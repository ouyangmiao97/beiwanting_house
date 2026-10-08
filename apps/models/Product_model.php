<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model {
	
	/**
	 * eyelens product model
	 *
	 */
	//商品
	private $product_database = 'product';
	 
	private $defaults = array(
		'id'=>null,
		'img'=>0,
		'img_list'=>0,
		'brand_id'=>0,
		'brand'=>'',
		'classs'=>'',
		'title'=>'',
		'pick'=>'',
		'price'=>0,
		'origin'=>'',
		'diameter_head'=>0,
		'diameter_img'=>0,
		'base_curve'=>0,
		'type_id'=>0,
		'type'=>'',
		'color'=>'',
		'degree'=>'',
		// 'inventory'=>0,
		'start_date'=>'0000-00-00',
		'end_date'=>'9999-12-31',
		'active'=>1,
		'shipping_methods'=>'',
		'create_at'=>'0000-00-00 00:00:00',
		'last_edit'=>'0000-00-00 00:00:00',
		'discount_active'=>0,
		'discount_end_date'=>'0000-00-00',
		'discount_price'=>0,
		'description'=>'',
		'keywords'=>'',
		'word'=>'',
		'water'=>0,
		'number_product'=>'',
		'number_ad'=>'',
		'rule_sub' => '',
		'product_id' => '',
		'memo' => '',
		'price_max' => 0,
		'price_min' => 0,
	);	
	
	
	public function __construct()
	{
		$this->load->model('upload_model');
		$this->today = date('Y-m-d');
	}
	
	
	public function __destruct()
	{
		
	}
	
	
	/**
	 * 取得產品列表
	 * @param int $type 產品的主要分類
	 * @param boolean $active 是否限制產品狀態要開啟
	 * 
	 * @return array(object{}) $result
	 */
	public function get_product_list($type = -1)
	{
		//設定搜尋條件
		$sql_where = 'WHERE active > 0';
		$sql_data = array();
		
		if ($type >= 0)
		{
			$sql_where .= ' AND type_id = ?';
			$sql_data[] = $type;
		}
		
		$sql = "SELECT * FROM {$this->product_database} {$sql_where}";
		$query = $this->db->query($sql , $sql_data);
		$result = $query->result();
		
		$query->free_result();
		
		//將圖片資訊寫入到陣列中
		foreach($result as $key => $row)
		{
			$result[$key]->img_file = $this->upload_model->get_cache($row->img);
			
			$tmp = $row->img_list;
			$tmp = explode(',' , $tmp);
			
			foreach($tmp as $kk => $vv)
			{
				$result[$key]->img_file_list[] = $this->upload_model->get_cache($vv);
			}
		}
		
		return $result;
	}
	
	
	/**
	 * @param $ac 0:全部 1:開啟 2:關閉
	 *
	 */
	public function get_product_list_ac($ac = 0)
	{
		if ($ac == 0) $this->db->where('active>=' , 0);
		if ($ac == 1) $this->db->where('active' , 1);
		if ($ac == 2) $this->db->where('active' , 0);
		
		$query = $this->db->get($this->product_database);
		
		$result = $query->result();
		
		$query->free_result();
		
		//將圖片資訊寫入到陣列中
		foreach($result as $key => $row)
		{
			$result[$key]->img_file = $this->upload_model->get_cache($row->img);
			
			$tmp = $row->img_list;
			$tmp = explode(',' , $tmp);
			
			foreach($tmp as $kk => $vv)
			{
				$result[$key]->img_file_list[] = $this->upload_model->get_cache($vv);
			}
		}
		
		return $result;
	}
	
	
	public function get_product_list_all($type = -1)
	{
		//設定搜尋條件
		$sql_where = 'WHERE active >= 0';
		$sql_data = array();
		
		if ($type >= 0)
		{
			$sql_where .= ' AND type_id = ?';
			$sql_data[] = $type;
		}
		
		$sql = "SELECT * FROM {$this->product_database} {$sql_where}";
		$query = $this->db->query($sql , $sql_data);
		$result = $query->result();
		
		$query->free_result();
		
		//將圖片資訊寫入到陣列中
		foreach($result as $key => $row)
		{
			$result[$key]->img_file = $this->upload_model->get_cache($row->img);
			
			$tmp = $row->img_list;
			$tmp = explode(',' , $tmp);
			
			foreach($tmp as $kk => $vv)
			{
				$result[$key]->img_file_list[] = $this->upload_model->get_cache($vv);
			}
		}
		
		return $result;
	}
	
	
	/**
	 * 取得單一商品
	 * @param boolean $active 是否限制產品狀態要開啟
	 *
	 * @return object{} $row
	 */
	public function get_product_one($id = FALSE , $active = 0)
	{
		if (!$id) return FALSE;
		
		$sql = "SELECT * FROM {$this->product_database} WHERE id = ? AND active >= ?";
		$query = $this->db->query($sql , array($id , $active));
		$row = $query->row();
		
		$query->free_result();
		
		if ($row != FALSE)
		{
			//將圖片資訊寫入到陣列中
			$row->img_file = $this->upload_model->get_cache($row->img);
			$tmp = $row->img_list;
			$tmp = explode(',' , $tmp);	
			
			foreach($tmp as $key => $val)
			{
				$row->img_file_list[] = $this->upload_model->get_cache($val);
			}
		}
		
		return $row;
	}
	
	
	/**
	 * 取得最新優惠商品
	 * 
	 */
	public function get_sale_list($page = 0 , $limit = 10)
	{
		$page = (int) $page;
		$limit = (int) $limit;
		
		$start = $page * $limit;
		
		$sql = "SELECT * FROM {$this->product_database} WHERE discount_active > 0 AND discount_end_date >= NOW() AND active > 0 AND start_date <= '{$this->today}' AND (end_date >= '{$this->today}' OR end_date = '0000-00-00') ORDER BY create_at DESC LIMIT ? , ?";
		$query = $this->db->query($sql , array($start , $limit));
		$result = $query->result();
		
		$query->free_result();
		
		//將圖片資訊寫入到陣列中
		foreach($result as $key => $row)
		{
			$result[$key]->img_file = $this->upload_model->get_cache($row->img);
			
			$tmp = $row->img_list;
			$tmp = explode(',' , $tmp);
			
			foreach($tmp as $kk => $vv)
			{
				$result[$key]->img_file_list[] = $this->upload_model->get_cache($vv);
			}
		}
		
		return $result;
	}
	
	
	/**
	 * 取得最新商品
	 *
	 */
	public function get_news_list($page = 0 , $limit = 10)
	{
		$json = json_decode(get_cache('meta/home_list.json') , TRUE);
		$ary = explode("\n" , $json['product_list']);
		$result = [];
		
		foreach($ary as $k => $pid)
		{
			$product = $this->get_product_one($pid , 1);
			if ($product != FALSE)
			{
				$result[] = $product;
			}
		}
		
		return $result;
		exit();
		
	
		$page = (int) $page;
		$limit = (int) $limit;
		
		$start = $page * $limit;
		
		$sql = "SELECT * FROM {$this->product_database} WHERE (discount_active = 0 OR (discount_active = 1 AND discount_end_date < NOW())) AND active > 0 AND start_date <= '{$this->today}' AND (end_date >= '{$this->today}' OR end_date = '0000-00-00') ORDER BY create_at DESC LIMIT ? , ?";
		$query = $this->db->query($sql , array($start , $limit));
		$result = $query->result();
		
		$query->free_result();
		
		//將圖片資訊寫入到陣列中
		foreach($result as $key => $row)
		{
			$result[$key]->img_file = $this->upload_model->get_cache($row->img);
			
			$tmp = $row->img_list;
			$tmp = explode(',' , $tmp);
			
			foreach($tmp as $kk => $vv)
			{
				$result[$key]->img_file_list[] = $this->upload_model->get_cache($vv);
			}
		}
		
		return $result;
	}
	
	
	/**
	 * 取得你可能喜歡的商品
	 * @param int $id
	 * @param int $page
	 * @param int $limit
	 *
	 * @return array(object{})
	 */
	public function get_love_list($id = FALSE , $page = 0 , $limit = 10)
	{
		$page = (int) $page;
		$limit = (int) $limit;
		$start = $page * $limit;
		
		$product = $this->get_product_one($id , 1);
		
		if (!$product)
		{
			//如果找不到該商品，呈現優惠
			$result = $this->get_sale_list();
			
			if ($result == FALSE || count($result) < 4)
			{
				return $this->get_news_list();
			}
			
			return $result;
		}
		else
		{
			//找到該商品，尋找相關的商品
			$sql = "SELECT * FROM {$this->product_database} WHERE active > 0 AND (brand LIKE '%{$product->brand}%' OR classs LIKE '%{$product->brand}%') AND id != ? AND start_date <= '{$this->today}' AND (end_date >= '{$this->today}' OR end_date = '0000-00-00') LIMIT ? , ?";
			$query = $this->db->query($sql , array($product->id , $start , $limit));
			$result = $query->result();
			
			//將圖片資訊寫入到陣列中
			foreach($result as $key => $row)
			{
				$result[$key]->img_file = $this->upload_model->get_cache($row->img);
				
				$tmp = $row->img_list;
				$tmp = explode(',' , $tmp);
				
				foreach($tmp as $kk => $vv)
				{
					$result[$key]->img_file_list[] = $this->upload_model->get_cache($vv);
				}
			}
		}
		
		if (count($result) < 4)
		{
			$result = $this->get_news_list();
		}
		
		$query->free_result();		
		
		return $result;
	}
	
	
	/**
	 * 取得商品列表
	 * @param int $type brand_id
	 * @param string $classs  classs
	 * @param int $page
	 * @param int $limit
	 *
	 * @return array(object{})
	 */
	public function get_list_by_type($type = FALSE , $classs = FALSE , $page = 0 , $limit = 20, $order =FALSE)
	{
		$type = (int) $type;
		$page = (int) $page;
		$limit = (int) $limit;
		$sql_classs = '';
		$sql_data = array();
		$start = $page>0?($page - 1) * $limit:0;
		
		if ($classs != FALSE)
		{
			$sql_classs = ' AND classs = ? ';
			$sql_data = array($type , $classs , $start , $limit);
		}
		else
		{
			$sql_data = array($type , $start , $limit);
		}
		
		//價錢低到高
		if($order == 1){
			$sql = "SELECT * FROM {$this->product_database} WHERE active > 0 AND brand_id = ? {$sql_classs} AND start_date <= '{$this->today}' AND (end_date >= '{$this->today}' OR end_date = '0000-00-00') ORDER BY price_min ASC LIMIT ? , ?";
		//價錢高到低
		}else if($order == 2){
			$sql = "SELECT * FROM {$this->product_database} WHERE active > 0 AND brand_id = ? {$sql_classs} AND start_date <= '{$this->today}' AND (end_date >= '{$this->today}' OR end_date = '0000-00-00') ORDER BY price_min DESC LIMIT ? , ?";
		//新到舊
		}else{
			$sql = "SELECT * FROM {$this->product_database} WHERE active > 0 AND brand_id = ? {$sql_classs} AND start_date <= '{$this->today}' AND (end_date >= '{$this->today}' OR end_date = '0000-00-00') ORDER BY create_at DESC LIMIT ? , ?";			
		}



		$query = $this->db->query($sql , $sql_data);
		$result = $query->result();
		
		$query->free_result();
		
		//將圖片資訊寫入到陣列中
		foreach($result as $key => $row)
		{
			$result[$key]->img_file = $this->upload_model->get_cache($row->img);
			
			$tmp = $row->img_list;
			$tmp = explode(',' , $tmp);
						foreach($tmp as $kk => $vv)
			{
				$result[$key]->img_file_list[] = $this->upload_model->get_cache($vv);
			}
		}
		
		return $result;
	}
	
	
	/**
	 * 計算依照類別搜尋的總數
	 *
	 */
	public function get_list_by_type_total($type = FALSE , $classs = FALSE)
	{
		$type = (int) $type;
		$sql_classs = '';
		$sql_data = array();
		
		if ($classs != FALSE)
		{
			$sql_classs = 'AND classs = ? ';
			$sql_data = array($type , $classs);
		}
		else
		{
			$sql_data = array($type);
		}
		
		$sql = "SELECT count(*) as total FROM {$this->product_database} WHERE active > 0 AND brand_id = ? {$sql_classs}";
		$query = $this->db->query($sql , $sql_data);
		$row = $query->row();
		
		return $row->total;
	}
	
	
	/**
	 * 搜尋商品
	 *
	 */
	public function get_product_list_by_search($keywords = FALSE , $page = 0 , $limit = 20)
	{
		if (!$keywords) return FALSE;
		
		$start = $page > 0 ? ($page - 1) * $limit:0;
		
		$keywords = '%' . $keywords . '%';
		
		$sql = "SELECT * FROM {$this->product_database} WHERE active > 0 AND (product_id LIKE ? OR brand LIKE ? OR classs LIKE ? OR title LIKE ? OR origin LIKE ?) AND start_date <= '{$this->today}' AND (end_date >= '{$this->today}' OR end_date = '0000-00-00') ORDER BY create_at DESC LIMIT ? , ?";
		$query = $this->db->query($sql , array($keywords , $keywords , $keywords , $keywords , $keywords, $start , $limit));
		
		$result = $query->result();
		
		$query->free_result();
		
		//將圖片資訊寫入到陣列中
		foreach($result as $key => $row)
		{
			$result[$key]->img_file = $this->upload_model->get_cache($row->img);
			
			$tmp = $row->img_list;
			$tmp = explode(',' , $tmp);
						foreach($tmp as $kk => $vv)
			{
				$result[$key]->img_file_list[] = $this->upload_model->get_cache($vv);
			}
		}
		
		return $result;
	}
	
	
	/**
	 * 計算搜尋筆數
	 *
	 */
	public function get_product_list_by_search_total($keywords = FALSE , $page = 0 , $limit = 20)
	{
		if (!$keywords) return 0;
		
		$start = $page > 0 ? ($page - 1) * $limit:0;
		
		$keywords = '%' . $keywords . '%';
		
		$sql = "SELECT count(*) as total FROM {$this->product_database} WHERE active > 0 AND (product_id LIKE ? OR brand LIKE ? OR classs LIKE ? OR title LIKE ? OR origin LIKE ?) AND start_date <= '{$this->today}' AND (end_date >= '{$this->today}' OR end_date = '0000-00-00') ORDER BY create_at DESC LIMIT ? , ?";
		$query = $this->db->query($sql , array($keywords , $keywords , $keywords , $keywords , $keywords, $start , $limit));
		
		$row = $query->row();
		
		return isset($row->total)?$row->total:0;
	}
	
	
	public function get_product_all_by_pncode($pname = FALSE , $pcode = FALSE)
	{
		if ($pname == FALSE && $pcode == FALSE)
		{
			return FALSE;
		}
		
		if ($pname != FALSE)
		{
			$this->db->like('title' , $pname);
		}
		
		if ($pcode != FALSE)
		{
			$this->db->like('product_id' , $pcode);
		}
		$this->db->where('active' , 1);
		$this->db->order_by('create_at' , 'desc');
		$query = $this->db->get($this->product_database);
		
		return $query->result();
	}

	
	/**
	 * 新增產品
	 * @param array $data
	 * 
	 * @return boolean
	 */
	public function add_product($data = array())
	{
		if (!is_array($data)) return FALSE;
		
		unset($data['color_list']);
		
		$query = $this->db->insert($this->product_database , $data);
		
		// $sql_data = array();
		// $sql_set = '';
		
		// foreach($this->defaults as $key => $val)
		// {
			// if (isset($data[$key]))
			// {
				// $sql_data[] = $data[$key];
			// }
			// else
			// {
				// $sql_data[] = $val;
			// }
			
			// if ($sql_set != '')
			// {
				// $sql_set .= ' , ' .  $key . ' = ? ';
			// }
			// else
			// {
				// $sql_set .= $key . ' = ? ';
			// }
		// }
		
		// $sql = "INSERT INTO {$this->product_database} SET {$sql_set}";
		// $query = $this->db->query($sql , $sql_data);
		
		if ($query)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	
	/**
	 * 修改產品
	 * @param array() $data
	 * 
	 * @return boolean
	 */
	public function edit_product($data = array())
	{
		if (!is_array($data)) return FALSE;
		
		$this->db->where('id' , $data['id']);
		$query = $this->db->get($this->product_database);
		$old_row = $query->row();
		
		if (!$old_row) return FALSE;
		
		foreach($data as $key => $val)
		{
			if ($key != 'id')
			{
				if (isset($old_row->$key)) $old_row->$key = $val;
			}
		}
		
		unset($old_row->id);
		
		$this->db->where('id' , $data['id']);
		return $this->db->update($this->product_database , $old_row);
		exit();
		
		$sql_data = array();
		$sql_set = '';
		
		foreach($this->defaults as $key => $val)
		{
			if ($key == 'id') continue;
			
			if (isset($data[$key]))
			{
				$sql_data[] = $data[$key];
			}
			else
			{
				$sql_data[] = $val;
			}
			
			if ($sql_set != '')
			{
				$sql_set .= ' , ' .  $key . ' = ? ';
			}
			else
			{
				$sql_set .= $key . ' = ? ';
			}
		}
		
		$sql_data[] = $data['id'];
		
		$sql = "UPDATE {$this->product_database} SET {$sql_set} WHERE id = ?";
		$query = $this->db->query($sql , $sql_data);
		
		if ($query)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	
	/**
	 * 刪除產品(假刪除)
	 * @param int $id
	 *
	 * @return boolean
	 */
	public function del_product($id = FALSE)
	{
		if (!$id) return FALSE;
		
		return $this->change_product_active($id , '-1');
	}
	
	
	/**
	 * 刪除產品
	 * @param int $id
	 *
	 * @reutrn boolean
	 */
	public function del_product_real($id)
	{
		if (!$id) return FALSE;
		
		$sql = "DELETE FROM {$this->product_database} WHERE id = ?";
		$query = $this->db->query($sql , array($id));
		
		if ($query)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	
	/**
	 * 改變產品狀態
	 * @param int $id 
	 * 
	 * @return boolean
	 */
	public function change_product_active($id = FALSE , $active = FALSE)
	{
		if (!$id) return FALSE;
		
		$sql = "UPDATE {$this->product_database} SET active = ? WHERE id = ?";
		$query = $this->db->query($sql , array($active , $id));
		
		if ($query)
		{
			return TRUE;
		}
		
		return FALSE;
	}

	/**
	 * 改變產品狀態
	 * @param int $id 
	 * 
	 * @return boolean
	 */
	public function change_product_length($id = FALSE , $length = FALSE)
	{
		if (!$id) return FALSE;
		
		$sql = "UPDATE {$this->product_database} SET length = ? WHERE id = ?";
		$query = $this->db->query($sql , array($length , $id));
		
		if ($query)
		{
			return TRUE;
		}
		
		return FALSE;
	}	
	
	
	/** 
	 * 產生產品類別與子類別清單
	 *
	 */
	public function get_product_menu()
	{
		$response = array();
		
		$sql = "SELECT brand , brand_id FROM {$this->product_database} WHERE active > 0 GROUP BY brand_id";
		$query = $this->db->query($sql);
		$result = $query->result();
		
		foreach($result as $key => $row)
		{
			$response[] = array('brand_id'=>$row->brand_id , 'brand'=>$row->brand , 'classslist' => array());
		}
		
		foreach($response as $key => $row)
		{
			$sql = "SELECT distinct(classs) as clas FROM {$this->product_database} WHERE active > 0 AND brand_id = ?";
			$query = $this->db->query($sql , array($row['brand_id']));
			$classs_list = $query->result();
			
			foreach($classs_list as $kk => $rr)
			{
				array_push($response[$key]['classslist'] , $rr->clas);
			}
		}
		
		return $response;
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
		
		$this->db->where('active' , 1);
		$this->db->order_by('create_at' , 'desc');
		$query = $this->db->get($this->product_database);
		
		return $query->result();
	}
	
	// 透過檢所資料
	public function search_bar($type_a = FALSE , $pname = FALSE , $pcode = FALSE)
	{
		if ($type_a != FALSE)
		{
			$this->db->where('type_a' , $type_a);
		}
		if ($pname != FALSE)
		{
			$this->db->like('title' , $pname);
		}
		if ($pcode != FALSE)
		{
			$this->db->like('product_id' , $pcode);
		}
		
		$this->db->where('active' , 1);
		$this->db->order_by('create_at' , 'desc');
		$query = $this->db->get($this->product_database);
		
		return $query->result();
	}
}

/* End of file Product_model.php */
/* Location: ./apps/models/Product_model.php */