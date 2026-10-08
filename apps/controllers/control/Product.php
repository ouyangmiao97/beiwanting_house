<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

	/**
	 * @copyright:	zh-tech 振華科技
	 * @author:		Tone
	 */
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->front->page_title = array(
			'title' => '產品列表',
			'bread_crumb' => array('管理首頁' => '/control/' , '產品' => '#' , '產品列表' => '/control/product/index')
		);
		
		$this->load->model('admin_model');
		$this->load->model('file_model');
		$this->load->model('upload_model');
		// $this->load->model('item_model');
		$this->load->model('product_model');
		$this->load->model('page_model');
		// $this->load->model('rule_sub_model');
		$this->load->model('product_color_model');
		$this->load->model('product_type_a_model');
		$this->load->model('product_type_b_model');
	}
	
	
	public function __destruct()
	{
		parent::__destruct();
	}

	
	public function index()
	{
		$this->admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => '產品列表',
			'bread_crumb' => array('管理首頁' => '/control/' , '產品' => '#' , '產品列表' => '/control/product/index')
		);
		
		$this->front->ac = $this->input->get('ac');
		
		$this->front->ac = $this->front->ac == FALSE ? 0 : $this->front->ac;
		
		
		
		// $this->front->data_list = $this->product_model->get_product_list_all();
		$this->front->data_list = $this->product_model->get_product_list_ac($this->front->ac);
		
		$this->load->view('control/product/index' , $this->front);
	}
	
	
	public function add_product()
	{
		$this->admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => '新增產品',
			'bread_crumb' => array('管理首頁' => '/control/' , '產品列表' => '/control/product/index' , '新增產品' => '/control/product/add_product')
		);
		
		// $this->front->rule_sub_list = $this->rule_sub_model->get_list();
		
		// $this->front->brand_list = $this->item_model->get_item_list();
		// $this->front->degree_list = $this->item_model->get_item_list(1);
		// $this->front->color_list = $this->item_model->get_item_list(2);
		// $this->front->pick_list = $this->item_model->get_item_list(3);
		// $this->front->origin_list = $this->item_model->get_item_list(4);
		// $this->front->type_list = $this->item_model->get_item_list(5);
		// $this->front->class_list = $this->item_model->get_item_list(6);
		
		$this->front->color_list = $this->product_color_model->search_all(['active' => 1]);
		$this->front->type_a_list = $this->product_type_a_model->search_all(['active' => 1]);
		$this->front->type_b_list = $this->product_type_b_model->search_all(['active' => 1]);
		
		$this->load->view('control/product/add_product' , $this->front);
	}
	
	
	public function edit_product()
	{
		$this->admin_model->is_login();
		
		$id = $this->input->get('id' , TRUE);

		$this->front->page_title = array(
			'title' => '修改產品',
			'bread_crumb' => array('管理首頁' => '/control/' , '產品列表' => '/control/product/index' , '修改產品' => '/control/product/edit_product')
		);
		
		$this->front->data_row = $this->product_model->get_product_one($id);
		
		// $this->front->rule_sub_list = $this->rule_sub_model->get_list();
		
		// $this->front->brand_list = $this->item_model->get_item_list();
		// $this->front->degree_list = $this->item_model->get_item_list(1);
		// $this->front->color_list = $this->item_model->get_item_list(2);
		// $this->front->pick_list = $this->item_model->get_item_list(3);
		// $this->front->origin_list = $this->item_model->get_item_list(4);
		// $this->front->type_list = $this->item_model->get_item_list(5);
		// $this->front->class_list = $this->item_model->get_item_list(6);
		
		$this->front->color_list = $this->product_color_model->search_all(['active' => 1]);
		$this->front->type_a_list = $this->product_type_a_model->search_all(['active' => 1]);
		$this->front->type_b_list = $this->product_type_b_model->search_all(['active' => 1 , 'top_id' => $this->front->data_row->type_a]);
		
		$this->load->view('control/product/edit_product' , $this->front);
	}

	
	public function add_product_post()
	{	
		$this->admin_model->is_login();
		
		$data = $this->input->post();
		
		//處理資料格式
		/*
		$brand = explode('_' , $data['brand']);
		$data['brand_id'] = $brand[0];
		$data['brand'] = $brand[1];
		*/
		
		/*
		$type = explode('_' , $data['type']);
		$data['type_id'] = $type[0];
		$data['type'] = $type[1];
		*/
		
		$img = explode(',' , $data['img_list']);
		$data['img'] = $img[0];
		
		// $data['create_at'] = date('Y-m-d H:i:s');
		$data['last_edit'] = date('Y-m-d H:i:s');
		
		// 價格將採用product_type
		// if (!isset($data['price']) || $data['price'] <= 0)
		// {
			// js_go_back('價格未輸入或不能為0');
			// exit();
		// }
		
		/*
		// 處理特價
		if (isset($data['discount_active']) && $data['discount_active'] == 0)
		{
			$data['discount_end_date'] = '';
			$data['discount_price'] = '';
		}
		
		// 檢查特價價格保護
		if (isset($data['discount_active']) && $data['discount_active'] == 1)
		{
			if ($data['discount_price'] <= 0)
			{
				js_go_back('特價價格未輸入或不能為0');
				exit();
			}
		}
		*/
		
		$data['color'] = $data['color_list'];
		// $data['degree'] = $data['degree_list'];
		
		// $data['shipping_methods'] = isset($data['shipping_methods_list'])?$data['shipping_methods_list']:'到店取貨';
		
		$result = $this->product_model->add_product($data);
		
		// 產生rule_main
		/*
		$this->load->model('rule_main_model');
		$this->rule_main_model->create_rule_list();
		*/
		
		if ($result)
		{
			js_go_msg(site_url('/control/product/index') , '新增成功');
			exit();
		}
		else
		{
			js_go_back('新增失敗');
			exit();
		}
	}
	
	
	public function edit_product_post()
	{	
		$this->admin_model->is_login();
		
		$data = $this->input->post();
		
		/*
		//處理資料格式
		$brand = explode('_' , $data['brand']);
		$data['brand_id'] = $brand[0];
		$data['brand'] = $brand[1];
		*/
		
		/*
		$type = explode('_' , $data['type']);
		$data['type_id'] = $type[0];
		$data['type'] = $type[1];
		*/
		
		$img = explode(',' , $data['img_list']);
		$data['img'] = $img[0];
		
		// $data['create_at'] = date('Y-m-d H:i:s');
		$data['last_edit'] = date('Y-m-d H:i:s');
		
		// 價格將採用product_type
		// if (!isset($data['price']) || $data['price'] <= 0)
		// {
			// js_go_back('價格未輸入或不能為0');
			// exit();
		// }
		
		
		/*
		// 處理特價
		if (isset($data['discount_active']) && $data['discount_active'] == 0)
		{
			$data['discount_end_date'] = '';
			$data['discount_price'] = '';
		}
		
		// 檢查特價價格保護
		if (isset($data['discount_active']) && $data['discount_active'] == 1)
		{
			if ($data['discount_price'] <= 0)
			{
				js_go_back('特價價格未輸入或不能為0');
				exit();
			}
		}
		*/
		
		
		$data['color'] = $data['color_list'];
		// $data['degree'] = $data['degree_list'];
		// $data['shipping_methods'] = isset($data['shipping_methods_list'])?$data['shipping_methods_list']:'到店取貨';
		
		$result = $this->product_model->edit_product($data);
		
		/*
		// 產生rule_mail
		$this->load->model('rule_main_model');
		$this->rule_main_model->create_rule_list();
		*/
		
		if ($result)
		{
			js_go_msg(site_url('/control/product/index') , '修改成功');
			exit();
		}
		else
		{
			js_go_back('新增失敗');
			exit();
		}
	}
	
	
	public function del_product()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$result = $this->product_model->del_product($id);
		
		if ($result)
		{
			echo json_encode(array('status' => 'T' , 'msg' => '刪除成功'));
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'msg' => '刪除失敗'));
		exit();
	}
	
	
	/**
	 * param file
	 *
	 */
	public function dropzone_file()
	{
		$this->load->model('admin_model');
		$this->load->model('file_model');
		$this->load->model('upload_model');
		
		$this->admin_model->is_login_ajax();
		
		$alt = $this->input->post('alt' , TRUE);
		
		$config['upload_path'] = './uploads/images/';
		$config['allowed_types'] = 'jpeg|jpg|gif|png';
		
		$response = $this->file_model->move('file' , $config);
		
		if (!$response)
		{
			echo json_encode(array('status' => 'F' , 'msg' => '檔案上傳發生錯誤' , 'url' => ''));
		}
		
		$response['alt'] = $alt;
		
		$id = $this->upload_model->add_uploads($response);
		
		$id = (int) $id;
		
		if (!$id)
		{
			echo json_encode(array('status' => 'F' , 'msg' => '檔案上傳發生錯誤' , 'url' => ''));
			exit();
		}
		
		$uploads = $this->upload_model->get_uploads_one($id);
		
		if ($uploads->is_image == 1)
		{
			$file_url = img_show($uploads->file_name);
			echo json_encode(array('status' => 'T' , 'msg' => '' , 'url' => $file_url , 'img_id' => $uploads->id));
			exit();
		}
		else
		{
			echo json_encode(array('status' => 'F' , 'msg' => '檔案格式錯誤' , 'url' => ''));
			exit();
		}
	}
	
	
	public function dropzone_update()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		$mask = $this->input->post('mask' , TRUE);
		$rand = $this->input->post('rand' , TRUE);
		
		$result = $this->upload_model->edit_uploads_mask_rand($id , $mask , $rand);
		
		if ($result)
		{
			echo json_encode(array('status' => 'T' , 'msg' => '成功' , 'img_id' => $id));
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'msg' => '寫入失敗' , 'img_id' => $id));
		exit();
	}
	
	
	public function dropzone_remove()
	{	
		$this->admin_model->is_login_ajax();
		
		// var_dump($_POST);
		
		$id = $this->input->post('id' , TRUE);
		
		// log_message('ERROR' , $id);
		
		$this->upload_model->del_uploads($id);
	}
	
	
	public function change_active()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		$active = $this->input->post('checkeds' , TRUE);
		
		$result = $this->product_model->change_product_active($id , $active);
		
		if ($result)
		{
			echo json_encode(array('status'=>'T'));
			exit();
		}
		
		echo json_encode(array('status'=>'F'));
		exit();
	}

	public function change_length()
	{
		$this->admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		$length = $this->input->post('checkeds' , TRUE);
		
		$result = $this->product_model->change_product_length($id , $length);
		//log_message('error','r='.$result);
		if ($result)
		{
			echo json_encode(array('status'=>'T'));
			exit();
		}
		
		echo json_encode(array('status'=>'F'));
		exit();
	}	
	
	
	public function edit_page_html($page = FALSE)
	{
		if (!$page)
		{
			js_go_back('page is not found');
			exit();
		}
		
		$this->admin_model->is_login();
		
		$html = $this->page_model->get_html($page);
		
		if (!$html)
		{
			$this->page_model->write_cache($page , '');
			
			$html = $this->page_model->get_html();
		}
		
		$this->front->page_id = $page;
		
		$this->front->page_html = $html;
		
		unset($html);
		
		$this->load->view('/control/page/edit_page_html' , $this->front);
	}
	
	
	public function edit_page_html_post()
	{
		$this->admin_model->is_login_ajax();
		
		$page = $this->input->post('page_id' , TRUE);
		
		$html = $this->input->post('html');
		
		$result = $this->page_model->write_cache($page , $html);
		
		if ($result)
		{
			echo json_encode(array('status' => 'T' , 'msg' => '儲存成功'));
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'msg' => '儲存失敗'));
		exit();
	}
	
	
	public function get_type_b_list()
	{
		$this->admin_model->is_login_ajax();
	
		$type_a = $this->input->post('type_a' , TRUE);
		
		$data_list = $this->product_type_b_model->search_all(['active' => 1 , 'top_id' => $type_a]);
		$html = '';
		
		foreach($data_list as $key => $row)
		{
			$html.= "<option value='{$row->id}'>{$row->title}</option>";
		}
		
		echo json_encode(['status' => 'T' , 'html' => $html]);
		exit();
	}
	
	
	public function home_list()
	{
		$this->front->page_title = array(
			'title' => '首頁產品設定',
			'bread_crumb' => array('管理首頁' => '/control/' , '產品' => '#' , '首頁產品設定' => '/control/product/home_list')
		);
	
		$this->admin_model->is_login();
		
		$this->front->data_list = json_decode(get_cache('meta/home_list.json') , TRUE);
		
		if ($this->front->data_list == FALSE) $this->front->data_list = ['product_list' => ''];
		
		$this->load->view('/control/product/home_list' , $this->front);
	}
	
	
	public function edit_home_list()
	{
		$this->admin_model->is_login();
		
		$data = array();
		$data['product_list'] = $this->input->post('product_list' , TRUE);
		
		set_cache('meta/home_list.json' , json_encode($data));
	
		js_go_msg('/control/product/home_list' , '修改完成');
		exit();
	}
}
//end of file Product.php