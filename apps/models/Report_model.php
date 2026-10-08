<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Report Model
 * 
 * @package		: zh-tech
 * @category		: model
 * @author		: Tone
 */

class Report_model extends CI_Model {
	
	private $agent_database = 'agent';
	
	private $report_database = 'report';
	
	private $week_list = FALSE;
	
	/**
	 * 建構式
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	
	/**
	 * 解構式
	 *
	 */
	public function __destruct()
	{
		
	}
	
	
	/**
	 * 紀錄用戶造訪
	 * @param 
	 *
	 * @return 
	 */
	public function log_user_request()
	{
		$this->load->library('user_agent');
		
		$create_at = date('Y-m-d H:i:s');
		
		//瀏覽器
		$is_browser = (int) $this->agent->is_browser();
		
		//手機
		$is_mobile = (int) $this->agent->is_mobile();
		
		//機器人
		$is_robot = (int) $this->agent->is_robot();
		
		//外連網站
		$is_referral = (int) $this->agent->is_referral();
		
		//瀏覽器版本
		$version = $this->agent->version();
		
		//行動裝置名稱
		$mobile = $this->agent->mobile();
		
		//機器人名稱
		$robot = $this->agent->robot();
		
		//作業系統
		$platform = $this->agent->platform();
		
		//完整的使用者代理資訊
		$agent_string = $this->agent->agent_string();
		
		$sql = "INSERT INTO {$this->agent_database} SET create_at = ? , is_browser = ? , is_mobile = ? , is_robot = ? , is_referral = ? , version = ? , mobile = ? , robot = ? , platform = ? , agent_string = ?";
		$query = $this->db->query($sql , array($create_at , $is_browser , $is_mobile , $is_robot , $is_referral , $version , $mobile , $robot , $platform , $agent_string));
		
		if ($is_robot == 0)
		{
			$create_at = date('Y-m-d');
			$device = $is_mobile == 0?1:2;
			
			$sql = "SELECT count(*) as tal FROM {$this->report_database} WHERE create_at = ? AND device = ? AND is_referral = ? ";
			$query = $this->db->query($sql , array($create_at , $device , $is_referral));
			$row = $query->row();
			
			if (isset($row->tal) && $row->tal > 0)
			{
				$sql = "UPDATE {$this->report_database} SET request = request + 1 WHERE create_at = ? AND device = ? AND is_referral = ? ";
				$query = $this->db->query($sql , array($create_at , $device , $is_referral));
			}
			else
			{
				$sql = "INSERT INTO {$this->report_database} SET create_at = ? , device = ? , is_referral = ? , request = 1";
				$query = $this->db->query($sql , array($create_at , $device , $is_referral));
			}
		}
	}
	
	
	/**
	 * 紀錄客服紀錄 (318咖啡版本已棄用)
	 *
	 */
	public function log_contact_request($type = 11)
	{
		if ($type != 11 && $type != 12) return FALSE;
		
		$create_at = date('Y-m-d');
		$device = $type;
		$is_referral = 0;
		
		$sql = "SELECT count(*) as tal FROM {$this->report_database} WHERE create_at = ? AND device = ? AND is_referral = ? ";
		$query = $this->db->query($sql , array($create_at , $device , $is_referral));
		$row = $query->row();
		
		if (isset($row->tal) && $row->tal > 0)
		{
			$sql = "UPDATE {$this->report_database} SET request = request + 1 WHERE create_at = ? AND device = ? AND is_referral = ? ";
			$query = $this->db->query($sql , array($create_at , $device , $is_referral));
		}
		else
		{
			$sql = "INSERT INTO {$this->report_database} SET create_at = ? , device = ? , is_referral = ? , request = 1";
			$query = $this->db->query($sql , array($create_at , $device , $is_referral));
		}
	}
	
	
	/**
	 * 取得請求列表
	 *
	 */
	public function get_report_data_list($device = 1 , $is_referral = 0)
	{
		$date_old_max = date('Y-m-d',(strtotime(date('Y-m-d')) - (86400 * 90)));
		
		$sql = "SELECT * FROM {$this->report_database} WHERE device = ? AND is_referral = ? AND create_at > '{$date_old_max}' ORDER BY create_at ASC";
		$query = $this->db->query($sql , array($device , $is_referral));
		
		return $query->result();
	}
	
	
	/**
	 * 產生一週的報表
	 * device 1 = pc 2 = mobile
	 * referral 0 外來 1 內部
	 */
	public function get_week_report($device = 1 , $is_referral = 0)
	{
		// 取得週
		$week_list = $this->get_week_list();
		
		// 產生容器
		$result = array();
		
		// 取得資料
		foreach($week_list as $key => $val)
		{
			$sql = "SELECT * FROM {$this->report_database} WHERE device = ? AND is_referral = ? AND create_at = ?";
			$query = $this->db->query($sql , array($device , $is_referral , $val));
			
			if ($query)
			{
				$row = $query->row();
				$result[] = isset($row->request)?$row->request:"0";
			}
			else
			{
				$result[] = "0";
			}
		}
		
		return $result;
	}
	
	
	/**
	 * 產生一週的日期
	 *
	 */
	public function get_week_list()
	{
		if ($this->week_list != FALSE)
		{
			return $this->week_list;
		}
		
		// 產生現在時間
		$now = time();
		
		// 產生容器
		$result = array();
		
		// 取得資料
		for($i=0;$i<7;$i++)
		{
			$result[] = date('Y-m-d',$now - ($i * 86400));
		}
		
		// 反敘排列
		$result = array_reverse($result);
		
		// 寫入記憶體
		$this->week_list = $result;
		
		// 回傳資料
		return $result;
	}

	
	/**
	 * 格式化資料列表
	 *
	 */
	public function format_report_data_list($data = array())
	{
		$response = array();
		
		if (!is_array($data)) return array();
		
		foreach($data as $key => $row)
		{
			if (is_object($row))
			{
				$response[] = array(strtotime($row->create_at) * 1000 , (int) $row->request);
			}
		}
		
		return $response;
	}

}