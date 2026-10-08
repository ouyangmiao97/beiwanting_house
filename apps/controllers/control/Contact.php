<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends MY_Controller {

	/**
	 * @package:	侏儸紀寶石
	 * @copyright:	zh-tech 振華科技
	 * @author:		Tone
	 * 
	 *
	 */
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('admin_model');
		$this->load->model('contact_model');
		
		$this->front->contact_type = $this->contact_model->contact_type;
	}
	
	
	public function __destruct()
	{
		parent::__destruct();
	}

	
	/**
	 * 聯絡我們
	 *
	 */
	public function index()
	{
		$this->admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => '聯絡我們',
			'bread_crumb' => array('管理首頁' => '/control/' , '聯絡我們' => '/control/contact/index')
		);
		
		$this->front->data_list = $this->contact_model->get_contact_list(FALSE , 0);
		
		$this->load->view('control/contact/index' , $this->front);
	}
	
	
	/**
	 * 產品問答
	 *
	 */
	public function product()
	{
		$this->admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => '產品問答',
			'bread_crumb' => array('管理首頁' => '/control/' , '產品問答' => '/control/contact/product')
		);
		
		$this->front->data_list = $this->contact_model->get_contact_list(FALSE , 1);
		
		$this->load->view('control/contact/index' , $this->front);
	}
	
	
	/**
	 * 訂單問答
	 *
	 */
	public function order()
	{
		$this->admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => '訂單問答',
			'bread_crumb' => array('管理首頁' => '/control/' , '訂單問答' => '/control/contact/index')
		);
		
		$this->front->data_list = $this->contact_model->get_contact_list(FALSE , 2);
		
		$this->load->view('control/contact/index' , $this->front);
	}
	
	
	/**
	 * 回覆問答
	 *
	 */
	public function reply()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$msg = $this->input->post('msg' , TRUE);
		
		/* process contact */
		$response = $this->contact_model->reply_contact($id , $msg);
			
		echo json_encode($response);
		
		exit();
	}
	
	
	/**
	 * 取得客服
	 *
	 */
	public function get_contact()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id');
		
		$contact = $this->contact_model->get_contact_one($id);
		
		if (isset($contact) && $contact != FALSE)
		{
			// $point_list = config_item('service_point_list');
			// $contact->service_point = $point_list[$contact->service_point];
			
			echo json_encode(array('status' => 'T' , 'contact' => $contact , 'msg' => ''));
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'contact' => '' , 'msg' => '查無資料'));
		exit();
	}
	
	
	/**
	 * 改變客服狀態
	 *
	 */
	public function change_contact_active()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$checkeds = $this->input->post('checkeds' , TRUE);
		
		$response = $this->contact_model->change_contact_active($id , $checkeds);
		
		echo json_encode($response);
	}
	
	
	/**
	 * 刪除客服紀錄
	 *
	 */
	public function del_contact()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$response = $this->contact_model->del_contact($id);
		
		echo json_encode($response);
	}
	
	
	/**
	 * 取得客戶訊息
	 *
	 */
	public function get_contact_message()
	{
		$this->admin_model->is_login_ajax();
		
		$response = $this->contact_model->get_contact_process_list();
		
		echo json_encode($response);
	}
	
	public function del_list()
	{
		$this->admin_model->is_login_ajax();
		
		$list = $this->input->post('list' , TRUE);
		
		$msg = '';
		
		foreach($list as $key => $id)
		{
			$response = $this->contact_model->del_contact($id);
			
			if (!$response)
			{
				$msg .= '系統編號為' . $id . '問答資訊刪除失敗' . "\n";
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
}
//end of file Contact.php