<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class settings extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		permission_view(true);
	}

	public function index(){

		$id   = (int)get("id");
		$list_lang = scandir(APPPATH."../lang/");
		unset($list_lang[0]);
		unset($list_lang[1]);
		$data_lang = array();
		foreach ($list_lang as $lang) {
			$arr_lang = explode(".", $lang);
			if(count($arr_lang) == 2 && strlen($arr_lang[0]) == 2 && $arr_lang[1] == "xml"){
				$data_lang[] = $arr_lang[0];
			}
		}

		$data = array(
			"result" => $this->model->get("*", SETTINGS),
			"lang"   => $data_lang,
		);

		if(post('website_title')){
			$data = array(
				"website_title"            => post('website_title'),
				"website_description"      => post('website_description'),
				"website_keyword"          => post('website_keyword'),
				"theme_color"              => post('theme_color'),
				"timezone"                 => post('timezone'),
				"register"                 => (int)post('register'),
				"auto_active_user"         => (int)post('auto_active_user'),
				"upload_max_size"          => (int)post('upload_max_size'),
				"default_language"         => post('default_language'),
				"default_deplay"           => post('default_deplay'),
				"minimum_deplay"           => (int)post('minimum_deplay'),
				"default_deplay_post_now"  => (int)post('default_deplay_post_now'),
				"minimum_deplay_post_now"  => (int)post('minimum_deplay_post_now'),
				"purchase_code"            => post('purchase_code'),
				"facebook_id"              => post('facebook_id'),
				"facebook_secret"          => post('facebook_secret'),
				"google_id"                => post('google_id'),
				"google_secret"            => post('google_secret'),
				"twitter_id"               => post('twitter_id'),
				"twitter_secret"           => post('twitter_secret'),
				"facebook_page"            => post('facebook_page'),
				"twitter_page"             => post('twitter_page'),
				"pinterest_page"           => post('pinterest_page'),
				"instagram_page"           => post('instagram_page')
			);

			foreach ($_FILES as $key => $value) {
			    if (!empty($value['tmp_name']) && $value['size'] > 0) {
			    	$this->load->library('upload');
			    	if($key == "language"){
			    		$config['upload_path'] = "./lang/";
					    $config['allowed_types'] = 'xml';
					    $config['remove_spaces'] = TRUE;
				    	$this->upload->initialize($config); 
				    	if ($this->upload->do_upload($key)) {}
			    	}else{
			    		$path = "./assets/images/";
			    		$config['upload_path'] = $path;
					    $config['allowed_types'] = 'jpg|png';
					    $config['remove_spaces'] = TRUE;
				    	$this->upload->initialize($config); 
				    	if ($this->upload->do_upload($key)) {
			            	$data_file = $this->upload->data();
		    				$data["logo"] = str_replace("./", "", $path.$data_file["file_name"]);
			        	}
			    	}
			    }
			}

			$this->db->update(SETTINGS, $data);
		    redirect(PATH."settings");
		}

		$this->template->title(l('Settings'));
		$this->template->build('index', $data);
	}

	public function ajax_update(){
		$id = (int)post("id");

		if(post("website_title") == ""){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Website title is required')
			));
		}

		if(post("public_key") == ""){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Public key is required')
			));
		}

		if(post("secret_key") == ""){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Secret key is required')
			));
		}

		if(post("currency") == ""){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Currency is required')
			));
		}

		$data = array(
			"paypal_email" => post("paypal_email"),
			"public_key"   => post("public_key"),
			"secret_key"   => post("secret_key"),
			"currency"     => post("currency")
		);

		$this->db->update(SETTINGS, $data, array("id" => $id));

		ms(array(
			"st"    => "success",
			"label" => "bg-light-green",
			"txt"   => l('Update successfully')
		));
	}
}