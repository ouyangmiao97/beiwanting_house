<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Product_type_model extends MY_Model {

	/**
	 * 建構式
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = 'product_type';
		
		$this->_checkfields = array();
	}
	
	
	public function __destruct()
	{
		
	}
	
	public function add($data = FALSE)
	{
		if (!$this->_checkfields($data)) return FALSE;
		
		$data['create_at'] = date('Y-m-d H:i:s');
		
		if ($data['color'] == FALSE && $data['cap'] == FALSE && $data['length'] == FALSE)
		{
			$this->error_msg = '顏色、容量、長度請擇一填寫';
			return FALSE;
		}
		
		if ($this->get_list_by_no_pid($data['no'] , $data['pid']) != FALSE)
		{
			$this->error_msg = '該產品下的號數重複！';
			return FALSE;
		}
		
		if ($data['price'] <= 0)
		{
			$this->error_msg = '價格不能為0';
			return FALSE;
		}
		
		return $this->_add($data);
	}
	
	public function edit($data = FALSE)
	{
		if (isset($data['color']) && isset($data['cap']) && isset($data['length'])){
			if ($data['color'] == FALSE && $data['cap'] == FALSE && $data['length'] == FALSE)
			{
				$this->error_msg = '顏色、容量、長度請擇一填寫';
				return FALSE;
			}
		}
	
		if (isset($data['no'])){
			// 如果號數沒變動就不用檢查
			$old = $this->get_one($data['id']);
			if ($old->no != $data['no'])
			{
				if ($this->get_list_by_no_pid($data['no'] , $data['pid']) != FALSE)
				{
					$this->error_msg = '該產品下的號數重複！';
					return FALSE;
				}
			}
		}
		
	 	if ($data['price'] <= 0)
		{
			$this->error_msg = '價格不能為0';
			return FALSE;
		}
		
		return $this->_edit($data);
	}
	
	public function del($id = FALSE)
	{
		return $this->_del($id);
	}
	
	public function get_list($page = 1 , $limit = 20)
	{
		$this->db->order_by('create_at' , 'desc');
		return $this->_get_list($page , $limit);
	}
	
	public function get_list_count()
	{
		return $this->_get_list_count();
	}
	
	public function get_all_list()
	{
		return $this->_get_all_list();
	}
	
	public function get_one($id = FALSE)
	{
		return $this->_get_one($id);
	}
	
	public function change_active($id = FALSE , $active = FALSE)
	{
		return $this->_change_active($id , $active);
	}
	

	public function get_all_list_active()
	{
		
		$this->db->where('active' , '1');
		$this->db->order_by('color');
		$this->db->order_by('cap');
		$this->db->order_by('length');
			
		return $this->_get_all_list();
	}
	

	public function get_list_by_pid($pid = FALSE , $active = FALSE)
	{
		if (!$pid) return FALSE;
		
		if ($active != FALSE)
		{
			$this->db->where('active' , $active);
		}
		
		$this->db->where('pid' , $pid);
		$this->db->order_by('color');
		$this->db->order_by('cap');
		$this->db->order_by('length');
		
		return $this->_get_all_list();
	}
	
	public function get_list_by_no_pid($no = FALSE , $pid = FALSE)
	{
		if (!$no) return FALSE;
		
		$this->db->where('no' , $no);
		$this->db->where('pid' , $pid);
		
		return $this->_get_all_list();
	}
	
	
	public function get_inventory_list()
	{
		$sql = "SELECT * , pt.id as ptid , pt.no as ptno FROM `product_type` as pt LEFT JOIN `product` as p ON pt.pid = p.id WHERE 1";
		$query = $this->db->query($sql);
		
		return $query->result();
	}
	
	
	public function inventory_add($id = FALSE , $num = FALSE)
	{
		if (!$id || !$num) return FALSE;
		
		$this->db->where('id' , $id);
		$old = $this->get_one($id);
		
		if (!$old) return FALSE;
		
		return $this->edit(array('id' => $id , 'inventory' => $old->inventory + $num));
	}
	
	
	public function inventory_cut($id = FALSE , $num = FALSE)
	{
		if (!$id || !$num) return FALSE;
		
		$old = $this->get_one($id);
		
		if (!$old) return FALSE;
		
		return $this->edit(array('id' => $id , 'inventory' => $old->inventory - $num));
	}
	
	public function get_inventory($id = FALSE)
	{
		if (!$id) return FALSE;
		
		$old = $this->get_one($id);
		
		return $old->inventory;
	}
	
	
	public function price_fix($pid = FALSE)
	{
		if (!$pid) return FALSE;
		
		$data_list = $this->get_list_by_pid($pid);
		
		$max = 0;
		$min = 999999;
		
		foreach($data_list as $key => $row)
		{
			if ($row->price > $max)
			{
				$max = $row->price;
			}
			if ($row->price < $min)
			{
				$min = $row->price;
			}
		}
		
		// 防呆機制
		if ($max == 0 && $min == 999999)
		{
			return FALSE;
		}
		
		// 更新product
		$this->db->where('id' , $pid);
		$response = $this->db->update('product' , array('price_max'=> $max , 'price_min' => $min));
		
		if ($response)
		{
			return TRUE;
		}
		
		$this->error_msg = '建立價格區間時發生錯誤';
		return FALSE;
	}
}

/* End of file Product_model.php */
/* Location: ./apps/models/Product_model.php */