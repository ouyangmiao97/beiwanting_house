<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_color_model extends MY_ZH_Model {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->table = 'product_color';
	}
}