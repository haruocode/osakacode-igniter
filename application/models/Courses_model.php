<?php

class Courses_model extends MY_model {
	public function __construct() {
		parent:: __construct();
		$this->load->database();
	}

	public function get_all_courses (){
		$query = $this->db->get_where('courses', []);
		$this->db->from('courses');
		return $query->result();
	}

	public function get_one_course ($course_id) {
		$query = $this->db->get_where('courses', ['id' => $course_id]);
		return $query->result();
	}

	public function insert_course($data){

		$data_course_db = [
			'description' => $data['description'],
			'title' => $data['title'],
			'image' => $data['image'],
			'difficulty' => $data['difficulty'],
			'status' => $data['status'],
			'featured' => $data['featured'],
			'archived' => $data['archived'],
			'link_id' => NULL,
			'created_at'=>date('Y-m-d H:i:s'),
      'updated_at'=>date('Y-m-d H:i:s')
		];

		$this->db->insert('courses', $data_course_db);
	}
}