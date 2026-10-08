<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {
	/**
	 * Zh_tech Admin Model
	 * 
	 * @package		: zh-tech
	 * @copyright	: zh-tech 振華科技
	 * @author		: Tone
	 * @depend		: zh_tech_helper,safe_model
	 */
	
	//密碼 hash
	private $passwd_hash = '';
	
	//session hash
	private $session_hash = '';
	
	//登入頁
	private $login_path = '';
	
	//登入成功後轉跳的後台主頁
	private $control_home = '';
	
	//管理者資料表
	private $admin_database = '';
	
	//登入紀錄資料表
	private $admin_loginlog_database = '';
	
	//操作紀錄資料表
	private $admin_operlog_database = '';
	
	//最大登入紀錄顯示筆數
	private $max_loginlog_rows = 0;
	
	//最大操作紀錄顯示筆數
	private $max_operlog_rows = 0;
	
	//是否開啟IP限制
	private $is_lock_ip = FALSE;
	
	//允許的白名單IP
	private $white_ip_map = array();
	
	//操作紀錄選項
	private $oper_list = array(0=>'未分類' , 1=>'新增' , 2=>'修改' , 3=>'查詢' , 4=>'刪除');

	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->passwd_hash = config_item('passwd_hash');
		$this->session_hash = config_item('session_hash');
		$this->login_path = config_item('login_path');
		$this->control_home = config_item('control_home');
		$this->admin_database = config_item('admin_database');
		$this->admin_loginlog_database = config_item('admin_loginlog_database');
		$this->admin_operlog_database = config_item('admin_operlog_database');
		$this->max_loginlog_rows = config_item('max_loginlog_rows');
		$this->max_operlog_rows = config_item('max_operlog_rows');
		$this->is_lock_ip = config_item('is_lock_ip');
		$this->white_ip_map = config_item('white_ip_map');
		
		$this->check_ip_map();
		
		$this->load->library('session');
		
		if (!isset($this->safe_model)) $this->load->model('safe_model');
	}
	
	public function __destruct()
	{
		
	}
	
	
	/**
	 * Create defaults root
	 *
	 * @return boolean
	 */
	public function create_default_root()
	{
		$this->is_lock_ip = TRUE;
		
		$this->check_ip_map(FALSE);
		
		return $this->add_admin('root' ,  'asdf' , 'ROOT' , 'tone2314@gmail.com' , 99);
	}
	
	
	/**
	 * 檢查IP是否在合法範圍內
	 * @param boolean $show_msg
	 *
	 * @return js_go_back()
	 */
	public function check_ip_map($show_msg = TRUE)
	{
		
		if ($this->is_lock_ip)
		{			
			if (function_exists('get_ip_address'))
			{
				$client_ip = get_ip_address();
			}
			else
			{
				$client_ip = $this->input->ip_address();
			}
			
			if ($client_ip == 'unknown') $client_ip = $this->input->ip_address();
			
			if ($this->input->valid_ip($client_ip))
			{
				if (!in_array($client_ip , $this->white_ip_map))
				{
					if ($show_msg)
					{
						js_go_back('您所使用的IP位置無法進入！');
					}
					exit();
				}
			}
			else
			{
				if ($show_msg)
				{
					js_go_back('您所使用的IP位置無法進入！');
				}
				exit();
			}
		}
	}
	
	
	/**
	 * 檢查用戶是否登入
	 * @param boolean $check_ajax_request 是否為ajax請求，若為是則不回傳js_go_msg並且驗證is_ajax_request()
	 * 
	 * @return TRUE | js_go_msg()
	 */
	public function is_login($check_ajax_request = FALSE)
	{
		if ($check_ajax_request == TRUE)
		{
			if (!$this->input->is_ajax_request())
			{
				return exit();
			}
		}
		
		$login = $this->session->userdata('login');
		
		$name = $this->session->userdata('name');
		
		$hash = $this->session->userdata('hash');
		
		if (md5($login . $name . $this->session_hash) === $hash)
		{
			return TRUE;
		}
		else
		{
			if ($check_ajax_request == FALSE)
			{
				js_go_msg($this->login_path , '您尚未登入');
				
			}
			return exit();
		}
	}
	
	
	/**
	 * 檢查用戶是否登入 (同時檢查ajax)
	 * 
	 * @return TRUE | js_go_msg()
	 */
	public function is_login_ajax()
	{
		$this->is_login(TRUE);
	}
	
	
	/**
	 * 登入會員
	 * @param string $login 登入帳號
	 * @param string $passwd 尚未md5編碼的密碼
	 * 
	 * @return js_go_msg()
	 */
	public function login($login = FALSE , $passwd = FALSE)
	{
		if ($login == FALSE || $passwd == FALSE)
		{
			$this->safe_model->add_request(1 , $login , $passwd);
			
			js_go_msg($this->login_path , '登入失敗');
			return exit();
		}
		
		$check = $this->safe_model->check(1 , $login , $passwd);
		
		$passwd = md5($passwd . $this->passwd_hash);
		
		$sql = "SELECT * FROM {$this->admin_database} WHERE login = ? AND passwd = ?";
		
		$query = $this->db->query($sql , array($login , $passwd));
		
		if ($query->num_rows() > 0 && $check)
		{
			$admin = $query->row();
			
			$session_data = array(
				'login' => $admin->login,
				'name' => $admin->name,
				'hash' => md5($admin->login . $admin->name . $this->session_hash),
				'level' => $admin->level,
			);
			
			$this->session->set_userdata($session_data);
			
			$this->update_login_time($admin->id);
			
			$this->add_loginlog($admin->login);
			
			js_go_msg($this->control_home , '登入成功');
			return exit();
		}
		
		$this->safe_model->add_request(1 , $login , $passwd);
		
		js_go_msg($this->login_path , '登入失敗');
		return exit();
	}
	
	
	/**
	 * 登出
	 * @param boolean $no_header 若為TRUE 則不執行header
	 *
	 * @return header
	 */
	public function logout($no_header = FALSE)
	{	
		$this->session->unset_userdata(array('login' , 'name' , 'hash' , 'level'));
		
		$this->session->sess_destroy();
			
		if ($no_header == FALSE) header('Location: /control/login');
	}
	
	
	/**
	 * 取得管理者列表
	 * @param
	 *
	 * @return array(object{*})
	 */
	public function get_admin_list()
	{
		$sql = "SELECT * FROM {$this->admin_database}";
		$query = $this->db->query($sql);
		
		$result = $query->result();
		$query->free_result();
		
		return $result;
	}
	
	
	/**
	 * 取得單一管理者
	 * @param int $id
	 * @param string $login
	 * 
	 * @return object{*} | FALSE
	 */
	public function get_one_admin($id = FALSE , $login = FALSE)
	{
		if ($id == FALSE && $login == FALSE) return FALSE;
		
		$sql_where = "WHERE 1 ";
		$param = array();
		
		if ($id != FALSE)
		{
			$sql_where .= "AND id = ? ";
			$param[] = $id;
		}
		
		if ($login != FALSE)
		{
			$sql_where .= "AND login = ? ";
			$param[] = $login;
		}
		
		$sql = "SELECT * FROM {$this->admin_database} {$sql_where}";
		$query = $this->db->query($sql , $param);
		$result = $query->row();
		
		$query->free_result();
		return $result;
	}
	
	
	/**
	 * 新增管理者
	 * @param array() $data array(login,passwd,name,email,level,create_at,last_login_at)
	 *
	 * @return array(status , msg)
	 */
	public function add_admin($login = FALSE , $passwd = FALSE , $name = '' , $email = '' , $level = 0)
	{
		if ($login == FALSE || $passwd == FALSE) return array('status' => 'F' , 'msg' => '缺少必填欄位');
		
		$passwd = md5($passwd . $this->passwd_hash);
		$create_at = date('Y-m-d H:i:s');
		$last_login_at = $create_at;
		$level = (int) $level;
		
		if (!$this->is_exists($login)) return array('status' => 'F' , 'msg' => '該帳號已註冊');
		
		if (strlen($login) > 30) return array('status' => 'F' , 'msg' => '帳號名稱過長');
		if (strlen($passwd) > 32) return array('status' => 'F' , 'msg' => '密碼過長');
		if (strlen($name) > 30) return array('status' => 'F' , 'msg' => '帳號名稱過長');
		if (strlen($email) > 100) return array('status' => 'F' , 'msg' => '信箱過長');
		if ($level > 99) return array('status' => 'F' , 'msg' => '權限請勿設定超過99');
		
		$sql = "INSERT INTO {$this->admin_database} SET login = ? , passwd = ? , name = ? , email = ? , level = ?  , create_at = ? , last_login_at = ? ";
		$query = $this->db->query($sql , array($login , $passwd , $name , $email , $level , $create_at , $last_login_at));
		
		if ($query) return array('status' => 'T' , 'msg' => '新增成功');
		
		return array('status' => 'F' , 'msg' => '資料寫入失敗');
	}
	
	
	/**
	 * 修改管理者
	 * @param int $id 
	 * @param string $login
	 * @param string $passwd
	 * @param string $name
	 * @param string $email
	 *
	 * @return array(status , msg)
	 */
	public function edit_admin($id = FALSE , $passwd = FALSE , $name = '' , $email = '' , $level = 0)
	{
		if ($id == FALSE) return array('status' => 'F' , 'msg' => '缺少必填欄位');
		
		$sql_str = " name = ? , email = ? ";
		$sql_ary = array($name , $email);
		$level = (int) $level;
		
		if (strlen($passwd) > 32) return array('status' => 'F' , 'msg' => '密碼過長');
		if (strlen($name) > 30) return array('status' => 'F' , 'msg' => '帳號名稱過長');
		if (strlen($email) > 100) return array('status' => 'F' , 'msg' => '信箱過長');
		if ($level > 99) return array('status' => 'F' , 'msg' => '權限請勿設定超過99');
		
		//刷新密碼
		if ($passwd != FALSE)
		{
			$passwd = md5($passwd . $this->passwd_hash);
			$sql_str .= " , passwd = ? ";
			$sql_ary[] = $passwd;
		}
		
		if ($name != FALSE)
		{
			$sql_str .= " , name = ? ";
			$sql_ary[] = $name;
		}
		
		if ($email != FALSE)
		{
			$sql_str .= " , email = ? ";
			$sql_ary[] = $email;
		}
		
		if ($level != FALSE)
		{
			$sql_str .= " , level = ? ";
			$sql_ary[] = $level;
		}
		
		$sql_str .= " WHERE id = ?";
		$sql_ary[] = $id;
		
		$sql = "UPDATE {$this->admin_database} SET {$sql_str}";
		$query = $this->db->query($sql , $sql_ary);
		
		if ($query) return array('status' => 'T' , 'msg' => '修改成功');
		
		return array('status' => 'F' , 'msg' => '寫入資料失敗');
	}
	
	
	/**
	 * 刪除管理者
	 * @param int $id 
	 *
	 * @return array(status , msg)
	 */
	public function del_admin($id = FALSE)
	{
		if ($id == FALSE) return array('status' => 'F' , 'msg' => '缺少必填欄位');
		
		$sql = "DELETE FROM {$this->admin_database} WHERE id = ?";
		$query = $this->db->query($sql , array($id));
		
		if ($query) return array('status' => 'T' , 'msg' => '刪除成功');
		
		return array('status' => 'F' , 'msg' => '寫入資料失敗');
	}
	
	
	/**
	 * 確認該帳號是否可以使用
	 * @param string $login
	 *
	 * @return boolean
	 */
	public function is_exists($login = '')
	{
		$sql = "SELECT * FROM {$this->admin_database} WHERE login = ?";
		$query = $this->db->query($sql , array($login));
		if ($query->num_rows() == 0) return TRUE;
		
		return FALSE;
	}
	
	
	/**
	 * 更新管理者登入時間
	 * @param int $id
	 * 
	 * @return boolean
	 */
	public function update_login_time($id = FALSE)
	{
		if ($id == FALSE) return FALSE;
		
		$sql = "UPDATE {$this->admin_database} SET last_login_at = ? WHERE id = ?";
		$query = $this->db->query($sql , array(date('Y-m-d H:i:s') , $id));
		
		if ($query) return TRUE;
		
		return FALSE;
	}
	
	
	/**
	 * 取得登入紀錄列表
	 *
	 * @return array(object{*})
	 */
	public function get_loginlog_list()
	{
		$sql = "SELECT * FROM {$this->admin_loginlog_database} WHERE 1 ORDER BY id DESC LIMIT 0,{$this->max_loginlog_rows}";
		$query = $this->db->query($sql);
		$result = $query->result();
		$query->free_result();
		
		return $result;
	}
	
	
	/**
	 * 取得操作紀錄
	 *
	 * @return array(object{*})
	 */
	public function get_operlog_list()
	{
		$sql = "SELECT * FROM {$this->admin_operlog_database} WHERE 1 ORDER BY id DESC LIMIT 0,{$this->max_operlog_rows}";
		$query = $this->db->query($sql);
		$result = $query->result();
		$query->free_result();
		
		return $result;
	}
	
	
	/**
	 * 新增登入紀錄
	 *
	 */
	public function add_loginlog($login = FALSE)
	{
		if ($login == FALSE) return FALSE;
		
		$sql = "INSERT INTO {$this->admin_loginlog_database} SET login = ? , create_at = ? , create_at_time = ? , ip_address = ? , request_info = ?";
		$query = $this->db->query($sql , array($login , date('Y-m-d') , date('Y-m-d H:i:s') , $this->input->ip_address() , json_encode($_SERVER)));
		
		if ($query)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	
	/**
	 * 新增操作紀錄
	 *
	 */
	public function add_operlog($type = 0 , $msg = '' , $login = '')
	{		
		if ($login == '')
		{
			$login = $this->session->userdata('login');
		}
		
		$sql = "INSERT INTO tigertour_admin_oper_history SET login = ? , create_at = ? , create_at_time = ? , ip_address = ? , request_info = ? , oper = ? , oper_desc = ? ";
		$query = $this->db->query($sql , array($login , date('Y-m-d') , date('Y-m-d H:i:s') , $this->input->ip_address() , json_encode($_SERVER) , $this->oper_list[$type] , $msg));
		
		if ($query)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	
	/**
	 * 確認該帳號權限是否高於此數值
	 * @param int $id 
	 * @param int $level
	 */
	public function check_level($id = FALSE , $level = 0)
	{
		if ($id == FALSE) return FALSE;
		
		$admin = $this->get_one_admin($id);
		
		if ($admin->level >= $level) return TRUE;
		
		return FALSE;
	}
	
}

/* End of file Zh_tech_admin_model.php */
/* Location: ./apps/models/Zh_tech_admin_model.php */