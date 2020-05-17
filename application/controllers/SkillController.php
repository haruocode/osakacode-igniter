<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SkillController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('skill_model','skill');
        $this->load->model('series_model','series');
        $this->load->model('lesson_model','lesson');
    }

    public function index($id)
    {
        $id = intval($id);
        $skill_data = $this->skill->get($id);
        if(!$skill_data) {
            show_404();
        }

        $this->current_menu = url_title($skill_data->name, '-', TRUE);

        $list_lessons = [];


        //get list series from list id
        $query = $this->db->select('course_id')
                        ->order_by('order','ASC')
                        ->get_where('skills_courses', ['skill_id'=>$id]);
        $list_id = [];
        foreach($query->result() as $id_item) {
            $list_id[] = $id_item->course_id;
        } 
        $list_series = $this->series->get_simple_list_by_id($list_id);
        
        foreach ($list_series as $series) {
            $series->status = $this->_getSeriesStatus($series->id);
        }

        //get list lessons from list id
        $query = $this->db->select('lesson_id')->get_where('skills_lessons', ['skill_id'=>$id]);
        $list_id = [];
        foreach($query->result() as $id_item) {
            $list_id[] = $id_item->lesson_id;
        }
        $list_lessons = $this->lesson->get_simple_list_by_id($list_id);

        if($list_lessons) {
            foreach ($list_lessons as $lesson) {
                //set status for lesson
                $lesson->status = 0;
                //set in watch later status
                $lesson->in_watch_later = 0;
                $list_lessons_view[$lesson->id] = $lesson;
            }
            //add lesson status complete - incomplete
            $this->_attachLessonStatus($list_lessons_view);
            //add lesson watch later status
            $this->_attachLessonWatchLaterStatus($list_lessons_view);
            // $detail->lessons = $list_lessons;
        }

        $data_view = [
            'head_title' => $skill_data->name,
            // 'head_keyword' => $skill_data->keyword,
            'head_desc' => $skill_data->description,
            'class_body'=>'skill',
            'skill'=>$skill_data,
            'list_series'=>$list_series,
            'list_lessons'=>$list_lessons_view,
            'count_series'=>count($list_series),
            'count_lessons'=>count($list_lessons),
            'current_menu'=>$this->current_menu,
        ];

        $this->blade->render('front.skills', $data_view);
    }

    private function _getSeriesStatus($series_id)
    {
        $query = $this->db->select('*')
                ->from('lessons')
                ->where('course_id', $series_id)
                ->get();
        $lessons = $query->result();

        $list_lessons = array();

        foreach ($lessons as $lesson) {
            $list_lessons[$lesson->id] = $lesson;
        }

        $this->_attachLessonStatus($list_lessons);

        $total_lessons = count($list_lessons);
        $completed_lessons = 0;

        foreach ($list_lessons as $lesson) {
            if(isset($lesson->status) && $lesson->status) {
                $completed_lessons++;
            }
        }

        if($total_lessons) {
            $percentage = round(($completed_lessons/$total_lessons)*100);    
        } else {
            $percentage = 0;
        }

        if ($percentage == 0) {
            $status = '未完了';
        } else if ($percentage == 100) {
            $status = '完了';
        } else {
            $status = '進捗率: '.$percentage.'%';
        }
        
        return $status;
    }
}