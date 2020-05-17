<?php

class User_history_model extends MY_Model {
    public $table = 'user_history';

    public $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function update_last_login($user_id) {
        //check user_history exists?
        $check = $this->where('user_id',$user_id)->get();
        if(!$check) {
            return $this->insert([
                'user_id'=>$user_id,
                'last_login' => date('Y-m-d H:i:s')
            ]);
        }else{
            return $this->update([
                'user_id'=>$user_id,
                'last_login' => date('Y-m-d H:i:s')
            ],'user_id');
        }
    }
}