<?php

/**
 * Created by PhpStorm.
 * User: Administrator PC
 * Date: 4/21/2016
 * Time: 2:26 PM
 */
class Post_model extends MY_Model
{
	public $table = 'posts';
	public $primary_key = 'id';
	public $before_create = ['createdAtTimestamps', 'updatedAtTimestamps', 'xssFilter', 'markdownConvert'];
	public $before_update = ['updatedAtTimestamps', 'xssFilter', 'markdownConvert'];
	protected $soft_deletes = TRUE;

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
		$this->has_one['user_profile'] = [
			'foreign_model' => 'Profile_model',
			'foreign_table' => 'users_profile',
			'foreign_key' => 'user_id',
			'local_key' => 'user_id'
		];
		parent::__construct();
	}

	protected function createdAtTimestamps($data)
	{
		$data['created_at'] = time();
		return $data;
	}

	protected function updatedAtTimestamps($data)
	{
		$data['updated_at'] = time();
		return $data;
	}

	protected function xssFilter($data)
	{
		if(isset($data['content'])){
			$data['content'] = $this->security->xss_clean($data['content']);
		}
		if(isset($data['markdown'])){
			$data['markdown'] = $this->security->xss_clean($data['markdown']);
		}
		return $data;
	}

	protected function markdownConvert($data)
	{
		if(isset($data['content'])){
			$data['content'] = Parsedown::instance()->text($data['content']);
		}
		return $data;
	}
}