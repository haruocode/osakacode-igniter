<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Lesson_model extends MY_Model
{
    public $table = 'lessons';

    public $primary_key = 'id';

    public function __construct()
    {
        $this->has_one['courses'] = [
            'foreign_model' => 'Series_model',
            'foreign_table' => 'courses',
            'foreign_key' => 'id',
            'local_key' => 'course_id'
        ];
        parent::__construct();
    }

    public function get_simple_list_by_id($list_id)
    {
        return $this->fields('id,title,free,updated_at')->where('id',$list_id)->get_all();
    }

    public function get_lesson_info($id)
    {
        $query = $this->db->get_where('lessons', ['id' => $id]);
        return $query->result();
    }
    
    public function insert_lesson($data){

  		$data_lesson_db = [
  			'title' => $data['title'],
  			'course_id' => $data['course_id'],
  			'order' => $data['order'],
  			'time' => $data['time'],
  			'description' => $data['description'],
  			'point' => $data['point'],
  			'created_at'=>date('Y-m-d H:i:s'),
        'updated_at'=>date('Y-m-d H:i:s'),
        'video_url' => $data['video_url'],
        'free' => $data['free'],
        'difficulty' => $data['difficulty']
  		];

  		$this->db->insert('lessons', $data_lesson_db);
  	}
}