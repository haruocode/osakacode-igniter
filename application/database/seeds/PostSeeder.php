<?php

class PostSeeder extends Seeder {
    public function run() {
        $this->db->truncate('posts');
        $arrayPost = file_get_contents(APPPATH . 'database/seeds/data/post.txt');
        $contents = explode('|',$arrayPost);
        //insert 300 post
        for($i = 0; $i < 300; $i ++) {
            $discussId = rand(1,19);
            $userId = rand(1,300);
            $content = $contents[rand(0,count($contents) - 1)];
            $created_at = time() - rand(0, 86400 * 100);
            $updated_at = $created_at;
            $this->db->insert('posts',[
                'user_id'=>$userId,
                'discussion_id'=>$discussId,
                'content'=>$content,
                'created_at'=>$created_at,
                'updated_at'=>$updated_at
            ]);
        }
    }
}