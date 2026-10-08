<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marquee extends MY_Controller {

	/**
	 * 建構式
	 *
	 */
	public function __construct()
	{
		parent::__construct();

		//載入需用到的模組
		$this->load->model('admin_model');
		$this->load->model('marquee_model');
		$this->load->model('meta_model');

	}
	

	/**
	 * 解構式
	 *
	 */
	public function __destruct()
	{
		parent::__destruct();
	}
	
	
	/**
	 * Banner 列表
	 *
	 */
	public function index()
	{
		// 檢查登入
		$this->admin_model->is_login();

		$this->front->data_list = $this->marquee_model->get_all_list();

		// 設定資料
		$this->front->page_title = array(
			'title' => '跑馬燈',
			'bread_crumb' => array('管理首頁' => '/control/' , '跑馬燈管理' => '/control/marquee/index')
		);

		
		// 載入頁面
		$this->load->view('/control/marquee/index' , $this->front);
	}
	
	
	public function add()
	{
		// 檢查登入
		$this->admin_model->is_login();

		// 設定資料
		
		$this->front->page_title = array(
			'title' => '新增跑馬燈',
			'bread_crumb' => array('管理首頁' => '/control/' , '跑馬燈管理' => '/control/marquee/index' , '新增跑馬燈' => '/control/marquee/add')
		);
		
		$this->load->view('/control/marquee/add' , $this->front);
	}
	
	
	/**
	 * 新增
	 * ajax
	 */
	public function add_post()
	{
		// 檢查登入
		$this->admin_model->is_login();
		
		// 取得資料
		$data = $this->input->post(NULL , TRUE);
		
		if ($this->marquee_model->add($data))
		{
			js_go_msg('/control/marquee/index' , '處理完成');
			exit();
		}
		else
		{
			js_go_back('處理失敗，發生錯誤');
			exit();
		}
	}
	
	
	public function edit($id = FALSE)
	{
		// 檢查登入
		$this->admin_model->is_login();

		if (!$id)
		{
			js_go_back('無效的ID');
			exit();
		}

		$this->front->data_row = $this->marquee_model->get_one($id);

		if (!$this->front->data_row)
		{
			js_go_back('查無此筆資料');
			exit();
		}		
		
		// 設定資料
		$this->front->page_title = array(
			'title' => '修改跑馬燈',
			'bread_crumb' => array('管理首頁' => '/control/' , '跑馬燈管理' => '/control/marquee/index', '修改跑馬燈' => '/control/marquee/edit/'),
		);
		
		// 載入頁面
		$this->load->view('/control/marquee/edit' , $this->front);
	}
	
	
	/**
	 * 修改
	 * ajax
	 */
	public function edit_post()
	{
		// 檢查登入
		$this->admin_model->is_login();
		
		$data = $this->input->post(NULL , TRUE);
		
		if ($this->marquee_model->edit($data))
		{
			js_go_msg('/control/marquee/index' , '處理完成');
			exit();
		}
		else
		{
			js_go_back('處理失敗，發生錯誤');
			exit();
		}
	}
	
	
	/**
	 * 刪除
	 * ajax
	 */
	public function del()
	{
		$id = $this->input->post('id' , TRUE);
		
		if ($id)
		{
			if ($this->marquee_model->del($id))
			{
				echo json_encode(array('status' => 'T' , 'msg' => '處理完成'));
				exit();
			}
		}
		echo json_encode(array('status' => 'F' , 'msg' => '刪除失敗'));
		exit();
	}

}