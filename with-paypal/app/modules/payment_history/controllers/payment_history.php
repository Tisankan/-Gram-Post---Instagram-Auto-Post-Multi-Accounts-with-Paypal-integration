<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class payment_history extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		permission_view(true);
	}

	public function index(){
		$data = array(
			"result" => $this->model->getPaymentHistory()
		);
		$this->template->title(l('Payment history'));
		$this->template->build('index', $data);
	}

}