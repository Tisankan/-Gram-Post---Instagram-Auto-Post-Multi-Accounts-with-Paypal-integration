<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user_management_model extends MY_Model {
	public function __construct(){
		parent::__construct();
	}

	public function getUserList(){
		$result = $this->model->fetch("*", USER_MANAGEMENT, "", "id", "DESC");
		return $result;
	}
}
