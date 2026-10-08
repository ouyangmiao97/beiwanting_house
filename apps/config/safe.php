<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @copyright : 振華科技
 * @author : Tone
 */

/**
 * Safe login mode
 *
 */
$config['safe_login_mode'] = TRUE;

/**
 * Safe request database
 *
 */
$config['safe_request_database'] = 'safe_request';

/**
 * Safe bind ip database
 *
 */
$config['safe_bind_ip_database'] = 'safe_bind_ip';

/**
 * Safe bind login database
 *
 */
$config['safe_bind_login_database'] = 'safe_bind_login';

/**
 * Safe request delag time
 *
 */
$config['safe_time_sleep'] = 5;

/**
 * Safe request 1min max times
 *
 */
$config['safe_1min_times'] = 4;

/**
 * Safe request bind rule
 *
 */
$config['safe_1min_bind_times'] = 8;

//end of file safe.php