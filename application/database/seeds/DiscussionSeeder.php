<?php

class DiscussionSeeder extends Seeder {
    public function run() {
        $this->db->truncate('discussions');
        $str_seed = file_get_contents(APPPATH . 'database/seeds/data/discuss.txt');
        $title_array = explode('|',$str_seed);
        for($i = 0; $i < 300; $i ++) {
            $title = $title_array[rand(0,count($title_array)-1)];
            $title = trim($title);
            if(!$title) continue;
            $data = [
                'title'=>$title,
                'user_id'=>rand(1,300),
                'channel_id'=>rand(1,10),
                'created_at'=>time(),
                'updated_at'=>time()
            ];
            $this->db->insert('discussions',$data);
        }
    }
}