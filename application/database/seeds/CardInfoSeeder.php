<?php

class CardInfoSeeder extends Seeder {
    public function run(){
        $this->db->truncate('card_info');

        $data = [
            'user_id' => '1',
            'user_object' => 'cus_9hk4kg4iU34l1vR',
            'recursion_id' => 'rec_9hk4ooepfaj1bbc',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ];
        $this->db->insert('card_info', $data);

        $data = [
            'user_id' => '2',
            'user_object' => 'cus_9ls9PD8vlbA19Y0',
            'recursion_id' => 'rec_9ls9TLcprfDWb0X',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ];
        $this->db->insert('card_info', $data);
    }
}