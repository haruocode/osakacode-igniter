<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SearchController extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
        $this->load->model('lesson_model','lessons');
        $this->load->helper('date');
	}

	public function index()
	{
		$q = $this->input->get('q');
		$q_where = $this->input->get('q-where');

		// Make search-word lowercase
		$q = strtolower($q);
		// Trim search-word
		$q = trim(preg_replace('!\s+!', ' ', str_replace(array ("\r", "\t", "\n"), " ", $q)));
		
		$data = [
			'head_title' => '動画検索結果',
			'head_desc' => 'プログラミング動画の検索結果です。',
			'title' => '検索結果',
			'lessons' => $q == NULL ? NULL : $this->search($q, $q_where),
			'q' => $q,
		];

		$this->blade->render('front.search', $data);
	}

	public function search($q, $q_where)
	{
		// Split to array of words
		$qs = explode(" ", $q);

		$lessons = array();

		$query = $this->db->select('*')
						  ->from($q_where)
						  ->get();

		foreach ($query->result() as $row) {
			$added = 0;
			foreach ($qs as $q) {
				if($added == 0) {
					if(strpos(strtolower($row->title), $q) !== FALSE || strpos(strtolower($row->description), $q) !== FALSE) {
						$lessons[] = $this->_get_lesson_with_courses($row->id);
						$added = 1;
					}
				}
			}	
		}

		return $lessons;
	}

	protected function _get_lesson_with_courses($id)
	{
		$lesson = $this->lessons->with_courses()
						  	    ->where('id', $id)
						    	->get();
		return $lesson;
	}
}