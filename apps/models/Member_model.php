<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_model extends CI_Model {
	/**
	 * 振華科技會員模組
	 * 
	 * @package		: zh-tech
	 * @copyright	: zh-tech 振華科技
	 * @author		: Tone
	 * @depend		: zh_tech_helper,safe_model
	 */
	private $member_passwd_hash = '';
	
	private $member_session_hash = '';
	
	private $member_database = '';
	
	private $member_login_uri = '';
	
	private $member_home_uri = '';
	
	private $member_defaults = array();
	
	private $error_code = array();
	
	private $member_haveto = array();
	
	private $member_login_time_out = 3600;
	
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
		$this->member_passwd_hash = config_item('member_password_hash');
		$this->member_session_hash = config_item('member_session_hash');
		$this->member_database = config_item('member_database');
		$this->member_login_uri = config_item('member_login_uri');
		$this->member_home_uri = config_item('member_home_uri');
		$this->member_defaults = config_item('member_defaults');
		$this->member_haveto = config_item('member_haveto');
		$this->member_login_time_out = config_item('member_login_time_out');
		
		$this->error_code = config_item('error_code');
		
		$this->load->library('session');
		
		if (!isset($this->safe_model)) $this->load->model('safe_model');
		
		if (!isset($this->upload_model)) $this->load->model('upload_model');
	}
	
	
	/**
	 * Response Message
	 *
	 */
	private function _msg($status = FALSE , $error = 0)
	{
		if (!array_key_exists($error , $this->error_code)) $error = 0;		
		
		if ($this->input->is_ajax_request())
		{			
			if (!$status)
			{
				$status = 'F';
			}else{
				$status = 'T';
			}
			return array('status' => $status , 'msg' => $this->error_code[$error]);
		}
		else
		{
			return array($status , $this->error_code[$error]);
		}
	}
	
	
	/**
	 * 檢查用戶是否登入
	 * @param boolean $check_ajax_request
	 *
	 * @return boolean Login state; redirects home when unavailable.
	 */
	public function is_login($check_ajax_request = FALSE)
	{
		if ($check_ajax_request)
		{
			if (!$this->input->is_ajax_request())
			{
				return exit();
			}
		}
		
		$member_login = $this->session->userdata('member_login');
		
		$member_name = $this->session->userdata('member_name');
		
		$member_hash = $this->session->userdata('member_hash');
		
		if (md5($member_login . $member_name . $this->member_session_hash) === $member_hash)
		{
			return TRUE;
		}
		else
		{
			if (!$check_ajax_request)
			{
				js_go_msg(site_url() , '您尚未登入');
				exit();
			}
			
			return exit();
		}
	}
	
	
	public function get_member_login()
	{
		return $this->session->userdata('member_login');
	}
	
	
	public function get_member_name()
	{
		return $this->session->userdata('member_name');
	}
	
	public function get_member_id()
	{
		return $this->session->userdata('member_id');
	}
	
	
	/**
	 * 檢查登入狀態
	 * 
	 * @return boolean 
	 */
	public function login_status()
	{
		$member_login = $this->session->userdata('member_login');
		
		$member_name = $this->session->userdata('member_name');
		
		$member_hash = $this->session->userdata('member_hash');
		
		if (md5($member_login . $member_name . $this->member_session_hash) === $member_hash)
		{
			return TRUE;
		}
		else
		{		
			return FALSE;
		}
	}
	
	
	/**
	 * 檢查用戶是否登入
	 * 
	 * @return boolean is_login
	 */
	public function is_login_ajax()
	{
		$this->is_login(TRUE);
	}
	
	
	/**
	 * 登入會員
	 * @param string $login 登入帳號
	 * @param string $passwd 尚未md5之密碼
	 *
	 * @return js_go_msg()
	 */
	public function login($login = FALSE , $passwd = FALSE , $remember = FALSE)
	{
		if ($login != FALSE) $login = strtolower($login);
		
		if ($login == FALSE || $passwd == FALSE)
		{
			$this->safe_model->add_request(2 , $login , $passwd);
			
			js_go_msg(site_url() , '登入失敗');
			return exit();
		}
		
		$check = $this->safe_model->check(2 , $login , $passwd);
		
		$passwd = md5($passwd . $this->member_passwd_hash);
		
		$sql = "SELECT * FROM {$this->member_database} WHERE login = ? AND passwd = ? AND active > 0 AND isfb = 0";
		
		$query = $this->db->query($sql , array($login , $passwd));
		
		$row = $query->row();
		
		$query->free_result();
		
		if ($row)
		{
			// if ($row->admin_verify != 1)
			// {
				// return exit();
			// }
			
			if (strtolower($remember) == 'on')
			{
				$time = 7776000;				
			}
			else
			{
				$time = $this->member_login_time_out;
			}
			
			ini_set('session_cookie_lifetime' , $time);
			setcookie('PHPSESSID' , session_id() , time() + $time , '/');
			// setcookie('ci_session' ,  , time() + $time , '/');
			
			$session_data = array(
				'member_id' => $row->id,
				'member_login' => $row->login,
				'member_name' => $row->name,
				'member_hash' => md5($row->login . $row->name . $this->member_session_hash),
				'is_facebook' => $row->isfb
			);
			
			$this->session->set_userdata($session_data);
			
			js_go_msg(site_url() , '登入成功');
			return exit();
		}
		
		$this->safe_model->add_request(2 , $login , $passwd);
		
		js_go_msg( site_url() , '登入失敗');
		return exit();
	}
	
	
	/**
	 * 登出
	 * @param boolean $no_header 若為True 則不執行header
	 */
	public function logout($no_header = FALSE)
	{
		$this->session->unset_userdata(array('member_login' , 'member_name' , 'member_hash' , 'member_level' , 'member_id' , 'is_facebook'));
		
		$this->session->sess_destroy();
		
		if ($no_header == FALSE) header('Location: ' . site_url('home/index'));
	}
	
	
	/**
	 * 取得單一會員(id)
	 * @param int $id
	 * 
	 * @return object{}
	 */
	public function get_member_by_id($id = FALSE , $active = 1)
	{
		if (!$id) return FALSE;
		
		$sql = "SELECT * FROM {$this->member_database} WHERE id = ? AND active >= ?";
		$query = $this->db->query($sql , array($id , $active));
		
		return $query->row();
	}
	
	
	/**
	 * 取得單一會員(login)
	 * @param string $login
	 * 
	 * @return object{}
	 */
	public function get_member_by_login($login = FALSE , $active = 1)
	{
		if (!$login) return FALSE;
		
		$sql = "SELECT * FROM {$this->member_database} WHERE login = ? AND active >= ?";
		$query = $this->db->query($sql , array($login , $active));
		
		return $query->row();
	}
	
	
	/**
	 * 取得現在登入的會員的資料
	 *
	 */
	public function get_member_my()
	{
		$login = $this->session->userdata('member_login');
		
		$member_data = $this->get_member_by_login($login);
		
		// $member_data->img_file = $this->upload_model->get_cache($member_data->prescription);
		
		//移除隱密資料
		if (isset($member_data->passwd))
		{
			unset($member_data->passwd);
		}
		
		return $member_data;
	}
	
	
	/**
	 * 取得會員列表
	 * @param int $active
	 * @param int $page
	 * @param int $limit
	 *
	 * @return array[object{}]
	 */
	public function get_member_list($active = 1 , $page = 0 , $limit = 0)
	{
		$active = (int) $active;
		$page = (int) $page;
		$limit = (int) $limit;
		
		if ($page > 0)
		{
			$page = ($page - 1) * $limit;
		}
		else
		{
			$page = 0;
		}
		
		$sql = "SELECT * FROM {$this->member_database} WHERE active = ? ORDER BY id DESC LIMIT ? , ?";
		$query = $this->db->query($sql , array($active , $page , $limit));
		
		return $query->result();
	}
	
	
	/**
	 * 檢查必填會員資料是否填寫
	 * @param array $data
	 *
	 * @return boolean 
	 */
	public function check_haveto($data = FALSE , $is_edit_or = FALSE)
	{
		if (!$data) return $this->_msg(FALSE , 401);
		
		$err = 0;
		
		foreach($this->member_haveto as $key => $val)
		{
			if ($is_edit_or && $val == 'login') continue;
			if ($is_edit_or && $val == 'passwd') continue;
			
			if (!isset($data[$val]) || !$data[$val])
			{
				return $this->_msg(FALSE , $key);
			}
		}

		return TRUE;
	}
	
	
	/**
	 * 
	 *
	 */
	public function bind_data($data = FALSE , $is_edit_or = FALSE)
	{
		if (!$data) return FALSE;
		
		if ($is_edit_or == FALSE)
		{
			//將帳號轉為小寫
			$data['login'] = strtolower($data['login']);
		}
		
		//密碼加密
		if (isset($data['passwd']))
		{
			$data['passwd'] = md5($data['passwd'] . $this->member_passwd_hash);
		}
		
		return $data;
	}
	
	
	/**
	 * 檢查資料格式
	 *
	 */
	public function check_data($data = FALSE , $is_edit_or = FALSE)
	{
		
		if (!$data) return $this->_msg(FALSE , 401);
		
		if ($is_edit_or == FALSE)
		{
			if (!preg_match("/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_-]+([.][A-z0-9_-]+)*[.][A-z]{2,4}$/" , $data['login'])) return $this->_msg(FALSE , 601);
		}
		
		// if (!preg_match("/^.*(?=.{8,})(?=.*d)(?=.*[a-z])(?=.*[A-Z]).*$/" , $data['passwd'])) return $this->_msg(FALSE , 602);
		
		if (isset($data['passwd']) && $data['passwd'] != FALSE)
		{
			if (!preg_match("/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,20}$/" , $data['passwd'])) return $this->_msg(FALSE , 602);
		}
		// if (!preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/" , $data['passwd'])) return $this->_msg(FALSE , 602);
		
		return TRUE;
	}
	
	
	/**
	 * 新增會員
	 *
	 *
	 */
	public function add_member($data = FALSE)
	{
		if (!$data) return $this->_msg(FALSE , 401);
		
		//檢查必填欄位
		$check = $this->check_haveto($data);
		
		if (is_array($check) || is_object($check))
		{
			return $check;
		}
		
		//檢查帳號是否已使用
		if ($this->member_exists($data['login'])) return $this->_msg(FALSE , 300);
		
		//檢查資料的格式
		$check = $this->check_data($data);
		
		//整理資料的格式
		$data = $this->bind_data($data);
		
		if (is_array($check) || is_object($check))
		{
			return $check;
		}
		
		$sql_data = array();
		$sql_set = array();
		
		// 產生會員編號
		$data['member_no'] = $this->create_member_no();
		// 取消驗證 直接通過驗證
		$data['admin_verify'] = 1;
		$data['create_at'] = date('Y-m-d H:i:s');
		$data['admin_verify_at'] = date('Y-m-d H:i:s');
		
		unset($data['passwd_again']);
		unset($data['captcha_code']);
		unset($data['captcha_file']);
		unset($data['agree']);
		
		$query = $this->db->insert($this->member_database , $data);
		
		if ($query)
		{
			return $this->_msg(TRUE , 1);
			exit();
		}
		
		return $this->_msg(FALSE , 500);
	}
	
	
	/**
	 * 修改會員
	 *
	 */
	public function edit_member($data = FALSE)
	{
		if (!$data) return $this->_msg(FALSE , 401);
		
		//檢查必填欄位
		$check = $this->check_haveto($data , TRUE);
		
		if (is_array($check) || is_object($check))
		{
			return $check;
		}
		
		//檢查資料的格式
		$check = $this->check_data($data , TRUE);
		
		//整理資料的格式
		$data = $this->bind_data($data , TRUE);
		
		if (is_array($check) || is_object($check))
		{
			return $check;
		}
		
		$id = $data['id'];
		
		unset($data['id']);
		
		// 若無修改密碼
		if (isset($data['passwd']) && $data['passwd'] == FALSE)
		{
			unset($data['passwd']);
		}
		
		$this->db->where('id' , $id);
		$query = $this->db->update($this->member_database , $data);
		
		// $sql_data = array();
		// $sql_set = array();
		
		// foreach($this->member_defaults as $key => $val)
		// {
			// if ($key == 'id') continue;
			// if ($key == 'passwd' && !isset($data['passwd'])) continue;
			
			// $sql_set[] = $key . ' = ? ';
			// if (isset($data[$key]))
			// {
				// $sql_data[$key] = $data[$key];
			// }
			// else
			// {
				// $sql_data[$key] = $val;
			// }
		// }
		
		// $sql_set = implode(',' , $sql_set);
		
		// $sql_data['id'] = $data['id'];
		
		// $sql = "UPDATE {$this->member_database} SET {$sql_set} WHERE id = ?";
		// $query = $this->db->query($sql , $sql_data);
		
		if ($query)
		{
			return $this->_msg(TRUE , 2);
			exit();
		}
		
		return $this->_msg(FALSE , 500);
	}
	
	
	/**
	 * 刪除會員(偽刪除)
	 *
	 */
	public function del_member($id = FALSE)
	{
		if (!$id) return $this->_msg(FALSE , 401);
		
		$sql = "UPDATE FROM {$this->member_database} SET active = '-1' WHERE id = ?";
		$query = $this->db->query($sql , array($id));
		
		if ($query)
		{
			return $this->_msg(TRUE , 3);
			exit();
		}
		
		return $this->_msg(FALSE , 500);
	}
	
	
	/**
	 * 檢查member是否存在
	 * @param string $login
	 *
	 * @return boolean
	 */
	public function member_exists($login = FALSE)
	{
		if (!$login) return FALSE;
		
		$sql = "SELECT * FROM {$this->member_database} WHERE login = ?";
		
		$query = $this->db->query($sql , array($login));
		
		$row = $query->row();
		
		if ($row)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	
	/**
	 * 信箱驗證
	 * @param string $login
	 * @param string $verify_code
	 *
	 * @return boolean
	 */
	public function member_verify($login = FALSE , $verify_code = FALSE)
	{
		if ($login == FALSE || $verify_code == FALSE) return FALSE;
		
		if (!$this->member_exists($login)) return FALSE;
		
		$sql = "SELECT verify_code FROM {$this->member_database} WHERE login = ? AND active = '0'";
		$query = $this->db->query($sql , array($login));
		$row = $query->row();
		if ($row->verify_code === $verify_code)
		{
			$sql = "UPDATE {$this->member_database} SET active = '1' WHERE login = ?";
			$query = $this->db->query($sql , array($login));
			
			if ($query) return TRUE;
			
			return FALSE;
		}
		
		return FALSE;
	}
	
	
	/**
	 * 寄信給使用者產生備用密碼的連結
	 * @param 
	 * 
	 */
	public function forget($login = FALSE)
	{
		if ($login == FALSE) return FALSE;
		
		if (!$this->member_exists($login)) return FALSE;
		
		$hash = md5(time() . $this->member_passwd_hash);
		
		$max_time = time() + 3600;
		
		$sql="UPDATE {$this->member_database} SET forget_hash_code = ? , forget_time = ? WHERE login = ?";
		$query = $this->db->query($sql , array($hash , $max_time , $login));
		
		
		$uri = site_url('member/forget_passwd/') . '?login=' . $login . '&hash=' . $hash;
		
		return $uri;
	}
	
	
	/**
	 * 寄信給使用者並且改掉使用者的密碼為暫時的密碼
	 * @param string $member_forget_hash
	 *
	 * @return boolean
	 */
	public function forget_passwd($login = FALSE , $hash = FALSE)
	{
		if (!$login || !$hash)
		{
			return FALSE;
		}
		
		$nowtime = time();
		
		$sql="SELECT * FROM {$this->member_database} WHERE login = ? AND forget_hash_code = ? AND forget_time > ?";
		$query = $this->db->query($sql , array($login , $hash , $nowtime));
		$member = $query->row();
		
		if (!$member)
		{
			return FALSE;
		}
		
		$new_pass = create_verify(8);
		$sql="UPDATE {$this->member_database} SET passwd = ? , forget_hash_code = '' , forget_time = 0 WHERE login = ?";
		$query = $this->db->query($sql , array(md5($new_pass . $this->member_passwd_hash) , $login));
		
		if ($query)
		{
			return $new_pass;
		}
		
		return FALSE;
	}
	
	
	/**
	 * 取得會員 (管理者)
	 *
	 */
	public function get_member_admin($key = FALSE)
	{
		if (!$key) return FALSE;
		
		$key_like = '%'.$key.'%';
		
		$sql = "SELECT * FROM {$this->member_database} WHERE id = ? OR login LIKE ? OR name LIKE ? OR phone LIKE ? OR mobile LIKE ? OR city LIKE ? OR country LIKE ? OR member_no LIKE ? OR fb_mail LIKE ?";
		$query = $this->db->query($sql , array($key , $key_like , $key_like , $key_like , $key_like , $key_like , $key_like , $key_like , $key_like));
		
		return $query->result();
	}
	
	/**
	 * 取得會員 (管理者)
	 *
	 */
	public function get_member_admin_verify()
	{
		$this->db->where('active' , 1);
		$this->db->where('admin_verify' , 0);
		$query = $this->db->get($this->member_database);
		
		return $query->result();
	}
	
	
	public function get_member_admin_verify_success()
	{
		$this->db->where('active' , 1);
		$this->db->where('admin_verify' , 1);
		$this->db->order_by('admin_verify_at' , 'desc');
		$this->db->limit(100 , 0);
		$query = $this->db->get($this->member_database);
		
		return $query->result();
	}
	
	
	public function get_member_admin_verify_false()
	{
		$this->db->where('active' , 1);
		$this->db->where('admin_verify' , -1);
		$this->db->order_by('admin_verify_at' , 'desc');
		$this->db->limit(100 , 0);
		$query = $this->db->get($this->member_database);
		
		return $query->result();
	}
	
	
	/**
	 * 改變會員狀態  (管理者)
	 *
	 */
	public function change_member_active_admin($id = FALSE , $active = FALSE)
	{
		if ($id === FALSE || $active === FALSE) return array('status' => 'F' , 'msg' => '錯誤的資訊');
		
		$id = (int) $id ;
		$active = (int) $active;
		
		if ($id === 0) return array('status' => 'F' , 'msg' => '錯誤的資訊');
		
		$sql = "UPDATE {$this->member_database} SET active = ? WHERE id = ? ";
		$query = $this->db->query($sql , array($active , $id));
		
		if ($query)
		{
			return array('status' => 'T' , 'msg' => '修改成功');
		}
		
		return array('status' => 'F' , 'msg' => '寫入資料失敗');
	}
	
	
	/**
	 * 會員補發密碼
	 *
	 */
	public function member_forget_passwd($id = FALSE)
	{
		if ($id === FALSE) return array('status' => 'F' , 'msg' => '錯誤的資訊');
		
		$id = (int) $id;
		
		return array('status' => 'F' , 'msg' => '寫入資料失敗');
	}
	
	
	/**
	 * 補發會員驗證信
	 *
	 */
	public function member_mail_verify($id = FALSE)
	{
		if ($id === FALSE) return array('status' => 'F' , 'msg' => '錯誤的資訊');
		
		$id = (int) $id;
		
		return array('status' => 'F' , 'msg' => '寫入資料失敗');
	}
	
	
	/**
	 * 寄送客服信件給會員
	 *
	 */
	public function member_contact_mail($id = FALSE)
	{
		if ($id === FALSE) return array('status' => 'F' , 'msg' => '錯誤的資訊');
		
		$id = (int) $id;
		
		return array('status' => 'F' , 'msg' => '寫入資料失敗');
	}
	
	
	/**
	 * 取得會員度數
	 *
	 */
	public function get_member_degree($id = FALSE)
	{
		if (!$id) return FALSE;
		
		$sql = "SELECT degree_left , degree_right FROM {$this->member_database} WHERE id = ?";
		$query = $this->db->query($sql , array($id));
		
		return $query->row();
	}
	
	
	/**
	 * 變更會員審核
	 *
	 */
	public function change_verify($member_id = FALSE , $active = 0)
	{
		$this->db->where('id' , $member_id);
		return $this->db->update($this->member_database , array('admin_verify' => $active , 'admin_verify_at' => date('Y-m-d H:i:s')));
	}
	
	
	public function create_member_no()
	{
		$query = $this->db->get('member_no');
		
		$row = $query->row();
		
		$now = $row!=FALSE?$row->nums:0;
		
		$now++;
		
		if ($row!=FALSE)
		{
			$this->db->update('member_no' , array('nums' => $now));
		}
		else
		{
			$this->db->insert('member_no' , array('nums' => $now));
		}
		
		if (strlen($now) <= 6)
		{
			$str = 'ON' . str_pad($now , 6 , '0' , STR_PAD_LEFT);
		}
		else
		{
			$str = 'ON' . str_pad($now , strlen($now) , '0' , STR_PAD_LEFT);
		}
		
		return $str;
	}
	
	
	public function get_one($id = FALSE)
	{
		$this->db->where('id' , $id);
		$query = $this->db->get($this->member_database);
		
		return $query->row();
	}
	
	
	public function get_list()
	{
		// $this->db->order_by('id' , 'desc');
		$this->db->limit(200 , 0);
		$query = $this->db->get($this->member_database);
		
		return $query->result();
	}
	
	
	/**
	 * 確認目前登入的帳號是否為FB帳號
	 * 來源：SESSION紀錄
	 * 系統帳號判定
	 */
	public function is_facebook()
	{
		$isfb = $this->session->userdata('is_facebook');
		
		if ($isfb) return TRUE;
		
		return FALSE;
	}
	
	
	/**
	 * @param string id
	 * @param string name
	 * @param string email
	 * 
	 */
	public function fb_get_one($id = FALSE , $name = FALSE , $email = FALSE)
	{
		// if ($id == FALSE || $name == FALSE || $email == FALSE) return FALSE;
		// if ($id == FALSE || $name == FALSE) return FALSE;
		
		$this->db->where('login' , $id);
		$this->db->where('name' , $name);
		// $this->db->where('fb_mail' , $email);
		$this->db->where('isfb' , 1);
		$query = $this->db->get($this->member_database);
		
		return $query->row();
	}
	
	
	/**
	 * FB登入會員
	 *
	 * @return js_go_msg()
	 */
	public function fb_login($id = FALSE , $name = FALSE , $email = FALSE)
	{
		// if ($id == FALSE || $name == FALSE || $email == FALSE) return FALSE;
		// if ($id == FALSE || $name == FALSE) return FALSE;
		
		$row = $this->fb_get_one($id , $name , $email);
		
		if ($row)
		{
			$time = $this->member_login_time_out;
			
			ini_set('session_cookie_lifetime' , $time);
			setcookie('PHPSESSID' , session_id() , time() + $time , '/');
			
			$session_data = array(
				'member_id' => $row->id,
				'member_login' => $row->login,
				'member_name' => $row->name,
				'member_hash' => md5($row->login . $row->name . $this->member_session_hash),
				'is_facebook' => $row->isfb
			);
			
			$this->session->set_userdata($session_data);
			
			return TRUE;
		}
		
		
		return FALSE;
	}
	
	public function fb_register($data = FALSE)
	{
		return $this->db->insert($this->member_database , $data);
	}
}

/* End of file Member_model.php */
/* Location: ./apps/models/Member_model.php */