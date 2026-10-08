<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends MY_Controller {

	/**
	 * @package:	eyelens order setting
	 * @copyright:	zh-tech 振華科技
	 * @author:		Tone
	 * 
	 *
	 */
	
	private $order_active_list = array();
	
	public function __construct()
	{
		parent::__construct();
		
		$this->front->page_title = array(
			'title' => '購物管理',
			'bread_crumb' => array('管理首頁' => '/control/' , '購物管理' => '/control/order/index'),
		);
		
		if (!isset($this->admin_model)) $this->load->model('admin_model');
		if (!isset($this->meta_model)) $this->load->model('meta_model');
		
		$this->admin_model->is_login();
	}
	
	
	public function __destruct()
	{
		parent::__destruct();
	}
	
	
	public function index()
	{
		
	}
	
	
	/**
	 * 訂單設定頁面
	 * 
	 */
	public function shopping_cost_setting()
	{
		
		$this->admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => '購物設定',
			'bread_crumb' => array('管理首頁' => '/control/' , '購物設定' => '/control/order/shopping_cost_setting')
		);
		
		$this->load->model('order_model');
		
		$this->front->order_setting = $this->order_model->read_setting();
		
		$this->front->shopping_cost_rule = $this->order_model->get_shopping_cost_rule();
		
		$this->front->invoice_rule = $this->order_model->get_invoice_rule();
		
		$this->load->view('control/order/shopping_cost_setting' , $this->front);
	}
	
	
	/**
	 * 送出訂單設定
	 *
	 */
	public function shopping_cost_setting_post()
	{
		$this->admin_model->is_login();
		
		$data = $this->input->post(null , TRUE);
		
		$this->load->model('order_model');
		
		$response = $this->order_model->insert_setting($data);
		
		if ($response === TRUE)
		{
			js_go_msg('/control/order/shopping_cost_setting' , '修改完成');
			exit();
		}
		
		js_go_back('修改失敗');
		exit();
	}
	
	
	/**
	 * 前端運送方式說明頁
	 *
	 */
	public function sendfun_page()
	{
		$this->admin_model->is_login();
		
		$this->load->model('page_model');
		
		$page = 'sendfun';
		
		$html = $this->page_model->get_html($page);
		
		if (!$html)
		{
			$this->page_model->write_cache($page , '');
			
			$html = $this->page_model->get_html();
		}
		
		$this->front->page_id = $page;
		
		$this->front->page_html = $html;
		
		unset($html);
		
		$this->load->view('/control/order/edit_page_html' , $this->front);
	}
	
	
	/**
	 * 待出貨清單
	 *
	 */
	public function sendlist()
	{
		$this->admin_model->is_login();
		
		$this->load->model('order_model');
		
		$this->load->model('payment_model');
		
		$this->front->page_title = array(
			'title' => '待出貨清單',
			'bread_crumb' => array('管理首頁' => '/control/' , '待出貨清單' => '/control/order/sendlist'),
		);
		
		$this->front->order_active_list = $this->order_model->get_order_active_list();
		
		$this->front->payment_active_list = $this->payment_model->get_payment_active_list();
		
		//取得post參數
		$post = $this->input->post(NULL , TRUE);
		
		$post['order_active'] = 2;	//訂單狀態待出貨
		
		$post['payment_active'] = 5;	//付款狀態已付款
		
		$this->front->order_list = $this->order_model->order_search($post);
		
		$this->front->data = $post;
		
		if (!is_array($this->front->order_list))
		{
			js_go_back($this->front->order_list);
			exit();
		}
		
		$this->load->view('/control/order/sendlist' , $this->front);
	}
	
	
	/**
	 * 到店取貨清單
	 *
	 */
	public function storelist()
	{
		$this->admin_model->is_login();
		
		$this->load->model('order_model');
		
		$this->load->model('payment_model');
		$this->load->model('store_model');
		
		$this->front->page_title = array(
			'title' => '到店取貨清單',
			'bread_crumb' => array('管理首頁' => '/control/' , '到店取貨清單' => '/control/order/sendlist'),
		);
		


		//顯示的內容
		$this->front->order_active_list = $this->order_model->get_order_active_list();
		
		$this->front->payment_active_list = $this->payment_model->get_payment_active_list();
		
		$this->front->store_list = $this->store_model->get_list_all();
		
		//取得post參數
		$post = $this->input->post(NULL , TRUE);
		
		 $post['order_active'] = 9;	//訂單狀態待出貨
		
		 $this->front->order_list = $this->order_model->order_search($post);
		
		$store_id = $this->input->get('store_id' , TRUE);

		$this->front->store_id = $store_id;
		
		if ($store_id >0  ) $this->db->where('store' , $store_id);
		
		$this->db->where('active' , 9);
		$this->db->or_where('active' , 10);
		$this->db->order_by('create_at' , 'desc');
		$query = $this->db->get('order');
		$this->front->order_list = $query->result();
		
		$this->front->data = $post;
		
		if (!is_array($this->front->order_list))
		{
			js_go_back($this->front->order_list);
			exit();
		}
		
		$this->load->view('/control/order/storelist' , $this->front);
	}
	

	/**
	*信件通知
	*
	*/
	public function storemail()
	{
		//檢查登入
		$this->admin_model->is_login();

		//載入模型
		$this->load->model('mail_model');
		$this->load->model('order_model');
		
		//管理頁面標題顯示
		$this->front->page_title = array(
			'title' => '到店取貨清單',
			'bread_crumb' => array('管理首頁' => '/control/' , '到店取貨清單' => '/control/order/sendlist'),
		);

		//訂單資料
		$this->front->order = $this->order_model->get_order_one($this->input->get('ss',TRUE));
		


		$order_contents = json_decode($this->front->order->order_contents , TRUE);
		foreach ($order_contents as $key => $row) 
		{
			//品名
			$this->front->name= $row['options']['name'];
			//商品規格
			$this->front->brand= $row['options']['brand'];			
		}
		

		//email 信件寄出
		$mail = $this->input->get('mail' , TRUE);
		//$mail = 'benson50217@gmail.com';
		if($mail != FALSE)
		{
			$data_or['id'] = $this->input->get('id' , TRUE);
			$data_or['statue'] = 1;
			$this->order_model->edit($data_or);

			$template = $this->load->view('/control/order/verification' , $this->front , TRUE);
			$subject='鉅灣客服系統 - 通知信件';
			$send = $this->mail_model->send($mail , $subject , $template);
		}
	
		
		if($send)
		{
			js_go_back('信件寄送成功');
			exit;
		}
		else
		{
			js_go_back('信件寄送失敗');
			exit;
		}
	}


	/**
	 * 多選刪除
	 *
	 */
	public function storelist_del_list()
	{
		$this->admin_model->is_login_ajax();
		
		$list = $this->input->post('list' , TRUE);
		
		$this->load->model('order_model');
		
		$msg = '';
		
		foreach($list as $key => $order_id)
		{
			$response = $this->order_model->del_order($order_id);
			
			if (!$response)
			{
				$msg .= '系統編號為' . $order_id . '訂單刪除失敗' . "\n";
			}
		}
		
		if ($msg == '')
		{
			echo json_encode(array('status' => 'T' , 'msg' => '處理完成'));
			exit();
		}
		else
		{
			echo json_encode(array('status' => 'F' , 'msg' => $msg));
			exit();
		}
	}
	
	
	/**
	 * 多筆改變狀態 (已到貨)
	 *
	 */
	public function storelist_change_list_in()
	{
		$this->admin_model->is_login_ajax();
		
		$list = $this->input->post('list' , TRUE);
		
		$this->load->model('order_model');
		$this->load->model('store_model');
		$this->load->model('mail_model');
		
		$msg = '';
		
		foreach($list as $key => $order_id)
		{
			$order = $this->order_model->get_one($order_id);
			
			// 變更狀態
			$this->db->where('id' , $order_id);
			$result = $this->db->update('order' , array('active' => '10'));
			
			if ($result)
			{
				$order = $this->order_model->get_one($order_id);
				$store = $this->store_model->get_one($order->store);
				
				$this->front->order =& $order;
				$this->front->store =& $store;
				
				if ($order->copyies_torec == 1)
				{
					$mailto = $order->pay_name . '<' . $order->pay_email . '>,' . $order->rec_name . '<' . $order->rec_email . '>';
				}
				else
				{
					$mailto = $order->pay_name . '<' . $order->pay_email . '>';
				}
				
				$subject = sprintf("%s-%s通知" , config_item('site') , '到貨通知');
				
				$template = $this->load->view('/member/mail_order_store_in' , $this->front , TRUE);
				
				$send = @$this->mail_model->send($mailto , $subject , $template);
				
				if ($send == FALSE)
				{
					$msg .= '系統編號為' . $order_id . '信件發送失敗' . "\n";
				}
			}
			else
			{
				$msg .= '系統編號為' . $order_id . '訂單失敗' . "\n";
			}
		}
		
		if ($msg == '')
		{
			echo json_encode(array('status' => 'T' , 'msg' => '處理完成'));
			exit();
		}
		else
		{
			echo json_encode(array('status' => 'F' , 'msg' => $msg));
			exit();
		}
	}
	
	
	/**
	 * 多筆改變狀態 (已取貨)
	 *
	 */
	public function storelist_change_list_out()
	{
		$this->admin_model->is_login_ajax();
		
		$list = $this->input->post('list' , TRUE);
		
		$this->load->model('order_model');
		$this->load->model('store_model');
		$this->load->model('mail_model');
		
		$msg = '';
		
		foreach($list as $key => $order_id)
		{
			// 變更狀態
			$this->db->where('id' , $order_id);
			$result = $this->db->update('order' , array('active' => '11'));
			
			if ($result)
			{
				$order = $this->order_model->get_one($order_id);
				$store = $this->store_model->get_one($order->store);
				
				$this->front->order =& $order;
				$this->front->store =& $store;
				
				if ($order->copyies_torec == 1)
				{
					$mailto = $order->pay_name . '<' . $order->pay_email . '>,' . $order->rec_name . '<' . $order->rec_email . '>';
				}
				else
				{
					$mailto = $order->pay_name . '<' . $order->pay_email . '>';
				}
				
				$subject = sprintf("%s-%s通知" , config_item('site') , '到貨通知');
				
				$template = $this->load->view('/member/mail_order_store_out' , $this->front , TRUE);
				
				$send = @$this->mail_model->send($mailto , $subject , $template);
				
				if ($send == FALSE)
				{
					$msg .= '系統編號為' . $order_id . '信件發送失敗' . "\n";
				}
			}
			else
			{
				$msg .= '系統編號為' . $order_id . '訂單失敗' . "\n";
			}
		}
		
		if ($msg == '')
		{
			echo json_encode(array('status' => 'T' , 'msg' => '處理完成'));
			exit();
		}
		else
		{
			echo json_encode(array('status' => 'F' , 'msg' => $msg));
			exit();
		}
	}
	
	
	/**
	 * 到店取貨清單
	 *
	 */
	public function storelist_old()
	{
		$this->admin_model->is_login();
		
		$this->load->model('order_model');
		
		$this->load->model('payment_model');
		$this->load->model('store_model');
		
		$this->front->page_title = array(
			'title' => '已取貨清單',
			'bread_crumb' => array('管理首頁' => '/control/' , '已取貨清單' => '/control/order/sendlist'),
		);
		
		$this->front->order_active_list = $this->order_model->get_order_active_list();
		
		$this->front->payment_active_list = $this->payment_model->get_payment_active_list();
		
		$this->front->store_list = $this->store_model->get_list_all();
		
		//取得post參數
		$post = $this->input->post(NULL , TRUE);
		
		// $post['order_active'] = 9;	//訂單狀態待出貨
		
		// $this->front->order_list = $this->order_model->order_search($post);
		
		$store_id = $this->input->get('store_id' , TRUE);
		$this->front->store_id = $store_id;
		
		if ($store_id != FALSE) $this->db->where('store' , $store_id);
		
		$this->db->where('active' , 11);
		$this->db->order_by('create_at' , 'desc');
		$query = $this->db->get('order');
		$this->front->order_list = $query->result();
		
		$this->front->data = $post;
		
		if (!is_array($this->front->order_list))
		{
			js_go_back($this->front->order_list);
			exit();
		}
		
		$this->load->view('/control/order/storelist' , $this->front);
	}
	
	
	/**
	 * 訂單查詢
	 *
	 */
	public function order_search()
	{
		$this->admin_model->is_login();
		
		$this->load->model('order_model');
		
		$this->load->model('payment_model');
		
		$this->front->page_title = array(
			'title' => '訂單查詢',
			'bread_crumb' => array('管理首頁' => '/control/' , '訂單查詢' => '/control/order/order_search'),
		);
		
		$this->front->order_active_list = $this->order_model->get_order_active_list();
		
		$this->front->payment_active_list = $this->payment_model->get_payment_active_list();
		
		//取得post參數
		$post = $this->input->post(NULL , TRUE);
		
		$this->front->order_list = $this->order_model->order_search($post);
		
		if (!isset($post['order_active']))
		{
			$post['order_active'] = 99;
		}
		
		if (!isset($post['payment_active']))
		{
			$post['payment_active'] = 99;
		}
		
		$post['order_active'] = (int) $post['order_active'];
		$post['payment_active'] = (int) $post['payment_active'];
		
		$this->front->data = $post;
		
		if (!is_array($this->front->order_list))
		{
			js_go_back($this->front->order_list);
			exit();
		}
		
		$this->load->view('/control/order/order_search' , $this->front);
	}
	
	
	/**
	 * 訂單明細
	 *
	 */
	public function order_detail($order_id = FALSE)
	{
		$this->admin_model->is_login();
		
		$this->load->model('order_model');
		
		$this->load->model('payment_model');
		
		$this->load->model('store_model');
		
		$this->load->model('member_model');
		
		if ($order_id == FALSE)
		{
			js_go_back('未輸入訂單編號');
			exit();
		}
		
		$this->front->order = $this->order_model->get_order_one($order_id);
		
		$this->front->member = $this->member_model->get_member_by_id($this->front->order->member_id);
		
		//取得訂單狀態列表
		$this->front->order_active_list = $this->order_model->get_order_active_list();
		
		//取得貨物送達時間列表
		$this->front->rec_time_list = $this->order_model->get_rec_time_list();
		
		//取得運送地區列表
		$this->front->send_fun_list = $this->order_model->get_send_fun_list();
		
		//取得發票類型列表
		$this->front->invoice_type_list = $this->order_model->get_invoice_type_list();
		
		//物流狀態碼
		$this->load->config('send_status');
		$this->front->send_status_list = $this->config->item('send_active');
		
		if (!$this->front->order)
		{
			js_go_back('查無訂單');
			exit();
		}
		
		$this->front->payment = $this->payment_model->get_payment_one_by_order_id($order_id);		
		
		//取得付款狀態列表
		$this->front->payment_active_list = $this->payment_model->get_payment_active_list();
		
		// 取得店家資訊
		$this->front->store = $this->store_model->get_one($this->front->order->store);		
		
		$this->load->model('product_type_model');
		
		// 取得每件商品的子項目
		$order_contents = json_decode($this->front->order->order_contents , TRUE);
		
		foreach($order_contents as $key => $row)
		{
			if (isset($row['options']['ptid']))
			{
				$order_contents[$key]['product_type'] = $this->product_type_model->get_one($row['options']['ptid']);
			}
			else
			{
				$order_contents[$key]['product_type'] = FALSE;
			}
		}
		
		$this->front->order->order_contents = json_encode($order_contents);
		
		if ($this->front->order->type==0)
		{
			$this->load->view('/control/order/order_detail_store' , $this->front);
		}
		else
		{
			$this->load->view('/control/order/order_detail' , $this->front);
		}
		
	}
	
	
	/**
	 * 訂單出貨
	 *
	 */
	public function order_send($order_id = FALSE)
	{
		$this->admin_model->is_login();
		
		$this->load->model('order_model');
		
		$this->load->model('payment_model');
		
		if ($order_id == FALSE)
		{
			js_go_back('未輸入訂單編號');
			exit();
		}
		
		$this->front->order = $this->order_model->get_order_one($order_id);
		
		$this->front->payment = $this->payment_model->get_payment_one_by_order_id($order_id);
		
		if (!$this->front->order)
		{
			js_go_back('查無訂單');
			exit();
		}
		
		//對於可以出貨的訂單一定要是已付款，不然廠商會賠錢
		//檢查付款狀態
		if (!$this->front->payment)
		{
			js_go_back('尚未產生付款紀錄');
			exit();
		}
		
		if (!isset($this->front->payment->active))
		{
			js_go_back('查無付款狀態');
			exit();
		}
		
		if ($this->front->payment->active != 5)
		{
			js_go_back('尚未完成付款流程！不能進行出貨的動作');
			exit();
		}
		
		//檢查訂單狀態
		if (!isset($this->front->order->active))
		{
			js_go_back('查無訂單狀態');
			exit();
		}
		
		if ($this->front->order->active != 2)
		{
			js_go_back('訂單狀態不符合出貨標準');
			exit();
		}
		
		$this->load->view('/control/order/order_send' , $this->front);
	}
	
	
	/**
	 * 送出物流紀錄
	 *
	 */
	public function order_send_post()
	{
		$this->admin_model->is_login();
		
		$post = $this->input->post(NULL , TRUE);
		
		$this->load->model('order_model');
		
		$this->load->model('payment_model');
		
		$this->payment_model->order_send($post);
		
		exit();
	}
	
	
	/**
	 * 產生託運單
	 *
	 */
	public function order_trade_doc($order_id = FALSE)
	{
		$this->admin_model->is_login();
		
		if (!$order_id)
		{
			js_go_back('無效的訂單ID');
			exit();
		}
		
		$this->load->model('payment_model');
		
		$html = $this->payment_model->make_trade_doc($order_id);
		
		if ($html == FALSE)
		{
			js_go_back('查無訂單資料');
			exit();
		}
		
		echo $html;
	}
	
	// 將訂單變更為已到貨
	public function store_in($order_id = FALSE)
	{
		$this->admin_model->is_login_ajax();
		
		if (!$order_id)
		{
			echo json_encode(array('status' => 'F'));
			exit();
		}
		
		$this->db->where('id' , $order_id);
		if ($this->db->update('order' , array('active' => '10')))
		{
			// 進行通知消費者
			$this->load->model('order_model');
			$this->load->model('store_model');
			$this->load->model('mail_model');
			$order = $this->order_model->get_one($order_id);
			
			if (!isset($order))
			{
				echo json_encode(array('status' => 'F' , 'msg' => '發生錯誤，查無訂單資訊，導致信件寄送失敗'));
				exit();
			}
			
			$this->front->order = $order;
			$this->front->store = $this->store_model->get_one($order->store);
			
			if ($order->copyies_torec == 1)
			{
				// $mailto = sprintf("%s<%s> , %s<%s>" , $order->pay_name , $order->pay_email , $order->rec_name , $order->rec_email);
				$mailto = $order->pay_name . '<' . $order->pay_email . '>,' . $order->rec_name . '<' . $order->rec_email . '>';
			}
			else
			{
				// $mailto = sprintf("%s<%s>" , $order->pay_name , $order->pay_email);
				$mailto = $order->pay_name . '<' . $order->pay_email . '>';
			}
			
			$subject = sprintf("%s-%s通知" , config_item('site') , '到貨通知');
			
			$template = $this->load->view('/member/mail_order_store_in' , $this->front , TRUE);
			
			$send = @$this->mail_model->send($mailto , $subject , $template);
			
			if (!$send)
			{
				echo json_encode(array('status' => 'F' , 'msg' => '訂單狀態變更成功，但信件寄送失敗！'));
				exit();
			}
			
			echo json_encode(array('status' => 'T'));
			exit();
		}
		else
		{
			echo json_encode(array('status' => 'F'));
			exit();
		}
	}
	
	
	public function store_out($order_id = FALSE)
	{
		$this->admin_model->is_login_ajax();
		
		if (!$order_id)
		{
			echo json_encode(array('status' => 'F'));
			exit();
		}
		
		$this->db->where('id' , $order_id);
		if ($this->db->update('order' , array('active' => '11')))
		{
			// 進行通知消費者
			$this->load->model('order_model');
			$this->load->model('store_model');
			$this->load->model('mail_model');
			$order = $this->order_model->get_one($order_id);		
			
			if (!isset($order))
			{
				echo json_encode(array('status' => 'F' , 'msg' => '發生錯誤，查無訂單資訊，導致信件寄送失敗'));
				exit();
			}
			
			$this->front->order = $order;
			$this->front->store = $this->store_model->get_one($order->store);
			
			if ($order->copyies_torec == 1)
			{
				// $mailto = sprintf("%s<%s> , %s<%s>" , $order->pay_name , $order->pay_email , $order->rec_name , $order->rec_email);
				$mailto = $order->pay_name . '<' . $order->pay_email . '>,' . $order->rec_name . '<' . $order->rec_email . '>';
			}
			else
			{
				// $mailto = sprintf("%s<%s>" , $order->pay_name , $order->pay_email);
				$mailto = $order->pay_name . '<' . $order->pay_email . '>';
			}
			
			$subject = sprintf("%s-%s通知" , config_item('site') , '取貨完成通知');
			
			$template = $this->load->view('/member/mail_order_store_out' , $this->front , TRUE);
			
			$send = @$this->mail_model->send($mailto , $subject , $template);
			
			if (!$send)
			{
				echo json_encode(array('status' => 'F' , 'msg' => '訂單狀態變更成功，但信件寄送失敗！'));
				exit();
			}
			
			echo json_encode(array('status' => 'T'));
			exit();
		}
		else
		{
			echo json_encode(array('status' => 'F'));
			exit();
		}
	}
	
	
	public function del()
	{
		$this->admin_model->is_login_ajax();
		
		$this->load->model('order_model');
		
		$id = $this->input->post('id' , TRUE);
		
		$response = $this->order_model->del_order($id);
		
		if ($response)
		{
			echo json_encode(array('status' => 'T' , 'msg' => '操作完成'));
			exit();
		}
		else
		{
			echo json_encode(array('status' => 'F' , 'msg' => '操作失敗！請重試或聯絡管理員'));
			exit();
		}
	}

}
//end of file Home.php