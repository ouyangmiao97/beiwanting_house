<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 振華Payment Config
 *
 * @copyright:	Zh-tech 振華科技
 * @author:		Tone(tone2314@gmail.com)
 * @version:	1.0
 * @update:		2016/03/14
 */

/**
 * 振華Payment提供的付款金流串接方式
 *
 */
$config['zhtech_payment_list'] = array(
	1 => '歐付寶',
);

/**
 * 自動模擬交易完成
 * 當開啟此項目時，payment model 會自動模擬完成交易，請注意！此功能僅適合未上線時測式系統其他部分的功能是否完整，上線時請勿開啟此項目
 *
 */
define('ZHTECH_PAYMENT_DEBUG_AUTO_MODE' , FALSE);

/**
 * 自動記錄log，開啟時交易將自動記錄到對應的log檔中
 * 可以是ci_log , zhtech_log , FALSE
 */
define('ZHTECH_PAYMENT_DEBUG_LOG_MODE' , 'zhtech_log');

define('ZHTECH_PAYMENT_DEBUG_LOG_PATH' , 'logs/');

/**
 * AllPay 歐付寶參數設定
 *
 **/
define('ZHTECH_PAYMENT_ALLPAY_MERCHANT_ID' , '1238426');

define('ZHTECH_PAYMENT_ALLPAY_HASH_KEY' , 'ToTXi7XFNNxoyiuX');

define('ZHTECH_PAYMENT_ALLPAY_HASH_IV' , 'ipDLkARkmqnlOuEW');