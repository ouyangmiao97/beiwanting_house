<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_type extends MY_Controller {

	/**
	 * @copyright:	zh-tech 振華科技
	 * @author:		Tone
	 */
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('admin_model');
		$this->load->model('product_model');
		$this->load->model('product_type_model');
	}
	
	
	public function __destruct()
	{
		parent::__destruct();
	}

	
	public function index($pid = FALSE)
	{
		$this->admin_model->is_login();
		
		$this->front->pid = $pid;
		
		if (!$pid) {
			js_go_back('缺少參數ID');
			exit();
		}
		
		$this->front->page_title = array(
			'title' => '產品商品規格',
			'bread_crumb' => array('管理首頁' => '/control/' , '產品' => '#' , '產品商品規格' => '/control/product_type/index/' . $pid)
		);
		
		// 產品資訊
		$this->front->product = $this->product_model->get_product_one($pid);
		
		// 產品商品規格
		$this->front->data_list = $this->product_type_model->get_list_by_pid($pid);
		
		$this->load->view('control/product_type/index' , $this->front);
	}
	
	
	public function add($pid = FALSE)
	{
		$this->admin_model->is_login();
		
		$this->front->pid = $pid;
		
		if (!$pid) {
			js_go_back('缺少參數ID');
			exit();
		}
		
		$this->front->page_title = array(
			'title' => '產品商品規格',
			'bread_crumb' => array('管理首頁' => '/control/' , '產品' => '#' , '產品商品規格' => '/control/product_type/index/' . $pid , '新增產品商品規格' => '/control/product_type/add/' . $pid)
		);
		
		// 產品資訊
		$this->front->product = $this->product_model->get_product_one($pid);
		
		$this->load->view('control/product_type/add' , $this->front);
	}

	public function add_post($pid = FALSE)
	{
		$this->admin_model->is_login();
		
		$data = $this->input->post(NULL , TRUE);
		
		$response = $this->product_type_model->add($data);
		
		if ($response)
		{
			// 連帶處理product價格顯示
			$response2 = $this->product_type_model->price_fix($pid);
			
			if (!$response2)
			{
				js_go_msg('/control/product_type/index/' . $pid , '商品規格修改成功，' . $this->product_type_model->error_msg);
				exit();
			}
			
			js_go_msg('/control/product_type/index/' . $pid , '處理完成');
			exit();
		}
		else
		{
			js_go_back('處理失敗：' . $this->product_type_model->error_msg);
			exit();
		}
	}
	
	public function edit($pid = FALSE , $ptid = FALSE)
	{
		$this->admin_model->is_login();
		
		$this->front->pid = $pid;
		
		if (!$pid || !$ptid) {
			js_go_back('缺少參數ID');
			exit();
		}
		
		$this->front->data_row = $this->product_type_model->get_one($ptid);
		
		$this->front->page_title = array(
			'title' => '產品商品規格',
			'bread_crumb' => array('管理首頁' => '/control/' , '產品' => '#' , '產品商品規格' => '/control/product_type/index/' . $pid , '修改產品商品規格' => '/control/product_type/edit/' . $pid . '/' . $ptid)
		);
		
		// 產品資訊
		$this->front->product = $this->product_model->get_product_one($pid);
		
		$this->load->view('control/product_type/edit' , $this->front);
	}
	
	public function edit_post($pid = FALSE)
	{
		$this->admin_model->is_login();
		
		$data = $this->input->post(NULL , TRUE);
		
		$response = $this->product_type_model->edit($data);
		
		if ($response)
		{
			// 連帶處理product價格顯示
			$response2 = $this->product_type_model->price_fix($pid);
			
			if (!$response2)
			{
				js_go_msg('/control/product_type/index/' . $pid , '商品規格修改成功，' . $this->product_type_model->error_msg);
				exit();
			}
			
			js_go_msg('/control/product_type/index/' . $pid , '處理完成');
			exit();
		}
		else
		{
			js_go_back('處理失敗：' . $this->product_type_model->error_msg);
			exit();
		}
	}
	
	public function del($pid = FALSE)
	{
		$this->admin_model->is_login_ajax();
		
		$this->front->pid = $pid;
		
		$id = $this->input->post('id' , TRUE);
		
		$response = $this->product_type_model->del($id);
		
		if ($response)
		{
			echo json_encode(array('status' => 'T' , 'msg' => '處理完成'));
			exit();
		}
		else
		{
			echo json_encode(array('status' => 'F' , 'msg' => '處理失敗：' . $this->product_type_model->error_msg));
			exit();
		}
	}
	
	
	/** 
	 * 快速切換狀態
	 *
	 */
	public function change_active()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		$active = $this->input->post('checkeds' , TRUE);
		
		$result = $this->product_type_model->change_active($id , $active);
		
		if ($result)
		{
			echo json_encode(array('status'=>'T'));
			exit();
		}
		
		echo json_encode(array('status'=>'F'));
		exit();
	}
}