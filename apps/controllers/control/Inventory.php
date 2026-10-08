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
		$this->load->model('product_type_model');
	}
	
	
	public function __destruct()
	{
		
	}
	
	
	public function index()
	{
		$this->admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => '庫存列表',
			'bread_crumb' => array('管理首頁' => '/control/' , '產品' => '#' , '產品列表' => '/control/product/index' , '庫存列表' => '/control/inventory/index/')
		);
		
		$this->front->data_list = $this->product_type_model->get_inventory_list();
		
		//將圖片資訊寫入到陣列中
		foreach($this->front->data_list as $key => $row)
		{
			$this->front->data_list[$key]->img_file = $this->upload_model->get_cache($row->img);
		}
		
		$this->load->view('/control/product_type/inventory' , $this->front);
	}
	
	
	// public function get_inventory()
	// {
		// $this->admin_model->is_login_ajax();
		
		// $id = $this->input->post('id' , TRUE);
		
		// $response = $this->product_type_model->get_one($id);
		// $response = $this->inventory_model->get_inventory_one($id);
		
		// echo $response;
	// }
	
	
	// public function add_inventory()
	// {
		// $this->admin_model->is_login_ajax();
		
		// $data = $this->input->post(NULL , TRUE);
		
		// $pid = $data['pid'];
		// $num = $data['num'];
		
		// $data = array('id'=>$pid , 'inventory'=>$num);
		
		// $response = $this->product_type_model->edit($data);
		
		// if ($response)
		// {
			// echo json_encode(array('status' => 'T' , 'msg' => '處理完成'));
			// exit();
		// }
		// else
		// {
			// echo json_encode(array('status' => 'F' , 'msg' => '處理失敗：' . $this->product_type_model->error_msg));
			// exit();
		// }
	// }
	
	
	// public function edit_inventory()
	// {
		// $this->admin_model->is_login_ajax();
		
		// $data = $this->input->post(NULL , TRUE);
		
		// $pid = $data['pid'];
		// $num = $data['num'];
		
		// $data = array('id'=>$pid , 'inventory'=>$num);
		
		// $response = $this->product_type_model->edit($data);
		
		// if ($response)
		// {
			// echo json_encode(array('status' => 'T' , 'msg' => '處理完成'));
			// exit();
		// }
		// else
		// {
			// echo json_encode(array('status' => 'F' , 'msg' => '處理失敗：' . $this->product_type_model->error_msg));
			// exit();
		// }
	// }
	
	
	// public function del_inventory()
	// {
		// $this->admin_model->is_login_ajax();
		
		// $id = $this->input->post('id' , TRUE);
		
		// $result = $this->inventory_model->del_inventory($id);
		
		// if ($result)
		// {
			// echo json_encode(array('status' => 'T' , 'msg' => '刪除成功'));
			// exit();
		// }
		
		// echo json_encode(array('status' => 'F' , 'msg' => '刪除失敗'));
		// exit();
	// }
}
//end of file Inventory.php