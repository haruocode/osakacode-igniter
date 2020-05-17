<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
use Solid\Services\HistoryService;
class DashboardController extends MY_Controller {

    private $historyService;

	public function __construct(HistoryService $historyService){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('playlist_model', 'playlist');
        $this->load->model('lesson_model');
        $this->load->model('user_history_model');
		$this->load->model('users_lesson_model', 'users_lesson');
		$this->load->helper('url');
        $this->historyService = $historyService;
        $this->historyService->setUserModel($this->user_history_model);
        $this->historyService->setSession($this->session);
        !check_logged() ? redirect('') : [];
    }

	public function dashboard () {
        $this->current_menu = 'dashboard';

        $user_data = $this->user_model->get_user($this->session->userdata['id']);

        $watch_late_list = $this->playlist->getPlaylist([
            'user_id' => $this->session->userdata('id'),
            'playlist_type' => PLAYLIST_WATCH_LATER_TYPE
        ]);
        $watch_list = $this->_getPlaylist($watch_late_list);

        $recently_favorite_list = $this->playlist->getPlaylist([
            'user_id' => $this->session->userdata('id'),
            'playlist_type' => PLAYLIST_FAVORITES_TYPE
        ]);
        $favorite_list = $this->_getPlaylist($recently_favorite_list);

		$list_lesson_complete = $this->users_lesson->list_recently_complete($user_data->id);
		// var_dump($list_lesson_complete);die();
        $update_list = $this->_getUpdateList();
        $this->_attachLessonStatus($update_list);
        $data_view = [
            'type' => 'saves',
            'updated_list' => $update_list,
            'watch_list' => $watch_list,
            'favorite_list' => $favorite_list,
            'list_lesson_complete' => $list_lesson_complete,
            'current_menu' => $this->current_menu,
        ];
        $this->blade->render('front.dashboard', $data_view);
	}

	protected function _getPlaylist($data_list)
    {
        $playlist = [];
        foreach ($data_list as $item) {
            if ($item->object_type == PLAYLIST_OBJECT_TYPE_LESSON) {
                //select from lesson
                $this->load->model('lesson_model', 'lessons');
                $item->detail = $this->lessons->with_courses()
                    ->where(['id' => $item->object_id])
                    ->get();
            } else {
                //select from series
                $this->load->model('series_model', 'series');
                $item->detail = $this->series->where(['id' => $item->object_id])->get();
            }
            $playlist[] = $item;
        }
        return $playlist;
    }

    /**
     * get the list of updated lesson since last login
     * @limit 60
     */
    protected function _getUpdateList() {
        $last_login = $this->historyService->lastLogin();
        $where_sql = 'created_at >= "' . $last_login . '" OR updated_at >= "' . $last_login . '"';
        $lessons = $this->lesson_model->with_courses()
                        ->where($where_sql,NULL,NULL,FALSE,FALSE,TRUE)
                        ->limit(20)
                        ->get_all();
        $list_lessons = [];
        if(!empty($lessons)){
            foreach($lessons as $lesson) {
                $lesson->status = 0;
                $list_lessons[$lesson->id] = $lesson;
            }
        }
        return $list_lessons;
    }
}