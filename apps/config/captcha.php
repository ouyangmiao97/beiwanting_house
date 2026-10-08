<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 驗證碼生成設定
 * 設定 captcha
 *
 */
// $config['captcha_setting'] = array(
	// 'word'	=> '',
	// 'img_path'	=> './captcha/',
	// 'cache_path' => APPPATH . 'cache/captcha/',
	// 'img_url'	=> '/captcha/',
	// 'font_path'	=> APPPATH . 'ttf/HoboStd.otf',		//產生時使用的字體檔
	// 'img_width'	=> '50',
	// 'img_height' => '20',
	// 'expiration' => '600',							//有效時間(單位：秒)
	// 'word_length' => 4 ,							//產生字數
	// 'font_size' => 12
// );
$config['captcha_setting'] = array(
	'word'	=> '',
	'img_path'	=> './captcha/',
	'cache_path' => APPPATH . 'cache/captcha/',
	'img_url'	=> '/captcha/',
	'font_path'	=> APPPATH . 'ttf/HarlequinExtraboldFLF.ttf',		// 產生時使用的字體檔
	'img_width'	=> '100',
	'img_height' => '32',
	'expiration' => '600',							// 有效時間(單位：秒)
	'word_length' => 4 ,							// 產生字數
	'font_size' => 16
);

