<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LessonController extends MY_Controller
{
    protected $limit = 30;
    protected $total_record = 0;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('lesson_model','lessons');
        $this->load->model('playlist_model','playlist');
        $this->load->model('tag_model','tags');
        $this->load->model('series_model','series');
        $this->load->model('user_model','user');
    }

    public function index()
    {
        $this->current_menu = 'lessons';

        $page = intval($this->input->get('page',TRUE));
        $page = $page > 1 ? $page : 1;
        $filters = [
            'difficulty'=>$this->input->get('difficulty',TRUE),
            'type'=>$this->input->get('type',TRUE),
            'length'=>$this->input->get('length',TRUE)
        ];
        if($filters['difficulty'] !== NULL) {
            $filters['difficulty'] = intval($filters['difficulty']);
        }
        //set filter
        $this->_queryGetList($filters);
        //count record
        $this->_countTotalRecord();
        //check page
        $total_page = ceil($this->total_record / $this->limit);
        $page = $page <= $total_page ? $page : $total_page;
        //pagination
        //TODO : create two buttons
        $next_page = $page < $total_page ? $page + 1 : NULL;
        $prev_page = $page > 1 ? $page - 1 : NULL;

        //set filter to init again and get list data
        $this->_queryGetList($filters);
        $list_lessons = [];
        foreach($this->_getList($page) as $lesson) {
            $lesson->status = 0;
            $list_lessons[intval($lesson->id)] = $lesson;
        }
        $this->_attachLessonStatus($list_lessons);
//        d($list_lessons);
        $isset_filter = $filters['difficulty'] || $filters['type'] || $filters['length'];
        $filter_string = '';
        foreach($filters as $k=>$v) {
            if($v) {
                $filter_string = '?' . $k.'='.$v;
            }
        }
        $url_with_filter_string = uri_string() . $filter_string;

        //parse data for view
        $data_view = [
            'head_title' => '個別レッスン一覧',
            'head_keyword' => 'プログラミング,動画,チュートリアル,講座,レッスン,学習',
            'head_desc' => '新着レッスンなどの特定の動画をお探しでしたらこちらからどうぞ。',
            'filters'=>$filters,
            'list_lessons'=> $list_lessons,
            'page'=>$page,
            'first_page_url'=>$page > 1 ? $url_with_filter_string . ($isset_filter ? '&' : '?') .'page=1' : '',
            'last_page_url'=>$page < $total_page ? $url_with_filter_string . ($isset_filter ? '&' : '?') .'page='.$total_page : '',
            'next_page'=>$next_page,
            'prev_page'=>$prev_page,
            'next_page_url'=>$next_page ? $url_with_filter_string . ($isset_filter ? '&' : '?') .'page=' . $next_page : '',
            'prev_page_url'=>$prev_page ? $url_with_filter_string . ($isset_filter ? '&' : '?') .'page=' . $prev_page : '',
            'total_page'=>$total_page,
            'current_menu' => $this->current_menu,
        ];
        
        
        //check pjax
        if($this->is_pjax) {
            $this->blade->render('front.includes.lessons.main',$data_view);
        }else{
            $this->blade->render('front.lessons',$data_view);
        }
    }



    protected function _queryGetList($filter)
    {
        if($filter['difficulty'] !== NULL) {
            switch($filter['difficulty']) {
                case DIFFICULTY_BEGINNER:
                    $this->lessons->where('difficulty',DIFFICULTY_BEGINNER);
                    break;
                case DIFFICULTY_INTERMEDIATE:
                    $this->lessons->where('difficulty',DIFFICULTY_INTERMEDIATE);
                    break;
                case DIFFICULTY_ADVANCED:
                    $this->lessons->where('difficulty',DIFFICULTY_ADVANCED);
                    break;
            }
        }
        if($filter['type'] !== NULL) {
            switch($filter['type']) {
                case 'episode':
                    $this->lessons->where('course_id >',0);
                    break;
                case 'lesson':
                    $this->lessons->where('course_id',[NULL,0]);
                    break;
            }
        }
        if($filter['length'] !== NULL) {
            switch($filter['length']) {
                case 'short':
                    $this->lessons->where('time <= ', 10 * 60);
                    break;
                case 'medium':
                    $this->lessons->where('time > ', 10*60)->where('time <=', 20 * 60);
                    break;
                case 'long':
                    $this->lessons->where('time > ', 20*60);
                    break;
            }
        }

        $this->lessons
            ->with_courses()
            ->order_by('updated_at','DESC');
    }

    protected function _countTotalRecord() {
        $this->total_record = $this->lessons->count();
    }

    protected function _getList($page = 1) {
        $page = $page > 1 ? $page : 1;
        $list = $this->lessons->paginate($this->limit, null, $page);
        return $list ? $list : [];
    }

    public function getSingleLesson($id)
    {
        $lesson_id = intval($id);
        $lessons = $this->lessons
                        ->with_courses()
                        ->where(['id'=>$lesson_id])
                        ->get();
        $lessons->tags = $this->_getTags($lessons->id);
        if(check_logged()) {
            $lessons->completed = $this->_getLessonStatus($lessons->id);
            $lessons->in_watch_later = $this->playlist->checkInPlaylist([
                'object_id'=>$lessons->id,
                'user_id'=>$this->session->userdata('id'),
                'object_type'=>PLAYLIST_OBJECT_TYPE_LESSON,
                'playlist_type'=>PLAYLIST_WATCH_LATER_TYPE
            ]);
            $lessons->in_favorite = $this->playlist->checkInPlaylist([
                'object_id'=>$lessons->id,
                'user_id'=>$this->session->userdata('id'),
                'object_type'=>PLAYLIST_OBJECT_TYPE_LESSON,
                'playlist_type'=>PLAYLIST_FAVORITES_TYPE
            ]);
            $lessons->canSee = $this->_getSeeableStatus($lessons->id, $this->session->userdata['id']);
        }
        $data_view = [
            'lessons'=>$lessons,
        ];
        $this->blade->render('front.lesson_single',$data_view);
    }

    public function getEpisodeLesson($course_id, $episode)
    {
        $course_id = intval($course_id);
        $episode = intval($episode);
        //get series detail
        $series = $this->series->fields('id,title,image')
                        ->with_lessons()
                        ->where('id = ', intval($course_id))
                        ->get();
        if (check_logged() && $series->lessons) {
            foreach ($series->lessons as $lesson) {
                //set status for lesson
                $lesson->status = 0;
                //set in watch later status
                $lesson->in_watch_later = 0;
                $list_lessons[$lesson->id] = $lesson;
            }
            //add lesson status complete - incomplete
            $this->_attachLessonStatus($list_lessons);
            //add lesson watch later status
            $this->_attachLessonWatchLaterStatus($list_lessons);
            $series->lessons = $list_lessons;
        }

        $lessons = $this->lessons
                        ->with_courses()
                        ->where(['course_id'=>$course_id, 'order'=>$episode])
                        ->get();
        $lessons->tags = $this->_getTags($lessons->id);
        if(check_logged()) {
            $lessons->completed = $this->_getLessonStatus($lessons->id);
            $lessons->in_watch_later = $this->playlist->checkInPlaylist([
                'object_id'=>$lessons->id,
                'user_id'=>$this->session->userdata('id'),
                'object_type'=>PLAYLIST_OBJECT_TYPE_LESSON,
                'playlist_type'=>PLAYLIST_WATCH_LATER_TYPE
            ]);
            $lessons->in_favorite = $this->playlist->checkInPlaylist([
                'object_id'=>$lessons->id,
                'user_id'=>$this->session->userdata('id'),
                'object_type'=>PLAYLIST_OBJECT_TYPE_LESSON,
                'playlist_type'=>PLAYLIST_FAVORITES_TYPE
            ]);
            $lessons->canSee = $this->_getSeeableStatus($lessons->id, $this->session->userdata['id']);
        }

        $data_view = [
            'head_title'=>$lessons->title . '(' . $series->title . ')',
            // 'head_keyword'=>$lessons->keyword,
            'head_desc'=>$lessons->description,
            'lessons'=>$lessons,
            'series'=>$series
        ];
        $this->blade->render('front.lesson_detail',$data_view);
    }

    public function completeLesson()
    {
        $lesson_id = intval($this->input->post('lesson-id',TRUE));
        $array_return = array(
            'success'=>0,
            'error'=>0,
            'msg'=>''
        );
        $statusToggle = 0;
        //check user login
        if(!check_logged()) {
            $array_return['error'] = 1;
            $array_return['msg'] = 'Not logged';
            echo json_encode($array_return);
            die();
        }
        if($lesson_id <= 0) {
            $array_return['error'] = 1;
            $array_return['msg'] = 'Lesson is not valid';
            echo json_encode($array_return);
            die();
        }
        //lay info user
        $user_id = $this->session->userdata('id');
        $user_exp = CommonService::get_instance()->user_exp();
        $exp_lesson = $this->lessons->get_lesson_info($lesson_id)[0]->point;
        //update table users_lessons

        $query_check = $this->db
                ->select('*')
                ->from('users_lessons')
                ->where('user_id', $user_id)
                ->where('lesson_id', $lesson_id)->get();

        if(count($query_check->result())>0){
            $sql_delete = "DELETE FROM users_lessons
                       WHERE user_id = {$user_id}
                       AND lesson_id = {$lesson_id}";
            $query = $this->db->query($sql_delete);
            $this->user->update_exp($user_id, $user_exp - $exp_lesson);
            $statusToggle = 0; // lesson marked as incompleted
        } else{
            $sql_insert = "INSERT INTO users_lessons(user_id, lesson_id, status)
                       VALUES({$user_id},{$lesson_id}, 1)";
            $query = $this->db->query($sql_insert);
            $this->user->update_exp($user_id, $user_exp + $exp_lesson);
            $statusToggle = 1; // lesson marked as completed
        }
        
        if($query) {
            $array_return['success'] = 1;
            if($statusToggle == 1)
                $array_return['msg'] = 'レッスンが完了しました!';
            else
                $array_return['msg'] = 'レッスンを未完了に変更しました';
            echo json_encode($array_return);
            die();
        }
    }

    public function saveLessonToWatchLater()
    {
        $array_return = array(
            'success'=>0,
            'error'=>0,
            'msg'=>''
        );
        if(!check_logged()) {
            $array_return['error'] = 1;
            $array_return['msg'] = 'Not logged';
            echo json_encode($array_return);die();
        }
        $playlist_type = PLAYLIST_WATCH_LATER_TYPE;
        $object_id = intval($this->input->post('objectId',TRUE));
        $object_type = PLAYLIST_OBJECT_TYPE_LESSON;
        $data_insert = [
            'object_id'=>$object_id,
            'user_id'=>$this->session->userdata('id'),
            'object_type'=>$object_type,
            'playlist_type'=>$playlist_type
        ];
        $playlist_result = $this->playlist->addPlaylist($data_insert);
        if($playlist_result == 'added') {
            $array_return['success'] = 1;
            $array_return['msg'] = trans('front.alert_msg.added_watch_later');
            echo json_encode($array_return);die();
        }else {
            $array_return['success'] = 1;
            $array_return['msg'] = trans('front.alert_msg.removed_watch_later');
            echo json_encode($array_return);die();
        }
    }
    public function favoriteLesson(){
        $array_return = array(
            'success'=>0,
            'error'=>0,
            'msg'=>''
        );
        if(!check_logged()) {
            $array_return['error'] = 1;
            $array_return['msg'] = 'Not logged';
            echo json_encode($array_return);die();
        }
        $playlist_type = PLAYLIST_FAVORITES_TYPE;
        $object_id = intval($this->input->post('objectId',TRUE));
        $object_type = PLAYLIST_OBJECT_TYPE_LESSON;
        $data_insert = [
            'object_id'=>$object_id,
            'user_id'=>$this->session->userdata('id'),
            'object_type'=>$object_type,
            'playlist_type'=>$playlist_type
        ];
        $playlist_result = $this->playlist->addPlaylist($data_insert);
        if($playlist_result == 'added') {
            $array_return['success'] = 1;
            $array_return['msg'] = trans('front.alert_msg.added_favorite');
            echo json_encode($array_return);die();
        }else {
            $array_return['success'] = 1;
            $array_return['msg'] = trans('front.alert_msg.removed_favorite');
            echo json_encode($array_return);die();
        }
    }

    protected function _getTags($lesson_id) {
        $list_tag_id = [];
        $list_tag = $this->db->select('tag_id')
                        ->from('lessons_tags')
                        ->where('lesson_id',intval($lesson_id))
                        ->get();
        foreach($list_tag->result() as $row) {
            $list_tag_id[] = $row->tag_id;
        }
        if (!empty($list_tag_id)){
            $list_tags = $this->tags->where('id',$list_tag_id)->get_all();
        } else{
            $list_tags = [];
        }
        return $list_tags;
    }

    protected function _getLessonStatus($lesson_id) {
        if(!check_logged()) {
            return false;
        }
        $status = $this->db->select('status')
                            ->from('users_lessons')
                            ->where([
                                'lesson_id'=>$lesson_id,
                                'user_id'=>$this->session->userdata('id')
                            ])->get()->row();
        return $status ? $status->status : 0;
    }

    protected function _getSeeableStatus($lesson_id, $user_id)
    {
        if (!check_logged()) {
            return FALSE;
        }

        $query = $this->db->select('plan_id')
                ->from('users')
                ->where('id', $user_id)
                ->get();

        $plan_id = $query->result()[0]->plan_id;

        if($plan_id == NULL) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
