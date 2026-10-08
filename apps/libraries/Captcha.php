<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Captcha {
	
	// 預設資料
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
		// 'pool'		=> '23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ',
		'pool'		=> '0123456789',
		'colors'	=> array(
			'background'	=> array(255,255,255),
			'border'	=> array(255,255,255),
			'text'		=> array(0,200,0),
			'grid'		=> array(0,200,0)
		)
	);
	
	// 資料
	private $data = array();
	
	// 預設格式
	private $captcha = array('word' => '', 'time' => '', 'image' => '', 'filename' => '');
	
	
	/**
	 * 建構式
	 *
	 */
	public function __construct()
	{
		$this->_check_cache_dir();
	}
	
	
	/**
	 * 解構式
	 *
	 */
	public function __destruct()
	{
		
	}
	
	
	/**
	 * 檢查快取資料夾
	 * @param 
	 * 
	 * @return 
	 */
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
	 * @return $this
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
	 * @param 
	 *
	 * @return $this
	 */
	public function create()
	{
		// 重製驗證碼
		$this->captcha = array('word' => '', 'time' => '', 'image' => '', 'filename' => '');
		
		// 取得config資料
		foreach($this->data as $key => $val) $$key = $val;
		
		// 檢查路徑及GD涵式庫
		if ($img_path === '' OR $img_url === '' OR $cache_path === ''
			OR ! is_dir($img_path) OR ! is_really_writable($img_path)
			OR ! extension_loaded('gd'))
		{
			return $this;
		}

		// 清除過期&無效的圖片
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
		
		// 清除過期&無效的快取
		
		$current_dir = @opendir($cache_path);
		while ($filename = @readdir($current_dir))
		{
			if (substr($filename, -6) === '.cache' && (str_replace('.cache', '', $filename) + $expiration) < $now)
			{
				@unlink($cache_path.$filename);
			}
		}

		@closedir($current_dir);
		
		// 清除舊資料以及建立新的驗證碼文字
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
		
		// 建立圖片
		$im = @imagecreatetruecolor($img_width , $img_height);
		
		// 背景色
		imagefill($im , 0 , 0 , imagecolorallocate($im , $colors['background'][0] , $colors['background'][1] , $colors['background'][2]));
		
		// 邊框色
		imagerectangle($im,0,0,$img_width - 1,$img_height -1,imagecolorallocate($im , $colors['border'][0] , $colors['border'][1] , $colors['border'][2]));
		
		/*
		// 畫曲線
		$A = mt_rand(1 , $img_height / 2); // 震幅
		$b = mt_rand(-$img_height / 4 , $img_height / 4); // Y軸偏移
		$f = mt_rand(-$img_height / 4 , $img_height / 4); // X軸偏移
		$T = mt_rand($img_height * 1.5 , $img_width * 2); // 週期
		$w = (2* M_PI)/$T;
		
		$px1 = 0;  // 曲线横坐标起始位置
		$px2 = mt_rand($img_width/2, $img_width * 0.667);  // 曲线横坐标结束位置 	    	
		for ($px=$px1; $px<=$px2; $px=$px+ 0.9) {
			if ($w!=0) {
				$py = $A * sin($w*$px + $f)+ $b + $img_height/2;  // y = Asin(ωx+φ) + b
				$i = (int) (($font_size - 6)/4);
				while ($i > 0) {	
				    imagesetpixel($im, $px + $i, $py + $i, imagecolorallocate($im,$colors['text'][0] , $colors['text'][1] , $colors['text'][2]));  // 这里画像素点比imagettftext和imagestring性能要好很多				    
				    $i--;
				}
			}
		}
		
		$A = mt_rand(1, $img_height/2);                  // 振幅		
		$f = mt_rand(-$img_height/4, $img_height/4);   // X轴方向偏移量
		$T = mt_rand($img_height*1.5, $img_width*2);  // 周期
		$w = (2* M_PI)/$T;		
		$b = $py - $A * sin($w*$px + $f) - $img_height/2;
		$px1 = $px2;
		$px2 = $img_width;
		for ($px=$px1; $px<=$px2; $px=$px+ 0.9) {
			if ($w!=0) {
				$py = $A * sin($w*$px + $f)+ $b + $img_height/2;  // y = Asin(ωx+φ) + b
				$i = (int) (($font_size - 8)/4);
				while ($i > 0) {			
				    imagesetpixel($im, $px + $i, $py + $i, imagecolorallocate($im,$colors['text'][0] , $colors['text'][1] , $colors['text'][2]));  // 这里(while)循环画像素点比imagettftext和imagestring用字体大小一次画出（不用这while循环）性能要好很多	
				    $i--;
				}
			}
		}
		*/
		
		// $length	= strlen($word);
		// $angle	= ($length >= 6) ? mt_rand(-($length-6), ($length-6)) : 0;
		// $x_axis	= mt_rand(6, (360/$length)-16);
		// $y_axis = ($angle >= 0) ? mt_rand($img_height, $img_width) : mt_rand(6, $img_height);
		
		for($i=2;$i<$img_height-1;$i++)
		{
			// 获取随机淡色
			// $line_color = imagecolorallocate($im,rand(200,255),rand(200,255),rand(200,255));
			// $line_color = imagecolorallocate($im,$colors['grid'][0] , $colors['grid'][1] , $colors['grid'][2]);
			// 画线
			// imageline($im,2,$i,$img_width - 3,$i,$line_color);
		}
		
		// ($font_size > 30) && $font_size = 30;
		// $x = mt_rand(0, $img_width / ($length / 1.5));
		// $x = mt_rand(0, $img_width / ($length / 1.5));
		// $y = $img_height / 4;
		$y = rand(0,3);
		// $y = $font_size + 2;
		$x = rand(2,5);
		
		$codeNX = 0;
		
		for ($i = 0; $i < strlen($word); $i++)
		{
			$y = @mt_rand($img_height / 5, $img_height / 8);
			
			// 获取随机较深颜色
			// $text_color = imagecolorallocate($im,rand(50,180),rand(50,180),rand(50,180));
			$text_color = imagecolorallocate($im,$colors['text'][0] , $colors['text'][1] , $colors['text'][2]);
			// 画文字
			// imagechar($im,$font_size,$x,$y,$word[$i],$text_color);
			$codeNX += mt_rand($font_size*1, $font_size*1);
			imagettftext($im,$font_size,mt_rand(-20, 20),$codeNX,$font_size * 1.5 , $text_color ,$font_path , $word[$i] );
			// imagechar($im,$font_size,mt_rand(-20, 40),$codeNX, $word[$i] ,$text_color );
			
			// imagettftext($im, $font_size, mt_rand(-40, 70), $codeNX, self::$fontSize*1.5, self::$_color, $ttf, $code[$i]);
			
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
		$this->captcha = array('word' => $word, 'time' => $now . '', 'image' => $img, 'filename' => $img_filename);
		
		return $this;
	}
	
	
	/**
	 * 寫入快取
	 * @param string $file
	 * @param string $word
	 *
	 * @reutrn
	 */
	public function set_cache($file = '' , $word = '')
	{
		file_put_contents($file , $word);
		chmod($file , 0777);
	}
	
	
	/**
	 * 取得
	 * @param
	 *
	 * @return array() $this->captcha
	 */
	public function cap()
	{
		return $this->captcha;
	}
	
	
	/**
	 * 印出
	 * @param
	 *
	 * @return $this
	 */
	public function out()
	{
		echo json_encode(array('captcha' => $this->captcha['image'] , 'captcha_code' => $this->captcha['time']));
		
		return $this;
	}
	
	
	/**
	 * 檢查驗證碼
	 * @param string $captcha_code
	 * @param string $captcha_file
	 *
	 * @return bool
	 */
	public function check($captcha_code = FALSE , $captcha_file = FALSE)
	{
		if ($captcha_code == FALSE || $captcha_file == FALSE) return FALSE;
		
		$file = $this->data['cache_path'] . $captcha_file . '.cache';
		
		if (!is_file($file)) return FALSE;
		
		// $cache_code = get_cache('captcha/' . $captcha_file . '.cache');
		$cache_code = file_get_contents($file);	
		
		// 取出驗證碼後表示該驗證碼使用過，即移除
		@unlink($file);
		
		if (strtolower($cache_code) != strtolower($captcha_code)) return FALSE;
		
		return TRUE;
	}
}