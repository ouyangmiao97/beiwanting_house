<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mail_model extends CI_Model {
	/**
	 * Mail Model
	 * 
	 * @package		: zh-tech
	 * @copyright	: zh-tech 振華科技
	 * @author		: Tone
	 *
	 */
	 
	private $debug = TRUE;
	
	private $from = '';
	
	private $mailto = '';

	public function __construct()
	{
		parent::__construct();
		
		$this->_get_mail_config();
	}
	
	
	public function __destruct()
	{
		
	}
	
	
	private function _get_mail_config()
	{
		$this->load->config('mail');
		
		$from = config_item('from');
			
		$mailto = config_item('mailto');
			
		$this->from = $from != FALSE ? $from : $this->from;
			
		$this->mailto = $mailto != FALSE ? $mailto : $this->mailto;
	}

	
	/**
	 * 寄送信件
	 * @param string $mailto
	 * @param string $subject
	 * @parma string $msg
	 *
	 * @return boolean 
	 */
	public function send($mailto = FALSE , $subject = FALSE , $msg = FALSE , $from = FALSE , $reply = FALSE)
	{
		if (!$mailto && !$this->mailto) return FALSE;
		
		if (!$subject || !$msg) return FALSE;
		
		$mailto = !$mailto?$this->mailto:$mailto;
		
		$from = !$from?$this->from:$from;
		
		$headers = sprintf("MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: %s\r\nReply-To:%s\r\nX-Mailer: PHP/%s" , $from , $reply , phpversion());
		
		$response = mail($mailto , $subject , $msg , $headers);
		
		if ($this->debug) log_message('ERROR' , $response);
		
		return $response;
	}
}

/* End of file Mail_model.php */
/* Location: ./apps/models/Mail_model.php */