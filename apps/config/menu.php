<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['menu_cache_file'] = array(
	'header' => '/menu/header.json',
	'footer' => '/menu/footer.json',
	'quick' => '/menu/quick.json'
);

$config['menu_cache_default'] = array(
	'header' => array(array(
		'text' => '主要導覽',
		'icon' => 'fa fa-folder-o c-primary',
		'state' => array('selected' => true, 'opened' => true),
		'children' => array(
			array('text' => '認識北灣町', 'icon' => 'fa fa-folder-o c-primary', 'state' => array('selected' => false), 'data' => array('url' => '/#about')),
			array('text' => '空間與房型', 'icon' => 'fa fa-folder-o c-primary', 'state' => array('selected' => false), 'data' => array('url' => '/#rooms')),
			array('text' => '預約包棟', 'icon' => 'fa fa-folder-o c-primary', 'state' => array('selected' => false), 'data' => array('url' => '/#contact'))
		)
	)),
	'footer' => array(array(
		'text' => '頁尾連結',
		'icon' => 'fa fa-folder-o c-primary',
		'state' => array('selected' => true, 'opened' => true),
		'children' => array(
			array('text' => '回到首頁', 'icon' => 'fa fa-folder-o c-primary', 'state' => array('selected' => false), 'data' => array('url' => '/#home')),
			array('text' => '聯絡訂房', 'icon' => 'fa fa-folder-o c-primary', 'state' => array('selected' => false), 'data' => array('url' => '/#contact')),
			array('text' => 'Google 地圖', 'icon' => 'fa fa-folder-o c-primary', 'state' => array('selected' => false), 'data' => array('url' => 'https://maps.app.goo.gl/W2YWeiEAUfDPExPG9?g_st=il'))
		)
	)),
	'quick' => array(array(
		'text' => '快速連結',
		'icon' => 'fa fa-folder-o c-primary',
		'state' => array('selected' => true, 'opened' => true),
		'children' => array(
			array('text' => '認識北灣町', 'icon' => 'fa fa-folder-o c-primary', 'state' => array('selected' => false), 'data' => array('url' => '/#about')),
			array('text' => '空間與房型', 'icon' => 'fa fa-folder-o c-primary', 'state' => array('selected' => false), 'data' => array('url' => '/#rooms')),
			array('text' => '預約包棟', 'icon' => 'fa fa-folder-o c-primary', 'state' => array('selected' => false), 'data' => array('url' => '/#contact'))
		)
	))
);
