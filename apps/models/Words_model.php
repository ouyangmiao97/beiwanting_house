<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Words_model extends CI_Model {
	/**
	 * Learn Model
	 * 
	 * @package		: zh-tech
	 * @copyright	: zh-tech 振華科技
	 * @author		: Tone
	 * @depend		: upload_model,file_model,zh_tech_helper
	 *
	 */
	private $words_database = 'words';
	
	private $words_defaults = array(
		'id' => null,
		'banner_type' => 0,
		'title' => '',
		'active' => 1,
		'type' => 1,
		'img_id' => 0,
		'youtube' => '',
		'words' => '',
		'description' => '',
		'keywords' => '',
		'url' => '',
		'create_at' => ''
	);
	
	private $img_config = array(
			'upload_path' => './uploads/images/',
			'allowed_types' => 'jpeg|jpg|gif|png',
	);
	
	public $words_types = array(
		0=>array('title' => '最新優惠' , 'type' => 0),
		// 1=>array('title' => '常見問題' , 'type' => 0),
		1=>array('title' => '經驗分享' , 'type' => 1),
	);
	
	public function __construct()
	{
		parent::__construct();
		
		if (!isset($this->upload_model)) $this->load->model('upload_model');
		if (!isset($this->file_model)) $this->load->model('file_model');
	}
	
	
	public function __destruct()
	{
		
	}
	
	
	public function get_one_open($id = FALSE , $type = FALSE)
	{
		if ($id === FALSE || $type === FALSE) return FALSE;
		
		$sql = "SELECT * FROM {$this->words_database} WHERE active = '1' AND id = ? AND type = ? ";
		$query = $this->db->query($sql , array($id , $type));
		
		$row = $query->row();
		$query->free_result();
		
		if ($row != FALSE)
		{
			$row->img_file = $this->upload_model->get_cache($row->img_id);
		}
		
		
		return $row;
	}
	
	
	public function get_list_index($type = 0)
	{
		if (!array_key_exists($type , $this->words_types)) $type = 0;
		
		$rows = 5;
		
		if ($type == 0)$rows = 2;
		
		$sql = "SELECT * FROM {$this->words_database} WHERE active = '1' AND type = ? ORDER BY create_at DESC , id DESC LIMIT 0 , ?";
		$query = $this->db->query($sql , array($type , $rows));
		
		$result = $query->result();
		$query->free_result();
		foreach($result as $key => $row)
		{
			$result[$key]->img_file = $this->upload_model->get_cache($row->img_id);
		}
		
		return $result;
	}
	
	
	public function get_list_open($type = 0)
	{
		if (!array_key_exists($type , $this->words_types)) $type = 0;
		
		$sql = "SELECT * FROM {$this->words_database} WHERE active = '1' AND type = ? ORDER BY create_at DESC , id DESC";
		$query = $this->db->query($sql , array($type));
		
		$result = $query->result();
		$query->free_result();
		foreach($result as $key => $row)
		{
			$result[$key]->img_file = $this->upload_model->get_cache($row->img_id);
		}
		
		return $result;
	}
	
	
	public function get_list_open_limit($type = 0 , $page = 0 , $limit = 20)
	{
		if (!array_key_exists($type , $this->words_types)) $type = 0;
		
		$start = $page>0?($page - 1)*$limit:0;
		
		$sql = "SELECT * FROM {$this->words_database} WHERE active = '1' AND type = ? ORDER BY create_at DESC , id DESC LIMIT ? , ?";
		$query = $this->db->query($sql , array($type , $start , $limit));
		
		$result = $query->result();
		$query->free_result();
		foreach($result as $key => $row)
		{
			$result[$key]->img_file = $this->upload_model->get_cache($row->img_id);
		}
		
		return $result;
	}
	
	
	public function get_list_total($type = 0)
	{
		if (!array_key_exists($type , $this->words_types)) $type = 0;
		
		$sql = "SELECT COUNT(id) as total FROM {$this->words_database} WHERE active = '1' AND type = ?";
		$query = $this->db->query($sql , array($type));
		
		$row = $query->row();
		$query->free_result();
		
		return isset($row->total)?$row->total:0;
	}
	
	
	public function get_list()
	{
		$sql = "SELECT * FROM {$this->words_database} WHERE 1";
		$query = $this->db->query($sql);
		
		return $query->result();
	}
	
	
	/**
	 * 取得單筆
	 *
	 */
	public function get_one($id = FALSE)
	{
		if (!$id) return FALSE;
		
		$sql = "SELECT * FROM {$this->words_database} WHERE id = ? LIMIT 0 , 1";
		$query = $this->db->query($sql , array($id));
		
		$row = $query->row();
		$row->img_file = $this->upload_model->get_cache($row->img_id);
		
		return $row;
	}
	
	
	/**
	 * 新增
	 *
	 */
	public function insert($data = FALSE)
	{
		if ($data == FALSE) return array('status' => 'F' , 'msg' => '資料錯誤');
		
		$sql_data = array();
		
		foreach($this->words_defaults as $key => $val)
		{
			if (isset($data[$key]))
			{
				$sql_data[$key] = $data[$key];
			}
			else
			{
				$sql_data[$key] = $val;
			}
		}
		
		$sql_data['words'] = windowsbr_to_unixbr($sql_data['words']);
		
		$sql_data['youtube'] = youtube_uri_id($sql_data['youtube']);
		
		$sql_data['img_id'] = $this->img_process('img_file' , $data['alt']);
		
		$check = $this->check_rule($sql_data);
		
		if ($check['status']=='F')
		{
			$this->upload_model->del_uploads($sql_data['img_id']);
			return $check;
		}
		
		$sql = "INSERT INTO {$this->words_database} SET id = ? , banner_type = ? , title = ? , active = ? , type = ? , img_id = ? , youtube = ? , words = ? , description = ? , keywords = ? , url = ? , create_at = ?";
		$query = $this->db->query($sql , $sql_data);
		
		if ($query)
		{
			return array('status' => 'T' , 'msg' => '新增成功');
		}
		
		return array('status' => 'F' , 'msg' => '寫入資料失敗');
	}
	
	
	/**
	 * 修改
	 *
	 */
	public function update($data = FALSE)
	{
		if ($data == FALSE) return array('status' => 'F' , 'msg' => '資料錯誤');
		if (!isset($data['id']) || !$data['id']) return array('status' => 'F' , 'msg' => '資料錯誤');
		
		$sql_data = array();
		
		foreach($this->words_defaults as $key => $val)
		{
			if ($key != 'id')
			{
				if (isset($data[$key]))
				{
					$sql_data[$key] = $data[$key];
				}
				else
				{
					$sql_data[$key] = $val;
				}
			}
		}
		
		$sql_data['id'] = $data['id'];
		
		$sql_data['words'] = windowsbr_to_unixbr($sql_data['words']);
		
		// log_message('ERROR' , $sql_data);
		
		$sql_data['youtube'] = youtube_uri_id($sql_data['youtube']);
		
		$old_data = $this->get_one($data['id']);
		
		$new_img_id = $this->img_process('img_file' , $data['alt']);
		
		if ($new_img_id > 0)
		{
			$sql_data['img_id'] = $new_img_id;
		}
		else
		{
			$sql_data['img_id'] = $old_data->img_id;
		}
		
		$check = $this->check_rule($sql_data);
		
		if ($check['status']=='F')
		{
			if ($new_img_id != $old_data->img_id)
			{
				$this->upload_model->del_uploads($new_img_id);
			}
			return $check;
		}
		
		$sql = "UPDATE {$this->words_database} SET banner_type = ? , title = ? , active = ? , type = ? , img_id = ? , youtube = ? , words = ? , description = ? , keywords = ? , url = ? , create_at = ? WHERE id = ?";
		$query = $this->db->query($sql , $sql_data);
		
		if ($query)
		{
			if ($new_img_id > 0)
			{
				$this->upload_model->del_uploads($old_data->img_id);
			}
			else
			{
				$this->upload_model->edit_uploads_alt($sql_data['img_id'] , $data['alt']);
			}
			
			return array('status' => 'T' , 'msg' => '修改成功');
		}
		
		return array('status' => 'F' , 'msg' => '寫入資料失敗');
	}
	
	
	/**
	 * 刪除
	 *
	 */
	public function delete($id = FALSE)
	{
		if ($id == FALSE) return array('status' => 'F' , 'msg' => '必填欄位未填');
		
		$old_data = $this->get_one($id);
		
		$sql = "DELETE FROM {$this->words_database} WHERE id = ?";
		$query = $this->db->query($sql , array($id));
		
		if ($query)
		{
			$this->upload_model->del_uploads($old_data->img_id);
			
			return array('status' => 'T' , 'msg' => '刪除成功');
		}
		
		return array('status' => 'F' , 'msg' => '寫入資料失敗');
	}
	
	
	public function check_rule($data = array())
	{
		if (isset($data) && is_array($data))
		{
			if (isset($data['type']))
			{
				if (!array_key_exists ($data['type'] , $this->words_types)) return array('status' => 'F' , 'msg' => '超出允許的文章分類範圍');
				
				if (!$data['title']) return array('status' => 'F' , 'msg' => '文章標題為必填欄位');
				
				if (!in_array($data['active'] , array(0,1))) return array('status' => 'F' , 'msg' => '超出允許的文章分類範圍');
				if (mb_strlen($data['title'] , 'utf-8') > 100) return array('status' => 'F' , 'msg' => '標題超出允許的最大長度');
				if (mb_strlen($data['description'] , 'utf-8') > 100) return array('status' => 'F' , 'msg' => 'Description超出允許的最大長度');
				if (mb_strlen($data['keywords'] , 'utf-8') > 100) return array('status' => 'F' , 'msg' => 'keywords超出允許的最大長度');
				if (mb_strlen($data['url'] , 'utf-8') > 100) return array('status' => 'F' , 'msg' => '網址超出允許的最大長度');
				
				$type = $this->words_types[$data['type']]['type'];
				
				switch($type)
				{
					case 0:
						//最新消息
						
					break;
					case 1:
						//瀑布式頁面
						if (!$data['img_id'] && !$data['youtube']) return array('status' => 'F' , 'msg' => '圖片與影片必須擇一上傳');
					break;
					case 2:
						//Banner輪播
						if (!$data['img_id'] && !$data['youtube']) return array('status' => 'F' , 'msg' => '圖片與影片必須擇一上傳');
					break;
					default:
						
					break;
				}
				
				
				return array('status' => 'T' , 'msg' => '');
				
			}
			else
			{
				return array('status' => 'F' , 'msg' => '文章分類為必填欄位');
			}
		}
		else
		{
			return array('status' => 'F' , 'msg' => '資料異常.sql_data必須為陣列');
		}
	}
	
	
	public function img_process($filename = '' , $alt = '')
	{
		$img = $this->file_model->move($filename , $this->img_config);
		
		if ($img)
		{
			$img['alt'] = $alt;
			
			$img_id = $this->upload_model->add_uploads($img);
			
			return (int) $img_id;
		}
		
		return 0;
	}
	
	
	public function change_active($id = FALSE , $active = 0)
	{
		$id = (int) $id;
		$active = (int) $active ;
		
		if (!$id) return array('status' => 'F' , 'msg' => '修改失敗');
		
		$sql = "UPDATE {$this->words_database} SET active = ?  WHERE id = ?";
		$query = $this->db->query($sql , array($active , $id));
		
		if ($query)
			return array('status' => 'T' , 'msg' => '修改成功');
		
		return array('status' => 'F' , 'msg' => '修改失敗');
	}
}

/* End of file Words_model.php */
/* Location: ./apps/models/Words_model.php */