<?php defined('BASEPATH') OR exit('No direct script access allowed');

class CommonService
{
	private static $instance;
	private static $skill_list;
	private static $user_exp;
	private static $user_name;
	private static $user_avatar;
	private static $count_favorite;
	private static $count_lesson_complete;
	private static $user_notification;
	private static $user_info;
	private static $user_email;


	/**
	 * @return CommonService
	 */
	public static function get_instance()
	{
		if (null === static::$instance) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	public static function generateTrustLimitData($total, $offset, $pageSize)
	{
		if ($total < $offset) {
			$offset = floor($total / $pageSize);
			$pageSize = $total - $offset;
		} elseif ($total == $offset) {
			$offset = floor($total / $pageSize) - 1;
			$offset = $offset > 0 ? $offset : 0;
		} elseif ($total > $offset && $total < $offset + $pageSize) {
			$pageSize = $total - $offset;
		}
		return ['offset' => $offset, 'pageSize' => $pageSize];
	}

	public function skill_list()
	{
		if (null === static::$skill_list) {
			$ci = CI_Controller::get_instance();
			static::$skill_list = $ci->db->from('skills')->get();
		}
		return static::$skill_list;
	}

	public function user_exp()
	{
		if (null === self::$user_exp) {
			self::getUserInfo();
		}
		return self::$user_exp;
	}

	private function getUserInfo()
	{
		if (null === self::$user_info) {
			$ci = CI_Controller::get_instance();
			$info = $ci->db->select('*')
				->from('users')
				->where('id', $ci->session->userdata('id'))
				->get()->row();
			self::$user_info = $info;
			self::$user_exp = $info->exp;
			self::$user_name = $info->username;
			self::$user_email = $info->email;
		}
		return self::$user_info;
	}

	public function user_name()
	{
		if (null === self::$user_name) {
			$username = CI_Controller::get_instance()->session->userdata('username');
			if($username) {
				self::$user_name = $username;
				return $username;
			}
			self::getUserInfo();
		}
		return self::$user_name;
	}

	public function user_email()
	{
		if (null === self::$user_email) {
			self::getUserInfo();
		}
		return self::$user_email;
	}

	public function user_avatar($user_id)
	{
		if (null === static::$user_avatar) {
			$ci = CI_Controller::get_instance();
			static::$user_avatar = $ci->db->select('avatar')
				->from('users_profile')
				->where('user_id', $user_id)
				->get()->row()->avatar;
		}
		return static::$user_avatar;
	}

	public function getRoundTime($str_time)
	{
		if (is_int($str_time)) {
			$round = (time() - $str_time) / 86400;
		} else {
			$round = (time() - strtotime($str_time)) / 86400;
		}
		$result = $round / 365;
		if ($result >= 1) {
			return floor($result) . ' 年';
		}
		$result = $round / 30;
		if ($result >= 1) {
			return floor($result) . ' ヶ月';
		}
		return floor($round) . ' 日';
	}

	public function count_favorite($user_id)
	{
		if (null === static::$count_favorite) {
			$ci = CI_Controller::get_instance();
			static::$count_favorite = $ci->db->select('count(id) as count')
				->from('playlist')
				->where('user_id', $user_id)
				->where('playlist_type', PLAYLIST_FAVORITES_TYPE)
				->get()->row()->count;
		}
		return static::$count_favorite;
	}

	public function count_lesson_complete($user_id)
	{
		if (null === static::$count_lesson_complete) {
			$ci = CI_Controller::get_instance();
			static::$count_lesson_complete = $ci->db->select('count(id) as count')
				->from('users_lessons')
				->where('user_id', $user_id)
				->where('status', LESSON_COMPLETE)
				->get()->row()->count;
		}
		return static::$count_lesson_complete;
	}

	public function getUserNotification()
	{
		if (null === self::$user_notification) {
			$ci = CI_Controller::get_instance();
			$ci->load->model('notification_model');
			$notifyService = new \Solid\Services\SystemNotificationService();
			$notifyRepo = new \Solid\Repositories\SystemNotificationRepository($notifyService);
			$notifyRepo->setModel($ci->notification_model);
			self::$user_notification = $notifyRepo->getUnread($ci->session->userdata('id'));
		}
		return self::$user_notification;
	}

	function time_elapsed_string($datetime, $full = false) {
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => '年',
			'm' => 'ヶ月',
			'w' => '週間',
			'd' => '日',
			'h' => '時間',
			'i' => '分',
			's' => '秒',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . '' . $v . ($diff->$k > 1 ? '' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . '前' : 'たった今';
	}
	
	function getYoutubeEmbedUrl($youtubeUrl){
		return str_replace("watch?v=","embed/",$youtubeUrl);
	}
}