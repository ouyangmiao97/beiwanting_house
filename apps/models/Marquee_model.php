<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Marquee_model extends MY_Model {

	/**
	 * 建構式
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = 'marquee';
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
		$data['create_at'] = date("Y-m-d H:i:s");
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
	
	public function get_list($page = FALSE , $limit = 20)
	{
		return $this->_get_list($page , $limit);
	}
	
	public function get_list_count()
	{
		return $this->_get_list_count();
	}
	
	public function get_list_r($page = FALSE , $limit = 20)
	{
		return $this->_get_list($page , $limit);
	}
	
	public function get_list_count_r()
	{
		return $this->_get_list_count();
	}
	
	public function get_all_list()
	{
		$this->db->order_by('create_at' , 'asc');
		return $this->_get_all_list();
	}

	public function get_one($id = FALSE)
	{
		return $this->_get_one($id);
	}

}