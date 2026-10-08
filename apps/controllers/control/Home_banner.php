<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_banner extends MY_Controller {
	
	private $cache_file = 'meta/home_banner.json';
	
	private $data_default = [
		'mode' => 0,	// 0:圖片模式 1:mp4模式
		'image_sm' => '/images/mainimg.jpg',
		'image_md' => '/images/m_mainimg.jpg',
		'mp4' => '/uploads/main.mp4',
	];
	
	public function __construct()
	{
		parent::__construct();
		
		$this->front->page_title = array(
			'title' => '首頁影片設定',
			'bread_crumb' => array('管理首頁' => '/control/' , '首頁影片設定' => '/control/home_banner/index')
		);
		
		$this->load->model('admin_model');
	}
	
	
	public function __destruct()
	{
		parent::__destruct();
	}

	public function index()
	{
		$this->front->page_title = array(
			'title' => '首頁影片設定',
			'bread_crumb' => array('管理首頁' => '/control/' , '首頁影片設定' => '/control/home_banner/index')
		);
		
		$this->admin_model->is_login();
		
		$this->front->data_list = json_decode(get_cache($this->cache_file) , TRUE);
		
		if ($this->front->data_list == FALSE) $this->front->data_list = $this->data_default;
		
		$this->load->view('/control/home_banner/index' , $this->front);
	}
	
	public function edit()
	{
		// $data = $this->input->post(NULL , TRUE);
		// echo json_encode($data);exit();
		
		$this->load->model('file_model');
		
		$this->admin_model->is_login();
		
		if ($_FILES['uploadfile'] != FALSE)
		{
			if ($_FILES['uploadfile']['error'] == 0)
			{
				// 檢查檔案類型
				if ($_FILES['uploadfile']['type'] != 'video/mp4')
				{
					js_go_back('上傳的檔案格式不支援');
					exit();
				}
				
				// 搬移檔案到目標位置
				if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], './uploads/main.mp4') == FALSE)
				{
					js_go_back('檔案上傳失敗(搬移)');
					exit();
				}
			}
		}
		
		$data = $this->input->post(NULL , TRUE);
		
		$data->mp4 = '/uploads/main.mp4';
		
		set_cache($this->cache_file , json_encode($data));
		
		js_go_msg('/control/home_banner/index' , '修改完成');
		exit();
	}
}