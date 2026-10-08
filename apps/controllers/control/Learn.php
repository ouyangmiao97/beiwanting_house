<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Learn extends MY_Controller {

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
		
		$this->load->model('zh_tech_admin_model');
		
		$this->load->model('banner_model');
		
		$this->load->model('zh_tech_file_model');
		
		$this->load->model('upload_model');
		
		$this->load->model('website_model');
		
		$this->load->model('meta_model');
		
		$this->load->model('zh_tech_menu_model');
		
		$this->load->model('learn_model');
		
		$this->load->model('page_model');
		
	}
	
	
	public function __destruct()
	{
		parent::__destruct();
	}

	
	public function index()
	{
		$this->zh_tech_admin_model->is_login();
		
		$this->front->web_meta = $this->meta_model->get_meta('learn');
		
		$this->front->page_title = array(
			'title' => '學習網',
			'bread_crumb' => array('管理首頁' => '/control/' , '學習網' => '/control/learn/learn')
		);
		
		$this->load->view('/control/learn/learn' , $this->front);
	}
	
	
	public function learn_post()
	{
		$this->zh_tech_admin_model->is_login();
		
		$meta = array();
		
		$meta['web_title'] = $this->input->post('web_title' , TRUE);
		$meta['web_title_end'] = $this->input->post('web_title_end' , TRUE);
		$meta['web_author'] = $this->input->post('web_author' , TRUE);
		$meta['web_description'] = $this->input->post('web_description' , TRUE);
		$meta['web_keywords'] = $this->input->post('web_keywords' , TRUE);
		
		$result = $this->meta_model->set_meta($meta , 'learn');
		
		if ($result)
		{
			js_go_msg('/control/learn/index' , '修改完成');
			exit();
		}
		
		js_go_back('修改失敗');
		exit();
		
	}
	
	
	public function media_type()
	{
		$this->zh_tech_admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => '主項目管理',
			'bread_crumb' => array('管理首頁' => '/control/' , '主項目管理' => '/control/learn/media_type')
		);
		
		$this->front->data_list = $this->learn_model->get_media_type_list();
		
		$this->load->view('/control/learn/media_type' , $this->front);
	}
	
	
	public function add_media_type()
	{
		$this->zh_tech_admin_model->is_login_ajax();
		
		$title = $this->input->post('title' , TRUE);
		
		$description = $this->input->post('description' , TRUE);
		
		$keywords = $this->input->post('keywords' , TRUE);
		
		$response = $this->learn_model->add_media_type($title , $description , $keywords);
		
		echo json_encode($response);
	}
	
	
	public function edit_media_type()
	{
		$this->zh_tech_admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$title = $this->input->post('title' , TRUE);
		
		$description = $this->input->post('description' , TRUE);
		
		$keywords = $this->input->post('keywords' , TRUE);
		
		$response = $this->learn_model->edit_media_type($id , $title , $description , $keywords);
		
		echo json_encode($response);
	}
	
	
	public function del_media_type()
	{
		$this->zh_tech_admin_model->is_login_ajax();
		
		$id = $this->input->post('id');
		
		$response = $this->learn_model->del_media_type($id);
		
		echo json_encode($response);
	}
	
	
	public function media()
	{
		$this->zh_tech_admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => '內容管理',
			'bread_crumb' => array('管理首頁' => '/control/' , '內容管理' => '/control/learn/media')
		);
		
		$this->front->main_list = $this->learn_model->get_media_type_list();
		
		if (!$this->front->main_list || count($this->front->main_list) == 0) 
		{
			js_go_back('請先設定主項目，再進行內容管理！');
			exit();
		}
		
		$main_list = array();
		
		foreach($this->front->main_list as $key => $row)
		{
			$main_list[$row->id] = $row;
		}
		
		$this->front->main_list = $main_list;
		
		unset($main_list);
		
		
		$this->front->data_list = $this->learn_model->get_media_list();
		
		foreach($this->front->data_list as $key => $row)
		{
			$this->front->data_list[$key]->img_file = $this->upload_model->get_cache($row->img_id);
		}
		
		$this->load->view('/control/learn/media' , $this->front);
	}
	
	
	public function add_media()
	{
		$this->zh_tech_admin_model->is_login_ajax();
		
		$title = $this->input->post('title' , TRUE);
		
		$type = $this->input->post('type' , TRUE);
		
		$active = $this->input->post('active' , TRUE);
		
		$youtube = $this->input->post('youtube' , TRUE);
		
		$img_alt = $this->input->post('img_alt' , TRUE);
		
		$text = $this->input->post('text' , TRUE);
		
		$description = $this->input->post('description' , TRUE);
		
		$keywords = $this->input->post('keywords' , TRUE);
		
		$youtube = youtube_uri_id($youtube);
		
		$img_id = 0;
		
		// if ($youtube == FALSE)
		// {
			$config = array();
			
			$config['upload_path'] = './uploads/images/';
			$config['allowed_types'] = 'jpeg|jpg|gif|png';
			
			$result = $this->zh_tech_file_model->move('img_file' , $config);
			
			if ($result == FALSE)
			{
				if ($youtube == FALSE)
				{
					echo json_encode(array('status'=>'F' , 'msg'=>$this->zh_tech_file_model->err_msg));
					exit();
				}
			}
			else
			{
				$result['alt'] = $img_alt;
				$img_id = $this->upload_model->add_uploads($result);
				
				if (!$img_id)
				{
					echo json_encode(array('status'=>'F' , 'msg'=>'圖片寫入失敗'));
					exit();
				}
			}
			
			
			
		
			
		// }
		
		$response = $this->learn_model->add_media( $type , $title , $youtube , $img_id , $text , $description , $keywords , $active);
		
		echo json_encode($response);
	}
	
	
	public function edit_media()
	{
		$this->zh_tech_admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$title = $this->input->post('title' , TRUE);
		
		$type = $this->input->post('type' , TRUE);
		
		$active = $this->input->post('active' , TRUE);
		
		$youtube = $this->input->post('youtube' , TRUE);
		
		$img_alt = $this->input->post('img_alt' , TRUE);
		
		$text = $this->input->post('text' , TRUE);
		
		$description = $this->input->post('description' , TRUE);
		
		$keywords = $this->input->post('keywords' , TRUE);
		
		$youtube = youtube_uri_id($youtube);
		
		$img_id = 0;
		
		$media = $this->learn_model->get_media_one($id);
		
		if (!$media)
		{
			echo json_encode(array('status' => 'F' , 'msg' => '無法取得舊資料'));
			exit();
		}
		
		// if ($youtube == FALSE)
		// {
			$config = array();
			
			$config['upload_path'] = './uploads/images/';
			$config['allowed_types'] = 'jpeg|jpg|gif|png';
			
			$result = $this->zh_tech_file_model->move('img_file' , $config);
			
			if ($result == FALSE && $media->img_id == 0 && $youtube == FALSE)
			{
				//如果上傳失敗 無檔 而且原本沒圖片
				echo json_encode(array('status'=>'F' , 'msg'=>$this->zh_tech_file_model->err_msg));
				exit();
			}
			else
			{
				
				if ($result != FALSE)
				{
					//檔案上傳成功
					$result['alt'] = $img_alt;
					$img_id = $this->upload_model->add_uploads($result);
					
					if (!$img_id && $media->img_id == 0)
					{
						echo json_encode(array('status'=>'F' , 'msg'=>'圖片寫入失敗'));
						exit();
					}
					
					//刪除舊圖片
					$this->upload_model->del_uploads($media->img_id);
				}
				else
				{
					//檔案上傳失敗 無上傳檔案
					if ($img_id == 0) $img_id = $media->img_id;
				}
			}
			
		if ($img_id == $media->img_id)
		{
			$this->upload_model->edit_uploads_alt($img_id , $img_alt);
		}
			
		if ($youtube == FALSE && $img_id == FALSE)
		{
			echo json_encode(array('status'=>'F' , 'msg'=>'圖片與youtube至少選擇一項'));
			exit();
		}
	
	
	
		// }
		// else
		// {
			// if ($media->img_id != 0)
			// {
				// 換成影片刪除舊有圖片
				// $this->upload_model->del_uploads($media->img_id);
				// $img_id = 0;
			// }
		// }
		
		$response = $this->learn_model->edit_media($id ,  $type , $title , $youtube , $img_id , $text , $description , $keywords , $active);
		
		echo json_encode($response);
	}
	
	
	public function edit_media_get_data()
	{
		$this->zh_tech_admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$media = $this->learn_model->get_media_one($id);
		
		if (!$media) exit();
		
		$img_file = $this->upload_model->get_cache($media->img_id);
		
		if ($img_file != FALSE)
		{
			$media->file_name = img_show($img_file->file_name);
			$media->img_alt = $img_file->alt;
		}
		else
		{
			$media->file_name = '';
			$media->img_alt = '';
		}
		
		
		echo json_encode($media);
	}
	
	
	public function del_media()
	{
		$this->zh_tech_admin_model->is_login_ajax();
		
		$id = $this->input->post('id' , TRUE);
		
		$response = $this->learn_model->del_media($id);
		
		echo json_encode($response);
	}
	
	
	public function banner()
	{
		$this->zh_tech_admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => '學習網Banner管理',
			'bread_crumb' => array('管理首頁' => '/control/' , '學習網Banner管理' => '/control/learn/banner')
		);
		
		$this->front->banner_list = $this->banner_model->get_banner_list(1 , 0);
		
		$this->load->view('/control/learn/banner' , $this->front);
	}
	
	
	public function add_banner()
	{
		$this->zh_tech_admin_model->is_login_ajax();
		
		$title = $this->input->post('title' , TRUE);
		
		$youtube = $this->input->post('youtube' , TRUE);
		
		$alt = $this->input->post('alt' , TRUE);
		
		$type = 1;
		
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
		
		$type = 1;
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
		
		$type = 1;
		
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
		
		$result = $this->banner_model->del_banner($id);
		
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
		$response['img'] = img_show($banner->file_name);
		$response['alt'] = $banner->alt;
		
		echo json_encode($response);
		exit();
	}
	
	
	public function menu()
	{		
		$this->zh_tech_admin_model->is_login();
		
		$this->front->page_title = array(
			'title' => '學習網選單管理',
			'bread_crumb' => array('管理首頁' => '/control/' , '學習網選單管理' => '/control/learn/menu')
		);
		
		$cache = $this->zh_tech_menu_model->get_cache_menu('zh_tech_learn_menu_cache_file' , 'zh_tech_learn_menu_default');
		
		// $this->front->menu_list = json_encode(array('core' => array('check_callback' => true,'data' => $cache , 'plugins' => array("contextmenu", "dnd", "search", "state", "types", "wholerow") )));
		
		$this->front->menu_list = $cache;
		
		$this->load->view('/control/learn/menu' , $this->front);
	}
	
	
	public function edit_menu()
	{
		$this->zh_tech_admin_model->is_login_ajax();
		
		$menu = $this->input->post('menu' , TRUE);
		
		$this->zh_tech_menu_model->set_cache_menu($menu , 'zh_tech_learn_menu_cache_file');
		
		echo json_encode(array('status' => 'T' , 'msg' => '傳送成功'));
		
		exit();
	}
	
	
	public function edit_learn_page()
	{
		$page = 'learn';
		
		$this->zh_tech_admin_model->is_login();
		
		$html = $this->page_model->get_html($page);
		
		if (!$html)
		{
			$this->page_model->write_cache($page , '');
			
			$html = $this->page_model->get_html();
		}
		
		$this->front->page_id = $page;
		
		$this->front->page_html = $html;
		
		unset($html);
		
		$this->load->view('/control/learn/edit_page_html' , $this->front);
	}
	
	public function edit_page_html_post($page = FALSE)
	{
		$this->zh_tech_admin_model->is_login_ajax();
		
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
}
//end of file Learn.php