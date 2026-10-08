<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banner_model extends CI_Model {
	/**
	 * Banner Model
	 * 
	 * @package		: zh-tech
	 * @copyright	: zh-tech 振華科技
	 * @author		: Tone
	 * @depend		: upload_model,file_model,zh_tech_helper
	 *
	 */
	private $words_database = 'banner';
	
	private $words_defaults = array(
		'id' => null,
		'banner_type' => 1,
		'title' => '',
		'active' => 1,
		'type' => 1,
		'img_id' => 0,
		'imgm_id' => 0,
		'imgs_id' => 0,
		'youtube' => '',
		'words' => '',
		'description' => '',
		'keywords' => '',
		'url' => '',
		'create_at' => '',
	);
	
	private $img_config = array(
			'upload_path' => './uploads/images/',
			'allowed_types' => 'jpeg|jpg|gif|png',
	);
	
	/**
	 * this model is word_model , the word type :
	 * 0=> for the news
	 * 1=>
	 * 2=> banner type
	 */
	public $words_types = array(
		0=>array('title' => '首頁Banner' , 'type' => 2),
		1=>array('title' => '三廣告圖片' , 'type' => 2),
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
	
	
	public function get_list_index($type = 0)
	{
		$sql = "SELECT * FROM {$this->words_database} WHERE active = '1' AND type = ?";
		$query = $this->db->query($sql , array($type));
		
		$result = $query->result();
		foreach($result as $key => $row)
		{
			$result[$key]->img_file = $this->upload_model->get_cache($row->img_id);
			$result[$key]->img_file2 = $this->upload_model->get_cache($row->imgm_id);
			$result[$key]->img_file3 = $this->upload_model->get_cache($row->imgs_id);
		}
		
		return $result;
	}
	
	
	public function get_list_open()
	{
		$sql = "SELECT * FROM {$this->words_database} WHERE active = '1'";
		$query = $this->db->query($sql);
		
		$result = $query->result();
		foreach($result as $key => $row)
		{
			$result[$key]->img_file = $this->upload_model->get_cache($row->img_id);
		}
		
		return $result;
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
		
		$this->db->where('id' , $id);
		$query = $this->db->get($this->words_database);
		
		$row = $query->row();
		$row->img_file = $this->upload_model->get_cache($row->img_id);
		$row->img_file2 = $this->upload_model->get_cache($row->imgm_id);
		$row->img_file3 = $this->upload_model->get_cache($row->imgs_id);
		
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
		
		$sql_data['youtube'] = youtube_uri_id($sql_data['youtube']);
		
		$sql_data['img_id'] = $this->img_process('img_file' , $data['alt']);
		$sql_data['imgm_id'] = $this->img_process('img_file2' , $data['alt']);
		$sql_data['imgs_id'] = $this->img_process('img_file3' , $data['alt']);
		
		$check = $this->check_rule($sql_data);
		
		if ($check['status']=='F')
		{
			if ($sql_data['img_id'] != 0) $this->upload_model->del_uploads($sql_data['img_id']);
			if ($sql_data['imgm_id'] != 0) $this->upload_model->del_uploads($sql_data['imgm_id']);
			if ($sql_data['imgs_id'] != 0) $this->upload_model->del_uploads($sql_data['imgs_id']);
			return $check;
		}
		
		$query = $this->db->insert($this->words_database , $sql_data);
		
		// $sql = "INSERT INTO {$this->words_database} SET id = ? , banner_type = ? , title = ? , active = ? , type = ? , img_id = ? , youtube = ? , words = ? , description = ? , keywords = ? , url = ? , create_at = ?";
		// $query = $this->db->query($sql , $sql_data);
		
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
		
		// $sql_data['id'] = $data['id'];
		$id = $data['id'];
		
		$sql_data['youtube'] = youtube_uri_id($sql_data['youtube']);
		
		$old_data = $this->get_one($data['id']);
		
		$new_img_id = $this->img_process('img_file' , $data['alt']);
		$new_img_id2 = $this->img_process('img_file2' , $data['alt']);
		$new_img_id3 = $this->img_process('img_file3' , $data['alt']);
		
		if ($new_img_id > 0)
		{
			$sql_data['img_id'] = $new_img_id;
		}
		else
		{
			$sql_data['img_id'] = $old_data->img_id;
		}
		
		if ($new_img_id2 > 0)
		{
			$sql_data['imgm_id'] = $new_img_id2;
		}
		else
		{
			$sql_data['imgm_id'] = $old_data->imgm_id;
		}
		
		if ($new_img_id3 > 0)
		{
			$sql_data['imgs_id'] = $new_img_id3;
		}
		else
		{
			$sql_data['imgs_id'] = $old_data->imgs_id;
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
		
		$this->db->where('id' , $id);
		$query = $this->db->update($this->words_database , $sql_data);
		
		// $sql = "UPDATE {$this->words_database} SET banner_type = ? , title = ? , active = ? , type = ? , img_id = ? , youtube = ? , words = ? , description = ? , keywords = ? , url = ? , create_at = ? WHERE id = ?";
		// $query = $this->db->query($sql , $sql_data);
		
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
						if (!$data['youtube'])
						{
							if (!$data['img_id'] || !$data['imgm_id'] || !$data['imgs_id'])
							{
								return array('status' => 'F' , 'msg' => '三種尺寸圖片皆須上傳');
							}
						}
						// if (!$data['img_id'] && !$data['youtube']) return array('status' => 'F' , 'msg' => '圖片與影片必須擇一上傳');
					break;
					case 2:
						//Banner輪播
						if (!$data['youtube'])
						{
							if (!$data['img_id'] || !$data['imgm_id'] || !$data['imgs_id'])
							{
								return array('status' => 'F' , 'msg' => '三種尺寸圖片皆須上傳');
							}
						}
						// if (!$data['img_id'] && !$data['youtube']) return array('status' => 'F' , 'msg' => '圖片與影片必須擇一上傳');
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

/* End of file Banner_model.php */
/* Location: ./apps/models/Banner_model.php */