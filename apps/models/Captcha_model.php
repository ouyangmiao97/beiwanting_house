<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha_model extends CI_Model {
	/**
	 * Captcha Model
	 * 
	 * 
	 * @package		: zh-tech
	 * @copyright	: zh-tech 振華科技
	 * @author		: Tone
	 * 
	 * if you autoload the tech.php config you api controller can use:
	 *
	 * $this->load->model('zh_tech_captcha');
	 * $this->zh_tech_captcha_model->set_data($this->config->item('zh_tech_captcha_setting'))->create()->out();
	 * 
	 * and this out function echo this json:
	 * 
	 * {"captcha":"<img  src=\"\/captcha\/1444980351.98.jpg\" style=\"width: 50; height: 20; border: 0;\" alt=\" \" \/>","captcha_code":1444980351.98}
	 *
	 *
	 */
	
	private $defaults = array(
		'word'		=> '',
		'cache_path'=> '',
		'img_path'	=> '',
		'img_url'	=> '',
		'img_width'	=> '150',
		'img_height'	=> '30',
		'font_path'	=> '',
		'expiration'	=> 7200,
		'word_length'	=> 8,
		'font_size'	=> 8,
		'img_id'	=> '',
		'pool'		=> '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
		'colors'	=> array(
			'background'	=> array(255,128,255),
			'border'	=> array(153,102,102),
			'text'		=> array(204,153,153),
			'grid'		=> array(255,182,182)
		)
	);
	
	private $data = array();
	
	private $captcha = array('word' => '', 'time' => '', 'image' => '', 'filename' => '');
	
	public function __construct()
	{
		parent::__construct();
		
		$this->_check_cache_dir();
	}
	
	public function __destruct()
	{
		
	}
	
	
	private function _check_cache_dir()
	{
		if (!is_dir(APPPATH . 'cache/captcha/'))
		{
			mkdir(APPPATH . 'cache/captcha/');
			chmod(APPPATH . 'cache/captcha/' , 0777);
		}
	}
	
	
	/**
	 * 驗證碼產生器基本設定
	 * @param array $data
	 *
	 */
	public function set_data($data = FALSE)
	{
		foreach($this->defaults as $key => $val)
		{
			if ( ! is_array($data) && empty($this->data[$key]))
			{
				$this->data[$key] = $val;
			}
			else
			{
				$this->data[$key] = isset($data[$key]) ? $data[$key] : $val;
			}
		}

		return $this;
	}
	
	
	/**
	 * 產生驗證碼
	 *
	 */
	public function create()
	{
		$this->captcha = array('word' => '', 'time' => '', 'image' => '', 'filename' => '');
		
		foreach($this->data as $key => $val) $$key = $val;
		
		if ($img_path === '' OR $img_url === '' OR $cache_path === ''
			OR ! is_dir($img_path) OR ! is_really_writable($img_path)
			OR ! extension_loaded('gd'))
		{
			return $this;
		}

		// -----------------------------------
		// Remove old images
		// -----------------------------------

		$now = microtime(TRUE);

		$current_dir = @opendir($img_path);
		while ($filename = @readdir($current_dir))
		{
			if (substr($filename, -4) === '.jpg' && (str_replace('.jpg', '', $filename) + $expiration) < $now)
			{
				@unlink($img_path.$filename);
			}
		}

		@closedir($current_dir);
		
		// -----------------------------------
		// Remove old cache
		// -----------------------------------
		
		$current_dir = @opendir($cache_path);
		while ($filename = @readdir($current_dir))
		{
			if (substr($filename, -6) === '.cache' && (str_replace('.cache', '', $filename) + $expiration) < $now)
			{
				@unlink($cache_path.$filename);
			}
		}

		@closedir($current_dir);
		
		if (empty($word))
		{
			$word = '';
			for ($i = 0, $mt_rand_max = strlen($pool) - 1; $i < $word_length; $i++)
			{
				$word .= $pool[mt_rand(0, $mt_rand_max)];
			}
		}
		elseif ( ! is_string($word))
		{
			$word = (string) $word;
		}
		
		
		
		$im = @imagecreatetruecolor($img_width , $img_height);
		
		//背景色
		$background_color = imagecolorallocate($im , $colors['background'][0] , $colors['background'][1] , $colors['background'][2]);
		imagefill($im , 0 , 0 , $background_color);
		
		//邊框色
		$border_color = imagecolorallocate($im , $colors['border'][0] , $colors['border'][1] , $colors['border'][2]);
		imagerectangle($im,0,0,$img_width - 1,$img_height -1,$border_color);
		
		$length	= strlen($word);
		$angle	= ($length >= 6) ? mt_rand(-($length-6), ($length-6)) : 0;
		$x_axis	= mt_rand(6, (360/$length)-16);
		$y_axis = ($angle >= 0) ? mt_rand($img_height, $img_width) : mt_rand(6, $img_height);
		
		for($i=2;$i<$img_height-1;$i++)
		{
			//获取随机淡色
			$line_color = imagecolorallocate($im,rand(200,255),rand(200,255),rand(200,255));
			//画线
			imageline($im,2,$i,$img_width - 3,$i,$line_color);
		}
		
		($font_size > 30) && $font_size = 30;
		// $x = mt_rand(0, $img_width / ($length / 1.5));
		// $x = mt_rand(0, $img_width / ($length / 1.5));
		// $y = $img_height / 4;
		$y = rand(0,3);
		// $y = $font_size + 2;
		$x = rand(2,5);
		
		for ($i = 0; $i < $length; $i++)
		{
			$y = @mt_rand($img_height / 5, $img_height / 8);
			
			//获取随机较深颜色
			$text_color = imagecolorallocate($im,rand(50,180),rand(50,180),rand(50,180));
			//画文字
			imagechar($im,$font_size,$x,$y,$word[$i],$text_color);
			
			$x += $font_size;
		}
		
		// -----------------------------------
		//  Generate the image
		// -----------------------------------
		$img_url = rtrim($img_url, '/').'/';

		if (function_exists('imagejpeg'))
		{
			$img_filename = $now.'.jpg';
			imagejpeg($im, $img_path.$img_filename);
		}
		elseif (function_exists('imagepng'))
		{
			$img_filename = $now.'.png';
			imagepng($im, $img_path.$img_filename);
		}
		else
		{
			return $this;
		}

		$img = '<img '.($img_id === '' ? '' : 'id="'.$img_id.'"').' src="'.$img_url.$img_filename.'" style="width: '.$img_width.'; height: '.$img_height .'; border: 0;" alt=" " />';
		ImageDestroy($im);
		
		$this->set_cache($cache_path . $now . '.cache' , $word);
		
		// return array('word' => $word, 'time' => $now, 'image' => $img, 'filename' => $img_filename);
		$this->captcha = array('word' => $word, 'time' => $now, 'image' => $img, 'filename' => $img_filename);
		
		return $this;
	}
	
	
	/**
	 * 寫入快取
	 *
	 */
	public function set_cache($file = '' , $word = '')
	{
		file_put_contents($file , $word);
		chmod($file , 0777);
	}
	
	
	/**
	 * 取得
	 *
	 */
	public function cap()
	{
		return $this->captcha;
	}
	
	
	/**
	 * 印出
	 *
	 */
	public function out()
	{
		echo json_encode(array('captcha' => $this->captcha['image'] , 'captcha_code' => $this->captcha['time']));
		
		return $this;
	}
	
	
	/**
	 * 檢查驗證碼
	 *
	 */
	public function check($captcha_code = FALSE , $captcha_file = FALSE)
	{
		if ($captcha_code == FALSE || $captcha_file == FALSE) return FALSE;
		
		$file = $this->data['cache_path'] . $captcha_file . '.cache';
		
		if (!is_file($file)) return FALSE;
		
		//$cache_code = get_cache('captcha/' . $captcha_file . '.cache');
		$cache_code = file_get_contents($file);	
		
		//取出驗證碼後表示該驗證碼使用過，即移除
		@unlink($file);
		
		if (strtolower($cache_code) != strtolower($captcha_code)) return FALSE;
		
		return TRUE;
	}
}

/* End of file Zh_tech_captcha_model.php */
/* Location: ./apps/models/Zh_tech_captcha_model.php */