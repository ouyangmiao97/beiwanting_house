<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	
	private $debug = TRUE;
	
	public $front = null;
	
	/**
	 * 建構式
	 *
	 */
	public function __construct()
	{		
		parent::__construct();
		
		//除錯
		$this->output->enable_profiler(FALSE);
		
		$this->front = new stdClass();
		
		$this->front->logo = '/images/LOGO_black.png';
		
		$this->_initialize();
		$this->_load_config();
		$this->_load_model();
		$this->_load_fb_config();
		
		// 取得會員資訊
		$this->front->is_login = $this->member_model->login_status();
		$this->front->is_facebook = $this->member_model->is_facebook();
		$this->front->member_login = $this->member_model->get_member_login();
		$this->front->member_id = $this->member_model->get_member_id();
		
		//網站維護鎖
		// $this->load->model('website_lock_model');
		// $this->website_lock_model->lock();
		
		//IP鎖定
		// $this->close_inlet();
		
		$this->topbar_nums();
	}
	
	
	/**
	 * 解構式
	 *
	 */
	public function __destruct(){}
	
	
	/**
	 * 後台初始化
	 *
	 */
	private function _initialize()
	{
		$this->load->config('zhtech');
	}
	
	
	/**
	 * 自動載入設定檔
	 *
	 */
	private function _load_config()
	{
		$list = config_item('autoload_config');
		
		if (isset($list) && is_array($list))
		{
			foreach($list as $key => $val)
			{
				$this->load->config($val);
			}
			
			return TRUE;
		}
		else
		{
			if ($this->debug)
			{
				echo '_load_config() error . check your admin.php config setting';
			}
			
			log_message('error' , '_load_config() error . check your admin.php config setting');
			
			return die();
		}
	}
	
	
	/**
	 * 自動載入模組
	 *
	 */
	private function _load_model()
	{
		$list = config_item('autoload_model');
		
		if (isset($list) && is_array($list))
		{
			foreach($list as $key => $val)
			{
				$this->load->model($val);
			}
			
			return TRUE;
		}
		else
		{
			if ($this->debug)
			{
				echo '_load_model() error . check your admin.php config setting';
			}
			
			log_message('error' , '_load_model() error . check your admin.php config setting');
			
			return die();
		}
	}
	
	
	private function _load_fb_config()
	{
		$this->load->config('facebook');
		
		$this->front->fb_client_id = config_item('fb_client_id');
		$this->front->fb_client_private_key = config_item('fb_client_private_key');
		$this->front->fb_oauth_url_scope = config_item('fb_oauth_url_scope');
		$this->front->fb_scope = config_item('fb_scope');
		$this->front->fb_api_version = config_item('fb_api_version');
		$this->front->fb_oauth_target = config_item('fb_oauth_target');
	}
	
	
	/**
	 * 寫入meta
	 *
	 */
	public function write_meta($title = '' )
	{
		$this->load->model('meta_model');
		
		$meta = $this->meta_model->get_meta('index');
		
		if (!$title)
		{
			$this->front->title = $meta['web_title'] . $meta['web_title_end'];
		}
		else
		{
			$this->front->title = $title . $meta['web_title_end'];
		}
		
		$this->front->keywords = $title . ',' . $meta['web_keywords'];
		$this->front->description = $meta['web_description'];
		$this->front->author = $meta['web_author'];
		$this->front->footer = $meta['web_footer'];
	}
	
	
	/**
	 * 關閉網站入口
	 *
	 */
	public function close_inlet()
	{
		$ip = $this->input->ip_address();
		
		if (!in_array($ip , array('220.137.8.182' , '127.0.0.1')))
		{
			echo '網站建置中';
			return exit();
		}
	}
	
	
	/**
	 * 流量監控
	 *
	 */
	public function report_log()
	{
		$this->load->model('report_model');
		$this->report_model->log_user_request();
	}
	
	
	/** 
	 * 處理tarbar數字
	 *
	 */
	public function topbar_nums()
	{
		$this->front->topbar_nums1 = 0;
		$this->front->topbar_nums2 = 0;
		$this->front->topbar_nums3 = 0;
		
		// 1.系統通知訊息
		if ($this->front->is_login)
		{
			$this->db->where('mid' , $this->front->member_id);
			$this->db->where('is_read' , 0);
			$this->db->from('contact');
			
			$this->front->topbar_nums1 = $this->db->count_all_results();
		}
		
		// 2.最愛商品
		if ($this->front->is_login)
		{
			$this->load->model('favourite_model');
			
			$data = $this->favourite_model->get($this->front->member_login);
			
			$this->front->topbar_nums2 = count($data);
			
			unset($data);
		}
		
		// 3.購物車
		$this->load->library('cart');
		$contents = $this->cart->contents();
		$this->front->topbar_nums3 = count($contents);
	}
}

/* End of file MY_Controller.php */
/* Location: ./apps/core/MY_Conteoller.php */