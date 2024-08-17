<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class dashboard extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function index(){
		$result = $this->model->fetch("*", INSTAGRAM_SCHEDULES, getDatabyUser(0), "id", "desc", 0, 10000);
		$accounts = $this->model->fetch("*", INSTAGRAM_ACCOUNTS, getDatabyUser(0));
		
		//PROCESS GROUPS
		$group_count = array(
			"profile" => count($accounts),
		);


		//PROCESS SCHEDULE
		$minday = "";
		$maxday = "";

		$total = array(
			"total"        => 0,
			"queue"        => 0,
			"success"      => 0,
			"failure"      => 0,
			"processing"   => 0,
			"repeat"       => 0,
		);

		//POST
		$post = array(
			"total"        => 0,
			"queue"        => 0,
			"success"      => 0,
			"failure"      => 0,
			"processing"   => 0,
			"repeat"       => 0,
		);
		$post_day  = array();

		if(!empty($post)){
			foreach ($result as $key => $row) {
				switch ($row->category) {
					case 'post':
						$post['total']++;
						$total['total']++;
						switch ($row->status) {
							case 1:
								$post['processing']++;
								$total['processing']++;
								break;
							case 2:
								$post['queue']++;
								$total['queue']++;
								break;
							case 3:
								$post['success']++;
								$total['success']++;

								//Process day
								if(compare_day($minday, $row->created)){
									$minday = date("Y-m-d", strtotime($row->created));
								}

								if(compare_day($maxday, $row->created, "max")){
									$maxday = date("Y-m-d", strtotime($row->created));
								}

								//Process chart day
								$date = date("Y-m-d", strtotime($row->created));
								if(!isset($post_day[$date])){
									$post_day[$date] = 0;
								}
								$post_day[$date] += 1;
								break;
							case 4:
								$post['failure']++;
								$total['failure']++;
								break;
							case 5:
								$post['repeat']++;
								$total['repeat']++;
								break;
						}
						break;
				}
			}
		}

		//Pie Chart
		$post_pie_chart    = "['Success',".$post['success']."],['Failure',".$post['failure']."],['Repeat',".$post['repeat']."],['Processing',".$post['processing']."]";

		//Chart by days
		$post_day_full = array();

		$begin = new DateTime($minday);
		$end = new DateTime($maxday);
		$end = $end->modify( '+1 day' ); 
		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);
		foreach ($period as $dt){
			$day = $dt->format("Y-m-d");
			if(isset($post_day[$day])){
				$post_day_full[$day] = $post_day[$day];
			}else{
				$post_day_full[$day] = 0;
			}
		}

		//POST
		$post_by_day = "";
		if(!empty($post_day_full)){
			foreach ($post_day_full as $key => $value) {
				$year  = date("Y", strtotime($key));
	            $month = date("n", strtotime($key)) - 1;
	            $day   = date("j", strtotime($key));
				$post_by_day.="[Date.UTC(".$year.",".$month.",".$day."),".$value."],";
			}
		}
		$post_by_day = substr($post_by_day, 0, -1);

		$data = array(
			'group'             => (object)$group_count,
			'total'             => (object)$total,
			'post'              => (object)$post,
			'post_by_day'       => $post_by_day,
			'post_pie_chart'    => $post_pie_chart,
		);

		$this->template->title('Dashboard');
		$this->template->build('index', $data);
	}
	
}