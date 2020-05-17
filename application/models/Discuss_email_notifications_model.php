<?php

/**
 * Created by PhpStorm.
 * User: Administrator PC
 * Date: 5/4/2016
 * Time: 4:52 PM
 */
class Discuss_email_notifications_model extends MY_Model
{
	public $table = 'discuss_email_notifications';
	public function __construct()
	{
		$this->has_one['user'] = [
			'foreign_model' => 'User_model',
			'foreign_table' => 'users',
			'foreign_key' => 'id',
			'local_key' => 'user_id'
		];
		$this->has_one['discussion'] = [
			'foreign_model' => 'Discussions_model',
			'foreign_table' => 'discussions',
			'foreign_key' => 'id',
			'local_key' => 'discussion_id'
		];
		parent::__construct();
	}
}