<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends MY_Controller {

	/**
	 * @package:	振華後台模組
	 * @copyright:	zh-tech 振華科技
	 * @author:		Tone
	 * 
	 *
	 */
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('admin_model');
		
		$this->front->page_title = array(
			'title' => '會員查詢',
			'bread_crumb' => array('管理首頁' => '/control/' , '會員查詢' => '/control/member/index')
		);
		
		$this->front->member_active_list = array(
			-1 => '刪除',
			0 => '未驗證',
			1 => '已驗證',
		);
	}
	
	
	public function __destruct()
	{
		parent::__destruct();
	}
	
	/**
	 * 查詢會員
	 *
	 */
	public function index()
	{
		$this->admin_model->is_login();
		
		$key = $this->input->get('key');
		
		if (!isset($key) || $key == FALSE)
		{
			$this->front->member_list = $this->member_model->get_list();
		}
		else
		{
			$this->front->member_list = $this->member_model->get_member_admin($key);
		}
		
		$this->load->view('control/member/index' , $this->front);
	}
	
	/**
	 * 查詢會員
	 *
	 */
	public function verify()
	{
		$this->admin_model->is_login();
		
		$this->front->member_list = $this->member_model->get_member_admin_verify();
		
		$this->load->view('control/member/verify' , $this->front);
	}
	
	
	/**
	 * 已審核會員
	 *
	 */
	public function success()
	{
		$this->admin_model->is_login();
		
		$this->front->member_list = $this->member_model->get_member_admin_verify_success();
		
		$this->load->view('control/member/success' , $this->front);
	}
	
	
	/**
	 * 退審會員
	 *
	 */
	public function verify_false()
	{
		$this->admin_model->is_login();
		
		$this->front->member_list = $this->member_model->get_member_admin_verify_false();
		
		$this->load->view('control/member/verify_false' , $this->front);
	}
	
	/**
	 * 後台會員註冊
	 *
	 */
	public function register()
	{
		// 檢查登入ajax
		$this->admin_model->is_login();
		
		// 宣告標題
		$this->front->page_title = array(
			'title' => '會員申辦',
			'bread_crumb' => array('管理首頁' => '/control/' , '會員申辦' => '/control/member/register')
		);
		
		// 載入頁面
		$this->load->view('control/member/register' , $this->front);
	}
	
	
	/**
	 * 會員詳細資料
	 *
	 */
	public function detail($id = FALSE)
	{
		$this->admin_model->is_login();
		
		if (!$id)
		{
			js_go_back('無效的會員ID');
			exit();
		}
		
		$this->front->member = $this->member_model->get_member_by_id($id , -1);
		
		// 處理處方籤圖片
		$this->load->model('upload_model');
		
		$this->front->member->img_file = $this->upload_model->get_uploads_one($this->front->member->prescription);
		
		$this->load->view('control/member/detail' , $this->front);
	}
	
	
	/**
	 * 改變會員狀態(停權、待驗證、啟用、假刪除)
	 *
	 */
	public function change_member_active()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$active = $this->input->post('active' , TRUE);
		
		$response = $this->member_model->change_member_active_admin($id , $active);
		
		echo json_encode($response);
	}
	
	
	/**
	 * 補發會員密碼
	 *
	 */
	public function member_forget_passwd()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
	}
	
	
	/**
	 * 補發會員驗證信
	 *
	 */
	public function member_mail_verify()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
	}
	
	
	/**
	 * 寄送客服信件給會員
	 *
	 */
	public function member_contact_mail()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
	}
	
	
	/**
	 * 變更審核狀態
	 *
	 */
	public function verify_post()
	{
		$this->admin_model->is_login_ajax();
		
		$member_id = $this->input->post('member_id' , TRUE);
		$active = $this->input->post('active' , TRUE);
		
		$this->load->model('member_model');
		
		$member = $this->member_model->get_member_by_id($member_id , 1);
		
		if (!$member)
		{
			echo json_encode(array('status' => 'F' , 'msg' => '查無此會員'));
			exit();
		}
		
		if ($this->member_model->change_verify($member_id , $active))
		{
			echo json_encode(array('status' => 'T' , 'msg' => '修改完成'));
			exit();
		}
		else
		{
			echo json_encode(array('status' => 'F' , 'msg' => '修改發生錯誤'));
			exit();
		}
		
	}
	
	
	public function add()
	{
		$this->admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => '新增會員',
			'bread_crumb' => array('管理首頁' => '/control/' , '會員列表' => '/control/member/index' , '新增會員' => '/control/member/add')
		);
		
		$this->load->view('control/member/add' , $this->front);
	}
	
	public function add_post()
	{
		$this->admin_model->is_login();
		
		$data = $this->input->post(NULL , TRUE);
		
		$response = $this->member_model->add_member($data);
		
		if (is_array($response))
		{
			$status = isset($response[0])?$response[0]:FALSE;
			$msg = isset($response[1])?$response[1]:0;
			
			if ($status)
			{
				js_go_msg('/control/member/index' , '處理成功');
				exit();
			}
			else
			{
				js_go_back('處理失敗，錯誤訊息：' . $msg);
				exit();
			}
		}
		else
		{
			js_go_back('發生例外錯誤，請聯絡管理人員');
			exit();
		}
	}
	
	public function edit($member_id = FALSE)
	{
		$this->admin_model->is_login();
		
		$this->front->data_row = $this->member_model->get_one($member_id);
		
		if (!$this->front->data_row)
		{
			js_go_back('查無該會員資料');
			exit();
		}
		
		$this->front->page_title = array(
			'title' => '修改會員',
			'bread_crumb' => array('管理首頁' => '/control/' , '會員列表' => '/control/member/index' , '修改會員' => '/control/member/edit')
		);
		
		$this->load->view('control/member/edit' , $this->front);
	}
	
	public function edit_post()
	{
		$this->admin_model->is_login();
		
		$data = $this->input->post(NULL , TRUE);
		
		$response = $this->member_model->edit_member($data);
		
		// log_message('ERROR' , json_encode($response , TRUE));
		
		if (is_array($response))
		{
			$status = isset($response[0])?$response[0]:FALSE;
			$msg = isset($response[1])?$response[1]:0;
			
			if ($status)
			{
				js_go_msg('/control/member/index' , '處理成功');
				exit();
			}
			else
			{
				js_go_back('處理失敗，錯誤訊息：' . $msg);
				exit();
			}
		}
		else
		{
			js_go_back('發生例外錯誤，請聯絡管理人員');
			exit();
		}
	}
	
	// public function del_post()
	// {
		// $this->admin_model->is_login_ajax();
		
		
	// }
}
//end of file Member.php