<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: hiennq
 * Date: 5/5/16
 * Time: 15:28
 */
class Log_likes_model extends MY_Model
{
    public $table = 'log_likes';
    protected $soft_deletes = false;
    protected $timestamps = false;
    public $primary_key = 'post_id';

    public function __construct()
    {
        parent::__construct();
    }

    public $before_create = ['createdAtTimestamps'];

    protected function createdAtTimestamps($data)
    {
        $data['created_at'] = time();
        return $data;
    }
}