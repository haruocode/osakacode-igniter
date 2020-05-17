<?php

/**
 * Created by PhpStorm.
 * User: Administrator PC
 * Date: 12/8/2015
 * Time: 9:40 AM
 */
class LessonsTagsSeeder extends Seeder
{
    public function run() {
        $this->db->truncate('lessons_tags');
        for($i = 0; $i < 400; $i++) {
            $this->db->insert('lessons_tags',[
                'tag_id'=>rand(1,110),
                'lesson_id'=>rand(1,37)
            ]);
        }
    }
}