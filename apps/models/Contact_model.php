<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_model extends CI_Model {
	/**
	 * Contact Model
	 * 
	 * @package		: zh-tech
	 * @copyright	: zh-tech 振華科技
	 * @author		: Tone
	 * @depend		: mail_model、admin databaes、admin_group database
	 *
	 */
	
	// 當收到新的客服需求，是否寄信給管理者通知
	private $mail_send = TRUE;
	
	// 設定客服需求的資料庫表名
	private $contact_database = 'contact';
	
	// 設定管理者的資料庫表名
	private $admin_database = 'admin';
	
	// 管理者群組的資料庫表名
	private $admin_group_database = 'admin_group';
	
	// 客服訊息種類
	public $contact_type = array(
		0=>'聯絡我們',
		1=>'商品問答',
		2=>'訂單問答',
	);
	
	// 預設資料
	private $defaults = array(
		'id' => '',
		'active' => 0,
		'order_id' => '',
		'product_id' => 0,
		'type' => 0,
		'title' => '',
		'pid' => '',
		'ptitle' => '',
		'service_point' => 0,
		'user_name' => '',
		'user_phone' => '',
		'user_mail' => '',
		'memo' => '',
		'reservation_at' => '', // Y-m-d
		'create_at' => '', // Y-m-d H:i:s
		'ip' => '',
		'request_log' => '',
		'user_agent' => '',
		'reply' => '',
		'mid' => 0,
	);
	
	
	/**
	 * 建構式
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		
		// 載入main model
		if ($this->mail_send) $this->load->model('mail_model');
	}
	
	
	public function __destruct()
	{
		
	}
	
	
	/**
	 * 設定預設資料
	 *
	 */
	private function _set_default()
	{
		$this->load->library('user_agent');
		
		$this->defaults['create_at'] = date('Y-m-d H:i:s');
		
		$this->defaults['user_agent'] = $this->agent->agent_string();
		
		$this->defaults['ip'] = $this->input->ip_address();
		
		$this->defaults['request_log'] = json_encode($_SERVER);
	}
	
	
	/**
	 * 檢查必填資料
	 *
	 */
	private function _check_data_field($data = FALSE)
	{
		if (!$data) return array(FALSE , '資料錯誤');
		
		switch($data['type'])
		{
			case 0:
				if ($data['user_name'] == FALSE) return array(FALSE , '請填寫姓名');
				if ($data['user_mail'] == FALSE) return array(FALSE , '請填寫電子郵件信箱');
				if ($data['memo'] == FALSE) return array(FALSE , '請填寫問題內容');
				// if ($data['user_phone'] == FALSE && $data['user_mail'] == FALSE) return array(FALSE , '信箱與聯絡電話請至少擇一填寫');
			break;
			case 1:
				// if ($data['product_id'] == FALSE) return array(FALSE , '錯誤的產品ID');
			break;
			case 2:
				// if ($data['order_id'] == FALSE) return array(FALSE , '錯誤的訂單ID');
			break;
			default:
				// return array(FALSE , '無效的分類');
			break;
		}	
		
		return array(TRUE , '');
	}
	
	
	/**
	 * 取得客服列表
	 *
	 */
	public function get_contact_list($show_all = TRUE , $type = 0 , $active = 0 , $rule = '>=')
	{
		if ($show_all)
		{
			$sql = "SELECT * FROM {$this->contact_database} WHERE active {$rule} ? ORDER BY create_at DESC";
			$query = $this->db->query($sql , array($active));
		}
		else
		{
			$sql = "SELECT * FROM {$this->contact_database} WHERE type = ? AND active {$rule} ? ORDER BY create_at DESC";
			$query = $this->db->query($sql , array($type , $active));
		}
		
		$result = $query->result();
		
		$query->free_result();
		
		return $result;
	}
	
	
	/**
	 * 取得某訂單的問答資料
	 *
	 */
	public function get_contact_list_by_order_id($order_id = FALSE , $member_id = FALSE)
	{
		if ($order_id == FALSE || $member_id == FALSE) return FALSE;
		
		$sql = "SELECT * FROM {$this->contact_database} WHERE active >= 0 AND order_id = ? AND mid = ?";
		$query = $this->db->query($sql , array($order_id , $member_id));
		
		if ($query)
		{
			return $query->result();
		}
		
		return FALSE;
	}
	
	
	/**
	 * 取得用戶的問答
	 *
	 */
	public function get_member_contact($mid = FALSE , $page = 0 , $limit = 20)
	{
		if (!$mid) return FALSE;
		
		$start = $page * $limit;
		
		$sql = "SELECT * FROM {$this->contact_database} WHERE mid = ?  ORDER BY create_at DESC LIMIT ? , ?";
		$query = $this->db->query($sql , array($mid , $page , $limit));
		
		return $query->result();
	}
	
	
	/**
	 * 取得單筆的問答
	 *
	 */
	public function get_member_contact_one($mid = FALSE , $qaid = FALSE)
	{
		if (!$mid || !$qaid) return FALSE;
		
		$sql = "SELECT * FROM {$this->contact_database} WHERE id = ? AND mid = ?";
		$query = $this->db->query($sql , array($qaid , $mid));
		
		return $query->row();
	}
	
	
	/**
	 * 取得客服發問紀錄
	 *
	 *
	 */
	public function get_contact_by_pid($id = FALSE)
	{
		$sql = "SELECT * FROM {$this->contact_database} WHERE product_id = ?";
		$query = $this->db->query($sql , array($id));
		
		return $query->result();
	}
	
	
	/**
	 * 取得未處理客服
	 *
	 */
	public function get_contact_process_list($show_all = TRUE , $type = 0)
	{		
		return $this->get_contact_list($show_all , $type , 0 , '=');
	}
	
	
	/**
	 * 取得單筆客服
	 *
	 */
	public function get_contact_one($id = FALSE , $active = 0 , $rule = '>=')
	{
		if (!$id) return FALSE;
		
		$sql = "SELECT * FROM {$this->contact_database} WHERE id = ? AND active {$rule} ?";
		$query = $this->db->query($sql , array($id , $active));
		
		$row = $query->row();
		
		$row->memo = back_space_and_br($row->memo);
		$row->reply = back_space_and_br($row->reply);
		
		return $row;
	}
	
	
	/**
	 * 新增客服紀錄
	 *
	 */
	public function add_contact($data = FALSE)
	{
		if (!$data || !is_array($data)) return array('status' => 'F' , 'msg' => '資料錯誤');
		
		// 設定預設資料的初始值
		$this->_set_default();
		
		$sql_data = array();
		
		foreach($this->defaults as $key => $val)
		{
			if ($key != 'id')
			{
				if (isset($data[$key]))
				{
					$sql_data[$key] = $data[$key];
				}
				else
				{
					$sql_data[$key] = $val;
				}
			}
		}
		
		$sql_data['memo'] = windowsbr_to_unixbr($sql_data['memo']);
		
		foreach($sql_data as $key => $val)
		{
			$sql_data[$key] = html_escape($sql_data[$key]);
		}
		
		if (isset($this->front->is_login) && $this->front->is_login != FALSE)
		{
			//here to do login info
			$member = $this->member_model->get_member_by_login($this->front->member_login);
			
			$sql_data['mid'] = $member->id;
			$sql_data['user_name'] = $member->name;
			$sql_data['user_phone'] = sprintf('phone:%s mobile:%s' , $member->phone , $member->mobile);
			$sql_data['user_mail'] = $member->login;
		}
		
		list($status , $msg) = $this->_check_data_field($sql_data);
		
		if ($status == FALSE) return array('status' => 'F' , 'msg' => $msg);
		
		$sql_set = '';
		$sql_set_ary = array();
		
		foreach($sql_data as $key => $row)
		{
			array_push($sql_set_ary , $key . ' = ? ');
		}
		
		$sql_set = implode(' , ' , $sql_set_ary);
		unset($sql_set_ary);
		
		$sql = "INSERT INTO {$this->contact_database} SET {$sql_set}";
		$query = $this->db->query($sql , $sql_data);
		
		$insert_id = $this->db->insert_id();
		
		if ($query)
		{
			//信件寄送
			if ($this->mail_send)
			{
				//建立信件標題
				$subject = sprintf("%s-%s通知" , config_item('site') , $this->contact_type[$data['type']]);
				
				// 寄信對象先以測試帳號，記得改回所有人
				$mailto = $this->get_admin_mail($data);
				
				//載入客服資料至front
				$this->front->contact = $this->get_contact_one($insert_id);
				
				//取的信件template
				switch($data['type'])
				{
					case 0:
						$template = $this->load->view('member/mail_contact' , $this->front , TRUE);
					break;
					case 1:
						$template = $this->load->view('member/mail_contact_product' , $this->front , TRUE);
					break;
					case 2:
						$template = $this->load->view('member/mail_contact_order' , $this->front , TRUE);
					break;
				}
				
				$reply = '';
				
				$send = @$this->mail_model->send( $mailto , $subject , $template);
			}
			
			return array('status' => 'T' , 'msg' => '再次感謝您的愛護與支持，我們已收到您的訊息！我們會盡快處理！');
		}
		
		return array('status' => 'F' , 'msg' => '資料寫入失敗');
	}
	
	
	/**
	 * 修改客服
	 *
	 */
	public function edit_contact()	{}
	
	
	/**
	 * 回覆客服
	 *
	 */
	public function reply_contact($id = FALSE , $msg = '')
	{
		if (!$id) return array('status' => 'F' , 'msg' => '錯誤的ID');
		
		$reply_at = date('Y-m-d H:i:s');
		
		$sql = "UPDATE {$this->contact_database} SET reply = ? , reply_at = ? WHERE id = ? ";
		$query = $this->db->query($sql , array($msg , $reply_at , $id));
		
		if ($query)
		{
			//信件寄送
			if ($this->mail_send)
			{
				$contact = $this->get_contact_one($id);
				
				if (!$contact->user_mail)
				{
					$this->change_contact_active($id , 1);
					return array('status' => 'T' , 'msg' => '系統資料已更新，但找不到電子郵件地址，所以並未發送郵件');
				}
				
				// 寄信對象為留下客服的人
				$mailto = sprintf('%s<%s>' , $contact->user_name , $contact->user_mail);
				
				//載入客服資料至front
				$this->front->contact = $contact;
				
				//載入所需資料至front
				switch($contact->type)
				{
					case 0:
						
					break;
					case 1:
						//載入產品資料至front
						$this->load->model('product_model');
						$this->front->product = $this->product_model->get_product_one($contact->pid);
					break;
					case 2:
						$this->load->model('order_model');
					break;
				}
				
				//載入信件類型至front
				$this->front->mail_type = $this->contact_type[$contact->type];
				
				//取的信件template
				$template = $this->load->view('member/mail_reply' , $this->front , TRUE);
				
				$send = @$this->mail_model->send( $mailto , 'WEFOX客服通知信件' , $template);
				
				if ($send)
				{
					$this->change_contact_active($id , 1);
					return array('status' => 'T' , 'msg' => '系統資料已更新，並且已寄出信件至用戶信箱');
				}
				else
				{
					$this->change_contact_active($id , 1);
					return array('status' => 'T' , 'msg' => '系統資料已更新，但寄件失敗，故未寄出信件');
				}
			}
			
			$this->change_contact_active($id , 1);
			return array('status' => 'T' , 'msg' => '系統資料已更新，因系統設定故未發送信件至用戶信箱');
		}
		
		return array('status' => 'F' , 'msg' => '客服資料寫入失敗');
	}
	
	
	/**
	 * 刪除客服
	 *
	 */
	public function del_contact($id = FALSE)
	{
		if (!$id) return array('status' => 'F' , 'msg' => '缺少必要資訊');
		
		$sql = "DELETE FROM {$this->contact_database} WHERE id = ? ";
		$query = $this->db->query($sql , array($id));
		
		if ($query)
			return array('status' => 'T' , 'msg' => '刪除成功');
		
		return array('status' => 'F' , 'msg' => '寫入資料失敗');
	}
	
	
	/**
	 * 改變客服請求的狀態
	 * 
	 */
	public function change_contact_active($id = FALSE , $active = 0)
	{
		$id = (int) $id;
		$active = (int) $active ;
		
		if (!$id) return array('status' => 'F' , 'msg' => '修改失敗');
		
		$sql = "UPDATE {$this->contact_database} SET active = ?  WHERE id = ?";
		$query = $this->db->query($sql , array($active , $id));
		
		if ($query)
			return array('status' => 'T' , 'msg' => '修改成功');
		
		return array('status' => 'F' , 'msg' => '修改失敗');
	}
	
	
	/**
	 * 取得管理者信箱
	 *
	 */
	public function get_admin_mail($data = FALSE)
	{
		// return 'Tone<tone2314@gmail.com>';
	
		$sql = "SELECT * FROM `admin` WHERE 1";
		$query = $this->db->query($sql);
		
		if (!$query)
		{
			return 'stewardlin<stewardlin1688@gmail.com>';
		}
		
		$result = $query->result();
		
		$tmp_ary = array();
		
		foreach($result as $key => $row)
		{
			if ($row->email != FALSE)
			{
				$tmp_ary[] = $row->name . '<' . $row->email . '>';
			}
		}
		
		return implode(',' , $tmp_ary);
	}
}

/* End of file Contact_model.php */
/* Location: ./apps/models/Contact_model.php */