<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cost extends MY_Controller {

	/**
	 * @package:	聖德宮
	 * @copyright:	zh-tech 振華科技
	 * @author:		Tone
	 * 
	 *
	 */
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('admin_model');
		$this->load->model('cost_model');
		
		$this->load->config('admin_menu');
		
		$this->front->cost_item_type_list = $this->cost_model->cost_item_type_list;
		$this->front->cost_item_ary = $this->cost_model->get_cost_item_ary();
	}
	
	
	public function __destruct()
	{
		parent::__destruct();
	}

	
	public function index()
	{
		$this->today();
	}
	
	
	public function item()
	{
		$this->front->page_title = array(
			'title' => '財管項目',
			'bread_crumb' => array('管理首頁' => '/control/' , '財管系統' => '#' , '財管項目' => '/control/cost/item')
		);
		
		$this->front->data_list = $this->cost_model->get_cost_item_list();
		
		$this->load->view('control/cost/item' , $this->front);
	}
	
	
	public function get_item()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$result = $this->cost_model->get_cost_item_one($id);
		
		echo json_encode(array('status' => 'T' , 'msg' => '' , 'item' => $result));
	}
	
	
	public function add_item()
	{
		$this->admin_model->is_login_ajax();
		
		$data = $this->input->post(null , TRUE);
		
		$result = $this->cost_model->add_cost_item($data);
		
		echo json_encode($result);
	}
	
	
	public function edit_item()
	{
		$this->admin_model->is_login_ajax();
		
		$data = $this->input->post(null , TRUE);
		
		$result = $this->cost_model->edit_cost_item($data);
		
		echo json_encode($result);
	}
	
	
	public function del_item()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$result = $this->cost_model->del_cost_item($id);
		
		echo json_encode($result);
	}
	
	
	public function today()
	{
		$this->front->page_title = array(
			'title' => '今日帳務',
			'bread_crumb' => array('管理首頁' => '/control/' , '財管系統' => '#' , '今日帳務' => '/control/cost/today')
		);
		
		$this->front->data_list = $this->cost_model->get_cost_today();
		
		$this->front->total_out = $this->cost_model->get_total_cost(0);
		$this->front->total_in = $this->cost_model->get_total_cost(1);
		
		$this->load->view('control/cost/today' , $this->front);
	}
	
	
	public function get_cost()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$result = $this->cost_model->get_cost_one($id);
		
		echo json_encode(array('status' => 'T' , 'msg' => '' , 'cost' => $result));
	}
	
	
	public function add_cost()
	{
		$this->admin_model->is_login_ajax();
		
		$data = $this->input->post(null , TRUE);
		
		$result = $this->cost_model->add_cost($data);
		
		echo json_encode($result);
	}
	
	
	public function edit_cost()
	{
		$this->admin_model->is_login_ajax();
		
		$data = $this->input->post(null , TRUE);
		
		$result = $this->cost_model->edit_cost($data);
		
		echo json_encode($result);
	}
	
	
	public function del_cost()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$result = $this->cost_model->del_cost($id);
		
		echo json_encode($result);
	}
	
	
	public function income()
	{
		
	}
	
	
	public function outlay()
	{
		
	}
	
	
	public function commission()
	{
		$this->front->page_title = array(
			'title' => '委員列表',
			'bread_crumb' => array('管理首頁' => '/control/' , '財管系統' => '#' , '委員列表' => '/control/cost/today')
		);
		
		$this->front->data_list = $this->cost_model->get_commission_list();
		
		$this->load->view('control/cost/commission' , $this->front);
	}
	
	
	public function get_commission()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$result = $this->cost_model->get_commission_one($id);
		
		echo json_encode(array('status' => 'T' , 'msg' => '' , 'commission' => $result));
	}
	
	
	public function add_commission()
	{
		$this->admin_model->is_login_ajax();
		
		$data = $this->input->post(null , TRUE);
		
		$result = $this->cost_model->add_commission($data);
		
		echo json_encode($result);
	}
	
	
	public function edit_commission()
	{
		$this->admin_model->is_login_ajax();
		
		$data = $this->input->post(null , TRUE);
		
		$result = $this->cost_model->edit_commission($data);
		
		echo json_encode($result);
	}
	
	
	public function del_commission()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$result = $this->cost_model->del_commission($id);
		
		echo json_encode($result);
	}
	
	
	public function commission_cost()
	{
		
	}
	
	
	public function add_commission_cost()
	{
		$this->admin_model->is_login_ajax();
		
		$data = $this->input->post(null , TRUE);
		
		$result = $this->cost_model->add_commission_cost($data);
		
		echo json_encode($result);
	}
	
	
	public function edit_commission_cost()
	{
		$this->admin_model->is_login_ajax();
		
		$data = $this->input->post(null , TRUE);
		
		$result = $this->cost_model->edit_commission_cost($data);
		
		echo json_encode($result);
	}
	
	
	public function del_commission_cost()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$result = $this->cost_model->del_commission_cost($id);
		
		echo json_encode($result);
	}
	
	
	public function report()
	{
		$this->front->page_title = array(
			'title' => '報表',
			'bread_crumb' => array('管理首頁' => '/control/' , '財管系統' => '#' , '報表' => '/control/cost/search')
		);
		
		$data = $this->input->post(null , TRUE);
		
		//預設抓當月
		if (!isset($data['start_date']) || !isset($data['end_date']))
		{
			$data['start_date'] = date('Y-m-d' , time() - (86400 * 30));
			$data['end_date'] = date('Y-m-d');
		}
		
		$this->front->start_date = $data['start_date'];
		$this->front->end_date = $data['end_date'];
		
		$this->front->data_list = $this->cost_model->report_data($data);
		
		$this->load->view('control/cost/report' , $this->front);
	}
	
	
	public function search()
	{
		$this->front->page_title = array(
			'title' => '資料查詢',
			'bread_crumb' => array('管理首頁' => '/control/' , '財管系統' => '#' , '資料查詢' => '/control/cost/search')
		);
		
		$data = $this->input->post(null , TRUE);
		
		//預設抓當月
		if (!isset($data['start_date']) || !isset($data['end_date']))
		{
			$data['start_date'] = date('Y-m-d' , time() - (86400 * 30));
			$data['end_date'] = date('Y-m-d');
		}
		
		$this->front->start_date = $data['start_date'];
		$this->front->end_date = $data['end_date'];
		
		$this->front->total_out = $this->cost_model->get_total_cost(0);
		$this->front->total_in = $this->cost_model->get_total_cost(1);
		
		$this->front->data_list = $this->cost_model->get_cost_by_date($data['start_date'] , $data['end_date']);
		
		$this->load->view('control/cost/search' , $this->front);
	}
	
}
//end of file Home.php