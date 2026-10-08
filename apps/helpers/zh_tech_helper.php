<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author:		Tone
 * @copyright:	zh-tech
 * @update		2015-09-10
 */

if (!function_exists('get_cache'))
{
	/**
	* 取得快取資料
	*/	
	function get_cache($file = '')
	{
		$file = APPPATH . 'cache' . '/' . $file;
		$file_lock = $file . '.lock';
		$is_lock = TRUE;
		$times = 0;
		
		while($times < 1)
		{
			if (file_exists($file_lock))
			{
				sleep(1);
				$times++;
			}
			else
			{
				$is_lock = FALSE;
				$times = 100000;
			}
		}
		
		if ($is_lock == TRUE) return FALSE;
		
		if (is_file($file))
		{
			return file_get_contents($file);
		}
		
		return FALSE;
	}
}

if (!function_exists('set_cache'))
{
	/**
	* 寫入快取
	*/
	function set_cache($file = '' , $area = '')
	{
		$file = APPPATH . 'cache' . '/' . $file;
		$file_lock = $file . '.lock';
		$is_lock = TRUE;
		$times = 0;
		
		while($times < 1)
		{
			if (file_exists($file_lock))
			{
				sleep(1);
				$times++;
			}
			else
			{
				$is_lock = FALSE;
				$times = 100000;
			}
		}
		
		// timeout ! file is lock
		if ($is_lock == TRUE) return FALSE;
		
		// file_put_contents($file_lock , 'filelock');
		file_put_contents($file , $area);
		// unlink($file_lock);
		
		chmod($file , 0777);
	}
}

if (!function_exists('rm_cache'))
{
	/**
	* 移除快取
	*/	
	function rm_cache($file = '')
	{
		$file = APPPATH . 'cache' . '/' . $file;
		if (@unlink($file)) return TRUE;
		return FALSE;
	}
}

if (!function_exists('js_go_msg'))
{
	/**
	* Alert 指定頁
	*/
	function js_go_msg($url = '',$msg = '' ,$charset = 'utf-8'){

		$uri=(string)$url;
		$msg=(string)$msg;

		$string="<html><head>";
		$string.="<meta http-equiv=\"Content-Type\" content=\"text/html; charset=".$charset."\" />";
		$string.="<script language=\"javascript\">";
		$string.="alert('".$msg."');";
		$string.="window.location.href='".$url."';";
		$string.="</script>";
		$string.="</head><body></body></html>";

		return print $string;
	}
}

if (!function_exists('js_go_back'))
{
	/**
	* Alert 上一頁
	*/
	function js_go_back($msg = '' ,$charset = 'utf-8'){

		$msg=(string)$msg;

		$string="<html><head>";
		$string.="<meta http-equiv=\"Content-Type\" content=\"text/html; charset=".$charset."\" />";
		$string.="<script language=\"javascript\">";
		$string.="alert('".$msg."');";
		$string.="window.history.go(-1);";
		$string.="</script>";
		$string.="</head><body></body></html>";

		return print $string;
	}
}

if (!function_exists('remove_bom'))
{
	/**
	 * 移除BOM檔頭
	 */
	function remove_bom($str = '')
	{
		if (substr($str , 0 , 3 ) == pack("CCC",0xef,0xbb,0xbf))
			$str = substr($str , 3);
		
		return $str;
	}
}


if (!function_exists('get_ip_address'))
{
	// lowercase first letter of functions. It is more standard for PHP
	function get_ip_address() 
	{
		
		// populate a local variable to avoid extra function calls.
		// NOTE: use of getenv is not as common as use of $_SERVER.
		//       because of this use of $_SERVER is recommended, but 
		//       for consistency, I'll use getenv below
		$tmp = getenv("HTTP_CLIENT_IP");
		// you DON'T want the HTTP_CLIENT_ID to equal unknown. That said, I don't
		// believe it ever will (same for all below)
		if ( $tmp && !strcasecmp( $tmp, "unknown"))
			return $tmp;

		$tmp = getenv("HTTP_X_FORWARDED_FOR");
		if( $tmp && !strcasecmp( $tmp, "unknown"))
			return $tmp;

		// no sense in testing SERVER after this. 
		// $_SERVER[ 'REMOTE_ADDR' ] == gentenv( 'REMOTE_ADDR' );
		$tmp = getenv("REMOTE_ADDR");
		if($tmp && !strcasecmp($tmp, "unknown"))
			return $tmp;

		return("unknown");
	}
}

if (!function_exists('fix_admin_template_code'))
{
	function fix_admin_template_code($html = '')
	{
		return preg_replace('/contenteditable="true"/i' , 'contenteditable="false"' , $html);
	}
}

if (!function_exists('to_money')){
	/**
	 * to money format 
	 * @editer Tone
	 * @update 2016-03-09
	 * @param int | string $v
	 * @param string $symbol default = 'NT$'
	 * @param int $r
	 * @return string 
	 */
	function to_money($v = 0 , $symbol='NT$' , $r=0)
	{
		$sign = '';
		
		if ($v < 0)
		{
			$sign = '-';
		}
		
		$v = number_format($v , $r , '.' , ',');
		
		
		return $symbol . $sign . $v;
		// $n = $val; 
		// $c = is_float($n) ? 1 : number_format($n,$r);
		// $d = '.';
		// $t = ',';
		// $sign = ($n < 0) ? '-' : '';
		// $i = $n=number_format(abs($n),$r); 
		// $j = (($j = strlen($i)) > 3) ? $j % 3 : 0; 

	   // return  $symbol.$sign .($j ? substr($i,0, $j) + $t : '').preg_replace('/(\d{3})(?=\d)/',"$1" + $t,substr($i,$j)) ;
	}
}

if (!function_exists('my_array_pop'))
{
	function my_array_pop($ary = FALSE)
	{
		$pop = '';
		
		if (is_array($ary))
		{
			foreach($ary as $key => $val)
			{
				$pop = $val;
			}
		}
		
		return $pop;
	}
}

if (!function_exists('img_show'))
{
	function img_show($file = '')
	{
		return config_item('upload_images_path') . $file;
	}
}

if (!function_exists('youtube_show'))
{
	function youtube_show($youtube = '')
	{		
		$youtube = youtube_uri_id($youtube);
		
		return '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/' . $youtube . '" allowfullscreen></iframe></div>';
	}
}

if (!function_exists('youtube_uri_id'))
{
	function youtube_uri_id($youtube = '')
	{
		if (strlen($youtube) > 15)
		{
			$youtube = explode('?v=' , $youtube);
		
			$youtube = is_array($youtube)?$youtube[1]:$youtube;
		}
		
		return $youtube;
	}
}

if (!function_exists('create_verify'))
{
	/**
	 * 產生一串字碼
	 * @param int $len
	 * @return string $verify
	 */
	function create_verify($len = 6)
	{
		$code = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
		$verify = '';
		
		for($i=1;$i<=$len;$i++)
		{
			$verify .= substr($code , rand(0 , strlen($code) - 1) , 1);
		}
		
		return $verify;
	}
}


if (!function_exists('back_space_and_br'))
{
	function back_space_and_br($str = '')
	{
		//將空白還原
		$str=str_replace(" ","&nbsp;","$str");
		//將換行還原
		$str=nl2br($str);
		return $str;
	}
}

if (!function_exists('windowsbr_to_unixbr'))
{
	function windowsbr_to_unixbr($str = '')
	{
		//轉換<br> to /n
		$str = str_replace("<br />" , "\n" , $str);
		$str = str_replace("<br>" , "\n" , $str);
		$str = str_replace("<br >" , "\n" , $str);
		
		//轉換/r/n to /n
		$str = str_replace("\r\n" , "\n" , $str);
		
		//轉換/r to /n
		$str = str_replace("\r" , "\n" , $str);
		
		return $str;
	}
}

if (!function_exists('is_localhost'))
{
	function is_localhost()
	{
		if (get_ip_address()!='127.0.0.1')
		{
			js_go_msg(site_url() , '很抱歉！您沒有權限觀看目前的頁面！');
			exit();
		}
	}
}

if (!function_exists('shuffle_assoc'))
{
	/**
	 * 多維陣列亂序
	 *
	 */
	function shuffle_assoc($list = FALSE)
	{ 
		if (!is_array($list)) return $list; 

		$keys = array_keys($list); 
		shuffle($keys); 
		$random = array(); 
		foreach ($keys as $key) 
		$random[$key] = shuffle_assoc($list[$key]); 

		return $random; 
	} 
}
/**
 * @param obj | array $obj
 * @result $new_array = array()
 */
if (!function_exists('id2key'))
{
	function id2key($obj = FALSE)
	{
		$new = array();
		

		foreach($obj as $key => $row)
		{
			if (is_array($row))
			{
				if (isset($row['id']))
				{
					$new[$row['id']] = $row;
				}
			}
			else if(is_object($row))
			{
				if (isset($row->id))
				{
					$new[$row->id] = $row;
				}
			}
		}
		
		return $new;
	}
}


if (!function_exists('my_urlencode'))
{
	function my_urlencode($str = FALSE)
	{
		if ($str == FALSE) return FALSE;
		
		$str = str_replace(' ', '' , $str);
		$str = str_replace('$', '' , $str);
		$str = str_replace(',', '' , $str);
		$str = str_replace('+', '' , $str);
		$str = str_replace('/', '' , $str);
		$str = str_replace('&', '' , $str);
		
		return urlencode($str);
	}
}


if (!function_exists('price_show'))
{
	function price_show($ary = FALSE)
	{
		if (!is_array($ary))
		{
			$ary = explode("\r\n" , $ary);
		}
		
		if (count($ary) == 1)
		{
			return to_money((int) $ary[0] , '$') . '<span style="font-size: 0.5em;"> TWD</span>';
		}
		
		foreach($ary as $k => $v)
		{
			$ary[$k] = (int) $v;
		}
		
		return to_money((int) min($ary) , '$') . '<span style="font-size: 0.5em;"> TWD</span>' . '~' . to_money((int) max($ary) , '$') . '<span style="font-size: 0.5em;"> TWD</span>';
	}
}

/* End of file zh_tech_helper.php */
/* Location: ./apps/helpers/zh_tech_helper.php */