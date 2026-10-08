<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends MY_Controller {

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
		
		$this->load->model('page_model');
	}
	
	
	public function __destruct()
	{
		parent::__destruct();
	}

	
	public function index()
	{
		$this->admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => '獨立頁面',
			'bread_crumb' => array('管理首頁' => '/control/' , '獨立頁面' => '/control/page/index')
		);
		
		$this->front->data_list = $this->page_model->get_page_list();
		
		$this->load->view('control/page/index' , $this->front);
	}
	
	
	public function edit_page_html($page = FALSE)
	{
		if (!$page)
		{
			js_go_back('page is not found');
			exit();
		}
		
		$this->admin_model->is_login();
		
		$html = $this->page_model->get_html($page);
		
		if (!$html)
		{
			$this->page_model->write_cache($page , '');
			
			$html = $this->page_model->get_html();
		}
		
		$this->front->page_id = $page;
		
		$this->front->page_html = $html;
		
		unset($html);
		
		$this->load->view('/control/page/edit_page_html' , $this->front);
	}
	
	
	public function edit_page_html_post()
	{
		$this->admin_model->is_login_ajax();
		
		$page = $this->input->post('page_id' , TRUE);
		
		$html = $this->input->post('html');
		
		$result = $this->page_model->write_cache($page , $html);
		
		if ($result)
		{
			echo json_encode(array('status' => 'T' , 'msg' => '儲存成功'));
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'msg' => '儲存失敗'));
		exit();
	}
	
	
	public function add_page()
	{
		$this->admin_model->is_login_ajax();
		
		$title = $this->input->post('title' , TRUE);
		
		$description = $this->input->post('description' , TRUE);
		
		$keywords = $this->input->post('keywords' , TRUE);
		
		$result = $this->page_model->add_page($title , $description , $keywords);
		
		echo json_encode($result);
	}
	
	
	public function edit_page()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$title = $this->input->post('title' , TRUE);
		
		$description = $this->input->post('description' , TRUE);
		
		$keywords = $this->input->post('keywords' , TRUE);
		
		$result = $this->page_model->edit_page($id , $title , $description , $keywords);
		
		echo json_encode($result);
	}
	
	
	public function del_page()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$result = $this->page_model->del_page($id);
		
		echo json_encode($result);
	}
	
}
//end of file Page.php