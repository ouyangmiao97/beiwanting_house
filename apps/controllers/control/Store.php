<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends MY_Controller {

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
		$this->load->model('store_model');
		$this->load->model('city_model');
		$this->load->model('district_model');
	}
	
	
	public function __destruct()
	{
		parent::__destruct();
	}

	
	/**
	 * 文章列表
	 *
	 */
	public function index()
	{
		$this->front->city_list = $this->city_model->get_all_list();
		
		$this->admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => ' 店鋪管理',
			'bread_crumb' => array('管理首頁' => '/control/' , '店鋪管理' => '#' , '店鋪管理列表' => '/control/store/index')
		);
		
		$this->front->data_list = $this->store_model->get_list_all();
		
		$this->load->view('control/store/index' , $this->front);
	}
	
	
	public function get()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$store = $this->store_model->get_one($id);

		$this->db->where('cid' , $store->cid);
		$query = $this->db->get('district');
		$result = $query->result();
			
		$html = '<option value="">選擇區域</option>';
		
		foreach($result as $key => $row)
		{
			if ($store->did != $row->id)
			{
				$html .= '<option value="' . $row->id . '">' . $row->title . '</option>';
			}
			else
			{
				$html .= '<option value="' . $row->id . '" selected>' . $row->title . '</option>';
			}
			
		}

		echo json_encode(array('status' => 'T' , 'msg' => '' , 'words' => $store , 'html' => $html));
	}
	
	
	/**
	 * 新增文章
	 *
	 */
	public function add()
	{
		$this->admin_model->is_login_ajax();
		
		$data = $this->input->post(null , TRUE);
		
		$result = $this->store_model->add($data);
		
		if (is_array($result))
		{
			echo json_encode($result);
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'msg' => 'unknow error!!'));
	}
	
	
	/**
	 * 修改文章
	 *
	 */
	public function edit()
	{
		$this->admin_model->is_login_ajax();
		
		$data = $this->input->post(null , TRUE);
		
		$data['map_data'] = $_POST['map_data'];
		
		$result = $this->store_model->edit($data);
		
		if (is_array($result))
		{
			echo json_encode($result);
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'msg' => 'unknow error!!'));
	}
	
	
	/**
	 * 刪除文章
	 *
	 */
	public function del()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$result = $this->store_model->del($id);
		
		if (is_array($result))
		{
			echo json_encode($result);
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'msg' => 'unknow error!!'));
	}
	
	
	/**
	 * 改變文章狀態
	 *
	 */
	public function change_active()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$checked = (int) $this->input->post('checkeds' , TRUE);
		
		$result = $this->store_model->change_active($id , $checked);
		
		if (is_array($result))
		{
			echo json_encode($result);
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'msg' => 'unknow error!!'));
	}
	
}
//end of file Words.php