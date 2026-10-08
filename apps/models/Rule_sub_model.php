<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rule_sub_model extends CI_Model {
	
	private $_table = 'rule_sub';
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function __destruct()
	{
		
	}
	
	public function get_one($id = FALSE)
	{
		if (!$id) return FALSE;
		
		$this->db->where('id' , $id);
		$query = $this->db->get($this->_table);
		
		return $query->row();
	}
	
	public function get_list()
	{
		$this->db->order_by('sort_key');
		$query = $this->db->get($this->_table);
		return $query->result();
	}
	
	public function get_list_main_id($main_id = FALSE)
	{
		if (!$main_id) return FALSE;
		
		$this->db->where('main_id' , $main_id);
		$query = $this->db->get($this->_table);
		return $query->result();
	}
	
	public function add($param = FALSE)
	{
		$param['sort_key'] = $this->get_sort_key_next();
		return $this->db->insert($this->_table , $param);
	}
	
	public function edit($param = FALSE)
	{
		$id = isset($param['id']) ? $param['id'] : FALSE;
		
		if (!$id) return FALSE;
		
		unset($param['id']);
		
		$this->db->where('id' , $id);
		return $this->db->update($this->_table , $param);
	}
	
	public function del($id = FALSE)
	{
		if (!$id) return FALSE;
		
		$this->db->where('id' , $id);
		return $this->db->delete($this->_table);
	}
	
	// 取得下一個排序
	public function get_sort_key_next()
	{
		$this->db->order_by('sort_key' , 'desc');
		$query = $this->db->get($this->_table);
		
		$row = $query->row();
		
		if ($row != FALSE)
		{
			return $row->sort_key + 1;
		}
		else
		{
			return 1;
		}
	}
	
	
	// 交換兩者的排序
	public function change_sort_key($id1 = FALSE, $id2 = FALSE)
	{
		if (!$id1 || !$id2) return FALSE;
		
		// 交換排序不需要檢查active
		$this->active_check = FALSE;
		
		$row1 = $this->get_one($id1);
		$row2 = $this->get_one($id2);
		
		$response1 = $this->edit(array('id' => $id1 , 'sort_key' => $row2->sort_key));
		
		if ($response1)
		{
			$response2 = $this->edit(array('id' => $id2 , 'sort_key' => $row1->sort_key));
			
			if ($response2)
			{
				return TRUE;
			}
			else
			{
				$this->edit(array('id' => $id1 , 'sort_key' => $row1->sort_key));
				$this->edit(array('id' => $id2 , 'sort_key' => $row2->sort_key));
				
				return FALSE;
			}
		}
		else
		{
			$this->edit(array('id' => $id1 , 'sort_key' => $row1->sort_key));
			
			return FALSE;
		}
	}
}