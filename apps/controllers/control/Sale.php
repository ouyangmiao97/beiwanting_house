<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends MY_Controller {

	/**
	 * @package:	侏儸紀寶石
	 * @copyright:	zh-tech 振華科技
	 * @author:		Tone
	 * 
	 *
	 */
	
	private $title_list = array(
		'單據日期',
		'單據編號',
		'客戶編號',
		'貨品編號',
		'商品名稱',
		'數量',
		'單價',
		'小計',
		'合計',
		'營業稅',
	);
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('admin_model');
		$this->load->model('order_model');
		$this->load->model('member_model');
		$this->load->model('payment_model');
		$this->load->model('product_model');
	}
	
	
	public function __destruct()
	{
		parent::__destruct();
	}

	
	public function index()
	{
		
	}
	
	
	public function get_one($order_id = FALSE)
	{
		$this->admin_model->is_login();
		
		$order = $this->order_model->get_order_one($order_id);
		
		if (!$order)
		{
			echo '查無訂單編號';
			exit();
		}
		
		$order_contents = json_decode($order->order_contents , TRUE);
		
		// echo json_encode($order_contents);
		// exit();
		
		$member = $this->member_model->get_member_by_id($order->member_id , 0);
		
		$str = '<table style="font-size:20px;"><tr>';
		
		foreach($this->title_list as $key => $val)
		{
			$str .= '<td>' . $val . '</td>';
		}
		
		$str .= '</tr>';
		
		$talsum = 0;

		foreach($order_contents as $key => $order_rows)
		{
			$product = $this->product_model->get_product_one($order_rows['options']['id'] , 0);
			
			$str .= '<tr>';
			$str .= '<td>'.date('Y/m/d' , strtotime($order->create_at)).'</td>'; 
			$str .= '<td>'.$order->order_id.'</td>'; 
			$str .= '<td>'.$member->member_no.'</td>'; 
			$str .= '<td>'.$product->product_id.'</td>'; 
			$str .= '<td>'.$product->title.'</td>'; 
			$str .= '<td>'.$order_rows['qty'].'</td>'; 
			$str .= '<td>'.$order_rows['price'].'</td>'; 
			
			$tmpsum = $order_rows['qty'] * $order_rows['price'];
			
			$str .= '<td>'.$tmpsum.'</td>'; 
			$str .= '</tr>';
		}
		
		
		
		$str .= '</table>';
		
		header("Content-type:application/vnd.ms-excel;charset:utf-8;");
		header("Content-Disposition:attachment;filename=銷貨單號".$order_id.".xls"); 
	
		echo chr(239).chr(187). chr(191);
		echo $str;exit;
	}
	
	
	public function get_sale_by_date()
	{
		$this->admin_model->is_login();
		
		$start = $this->input->post('start' , TRUE);
		$end = $this->input->post('end' , TRUE);
		
		$this->db->where('create_at >=' , $start . ' 00:00:00');
		$this->db->where('create_at <=' , $end , ' 23:59:59');
		
		$query = $this->db->get('order');
		$data_list = $query->result();
		
		$str = '<table style="font-size:20px;"><tr>';
		
		foreach($this->title_list as $key => $val)
		{
			$str .= '<td>' . $val . '</td>';
		}
		
		$str .= '</tr>';
		
		foreach($data_list as $key => $order)
		{
		
			$order_contents = json_decode($order->order_contents , TRUE);
			
			$member = $this->member_model->get_member_by_id($order->member_id , 0);
			
			$talsum = 0;

			foreach($order_contents as $key => $order_rows)
			{
				$product = $this->product_model->get_product_one($order_rows['options']['id'] , 0);
				
				$str .= '<tr>';
				$str .= '<td>'.date('Y/m/d' , strtotime($order->create_at)).'</td>'; 
				$str .= '<td>'.$order->order_id.'</td>'; 
				$str .= '<td>'.$member->member_no.'</td>'; 
				$str .= '<td>'.$product->product_id.'</td>'; 
				$str .= '<td>'.$product->title.'</td>'; 
				$str .= '<td>'.$order_rows['qty'].'</td>'; 
				$str .= '<td>'.$order_rows['price'].'</td>'; 
				
				$tmpsum = $order_rows['qty'] * $order_rows['price'];
				
				$str .= '<td>'.$tmpsum.'</td>'; 
				$str .= '</tr>';
			}
		
		}
		
		
		$str .= '</table>';
		
		header("Content-type:application/vnd.ms-excel;charset:utf-8;");
		header("Content-Disposition:attachment;filename=".$start.'至'.$end."銷貨單.xls"); 
	
		echo chr(239).chr(187). chr(191);
		echo $str;exit;
	}
}