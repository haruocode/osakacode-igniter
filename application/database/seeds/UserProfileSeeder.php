<?php 

class UserProfileSeeder extends Seeder {
	public function run() {
		$this->db->truncate('users_profile');
		$data = [
			'user_id' => '2',
			'avatar' => 'abc.jpg',
			'website' => 'https://www.youtube.com/channel/UCQrojA1eV9Vb8FekN_N0rjQ/',
			'twitter' => 'twitter/haruocode', 
			'github' => 'github/haruocode',
			'work_place' => 'Osaka',
			'job_title' => 'Dev',
			'country' => 'Japan',
			'hometown' => 'Osaka',
			'can_hire' => '0',
			'public_profile' => '0',
			'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
		];
		$this->db->insert('users_profile', $data);
	}
}