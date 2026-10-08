<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Session_model extends CI_Model {
	/**
	 * Session Model
	 * 
	 * @package		: zh-tech
	 * @copyright	: zh-tech 振華科技
	 * @author		: Tone
	 * @depend		: CI_log 
	 *
	 */
	private $is_life = FALSE;
	
	private $debug = FALSE;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->check_session();
	}
	
	
	public function __destruct()
	{
		
	}
	
	
	public function check_session()
	{
		if (isset($_SESSION))
		{
			$this->is_life = TRUE;
		}
		else
		{
			$this->is_life = FALSE;
		}
		
		return $this->is_life;
	}
	
	
	/**
	 * Set session 
	 * @param string $key
	 * @param string $val
	 *
	 * @return boolean
	 */
	public function set_session($key = FALSE , $val = FALSE)
	{
		if (!$key || !$val) return $this->error('param error!!!');
		
		$key = config_item('site') . $key;
		
		if ($this->is_life)
		{
			$_SESSION[$key] = $val;
			
			if ($_SESSION[$key] == $val) return TRUE;
			
			return $this->error('session write error!!!');
		}
		else
		{
			return $this->error('check your session start. php can not load $_SESSION()');
		}
	}
	
	
	/**
	 * Get session
	 * @param string $key
	 *
	 * @return boolean
	 */
	public function get_session($key = FALSE)
	{
		if (!$key) return $this->error('param error!!!');
		
		$key = config_item('site') . $key;
		
		if ($this->is_life)
		{
			if (isset($_SESSION[$key]))
			{
				return $_SESSION[$key];
			}
			
			return $this->error('session can not befound!');
		}
		else
		{
			return $this->error('check your session start. php can not load $_SESSION()');
		}
	}
	
	
	/**
	 * Del session 
	 * @param string $key
	 *
	 * @return boolean
	 */
	public function del_session($key = FALSE)
	{
		if (!$key) return $this->error('param error!!!');
		
		$key = config_item('site') . $key;
		
		if ($this->is_life)
		{
			if (isset($_SESSION[$key]))
			{
				$_SESSION[$key] = '';
				unset($_SESSION[$key]);
			}
			
			return TRUE;
		}
		else
		{
			return $this->error('check your session start. php can not load $_SESSION()');
		}
	}
	
	
	private function error($msg = '')
	{
		if ($this->debug)
		{
			log_message('error' , $msg);
		}
		return FALSE;
	}
	
	
	public function set_time_out($time = 0)
	{
		$time = (int) $time;
		
		ini_set('session_cookie_lifetime' , $time);
		
		setcookie('PHPSESSID' , session_id() , time() + $time , '/');
	}
}

/* End of file Session_model.php */
/* Location: ./apps/models/Session_model.php */