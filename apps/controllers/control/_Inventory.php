<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends MY_Controller {

	/**
	 * @copyright:	zh-tech 振華科技
	 * @author:		Tone
	 */
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('inventory_model');
		$this->load->model('admin_model');
		$this->load->model('item_model');
		$this->load->model('product_model');
	}
	
	
	public function __destruct()
	{
		
	}
	
	
	public function index($pid = FALSE)
	{
		$pid = (int) $pid;
		
		$this->admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => '庫存列表',
			'bread_crumb' => array('管理首頁' => '/control/' , '產品' => '#' , '產品列表' => '/control/product/index' , '庫存列表' => '/control/inventory/index/' . $pid)
		);
		
		// $product = $this->product_model->get_product_one($pid);
		
		if ($pid)
		{
			$this->front->data_list = $this->inventory_model->get_inventory_list($pid);
		}
		else
		{
			$this->front->data_list = $this->inventory_model->get_inventory_all($pid);
		}
		
		foreach($this->front->data_list as $key => $row)
		{
			$product = $this->product_model->get_product_one($row->pid);
			
			$row->product_id = $product->product_id;
			$row->title = $product->title;
			
			$this->front->data_list[$key] = $row;
		}
		
		$this->front->pid = $pid;
		
		$this->load->view('/control/inventory/index' , $this->front);
	}
	
	
	public function get_inventory()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$response = $this->inventory_model->get_inventory_one($id);
		
		echo $response;
	}
	
	
	public function add_inventory()
	{
		$this->admin_model->is_login_ajax();
		
		$data = $this->input->post(NULL , TRUE);
		
		$response = $this->inventory_model->add_inventory($data);
		
		echo $response;
	}
	
	
	public function edit_inventory()
	{
		$this->admin_model->is_login_ajax();
		
		$data = $this->input->post(NULL , TRUE);
		
		$response = $this->inventory_model->edit_inventory($data);
		
		echo $response;
	}
	
	
	public function del_inventory()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$result = $this->inventory_model->del_inventory($id);
		
		if ($result)
		{
			echo json_encode(array('status' => 'T' , 'msg' => '刪除成功'));
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'msg' => '刪除失敗'));
		exit();
	}
}
//end of file Inventory.php