<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_footer extends MY_Controller {

	/**
	 * @copyright:	zh-tech 振華科技
	 * @author:		Tone
	 */
	
	private $menu_type = 'footer';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->front->page_title = array(
			'title' => '選單管理',
			'bread_crumb' => array('管理首頁' => '/control/' , '選單管理' => '/control/menu')
		);
		
		$this->load->model('admin_model');
		$this->load->model('menu_model');
		$this->load->config('menu');
	}
	
	
	public function __destruct()
	{
		parent::__destruct();
	}

	
	public function index()
	{
		$this->admin_model->is_login();
		
		$cache = $this->menu_model->get_cache_menu($this->menu_type);
		
		$this->front->menu_list = $cache;
		
		$this->load->view('/control/menu/index' , $this->front);
	}
	
	
	public function edit_menu()
	{
		$this->admin_model->is_login_ajax();
		
		$menu = $this->input->post('menu' , TRUE);
		
		$this->menu_model->set_cache_menu($menu , $this->menu_type);
		
		echo json_encode(array('status' => 'T' , 'msg' => '傳送成功'));
		
		exit();
	}
	
	
	
}
//end of file Menu.php