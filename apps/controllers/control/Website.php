<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Website extends MY_Controller {

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
		
		$this->front->banner_type_list = array('0'=>'首頁Banner' , '1'=>'學習網Banner');
		
		$this->front->banner_active_list = array('-1' => '刪除' , '0' => '關閉' , '1' => '開啟');
		
		$this->load->model('admin_model');
		
		$this->load->model('banner_model');
		
		$this->load->model('file_model');
		
		$this->load->model('upload_model');
		
		$this->load->model('website_model');
		
		
	}
	
	
	public function __destruct()
	{
		parent::__destruct();
	}

	
	public function index()
	{
		
	}
	
	
	public function banner()
	{
		$this->zh_tech_admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => '首頁Banner管理',
			'bread_crumb' => array('管理首頁' => '/control/' , '首頁Banner管理' => '/control/website/banner')
		);
		
		$this->front->banner_list = $this->banner_model->get_banner_list(0 , 0);
		
		$this->load->view('/control/website/banner' , $this->front);
	}
	
	
	public function add_banner()
	{
		$this->zh_tech_admin_model->is_login_ajax();
		
		$title = $this->input->post('title' , TRUE);
		
		$youtube = $this->input->post('youtube' , TRUE);
		
		$alt = $this->input->post('alt' , TRUE);
		
		$type = 0;
		
		$active = 1;
		
		if($youtube == FALSE){
		
			$config = array();
			
			$config['upload_path'] = './uploads/images/';
			// $config['upload_path'] = APPPATH . '/cache/';
			$config['allowed_types'] = 'jpeg|jpg|gif|png';
			
			$result = $this->zh_tech_file_model->move('banner_file' , $config);
			
			if ($result == FALSE)
			{
				echo json_encode(array('status'=>'F' , 'msg'=>$this->zh_tech_file_model->err_msg));
				exit();
			}
			
			$result['alt'] = $alt;
			
			$img_id = $this->upload_model->add_uploads($result);
			
			if (!$img_id)
			{
				echo json_encode(array('status'=>'F' , 'msg'=>'圖片寫入失敗'));
				exit();
			}
		
		}
		else
		{
			$img_id = 0;
		}
		
		$response = $this->banner_model->add_banner($title , $img_id , $youtube , $type , $active);
		
		echo json_encode($response);
		exit();
	}
	
	
	public function edit_banner()
	{
		$this->zh_tech_admin_model->is_login_ajax();
		
		$id = $this->input->post('edit_id' , TRUE);
		$title = $this->input->post('edit_title' , TRUE);
		$alt = $this->input->post('edit_alt' , TRUE);
		
		$youtube = $this->input->post('edit_youtube' , TRUE);
		
		$type = 0;
		$active = 1;
		
		$banner = $this->banner_model->get_banner_one($id);
		$img_id = $banner->img_id;
		
		if($youtube == FALSE){
		
			$config = array();
			
			$config['upload_path'] = './uploads/images/';
			$config['allowed_types'] = 'jpeg|jpg|gif|png';
			
			$result = $this->zh_tech_file_model->move('edit_banner_file' , $config);
			
			if ($result)
			{
				$this->upload_model->del_uploads($banner->img_id);
				
				$result['alt'] = $alt;
				
				$img_id = $this->upload_model->add_uploads($result);
			}
			
			if (!$img_id)
			{
				echo json_encode(array('status'=>'F' , 'msg'=>'圖片寫入失敗'));
				exit();
			}
			
			$this->upload_model->edit_uploads_alt($img_id , $alt);
		
		}
		else
		{
			$img_id = 0;
		}
		
		$response = $this->banner_model->edit_banner($id , $title , $img_id , $youtube , $type , $active);
		
		echo json_encode($response);
		exit();
		
	}
	
	
	public function del_banner()
	{
		$this->zh_tech_admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$banner = $this->banner_model->get_banner_one($id);
		
		$type = 0;
		
		if ($banner->img_id != FALSE)
		{
			$result = $this->upload_model->del_uploads($banner->img_id);
		}
		else
		{
			$result = TRUE;
		}
		
		if (!$result) 
		{
			echo json_encode(array('status'=>'F' , 'msg'=>'檔案刪除失敗'));
			exit();
		}
		
		$result = $this->banner_model->del_banner($id , $type);
		
		echo json_encode($result);
	}
	
	
	public function edit_banner_get_data()
	{
		$this->zh_tech_admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$banner = $this->banner_model->get_banner_one($id);
		
		
		// echo json_encode($_POST);
		
		$response = array();
		
		$response['title'] = $banner->title;
		$response['status'] = $banner->active;
		$response['youtube'] = $banner->youtube;
		$response['img'] = img_show($banner->file_name);
		$response['alt'] = $banner->alt;
		$response['orderno'] = $banner->orderno;
		
		echo json_encode($response);
		exit();
	}
	
	
	public function column()
	{
		$this->zh_tech_admin_model->is_login();
		
		$this->front->web_meta = $this->website_model->get_index_meta();
		
		$this->front->page_title = array(
			'title' => '首頁管理',
			'bread_crumb' => array('管理首頁' => '/control/' , '首頁管理' => '/control/website/column')
		);
		
		$this->front->data_list = $this->website_model->get_column_list();
		
		$this->front->column_type_list = array(1 => '4商品+n滑動' , 2 => '8商品+1圖片' , 3 => '1圖片');
		
		$this->load->view('/control/website/column' , $this->front);
	}
	
	public function meta()
	{
		$this->zh_tech_admin_model->is_login();
		
		$meta = array();
		
		$meta['web_title'] = $this->input->post('web_title' , TRUE);
		$meta['web_title_end'] = $this->input->post('web_title_end' , TRUE);
		$meta['web_author'] = $this->input->post('web_author' , TRUE);
		$meta['web_description'] = $this->input->post('web_description' , TRUE);
		$meta['web_keywords'] = $this->input->post('web_keywords' , TRUE);
		
		$result = $this->website_model->set_index_meta($meta);
		
		if ($result)
		{
			js_go_msg('/control/website/column' , '修改完成');
			exit();
		}
		
		js_go_back('修改失敗');
		exit();
	}
	
	
	public function add_column()
	{
		$this->zh_tech_admin_model->is_login_ajax();
		
		$title = $this->input->post('title' , TRUE);
		
		$orderno = $this->input->post('orderno' , TRUE);
		
		$type = $this->input->post('type' , TRUE);
		
		$more = $this->input->post('more' , TRUE);
		
		$img_id = 0;
		
		$img_alt= $this->input->post('img_alt' , TRUE);
		
		$img_url = $this->input->post('img_url' , TRUE);
		
		$pro_list = $this->input->post('pro_list' , TRUE);
		
		if ($type == 2 || $type == 3)
		{
			$config = array();
			
			$config['upload_path'] = './uploads/images/';
			$config['allowed_types'] = 'jpeg|jpg|gif|png';
			
			$result = $this->zh_tech_file_model->move('img_file' , $config);
			
			if ($result == FALSE)
			{
				echo json_encode(array('status'=>'F' , 'msg'=>$this->zh_tech_file_model->err_msg));
				exit();
			}

			$result['alt'] = $img_alt;
			$img_id = $this->upload_model->add_uploads($result);
		
			if (!$img_id)
			{
				echo json_encode(array('status'=>'F' , 'msg'=>'圖片寫入失敗'));
				exit();
			}
			
			if ($type == 2)
			{
				$response = $this->website_model->add_column($title , $type , $more , $img_id , $img_url , $pro_list , $orderno);
			}
			else
			{
				$response = $this->website_model->add_column($title , $type , $more , $img_id , $img_url , '',$orderno);
			}
			
			if ($response['status'] == 'F')
			{
				$this->upload_model->del_uploads($img_id);
			}
			
			echo json_encode($response);
			exit();
		}
		else if ($type == 1)
		{
			$response = $this->website_model->add_column($title , $type , '' , 0 , '' , $pro_list , $orderno);
			
			echo json_encode($response);
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'msg' => 'type error'));
		exit();
		
	}
	
	
	public function edit_column()
	{
		$this->zh_tech_admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$title = $this->input->post('title' , TRUE);
		
		$orderno = $this->input->post('orderno' , TRUE);
		
		$type = $this->input->post('type' , TRUE);
		
		$more = $this->input->post('more' , TRUE);
		
		$img_id = 0;
		
		$img_alt= $this->input->post('img_alt' , TRUE);
		
		$img_url = $this->input->post('img_url' , TRUE);
		
		$pro_list = $this->input->post('pro_list' , TRUE);
		
		$column = $this->website_model->get_column_one($id);
		
		if ($type == 2 || $type == 3)
		{
			$config = array();
			
			$config['upload_path'] = './uploads/images/';
			$config['allowed_types'] = 'jpeg|jpg|gif|png';
			
			$result = $this->zh_tech_file_model->move('img_file' , $config);
			
			if ($result)
			{
				$result['alt'] = $img_alt;
				$img_id = $this->upload_model->add_uploads($result);
			}
			else
			{
				$this->upload_model->edit_uploads_alt($column->img_id , $img_alt);
			}
		
			if (!$img_id)
			{
				$img_id = $column->img_id;
			}
			
			if ($type == 2)
			{
				$response = $this->website_model->edit_column($id , $title , $type , $more , $img_id , $img_url , $pro_list , $orderno);
			}
			else
			{
				$response = $this->website_model->edit_column($id , $title , $type , $more , $img_id , $img_url , '' , $orderno);
			}
			
			if ($response['status'] == 'F')
			{
				$this->upload_model->del_uploads($img_id);
			}
			else
			{
				if ($img_id != 0 && $column->img_id != $img_id)
				{
					$this->upload_model->del_uploads($column->img_id);
				}
			}
			
			echo json_encode($response);
			exit();
		}
		else if ($type == 1)
		{
			$response = $this->website_model->edit_column($id , $title , $type , '' , 0 , '' , $pro_list , $orderno);
			
			echo json_encode($response);
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'msg' => 'type error'));
		exit();
		
	}
	
	
	public function edit_column_get_data()
	{
		$this->zh_tech_admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$result = $this->website_model->get_column_one($id);
		
		echo json_encode($result);
		
		exit();
	}
	
	
	public function del_column()
	{
		$this->zh_tech_admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$result = $this->website_model->del_column($id);
		
		echo json_encode($result);
		
		exit();
	}
	
}
//end of file Website.php