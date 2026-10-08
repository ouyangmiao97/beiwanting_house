<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends CI_Model {
	/**
	 * Zh_tech Model
	 * 
	 * @package		: zh-tech
	 * @copyright	: zh-tech 振華科技
	 * @author		: Tone
	 * @depend		: zh_tech_helper , menu config
	 */
	private $cache_file = 'menu_cache_file';
	
	private $default_file = 'menu_cache_default';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->config('menu');
		
		$this->_check_cache_dir();
	}
	
	public function __destruct()
	{
		
	}
	
	private function _check_cache_dir()
	{
		if (!is_dir(APPPATH . 'cache/menu/'))
		{
			mkdir(APPPATH . 'cache/menu/');
			chmod(APPPATH . 'cache/menu/' , 0777);
		}
		
		if (!is_dir(APPPATH . 'cache/menu/oldmenu/'))
		{
			mkdir(APPPATH . 'cache/menu/oldmenu/');
			chmod(APPPATH . 'cache/menu/oldmenu/' , 0777);
		}
	}
	
	/**
	 * 取得系統選單的快取檔案資料
	 *
	 */
	public function get_cache_menu($array_key = 0)
	{		
		$cache_file = config_item($this->cache_file);
		
		$cache_file = $cache_file[$array_key];
		
		$cache = get_cache($cache_file);
		
		if (!$cache)
		{
			$this->create_default_cache($array_key);
			
			$cache = get_cache($cache_file);
		}
		
		if (!$cache)
		{
			return FALSE;
		}
		
		$cache = json_decode($cache , TRUE);
		
		return $cache;
	}
	
	
	/**
	 * 產生預設的快取檔案
	 *
	 */
	private function create_default_cache($array_key = 0)
	{
		$cache_file = config_item($this->cache_file);
		
		$cache_file = $cache_file[$array_key];
		
		$cache = config_item($this->default_file);
		
		$cache = $cache[$array_key];
		
		set_cache($cache_file , json_encode($cache));
	}
	
	
	/**
	 * 寫入快取
	 *
	 */
	public function set_cache_menu($cache = FALSE , $array_key = 0)
	{
		if (!$cache) return FALSE;
		
		$cache_file = config_item($this->cache_file);
		
		$cache_file = $cache_file[$array_key];
		
		//備份舊檔案
		$backup = config_item('old_menu_backup');
		$backup_path = config_item('old_menu_backup_path');
		if ($backup)
		{
			$old = $this->get_cache_menu($array_key);
			if (!is_dir(APPPATH . 'cache/' . $backup_path)){
				mkdir(APPPATH . 'cache/' . $backup_path);
				chmod(APPPATH . 'cache/' . $backup_path , 0777);
			}
			set_cache($backup_path . date('YmdHis') . '.json' , json_encode($old));
			unset($old);
		}
		
		//將不要的資料轉換掉
		$cache = $this->bind_bad_code($cache);
		
		set_cache($cache_file , $cache);
	}
	
	
	public function bind_bad_code($cache = FALSE)
	{
		if (!$cache) return FALSE;
		
		$cache = json_decode($cache , TRUE);
		
		$cache[0]['state']['opened'] = true;
		$cache[0]['state']['selected'] = true;
		$cache[0]['a_attr'] = array();
		
		foreach($cache[0]['children'] as $key => $row)
		{
			$cache[0]['children'][$key]['state']['opened'] = true;
			$cache[0]['children'][$key]['state']['selected'] = false;
			$cache[0]['children'][$key]['a_attr'] = array();
			
			if (isset($row['children']) && count($row['children']) > 0)
			{
				foreach($row['children'] as $kkey => $row2)
				{
					$cache[0]['children'][$key]['children'][$kkey]['state']['opened'] = false;
					$cache[0]['children'][$key]['children'][$kkey]['state']['selected'] = false;
					$cache[0]['children'][$key]['children'][$kkey]['a_attr'] = array();
					
					if (isset($row2['children']) && count($row2['children']) > 0)
					{
						foreach($row2['children'] as $kkkey => $row3)
						{
							$cache[0]['children'][$key]['children'][$kkey]['children'][$kkkey]['state']['opened'] = false;
							$cache[0]['children'][$key]['children'][$kkey]['children'][$kkkey]['state']['selected'] = false;
							$cache[0]['children'][$key]['children'][$kkey]['children'][$kkkey]['a_attr'] = array();
							
							if (isset($row3['children']) && count($row3['children']) > 0)
							{
								foreach($row3['children'] as $kkkkey => $row4)
								{
									$cache[0]['children'][$key]['children'][$kkey]['children'][$kkkey]['children'][$kkkkey]['state']['opened'] = false;
									$cache[0]['children'][$key]['children'][$kkey]['children'][$kkkey]['children'][$kkkkey]['state']['selected'] = false;
									$cache[0]['children'][$key]['children'][$kkey]['children'][$kkkey]['children'][$kkkkey]['a_attr'] = array();
								}
							}
						}
					}
				}
			}
		}
		
		return json_encode($cache);
	}
}

/* End of file Zh_tech_model.php */
/* Location: ./apps/models/Zh_tech_model.php */