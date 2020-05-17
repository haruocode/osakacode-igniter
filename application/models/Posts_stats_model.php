<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: hiennq
 * Date: 5/5/16
 * Time: 15:28
 */
class Posts_stats_model extends MY_Model
{
    public $table = 'posts_stats';
    protected $soft_deletes = false;
    protected $timestamps = false;
    public $primary_key = 'post_id';

    public function __construct()
    {
        parent::__construct();
    }
}