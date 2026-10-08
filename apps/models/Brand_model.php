<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brand_model extends CI_Model {
	/**
	 * Banner Model
	 * 
	 * @package		: zh-tech
	 * @copyright	: zh-tech 振華科技
	 * @author		: Tone
	 * @depend		: upload_model,file_model,zh_tech_helper
	 *
	 */
	private $_table = 'brand';
	
	private $img_config = array(
			'upload_path' => './uploads/images/',
			'allowed_types' => 'jpeg|jpg|gif|png',
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
	
	
	public function get_list_all()
	{
		$query = $this->db->get($this->_table);
		$result = $query->result();
		$new_result = array();
		
		foreach($result as $key => $row)
		{
			$row->img_file = $this->upload_model->get_cache($row->img_id);
			$new_result[] = $row;
		}
		
		return $new_result;
	}
	
	
	public function get_list_open()
	{
		$this->db->where('active' , 1);
		$query = $this->db->get($this->_table);
		$result = $query->result();
		
		foreach($result as $key => $row)
		{
			$row->img_file = $this->upload_model->get_cache($row->img_id);
			$new_result[] = $row;
		}
		
		return $new_result;
	}
	
	
	public function get_one($id = FALSE)
	{
		$this->db->where('id' , $id);
		$query = $this->db->get($this->_table);
		$row = $query->row();
		$row->img_file = $row->img_file = $this->upload_model->get_cache($row->img_id);
		return $row;
	}
	
	
	public function add($param = FALSE)
	{
		if (!$param) return array('status' => 'F' , 'msg' => 'faild');
		if (!is_array($param)) return array('status' => 'F' , 'msg' => 'faild');
		
		$param['img_id'] = $this->img_process('img_file' , $param['alt']);
		
		unset($param['img_file'] , $param['alt']);
		
		if ($this->db->insert($this->_table , $param))
		{
			return array('status' => 'T' , 'msg' => 'success');
		}
		else
		{
			return array('status' => 'F' , 'msg' => 'faild');
		}
	}
	
	
	public function edit($param = FALSE)
	{
		if (!$param) return array('status' => 'F' , 'msg' => 'faild');
		if (!is_array($param)) return array('status' => 'F' , 'msg' => 'faild');
		if (!isset($param['id'])) return array('status' => 'F' , 'msg' => 'faild');
		
		$id = $param['id'];
		unset($param['id']);
		
		$old_data = $this->get_one($id);
		
		if (isset($_FILES['img_file']))
		{
			$param['img_id'] = $this->img_process('img_file' , $param['alt']);
			
			if ($param['img_id'] != FALSE)
			{
				$this->upload_model->del_uploads($old_data->img_id);
			}
			else
			{
				$param['img_id'] = $old_data->img_id;
				// return array('status' => 'F' , 'msg' => '檔案上傳失敗');
			}
		}
		else
		{
			$this->upload_model->edit_uploads_alt($old_data->img_id , $param['alt']);
		}
		
		unset($_FILES['img_file'] , $param['alt']);
		
		$this->db->where('id' , $id);
		
		if ($this->db->update($this->_table , $param))
		{
			return array('status' => 'T' , 'msg' => 'success');
		}
		else
		{
			return array('status' => 'F' , 'msg' => 'faild');
		}
	}
	
	
	public function del($id = FALSE)
	{
		if (!$id) return array('status' => 'F' , 'msg' => 'faild');
		
		$this->db->where('id' , $id);
		
		if ($this->db->delete($this->_table))
		{
			return array('status' => 'T' , 'msg' => 'success');
		}
		else
		{
			return array('status' => 'F' , 'msg' => 'faild');
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
		$this->db->where('id' , $id);

		if ($this->db->update($this->_table , array('active' => $active)))
		{
			return array('status' => 'T' , 'msg' => 'success');
		}
		else
		{
			return array('status' => 'F' , 'msg' => 'faild');
		}
	}
}

/* End of file Banner_model.php */
/* Location: ./apps/models/Banner_model.php */