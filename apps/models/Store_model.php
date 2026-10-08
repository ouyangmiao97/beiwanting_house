<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Store_model extends CI_Model {
	/**
	 * Banner Model
	 * 
	 * @package		: zh-tech
	 * @copyright	: zh-tech 振華科技
	 * @author		: Tone
	 * @depend		: upload_model,file_model,zh_tech_helper
	 *
	 */
	private $_table = 'store';
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function __destruct()
	{
		
	}
	
	
	public function get_list_all()
	{
		$query = $this->db->get($this->_table);
		return $query->result();
	}
	
	
	public function get_list_open()
	{
		$this->db->where('active>=' , 1);
		$query = $this->db->get($this->_table);
		return $query->result();
	}
	
	
	public function get_one($id = FALSE)
	{
		$this->db->where('id' , $id);
		$query = $this->db->get($this->_table);
		return $query->row();
	}
	
	
	public function add($param = FALSE)
	{
		if (!$param) return FALSE;
		if (!is_array($param)) return FALSE;
		
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
		if (!$param) return FALSE;
		if (!is_array($param)) return FALSE;
		if (!isset($param['id'])) return FALSE;
		
		$id = $param['id'];
		unset($param['id']);
		
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
		if (!$id) return FALSE;
		
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
	
	
	public function get_distinct_city()
	{
		$this->load->model('city_model');
		
		$sql = "SELECT DISTINCT `cid` FROM `{$this->_table}` WHERE active > 0 ORDER BY cid";
		$query = $this->db->query($sql);
		
		$cid_result = $query->result();
		$data_list = array();
		
		foreach($cid_result as $key => $row)
		{
			$data_list[] = $this->city_model->get_one($row->cid);
		}
		
		return $data_list;
	}
	
	
	public function get_distinct_district($cid = FALSE)
	{
		if (!$cid) return FALSE;
		$this->load->model('district_model');
		
		$sql = "SELECT DISTINCT `did` FROM `{$this->_table}` WHERE active > 0 AND cid = '{$cid}' ORDER BY did";
		$query = $this->db->query($sql);
		
		$cid_result = $query->result();
		$data_list = array();
		
		foreach($cid_result as $key => $row)
		{
			$data_list[] = $this->district_model->get_one($row->did);
		}
		
		return $data_list;
	}
	
	
	public function get_list_by_did($did = FALSE)
	{
		$this->db->where('did' , $did);
		$this->db->where('active>=' , 1);
		$query = $this->db->get($this->_table);
		return $query->result();
	}
}