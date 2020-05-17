<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SeriesController extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('series_model', 'series');
        $this->load->model('playlist_model','playlist');
    }

    public function index()
    {
        $this->current_menu = 'series';
        $is_archived = boolval($this->input->get('archived'));
        $data_view = [
            'head_title' => '講座一覧',
            'head_keyword' => 'プログラミング,講座,一覧',
            'head_desc' => 'プログラミング講座の一覧です。',
            'is_archived' => $is_archived,
            'current_menu' => $this->current_menu,
            'list_cards' => $this->_getList($is_archived)
        ];
        $this->blade->render('front.series', $data_view);
    }

    public function getDetail($course_id)
    {
        $data_view = [
            'head_title' => $this->_getDetail($course_id)->title,
            // 'head_keyword' => $this->_getDetail($course_id)->keyword,
            'head_desc' => $this->_getDetail($course_id)->description,
            'class_body' => 'series',
            'series' => $this->_getDetail($course_id)
        ];
        if (!$data_view['series']) {
            show_404();
        }
        $data_suggest=$this->getLinkRef($data_view['series']->link_id);
        $data_view['data_suggest'] = $data_suggest;

        // Calculate percentage of completion
        $lessons = $data_view['series']->lessons;

        $total_lessons = count($lessons);
        $completed_lessons = 0;

        foreach ($lessons as $lesson) {
            if(isset($lesson->status) && $lesson->status) {
                $completed_lessons++;
            }
        }

        $percentage = round(($completed_lessons/$total_lessons)*100);

        $data_view['percentage'] = $percentage;

        $this->blade->render('front.series_detail', $data_view);
    }

    public function saveSeriesToWatchLater() {
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
        $object_type = PLAYLIST_OBJECT_TYPE_SERIES;
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

    public function favoriteSeries() {
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
        $object_type = PLAYLIST_OBJECT_TYPE_SERIES;
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


    protected function _getList($is_archived)
    {
        $list = $this->series
            ->with_lessons('fields:*count*')
            ->where_archived($is_archived)->get_all();
        return $list ? $list : [];
    }

    protected function _getDetail($course_id)
    {
        $query = $this->db->select('*')
                ->from('courses')
                ->where('id', $course_id)
                ->get();
        $detail = isset($query->result()[0])?$query->result()[0]:null;
        if($detail==null) return null;
        $query2 = $this->db->select('*')
                ->from('lessons')
                ->where('course_id', $detail->id)
                ->order_by('order', 'ASC')
                ->get();
        $lessons_list = $query2->result();
        $detail->lessons = isset($lessons_list) ? $lessons_list : [];

        $list_lessons = [];
        if (check_logged()) {
            //check series in watch later and favorite?
            $detail->in_favorite = $this->playlist->checkInPlaylist([
                'object_id'=>$course_id,
                'user_id'=>$this->session->userdata('id'),
                'object_type'=>PLAYLIST_OBJECT_TYPE_SERIES,
                'playlist_type'=>PLAYLIST_FAVORITES_TYPE
            ]);
            $detail->in_watch_later = $this->playlist->checkInPlaylist([
                'object_id'=>$course_id,
                'user_id'=>$this->session->userdata('id'),
                'object_type'=>PLAYLIST_OBJECT_TYPE_SERIES,
                'playlist_type'=>PLAYLIST_WATCH_LATER_TYPE
            ]);
            if($detail->lessons) {
                foreach ($detail->lessons as $lesson) {
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
                $detail->lessons = $list_lessons;
            }
        }
        return $detail;
    }
    private function getLinkRef($linkarr){
        $linkarr_id=explode(",",$linkarr);
        foreach($linkarr_id as $k=>$value){
            $linkarr_id[$k]=trim($value);
        }
        //Uncomment below to remove the dupticate id if customer want
        //$linkarr_id=array_unique($linkarr_id);
        $listSuggessCourse=[];
        foreach($linkarr_id as $id){
            if(ctype_digit($id)){
                if ($this->_getDetail($id) != null) {
                    $listSuggessCourse[] = $this->_getDetail($id);
                }
            }
                
        }
        //var_dump($listSuggessCourse);die();
        return $listSuggessCourse;
    }
}