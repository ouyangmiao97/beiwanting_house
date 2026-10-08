<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload_model extends CI_Model {
	/**
	 * Upload Model
	 * 
	 * @package		: zh-tech
	 * @copyright	: zh-tech 振華科技
	 * @author		: Tone
	 *
	 */
	private $cache_path = 'uploads/';
	
	private $cache_ext = '.json';
	
	private $uploads_database = 'uploads';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->_check_cache_dir();
		
	}
	
	public function __destruct()
	{
		
	}
	
	
	private function _check_cache_dir()
	{
		if (!is_dir(APPPATH . 'cache/uploads/'))
		{
			mkdir(APPPATH . 'cache/uploads/');
			chmod(APPPATH . 'cache/uploads/' , 0777);
		}
		
		if (!is_dir('uploads/'))
		{
			mkdir(APPPATH . 'uploads/');
			chmod(APPPATH . 'uploads/' , 0777);
		}
		
		if (!is_dir('uploads/images/'))
		{
			mkdir(APPPATH . 'uploads/images/');
			chmod(APPPATH . 'uploads/images/' , 0777);
		}
	}
	
	
	public function get_uploads_one($id = FALSE)
	{
		$id = (int) $id;
		
		$sql = "SELECT * FROM {$this->uploads_database} WHERE id = ?";
		$query = $this->db->query($sql , array($id));
		
		return $query->row();
	}
	
	public function add_uploads($datas = array())
	{
		$defaults = array(
			'file_name'=>'',
			'file_type'=>'',
			'file_path'=>'',
			'full_path'=>'',
			'raw_name'=>'',
			'orig_name'=>'',
			'file_ext'=>'',
			'file_size'=>0,
			'is_image'=>0,
			'image_width'=>0,
			'image_height'=>0,
			'image_type'=>'',
			'image_size_str'=>'',
			'alt'=>'',
		);
		
		foreach($defaults as $key => $val)
		{
			if (isset($datas[$key]))
			{
				$$key = $datas[$key];
			}
			else
			{
				$$key = $val;
			}
		}
		
		if ($file_name == FALSE || $file_type == FALSE || $file_path == FALSE || $full_path == FALSE || $raw_name == FALSE || $orig_name == FALSE || $file_ext == FALSE)
		{
			return FALSE;
		}
		
		if ($file_size == FALSE || $image_width == FALSE || $image_height == FALSE || $image_type == FALSE || $image_size_str == FALSE)
		{
			return FALSE;
		}
		
		$sql = "INSERT INTO {$this->uploads_database} SET  file_name = ? , 
														file_type = ? ,
														file_path = ? ,
														full_path = ? ,
														raw_name = ? , 
														orig_name = ? ,
														file_ext = ? , 
														file_size = ? , 
														is_image = ? , 
														image_width = ? ,
														image_height = ? ,
														image_type = ? ,
														image_size_str = ? ,
														alt = ?";
		$query = $this->db->query($sql , array($file_name , $file_type , $file_path , $full_path , $raw_name , $orig_name , $file_ext , $file_size , $is_image , $image_width , $image_height , $image_type , $image_size_str , $alt));
		
		if ($query)
		{
			$id = $this->db->insert_id();
			
			$this->set_cache($id);
			
			return $id;
		}
		
		return FALSE;
	}
	
	public function edit_uploads_alt($id = FALSE , $alt = FALSE)
	{
		if ($id == FALSE || $alt == FALSE)
		{
			return FALSE;
		}
		
		$sql = "UPDATE {$this->uploads_database} SET alt = ? WHERE id = ?";
		$query = $this->db->query($sql , array($alt , $id));
		
		$this->rm_cache($id);
		$this->set_cache($id);
		
		if ($query) return TRUE;
		
		return FALSE;
	}
	
	
	public function edit_uploads_mask_rand($id = FALSE , $mask = FALSE , $rand = FALSE)
	{
		if (!$id || !$mask || !$rand) return FALSE;
		
		$sql = "UPDATE {$this->uploads_database} SET mask = ? , rand = ? WHERE id = ?";
		$query = $this->db->query($sql , array($mask , $rand , $id));
		
		return $query;
	}
	
	
	public function del_uploads($id = FALSE)
	{
		if ($id == FALSE)return FALSE;
		
		$uploads = $this->get_uploads_one($id);
		
		if (count($uploads) == 0) return FALSE;
		
		@unlink($uploads->full_path);
		
		if (is_file($uploads->full_path))
		{
			return FALSE;
		}
		
		$sql = "DELETE FROM {$this->uploads_database} WHERE id = ? ";
		$query = $this->db->query($sql , array($id));
		
		$this->rm_cache($id);
		
		if ($query) return TRUE;
		
		return FALSE;
	}
	
	public function get_cache($id = FALSE)
	{		
		$file_name = $this->cache_path . $id . $this->cache_ext;
		
		$cache = get_cache($file_name);
		
		if (!$cache)
		{
			$this->set_cache($id);
			
			$cache = get_cache($file_name);
		}
		
		return json_decode($cache);
	}
	
	public function set_cache($id = FALSE)
	{
		$data = $this->get_uploads_one($id);
		
		if ($data != FALSE)
		{
			$file_name = $this->cache_path . $id . $this->cache_ext;
			
			set_cache($file_name , json_encode($data));
		}
	}
	
	public function rm_cache($id = FALSE)
	{
		$file_name = $this->cache_path . $id . $this->cache_ext;
		
		rm_cache($file_name);
	}
	

}

/* End of file Upload_model.php */
/* Location: ./apps/models/Upload_model.php */