<?php

class AdminController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('email') !== ADMIN_EMAIL){
    			show_error('You are not login',400);
    		};
        $this->load->model('courses_model', 'courses');
        $this->load->model('lesson_model', 'lesson');
    }

    public function index() {
      $data = array();
      $this->blade->render('myadmin.index', $data);
    }
    
    public function series() {
      $data = array();
      //講座一覧の取得
      $query = $this->db->select('*')
              ->from('courses')
              ->get();
      $detail = $query->result();
      $data['series'] = $detail;
      $this->blade->render('myadmin.series', $data);
    }
    
    public function add_series() {
      // Security for xss_clean
  		$this->load->helper('security');
  		$this->load->helper('form');
  		$this->load->library('form_validation');
      
      // set rules for login form
  		$this->form_validation->set_rules('title', '', 'trim|required|xss_clean');
  		$this->form_validation->set_rules('keyword', '', 'trim|required|xss_clean');
      $this->form_validation->set_rules('description', '', 'trim|required|xss_clean');
      //$this->form_validation->set_rules('image', '', 'trim|required|xss_clean');
      $this->form_validation->set_rules('difficulty', '', 'trim|required|xss_clean|numeric|max_length[1]');
      $this->form_validation->set_rules('status', '', 'trim|required|xss_clean|numeric|max_length[1]');
      $this->form_validation->set_rules('featured', '', 'trim|required|xss_clean|numeric|max_length[1]');
      $this->form_validation->set_rules('archived', '', 'trim|required|xss_clean|numeric|max_length[1]');
      
      if ($this->form_validation->run() == TRUE) {
  			//DBの○○テーブルにINSERTする
        $post_data = $this->input->post();
        $this->courses->insert_course($post_data);
  		}
      
      $data = array();
      $this->blade->render('myadmin.add_series', $data);
    }
    
    public function delete_series($id) {
      //講座の削除
      $ci = CI_Controller::get_instance();
      $ci->db->where('id', $id);
  		$ci->db->update('courses', ['deleted' => TRUE]);
      redirect('/adm/series/');
    }
    
    public function edit_series($id) {
      // Security for xss_clean
  		$this->load->helper('security');
  		$this->load->helper('form');
  		$this->load->library('form_validation');
      
      // set rules for login form
  		$this->form_validation->set_rules('title', '', 'trim|required|xss_clean');
  		//$this->form_validation->set_rules('keyword', '', 'trim|required|xss_clean');
      $this->form_validation->set_rules('description', '', 'trim|required|xss_clean');
      $this->form_validation->set_rules('image', '', 'trim|required|xss_clean');
      $this->form_validation->set_rules('difficulty', '', 'trim|required|xss_clean|numeric|max_length[1]');
      $this->form_validation->set_rules('status', '', 'trim|required|xss_clean|numeric|max_length[1]');
      $this->form_validation->set_rules('featured', '', 'trim|required|xss_clean|numeric|max_length[1]');
      $this->form_validation->set_rules('archived', '', 'trim|required|xss_clean|numeric|max_length[1]');
      
      if ($this->form_validation->run() == TRUE) {
        $ci = CI_Controller::get_instance();
        $ci->db->where('id', $id);
        $edit_data = array(
          'description' => $this->input->post('description'),
          'title' => $this->input->post('title'),
          'image' => $this->input->post('image'),
          'difficulty' => $this->input->post('difficulty'),
          'status' => $this->input->post('status'),
          'featured' => $this->input->post('featured'),
          'archived' => $this->input->post('archived'),
          'deleted' => $this->input->post('deleted'),
          'updated_at' => date('Y-m-d H:i:s')
        );
    		$ci->db->update('courses', $edit_data);
        redirect('/adm/series/');
  		}
      //講座情報の取得
      $query = $this->db->select('*')
              ->from('courses')
              ->where('id', $id)
              ->get();
      $detail = $query->result();
      $data = array();
      $data['id'] = $id;
      $data['series'] = $detail[0];
      $this->blade->render('myadmin.edit_series', $data);
      
    }
    
    public function lessons($id) {
      $data = array();
      //講座一覧の取得
      $query = $this->db->select('*')
              ->from('lessons')
              ->where('course_id', $id)
              ->get();
      $detail = $query->result();
      $data['id'] = $id;
      $data['lessons'] = $detail;
      $this->blade->render('myadmin.lessons', $data);
    }
    
    public function add_lesson($id) {
      // Security for xss_clean
  		$this->load->helper('security');
  		$this->load->helper('form');
  		$this->load->library('form_validation');
      
      // set rules for login form
  		$this->form_validation->set_rules('title', '', 'trim|required|xss_clean');
      $this->form_validation->set_rules('course_id', '', 'trim|required|xss_clean|numeric|max_length[1]');
  		$this->form_validation->set_rules('order', '', 'trim|required|xss_clean|numeric');
      $this->form_validation->set_rules('time', '', 'trim|required|xss_clean|numeric');
      $this->form_validation->set_rules('description', '', 'trim|required|xss_clean');
      $this->form_validation->set_rules('point', '', 'trim|required|xss_clean|numeric');
      $this->form_validation->set_rules('video_url', '', 'trim|required|xss_clean');
      $this->form_validation->set_rules('free', '', 'trim|required|xss_clean|numeric|max_length[1]');
      $this->form_validation->set_rules('difficulty', '', 'trim|required|xss_clean|numeric|max_length[1]');
      
      if ($this->form_validation->run() == TRUE) {
  			//DBの○○テーブルにINSERTする
        $post_data = $this->input->post();
        $this->lesson->insert_lesson($post_data);
        redirect('/adm/lessons/' . $id);
  		}
      
      $data = array();
      $data['id'] = $id;
      $this->blade->render('myadmin.add_lesson', $data);
    }
    
    public function delete_lesson($id) {
      //レッスンの削除
      $ci = CI_Controller::get_instance();
      $ci->db->where('id', $id);
  		$ci->db->update('lessons', ['deleted' => TRUE]);
      redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function edit_lesson($id) {
      // Security for xss_clean
  		$this->load->helper('security');
  		$this->load->helper('form');
  		$this->load->library('form_validation');
      
      // set rules for login form
  		$this->form_validation->set_rules('title', '', 'trim|required|xss_clean');
      $this->form_validation->set_rules('course_id', '', 'trim|required|xss_clean|numeric|max_length[1]');
  		$this->form_validation->set_rules('order', '', 'trim|required|xss_clean|numeric');
      $this->form_validation->set_rules('time', '', 'trim|required|xss_clean|numeric');
      $this->form_validation->set_rules('description', '', 'trim|required|xss_clean');
      $this->form_validation->set_rules('point', '', 'trim|required|xss_clean|numeric');
      $this->form_validation->set_rules('video_url', '', 'trim|required|xss_clean');
      $this->form_validation->set_rules('free', '', 'trim|required|xss_clean|numeric|max_length[1]');
      $this->form_validation->set_rules('difficulty', '', 'trim|required|xss_clean|numeric|max_length[1]');
      
      if ($this->form_validation->run() == TRUE) {
        $ci = CI_Controller::get_instance();
        $ci->db->where('id', $id);
        $edit_data = [
    			'title' => $this->input->post('title'),
    			'course_id' => $this->input->post('course_id'),
    			'order' => $this->input->post('order'),
    			'time' => $this->input->post('time'),
    			'description' => $this->input->post('description'),
    			'point' => $this->input->post('point'),
    			'created_at'=>date('Y-m-d H:i:s'),
          'updated_at'=>date('Y-m-d H:i:s'),
          'video_url' => $this->input->post('video_url'),
          'free' => $this->input->post('free'),
          'difficulty' => $this->input->post('difficulty'),
          'deleted' => $this->input->post('deleted')
    		];
    		$ci->db->update('lessons', $edit_data);
        redirect($this->session->userdata('prev_url'));
  		}
      //前画面のURLをセッションに保存
      if(count($this->input->post()) == 0){
        $this->session->set_userdata('prev_url', $_SERVER['HTTP_REFERER']);
      }
      //レッスン情報の取得
      $query = $this->db->select('*')
              ->from('lessons')
              ->where('id', $id)
              ->get();
      $detail = $query->result();
      $data = array();
      $data['id'] = $id;
      $data['lesson'] = $detail[0];
      $this->blade->render('myadmin.edit_lesson', $data);
      
    }
}