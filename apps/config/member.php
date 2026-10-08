<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @copyright : 振華科技
 * @author : Tone
 */

/**
 * Password hash
 *
 */
$config['member_password_hash'] = '2d806b48c1d384b244dc08ddb7183803';

/**
 * Session hash
 *
 */
$config['member_session_hash'] = '560bd8d8123bc315a0cb61e626fe0fd3';

/**
 * Session time out
 *
 */
$config['member_login_time_out'] = 3600;

/**
 * Admin database name
 *
 */
$config['member_database'] = 'member';

/**
 * Login Uri
 *
 */
$config['member_login_uri'] = '/';

/**
 * Control Uri
 *
 */
$config['member_home_uri'] = '/';

/**
 * member field
 *
 */
$config['member_defaults'] = array(
		'id' => null , 
		'login' => '',
		'passwd' => '',
		'member_no' => '',
		'name' => '',
		'active' => 0,
		'phone' => '',
		'mobile' => '',
		'post_no' => '',
		'address' => '',
		'city' => '',
		'country' => '',
		'optometry_place' => '',
		'optometry_info' => '',
		'prescription' => 0,
		'verify_code' => '',
		'last_login' => '',
		'degree_left' => 0,
		'degree_right' => 0,
		'isfb' => 0,
		'fb_mail' => 0,
);

/**
 * member field have to import
 *
 */
$config['member_haveto'] = array(
	301 => 'login' ,
	302 => 'passwd' , 
	303 => 'phone' , 
	304 => 'mobile' ,
	305 => 'address' , 
	// 306 => 'city' , 
	// 307 => 'country' , 
	// 308 => 'optometry_place' , 
	// 309 => 'optometry_info' ,
	// 310 => 'prescription' ,
	// 311 => 'post_no' ,
);

/**
 * error code 
 *
 */
$config['error_code'] = array(
	0 => '很抱歉系統遇到未知的錯誤，我們會盡速解決此問題，造成您的不便多請見諒。',
	1 => '新增成功',
	2 => '修改成功',
	3 => '刪除成功',
	4 => '請求成功',
	300 => '該帳號已經被使用',
	301 => '請輸入帳號' ,
	302 => '請輸入密碼' , 
	303 => '請輸入電話號碼' , 
	304 => '請輸入手機號碼' , 
	305 => '請輸入住址' , 
	306 => '請輸入居住城市' , 
	307 => '請輸入居住國家' , 
	// 308 => '請輸入驗光地點' , 
	// 309 => '請輸入驗光店家資訊' ,
	// 310 => '請上傳醫生處方籤' ,
	401 => '缺少必要參數',
	500 => '寫入資料失敗',
	601 => '帳號信箱格式錯誤，麻煩您檢查信箱是否輸入錯誤。',
	602 => '密碼格式錯誤，請至少輸入八位數的混和密碼，並包含至少一個大寫字母、小寫字母、數字。',
	
);


//end of file member.php