<?php

class TestUserSeeder extends Seeder {
	public function run() {
		$this->db->truncate('users');
		$data = [
			'username' => 'root',
			'password' => password_hash('123456', PASSWORD_DEFAULT),
			'email' => 'root@123.com',
			'plan_id' => '2',
			'exp' => '1000',
			'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
		];
		$this->db->insert('users', $data);
		$password = password_hash('123456', PASSWORD_DEFAULT);
		for($i = 0; $i < 300; $i++) {
			$data = [
				'username' => str_shuffle('aghkdecl') . $i,
				'password' => $password,
				'email' => 'test+'.$i.'@mail.com',
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=>date('Y-m-d H:i:s')
			];
			$this->db->insert('users', $data);
		}
	}
}