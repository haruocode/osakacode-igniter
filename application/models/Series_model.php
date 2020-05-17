<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Series_model extends MY_Model
{


    public $table = 'courses';

    public $primary_key = 'id';

    public $fillable = array('title', 'description', 'image', 'updated_at');


    public function __construct()
    {
        $this->has_many['lessons'] = [
            'foreign_model' => 'Lesson_model',
            'foreign_table' => 'lessons',
            'foreign_key' => 'course_id',
            'local_key'=>'id'
        ];

        parent::__construct();

    }
    public function get_simple_list_by_id($list_id)
    {
        return $this->fields('id,title,image')
                    ->with_lessons('fields:*count*')
                    ->where('id',$list_id)
                    ->get_all();
    }
}