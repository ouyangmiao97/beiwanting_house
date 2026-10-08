<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

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
		
		$this->front->page_title = array(
			'title' => '管理首頁',
			'bread_crumb' => array('管理首頁' => '/control/')
		);
		
		
		if (!isset($this->admin_model)) $this->load->model('admin_model');
		if (!isset($this->meta_model)) $this->load->model('meta_model');
		if (!isset($this->report_model)) $this->load->model('report_model');
		
		$this->admin_model->is_login();
	}
	
	
	public function __destruct()
	{
		parent::__destruct();
	}

	
	public function index()
	{
		// 檢查登入
		$this->admin_model->is_login();
		
		//產生報表資料
		$this->front->week_list = $this->report_model->get_week_list();
		$this->front->pc_r = $this->report_model->get_week_report(1 , 1);
		$this->front->pc_n = $this->report_model->get_week_report(1 , 0);
		$this->front->mobile_r = $this->report_model->get_week_report(2 , 1);
		$this->front->mobile_n = $this->report_model->get_week_report(2 , 0);
		
		// 產生容器
		$this->front->total = array();
		
		// 加總瀏覽量
		foreach($this->front->week_list as $key => $val)
		{
			$tmp = $this->front->pc_r[$key] + $this->front->pc_n[$key] + $this->front->mobile_r[$key] + $this->front->mobile_n[$key];
			$this->front->total[] = (string) $tmp;
		}
		
		// 產生報表資料
		$this->front->report1 = $this->report_model->format_report_data_list($this->report_model->get_report_data_list(1,1));
		$this->front->report2 = $this->report_model->format_report_data_list($this->report_model->get_report_data_list(1,0));
		$this->front->report3 = $this->report_model->format_report_data_list($this->report_model->get_report_data_list(2,1));
		$this->front->report4 = $this->report_model->format_report_data_list($this->report_model->get_report_data_list(2,0));
		
		// 載入頁面
		$this->load->view('/control/home/index' , $this->front);
	}
	
	
	public function meta()
	{
		$this->admin_model->is_login();
		
		$this->front->web_meta = $this->meta_model->get_meta('index');
		
		$this->load->view('/control/home/meta' , $this->front);
	}
	
	
	public function edit_meta()
	{
		$this->admin_model->is_login();
		
		$meta = array();
		
		$meta['web_title'] = $this->input->post('web_title' , TRUE);
		$meta['web_title_end'] = $this->input->post('web_title_end' , TRUE);
		$meta['web_author'] = $this->input->post('web_author' , TRUE);
		$meta['web_description'] = $this->input->post('web_description' , TRUE);
		$meta['web_keywords'] = $this->input->post('web_keywords' , TRUE);
		$meta['web_footer'] = $this->input->post('web_footer' , TRUE);
		
		$result = $this->meta_model->set_meta($meta , 'index');
		
		if ($result)
		{
			js_go_msg('/control/home/meta' , '修改完成');
			exit();
		}
		
		js_go_back('修改失敗');
		exit();
	}
	
}
//end of file Home.php