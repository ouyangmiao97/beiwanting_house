<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Meta_model extends CI_Model {
	/**
	 * Meta Model
	 * 
	 * @package		: zh-tech
	 * @copyright	: zh-tech 振華科技
	 * @author		: Tone
	 *
	 */
	private $defaults = array(
			'web_title' => '',
			'web_title_end' => '',
			'web_author' => '',
			'web_description' => '',
			'web_keywords' => '',
			'web_footer' => '',
		);
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->_check_cache_dir();
		
		$this->_get_config_meta();
	}
	
	
	public function __destruct()
	{
		
	}
	
	
	private function _check_cache_dir()
	{
		$dir = APPPATH . 'cache/meta';
		
		if (!is_dir($dir))
		{
			mkdir($dir);
			
			chmod($dir , 0777);
		}
	}
	
	
	/**
	 * 轉換成快取名稱
	 *
	 */
	private function _get_cache_name($cache_name = '')
	{
		return 'meta/meta_' . $cache_name . '.json';
	}
	
	
	/**
	 * 載入預設的config資料
	 *
	 */
	private function _get_config_meta()
	{
		$this->defaults['web_title'] = config_item('default_title')?config_item('default_title'):$this->defaults['web_title'];
		$this->defaults['web_title_end'] = config_item('title_end')?config_item('title_end'):$this->defaults['web_title_end'];
		$this->defaults['web_author'] = config_item('default_author')?config_item('default_author'):$this->defaults['web_author'];
		$this->defaults['web_description'] = config_item('default_description')?config_item('default_description'):$this->defaults['web_description'];
		$this->defaults['web_keywords'] = config_item('default_keywords')?config_item('default_keywords'):$this->defaults['web_keywords'];
		$this->defaults['web_footer'] = config_item('default_footer')?config_item('default_footer'):$this->defaults['web_footer'];
	}
	
	
	/**
	 * 取得meta資料
	 *
	 */
	public function get_meta($cache_file = FALSE)
	{
		if (!$cache_file) return FALSE;
		
		$cache_file = $this->_get_cache_name($cache_file);
		
		$cache = get_cache($cache_file);
		
		if (!$cache) return $this->defaults;
		
		$cache = json_decode($cache , TRUE);
		
		return $cache;
	}
	
	
	/**
	 * 設定meta資料
	 *
	 */
	public function set_meta($data = FALSE , $cache_file = FALSE)
	{
		if (!$data || !$cache_file) return FALSE;
		
		$cache_file = $this->_get_cache_name($cache_file);
		
		$meta = array();		
		
		foreach($this->defaults as $key => $val)
		{
			if (isset($data[$key]))
			{
				$meta[$key] = $data[$key];
			}
			else
			{
				$meta[$key] = $this->defaults[$key];
			}
		}
		
		foreach($meta as $key => $val)
		{
			if ($val == FALSE) return FALSE;
		}
		
		set_cache($cache_file , json_encode($meta));
		
		return TRUE;
	}
}

/* End of file Meta_model.php */
/* Location: ./apps/models/Meta_model.php */