<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class payments extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function index(){
		$data = array(
			"payment" => $this->model->get("*", PAYMENT),
			"package" => $this->model->fetch("*", PACKAGE, "status = 1 AND type = 2", "orders", "ASC")
		);
		$this->template->set_layout("home");
		$this->template->title(l('Pricing'));
		$this->template->build('index', $data);
	}
	
	public function do_payment(){
		$payment = $this->model->get("*", PAYMENT);
		$payment = $this->model->get("*", PAYMENT);
		$package = $this->model->get("*", PACKAGE, "id = '".(int)get("package")."'");
		if(empty($payment) || empty($package) || !session("uid")) redirect(PATH);

		$config['business'] 			= $payment->paypal_email;
		$config['cpp_header_image'] 	= ''; //Image header url [750 pixels wide by 90 pixels high]
		$config['return'] 				= cn().'notify_payment';
		$config['cancel_return'] 		= cn().'cancel_payment';
		$config['notify_url'] 			= cn().'process_payment'; //IPN Post
		$config['production'] 			= ($payment->sandbox == 1)?FALSE:TRUE; //Its false by default and will use sandbox
		$config["invoice"]				= random_string('numeric',8); //The invoice id
		$config["currency_code"]     	= $payment->currency; //The invoice id
		
		$this->load->library('paypal',$config);
		$this->paypal->add($package->name, $package->price, 1, $package->id); //Third item with code
		$this->paypal->pay(); //Proccess the payment
	}

	public function process_payment(){
		
	}

	public function notify_payment(){
		$result = $this->input->post();
		if(!empty($result)){
			$data = array(
				"uid"             => session("uid"),
				"invoice"         => (int)$result['invoice'],
				"first_name"      => $result['first_name'],
				"last_name"       => $result['last_name'],
				"business"        => $result['business'],
				"payer_email"     => $result['payer_email'],
				"item_name"       => $result['item_name'],
				"item_number"     => (int)$result['item_number'],
				"address_street"  => isset($result['address_street'])?$result['address_street']:"",
				"address_city"    => isset($result['address_city'])?$result['address_city']:"",
				"address_country" => isset($result['address_country'])?$result['address_country']:"",
				"mc_gross"        => $result['mc_gross'],
				"mc_currency"     => $result['mc_currency'],
				"payment_date"    => date("Y-m-d H:i:s", strtotime($result['payment_date'])),
				"payment_status"  => $result['payment_status'],
				"full_data"       => json_encode($result),
				"created"         => NOW
			);
			$this->db->insert(PAYMENT_HISTORY, $data);
			if($result['payment_status'] == "Completed"){
				$user = $this->model->get("*", USER_MANAGEMENT, "id = '".session("uid")."'");
				if(!empty($user)){
					$package_new = $this->model->get("*", PACKAGE, "id = '".$result['item_number']."'");
					$package_old = $this->model->get("*", PACKAGE, "id = '".$user->package_id."'");
					$package_id = $package_new->id;
					if(!empty($package_old)){
						if(strtotime(NOW) < strtotime($user->expiration_date)){
							$date_now = date("Y-m-d", strtotime(NOW));
							$date_expiration = date("Y-m-d", strtotime($user->expiration_date));
							$diff = abs(strtotime($date_expiration) - strtotime($date_now));
							$days = floor($diff/86400);

							$day_added = round(($package_old->price/$package_new->price)*$days);
							$total_day = $package_new->day + $day_added;
							$expiration_date = date('Y-m-d', strtotime("+".$total_day." days"));
						}else{
							$expiration_date = date('Y-m-d', strtotime("+".$package_new->day." days"));
						}
					}else{
						$expiration_date = date('Y-m-d', strtotime("+".$package_new->day." days"));
					}

					$data = array(
						"package_id"      => $package_id,
						"expiration_date" => $expiration_date
					);

					$this->db->update(USER_MANAGEMENT, $data, "id = '".session("uid")."'");
				}
			}
		}
		redirect(PATH);
	}

	public function cancel_payment(){
		redirect(url('payments'));
	}

}