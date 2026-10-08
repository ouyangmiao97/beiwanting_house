<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {
	
	// 資料表
	public $_table = '';
	
	// 檢查欄位
	public $_checkfields = array();
	
	// 預設上傳格式
	public $img_config = array(
			'upload_path' => './uploads/images/',
			'allowed_types' => 'jpeg|jpg|gif|png',
	);
	
	public $error_msg = '';
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function __destruct()
	{
		
	}
	
	/**
	 * 圖片處理
	 * @param string $filename 
	 * @param string $alt
	 * 
	 * @return interger $img_id | 0
	 */
	public function img_process($filename = '' , $alt = '' , $img_config = FALSE)
	{
		// 載入需用到的模組
		$this->load->model('file_model');
		$this->load->model('upload_model');
		
		// 取得設定檔
		if ($img_config == FALSE)
		{
			$img_config = $this->img_config;
		}
		
		// 搬移圖片
		$img = $this->file_model->move($filename , $img_config);
		
		if ($img)
		{
			$img['alt'] = $alt;
			
			$img_id = $this->upload_model->add_uploads($img);
			
			return (int) $img_id;
		}
		
		return 0;
	}
	
	
	public function _add($data = array())
	{
		$response = $this->db->insert($this->_table , $data);
		
		if ($response) return TRUE;
		
		$this->error_msg = '資料寫入失敗！';
		return FALSE;
	}
	
	
	public function _edit($data = array())
	{
		$id = isset($data['id'])?$data['id']:FALSE;
		unset($data['id']);
		
		if (!$id) return FALSE;
		
		$this->db->where('id' , $id);
		return $this->db->update($this->_table , $data);
	}
	
	
	public function _del($id = FALSE)
	{
		if (!$id) return FALSE;
		
		$this->db->where('id' , $id);
		return $this->db->delete($this->_table);
	}
	
	
	public function _get_all_list()
	{
		$query = $this->db->get($this->_table);
		return $query->result();
	}
	
	
	public function _get_one($id = FALSE)
	{
		if (!$id) return FALSE;
		$this->db->where('id' , $id);
		$query = $this->db->get($this->_table);
		
		return $query->row();
	}
	
	
	public function _get_list($page = 0 , $limit = 20)
	{
		if ($page == 0) $page = 1;
		$start = ($page - 1 ) * $limit;
		
		$this->db->limit($limit , $start);
		$query = $this->db->get($this->_table);
		
		return $query->result();
	}
	
	
	public function _get_list_count()
	{
		$this->db->from($this->_table);
		
		return $this->db->count_all_results();
	}
	
	
	public function _change_active($id = FALSE , $active = FALSE)
	{
		if (!$id) return FALSE;
		
		$this->db->where('id' , $id);
		return $this->db->update($this->_table , array('active' => $active));
	}
	
	
	public function _checkfields($data = array())
	{
		foreach($this->_checkfields as $k => $v)
		{
			if (!isset($data[$v]) || $data[$v] == FALSE)
			{
				$this->error_msg = '很抱歉，您有必填欄位未填寫，請確認您的欄位資料是否都已填寫';
				return FALSE;
				break;
			}
		}
		
		return TRUE;
	}
}


class MY_ZH_Model extends CI_Model {
	
	// 寫入對象資料表名稱
	public $table = '';
	
	// 錯誤訊息
	public $error_msg = '';
	
	/** 以下為模組設定 **/
	
	// 是否在建立資料時自動寫入建立日期 (資料表必須要有create_at欄位)
	private $auto_create_time = TRUE;
	
	// 是否再修改資料時自動寫入修改日期 (資料表必須要有edit_at欄位)
	private $auto_edit_time = TRUE;
	
	// 預設List撈取筆數
	public $limit = 20;
	
	// 檔案上傳的設定
	public $file_upload_config = [
		'upload_path' => './uploads/download/',
		'allowed_types' => 'pdf|ppt|pptx|doc|docx|txt|text|xlsx|xls|mp4|mp3|zip|rar|gtar|gz|gzip|7zip|wma|wmv|jpeg|jpg|gif|png|ai',
		'overwrite' => FALSE,
		'max_size' => 102400,
		'max_width' => 0,
		'max_height' => 0,
		'max_filename' => 0,
		'encrypt_name' => TRUE,
		'remove_spaces' => TRUE
	];
	
	public $img_upload_config = [
		'upload_path' => './uploads/images/',
		'allowed_types' => 'jpeg|jpg|gif|png',
	];
	
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	// 新增資料
	public function add($data = FALSE)
	{
		$data = (object) $data;
		
		if ($this->auto_create_time)
		{
			$data->create_at = date('Y-m-d H:i:s');
		}
		
		$response = $this->db->insert($this->table , $data);
		
		if ($response) return TRUE;
		
		$this->error_msg = '寫入資料庫發生錯誤';
		return FALSE;
	}
	
	
	// 修改資料
	public function edit($data = FALSE)
	{
		$data = (object) $data;
		
		if ($this->auto_edit_time)
		{
			$data->edit_at = date('Y-m-d H:i:s');
		}
		
		$id = isset($data->id)?$data->id:FALSE;
		unset($data->id);
		if ($id == FALSE)
		{
			$this->error_msg = '$data參數中未找到id';
			return FALSE;
		}
		
		$this->db->where('id' , $id);
		$response = $this->db->update($this->table , $data);
		
		if ($response) return TRUE;
		
		$this->error_msg = '寫入資料庫發生錯誤';
		return FALSE;
	}
	
	
	// 刪除資料
	public function del($id = FALSE)
	{
		if ($id == FALSE)
		{
			$this->error_msg = '$id參數未輸入';
			return FALSE;
		}
		
		$this->db->where('id' , $id);
		$response = $this->db->delete($this->table);
		
		if ($response) return TRUE;
		
		$this->error_msg = '寫入資料庫發生錯誤';
		return FALSE;
	}
	
	
	// 取得單筆
	public function get_one($value = FALSE , $field = 'id')
	{
		if ($value == FALSE)
		{
			$this->error_msg = '$value參數未輸入';
			return FALSE;
		}
		
		$this->db->where($field , $value);
		$query = $this->db->get($this->table);
		
		return $query->row();
	}
	
	
	// 取得隨機一筆資料
	public function get_rand_one($kv = [])
	{
		foreach($kv as $field => $value)
		{
			$this->db->where($field , $value);
		}
		
		$this->db->order_by("rand()");
		$this->db->limit(1);
		$query = $this->db->get($this->table);
		
		return $query->row();
	}
	
	
	// 取得隨機多筆資料
	public function get_rand_list($kv = [] , $limit = 10)
	{
		foreach($kv as $field => $value)
		{
			$this->db->where($field , $value);
		}
		
		$this->db->order_by("rand()");
		$this->db->limit($limit);
		$query = $this->db->get($this->table);
		
		return $query->result();
	}
	
	
	// 取得全部資料
	public function get_all_list($order_by = [])
	{
		foreach($order_by as $field => $value)
		{
			$this->db->order_by($field , $value);
		}
		
		$query = $this->db->get($this->table);
		return $query->result();
	}
	
	
	// 取得部分資料
	public function get_list($page = 0 , $order_by = [])
	{
		if ($page == 0) $page = 1;
		$start = ($page - 1 ) * $this->limit;
		
		$this->db->limit($this->limit , $start);
		
		foreach($order_by as $field => $value)
		{
			$this->db->order_by($field , $value);
		}
		
		$query = $this->db->get($this->table);
		
		return $query->result();
	}
	
	
	// 取得資料總數
	public function get_list_count()
	{
		$this->db->from($this->table);
		
		return $this->db->count_all_results();
	}
	
	
	public function search_one($kv = [])
	{
		if ($kv == FALSE)
		{
			$this->error_msg = '$kv參數未輸入';
			return FALSE;
		}
		
		foreach($kv as $field => $value)
		{
			$this->db->where($field , $value);
		}
		
		$query = $this->db->get($this->table);
		
		return $query->row();
	}
	
	
	// 查詢資料
	public function search_all($kv = [] , $order_by = [])
	{
		if ($kv == FALSE)
		{
			$this->error_msg = '$kv參數未輸入';
			return FALSE;
		}
		
		foreach($kv as $field => $value)
		{
			$this->db->where($field , $value);
		}
		
		foreach($order_by as $field => $value)
		{
			$this->db->order_by($field , $value);
		}
		
		$query = $this->db->get($this->table);
		
		return $query->result();
	}
	
	
	// 查詢資料
	public function search_list($kv = [] , $page = 0 , $order_by = [])
	{
		if ($kv == FALSE)
		{
			$this->error_msg = '$kv參數未輸入';
			return FALSE;
		}
		
		foreach($kv as $field => $value)
		{
			$this->db->where($field , $value);
		}
		
		if ($page == 0) $page = 1;
		$start = ($page - 1 ) * $this->limit;
		
		$this->db->limit($this->limit , $start);
		
		foreach($order_by as $field => $value)
		{
			$this->db->order_by($field , $value);
		}
		
		$query = $this->db->get($this->table);
		
		return $query->result();
	}
	
	
	// 搜尋條件下的資料總數
	public function search_list_count($kv = [])
	{
		if ($kv == FALSE)
		{
			$this->error_msg = '$kv參數未輸入';
			return FALSE;
		}
		
		foreach($kv as $field => $value)
		{
			$this->db->where($field , $value);
		}
		
		$this->db->from($this->table);
		
		return $this->db->count_all_results();
	}
	
	
	// 取得下一個排序鍵
	public function get_next_sort_key()
	{
		$this->db->order_by('sort_key' , 'desc');
		$query = $this->db->get($this->table);
		
		$row = $query->row();
		
		if ($row != FALSE && isset($row->sort_key))
		{
			return $row->sort_key + 1;
		}
		else
		{
			return 1;
		}
	}
	
	
	// 交換兩筆資料的排序鍵
	public function change_sort_key($id1 = FALSE , $id2 = FALSE)
	{
		if (!$id1 || !$id2) return FALSE;
		
		$row1 = $this->get_one($id1);
		$row2 = $this->get_one($id2);
		
		if ($row1 == FALSE || $row2 == FALSE) return FALSE;
		
		$this->edit(['id' => $row1->id , 'sort_key' => $row2->sort_key]);
		$this->edit(['id' => $row2->id , 'sort_key' => $row1->sort_key]);
		
		return TRUE;
	}
	
	
	// 檔案上傳
	public function file_upload($filename = FALSE , $filename_rule = FALSE , $target_path = '/uploads/')
	{
		// 檢查資料
		if ($filename == FALSE || $filename_rule == FALSE)
		{
			$this->error_msg = '參數錯誤';
			return FALSE;
		}
		
		// 建立目錄並取得路徑
		$path = $this->create_upload_dir($target_path);
		
		// 設定目錄
		$this->file_upload_config['upload_path'] = '.' . $path;
		if ($filename_rule == 1) $this->file_upload_config['encrypt_name'] = FALSE;
		if ($filename_rule == 2) $this->file_upload_config['encrypt_name'] = TRUE;
		
		// 使用取得後的設定使用CI upload
		$this->load->library('upload' , $this->file_upload_config);
		
		// 搬移檔案
		$upload_state = $this->upload->do_upload($filename);
		
		if ($upload_state == FALSE)
		{
			$this->error_msg = '檔案上傳失敗，錯誤訊息：' . $this->upload->display_errors();
			return FALSE;
		}
		
		// 搬移成功取得檔案資訊
		$info = $this->upload->data();
		$info['www_path'] = $path . $info['file_name'];
		
		return $info;
	}
	
	
	// 建立上傳檔案目錄
	private function create_upload_dir($target_path = "/uploads/")
	{
		$path = $target_path . date('Y_m_d') . '/';
		$path2 = '.' . $path;
		
		if (is_dir($path2) == FALSE)
		{
			@mkdir($path2);
			@chmod($path2 , 0777);
			
			if (is_dir($path2) == FALSE)
			{
				$this->error_msg = '建立目錄失敗';
				return FALSE;
			}
		}
		
		return $path;
	}
	
	// 清除檔案
	public function file_remove($id = FALSE)
	{
		$row = $this->get_one($id);
		
		if ($row == FALSE)
		{
			$this->error_msg = '查無資料';
			return FALSE;
		}
		
		if (isset($row->full_path) == FALSE)
		{
			$this->error_msg = '查無路徑欄位';
			return FALSE;	
		}
		
		@unlink($row->full_path);
		return TRUE;
	}
	
	
	/**
	 * 圖片處理
	 * @param string $filename 
	 * @param string $alt
	 * 
	 * @return interger $img_id | 0
	 */
	public function img_process($filename = '' , $alt = '' , $img_config = FALSE)
	{
		// 載入需用到的模組
		$this->load->model('file_model');
		$this->load->model('upload_model');
		
		// 取得設定檔
		if ($img_config == FALSE)
		{
			$img_config = $this->img_upload_config;
		}
		
		// 搬移圖片
		$img = $this->file_model->move($filename , $img_config);
		
		if ($img)
		{
			$img['alt'] = $alt;
			
			$img_id = $this->upload_model->add_uploads($img);
			
			return (int) $img_id;
		}
		
		return 0;
	}
	
}