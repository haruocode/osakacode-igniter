<?php

class LessonSeeder extends Seeder {
    public function run() {
        $this->db->truncate('lessons');
        $data = [
            'title' => '1.その登場の背景 | TypeScript入門講座',
            'course_id'=>1,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=dCIiJ0ZdNhI',
            'free'=>1,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => '2.準備 | TypeScript入門講座',
            'course_id'=>1,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=Fn3Drz9-rTE',
            'free'=>1,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => '3.TypeScriptの花形 | TypeScript入門講座',
            'course_id'=>1,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=QljZN2j9tB4',
            'free'=>1,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => '4.型アノテーション | TypeScript入門講座',
            'course_id'=>1,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=bv9rS1Lv-Dw',
            'free'=>0,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => '5.型を使ってみよう | TypeScript入門講座',
            'course_id'=>1,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=Tmg_a67Ehes',
            'free'=>0,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);

        $data = [
            'title' => 'フリーエンジニアとは何か | 大阪フリーエンジニア講座１',
            'course_id'=>2,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=w9a3II6HUvo',
            'free'=>1,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => '大阪の月単価相場(主にLAMP環境) | 大阪フリーエンジニア講座２',
            'course_id'=>2,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=EN_k0G78xoM',
            'free'=>1,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => 'エージェントについて | 大阪フリーエンジニア講座３',
            'course_id'=>2,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=4KQqygT9EVM',
            'free'=>1,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => '面談した感想(PHP＆フロントエンド) | 大阪フリーエンジニア講座４',
            'course_id'=>2,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=NyiCIiaE48w',
            'free'=>0,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => '開発実務体験談(LAMP,VueJS) | 大阪フリーエンジニア講座５',
            'course_id'=>2,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=a8vcrRN02SI',
            'free'=>0,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);

        $data = [
            'title'=> 'Puppeteer入門講座１「Puppeteerとは何か」',
            'course_id'=> 3,
            'order'=>0,
            'time'=>356,
            'description'=>'This is a description...',
            'point'=>110,
            'video_url'=>'https://www.youtube.com/watch?v=CDtJc_xhvW0',
            'free'=>1,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => 'Puppeteer入門講座２「インストール」',
            'course_id'=>3,
            'order'=>1,
            'time'=>830,
            'description'=>'This is a description...',
            'point'=>110,
            'video_url'=>'https://www.youtube.com/watch?v=T2M5d-_c9ew',
            'free'=>1,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => 'puppeteer入門講座３「サンプルコードを実行してみる(基本編)」',
            'course_id'=>3,
            'order'=>1,
            'time'=>1044,
            'description'=>'This is a description...',
            'point'=>120,
            'video_url'=>'https://www.youtube.com/watch?v=9tHXBWlfScE',
            'free'=>0,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => 'puppeteer入門講座４「サンプルコードを実行してみる(検索編)」',
            'course_id'=>3,
            'order'=>1,
            'time'=>607,
            'description'=>'This is a description...',
            'point'=>120,
            'video_url'=>'https://www.youtube.com/watch?v=FZ_qxb6CcZ0',
            'free'=>0,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);

        $data = [
            'title' => 'Laravel入門 その1「開発環境を整える(XAMMP編)」',
            'course_id'=>4,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=p1bGCZkz25c',
            'free'=>1,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => 'Laravel入門 その2「ルーティング」',
            'course_id'=>4,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=iydjREwuaTc',
            'free'=>1,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => 'Laravel入門 その3「コントローラーとビューの基本」',
            'course_id'=>4,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=1uOavQlUFt8',
            'free'=>1,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => 'Laravel入門 その4「Bladeテンプレートエンジン(1)」',
            'course_id'=>4,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=fkpnf_VLATQ',
            'free'=>0,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => 'Laravel入門 その5「Bladeテンプレートエンジン(2)」',
            'course_id'=>4,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=UcCm4-lHq7M',
            'free'=>0,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);

        $data = [
            'title' => 'Electron入門１「Electronについてざっくり説明」',
            'course_id'=>5,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=n-BPQBuItI8',
            'free'=>1,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => 'Electron入門２「インストールと最小アプリの作成」',
            'course_id'=>5,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=sYbIgLKQu7g',
            'free'=>1,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => 'Electron入門３「VueJSを組み合わせて開発する準備」',
            'course_id'=>5,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=e2Dy0Eu13J0',
            'free'=>1,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => 'Electron入門４「ブックマークアプリを作る(１)」',
            'course_id'=>5,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=Q812p-xLWu8',
            'free'=>0,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => 'Electron入門５「ブックマークアプリを作る(2)」',
            'course_id'=>5,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=-Yy3z42EFQM',
            'free'=>0,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);

        $data = [
            'title' => 'VueJS入門その1「インストールする」',
            'course_id'=>6,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=rfZfrNmIiJk',
            'free'=>1,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => 'VueJS入門その2「dataプロパティとオブジェクト」',
            'course_id'=>6,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=qip5F5v8f7s',
            'free'=>1,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => 'VueJS入門その3「v-forでデータをループ表示させる」',
            'course_id'=>6,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=Ot1lqLtlNyI',
            'free'=>1,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => 'VueJS入門その4「v-onとmethodsでイベント発生時の関数実行」',
            'course_id'=>6,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=6DtlZSvbUhs',
            'free'=>0,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        $data = [
            'title' => 'VueJS入門その5「v-bindによる属性バインディング」',
            'course_id'=>6,
            'order'=>1,
            'time'=>578,
            'description'=>'This is a description...',
            'point'=>200,
            'video_url'=>'https://www.youtube.com/watch?v=m4XadtjceFc',
            'free'=>0,
            'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
            'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
        ];
        $this->db->insert('lessons',$data);
        
        $title_array = [
            '1ヵ月間リモートワークした感想(客先常駐案件)',
            'チャンネル登録者数1000人ありがとうございます。',
            '[Q&A]質問への回答',
            '質問を募集します！',
            'フロントエンドエンジニアになるための９つのスキル',
            '【ご意見募集】次はどんな講座がいいですか？',
            'ご意見ありがとうございます！'
        ];
        for($i = 0; $i < 7; $i++) {
            $data = [
                'title' => $title_array[$i],
                'course_id'=>0,
                'order'=>$i + 1,
                'time'=>rand(300,1000),
                'description'=>'This is a description...',
                'point'=>rand(100,200),
                'video_url'=>'https://www.youtube.com/watch?v=rfZfrNmIiJk',
                'free'=>1,
                'created_at'=>date('Y-m-d H:i:s', time() - rand(6000, 10000)),
                'updated_at'=>date('Y-m-d H:i:s', time() - rand(60, 5000))
            ];
            $this->db->insert('lessons',$data);
        }
    }
}