<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MY_Controller {

	/**
	 * @package:	侏儸紀寶石
	 * @copyright:	zh-tech 振華科技
	 * @author:		Tone
	 * 
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function __destruct(){}
	
	
	public function index()
	{

	}
	
	
	/**
	 * 產生驗證碼
	 * @return {array(captcha , captcha_code)}
	 */
	public function captcha()
	{
		if (!$this->input->is_ajax_request()) exit();
		
		// $this->load->model('captcha_model');
		
		// $this->load->config('captcha');
		
		// $this->captcha_model->set_data(config_item('captcha_setting'))->create()->out();
		
		$this->load->library('captcha');
		
		$this->captcha->set_data(config_item('captcha_setting'))->create()->out();
	}
	
	
	/**
	 * 上傳檔案
	 * @url /api/uploads.html
	 * @param post upload_file
	 * @param post alt
	 * @param return {array(status , msg , url)}
	 */
	public function uploads()
	{
		if (!$this->input->is_ajax_request()) exit();
		
		$this->load->model('admin_model');
		$this->load->model('file_model');
		$this->load->model('upload_model');
		
		$this->admin_model->is_login_ajax();
		
		$alt = $this->input->post('alt' , TRUE);
		
		$config['upload_path'] = './uploads/images/';
		$config['allowed_types'] = 'jpeg|jpg|gif|png';
		
		$response = $this->file_model->move('upload_file' , $config);
		
		if (!$response)
		{
			echo json_encode(array('status' => 'F' , 'msg' => '檔案上傳發生錯誤' , 'url' => ''));
		}
		
		$response['alt'] = $alt;
		
		$id = $this->upload_model->add_uploads($response);
		
		$id = (int) $id;
		
		if (!$id)
		{
			echo json_encode(array('status' => 'F' , 'msg' => '檔案上傳發生錯誤' , 'url' => ''));
		}
		
		$uploads = $this->upload_model->get_uploads_one($id);
		
		if ($uploads->is_image == 1)
		{
			$file_url = img_show($uploads->file_name);
			echo json_encode(array('status' => 'T' , 'msg' => '' , 'url' => $file_url));
		}
		else
		{
			echo json_encode(array('status' => 'F' , 'msg' => '檔案格式錯誤' , 'url' => ''));
		}
	}
	
	
	/**
	 * 新增至最愛清單
	 *
	 */
	public function favourite()
	{
		if (!$this->input->is_ajax_request()) exit();
		
		$this->load->model('member_model');
		$this->load->model('favourite_model');
		
		$this->member_model->is_login_ajax();
		
		$login = $this->input->post('login' , TRUE);
		$pid = $this->input->post('pid' , TRUE);
		
		$login_c = $this->member_model->get_member_login();
		
		if ($login == $login_c)
		{
			$this->favourite_model->add($login , $pid);
			
			echo json_encode(array('status'=>'T' , 'msg'=>'已經增加到您的最愛(追蹤)清單中了'));
			exit();
		}
		else
		{
			echo json_encode(array('status'=>'F' , 'msg'=>'帳號驗證錯誤'));
			exit();
		}
	}
	
	
	/**
	 * 移除最愛
	 *
	 **/
	public function del_favourite()
	{
		if (!$this->input->is_ajax_request()) exit();
		
		$this->load->model('member_model');
		$this->load->model('favourite_model');
		
		$this->member_model->is_login_ajax();
		
		$login = $this->input->post('login' , TRUE);
		$pid = $this->input->post('pid' , TRUE);
		
		$login_c = $this->member_model->get_member_login();
		
		if ($login == $login_c)
		{
			$this->favourite_model->del($login , $pid);
			
			echo json_encode(array('status'=>'T' , 'msg'=>'移除成功'));
			exit();
		}
		else
		{
			echo json_encode(array('status'=>'F' , 'msg'=>'帳號驗證錯誤'));
			exit();
		}
	}
	
	
	/**
	 * 加入購物車
	 * 
	 */
	public function add_cart($pid = FALSE , $ptid = FALSE , $num = FALSE)
	{
		if (!$this->input->is_ajax_request()) exit();
		
		$this->member_model->is_login_ajax();
		
		// 檢查會員是否通過審核
		$member = $this->member_model->get_member_my();
		if ($member->admin_verify < 1)
		{
			echo json_encode(array('status' => 'F' , 'msg' => '加入購物車失敗，您的帳號尚未通過審核。'));
			exit();
		}
		
		//商品陣列預設值
		$product = array(
			'id' => '',
			'qty' => 0,
			'price' => 0,
			'name' => '',
			'options' => array(),
		);
		
		//取得相關參數
		$pid = $pid == FALSE?$this->input->post('pid' , TRUE):$pid;
		// $degree = $this->input->post('degree' , TRUE);
		// $color = $this->input->post('color' , TRUE);
		$ptid = $ptid==FALSE?$this->input->post('ptid' , TRUE):$ptid;
		$num = $num==FALSE?$this->input->post('num' , TRUE):$num;
		
		if ($pid == FALSE || $num == FALSE)
		{
			echo json_encode(array('status' => 'F' , 'msg' => '加入購物車失敗，錯誤代碼4001'));
			exit();
		}
		
		//檢查商品庫存
		$this->load->model('product_type_model');
		// $this->load->model('inventory_model');
		
		// $inventory = $this->inventory_model->get_inventory($pid);
		$product_type = $this->product_type_model->get_one($ptid);
		// $inventory = $this->product_type_model->get_inventory($ptid);
		$inventory = $product_type->inventory;
		
		if ($inventory==FALSE || $inventory <= 0)
		{
			// 5001
			echo json_encode(array('status' => 'F' , 'msg' => '很抱歉！加入購物車失敗，目前已無任何庫存，若有疑問請洽客服人員，錯誤代碼5001'));
			exit();
		}
		
		if ($inventory==FALSE || $inventory < $num)
		{
			echo json_encode(array('status' => 'F' , 'msg' => '很抱歉！加入購物車失敗，目前商品庫存量小於您所填寫的購買量，錯誤代碼5002'));
			exit();
		}
		
		//暫時扣除該商品的庫存
		//若購物車取消則增加回去
		//加入購物車不扣除 結帳在檢查
		// if ($this->inventory_model->add_cart($inventory->id , $num) == FALSE)
		// {
			// echo json_encode(array('status' => 'F' , 'msg' => '很抱歉！商品扣除失敗，請稍後再試，如果此問題持續存在請聯絡客服人員處理，錯誤代碼5003'));
			// exit();
		// }
		
		//載入商品資訊
		$this->load->model('product_model');
		
		$pro = $this->product_model->get_product_one($pid , 1);
		
		if (!$pro)
		{
			//商品扣除庫存會有問題，於實際購買時再扣除庫存
			//把扣除的商品數量加回去
			// $this->inventory_model->del_cart($inventory->id , $num);
			
			echo json_encode(array('status' => 'F' , 'msg' => '很抱歉！系統發生錯誤，請稍後再試，如果此問題持續存在請聯絡客服人員處理，錯誤代碼5004'));
			exit();
		}
		
		//要將度數與顏色轉換回item的id
		$this->load->model('item_model');
		
		// $degree_id = $this->item_model->get_id_by_title($degree , 1);
		// $color_id = $this->item_model->get_id_by_title($color , 2);
		
		// if ($color_id == FALSE)
		// {
			// echo json_encode(array('status' => 'F' , 'msg' => '很抱歉！系統發生錯誤，請稍後再試，如果此問題持續存在請聯絡客服人員處理，錯誤代碼5006'));
			// exit();
		// }
		
		//寫入購物車的資訊
		$product['id'] = 'e' . sprintf('%06d' , $pro->id);
		// $product['id'] = 'WEFOX' . str_pad($pro->id , 8 , '0' , STR_PAD_LEFT) . str_pad($degree_id , 2 , '0' , STR_PAD_LEFT) . str_pad($degree_id , );
		$product['qty'] = $num;
		
		
		// 採用product_type的價格
		$product['price'] = $product_type->price;
		
		// if ($pro->discount_active==1 && strtotime($pro->discount_end_date) >= time())
		// {
			// $product['price'] = $pro->discount_price;
		// }
		// else
		// {
			// $product['price'] = $pro->price;
		// }
		
		
		$product['name'] = 'WEFOX' . str_pad($pro->id , 8 , '0' , STR_PAD_LEFT);
		$product['options'] = array(
			'id' => $pro->id,
			'name' => $pro->title,
			// 'color' => $color,
			// 'degree' => $degree,
			'brand' => $pro->brand ,
			'classs' => $pro->classs ,
			'pick' => $pro->pick ,
			'origin' => $pro->origin ,
			'type' => $pro->type ,
			'water' => $pro->water ,
			'word' => $pro->word ,
			'base_curve' => $pro->base_curve ,
			'diameter_img' => $pro->diameter_img , 
			'diameter_head' => $pro->diameter_head ,
			'img_file' => $pro->img_file,
			'product_id' => $pro->product_id,
			'ptid' => $ptid,
			'length' => $pro->length,
			'pttitle' => $product_type->color . $product_type->cap . $product_type->length
		);
		
		$this->load->library('session');
		$this->load->library('cart');
		
		if ($this->cart->insert($product) == FALSE)
		{
			echo json_encode(array('status' => 'F' , 'msg' => '加入購物車失敗，請稍後在試，如果此問題持續存在請聯絡客服人員處理，錯誤代碼5005'));
			exit();
		}
		
		echo json_encode(array('status' => 'T' , 'msg' => '已經加入到購物車中，您可以在購物車中瀏覽已加入的商品'));
		exit();
	}
	
	
	/**
	 * 檢查商品庫存
	 *
	 */
	public function check_product_inventory()
	{
		
		exit();
		
		if (!$this->input->is_ajax_request()) exit();
		
		$this->member_model->is_login_ajax();
		
		$this->load->model('inventory_model');
		
		$pid = $this->input->post('pid' , TRUE);
		
		// $color = $this->input->post('color' , TRUE); 
		
		// $degree = $this->input->post('degree' , TRUE);
		
		$response = $this->inventory_model->check_product_inventory($pid);
		
		echo $response;
		
		// echo json_encode(array('status' => 'T' , 'result' => 1 , 'num' => 999));
		
		// exit();
	}
	
	
	/**
	 * 清空購物車
	 *
	 */
	public function clear_cart()
	{
		if (!$this->input->is_ajax_request()) exit();
		
		$this->member_model->is_login_ajax();
		
		$this->load->library('cart');
		
		$this->cart->destroy();
		
		echo json_encode(array('status' => 'T' , 'msg' => '清除完畢'));
		exit();
	}
	
	
	/**
	 * 將某商品從購物車中移除
	 *
	 */
	public function del_cart()
	{
		if (!$this->input->is_ajax_request()) exit();
		
		$this->member_model->is_login_ajax();
		
		$this->load->library('cart');
		
		$rowid = $this->input->post('rowid' , TRUE);
		
		$data = array(
			'rowid' => $rowid,
			'qty' => 0,
		);
		
		if ($this->cart->update($data))
		{
			echo json_encode(array('status' => 'T' , 'msg' => '移除完畢'));
			exit();
		}
		
		log_message('error' , 'cart error 5102.');
		
		echo json_encode(array('status' => 'F' , 'msg' => '移除商品失敗，錯誤代碼5102'));
		exit();
	}
	
	
	/**
	 * 更新購物車
	 *
	 */
	public function update_cart()
	{
		if (!$this->input->is_ajax_request()) exit();
		
		$this->member_model->is_login_ajax();
		
		$this->load->library('cart');
		$this->load->model('product_type_model');
		
		// 購物車識別ID
		$rowid = $this->input->post('rowid' , TRUE);
		
		// 數量
		$qty = (int) $this->input->post('qty' , TRUE);
		log_message('error','qty='.$qty);
		// 產品ID
		$pid = $this->input->post('pid' , TRUE);
		
		// 原本選擇的類別
		$ptid = $this->input->post('ptid' , TRUE);
		
		// 新選擇的類別
		$newptid = $this->input->post('newptid' , TRUE);
		
		if ($qty == 0)
		{
			log_message('error' , 'cart error 5001. 商品購買量型別錯誤.');
			
			echo json_encode(array('status' => 'F' , 'msg' => '商品數量不能為0或者是文字，請注意是否使用全形數字或夾帶數字以外的字，錯誤代碼5001'));
			exit();
		}
		
		// 檢查新類別的庫存量是否足夠
		$inventory = $this->product_type_model->get_inventory($newptid);
		
		if ($qty > $inventory)
		{
			log_message('error' , 'cart error 5002. 庫存量不足.');
			
			echo json_encode(array('status' => 'F' , 'msg' => '商品庫存量不足，錯誤代碼5002'));
			exit();
		}
		
		
		// 刪除掉舊的ROW在新增
		$data = array(
			'rowid' => $rowid,
			'qty' => 0,
		);
		
		$this->cart->update($data);
		
		return $this->add_cart($pid , $newptid , $qty);
		
		exit();
		
		
		//必須進行庫存量的比對
		
		$options = $this->cart->product_options($rowid);
		
		$pid = $options['id'];
		$ptid = $options['ptid'];
		
		$this->load->model('product_type_model');
		
		
		$inventory = $this->product_type_model->get_inventory($ptid);
		
		if ($qty > $inventory)
		{
			log_message('error' , 'cart error 5002. 庫存量不足.');
			
			echo json_encode(array('status' => 'F' , 'msg' => '商品庫存量不足，錯誤代碼5002'));
			exit();
		}
		
		$data = array(
			'rowid' => $rowid ,
			'qty' => $qty ,
		);
		
		if ($this->cart->update($data))
		{
			echo json_encode(array('status' => 'T' , 'msg' => '修改成功'));
			exit();
		}
		
		log_message('error' , 'cart error 5103.');
		
		echo json_encode(array('status' => 'F' , 'msg' =>'修改商品數量失敗，錯誤代碼5103'));
		exit();
	}

	/**
	 * 更新購物車(數量)
	 *
	 */
	public function update_cart_ini()
	{
		log_message('error','update_cart_ini');
		if (!$this->input->is_ajax_request()) exit();
		
		$this->member_model->is_login_ajax();
		
		$this->load->library('cart');
		$this->load->model('product_type_model');
		
		// 購物車識別ID
		$rowid = $this->input->post('rowid' , TRUE);
		
		// 數量
		$qty = (int) $this->input->post('qty' , TRUE);
		
		// 產品ID
		$pid = $this->input->post('pid' , TRUE);
		
		// 原本選擇的類別
		$ptid = $this->input->post('ptid' , TRUE);
		
		
		if ($qty == 0)
		{
			log_message('error' , 'cart error 5001. 商品購買量型別錯誤.');
			
			echo json_encode(array('status' => 'F' , 'msg' => '商品數量不能為0或者是文字，請注意是否使用全形數字或夾帶數字以外的字，錯誤代碼5001'));
			exit();
		}

		// 刪除掉舊的ROW在新增
		$data = array(
			'rowid' => $rowid,
			'qty' => 0,
		);
		
		$this->cart->update($data);
		
		return $this->add_cart($pid , $newptid , $qty);
		
		exit();
		
		
		//必須進行庫存量的比對
		
		$options = $this->cart->product_options($rowid);
		
		$pid = $options['id'];
		$ptid = $options['ptid'];
		
		$this->load->model('product_type_model');
		
		$inventory = $this->product_type_model->get_inventory($ptid);
		
		if ($qty > $inventory)
		{
			log_message('error' , 'cart error 5002. 庫存量不足.');
			
			echo json_encode(array('status' => 'F' , 'msg' => '商品庫存量不足，錯誤代碼5002'));
			exit();
		}
		
		$data = array(
			'rowid' => $rowid ,
			'qty' => $qty ,
		);
		
		if ($this->cart->update($data))
		{
			echo json_encode(array('status' => 'T' , 'msg' => '修改成功'));
			exit();
		}
		
		log_message('error' , 'cart error 5103.');
		
		echo json_encode(array('status' => 'F' , 'msg' =>'修改商品數量失敗，錯誤代碼5103'));
		exit();
	}
	
	/**
	 * 更新購物車(類別)
	 *
	 */
	public function update_cart_type()
	{

		if (!$this->input->is_ajax_request()) exit();
		
		$this->member_model->is_login_ajax();
		
		$this->load->library('cart');
		$this->load->model('product_type_model');
		
		// 購物車識別ID
		$rowid = $this->input->post('rowid' , TRUE);
		
		// 數量
		$qty = (int) $this->input->post('qty' , TRUE);
		
		// 產品ID
		$pid = $this->input->post('pid' , TRUE);
		
		// 原本選擇的類別
		$ptid = $this->input->post('ptid' , TRUE);
		
		// 新選擇的類別
		$newptid = $this->input->post('newptid' , TRUE);
		
		if ($qty == 0)
		{
			log_message('error' , 'cart error 5001. 商品購買量型別錯誤.');
			
			echo json_encode(array('status' => 'F' , 'msg' => '商品數量不能為0或者是文字，請注意是否使用全形數字或夾帶數字以外的字，錯誤代碼5001'));
			exit();
		}
		
		// 檢查新類別的庫存量是否足夠
		$inventory = $this->product_type_model->get_inventory($newptid);
		
		if ($qty > $inventory)
		{
			log_message('error' , 'cart error 5002. 庫存量不足.');
			
			echo json_encode(array('status' => 'F' , 'msg' => '商品庫存量不足，錯誤代碼5002'));
			exit();
		}
		
		
		// 刪除掉舊的ROW在新增
		$data = array(
			'rowid' => $rowid,
			'qty' => 0,
		);
		
		$this->cart->update($data);
		
		return $this->add_cart($pid , $newptid , $qty);
		
		exit();
		
		
		//必須進行庫存量的比對
		
		$options = $this->cart->product_options($rowid);
		
		$pid = $options['id'];
		$ptid = $options['ptid'];
		

		$this->load->model('product_type_model');
		
		
		$inventory = $this->product_type_model->get_inventory($ptid);

		
		if ($qty > $inventory)
		{
			log_message('error' , 'cart error 5002. 庫存量不足.');
			
			echo json_encode(array('status' => 'F' , 'msg' => '商品庫存量不足，錯誤代碼5002'));
			exit();
		}
		
		$data = array(
			'rowid' => $rowid ,
			'qty' => $qty ,
		);
		
		if ($this->cart->update($data))
		{
			echo json_encode(array('status' => 'T' , 'msg' => '修改成功'));
			exit();
		}
		
		log_message('error' , 'cart error 5103.');
		
		echo json_encode(array('status' => 'F' , 'msg' =>'修改商品數量失敗，錯誤代碼5103'));
		exit();
		
	}	
	/**
	 * 歐付寶交易回傳
	 *
	 */
	public function allpay_response()
	{
		$this->load->model('payment_model');
		
		$this->load->model('order_model');
		
		$this->load->model('inventory_model');
		
		$post = $this->payment_model->get_feedback_data();
		
		if (FALSE == isset($post['MerchantID']))
		{
			$this->payment_model->log_message('error' , '0|無法取得廠商代號___' . json_encode($post));
			echo '0|無法取得廠商代號';
			exit();
		}
		
		if (FALSE == $this->payment_model->is_merchant($post['MerchantID']))
		{
			$this->payment_model->log_message('error' , '0|非此網站使用的廠商ID___' . json_encode($post));
			echo '0|非此網站使用的廠商ID';
			exit();
		}
		
		$response = $this->payment_model->insert_allpay_response($post);
		
		if (!$response)
		{
			$this->payment_model->log_message('error' , '接收ALLPAY回傳寫入資料庫失敗');
			$this->payment_model->log_message('error' , json_encode($_POST));
		}
		
		//取得訂單
		$order = $this->order_model->get_order_one_by_payment_id($post['MerchantTradeNo']);			
		
		
		//交易成功
		if ('1' == $post['RtnCode'])
		{	
			
			//修改訂單狀態
			$this->order_model->change_order_active($post['MerchantTradeNo'] , '2');
			
			//修改付款狀態
			if ('1' != $post['SimulatePaid'])
			{
				//正式
				$this->payment_model->change_payment_active($post['MerchantTradeNo'] , '5');
			}
			else
			{
				//歐付寶測試
				$this->payment_model->change_payment_active($post['MerchantTradeNo'] , '4');
			}
			
			echo '1|OK';
			exit();
		}//回傳交易失敗處理
		else if ('1' != $post['RtnCode'])
		{
			
			//修改訂單狀態
			$this->order_model->change_order_active($post['MerchantTradeNo'] , '-2');
			
			//修改付款狀態
			$this->payment_model->change_payment_active($post['MerchantTradeNo'] , '-4');
			
			//交易失敗取消扣除的存貨量
			$order_contents = json_decode($order->order_contents , TRUE);
			while(list($key , $row) = each($order_contents))
			{
				$pid = $row['options']['id'];
				// $color = $row['options']['color'];
				// $degree = $row['options']['degree'];
				$degree = false;
				$num = $row['qty'];
				//扣除商品庫存
				$this->inventory_model->sale_inventory_back($pid , $num);
			}
			
			$this->payment_model->log_message('error' , '1|已接收交易失敗訊息___' . json_encode($post));
			echo '1|OK';
			exit();
		}
		
		print '0|未知的錯誤';
		
		exit();
	}
	
	/**
	 * 歐付寶錯誤回傳網址
	 *
	 */
	public function allpay_error()
	{
		$this->load->model('payment_model');
		
		$this->payment_model->log_message('error' , json_encode($_POST));
		
		print '1|OK';
		
		exit();
	}
	
	/**
	 * 歐付寶取消訂單網址
	 *
	 */
	public function allpay_cancel_order()
	{
		$this->load->model('payment_model');
		
		$this->payment_model->log_message('error' , json_encode($_POST));
		
		print '1|OK';
		
		exit();
	}
	
	/**
	 * 取號結果
	 * 當歐付寶ATM取號成功時會呼叫此API，回傳取號結果通知，若為TRUE，則WEFOX的payment將開啟
	 */
	public function allpay_info_response()
	{
		$this->load->model('payment_model');
		
		$this->load->model('order_model');
		
		$this->load->model('inventory_model');
		
		$post = $this->payment_model->get_feedback_data();
		
		// $post = $this->input->post(NULL , TRUE);
		
		if (FALSE == isset($post['MerchantID']))
		{
			$this->payment_model->log_message('error' , '0|無法取得廠商代號___' . json_encode($post));
			echo '0|無法取得廠商代號';
			exit();
		}
		
		if (FALSE == $this->payment_model->is_merchant($post['MerchantID']))
		{
			$this->payment_model->log_message('error' , '0|非此網站使用的廠商ID___' . json_encode($post));
			echo '0|非此網站使用的廠商ID';
			exit();
		}
		
		if ('2' != $post['RtnCode'])
		{
			
			//返回的交易失敗處理
			//訂單&&購買紀錄要消去，並且還原庫存量
			
			
			
			$this->payment_model->log_message('error' , '1|已接收交易失敗訊息___' . json_encode($post));
			echo '1|已接收交易失敗訊息';
			exit();
		}
		
		//取號成功處理
		//要將訂單&&購買紀錄活化
		$payment_response = $this->payment_model->allpay_info_response($post);
		
		$order_response = $this->order_model->allpay_info_response($post);
		
		if ($payment_response && $order_response)
		{
			//扣除庫存
			$order = $this->order_model->get_order_one_by_payment_id($post['MerchantTradeNo']);
			
			$order_contents = json_decode($order->order_contents , TRUE);
			
			while(list($key , $row) = each($order_contents))
			{
				$pid = $row['options']['id'];
				// $color = $row['options']['color'];
				// $degree = $row['options']['degree'];
				$degree = false;
				$num = $row['qty'];
				//扣除商品庫存
				$this->inventory_model->sale_inventory($pid , $num);
				
				$this->payment_model->log_message('error' , '扣除商品紀錄' . sprintf('%s_%s' , $pid , $num));
			}
			
			unset($order_contents);
			
			//發送信件
			//載入信件模組
			$this->load->model('mail_model');
			
			//準備信件內容資料
			$this->front->order = $order;
			
			//信件標題
			$subject = sprintf("%s-%s通知" , config_item('site') , '購買紀錄');
			
			//是否寄送訂單副本(正本)給收貨人
			if (isset($order->copyies_torec) && $order->copyies_torec == 1)
			{
				$mailto = sprintf("%s<%s> , %s<%s>" , $order->pay_name , $order->pay_email , $order->rec_name , $order->rec_email);
			}
			else
			{
				$mailto = sprintf("%s<%s>" , $order->pay_name , $order->pay_email);
			}
			
			$template = $this->load->view('/member/mail_order' , $this->front , TRUE);
			
			$send = @$this->mail_model->send($mailto , $subject , $template);
			
			if ($send == FALSE)
			{
				$this->payment_model->log_message('error' , '1|訂單產生成功！但系統信件寄送失敗，錯誤代碼：6103___' . json_encode($post));
				echo '1|訂單產生成功！但系統信件寄送失敗';
				exit();
			}
			
		}
		else
		{
			//資料寫入錯誤
			$this->payment_model->log_message('error' , '0|變更訂單與付款紀錄狀態失敗___' . json_encode($post));
			echo '0|變更訂單與付款紀錄狀態失敗' . json_encode($post);
			exit();
		}
		
		$this->payment_model->log_message('error' , '1|已記錄取號成功訊息___' . json_encode($post));
		echo '1|已記錄取號成功訊息';
		exit();
		
		
	}
	
	
	/** 
	 * 物流狀態變更回傳
	 *
	 */
	public function order_send_response()
	{
		$this->load->model('payment_model');
		
		$this->load->model('order_model');
		
		require_once(APPPATH . '/libraries/AllPay.Logistics.Integration.php');
		
		try {
			$AL = new AllpayLogistics();
			
			$response = $this->input->post(NULL , TRUE);
			
			$AL->CheckOutFeedback($response);
			
			//成功處理
			$sql = "UPDATE `payment` SET send_id = ? , send_status = ? , send_status_msg = ? , api_response_date = ? , booking_note = ? WHERE payment_id = ? ";
			$query1 = $this->db->query($sql , array($response['AllPayLogisticsID'] , $response['RtnCode'] , $response['RtnMsg'] , $response['UpdateStatusDate'] , $response['BookingNote'] , $response['MerchantTradeNo']));
			
			// $sql = "UPDATE `order` SET active = '3' WHERE payment_id = ?";
			// $query2 = $this->db->query($sql , array($response['MerchantTradeNo']));
			
			
		}
		catch(Exception $e)
		{
			//例外處理錯誤
			$this->payment_model->log_message('error' , '接收歐付寶物流時發生例外錯誤，錯誤代碼：9999，/api/order_send_response');
			$this->payment_model->log_message('error' , json_encode($e->getMessage()));
			
			echo '0|' . $e->getMessage();
			exit();			
		}
	}
	
	
	public function product_rule_get()
	{
		$this->load->model('product_model');
		$this->load->model('upload_model');
		
		$param = $this->input->post(NULL , TRUE);
		
		$type = $param['type'];
		$rule_sub = isset($param['rule_sub'])?$param['rule_sub']:FALSE;
		$today = date('Y-m-d');
		
		$this->db->order_by('create_at' , 'desc');
		$this->db->where('active >' , 0);
		$this->db->where('brand_id' , $type);
		$this->db->where('start_date <=' , $today);
		$where = "(end_date >='{$today}' OR end_date = '0000-00-00')";
		$this->db->where($where);
		// $this->db->where('end_date >=' , date('Y-m-d'));
		// $this->db->or_where('end_date' , '0000-00-00');
		$query = $this->db->get('product');
		
		$product_list = $query->result();
		$response_list = array();
		
		if ($rule_sub != FALSE)
		{
			foreach($product_list as $key => $row)
			{
				if ($row->rule_sub == FALSE) continue;
				
				$sub = explode(',' , $row->rule_sub);
				
				// $rule_su = TRUE;
				
				// foreach($rule_sub as $kk => $vv)
				// {
					// if (!in_array($vv , $sub))
					// {
						// $rule_su = FALSE;
					// }
				// }
				
				$rule_su = FALSE;
				
				foreach($rule_sub as $kk => $vv)
				{
					if (in_array($vv , $sub))
					{
						$rule_su = TRUE;
					}
				}
				
				if ($rule_su)
				{
					$response_list[$row->id] = $row;
				}
			}
		}
		else
		{
			$response_list = $product_list;
		}
		
		unset($product_list);
		
		$response = array('status' => 'T' , 'html' => '');
		
		$i = 0;
		
		foreach($response_list as $key => $row)
		{
			$row->img_file = $this->upload_model->get_cache($row->img);
			
			$tmp = $row->img_list;
			$tmp = explode(',' , $tmp);
			foreach($tmp as $kk => $vv)
			{
				$row->img_file_list[] = $this->upload_model->get_cache($vv);
			}
			
			++$i;
			if ($i>3)$i=1;
			if ($i == 1)
			{
				$response['html'] .= '<div class="row">';
			}
			
			
			$response['html'] .= '<div class="col-sm-6 col-md-4">';
			$response['html'] .= '<div class="thumbnail">';
	
			$response['html'] .= '<div class="paddingT20 text-center"><a href="'.site_url().'"><img src="';
			// . img_show($row->img_file->file_name) . '" alt="' . $row->img_file->alt . '" width="100%" data-src="holder.js/300x300"></div>';
			$response['html'] .= isset($row->img_file)?img_show($row->img_file->file_name):'/images/no-image.jpg';
			$response['html'] .= '" alt="';
			$response['html'] .= isset($row->img_file)?$row->img_file->alt:'';
			$response['html'] .= '" width="100%" data-src="holder.js/300x300"></a></div>';
			
			
			$response['html'] .= '<div class="caption">';
			$response['html'] .= '<h2 class=" textRed text-center">';
			// $response['html'] .= $row->discount_active==1 && strtotime($row->discount_end_date) >= time()?to_money($row->discount_price):to_money($row->price);
			if ($row->price_max == 0 && $row->price_min == 0)
			{
				$response['html'] .= '該產品目前尚未販售';
			}
			else
			{
				$response['html'] .= $row->price_max == $row->price_min?to_money($row->price_max):to_money($row->price_min) . '-' . to_money($row->price_max);
			}
			
			$response['html'] .= '</h2>';
			// $response['html'] .= '<h4 class=" fontcolorBlack text-center textlineheight30">' . $row->brand . ' ' . $row->title . '<br />' . $row->origin . '<br />' . $row->type . '/' . $row->pick . '</h4>';
			$response['html'] .= '<h4 class=" fontcolorBlack text-center textlineheight30"><span class="fontBold">'. $row->product_id .'</sapn><br />' . $row->title . '</h4>';
			$response['html'] .= '<p class="paddingT20 Lilaclink text-center">';
			$response['html'] .= '<a href="' . site_url() . '" class="btn btn-default paddingRL20" role="button">返回首頁</a>';
			$response['html'] .= '<a href="#" class="btn btn-default pull-right favourite_btn" data-login="';
			$response['html'] .= $this->front->member_login != FALSE?$this->front->member_login:'';
			$response['html'] .= '" data-pid="' . '" role="button"> <span class="glyphicon glyphicon-heart"></span></a>';
			$response['html'] .= '</p></div></div></div>';
			
			if ($i == 3)
			{
				$response['html'] .= '</div>';
			}
		}
		
		if ($i != 3)
		{
			$response['html'] .= '</div>';
		}
		
		// 若無資料
		if ($response['html'] == FALSE)
		{
			$response['html'] = '很抱歉！找不到資料或資料建構中！<br /><br />若您有疑問可以至聯絡我們';
		}
		
		echo json_encode($response);
		exit();
	}
	
	
	// 取得對應產品顏色下的度數
	public function get_color_degree()
	{
		$pid = $this->input->post('pid' , TRUE);
		// $color = $this->input->post('color' , TRUE);
		
		$this->db->where('pid' , $pid);
		// $this->db->where('color' , $color);
		$query = $this->db->get('inventory');
		
		$result = $query->result();
		
		$html = '<select name="degree" id="degree" class="form-control">';
		$html.='<option value="">請選擇度數</option>';
		if (count($result) > 0)
		{
			foreach($result as $key => $row)
			{
				if ($row->num > 0)
				{
					$html.='<option value="'.$row->degree.'">'.$row->degree.'</option>';
				}
				else
				{
					$html.='<option value="'.$row->degree.'">'.$row->degree.'  (庫存量不足)</option>';
				}
				
			}
		}
		
		$html.= '</select>';
		
		echo json_encode(array('status' => 'T' , 'html' => $html));
		exit();
	}

	public function get_district()
	{
		$cid = $this->input->post('cid' , TRUE);
		
		$this->db->where('cid' , $cid);
		$query = $this->db->get('district');
		$result = $query->result();
		$html = '<option value="">選擇區域</option>';
		
		foreach($result as $key => $row)
		{
			$html .= '<option value="' . $row->id . '">' . $row->title . '</option>';
		}
		
		echo json_encode(array('status' => 'T' , 'html' => $html));
		exit();
	}
	
	
	public function get_inventory()
	{
		$this->load->model('product_type_model');
		
		$ptid = $this->input->post('ptid' , TRUE);
		
		$ptdata = $this->product_type_model->get_one($ptid);
		
		if ($ptdata != FALSE)
		{
			if ($ptdata->inventory > 0)
			{
				echo json_encode(array('status' => 'T' , 'inventory' => $ptdata->inventory , 'price' => to_money($ptdata->price)));
				exit();
			}
			
		}
		
		$this->load->model('product_model');
		
		echo json_encode(array('status' => 'F' , 'inventory' => 0));
		exit();
	}
	
	// 取得鄉鎮前台
	public function get_district_p()
	{
		$this->load->model('store_model');
		
		$id = $this->input->post('id' , TRUE);
		$html = '';
		
		$html .= '<option value="0">請選擇</option>';
		
		$result = $this->store_model->get_distinct_district($id);
	
		if (isset($result) && is_array($result) && count($result) > 0)
		{
			foreach($result as $key => $row)
			{
				$html .= '<option value='.$row->id.'>' . $row->title . '</option>';
			}
			
			echo json_encode(array('status' => 'T' , 'html' => $html));
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'html' => ''));
		exit();
	}
	
	
	public function get_store()
	{
		$this->load->model('store_model');
		
		$id = $this->input->post('id' , TRUE);
		$html = '';
		
		$result = $this->store_model->get_list_by_did($id);
	
		if (isset($result) && is_array($result) && count($result) > 0)
		{
			foreach($result as $key => $row)
			{
				$html .= '<tr><td>';
				$html .= '<input type="radio" name="store" id="" class="store'.$row->id.' storefill" value="'.$row->id.'"></input>' . $row->title;
				$html .= '</td><td>';
				$html .= '<span>地址：'.$row->address.'</span>';
				$html .= '<span style="margin-left:50px;">電話：'.$row->phone.'</span>';
				$html .= '<span style="float:right;position:relative;"><a href="#" data-toggle="modal" data-target=".store_'.$row->id.'"><img src="/images/map.jpg" style="margin:0;padding:0;width:20px;height:20px;" /></a></span>';
				$html .= '';
				$html .= '</td></tr>';


			}
			
			echo json_encode(array('status' => 'T' , 'html' => $html));
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'html' => ''));
		exit();
	}
	public function get_map()
	{
		$this->load->model('store_model');
		
		$id = $this->input->post('id' , TRUE);
		$html = '';
		
		$result = $this->store_model->get_list_by_did($id);
	
		if (isset($result) && is_array($result) && count($result) > 0)
		{
			foreach($result as $key => $row)
			{
				$html .= '<tr id="mapshow'.$row->id.'" class="'.$row->id.'">
				<td colspan="2"><div tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"><div class="modal-dialog">'.$row->map_data.'</div></div></td>  <td></td> </tr>';
				
				/*
				$html .= '<script>
					$(document).ready(function(){
						$("#mapshow'.$row->id.'").attr("style","display:none;");
					});

					$(".storefill").click(function(){
						$("#mapshow'.$row->id.'").attr("style","display:none;");			
					});

					$(".store'.$row->id.'").click(function(){
						$(".'.$row->id.'").attr("style","display:block;");			
					});
					</script>';
					*/
			}
			
			echo json_encode(array('status' => 'T' , 'html' => $html));
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'html' => ''));
		exit();
	}	

	public function get_map_one()
	{
		$this->load->model('store_model');
		
		$id = $this->input->post('id' , TRUE);
		$html = '';
		
		$result = $this->store_model->get_one($id);

		if (isset($result)  && count($result) > 0)
		{

				$html .= '<tr id="mapshow'.$result->id.'" class="'.$result->id.'">
				<td colspan="2"><div tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"><div class="modal-dialog">'.$result->map_data.'</div></div></td>  <td></td> </tr>';
			
			echo json_encode(array('status' => 'T' , 'html' => $html));
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'html' => ''));
		exit();
	}		
	
	public function get_jq(){
		$this->load->model('store_model');
		
		$id = $this->input->post('id' , TRUE);
		$html = '';
		
		$result = $this->store_model->get_list_by_did($id);
	
		if (isset($result) && is_array($result) && count($result) > 0)
		{
			foreach($result as $key => $row)
			{

			}
			
			echo json_encode(array('status' => 'T' , 'html' => $html));
			exit();
		}
		
		echo json_encode(array('status' => 'F' , 'html' => ''));
		exit();		
	}
	
	public function get_product_type_list()
	{
		$this->member_model->is_login_ajax();
		
		$pid = $this->input->post('pid' , TRUE);
		$ptid = $this->input->post('ptid' , TRUE);
		$html='';
		
		// $this->load->model('product_model');
		$this->load->model('product_type_model');
		
		$product_type_list = $this->product_type_model->get_list_by_pid($pid);
		
		$html.='<select class="form-control" id="edit-ptitle">';
		
		foreach($product_type_list as $key => $row)
		{
			if ($row->id == $ptid)
			{
				$html.='<option value="' . $row->id . '" selected>' . $row->color . $row->cap . $row->length . '/' . to_money($row->price) . '</option>';
			}
			else
			{
				$html.='<option value="' . $row->id . '">' . $row->color . $row->cap . $row->length . '/' . to_money($row->price) . '</option>';
			}
		}
		
		$html.='</select>';

		echo json_encode(array('status' => 'T' , 'html'=>$html));
		exit();
	}
}
//end of file Api.php