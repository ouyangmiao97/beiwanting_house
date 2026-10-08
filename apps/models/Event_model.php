<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event_model extends MY_ZH_Model {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->table = 'event';
	}
	
	
	public function __destruct()
	{
		
	}
}