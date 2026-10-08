<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * facebook oauth 設定
 *
 *
 */

/**
 * 	此值為申請的FB應用程式編號
 */
$config['fb_client_id'] = '2799911100235109';

/**
 *	此值為應用程式密鑰
 */
$config['fb_client_private_key'] = 'f2d6a91741015391ee22cbc9f9e1527f';

/*
 *	針對需要提取的欄位
 *
 *	此處為登入的權限提取，若需要特殊權限則需要FB審核，此處的public_profile與email不需要權限審核
 *	[public_profile]包含：
 *	id
 *	first_name
 *	last_name
 *	middle_name
 *	name
 *	name_format
 *	picture
 *	short_name
 *	參考網址：https://developers.facebook.com/docs/facebook-login/permissions/
 *	[email]
 *	無須權限審核，但有可能此值得回應是空的
 *
 *	email 無須特殊權限
 */
// $config['fb_scope'] = 'public_profile,email';
// 取得權限
$config['fb_oauth_url_scope'] = 'public_profile,email';
// FB.api fields(實際存取欄位)
$config['fb_scope'] = 'email,name';

/**
 * Api Version
 *
 */
// $config['fb_api_version'] = 'v3.2';
// $config['fb_api_version'] = 'v11.0';
$config['fb_api_version'] = 'v14.0';

/**
 * OAuth重新導向目標
 *
 */
$config['fb_oauth_target'] = 'https://fishing-wefox.com/oauth/login_success.html';