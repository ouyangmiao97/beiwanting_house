<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class rule_sub extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('admin_model');
		$this->load->model('rule_sub_model');
		$this->load->model('rule_main_model');
	}
	
	
	public function __destruct()
	{
		parent::__destruct();
	}

	
	/**
	 * 文章列表
	 *
	 */
	public function index()
	{
		$this->admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => '商品篩選子項目',
			'bread_crumb' => array('管理首頁' => '/control/' , '商品篩選子項目' => '#' )
		);
		
		$this->front->rule_main_list = $this->rule_main_model->get_list();
		
		$tmp_list = array();
		
		foreach($this->front->rule_main_list as $key => $row)
		{
			$tmp_list[$row->id] = $row;
		}
		
		$this->front->rule_main_list = $tmp_list;
		
		unset($tmp_list);
		
		$this->front->data_list = $this->rule_sub_model->get_list();
		
		$this->load->view('control/rule_sub/index' , $this->front);
	}
	
	
	public function get()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$result = $this->rule_sub_model->get_one($id);
		
		echo json_encode(array('status' => 'T' , 'msg' => '' , 'datas' => $result));
		exit();
	}
	
	
	/**
	 * 新增文章
	 *
	 */
	public function add()
	{
		$this->admin_model->is_login_ajax();
		
		$data = $this->input->post(null , FALSE);
		
		$result = $this->rule_sub_model->add($data);
		
		if ($result)
		{			
			echo json_encode(array('status' => 'T' , 'msg' => '操作成功'));
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'msg' => 'unknow error!!'));
		exit();
	}
	
	
	/**
	 * 修改文章
	 *
	 */
	public function edit()
	{
		$this->admin_model->is_login_ajax();
		
		$data = $this->input->post(null , FALSE);
		
		$result = $this->rule_sub_model->edit($data);
		
		if ($result)
		{
			echo json_encode(array('status' => 'T' , 'msg' => '操作成功'));
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'msg' => 'unknow error!!'));
		exit();
	}
	
	
	/**
	 * 刪除文章
	 *
	 */
	public function del()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$result = $this->rule_sub_model->del($id);
		
		if ($result)
		{
			echo json_encode(array('status' => 'T' , 'msg' => '操作成功'));
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'msg' => 'unknow error!!'));
		exit();
	}
	
	public function change_sort_key()
	{
		$this->admin_model->is_login_ajax();
		
		$id1 = $this->input->post('id1' , TRUE);
		$id2 = $this->input->post('id2' , TRUE);
		
		$response = $this->rule_sub_model->change_sort_key($id1 , $id2);
		
		if ($response)
		{
			echo json_encode(array('status' => 'T' , 'msg' => ''));
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'msg' => '交換排序失敗！'));
		exit();
	}
	
}