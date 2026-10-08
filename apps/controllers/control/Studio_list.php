<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Studio_list extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();	
		
		$this->load->model('admin_model');
		$this->load->model('studio_model');
		$this->load->model('studio_list_model');
		
		$this->front->zh_path = 'studio_list';
		$this->front->zh_name = 'STUDIO內容';
	}
	
	
	public function __destruct()
	{
		parent::__destruct();
	}
	
	
	/**
	 * 列表頁
	 *
	 */
	public function index($event_id = 0)
	{
		$this->admin_model->is_login();
		
		$event_row = $this->studio_model->get_one($event_id);
		
		if ($event_row == FALSE)
		{
			js_go_back('請選擇STUDIO');
			exit();
		}
		
		$this->front->zh_name = 'STUDIO - ' . $event_row->title;
		
		$this->front->page_title = array(
			'title' => "{$this->front->zh_name}管理",
			'bread_crumb' => array('管理首頁' => '/control/' , "STUDIO管理" => "/control/studio/" , "{$this->front->zh_name}管理" => "/control/{$this->front->zh_path}/{$event_id}")
		);
		
		$this->front->event_id = $event_id;
		$this->front->data_list = $this->studio_list_model->search_all(['event_id' => $event_id]);
		
		// foreach($this->front->data_list as $key => $row)
		// {
			// $this->front->data_list[$key]->img_file = $this->upload_model->get_cache($row->img_id);
		// }
		
		$this->load->view("control/{$this->front->zh_path}/index" , $this->front);
	}
	
	
	/**
	 * 新增
	 *
	 */
	public function add_post()
	{
		$this->admin_model->is_login_ajax();
		
		$data = $this->input->post(NULL , FALSE);
		$data['youtube'] = $this->input->post("youtube" , FALSE);
		
		/*
		// 圖片上傳
		$data['img_id'] = $this->studio_list_model->img_process('img_file' , $data['img_alt']);
		unset($data['img_alt']);
		
		// 圖片上傳失敗
		if ($data['img_id'] == FALSE)
		{
			echo json_encode(['status' => 'F' , 'msg' => '圖片上傳失敗']);
			exit();
		}
		*/
		
		if ($this->studio_list_model->add($data))
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
		
		$data = $this->input->post(NULL , FALSE);
		$data['youtube'] = $this->input->post("youtube" , FALSE);
		
		$id = $data['id'];
		
		if ($id == FALSE)
		{
			echo json_encode(['status' => 'F' , 'msg' => '無效ID']);
			exit();
		}
		
		$old = $this->studio_list_model->get_one($id);
		
		if ($old == FALSE)
		{
			echo json_encode(['status' => 'F' , 'msg' => '無法取得舊資料']);
			exit();
		}
		
		/*
		// 圖片上傳
		$data['img_id'] = $this->studio_list_model->img_process('img_file' , $data['img_alt']);
		
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
		*/
		unset($data['removeimg']);
		
		
		if ($this->studio_list_model->edit($data))
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
		/*
		$old = $this->studio_list_model->get_one($id);
		
		if ($old == FALSE)
		{
			echo json_encode(['status' => 'F' , 'msg' => '無法取得舊資料']);
			exit();
		}
		
		if ($this->studio_list_model->del($id))
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
		*/
		
		if ($this->studio_list_model->del($id))
		{			
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
		
		$data = $this->studio_list_model->get_one($id);
		// $data->img_file = $this->upload_model->get_cache($data->img_id);
		
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
		
		if ($this->studio_list_model->edit($data))
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