<?php
class ChannelSeeder extends Seeder {
    public function run() {
        $this->db->truncate('channels');
        $channels = [
            'Code Review',
            'Elixir',
            'Eloquent',
            'Envoyer',
            'Forge',
            'General',
            'Laravel',
            'Lumen',
            'Request',
            'Server'
        ];
        foreach ($channels as $channel) {
            $data = [
                'name'=>$channel,
                'created_at'=>time(),
                'updated_at'=>time(),
            ];
            $this->db->insert('channels',$data);
        }
    }
}