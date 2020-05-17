<?php

class CourseSeeder extends Seeder {

    public function run()
    {
        $this->db->truncate('courses');
        $data = [
            'title'=> 'TypeScript入門講座',
            'difficulty'=>rand(0,2),
            'description'=> 'This is a description...',
            'image'=> 'advanced-eloquent.jpg',
            'featured'=>rand(0,1),
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 12000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(0, 6000))
        ];
        $this->db->insert('courses',$data);
        $data = [
            'title'=> '大阪フリーエンジニア講座',
            'difficulty'=>rand(0,2),
            'description'=> 'This is a description...',
            'image'=> 'incremental-apis.jpg',
            'featured'=>rand(0,1),
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 12000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(0, 6000))
        ];
        $this->db->insert('courses',$data);
        $data = [
            'title'=> 'Puppeteer入門講座',
            'difficulty'=>rand(0,2),
            'description'=> 'This is a description...',
            'featured'=>rand(0,1),
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 12000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(0, 6000))
        ];
        $this->db->insert('courses',$data);
        $data = [
            'title'=> 'Laravel入門講座',
            'difficulty'=>rand(0,2),
            'description'=> 'This is a description...',
            'image'=> 'solid-patterns.jpg',
            'featured'=>rand(0,1),
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 12000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(0, 6000))
        ];
        $this->db->insert('courses',$data);
        $data = [
            'title'=> 'Electron入門講座',
            'difficulty'=>rand(0,2),
            'description'=> 'This is a description...',
            'featured'=>rand(0,1),
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 12000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(0, 6000))
        ];
        $this->db->insert('courses',$data);
        $data = [
            'title'=> 'VueJS入門講座',
            'difficulty'=>rand(0,2),
            'description'=> 'This is a description...',
            'featured'=>rand(0,1),
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 12000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(0, 6000))
        ];
        $this->db->insert('courses',$data);
    }
}