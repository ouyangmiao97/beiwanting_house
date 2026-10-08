<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Favourite_model extends CI_Model {
	/**
	 * Favourite Model
	 * 建立使用者喜愛的商品 
	 *
	 *
	 * @package		: zh-tech
	 * @copyright	: zh-tech 振華科技
	 * @author		: Tone
	 *
	 */
	
	private $love = array();
	
	private $cache = 'favourite/';
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function __destruct()
	{
		
	}
	
	
	/**
	 * 取得用戶的喜愛商品清單
	 * @param string $login
	 * @param boolean $reflash default:FALSE
	 * 
	 * return array() $this->love
	 */
	public function get($login = FALSE , $reflash = FALSE)
	{
		if (!$login) return FALSE;
		
		
		if (is_array($this->love) && count($this->love) > 0 && $reflash == FALSE)
		{
			return $this->love;
		}
		else
		{
			$this->love = json_decode(get_cache($this->name($login)) , TRUE);
			
			if (!$this->love)
			{
				$this->create($login);
				
				$this->love = json_decode(get_cache($this->name($login)) , TRUE);
			}
			
			return $this->love;
		}
	}
	

	/**
	 * 建立空資料
	 * @param boolean $login
	 */
	public function create($login = FALSE)
	{
		if (!$login) return FALSE;
		
		set_cache($this->name($login) , json_encode(array()));
	}
	
	
	/**
	 * 新增喜愛的商品
	 * @param boolean $login
	 * @param boolean $pid
	 */
	public function add($login = FALSE , $pid = FALSE)
	{
		if (!$login || !$pid) return FALSE;
		
		$this->get($login);
		
		if (!in_array($pid , $this->love))
		{
			array_push($this->love , $pid);
		}
		
		if (count($this->love)>=10)
		{
			unset($this->love[0]);
		}
		
		set_cache($this->name($login) , json_encode($this->love));
		
		$this->get($login , TRUE);
	}
	
	
	/**
	 * 刪除喜愛的商品
	 * @param string $login
	 * @param string $pid
	 */
	public function del($login = FALSE , $pid = FALSE)
	{
		if (!$login || !$pid) return FALSE;
			
		$this->get($login);
		
		$new_ary = array();
		
		foreach($this->love as $key => $val)
		{
			if ($val == $pid) continue;
			array_push($new_ary , $val);
		}
		
		set_cache($this->name($login) , json_encode($new_ary));
		
		$this->get($login , TRUE);
	}
	
	
	/**
	 * Create cache file name
	 * @param string $login
	 *
	 * @return string $name
	 */
	public function name($login = FALSE)
	{
		if (!$login) return FALSE;
		
		return $this->cache . $login . '.json';
	}
}

/* End of file Favourite_model.php */
/* Location: ./apps/models/Favourite_model.php */