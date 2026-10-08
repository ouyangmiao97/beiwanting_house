<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_model extends CI_Model {
	/**
	 * Page Model
	 * 
	 * @package		: 自製獨立頁面
	 * @copyright	: zh-tech 振華科技
	 * @author		: Tone
	 *
	 */
	private $cache_path = 'page/';
	
	private $cache_ext = '.cache';
	
	private $cache_uri = '/page/';
	
	private $bad_code_run_times = 10;
	
	private $page_database = 'page';

	public function __construct()
	{
		parent::__construct();
		
	}
	
	public function __destruct()
	{
		
	}
	
	
	/**
	 * 產生檔名
	 * @parma string $page
	 *
	 * @return string $filename
	 */
	private function get_filename($page = FALSE)
	{
		if (!$page) return FALSE;
		
		return $this->cache_path . $page . $this->cache_ext;
	}
	

	/**
	 * 取得快取頁面
	 * @param stirng $page
	 *
	 * @return string $cache
	 */
	public function get_html($page = FALSE )
	{
		if (!$page) return FALSE;
		
		$filename = $this->get_filename($page);
		
		return get_cache($filename);
	}
	

	/**
	 * 寫入快取頁面
	 * @param string $page
	 * @param string $html
	 *
	 * @return array(status , msg)
	 */
	public function write_cache($page = FALSE , $html = FALSE)
	{
		if (!$page || !$html) return FALSE;
		
		$filename = $this->get_filename($page);
		
		$html = $this->bind_bad_code($html);
		
		set_cache($filename , $html);
		
		if (get_cache($filename)) return TRUE;
		
		return FALSE;
	}
	
	
	/**
	 * 移除快取頁面
	 *
	 */
	public function remove_cache($page = FALSE)
	{
		if (!$page) return FALSE;
		
		$filename = $this->get_filename($page);
		
		if (@rm_cache($filename)) return TRUE;
		
		return FALSE;
	}
	
	
	/**
	 * 過濾html碼資料
	 * @param string $html
	 * 
	 * @return string $html
	 */
	public function bind_bad_code($html = "")
	{
		//取代admin template 產生的多餘區塊
		$html = preg_replace('/<div class="row"><\/div>/i' , '' , $html);
		
		//去除頭尾空白字元
		$html = trim($html);
		
		for($i=1;$i<=$this->bad_code_run_times;$i++)
		{
			//取代多餘的空白
			$html = preg_replace('/\s\s/i' , ' ' , $html);
		}

		//消除多餘的換行
		$html = preg_replace('/\n/i' , '' , $html);
		
		return $html;
	}
	
	
	/**
	 * 取得頁面列表
	 *
	 **/
	public function get_page_list()
	{
		$sql = "SELECT * FROM {$this->page_database} WHERE 1";
		$query = $this->db->query($sql);
		
		return $query->result();
	}
	
	
	/**
	 * 取得單筆頁面列表
	 *
	 */
	public function get_page_one($id = FALSE)
	{
		if (!$id) return FALSE;
		
		$sql = "SELECT * FROM {$this->page_database} WHERE id = ?";
		$query = $this->db->query($sql , array($id));
		
		return $query->row();
	}
	
	
	/**
	 * 新增page
	 *
	 */
	public function add_page($title = '' , $description = '' , $keywords = '')
	{
		if (!$title) return array('status' => 'F' , 'msg' => '缺少必要資訊');
		
		$sql = "INSERT INTO {$this->page_database} SET title = ? , description = ? , keywords = ? ";
		$query = $this->db->query($sql , array($title , $description , $keywords));
		
		if ($query)
		{
			return array('status' => 'T' , 'msg' => '新增成功');
		}
		
		return array('status' => 'F' , 'msg' => '寫入資料失敗');
	}
	
	
	/**
	 * 修改page
	 *
	 */
	public function edit_page($id = FALSE , $title = '' , $description = '' , $keywords = '')
	{
		if (!$id || !$title) return array('status' => 'F' , 'msg' => '缺少必要資訊');
		
		$sql = "UPDATE {$this->page_database} SET title = ? , description = ? , keywords = ? WHERE id = ? ";
		$query = $this->db->query($sql , array($title , $description , $keywords , $id));
		
		if ($query)
		{
			return array('status' => 'T' , 'msg' => '修改成功');
		}
		
		return array('status' => 'F' , 'msg' => '寫入資料失敗');
	}
	
	
	/**
	 * 刪除page
	 *
	 */
	public function del_page($id = FALSE)
	{
		if (!$id) return array('status' => 'F' , 'msg' => '缺少必要資訊');
		
		$sql = "DELETE FROM {$this->page_database} WHERE id = ?";
		$query = $this->db->query($sql , array($id));
		
		if ($query)
		{
			if ($this->remove_cache($id))
			{
				return array('status' => 'T' , 'msg' => '刪除成功');
			}
			
			return array('status' => 'T' , 'msg' => '刪除成功，但快取檔案刪除失敗，請洽系統管理員');
		}
		
		return array('status' => 'F' , 'msg' => '寫入資料失敗');
	}
}

/* End of file Page_model.php */
/* Location: ./apps/models/Page_model.php */