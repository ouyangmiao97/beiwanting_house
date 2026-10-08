<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class City_model extends MY_Model {

	/**
	 * 建構式
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = 'city';
	}
	
	
	/**
	 * 解構式
	 *
	 */
	public function __destruct()
	{
		
	}
	
	
	public function add($data = FALSE)
	{
		return $this->_add($data);
	}
	
	public function edit($data = FALSE)
	{
		return $this->_edit($data);
	}
	
	public function del($id = FALSE)
	{
		return $this->_del($id);
	}
	
	public function get_all_list()
	{
		return $this->_get_all_list();
	}
	
	public function get_list($page = 0 , $limit = 100)
	{
		$page = $page == 0 ? 1 : $page;
		$start = ($page - 1) * $limit;
		
		return $this->_get_list('datetime' , 'desc' , $start , $limit);
	}
	
	public function get_one($id = FALSE)
	{
		return $this->_get_one($id);
	}
	
	public function change_active($id = FALSE , $active = FALSE)
	{
		return $this->_change_active($id , $active);
	}
}