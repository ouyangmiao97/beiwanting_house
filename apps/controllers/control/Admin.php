<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

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
	}
	
	
	public function __destruct()
	{
		parent::__destruct();
	}

	
	public function index()
	{
		$this->admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => '帳號管理',
			'bread_crumb' => array('管理首頁' => '/control/' , '帳號管理' => '/control/admin/')
		);
		
		$this->front->admin_list = $this->admin_model->get_admin_list();
		
		$this->load->view('control/admin/index' , $this->front);
	}
	
	
	public function loginlog()
	{
		$this->admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => '登入紀錄',
			'bread_crumb' => array('管理首頁' => '/control/' , '登入紀錄' => '/control/admin/loginlog')
		);
		
		$this->front->data_list = $this->admin_model->get_loginlog_list();
		
		$this->load->view('/control/admin/loginlog' , $this->front);
	}
	
	
	public function operlog()
	{
		$this->admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => '操作紀錄',
			'bread_crumb' => array('管理首頁' => '/control/' , '操作紀錄' => '/control/admin/operlog')
		);
		
		$this->front->data_list = $this->admin_model->get_operlog_list();
		
		$this->load->view('/control/admin/operlog' , $this->front);
	}
	
	
	public function get_admin()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$response = $this->admin_model->get_one_admin($id);
		
		if (count($response) > 0)
		{
			echo json_encode(array('status'=>'T' , 'msg'=>'' , 'admin' => $response));
			
			exit();
		}
		
		echo json_encode(array('status'=>'F' , 'msg' => '取得失敗'));
		
		exit();
	}
	
	
	public function add_admin()
	{
		$this->admin_model->is_login_ajax();
		
		$login = $this->input->post('login' , TRUE);
		
		$passwd = $this->input->post('passwd' , TRUE);
		
		$name = $this->input->post('name' , TRUE);
		
		$email = $this->input->post('email' , TRUE);
		
		$level = $this->input->post('level' , TRUE);
		
		$response = $this->admin_model->add_admin($login , $passwd , $name , $email , $level);
		
		echo json_encode($response);
		
		exit();
	}
	
	
	public function edit_admin()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$passwd = $this->input->post('passwd' , TRUE);
		
		$name = $this->input->post('name' , TRUE);
		
		$email = $this->input->post('email' , TRUE);
		
		$level = $this->input->post('level' , TRUE);
		
		$response = $this->admin_model->edit_admin($id , $passwd , $name , $email , $level);
		
		echo json_encode($response);
		
		exit();
	}
	
	
	public function del_admin()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$response = $this->admin_model->del_admin($id);
		
		echo json_encode($response);
		
		exit();
	}
}
//end of file Admin.php