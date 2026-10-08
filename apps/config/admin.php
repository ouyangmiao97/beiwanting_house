<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @copyright : 振華科技
 * @author : Tone
 */

/**
 * Check request ip address
 *
 */
$config['is_lock_ip'] = FALSE;

/**
 * Request IP whitelist
 *
 */
$config['white_ip_map'] = array('127.0.0.1');

/**
 * Password hash
 *
 */
$config['password_hash'] = '2d806b48c1d384b244dc08ddb7183803';

/**
 * Session hash
 *
 */
$config['session_hash'] = '560bd8d8123bc315a0cb61e626fe0fd3';

/**
 * Admin database name
 *
 */
$config['admin_database'] = 'admin';

/**
 * Admin login log database name
 *
 */
$config['admin_loginlog_database'] = 'admin_loginlog';

/**
 * Admin login oper database name
 *
 */
$config['admin_operlog_database'] = 'admin_operlog';

/**
 * Login Uri
 *
 */
$config['login_path'] = '/control/login';

/**
 * Control Uri
 *
 */
$config['control_home'] = '/control/home';

/**
 * Query login log max rows
 *
 */
$config['max_loginlog_rows'] = 200;

/**
 * Query oper log max rows
 *
 */
$config['max_operlog_rows'] = 500;

/**
 * Admin Template Menu List
 * 
 */
$config['admin_menu'] = array(
		array('title' => '系統' , 'smallitem' => array(
			array('title' => '管理首頁','url' => '/control/home' , 'iclass' => 'icon-home'),
			
			array('title' => '帳號管理' , 'url' => '#' , 'iclass' => 'icon-user' , 'miniitem' => array(
				array('title' => '帳號管理','url' => '/control/admin' , 'iclass' => 'icon-user'),
				array('title' => '登入紀錄' , 'url' => '/control/admin/loginlog' , 'iclass' => 'icon-user'),
				array('title' => '操作紀錄' , 'url' => '/control/admin/operlog' , 'iclass' => 'icon-user'),
			)),
			array('title' => '登出' , 'url' => '/control/login/out' , 'iclass' => 'icon-logout'),
		)),
		array('title' => '管理' , 'smallitem' => array(
			array('title' => '選單' , 'url' => '#' , 'iclass' => 'icon-grid' , 'miniitem' => array(
				array('title' => '首頁' , 'url' => '/control/menu_header' , 'iclass' => 'fa fa-pencil-square-o'),
				array('title' => '頁尾' , 'url' => '/control/menu_footer' , 'iclass' => 'fa fa-pencil-square-o'),
				array('title' => '快速連結' , 'url' => '/control/menu_quick' , 'iclass' => 'fa fa-pencil-square-o'),
			)),
			array('title' => '圖片' , 'url' => '#' , 'iclass' => 'icon-picture' , 'miniitem' => array(
				array('title' => 'Banner管理' , 'url' => '/control/banner' , 'iclass' => 'fa fa-pencil-square-o'),
				array('title' => '首頁商品品牌區' , 'url' => '/control/brand' , 'iclass' => 'fa fa-pencil-square-o'),
			)),
			array('title' => '內容' , 'url' => '#' , 'iclass' => 'icon-notebook' , 'miniitem' => array(
				// array('title' => '文章管理' , 'url' => '/control/words/index' , 'iclass' => 'fa fa-pencil-square-o'),
				array('title' => 'EVENT管理' , 'url' => '/control/event/index' , 'iclass' => 'fa fa-pencil-square-o'),
				array('title' => 'STUDIO管理' , 'url' => '/control/studio/index' , 'iclass' => 'fa fa-pencil-square-o'),
				array('title' => '首頁影片設定' , 'url' => '/control/home_banner/index' , 'iclass' => 'fa fa-pencil-square-o'),
			)),
			array('title' => '頁面' , 'url' => '#' , 'iclass' => 'icon-doc' , 'miniitem' => array(
				array('title' => '一般頁面' , 'url' => '/control/page' , 'iclass' => 'fa fa-pencil-square-o'),
				array('title' => 'Meta管理' , 'url' => '/control/home/meta' , 'iclass' => 'fa fa-pencil-square-o'),
				array('title' => '跑馬燈管理' , 'url' => '/control/marquee/index' , 'iclass' => 'fa fa-pencil-square-o'),				
			)),
			array('title' => '聯絡我們' , 'url' => '#' , 'iclass' => 'icon-question' , 'miniitem' => array(
				array('title' => '聯絡我們','url' => '/control/contact/index' , 'iclass' => 'icon-user'),
				// array('title' => '產品問答' , 'url' => '/control/contact/product' , 'iclass' => 'icon-user'),
				// array('title' => '訂單問答' , 'url' => '/control/contact/order' , 'iclass' => 'icon-user'),
			)),
			/*
			array('title' => '商品' , 'url' => '#' , 'iclass' => 'icon-user' , 'miniitem' => array(
				array('title' => '項目管理' , 'url' => '/control/item/index' , 'iclass' => 'fa fa-pencil-square-o'),
				array('title' => '商品上架' , 'url' => '/control/product/add_product' , 'iclass' => 'fa fa-pencil-square-o'),
				array('title' => '商品查詢/修改' , 'url' => '/control/product/index' , 'iclass' => 'fa fa-pencil-square-o'),
				array('title' => '篩選主項目' , 'url' => '/control/rule_main/index' , 'iclass' => 'fa fa-pencil-square-o'),
				array('title' => '篩選子項目' , 'url' => '/control/rule_sub/index' , 'iclass' => 'fa fa-pencil-square-o'),
				array('title' => '庫存總表' , 'url' => '/control/inventory/index' , 'iclass' => 'fa fa-pencil-square-o'),
			)),*/
			// array('title' => '購物' , 'url' => '#' , 'iclass' => 'icon-user' , 'miniitem' => array(
				// array('title' => '購物設定' , 'url' => '/control/order/shopping_cost_setting' , 'iclass' => 'icon-user'),
				// array('title' => '前端運送方式說明頁' , 'url' => '/control/order/sendfun_page' , 'iclass' => 'icon-user'),
				// array('title' => '待出貨清單','url' => '/control/order/sendlist' , 'iclass' => 'icon-user'),
				// array('title' => '到店取貨清單','url' => '/control/order/storelist' , 'iclass' => 'icon-user'),
				// array('title' => '到店已取貨清單','url' => '/control/order/storelist_old' , 'iclass' => 'icon-user'),
				// /*array('title' => '匯款待確認清單' , 'url' => '#' , 'iclass' => 'icon-user'),*/
				// array('title' => '訂單查詢/操作' , 'url' => '/control/order/order_search' , 'iclass' => 'icon-user'),
				// /*array('title' => '訂單取消/信用卡刷退' , 'url' => '#' , 'iclass' => 'icon-user'),*/
				// /*array('title' => '歐付寶後台' , 'url' => '#' , 'iclass' => 'icon-user'),*/
				// array('title' => '店鋪管理' , 'url' => '/control/store/index' , 'iclass' => 'icon-user'),
			// )),
			// array('title' => '會員' , 'url' => '#' , 'iclass' => 'icon-user' , 'miniitem' => array(
				// array('title' => '會員申辦' , 'url' => '/control/member/register' , 'iclass' => 'fa fa-pencil-square-o'),
				// array('title' => '會員查詢' , 'url' => '/control/member/index' , 'iclass' => 'fa fa-pencil-square-o'),
				// array('title' => '待審核會員' , 'url' => '/control/member/verify' , 'iclass' => 'fa fa-pencil-square-o'),
				// array('title' => '已審核會員' , 'url' => '/control/member/success' , 'iclass' => 'fa fa-pencil-square-o'),
				// array('title' => '已退審會員' , 'url' => '/control/member/verify_false' , 'iclass' => 'fa fa-pencil-square-o'),
			// )),
			
			['title' => '商品(NEW)' , 'url' => '#' , 'iclass' => 'icon-basket-loaded' , 'miniitem' => [
				['title' => '商品分類' , 'url' => '/control/product_type_a' , 'iclass' => ''] ,
				['title' => '商品品牌' , 'url' => '/control/product_brand' , 'iclass' => ''] ,
				['title' => '商品顏色' , 'url' => '/control/product_color' , 'iclass' => ''] ,
				// ['title' => '商品新增' , 'url' => '/control/product/add' , 'iclass' => ''] ,
				['title' => '商品管理' , 'url' => '/control/product/index' , 'iclass' => ''] ,
				['title' => '首頁商品' , 'url' => '/control/product/home_list' , 'iclass' => ''] ,
			]],
			
		)),
);


//end of file admin.php