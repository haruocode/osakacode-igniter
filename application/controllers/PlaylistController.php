<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlaylistController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('playlist_model', 'playlist');
        !check_logged() ? redirect('') : [];
    }

    public function favorites()
    {
        $this->current_menu = 'favorites';

        $data_list = $this->playlist->getPlaylist([
            'user_id' => $this->session->userdata('id'),
            'playlist_type' => PLAYLIST_FAVORITES_TYPE
        ]);

        $playlist = $this->_getPlaylist($data_list);
        $data_view = [
            'type' => 'favorite',
            'playlist' => $playlist,
            'current_menu' => $this->current_menu,
        ];
        $this->blade->render('front.playlist', $data_view);
    }

    public function saves()
    {
        $this->current_menu = 'saves';

        $data_list = $this->playlist->getPlaylist([
            'user_id' => $this->session->userdata('id'),
            'playlist_type' => PLAYLIST_WATCH_LATER_TYPE
        ]);

        $playlist = $this->_getPlaylist($data_list);
        $data_view = [
            'type' => 'saves',
            'playlist' => $playlist,
            'current_menu' => $this->current_menu,
        ];
        $this->blade->render('front.playlist', $data_view);
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
}