<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Payment_model extends CI_Model {
	/**
	 * 振華 Payment Model
	 * 
	 * @copyright	: zh-tech 振華科技
	 * @author		: Tone
	 * @version		: 1.0
	 * @update 		: 2016/03/14
	 * @depend		: 
	 */
	
	/** 
	 * 2016/03/14
	 * 為避免重工，此model隨lulu專案一同使用，不僅僅以allpay為唯一付費方式
	 * 開發時應注意相容性與延展性
	 *
	 *
	 */
	private $payment_type_list = array();
	
	private $payment_log_title = '[ZHTECH PAYMENT]';
	
	private $_log_ext = 'php';
	
	private $_date_fmt = 'Y-m-d H:i:s';
	
	private $_file_permissions = 0644;
	
	private $_log_type = 'payment';
	
	private $defaults = array(
		'id' => null , 
		'member_id' => FALSE , 
		'member_login' => FALSE ,
		'return_url' => '' , 
		'client_back_url' => '' ,
		'order_result_url' => '' ,
		'merchant_trade_no' => '' , 
		'merchant_trade_date' => '' ,
		'total_amount' => '' , 
		'trade_desc' => '' ,
		'choose_payment' => '' ,
		'remark' => '' ,
		'choose_sub_payment' => '' ,
		'payment_id' => FALSE ,
		'order_id' => FALSE ,
		'active' => FALSE ,
		'create_at' => FALSE , 
		'payment_memo' => '' ,
		'payment_type' => '' ,
	);	
	
	private $payment_active_list = array(
		-4 => '交易失敗',
		-3 => '已刪除',
		-2 => '已退貨退款',
		-1 => '已退單',
		0 => '未啟用(等待金流回覆)',
		1 => '未付款',
		2 => '已逾時',
		3 => '模擬付款(本站)',
		4 => '模擬付款(金流)',
		5 => '已付款',
	);
	
	
	//歐付寶測試帳號
	private $all_pay_user = array(
		'ServiceURL' => 'http://payment-stage.allpay.com.tw/Cashier/AioCheckOut',
		'HashKey' => '5294y06JbISpM5x9',
		'HashIV' => 'v77hoKGq4kWxNNIS',
		'MerchantID' => '2000132',
	);
	
	
	//歐付寶實際上線帳號 eyelens
	// private $all_pay_user = array(
		// 'ServiceURL' => 'http://payment.allpay.com.tw/Cashier/AioCheckOut',
		// 'HashKey' => 'ToTXi7XFNNxoyiuX',
		// 'HashIV' => 'ipDLkARkmqnIOuEW',
		// 'MerchantID' => '1238426',
	// );
	
	public function __construct()
	{
		parent::__construct();
		
		//初始化config檔案
		$this->initialize_config();

	}
	
	
	public function __destruct()
	{
		
	}
	
	
	public function get_payment_active_list()
	{
		return $this->payment_active_list;
	}
	
	
	/**
	 * 歐付寶確認店家ID
	 * @param string $merchant_id
	 *
	 * @retunr bool
	 */
	public function is_merchant($merchant_id = FALSE)
	{
		if ( ! $merchant_id) return FALSE;
		
		if ($this->all_pay_user['MerchantID'] === $merchant_id) return TRUE;
		
		return FALSE;
	}
	
	
	/**
	 * 初始化config檔案
	 *
	 */
	public function initialize_config()
	{
		if (FALSE == $this->load->config('payment'))
		{
			$this->log_message('error' , 'can not load payment.php config.' , 'ci_log');
			return FALSE;
		}
		
		if (FALSE === function_exists('config_item'))
		{
			$this->log_message('error' , 'config_item() can not found this function.' , 'ci_log');
			return FALSE;
		}
		
		$this->payment_type_list = config_item('zhtech_payment_list');
		
		if ( ! is_array($this->payment_type_list))
		{
			$this->log_message('error' , 'can not load payment_type_list.' , 'ci_log');
			return FALSE;
		}
	}
	
	
	/**
	 * 紀錄Log檔
	 * @param string $level log_level 
	 */
	public function log_message($level = 'error' , $msg = FALSE , $mode = FALSE)
	{
		if (FALSE == $msg) return FALSE;
		
		if (FALSE === $mode && defined('ZHTECH_PAYMENT_DEBUG_LOG_MODE')) $mode = ZHTECH_PAYMENT_DEBUG_LOG_MODE;
		
		$msg = $this->payment_log_title . $msg;

		switch($mode)
		{
			case 'ci_log':
				return log_message($level , $msg);
			break;
			case 'zhtech_log':
				//自己寫獨立的log檔，不要與CI共用
				//參照CI log檔寫法
				$level = strtoupper($level);
				
				$filepath = defined('ZHTECH_PAYMENT_DEBUG_LOG_PATH')?APPPATH . ZHTECH_PAYMENT_DEBUG_LOG_PATH: APPPATH.'logs/';
				$filepath .= $this->_log_type . '-'.date('Y-m-d').'.'.$this->_log_ext;
				
				$message = '';
				
				if ( FALSE == file_exists($filepath))
				{
					$newfile = TRUE;
					if ($this->_log_ext == 'php')
					{
						$message .= "<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>\n\n";
					}
				}
				
				if (! $fp = @fopen($filepath , 'ab'))
				{
					return FALSE;
				}
				
				// Instantiating DateTime with microseconds appended to initial date is needed for proper support of this format
				if (strpos($this->_date_fmt, 'u') !== FALSE)
				{
					$microtime_full = microtime(TRUE);
					$microtime_short = sprintf("%06d", ($microtime_full - floor($microtime_full)) * 1000000);
					$date = new DateTime(date('Y-m-d H:i:s.'.$microtime_short, $microtime_full));
					$date = $date->format($this->_date_fmt);
				}
				else
				{
					$date = date($this->_date_fmt);
				}
				
				$message .= $level.' - '.$date.' --> '.$msg."\n";
				
				flock($fp, LOCK_EX);
				
				for ($written = 0, $length = strlen($message); $written < $length; $written += $result)
				{
					if (($result = fwrite($fp, substr($message, $written))) === FALSE)
					{
						break;
					}
				}
			
				flock($fp, LOCK_UN);
				fclose($fp);

				if (isset($newfile) && $newfile === TRUE)
				{
					chmod($filepath, $this->_file_permissions);
				}

				return is_int($result);
				
			break;
			case FALSE:
				return FALSE;
			break;
		}
		
		return FALSE;
	}
	
	
	/**
	 * 取得單筆
	 *
	 */
	public function get_payment_one($payment_id = FALSE)
	{
		if (!$payment_id) return FALSE;
		
		$sql = "SELECT * FROM `payment` WHERE payment_id = ?";
		$query = $this->db->query($sql , array($payment_id));
		
		if ($query)
		{
			return $query->row();
		}
		
		return FALSE;
	}
	
	
	public function get_payment_one_by_order_id($order_id = FALSE)
	{
		if (!$order_id) return FALSE;
		
		$sql = "SELECT * FROM `payment` WHERE order_id = ?";
		$query = $this->db->query($sql , array($order_id));
		
		if ($query)
		{
			return $query->row();
		}
		
		return FALSE;
	}
	
	
	/**
	 * 修改狀態
	 *
	 */
	public function change_payment_active($payment_id = FALSE , $active = 0)
	{
		if ($payment_id == FALSE) return FALSE;
		
		$sql = "UPDATE `payment` SET active = ? WHERE payment_id = ?";
		$query = $this->db->query($sql , array($active , $payment_id));
		
		if ($query)
		{
			return TRUE;
		}
		return FALSE;
	}
	
	
	/**
	 * 發送付費請求
	 *
	 */
	public function pay($data = array() , $payment_type = FALSE , $sub_payment = FALSE ,  $post = TRUE)
	{
		//資料檢查
		
		$this->load->library('cart');
		
		if( FALSE == $payment_type)
		{
			$this->log_message('error' , 'payment type is FALSE . ');
			return array(FALSE , '未輸入付費方式，錯誤代碼6101' , FALSE);
		}
		
		if ( FALSE == array_key_exists($payment_type , $this->payment_type_list))
		{
			$this->log_message('error' , 'unknow payment type');
			return array(FALSE , '未知的付費方式，錯誤代碼6101' , FALSE);
		}
		
		$data['payment_id'] = $this->make_payment_id();
		
		if (TRUE === ZHTECH_PAYMENT_DEBUG_AUTO_MODE)
		{
			//測試模擬
			$payment = $this->defaults;
				
			$payment['member_id'] = $data['member_id'];
			$payment['member_login'] = $data['member_login'];
			$payment['payment_id'] = $data['payment_id'];
			$payment['order_id'] = $data['order_id'];
			$payment['merchant_trade_no'] = $data['order_id'];//
			$payment['active'] = 3;	//模擬付款成功是3
			$payment['create_at'] = date('Y-m-d H:i:s');
			$payment['payment_type'] = $payment_type;
			$payment['choose_sub_payment'] = $sub_payment;
			$payment['merchant_trade_date'] = date('Y-m-d H:i:s');
			$payment['total_amount'] = $data['total'];
			$payment['trade_desc'] = 'ZHTECH模擬測試';
			$payment['remark'] = $data['rec_memo'];
			$payment['choose_payment'] = 'ZHTECH模擬測試';
			
			$sql_set = array();
			while(list($key , $val) = each($payment))
			{
				$sql_set[] = " {$key} = ? ";
			}
			
			$sql_set = implode(',' , $sql_set);
			
			
			$sql = "INSERT INTO payment SET {$sql_set}";
			$query = $this->db->query($sql , $payment);
			
			if ($query)
			{
				return array(TRUE , '金流模擬交易成功' , $payment);
			}
			
			$this->log_message('error' , '資料寫入失敗，錯誤代碼6102');
			return array(FALSE , '資料寫入失敗，錯誤代碼6102' , FALSE);
			exit();
		}
		
		//資料檢查與建立訂單
		
		switch($payment_type)
		{
			case 1:
				//AllPay
				
				try{
				
				include_once(APPPATH . '/libraries/AllPay.Payment.Integration.php');
				
				
				//建立付款payment
				$payment = $this->defaults;
				
				$this->load->library('user_agent');
				
				$payment['member_id'] = $data['member_id'];
				$payment['member_login'] = $data['member_login'];
				$payment['payment_id'] = $data['payment_id'];
				$payment['order_id'] = $data['order_id'];
				$payment['active'] = 0;	//先建立 取號成功後再改為1
				$payment['merchant_trade_no'] = $data['payment_id'];//同payment_id
				$payment['merchant_trade_date'] = date('Y/m/d H:i:s');
				$payment['total_amount'] = $data['total'];
				$payment['trade_desc'] = '於eyelens上使用ATM付款方式購買';
				$payment['choose_payment'] = PaymentMethod::ATM;
				$payment['remark'] = $data['rec_memo'];
				$payment['choose_sub_payment'] = PaymentMethodItem::None;
				$payment['need_extra_paidinfo'] = ExtraPaymentInfo::Yes;
				
				if ($this->agent->is_mobile())
				{
					$payment['device_source'] = DeviceType::Mobile;
				}
				else
				{
					$payment['device_source'] = DeviceType::PC;
				}
				
				$payment['create_at'] = date('Y-m-d H:i:s');
				$payment['payment_type'] = $payment_type;
				$payment['return_url'] = site_url('/api/allpay_response');
				$payment['client_back_url'] = site_url('/member/pay5');
				$payment['order_result_url'] = '';
				
				$sql_set = array();
				
				while(list($key , $val) = each($payment))
				{
					$sql_set[] = " {$key} = ? ";
				}
				
				$sql_set = implode(',' , $sql_set);
				
				
				$sql = "INSERT INTO payment SET {$sql_set}";
				$query = $this->db->query($sql , $payment);
				
				if (!$query)
				{
					$this->log_message('error' , '金流交易失敗，建立付款資料時失敗，錯誤代碼6102');
					return array(FALSE , '金流交易失敗，建立付款資料時失敗，錯誤代碼6102' , FALSE);
					exit();
				}
				
				$oPayment = new AllInOne();
				
				$oPayment->ServiceURL = $this->all_pay_user['ServiceURL'];
				$oPayment->HashKey = $this->all_pay_user['HashKey'];
				$oPayment->HashIV = $this->all_pay_user['HashIV'];
				$oPayment->MerchantID = $this->all_pay_user['MerchantID'];	
				
				$oPayment->Send['ReturnURL'] = $payment['return_url'];
				$oPayment->Send['ClientBackURL'] = $payment['client_back_url'];
				// $oPayment->Send['OrderResultURL'] = site_url('/member/pay5');
				$oPayment->Send['MerchantTradeNo'] = $payment['merchant_trade_no'];
				$oPayment->Send['MerchantTradeDate'] = $payment['merchant_trade_date'];
				$oPayment->Send['TotalAmount'] = $payment['total_amount'];
				$oPayment->Send['TradeDesc'] = $payment['trade_desc'];
				$oPayment->Send['ChoosePayment'] = $payment['choose_payment'];
				$oPayment->Send['Remark'] = $payment['remark'];
				$oPayment->Send['ChooseSubPayment'] = $payment['choose_sub_payment'];
				$oPayment->Send['NeedExtraPaidInfo'] = $payment['need_extra_paidinfo'];
				$oPayment->Send['DeviceSource'] = $payment['device_source'];
				
				$order_contents = json_decode($data['order_contents'] , TRUE);
				
				$oPayment->Send['Items'] = array();
				
				foreach($order_contents as $key => $row)
				{
					$tmp = array();
					
					$tmp['Name'] = $row['options']['name'];
					$tmp['Price'] = $row['price'];
					$tmp['Currency'] = '元';
					$tmp['Quantity'] = $row['qty'];
					$tmp['URL'] = site_url();
					
					$oPayment->Send['Items'][] = $tmp;
				}
				
				if ($data['send_cost'] > 0)
				{
					$tmp = array();
					
					$tmp['Name'] = "運費";
					$tmp['Price'] = $data['send_cost'];
					$tmp['Currency'] = '元';
					$tmp['Quantity'] = 1;
					$tmp['URL'] = '';
					
					$oPayment->Send['Items'][] = $tmp;
				}
				
				$oPayment->SendExtend['ExpireDate'] = 5;
				$oPayment->SendExtend['PaymentInfoURL'] = site_url('/api/allpay_info_response');
				
				$this->cart->destroy();
				
				$oPayment->CheckOut();
				$szHtml = $oPayment->CheckOutString();
				
				echo $szHtml;
				exit();
				
				return array(TRUE , '成功' , FALSE);
				
				}
				catch(Exception $e)
				{
					//例外處理錯誤
					$this->log_message('error' , '傳送歐付寶金流時發生例外錯誤，錯誤代碼：9999');
					$this->log_message('error' , json_encode($e->getMessage()));
					
					return array(FALSE , '例外的錯誤，錯誤代碼9999' , FALSE);
				}
				
			break;
		}
		
	}
	
	
	/**
	 * 產生付款編號
	 *
	 */
	public function make_payment_id()
	{
		$sql = "SELECT paymentnum FROM paymentnum WHERE 1";
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
		
		$num = $row->paymentnum;
		
		$sql = "UPDATE paymentnum SET paymentnum = paymentnum + 1 WHERE 1";
		$query = $this->db->query($sql);
		
		unset($sql , $row , $query);
		
		return sprintf('p%s%s' , date('Ymd') , str_pad($num , 8 , '0' , STR_PAD_LEFT));
	}
	
	
	/**
	 * 歐付寶取號成功
	 *
	 */
	public function allpay_info_response($post = array())
	{
		//將取號資訊寫入付費紀錄中，並且更新付費紀錄狀態
		$sql = "UPDATE `payment` SET active = 1 , trade_no = ? , trade_date = ? , api_response_date = ? , bank_code = ? , v_account = ? , pay_expire_date = ? WHERE payment_id = ?";
		$query = $this->db->query($sql , array($post['TradeNo'] , $post['TradeDate'] , date('Y-m-d H:i:s') , $post['BankCode'] , $post['vAccount'] , $post['ExpireDate'] , $post['MerchantTradeNo']));
		
		if ($query)
		{
			return TRUE;
		}
		return FALSE;
	}
	
	
	/**
	 * 取回歐付寶回傳的資訊
	 *
	 */
	public function get_feedback_data()
	{
		include_once(APPPATH . '/libraries/AllPay.Payment.Integration.php');
		
		$oPayment = new AllInOne();
		
		$oPayment->ServiceURL = $this->all_pay_user['ServiceURL'];
		$oPayment->HashKey = $this->all_pay_user['HashKey'];
		$oPayment->HashIV = $this->all_pay_user['HashIV'];
		$oPayment->MerchantID = $this->all_pay_user['MerchantID'];
		
		$arFeedback = $oPayment->CheckOutFeedback();
		if (sizeof($arFeedback) > 0)
		{
			$post = array();
			
			while(list($key , $val) = each($arFeedback))
			{
				$post[$key] = $val;
			}
			
			return $post;
		}
		else
		{
			return array();
		}
	}
	
	
	/**
	 * 紀錄歐付寶交易回傳的資料
	 *
	 */
	public function insert_allpay_response($data = array())
	{
		if (!isset($data['MerchantID'])) $data['MerchantID'] = '';
		if (!isset($data['MerchantTradeNo'])) $data['MerchantTradeNo'] = '';
		if (!isset($data['RtnCode'])) $data['RtnCode'] = '';
		if (!isset($data['RtnMsg'])) $data['RtnMsg'] = '';
		if (!isset($data['TradeNo'])) $data['TradeNo'] = '';
		if (!isset($data['TradeAmt'])) $data['TradeAmt'] = '';
		if (!isset($data['PaymentDate'])) $data['PaymentDate'] = '';
		if (!isset($data['PaymentType'])) $data['PaymentType'] = '';
		if (!isset($data['PaymentTypeChargeFee'])) $data['PaymentTypeChargeFee'] = '';
		if (!isset($data['TradeDate'])) $data['TradeDate'] = '';
		if (!isset($data['SimulatePaid'])) $data['SimulatePaid'] = '';
		
		$sql = "INSERT INTO `allpay_response` SET   merchant_id = ? ,
													merchant_trade_no = ? ,
													rtn_code = ? , 
													rtn_msg = ? , 
													trade_no = ? , 
													trade_amt = ? , 
													payment_date = ? , 
													payment_type = ? , 
													payment_type_charge_fee = ? , 
													trade_date = ? , 
													simulate_paid = ?";
		$query = $this->db->query($sql , array(
			$data['MerchantID'],
			$data['MerchantTradeNo'],
			$data['RtnCode'],
			$data['RtnMsg'],
			$data['TradeNo'],
			$data['TradeAmt'],
			$data['PaymentDate'],
			$data['PaymentType'],
			$data['PaymentTypeChargeFee'],
			$data['TradeDate'],
			$data['SimulatePaid'],
		));
		
		if ($query)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	
	/**
	 * 訂單出貨
	 *
	 */
	public function order_send($post = FALSE)
	{
		$this->load->library('user_agent');
		
		while(list($key , $val) = each($post))
		{
			$$key = $val;
		}
		
		if (!isset($order_id) ||!isset($payment_id) ||!isset($invoice_no) ||!isset($send_function) ||!isset($distance) ||!isset($package_size))
		{
			return FALSE;
		}
		
		//將出貨資訊寫入資料庫中
		$sql = "UPDATE `payment` SET invoice_no = ? , send_function = ? , distance = ? , package_size = ? WHERE payment_id = ?";
		$query = $this->db->query($sql , array($invoice_no , $send_function , $distance , $package_size , $payment_id));
		
		if (!$query)
		{
			return FALSE;
		}
		
		//取得訂單
		$this->load->model('order_model');
		$order = $this->order_model->get_order_one($order_id);
		$payment = $this->get_payment_one($payment_id);
		
		//讀取設定
		$order_setting = $this->order_model->read_setting();
		
		require_once(APPPATH . '/libraries/AllPay.Logistics.Integration.php');
		
		try {
			$AL = new AllpayLogistics();
			
				if ($this->agent->is_mobile())
				{
					$device = Device::MOBILE;
				}
				else
				{
					$device = Device::PC;
				}
			
			$AL->HashKey = $this->all_pay_user['HashKey'];
			$AL->HashIV = $this->all_pay_user['HashIV'];
			
			$AL->Send = array(
				'MerchantID' => $this->all_pay_user['MerchantID'],
				'MerchantTradeNo' => $payment_id,
				'MerchantTradeDate' => date('Y/m/d H:i:s'),
				'LogisticsType' =>  LogisticsType::HOME,
				'LogisticsSubType' => LogisticsSubType::TCAT,
				'GoodsAmount' => (int) $payment->total_amount,
				// 'CollectionAmount' => 0, 
				'IsCollection' => IsCollection::NO,
				'GoodsName' => 'eyelens訂單',
				'SenderName' => $order_setting['send_name'],
				'SenderPhone' => $order_setting['send_phone'],
				'SenderCellPhone' => $order_setting['send_mobile'],
				'ReceiverName' => $order->rec_name,
				'ReceiverPhone' => $order->rec_phone,
				'ReceiverCellPhone' => $order->rec_mobile,
				'ReceiverEmail' => $order->rec_email,
				'TradeDesc' => $order->rec_memo,
				'ServerReplyURL' => site_url('api/order_send_response'),
				// 'ClientReplyURL' => site_url('control/order/order_send_response'),
				// 'LogisticsC2CReplyURL' => site_url(''),
				'Remark' => $payment->remark,
				'PlatformID' => '',
				// 'ExtraData' => '歐付寶測試額外資訊' , 
				'Device' => $device,
			);
			
			$AL->SendExtend = array(
				'SenderZipCode' => (int) $order_setting['send_zip'],
				'SenderAddress' => $order_setting['send_address'],
				'ReceiverZipCode' => $order->rec_post_no,
				'ReceiverAddress' => $order->rec_address,
				'Temperature' => Temperature::ROOM,
				'Distance' => $distance,
				'Specification' => $package_size,
				'ScheduledDeliveryTime' => $order->rec_time,
			);
			
			$response = $AL->BGCreateShippingOrder();
			
			$AL->CheckOutFeedback($response);
			
			if ($response['ResCode'] == '1')
			{
				//成功處理
				$sql = "UPDATE `payment` SET send_id = ? , send_status = ? , send_status_msg = ? , api_response_date = ? , booking_note = ? WHERE order_id = ? ";
				$query1 = $this->db->query($sql , array($response['AllPayLogisticsID'] , $response['RtnCode'] , $response['RtnMsg'] , $response['UpdateStatusDate'] , $response['BookingNote'] , $order->order_id));
				
				$sql = "UPDATE `order` SET active = '3' WHERE order_id = ?";
				$query2 = $this->db->query($sql , array($order->order_id));
				
				if (!$query1 || !$query2)
				{
					js_go_back('更新資料失敗，請通知系統管理員');
					$this->log_message('error' , '訂單出貨後回傳寫入資料庫發生錯誤，請排除。');
					
					if (!$query1)
					{
						$this->log_message('error' , '回寫payment訂單錯誤');
					}
					
					if (!$query2)
					{
						$this->log_message('error' , '回寫order更改狀態失敗');
					}
					
					return FALSE;
				}
				
				js_go_msg(site_url('/control/order/order_detail/' . $order->order_id) , '出貨完畢，請列印出貨單');
				return TRUE;
				
			}
			else
			{
				//錯誤處理
				js_go_back('回傳狀態失敗：' . $response['ErrorMessage']);
				$this->log_message('error' , '歐付寶物流回傳狀態失敗');
				$this->log_message('error' , json_encode($response));
				
				return FALSE;
			}
			
		}
		catch(Exception $e)
		{
			//例外處理錯誤
			$this->log_message('error' , '傳送歐付寶物流時發生例外錯誤，錯誤代碼：9999');
			$this->log_message('error' , json_encode($e->getMessage()));
			
			js_go_back('歐付寶物流送出失敗，錯誤訊息：' . $e->getMessage());
			return FALSE;
		}
		
	}
	
	/**
	 * 產生託運單
	 *
	 */
	public function make_trade_doc($order_id = FALSE)
	{
		if ($order_id == FALSE) return FALSE;
		
		$this->load->model('order_model');
		$payment = $this->get_payment_one_by_order_id($order_id);
		
		if (!$payment)
		{
			return FALSE;
		}
		
		require_once(APPPATH . '/libraries/AllPay.Logistics.Integration.php');
		
		$AL = new AllpayLogistics();
		
		$AL->HashKey = $this->all_pay_user['HashKey'];
		$AL->HashIV = $this->all_pay_user['HashIV'];
		
		$AL->Send = array(
			'MerchantID' => $this->all_pay_user['MerchantID'],
			'AllPayLogisticsID' => $payment->send_id,
		);
		
		$html = $AL->PrintTradeDoc('產生托運單/一段標');
		
		return $html;
	}
	
	
}

/* End of file Payment_model.php */
/* Location: ./apps/models/Payment_model.php */