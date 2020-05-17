<?php

class SkillSeeder extends Seeder {
    public function run() {
        $this->db->truncate('skills');
        $skills = [
            [
                'name'=>'TypeScript',
                'image'=>'skill-typeScript.jpg',
                'description'=>'description...'
            ],
            [
                'name'=>'Puppeteer',
                'image'=>'skill-puppeteer.jpg',
                'description'=>'description...'
            ],
            [
                'name'=>'Laravel',
                'image'=>'skill-laravel.jpg',
                'description'=>'description...'
            ],
            [
                'name'=>'Electron',
                'image'=>'skill-electron.jpg',
                'description'=>'description...'
            ],
            [
                'name'=>'Vue.js',
                'image'=>'skill-vue.jpg',
                'description'=>'description...'
            ],
        ];
        $this->db->insert_batch('skills',$skills);

        $this->db->truncate('skills_courses');
        for($i=1; $i <= 5; $i++){
            for($j=0; $j <= 8; $j++) {
                $data = [
                    'skill_id'=>$i,
                    'course_id'=>rand(1,6),
                    'order'=>$j
                ];
                $this->db->query('INSERT IGNORE skills_courses (`skill_id`,`course_id`,`order`)
                    VALUES('.$data['skill_id'].','.$data['course_id'].','.$data['order'].')');
            }
        }
        $this->db->truncate('skills_lessons');
        for($i=1; $i <= 5; $i++){
            $rand_j = rand(6,15);
            for($j=0; $j <= $rand_j; $j++) {
                $data = [
                    'skill_id'=>$i,
                    'lesson_id'=>rand(1,37),
                    'order'=>$j
                ];
                $this->db->query('INSERT IGNORE skills_lessons (`skill_id`,`lesson_id`,`order`)
                        VALUES('.$data['skill_id'].','.$data['lesson_id'].','.$data['order'].')');
            }
        }
    }
}