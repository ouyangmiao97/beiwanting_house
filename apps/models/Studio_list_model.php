<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Studio_list_model extends MY_ZH_Model {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->table = 'studio_list';
	}
}