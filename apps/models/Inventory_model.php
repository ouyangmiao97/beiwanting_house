<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory_model extends CI_Model {
	
	//庫存
	private $inventory_database = 'inventory';
	
	private $item_database = 'item';
	
	private $product_database = 'product';
	
	private $defaults = array(
		'id' => null , 	//庫存編號
		'pid' => 0,		//產品ID
		'color' => '',		//顏色名稱
		// 'degree' => '',		//度數名稱
		'num' => 0,		//庫存量
	);
	
	public function __construct()
	{
		$this->load->model('upload_model');
	}
	
	public function __destruct()
	{
		
	}
	
	
	/**
	 * 取得單筆
	 *
	 */
	public function get_inventory_one($pid = FALSE)
	{
		if (!$pid) return FALSE;
		
		$sql = "SELECT * FROM {$this->inventory_database} WHERE id = ? LIMIT 0 , 1";
		$query = $this->db->query($sql , array($pid));
		
		if ($query)
		{
			return json_encode(array('status' => 'T' , 'msg' => '' , 'data' => $query->row()));
		}
		
		return json_encode(array('status' => 'F' , 'msg' => '載入資料失敗' , 'data' => FALSE));
	}
	
	
	/**
	 * 取得庫存
	 *
	 */
	public function get_inventory($pid = FALSE)
	{
		if (!$pid) return FALSE;
		
		$this->db->where('pid' , $pid);
		$query = $this->db->get($this->inventory_database);
		
		// $sql = "SELECT * FROM {$this->inventory_database} WHERE pid = ? AND color = ? ";
		// $query = $this->db->query($sql , array($pid , $color));
		
		return $query->row();
		
		
		// if (!$query)
		// {
			// $result = FALSE;
		// }
		// else
		// {
			// $result = $query->row();
			// $query->free_result();
		// }
				
		// return $result;
	}
	
	
	/**
	 * 取得多筆
	 *
	 */
	public function get_inventory_list($pid = FALSE)
	{
		if (!$pid) return FALSE;
		
		$this->db->where('pid' , $pid);
		$query = $this->db->get($this->inventory_database);
		
		// $sql = "SELECT * FROM {$this->inventory_database} WHERE pid = ?";
		// $query = $this->db->query($sql , array($pid));
		
		if (!$query)
		{
			$result = array();
		}
		else
		{
			$result = $query->result();
			$query->free_result();
		}
		
		return $result;
	}
	
	
	public function get_inventory_all()
	{
		// $this->db->order_by('num' , 'asc');
		$query = $this->db->get($this->inventory_database);
		
		if (!$query)
		{
			$result = array();
		}
		else
		{
			$result = $query->result();
			$query->free_result();
		}
		
		return $result;
	}
	
	
	/**
	 * 庫存銷售
	 * @param int $pid 
	 * @param string $color
	 * @param string $degree
	 * @param int $num
	 * 
	 * @return bool
	 */
	public function sale_inventory($pid = FALSE , $num = FALSE)
	{
		if (FALSE === $pid || FALSE === $num) return FALSE;
		
		$old = $this->get_inventory_one($pid);
		
		$this->db->where('pid' , $pid);
		$query = $this->db->update($this->inventory_database , array('num' => $old->num - $num));
		
		// $sql = "UPDATE {$this->inventory_database} SET num = num - ? WHERE pid = ? AND color = ? ";
		// $query = $this->db->query($sql , array($num , $pid , $color));
		
		if ($query)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	
	/**
	 * 庫存銷售還原
	 * @param int $pid 
	 * @param string $color
	 * @param string $degree
	 * @param int $num
	 * 
	 * @return bool
	 */
	public function sale_inventory_back($pid = FALSE , $num = FALSE)
	{
		if (FALSE === $pid || FALSE === $num) return FALSE;
		
		$this->db->where('pid' , $pid);
		$query = $this->db->update($this->inventory_database , array('num' => $old->num + $num));
		
		// $sql = "UPDATE {$this->inventory_database} SET num = num + ? WHERE pid = ? AND color = ?";
		// $query = $this->db->query($sql , array($num , $pid , $color));
		
		if ($query)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	
	/**
	 * 檢查庫存量是否足夠
	 *
	 */
	public function sale_check($pid = FALSE , $num = FALSE)
	{
		if (FALSE === $pid || FALSE === $num) return FALSE;
		
		$this->db->where('pid' , $pid);
		$this->db->where('num >=' , $num);
		$query = $this->db->get($this->inventory_database);
		
		// $sql = "SELECT * FROM {$this->inventory_database} WHERE pid = ? AND color = ? AND num >= ?";
		// $query = $this->db->query($sql , array($pid , $color , $num));
		
		if ($query)
		{
			$row = $query->row();
			$query->free_result();
		}
		else
		{
			$row = FALSE;
		}
		
		
		if (FALSE != $row)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	
	/**
	 * 新增庫存
	 *
	 */
	public function add_inventory($data = array())
	{
		$sql_data = array();
		$sql_insert = array();
		
		//檢查該庫存是否已經存在
		$check_data = array();
		$check_data[] = isset($data['pid']) ? $data['pid'] : $this->deafult['pid'];
		// $check_data[] = isset($data['color']) ? $data['color'] : $this->deafult['color'];
		// $check_data[] = isset($data['degree']) ? $data['degree'] : $this->deafult['degree'];
		
		$check_sql = "SELECT count(*) as counts FROM {$this->inventory_database} WHERE pid = ? ";
		$query = $this->db->query($check_sql , $check_data);
		
		if ($query)
		{
			$row = $query->row();
		}
		else
		{
			$row = FALSE;
		}
		
		
		if (is_object($row) && isset($row->counts) && $row->counts > 0)
		{
			return json_encode(array('status' => 'F' , 'msg' => '已經存在相同類型的庫存，請使用修改庫存量的方式修改'));
		}
		
		foreach($this->defaults as $key => $val)
		{
			if ($key == 'id') continue;
			
			$sql_insert[] = sprintf(" `%s` = ? " , $key);
			
			if (isset($data[$key]) && $data[$key] != FALSE)
			{
				$sql_data[] = $data[$key];
			}
			else
			{
				$sql_data[] = $val;
			}
		}
		
		$sql_insert = implode(',' , $sql_insert);
		
		$sql = "INSERT INTO {$this->inventory_database} SET {$sql_insert}";
		$query = $this->db->query($sql , $sql_data);

		if ($query)
		{
			return json_encode(array('status' => 'T' , 'msg' => '新增成功'));
		}
		
		return json_encode(array('status' => 'F' , 'msg' => '新增失敗'));
	}
	
	
	/**
	 * 編輯庫存
	 *
	 */
	public function edit_inventory($data = array())
	{
		$sql_data = array();
		$sql_update = array();
		
		if (!isset($data['id'])) return FALSE;
		
		foreach($this->defaults as $key => $val)
		{
			if ($key == 'id') continue;
			
			$sql_update[] = sprintf(" `%s` = ? " , $key);
			
			if (isset($data[$key]) && $data[$key] != FALSE)
			{
				
				$sql_data[] = $data[$key];
			}
			else
			{
				$sql_data[] = $val;
			}
		}
		
		$sql_data[] = $data['id'];
		
		$sql_update = implode(',' , $sql_update);
		
		$sql = "UPDATE {$this->inventory_database} SET {$sql_update} WHERE id = ?";
		$query = $this->db->query($sql , $sql_data);
		
		if ($query)
		{
			return json_encode(array('status' => 'T' , 'msg' => '新增成功'));
		}
		
		return json_encode(array('status' => 'F' , 'msg' => '新增失敗'));
	}
	
	
	/**
	 * 刪除庫存
	 *
	 */
	public function del_inventory($id = FALSE)
	{
		if ($id == FALSE) return FALSE;
		
		$sql = "DELETE FROM {$this->inventory_database} WHERE id = ?";
		$query = $this->db->query($sql , array($id));
		
		if ($query)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	
	/**
	 * 庫存查詢
	 *
	 */
	public function check_product_inventory($pid = FALSE)
	{
		
		if ($pid == FALSE || $color == FALSE)
		{
			return json_encode(array('status' => 'F' , 'result' => 0));
		}
		
		$sql = "SELECT * FROM {$this->inventory_database} WHERE pid = ?";
		$query = $this->db->query($sql , array($pid));
		
		if ($query)
		{
			$row = $query->row();
			$query->free_result();
		}
		else
		{
			$row = FALSE;
		}
		
		if (is_object($row))
		{
			//庫存存在檢查庫存量
			
			if ($row->num > 0)
			{
				//庫存量大於0
				return json_encode(array('status' => 'T' , 'result' => 1 , 'num' => $row->num));
			}
			else
			{
				//庫存量等於0
				return json_encode(array('status' => 'T' , 'result' => 2 , 'num' => 0));
			}
			
		}
		
		//庫存若不存在
		return json_encode(array('status' => 'T' , 'result' => 2 , 'num' => 0));
	}
	
	
	
	public function get_color_list($pid = FALSE)
	{
		if (!$pid) return FALSE;
		
		// $this->db->where('num >', 0);
		// $this->db->where('pid' , $pid);
		// $query = $this->db->get($this->inventory_database);
		
		// $color_list = $query->result();
		
		// $result = array();
		
		// foreach($color_list as $key => $row)
		// {
			// $result[$row->id] = $row->color;
		// }
		
		// return $result;
		
		$sql = "SELECT * FROM {$this->inventory_database} WHERE pid = ?";
		$query = $this->db->query($sql , array($pid));
		
		if ($query)
		{
			$result = $query->result();
			$query->free_result();
		}
		else
		{
			$result = array();
		}
		
		$tmp_result = array();
		
		foreach($result as $key => $obj)
		{
			$tmp_result[$obj->id] = $obj->color;
		}
		
		$result = $tmp_result;
		unset($tmp_result);
		
		return $result;
	}
	
	
	public function get_degree_list($pid = FALSE)
	{
		if (!$pid) return FALSE;
		
		// $sql = "SELECT tt.title as title , tt.id as id  FROM {$this->inventory_database} as ii JOIN {$this->item_database} as tt ON ii.did = tt.id WHERE ii.pid = ? GROUP BY ii.degree";
		$sql = "SELECT * FROM {$this->inventory_database} WHERE pid = ?";
		$query = $this->db->query($sql , array($pid));
		
		if ($query)
		{
			$result = $query->result();
			$query->free_result();
		}
		else
		{
			$result = array();
		}
		
		
		
		$tmp_result = array();
		
		foreach($result as $key => $obj)
		{
			$tmp_result[$obj->id] = $obj->degree;
		}
		
		$result = $tmp_result;
		unset($tmp_result);
		
		return $result;
	}
	
	
	/**
	 * 加入購物車
	 *
	 */
	public function add_cart($id = FALSE , $num = FALSE)
	{
		if (!$id || !$num) return FALSE;
		
		$sql = "UPDATE {$this->inventory_database} SET num = num - ? WHERE id = ?";
		$query = $this->db->query($sql , array($num , $id));
		
		if ($query)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	/**
	 * 移除購物車
	 *
	 */
	public function del_cart($id = FALSE , $num = FALSE)
	{
		if (!$id || !$num) return FALSE;
		
		$sql = "UPDATE {$this->inventory_database} SET num = num + ? WHERE id = ?";
		$query = $this->db->query($sql , array($num , $id));
		
		if ($query)
		{
			return TRUE;
		}
		
		return FALSE;
	}
}

/* End of file Inventory_model.php */
/* Location: ./apps/models/Inventory_model.php */