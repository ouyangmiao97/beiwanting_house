<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_model extends CI_Model {
	/**
	 * Order Model
	 * 
	 * @package		: zh-tech
	 * @copyright	: zh-tech 振華科技
	 * @author		: Tone
	 * @depend		:
	 *
	 */
	private $setting_file = 'order_setting.json';
	
	/*
	private $default_setting = array(
		'shopping_cost_rule' => 7,//運費規則設定
		'free_shopping_cost' => 3000,//免運條件
		'free_shopping_cost_i' => 10000,//外島免運條件
		'free_shopping_cost_c' => 30000,//國際免運條件
		'shooping_cost' => 80,//本島運費
		'shooping_cost_i' => 300,//外島運費
		'shooping_cost_c' => 1000,//國際運費
		'invoice_rule' => 1,
		'invoice_group' => '財團法人創世社會福利基金會',
		'send_name' => '概念國際',
		'send_zip' => '10695',
		'send_address' => '台北市大安區光復南路456巷16-1號',
		'send_phone' => '0227037381',
		'send_mobile' => '0227037381',
	);
	*/

	private $default_setting = array(
		'shopping_cost_rule' => 7,//運費規則設定
		'free_shopping_cost' => 2000,//免運條件
		'free_shopping_cost_i' => 2000,//外島免運條件
		'free_shopping_cost_c' => 2000,//國際免運條件
		'shooping_cost' => 150,//本島運費
		'shooping_cost_i' => 150,//外島運費
		'shooping_cost_c' => 150,//國際運費
		'limit_150' => 1,//超過150cm不適用免運
		'invoice_rule' => 1,
		'invoice_group' => '財團法人創世社會福利基金會',
		'send_name' => '概念國際',
		'send_zip' => '10695',
		'send_address' => '台北市大安區光復南路456巷16-1號',
		'send_phone' => '0227037381',
		'send_mobile' => '0227037381',
	);	
	
	private $shopping_cost_rule = array(
		0 => '關閉所有運費(警告！這會讓所有運費機制關閉！)',
		1 => '僅本島',
		3 => '本島+外島',
		7 => '本島+外島+國際',
	);
	
	private $invoice_rule = array(
		0 => '不開放發票捐贈(發票會都寄給消費者)',
		1 => '依照下面設定捐贈(不強制，消費者依然可以選擇取得發票)',
		2 => '依照下面設定捐贈(強制，消費者只能捐贈發票)',
	);
	
	private $order_active_list = array(
		-2 => '金流交易失敗',
		-1 => '已退單(含退貨刪除)',
		0 => '未啟用' , 
		1 => '待付款' , 
		2 => '待出貨' , 
		3 => '已出貨' , 
		// 4 => '已到貨' , 	取消已到貨
		9 => '進貨中(到店取貨)' ,
		10 => '待取貨(到店取貨)' ,
		11 => '已取貨(到店取貨)' ,
	);
	
	//訂單預設欄位
	private $defaults = array(
		'id' => null ,
		'type' => 0,
		'store' => 0,
		'member_id' => FALSE,
		'member_login' => FALSE,
		'order_id' => FALSE,
		'payment_id' => '',	//payment產生的ID
		'active' => FALSE,
		'create_at' => FALSE,
		'order_contents' => FALSE,
		'total' => FALSE,
		'send_fun' => 1,
		'send_cost' => 0,
		'cost' => FALSE,
		'total_items' => FALSE,
		'pay_email' => '', 
		'pay_name' => FALSE,
		// 'pay_post_no' => FALSE,
		// 'pay_address' => FALSE,
		// 'pay_city' => '',
		// 'pay_country' => '',
		'pay_phone' => '',
		'pay_mobile' => '',
		'rec_email' => '',
		'rec_name' => FALSE,
		// 'rec_post_no' => FALSE,
		// 'rec_address' => FALSE,
		// 'rec_city' => '',
		// 'rec_country' => '',
		'rec_phone' => '',
		'rec_mobile' => '',
		'rec_time' => 0,
		'rec_memo' => '',
		'invoice_type' => 0,
		'copyies_torec' => 0,
		'invoice_uniform' => '',
		'invoice_title' => '',
	);
	
	
	//宅配運送時間表
	private $rec_time_list = array(
		1=>'9~12時',
		2=>'12~17時',
		3=>'17~20時',
		4=>'不限時',
		//5=>'20~21時', 特定區域固不開放
	);	
	
	
	//運送地區
	private $send_fun_list = array(
		1=>'本島',
		2=>'離島',
		4=>'國際',
	);
	
	
	//發票類型
	private $invoice_type_list = array(
		0=>'捐贈',
		1=>'二聯式',
		2=>'三聯式',
	);
	
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function __destruct()
	{
		
	}
	
	
	/**
	 * 取得訂單狀態列表
	 *
	 **/
	public function	get_order_active_list()
	{
		return $this->order_active_list;
	}
	
	
	/**
	 * 取得貨物送達時間列表
	 *
	 */
	public function get_rec_time_list()
	{
		return $this->rec_time_list;
	}
	
	
	/**
	 * 取得運送第區列表
	 *
	 */
	public function get_send_fun_list()
	{
		return $this->send_fun_list;
	}
	
	
	/**
	 * 取得發票類型列表
	 *
	 */
	public function get_invoice_type_list()
	{
		return $this->invoice_type_list;
	}
	
	public function get_one($id = FALSE)
	{
		if (!$id )return FALSE;
		
		$this->db->where('id' , $id );
		$query = $this->db->get('order');
		return $query->row();
	}
	
	
	/**
	 * 寫入設定檔
	 *
	 */
	public function insert_setting($data = array())
	{
		
		if (isset($data) && is_array($data) && count($data) > 0)
		{
			// while(list($key , $val) = each($data))
			// {
				//轉換全部值為數字
				// $data[$key] = (int) $val;
			// }
			
			$setting = get_cache($this->setting_file);
			
			if (!$setting)
			{
				$setting = $this->default_setting;
			}
			else
			{
				$setting = json_decode($setting , TRUE);
			}
			
			if (is_array($setting) && count($setting) > 0)
			{
				$setting_new = array();
				
				while(list($key , $val) = each($setting))
				{
					if (isset($data[$key]))
					{
						$setting_new[$key] = $data[$key];
					}
					else
					{
						$setting_new[$key] = $setting[$key];
					}
				}
				
				set_cache($this->setting_file , json_encode($setting_new));
				
				return TRUE;
				exit();
			}
			else
			{
				return FALSE;
				exit();
			}
			
			
		}
		
		return FALSE;
		exit();
	}
	
	
	/**
	 * 讀取設定檔
	 *
	 */
	public function read_setting()
	{
		$setting = get_cache($this->setting_file);
		
		if ($setting == FALSE)
		{
			return $this->default_setting;
		}
		
		$setting = json_decode($setting , TRUE);
		
		//補足設定檔未設定的部分
		while(list($key , $val) = each($this->default_setting))
		{
			if (isset($setting[$key]) == FALSE)
			{
				$setting[$key] = $val;
			}
		}
		
		return $setting;
	}
	
	
	/**
	 * 取得運費機制列表
	 *
	 */
	public function get_shopping_cost_rule()
	{
		return $this->shopping_cost_rule;
	}
	
	
	/**
	 * 取得發票機制列表
	 *
	 */
	public function get_invoice_rule()
	{
		return $this->invoice_rule;
	}
	
	
	public function get_order_all(){}
	
	public function get_order_one($order_id = FALSE)
	{
		if (FALSE == $order_id) return FALSE;
		
		$sql = "SELECT * FROM `order` WHERE order_id = ?";
		$query = $this->db->query($sql , array($order_id));
		
		if ($query)
		{
			return $query->row();
		}
		
		return FALSE;
		
	}
	
	public function get_order_one_by_payment_id($payment_id = FALSE)
	{
		if (FALSE == $payment_id) return FALSE;
		
		$sql = "SELECT * FROM `order` WHERE payment_id = ?";
		$query = $this->db->query($sql , array($payment_id));
		
		if ($query)
		{
			return $query->row();
		}
		
		return FALSE;
		
	}
	
	public function get_order_list($member_id = FALSE)
	{
		if (FALSE === $member_id) return array(FALSE , '參數錯誤，無法取得會員ID，錯誤代碼4001' , FALSE);
		
		$member_id = (int) $member_id;
		
		$sql = "SELECT * FROM `order` WHERE member_id = ? AND active > 0";
		$query = $this->db->query($sql , array($member_id));
		
		if ($query)
		{
			$result = $query->result();
			$query->free_result();
		}
		else
		{
			$result = FALSE;
		}
		
		if (is_array($result))
		{
			return array(TRUE , '' , $result);
		}
		
		return array(FALSE , '取得資料失敗，錯誤代碼4002' , FALSE);
		
	}
	
	public function get_my_order(){}
	
	public function add_order($data = array())
	{
		$order = array();
		
		if (FALSE == $data || !is_array($data))
		{
			return array(FALSE , '資料輸入錯誤，錯誤代碼6001' , FALSE);
		}
		
		if (isset($data['order_contents'])) 
		{
			$data['order_contents'] = json_encode($data['order_contents']);
		}
		
		while(list($key , $val) = each($this->defaults))
		{
			if (isset($data[$key]))
			{
				$order[$key] = $data[$key];
			}
			else
			{
				$order[$key] = $val;
			}
		}
		unset($data);
		
		
		//建立訂單基本資料
		$order['order_id'] = $this->make_order_id();
		
		if (!isset($order['active']))
		{
			$order['active'] = 0;
		}
		$order['create_at'] = date('Y-m-d H:i:s');
		
		
		//檢查必填欄位，並順便產生SQL字串
		$sql_set = array();
		while(list($key , $val) = each($order))
		{
			if (FALSE === $val)
			{
				return array(FALSE , '必填欄位未填寫，錯誤代碼6002' , FALSE);
			}
			else
			{
			$sql_set[] = " {$key} = ? ";
			}
		}
		
		$sql_set = implode(',' , $sql_set);
		
		$sql = "INSERT INTO `order` SET {$sql_set} ";
		$query = $this->db->query($sql , $order);
		
		$order['id'] = $this->db->insert_id();
		
		$obj_order = $this->get_one($order['id']);
		
		if ($query)
		{
			return array(TRUE , '訂單產生成功' , $obj_order);
		}
		
		return array(FALSE , '訂單寫入失敗，錯誤代碼6003' , FALSE);
	}

	public function edit($data = array())
	{
		$id = isset($data['id'])?$data['id']:FALSE;
		unset($data['id']);
		
		if (!$id) return FALSE;
		
		$this->db->where('id' , $id);
		return $this->db->update('order' , $data);
	}

	public function edit_order($data = array())
	{
		$order = array();
		
		if (FALSE == $data || !is_array($data))
		{
			return array(FALSE , '資料輸入錯誤，錯誤代碼6001' , FALSE);
		}
		
		$id = $data['id'];
		
		foreach($this->defaults as $key => $val)
		{
			if ($key != 'id')
			{
			
				if (isset($data[$key]))
				{
					$order[$key] = $data[$key];
				}
				else
				{
					$order[$key] = $val;
				}
				
			}
		}
		unset($data);
		
		//檢查必填欄位，並順便產生SQL字串
		$sql_set = array();
		// while(list($key , $val) = each($order))
		foreach($order as $key => $val)
		{
			if (FALSE === $val)
			{
				return array(FALSE , '必填欄位未填寫，錯誤代碼6002' , FALSE);
			}
			else
			{
				$sql_set[] = " {$key} = ? ";
			}
		}
		
		$sql_set = implode(',' , $sql_set);
		$order['id'] = $id;
		
		$sql = "UPDATE `order` SET {$sql_set} WHERE id = ? ";
		$query = $this->db->query($sql , $order);
		
		if ($query)
		{
			return array(TRUE , '訂單產生成功' , $order);
		}
		
		return array(FALSE , '訂單寫入失敗，錯誤代碼6003' , FALSE);
	}
	
	// 刪除訂單 實際上是變更狀態馬
	public function del_order($id = FALSE)
	{
		if (!$id) return FALSE;
		
		$this->db->where('id' , $id);
		
		if ($this->db->update('order' , array('active' => -1))) return TRUE;
		
		return FALSE;
	}
	
	/**
	 * 產生訂單編號
	 *
	 */
	public function make_order_id()
	{
		$sql = "SELECT ordernum FROM ordernum WHERE 1";
		$query = $this->db->query($sql);
		if ($query)
		{
			$row = $query->row();
			$query->free_result();
		}
		else
		{
			return FALSE;
		}
		
		$num = $row->ordernum;
		
		$sql = "UPDATE ordernum SET ordernum = ordernum + 1 WHERE 1";
		$query = $this->db->query($sql);
		
		unset($sql , $row , $query);
		
		return sprintf('e%s%s' , date('Ymd') , str_pad($num , 8 , '0' , STR_PAD_LEFT));
	}
	
	
	/**
	 * 歐付寶取號成功
	 *
	 */
	public function allpay_info_response($post = array())
	{	
		//因為ATM取號成功打API，所以payment_id並未記錄在order中，必須在此寫入
		$sql = "SELECT * FROM `payment` WHERE payment_id = ?";
		$query = $this->db->query($sql , array($post['MerchantTradeNo']));
		
		if (!$query) return FALSE;
		
		$payment = $query->row();
		
		//更新訂單狀態
		$sql = "UPDATE `order` SET active = 1 , payment_id = ? WHERE order_id = ?";
		$query = $this->db->query($sql , array($payment->payment_id , $payment->order_id));
		
		if ($query)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	
	/**
	 * 修改狀態
	 *
	 */
	public function change_order_active($payment_id = FALSE , $active = 0)
	{
		if ($payment_id == FALSE) return FALSE;
		
		$sql = "UPDATE `order` SET active = ? WHERE payment_id = ?";
		$query = $this->db->query($sql , array($active , $payment_id));
		
		if ($query)
		{
			return TRUE;
		}
		return FALSE;
	}
	
	
	/**
	 * 訂單查詢
	 *
	 */
	public function order_search($post = FALSE)
	{
		if (!$post) return array();
		
		if (!is_array($post)) return array();
		
		foreach($post as $key => $val)
		{
			if ($val === '') unset($post[$key]);
		}
		
		//允許的搜尋欄位
		$search_array = array(
			'order_active' , 'payment_active' , 'order_id' , 'payment_id' , 'trade_no' , 'order_create_date_start' , 'order_create_date_end' , 'pay_date_start' , 'pay_date_end' , 'send_id' , 'booking_note' , 'invoice_no' , 'member_login'
		);
		
		$data = array();
		
		foreach($search_array as $key => $field)
		{
			if (isset($post[$field]))
			{
				$data[$field] = $post[$field];
			}
		}
		
		//檢查資料
		if (isset($data['order_create_date_start']) && !isset($data['order_create_date_end']))
		{
			return '未填寫訂單結束日期';
		}
		
		if (isset($data['order_create_date_end']) && !isset($data['order_create_date_start']))
		{
			return '未填寫訂單開始日期';
		}
		
		if (isset($data['pay_date_start']) && !isset($data['pay_date_end']))
		{
			return '未填寫付款結束日期';
		}
		
		if (isset($data['pay_date_start']) && !isset($data['pay_date_end']))
		{
			return '未填寫付款開始日期';
		}
		
		$sql_where = array();
		
		while(list($key , $val) = each($data))
		{
			$data[$key] = $this->db->escape_str($val);
		}
		
		if (isset($data['order_active']) && $data['order_active'] != 99)
		{
			$data['order_active'] = (int) $data['order_active'];
			
			$sql_where[] = "oo.active = '{$data['order_active']}'";
		}
		
		if (isset($data['payment_active']) && $data['payment_active'] != 99)
		{
			$data['payment_active'] = (int) $data['payment_active'];
			
			$sql_where[] = "pp.active = '{$data['payment_active']}'";
		}
		
		if (isset($data['order_id']))
		{
			
			$sql_where[] = "oo.order_id = '{$data['order_id']}'";
		}
		
		if (isset($data['payment_id']))
		{		
			$sql_where[] = "pp.payment_id = '{$data['payment_id']}'";
		}
		
		if (isset($data['trade_no']))
		{
			$sql_where[] = "pp.trade_no = '{$data['trade_no']}'";
		}
		
		if (isset($data['booking_note']))
		{
			$sql_where[] = "pp.booking_note = '{$data['booking_note']}'";
		}
		
		if (isset($data['send_id']))
		{
			$sql_where[] = "pp.send_id = '{$data['send_id']}'";
		}
		
		if (isset($data['invoice_no']))
		{
			$sql_where[] = "pp.invoice_no = '{$data['invoice_no']}'";
		}
		
		if (isset($data['member_login']))
		{
			$sql_where[] = "oo.member_login = '{$data['member_login']}'";
		}
		
		if (isset($data['order_create_date_start']) && isset($data['order_create_date_end']))
		{			
			$sql_where [] = "oo.create_at > '{$data['order_create_date_start']}' AND oo.create_at > '{$data['order_create_date_end']}'";
		}
		
		if (isset($data['pay_date_start']) && isset($data['pay_date_end']))
		{
			$sql_where [] = "pp.create_at > '{$data['pay_date_start']}' AND pp.create_at > '{$data['pay_date_end']}'";
		}
		
		if (sizeof($sql_where) == 0)
		{
			return array();
		}
		
		$sql_where = implode(' AND ' , $sql_where);
		
		$sql = "SELECT oo.order_id , pp.payment_id , pp.trade_no , oo.active as order_active , pp.active as payment_active FROM `order` as oo LEFT JOIN `payment` as pp ON oo.order_id = pp.order_id WHERE {$sql_where} ORDER BY oo.create_at";
		
		$query = $this->db->query($sql);
		
		if ($query)
		{
			return $query->result();
		}
		
		return array();
	}
}

/* End of file Order_model.php */
/* Location: ./apps/models/Order_model.php */