<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Words extends MY_Controller {

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
		$this->load->model('words_model');
		
		$this->front->words_types = $this->words_model->words_types;
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
			'title' => '文章管理',
			'bread_crumb' => array('管理首頁' => '/control/' , '文章管理' => '#' , '文章列表' => '/control/words/index')
		);
		
		$this->front->data_list = $this->words_model->get_list();
		
		$this->load->view('control/words/index' , $this->front);
	}
	
	
	public function get()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$result = $this->words_model->get_one($id);
		
		echo json_encode(array('status' => 'T' , 'msg' => '' , 'words' => $result));
	}
	
	
	/**
	 * 新增文章
	 *
	 */
	public function add()
	{
		$this->admin_model->is_login_ajax();
		
		$data = $this->input->post(null , FALSE);
		
		$result = $this->words_model->insert($data);
		
		if (is_array($result))
		{
			$this->create_news_2();
			
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
		
		$data = $this->input->post(null , FALSE);
		
		$result = $this->words_model->update($data);
		
		if (is_array($result))
		{
			$this->create_news_2();
			
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
		
		$result = $this->words_model->delete($id);
		
		if (is_array($result))
		{
			$this->create_news_2();
			
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
		
		$result = $this->words_model->change_active($id , $checked);
		
		if (is_array($result))
		{
			$this->create_news_2();
			
			echo json_encode($result);
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'msg' => 'unknow error!!'));
	}
	
	
	/**
	 * 建立兩個最新消息的快取
	 *
	 */
	public function create_news_2()
	{
		$new2 = $this->words_model->get_list_index(0);
		
		set_cache('news2.json' , json_encode($new2));
	}
	
}
//end of file Words.php