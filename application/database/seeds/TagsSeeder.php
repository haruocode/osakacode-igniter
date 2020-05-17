<?php

class TagsSeeder extends Seeder {
    public function run() {
        $this->db->truncate('tags');
        $tags = json_decode(file_get_contents(APPPATH . 'database/seeds/data/tags.txt'));
        foreach($tags as $tag) {
            $this->db->insert('tags',[
                'name'=>$tag
            ]);
        }
    }
}