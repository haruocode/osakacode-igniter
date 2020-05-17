<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Discussions_model extends MY_Model
{


    public $table = 'discussions';
    public $primary_key = 'id';
    protected $soft_deletes = TRUE;



    public function __construct()
    {
        $this->has_one['user'] = [
            'foreign_model' => 'User_model',
            'foreign_table' => 'users',
            'foreign_key' => 'id',
            'local_key' => 'user_id'
        ];
        $this->has_one['channel'] = [
            'foreign_model' => 'Channel_model',
            'foreign_table' => 'channels',
            'foreign_key' => 'id',
            'local_key' => 'channel_id'
        ];
        $this->has_many['post'] = [
            'foreign_model' => 'Post_model',
            'foreign_table' => 'posts',
            'foreign_key' => 'discussion_id',
            'local_key' => 'id'
        ];
        parent::__construct();
    }

    public $before_create = ['createdAtTimestamps','updatedAtTimestamps','xssFilter'];
    public $before_update = ['updatedAtTimestamps','xssFilter'];

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
        if(isset($data['content'])) {
            $data['title'] = $this->security->xss_clean($data['title']);
        }
        return $data;
    }
}