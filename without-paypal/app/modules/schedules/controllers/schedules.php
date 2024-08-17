<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class schedules extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function index(){
		$type = segment(2);
		if(!$type) redirect(PATH);

		$data = array();
		$this->template->title(l('Schedules'));
		$this->template->build('index', $data);
	}

	public function ajax_page(){
		$results = $this->model->get_cd_list();
        echo json_encode($results);
	}

	public function ajax_action_item(){
		$id = (int)post('id');
		$POST = $this->model->get('*', INSTAGRAM_SCHEDULES, "id = '{$id}'".getDatabyUser());
		if(!empty($POST)){
			switch (post("action")) {
				case 'delete':
					$this->db->delete(INSTAGRAM_SCHEDULES, "id = '{$id}'".getDatabyUser());
					break;
				
				case 'active':
					$this->db->update(INSTAGRAM_SCHEDULES, array("status" => 1), "id = '{$id}'".getDatabyUser());
					break;

				case 'disable':
					$this->db->update(INSTAGRAM_SCHEDULES, array("status" => 0), "id = '{$id}'".getDatabyUser());
					break;
			}
		}

		ms(array(
			'st' 	=> 'success',
			'txt' 	=> l('successfully')
		));
	}

	public function ajax_action_multiple(){
		$ids =$this->input->post('id');
		if(!empty($ids)){
			foreach ($ids as $id) {
				$POST = $this->model->get('*', INSTAGRAM_SCHEDULES, "id = '{$id}'".getDatabyUser());
				if(!empty($POST)){
					switch (post("action")) {
						case 'delete':
							$this->db->delete(INSTAGRAM_SCHEDULES, "id = '{$id}'");
							break;

						case 'active':
							$this->db->update(INSTAGRAM_SCHEDULES, array("status" => 1), "id = '{$id}'".getDatabyUser());
							break;

						case 'disable':
							$this->db->update(INSTAGRAM_SCHEDULES, array("status" => 0), "id = '{$id}'".getDatabyUser());
							break;
					}
				}
			}
		}

		if(post("action") == "delete_all"){
			$this->db->delete(INSTAGRAM_SCHEDULES, "category = '".post("category")."'".getDatabyUser());
		}

		ms(array(
			'st' 	=> 'success',
			'txt' 	=> l('Successfully')
		));
	}
}