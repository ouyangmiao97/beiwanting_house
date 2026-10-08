<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Website_lock_model extends CI_Model {
	/**
	 * Website Lock Model
	 * 
	 * @package		: zh-tech
	 * @copyright	: zh-tech 振華科技
	 * @author		: Tone
	 * @depend		: 
	 * @version 	: 1.0.1
	 * 
	 *
	 * 鎖定網站，讓使用者必須輸入密碼獲得權限才能瀏覽
	 * 使用方式
	 * CI core
	 * $this->load->model('Website_lock_model');
	 * $this->website_lock_model->lock();
	 *
	 * 驗證頁面
	 * $this->load->model('Website_lock_model');
	 * $this->website_lock_model->passwd();
	 */
	private $hash = '39c55431f71bfd25275623ed1337995a';
	
	private $passwd = 'zTechhi!@#';
	
	private $cookie_name = '';
	
	private $lock_msg = '網站建置或維護中';
	
	private $expire = 7200;
	
	private $show_uri = array('lock' , 'lock/index' , 'api/allpay_response' , 'api/allpay_error' , 'api/allpay_cancel_order' , 'api/allpay_info_response' , 'api/order_send_response');
	
	public function __construct()
	{
		parent::__construct();
		
		//每天更新一次
		$this->cookie_name = md5(date('Y-m-d'));
	}
	
	
	public function __destruct()
	{
		$this->hash = '';
		$this->passwd = '';
	}
	
	
	/**
	 * 鎖定網站，不讓使用者進入
	 *
	 */
	public function lock()
	{
		//驗證頁無須遮蔽
		if (in_array($this->uri->uri_string() , $this->show_uri)) return TRUE;
		
		//檢查是否接收驗證
		if ($this->input->post('website_lock' , TRUE) != FALSE)
		{
			if (!$this->passwd())
			{
				js_go_back('驗證失敗');
				return exit();
			}
			else
			{
				js_go_msg(site_url() , '驗證完成');
				return exit();
			}
		}
		
		//檢查驗證
		if (!$this->check())
		{
			echo $this->lock_msg;
			return exit();
		}
		
		return TRUE;
	}
	
	
	/**
	 * 驗證密碼
	 *
	 */
	public function passwd()
	{
		$passwd = $this->input->post('website_lock' , TRUE);
		
		if ($passwd === $this->passwd)
		{
			$cookie = array(
				'name' => $this->cookie_name,
				'value' => md5($this->cookie_name . $this->passwd . $this->hash),
				'expire' => $this->expire,
				'domain' => $_SERVER['HTTP_HOST'],
				'path' => '/',
				// 'prefix' => 'website_lock_',
				// 'secure' => TRUE,
			);
			
			$this->input->set_cookie($cookie);
			
			return TRUE;
		}
		
		return FALSE;
	}
	
	
	/**
	 * 顯示表單
	 *
	 */
	public function show_form()
	{
		echo '<form action="' . site_url() . '" method="post">';
		echo '輸入驗證碼： <input type="text" name="website_lock" /><input type="submit" value="送出" />';
		echo '</form>';
	}
	
	
	/**
	 * 檢查使用者身份是否合理
	 *
	 */
	public function check()
	{
		$cookie = $this->input->cookie($this->cookie_name , TRUE);
		
		if (!$cookie) return FALSE;
		
		$cookie_hash = md5($this->cookie_name . $this->passwd . $this->hash);
		
		if ($cookie === $cookie_hash)
		{
			$this->rewrite($cookie);
			
			return TRUE;
		}
		
		return FALSE;
	}
	
	
	/**
	 * 複寫cookie時間
	 *
	 */
	public function rewrite($cookie_hash = '')
	{
		$cookie = array(
			'name' => $this->cookie_name,
			'value' => $cookie_hash,
			'expire' => $this->expire,
			'domain' => $_SERVER['HTTP_HOST'],
			'path' => '/',
		);
		
		$this->input->set_cookie($cookie);
		
		return TRUE;
	}
}

/* End of file Website_lock_model.php */
/* Location: ./apps/models/Website_lock_model.php */