<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_features extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();	
		
		$this->load->model('admin_model');
		$this->load->model('product_model');
		$this->load->model('product_features_model');
		
		$this->front->zh_path = 'product_features';
		$this->front->zh_name = 'Product Features';
	}
	
	
	public function __destruct()
	{
		parent::__destruct();
	}
	
	
	/**
	 * 列表頁
	 *
	 */
	public function index($top_id = 0)
	{
		$this->admin_model->is_login();
		
		$top_row = $this->product_model->get_product_one($top_id);
		
		if ($top_row == FALSE)
		{
			js_go_back('請選擇商品');
			exit();
		}
		
		$this->front->zh_name = $this->front->zh_name . ' - ' . $top_row->title;
		
		$this->front->page_title = array(
			'title' => "{$this->front->zh_name}",
			'bread_crumb' => array('管理首頁' => '/control/' , "{$this->front->zh_name}" => "/control/{$this->front->zh_path}/index")
		);
		
		$this->front->top_id = $top_id;
		$this->front->data_list = $this->product_features_model->search_all(['top_id' => $top_id]);
		
		foreach($this->front->data_list as $key => $row)
		{
			$this->front->data_list[$key]->img_file = $this->upload_model->get_cache($row->img_id);
		}
		
		$this->load->view("control/{$this->front->zh_path}/index" , $this->front);
	}
	
	
	/**
	 * 新增
	 *
	 */
	public function add_post()
	{
		$this->admin_model->is_login_ajax();
		
		$data = $this->input->post(NULL , TRUE);
		
		// 圖片上傳
		$data['img_id'] = $this->product_features_model->img_process('img_file' , $data['img_alt']);
		unset($data['img_alt']);
		
		// 圖片上傳失敗
		if ($data['img_id'] == FALSE)
		{
			echo json_encode(['status' => 'F' , 'msg' => '圖片上傳失敗']);
			exit();
		}
		
		if ($this->product_features_model->add($data))
		{
			echo json_encode(['status' => 'T' , 'msg' => '處理完成']);
			exit();
		}
		
		echo json_encode(['status' => 'F' , 'msg' => '資料寫入失敗']);
		exit();
	}
	
	
	/**
	 * 修改
	 *
	 */
	public function edit_post()
	{
		$this->admin_model->is_login_ajax();
		
		$data = $this->input->post(NULL , TRUE);
		
		$id = $data['id'];
		
		if ($id == FALSE)
		{
			echo json_encode(['status' => 'F' , 'msg' => '無效ID']);
			exit();
		}
		
		$old = $this->product_features_model->get_one($id);
		
		if ($old == FALSE)
		{
			echo json_encode(['status' => 'F' , 'msg' => '無法取得舊資料']);
			exit();
		}
		
		// 圖片上傳
		$data['img_id'] = $this->product_features_model->img_process('img_file' , $data['img_alt']);
		
		if ($data['img_id'] == FALSE)
		{
			// 上傳圖片失敗或者未上傳
			$data['img_id'] = $old->img_id;
			
			// 更新ALT
			$this->upload_model->edit_uploads_alt($old->img_id , $data['img_alt']);
		}
		else
		{
			// 上傳成功 移除舊圖片
			$this->upload_model->del_uploads($old->img_id);
		}
		
		unset($data['img_alt']);
		unset($data['removeimg']);
		
		if ($this->product_features_model->edit($data))
		{
			echo json_encode(['status' => 'T' , 'msg' => '處理完成']);
			exit();
		}
		
		echo json_encode(['status' => 'F' , 'msg' => '資料寫入失敗']);
		exit();
	}
	
	
	/**
	 * 刪除
	 *
	 */
	public function del_post()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		if ($id == FALSE)
		{
			echo json_encode(['status' => 'F' , 'msg' => '無效ID']);
			exit();
		}
		
		$old = $this->product_features_model->get_one($id);
		
		if ($old == FALSE)
		{
			echo json_encode(['status' => 'F' , 'msg' => '無法取得舊資料']);
			exit();
		}
		
		if ($this->product_features_model->del($id))
		{
			// 刪除圖片
			$this->upload_model->del_uploads($old->img_id);
			
			echo json_encode(['status' => 'T' , 'msg' => '處理完成']);
			exit();
		}
		else
		{
			echo json_encode(['status' => 'F' , 'msg' => '資料寫入失敗']);
			exit();
		}
	}
	
	
	/**
	 * 取得
	 *
	 */
	public function get_post()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$data = $this->product_features_model->get_one($id);
		$data->img_file = $this->upload_model->get_cache($data->img_id);
		
		if ($data != FALSE)
		{
			echo json_encode(['status' => 'T' , 'msg' => '' , 'datarow' => $data]);
			exit();
		}
		
		echo json_encode(['status' => 'F' , 'msg' => '資料取得失敗' , 'data' => []]);
		exit();
	}
	
	
	/**
	 * 改變狀態
	 *
	 */
	public function change_post()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$checkeds = $this->input->post('checkeds' , TRUE);
		
		$data = ['id' => $id , 'active' => $checkeds];
		
		if ($this->product_features_model->edit($data))
		{
			echo json_encode(['status' => 'T' , 'msg' => '操作完成']);
			exit();
		}
		else
		{
			echo json_encode(['status' => 'F' , 'msg' => '資料寫入失敗']);
			exit();
		}
	}
}