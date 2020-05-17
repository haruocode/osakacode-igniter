<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Playlist_model extends MY_Model
{
    public $table = 'playlist';
    
    public $primary_key = 'id';
    
    public function __construct() {
        parent::__construct();
    }

    public function addPlaylist($data) {
        $data = $this->parseInsertData($data);
        //check exists
        $check_exist = $this->count($data);
        if($check_exist) {
            //delete
            $this->delete($data);
            return 'removed';
        }else{
            //insert into playlist
            $this->insert($data);
            return 'added';
        }
    }

    public function getPlaylist($data) {
        $playlist = $this->where($data)->order_by('updated_at', 'DESC')->get_all();
        return $playlist ? $playlist : [];
    }

    public function checkInPlaylist($data) {
        return !!$this->count($this->parseInsertData($data));
    }

    protected function parseInsertData($data) {
        $default = [
            'object_id'=>0,
            'user_id'=>0,
            'object_type'=>0,
            'playlist_type'=>0
        ];
        foreach($default as $k=>$v) {
            if(isset($data[$k])) {
                $default[$k] = $data[$k];
            }
        }
        return $default;
    }
}