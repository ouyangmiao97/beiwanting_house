<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_model extends CI_Model {
	
	/**
	 * 針對需要獨立出來的Item項目做管理
	 * @copyright: Zh-Tech 振華科技
	 * 
	 **/
	
	private $item_database = 'item';
	
	private $type = array(
		0=>'商品種類',
		1=>'尺寸',
		2=>'顏色',
		3=>'入數',
		4=>'產地',
		5=>'使用時間長度類型',
		6=>'子類別',
	);
	
	private $default = array(
		'id'=>null,
		'type'=>0,
		'title'=>'',
		'active'=>1,
		'color'=>'',
		'img_id'=>0,
	);
	
	private $img_config = array(
			'upload_path' => './uploads/images/',
			'allowed_types' => 'jpeg|jpg|gif|png',
	);
	
	
	
	public function __construct()
	{
		parent::__construct();
		
		if (!isset($this->file_model)) $this->load->model('file_model');
		if (!isset($this->upload_model)) $this->load->model('upload_model');
	}
	
	
	public function __destruct()
	{
		
	}
	
	
	public function get_type_list()
	{
		return $this->type;
	}
	
	
	/**
	 * 取得單筆資料
	 *
	 */
	public function get_one_by_id($id = FALSE , $for_model = FALSE)
	{
		if (!$id) return array('status' => 'F' , 'msg' => '缺少必要資訊');
		
		$sql = "SELECT * FROM {$this->item_database} WHERE id = ?";
		$query = $this->db->query($sql , array($id));
		$row = $query->row();
		
		if (!$row)
		{
			return FALSE;
		}
		
		$row->img_file = $this->upload_model->get_cache($row->img_id);
		
		if ($row->img_file == FALSE)
		{
			unset($row->img_file);
		}
		
		if (!$for_model)
		{
			return array('status' => 'T' , 'msg' => '成功' , 'item' => $row);
		}
		else
		{
			return $row;
		}
		
	}
	
	
	/**
	 * 取得項目列表
	 *
	 */
	public function get_item_list($type = 0)
	{
		$sql = "SELECT * FROM {$this->item_database} WHERE type = ? ";
		$query = $this->db->query($sql , array($type));
		$result = $query->result();
		$query->free_result();
		
		foreach($result as $key => $row)
		{
			if ($row->img_id)
			{
				$result[$key]->img_file = $this->upload_model->get_cache($row->img_id);
			}
			else
			{
				$result[$key]->img_file = FALSE;
			}
		}
		
		$tmp_ary = array();
		
		foreach($result as $key => $obj)
		{
			$tmp_ary[$obj->id] = $obj;
		}
		
		$result = $tmp_ary;
		unset($tmp_ary);
		
		return $result;
	}
	
	
	/**
	 * 反向查詢ID
	 *
	 */
	public function get_id_by_title($title = FALSE , $type = FALSE)
	{
		if ($title == FALSE) return FALSE;
		
		$sql = "SELECT * FROM {$this->item_database} WHERE title = ? ";
		$sql_data = array($title);
		
		if ($type != FALSE)
		{
			$sql .= 'AND type = ?';
			array_push($sql_data , $type);
		}
		
		$query = $this->db->query($sql , $sql_data);
		
		$row = $query->row();
		
		return isset($row->id)?$row->id:FALSE;
	}
	
	
	/**
	 * 取得所有項目
	 *
	 */
	public function get_item_list_all()
	{
		$sql = "SELECT * FROM {$this->item_database} WHERE 1";
		$query = $this->db->query($sql);
		$result = $query->result();
		$query->free_result();
		
		foreach($result as $key => $row)
		{
			$result[$key]->img_file = FALSE;
			
			if ($row->img_id) $result[$key]->img_file = $this->upload_model->get_cache($row->img_id);
		}
		
		return $result;
	}
	
	
	/**
	 * 開啟或關閉某一筆資料
	 *
	 */
	public function chang_active($id = FALSE , $active = FALSE)
	{
		if (!$id) return FALSE;
		
		$sql = "UPDATE {$this->item_database} SET active = ? WHERE id = ?";
		$query = $this->db->query($sql , array($active , $id));
		
		if ($query)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	
	/**
	 * 新增
	 *
	 */
	public function add($data = FALSE)
	{
		if (!$data) return array('status' => 'F' , 'msg' => '缺少必要資訊');
		
		if (!array_key_exists($data['type'] , $this->type)) return array('status'=>'F' , 'msg'=>'不正確的類型');
		
		$sql_data = array();
		$data['img_id'] = $this->img_process('img_file' , $data['img_alt']);
		
		foreach($this->default as $key => $val)
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
		
		$sql = "INSERT INTO {$this->item_database} SET id = ? , type = ? , title = ? , active = ? , color = ? , img_id = ?";
		$query = $this->db->query( $sql , $sql_data );
		
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
	public function edit($data = FALSE)
	{
		if (!$data) return array('status' => 'F' , 'msg' => '缺少必要資訊');
		
		if (!isset($data['id'])) return array('status' => 'F' , 'msg' => '缺少必要資訊');
		
		$id = $data['id'];
		
		$old_data = $this->get_one_by_id($id , TRUE);
		
		$new_img_id = $this->img_process('img_file' , $data['img_alt']);
		
		if ($new_img_id > 0)
		{
			$data['img_id'] = $new_img_id;
			$this->upload_model->del_uploads($old_data->img_id);
		}
		else
		{
			if ($old_data->img_id > 0)
			{
				$this->upload_model->edit_uploads_alt($old_data->img_id , $data['img_alt']);
			}
			
			// 刪除資料庫圖片
			if ($data['removeimg'] == 1)
			{
				unset($data['removeimg']);
				$data['img_id'] = 0;
				$this->upload_model->del_uploads($old_data->img_id);
			}
		}
		
		$sql_data = array();
		
		foreach($this->default as $key => $val)
		{
			if ($key == 'id') continue;
			if (isset($data[$key]))
			{
				$sql_data[$key] = $data[$key];
			}
			else
			{
				if (isset($old_data->$key))
				{
					$sql_data[$key] = $old_data->$key;
				}
				else
				{
					$sql_data = $val;
				}
			}
		}
		$sql_data['id'] = $id;
		
		$sql = "UPDATE {$this->item_database} SET type = ? , title = ? , active = ? , color = ? , img_id = ? WHERE id = ?";
		$query = $this->db->query($sql , $sql_data);
		
		if ($query)
		{
			// 商品種類修改，連動影響產品資料表
			if ($sql_data['type'] == 0)
			{
				$this->db->where('brand' , $old_data->title);
				$this->db->update('product' , array('brand' => $sql_data['title']));
			}
			
			return array('status' => 'T' , 'msg' => '修改成功');
		}
		
		return array('status' => 'F' , 'msg' => '寫入資料失敗');
	}
	
	
	/**
	 * 刪除
	 *
	 */
	public function del($id = FALSE)
	{
		if (!$id) return array('status' => 'F' , 'msg' => '缺少必要資訊');
		
		$sql = "DELETE FROM {$this->item_database} WHERE id = ?";
		$query = $this->db->query($sql , array($id));
		
		if ($query)
		{
			return array('status' => 'T' , 'msg' => '刪除成功');
		}
		
		
		return array('status' => 'F' , 'msg' => '寫入資料失敗');
	}
	
	
	/**
	 * 圖片上傳處理
	 *
	 */
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
}

/* End of file Item_model.php */
/* Location: ./apps/models/Item_model.php */