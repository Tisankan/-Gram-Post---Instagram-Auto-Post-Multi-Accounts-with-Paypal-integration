<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class home extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function index(){
		if(session("uid")) redirect(url("post"));
		$data = array();
		$this->template->set_layout("home");
		$this->template->title(TITLE);
		$this->template->build('index', $data);
	}

	public function timezone(){
		$data = array();
		$this->template->set_layout("home");
		$this->template->title(TITLE);
		$this->template->build('timezone', $data);
	}
	
	public function logout(){
		delete_cookie('folderid');
		unset_session('uid');
		redirect(PATH);
	}

	public function facebook(){
		redirect(FACEBOOK_GET_LOGIN_URL());
	}

	public function google(){
		redirect(GOOGLE_GET_LOGIN_URL());
	}

	public function twitter(){
		redirect(TWITTER_GET_LOGIN_URL());
	}
}