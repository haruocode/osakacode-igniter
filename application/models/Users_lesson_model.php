<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users_Lesson_model extends MY_Model
{
    public $table = 'users_lessons';

    public $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
    }
    public function list_recently_complete($user_id){
    	$query = $this->db
    			->select('lessons.id, lessons.course_id, lessons.order, lessons.title, lessons.updated_at')
    			->from('users_lessons')
    			->join('lessons', 'users_lessons.lesson_id = lessons.id')
    			->where('users_lessons.user_id', $user_id)
    			->where('users_lessons.status', LESSON_COMPLETE)
    			->order_by('id', 'ASC')->get();
		return $query->result();
    }
}