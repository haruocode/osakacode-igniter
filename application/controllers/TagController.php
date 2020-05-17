<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TagController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tag_model', 'tags');
    }

    public function index()
    {
        $this->current_menu = 'tag';
        $list_tags = $this->tags->order_by('name', 'ASC')->get_all();
        foreach ($list_tags as $index => $tag) {
            //count lesson with tag
            $count = $this->db->query('SELECT count(*) as count FROM lessons_tags WHERE tag_id = ' . $tag->id)->row();
            $tag->count_lesson = isset($count) ? $count->count : 0;
            if (!$tag->count_lesson) {
                unset($list_tags[$index]);
            }
        }
        $data_view = [
            'head_title'=>'タグ一覧',
            'head_keyword'=>'プログラミング,レッスン,チュートリアル,動画,タグ',
            'head_desc'=>'レッスン動画についているタグ別に並べています。',
            'list_tags' => $list_tags,
            'current_menu' => $this->current_menu,
        ];
        $this->blade->render('front.tags', $data_view);
    }

    public function detail($tag_id)
    {
        if(!$tag_id) {
            return false;
        }
        $tags = $this->tags->where(['id'=>$tag_id])->get();
        $list_lessons = $this->_getLessonList($tag_id);
        $this->_attachLessonStatus($list_lessons);
        $data_view = [
            'tags'=>$tags,
            'list_lessons'=>$list_lessons
        ];
        $this->blade->render('front.tags_detail',$data_view);
    }

    protected function _getLessonList($tag_id) {
        $query = $this->db->select('lesson_id')
                            ->from('lessons_tags')
                            ->where('tag_id',$tag_id)
                            ->get();
        $list_id = [];
        foreach($query->result() as $row) {
            $list_id[] = $row->lesson_id;
        }
        $this->load->model('lesson_model','lessons');
        $lessons = $this->lessons->with_courses()
                        ->where('id',$list_id)
                        ->get_all();
        $list_lessons = [];
        foreach($lessons as $lesson) {
            $lesson->status = 0;
            $list_lessons[$lesson->id] = $lesson;
        }
        return $list_lessons;
    }

}