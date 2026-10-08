<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends MY_Controller {

	/**
	 * @package:	振華後台模組
	 * @copyright:	zh-tech 振華科技
	 * @author:		Tone
	 * 
	 *
	 */
	
	
	public function __construct()
	{
		parent::__construct();	
		
		$this->load->model('admin_model');
		$this->load->model('item_model');
	}
	
	
	public function __destruct()
	{
		parent::__destruct();
	}
	
	
	/**
	 * 列表頁
	 *
	 */
	public function index()
	{
		$this->admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => '項目管理',
			'bread_crumb' => array('管理首頁' => '/control/' , '產品' => '#' , '項目管理' => '/control/item/')
		);
		
		$this->front->data_list = $this->item_model->get_item_list_all();
		
		$this->front->type_list = $this->item_model->get_type_list();
		
		$this->admin_model->is_login();
		
		$this->load->view('control/item/index' , $this->front);
	}
	
	
	/**
	 * 新增
	 *
	 */
	public function add_item()
	{
		$this->admin_model->is_login_ajax();
		
		$data = $this->input->post(NULL , TRUE);
		
		$result = $this->item_model->add($data);
		
		echo json_encode($result);
	}
	
	
	/**
	 * 修改
	 *
	 */
	public function edit_item()
	{
		$this->admin_model->is_login_ajax();
		
		$data = $this->input->post(NULL , TRUE);
		
		$result = $this->item_model->edit($data);
		
		echo json_encode($result);
	}
	
	
	/**
	 * 刪除
	 *
	 */
	public function del_item()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$result = $this->item_model->del($id);
		
		echo json_encode($result);
	}
	
	
	/**
	 * 取得
	 *
	 */
	public function get_item()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$result = $this->item_model->get_one_by_id($id);
		
		echo json_encode($result);
	}
	
	
	/**
	 * 改變狀態
	 *
	 */
	public function change_active()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$checkeds = $this->input->post('checkeds' , TRUE);
		
		$result = $this->item_model->chang_active($id , $checkeds);
		
		echo json_encode($result);
	}
}
//end of file Item.php