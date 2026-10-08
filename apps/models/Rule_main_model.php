<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rule_main_model extends CI_Model {
	
	private $_table = 'rule_main';
	
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
	
	// Create Rule List BY brand_id 
	public function create_rule_list()
	{
		$this->load->model('product_model');
		$this->load->model('rule_sub_model');
		$this->load->model('item_model');
		
		$brand_list = $this->item_model->get_item_list();
		
		foreach($brand_list as $bk => $brand)
		{
			
			$brand_id = $brand->id;
			
			$path = 'rule_list/' . $brand_id . '.json';
			
			// 該brand_id底下的所有產品清單
			$product_list = $this->product_model->get_list_by_type($brand_id , FALSE , 0 , 1000);
			
			// 取得大類
			$rule_main_list = $this->get_list();
			
			// 取得小類
			foreach($rule_main_list as $key => $row)
			{
				$rule_main_list[$key]->sub_list = $this->rule_sub_model->get_list_main_id($row->id);
			}
			
			// 根據大類小類檢查該類別下有無產品
			foreach($rule_main_list as $key => $row)
			{
				foreach($row->sub_list as $kk => $srow)
				{
					$submatch = FALSE;
					
					// 檢查所有產品
					foreach($product_list as $kp => $product)
					{
						$p_sub_ary = explode(',' , $product->rule_sub);
						
						if (in_array($srow->id , $p_sub_ary))
						{
							$submatch = TRUE;
							break;
						}
					}
					
					// 如果該子類無產品，則刪除該子類
					if ($submatch == FALSE)
					{
						// unset($rule_main_list[$key]->sub_list[$kk]);
						unset($row->sub_list[$kk]);
					}
				}
				
				// 如果子項目清單沒有任何商品
				if (count($row->sub_list) == 0)			
				{
					// 刪除該大類
					unset($rule_main_list[$key]);
				}
				else
				{
					$rule_main_list[$key] = $row;
				}
			}
			
			set_cache($path , json_encode($rule_main_list));
		}
		
		return TRUE;
	}
	
	public function get_rule_list($brand_id = FALSE)
	{
		if (!$brand_id) return FALSE;
		
		$path = 'rule_list/' . $brand_id . '.json';
		
		return json_decode(get_cache($path));
		
		// $data = get_cache($path);
		
		// if (!$data || !is_array($data)) return array();
		
		// return json_decode($data);
	}
}