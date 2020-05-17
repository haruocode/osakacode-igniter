<?php

/**
 * Created by PhpStorm.
 * User: Administrator PC
 * Date: 4/21/2016
 * Time: 2:16 PM
 */
class Channel_model extends MY_Model
{
    public $table = 'channels';
    public $primary_key = 'id';
    protected $soft_deletes = TRUE;

    public function __construct()
    {
        parent::__construct();
    }
}