<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File_model extends CI_Model {
	/**
	 * Zh_tech file Model
	 * 
	 * @package		: zh-tech
	 * @copyright	: zh-tech 振華科技
	 * @author		: Tone
	 *
	 */	
	private $debug_mode = FALSE;
	private $error_log_path = '';
	private $file_name_hash = '7127048fc9ef470451759abaf65b2814';
	public $err_msg = '';
	
	public function __construct()
	{
		parent::__construct();		
	}
	
	public function __destruct()
	{
		
	}
	
	/**
	 * 設定除錯模式
	 * @param boolean $mode
	 * @param string $path
	 * @return $this
	 **/
	public function debug_mode($mode = FALSE , $path = '')
	{
		$this->debug_mode = $mode;
		$this->error_log_path = $path;
		
		return $this;
	}
	
	/**
	 * LOG錯誤訊息
	 * @param string $msg
	 * @return 
	 */
	private function _error($msg = '')
	{
		if ($this->debug_mode == TRUE && $this->error_log_path != '' && is_dir($this->error_log_path))
		{
			@file_put_contents($this->error_log_path . '/file_' . date('Ymd') . '.log' , $msg , FILE_APPEND);
		}
	}
	
	/**
	 * 搬移檔案
	 * @param
	 * @return 
	 */
	public function move($upload_file = FALSE , $data = array())
	{
		if ($upload_file == FALSE)
		{
			$this->_error('no set upload file name.');
			return FALSE;
		}
		
		$defaults = array(
			'upload_path' => APPPATH . '/cache/',
			'allowed_types' => 'jpeg|jpg|gif|png|doc|docx|xls|xlsx',
			'overwrite' => FALSE,
			'max_size' => 102400,
			'max_width' => 0,
			'max_height' => 0,
			'max_filename' => 0,
			'encrypt_name' => TRUE,
			'remove_spaces' => TRUE
		);
		
		$config = array();
		
		foreach($defaults as $key => $val)
		{
			if (isset($data[$key]))
			{
				$config[$key] = $data[$key];
			}
			else
			{
				$config[$key] = $val;
			}
		}
		
		$this->load->library('upload' , $config);
		
		$upload_state = $this->upload->do_upload($upload_file);
		
		if ($upload_state == FALSE)
		{
			$err = $this->upload->display_errors('','');
			$this->err_msg = $err;
			$this->_error($err);
			return FALSE;
		}
		
		$response = $this->upload->data();
		    // [file_name]    => mypic.jpg
			// [file_type]    => image/jpeg
			// [file_path]    => /path/to/your/upload/
			// [full_path]    => /path/to/your/upload/jpg.jpg
			// [raw_name]     => mypic
			// [orig_name]    => mypic.jpg
			// [file_ext]     => .jpg
			// [file_size]    => 22.2
			// [is_image]     => 1
			// [image_width]  => 800
			// [image_height] => 600
			// [image_type]   => jpeg
			// [image_size_str] => width="800" height="200"
			
		return $response;
	}	
}

/* End of file Zh_tech_file_model.php */
/* Location: ./apps/models/Zh_tech_file_model.php */