<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Support extends MY_Controller {

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
		
		$this->load->model('zh_tech_admin_model');
	}
	
	
	public function __destruct()
	{
		parent::__destruct();
	}

	
	/**
	 * 系統說明
	 *
	 */
	public function index()
	{
		$this->zh_tech_admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => '系統說明',
			'bread_crumb' => array('管理首頁' => '/control/' , '支援' => '#' , '系統說明' => '/control/support/index')
		);
		
		$this->load->view('control/support/index' , $this->front);
	}
	
	
	/**
	 * 小工具 - 搜尋網址產生器
	 *
	 */
	public function url()
	{
		$this->zh_tech_admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => '搜尋網址產生器',
			'bread_crumb' => array('管理首頁' => '/control/' , '支援' => '#' , '搜尋網址產生器' => '/control/support/url')
		);
		
		$this->load->view('control/support/url' , $this->front);
	}
	
}
//end of file Website.php