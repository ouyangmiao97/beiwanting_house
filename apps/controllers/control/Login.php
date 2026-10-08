<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
	
	/**
	 * 建構式
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('admin_model');
		$this->load->model('captcha_model');
	}
	
	
	public function __destruct()
	{
		parent::__destruct();
	}

	
	public function index()
	{
		$this->admin_model->logout(TRUE);
		
		$this->load->view('/control/login/index' , $this->front);
	}
	
	
	public function login_post()
	{				
		$login = $this->input->post('zh_tech_login' , TRUE);
		$passwd = $this->input->post('zh_tech_passwd' , TRUE);
		$captcha_code = $this->input->post('captcha_code' , TRUE);
		$captcha_file = $this->input->post('captcha_file' , TRUE);
		
		$this->captcha_model->set_data(config_item('captcha_setting'));
		
		if ($this->captcha_model->check($captcha_code , $captcha_file))
		{
			$this->admin_model->login($login , $passwd);
			exit();
		}
		else
		{
			js_go_back('驗證碼錯誤');
			exit();
		}
	}
	
	
	public function out()
	{
		$this->admin_model->logout();
	}
}
//end of file Login.php