<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends MY_Controller {

	/**
	 * @package:	侏儸紀寶石
	 * @copyright:	zh-tech 振華科技
	 * @author:		Tone
	 * 
	 *
	 */
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('admin_model');
		$this->load->model('banner_model');
		
		$this->front->words_types = $this->banner_model->words_types;
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
			'title' => 'Banner管理',
			'bread_crumb' => array('管理首頁' => '/control/' , 'Banner管理' => '#' , 'Banner列表' => '/control/banner/index')
		);
		
		$this->front->data_list = $this->banner_model->get_list();
		
		$this->load->view('control/banner/index' , $this->front);
	}
	
	
	public function get()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$result = $this->banner_model->get_one($id);
		
		echo json_encode(array('status' => 'T' , 'msg' => '' , 'words' => $result));
	}
	
	
	/**
	 * 新增文章
	 *
	 */
	public function add()
	{
		$this->admin_model->is_login_ajax();
		
		$data = $this->input->post(null , TRUE);
		
		$result = $this->banner_model->insert($data);
		
		if (is_array($result))
		{
			echo json_encode($result);
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'msg' => 'unknow error!!'));
	}
	
	
	/**
	 * 修改文章
	 *
	 */
	public function edit()
	{
		$this->admin_model->is_login_ajax();
		
		$data = $this->input->post(null , TRUE);
		
		$result = $this->banner_model->update($data);
		
		if (is_array($result))
		{
			echo json_encode($result);
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'msg' => 'unknow error!!'));
	}
	
	
	/**
	 * 刪除文章
	 *
	 */
	public function del()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$result = $this->banner_model->delete($id);
		
		if (is_array($result))
		{
			echo json_encode($result);
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'msg' => 'unknow error!!'));
	}
	
	
	/**
	 * 改變文章狀態
	 *
	 */
	public function change_active()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$checked = (int) $this->input->post('checkeds' , TRUE);
		
		$result = $this->banner_model->change_active($id , $checked);
		
		if (is_array($result))
		{
			echo json_encode($result);
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'msg' => 'unknow error!!'));
	}
	
}
//end of file Words.php