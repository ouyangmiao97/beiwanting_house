<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Safe_model extends CI_Model {
	/**
	 * 帳號安全
	 * 
	 * @package		: zh-tech
	 * @copyright	: zh-tech 振華科技
	 * @author		: Tone
	 * @depend		: zh_tech_helper
	 */
	private $safe_login_mode = FALSE;
	
	private $safe_request_database = '';
	
	private $safe_bind_ip_database = '';
	
	private $safe_bind_login_database = '';
	
	private $safe_time_sleep = 0;
	
	private $safe_1min_times = 0;
	
	private $safe_1min_bind_times = 0;
	
	private $request_defaults = array(
		'id' => null,
		'type' => 0,
		'login' => '',
		'passwd' => '',
		'create_at' => '',
		'create_at_time' => '',
		'ip_address' => '',
		'request_info' => '',
	);
	
	public function __construct()
	{
		parent::__construct();
		
		$this->_initialize();
	}
	
	
	public function __destruct()
	{
		
	}
	
	
	private function _initialize()
	{
		$this->safe_login_mode = config_item('safe_login_mode');
		$this->safe_request_database = config_item('safe_request_database');
		$this->safe_bind_ip_database = config_item('safe_bind_ip_database');
		$this->safe_bind_login_database = config_item('safe_bind_login_database');
		$this->safe_time_sleep = config_item('safe_time_sleep');
		$this->safe_1min_times = config_item('safe_1min_times');
		$this->safe_1min_bind_times = config_item('safe_1min_bind_times');
	}
	
	
	/**
	 * Add request
	 *
	 */
	public function add_request($type = 0 , $login = '' , $passwd = '')
	{
		
		$data_list = $this->request_defaults;
		
		$data_list['type'] = $type;
		$data_list['login'] = $login;
		$data_list['passwd'] = $passwd;
		$data_list['create_at'] = date('Y-m-d');
		$data_list['create_at_time'] = date('Y-m-d H:i:s');
		$data_list['ip_address'] = $this->input->ip_address();
		$data_list['request_info'] = json_encode($_SERVER);
		
		$sql = "INSERT INTO {$this->safe_request_database} SET id = ? , type = ? , login = ? , passwd = ? , create_at = ? , create_at_time = ? , ip_address = ? , request_info = ?";
		$query = $this->db->query($sql , $data_list);
		
		/////檢查是否BAN
		
		if ($this->safe_login_mode)
		{
			$max_times = $this->safe_1min_bind_times;
			$s = 60;
			$now = time();
			$now = $now - $s;
			$datetime = date('Y-m-d H:i:s' , $now);
			$request = $this->get_request($type , $login , $datetime);
			
			if (count($request) > $max_times)
			{
				$this->ban_ip($type , $this->input->ip_address());
				$this->ban_login($type , $login);
			}
		}
	}
	
	
	/**
	 * Get request
	 *
	 */
	public function get_request($type = 0 , $login = '' , $datetime = '')
	{
		$sql = "SELECT * FROM {$this->safe_request_database} WHERE type = ? AND login = ? AND create_at_time > ?";
		$query = $this->db->query($sql , array($type , $login , $datetime));
		
		return $query->result();
	}
	
	
	/**
	 * Check 
	 *
	 */
	public function check($type = 0 , $login = '' , $passwd = '')
	{
		if (!$this->safe_login_mode) return TRUE;
		
		//檢查第一階段 N秒內請求視為失敗
		$s = $this->safe_time_sleep;
		$now = time();
		$now = $now - $s;
		$datetime = date('Y-m-d H:i:s' , $now);
		$request = $this->get_request($type , $login , $datetime);
		
		//檢查第二階段 一分鐘內 最大次數 超過視為失敗
		if (count($request) > 0) return FALSE;
		
		$max_times = $this->safe_1min_times;
		$s = 60;
		$now = time();
		$now = $now - $s;
		$datetime = date('Y-m-d H:i:s' , $now);
		$request = $this->get_request($type , $login , $datetime);
		
		if (count($request) > $max_times) return FALSE;
		
		//檢查第三階段 IP是否已經是被BAN
		$ip = $this->input->ip_address();
		
		if ($this->is_bind_ip($ip , $type))
			return FALSE;
		
		//檢查第四階段 帳號是否已經是被BAN
		if ($this->is_bind_login($login , $type))
			return FALSE;
		
		return TRUE;
	}

	
	/**
	 * GET bind ip list
	 *
	 */
	public function get_bind_ip_list($type = 0)
	{
		$sql = "SELECT * FROM {$this->safe_bind_ip_database} WHERE type = ?";
		$query = $this->db->query($sql , array($type));
		$result = $query->result();
		$query->free_result();
		
		if (!$result) return array();
		
		$tmp_list = array();
		foreach($result as $key => $row)
		{
			$tmp_list[] = $row->ip;
		}
		
		return $tmp_list;
	}
	
	
	/**
	 * GET bind ip list
	 *
	 */
	public function get_bind_login_list($type = 0)
	{
		$sql = "SELECT * FROM {$this->safe_bind_login_database} WHERE type = ?";
		$query = $this->db->query($sql , array($type));
		$result = $query->result();
		$query->free_result();
		
		if (!$result) return array();
		
		$tmp_list = array();
		foreach($result as $key => $row)
		{
			$tmp_list[] = $row->ip;
		}
		
		return $tmp_list;
	}
	
	
	public function is_bind_ip($ip = '' , $type = 0)
	{
		$bind_list = $this->get_bind_ip_list($type);
		
		if (in_array($ip , $bind_list))
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	
	public function is_bind_login($login = '' , $type = 0)
	{
		$bind_list = $this->get_bind_login_list($type);
		
		if (in_array($login , $bind_list))
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	
	public function ban_ip($type = 0 , $ip = '')
	{
		$sql = "INSERT INTO {$this->safe_bind_ip_database} SET type = ? , ip = ? , create_at_time = ?";
		$query = $this->db->query($sql , array($type , $ip , date('Y-m-d H:i:s')));
	}
	
	
	public function ban_login($type = 0 , $login = '')
	{
		$sql = "INSERT INTO {$this->safe_bind_login_database} SET type = ? , ip = ? , create_at_time = ?";
		$query = $this->db->query($sql , array($type , $login , date('Y-m-d H:i:s')));
	}
}

/* End of file Zh_tech_admin_model.php */
/* Location: ./apps/models/Zh_tech_admin_model.php */