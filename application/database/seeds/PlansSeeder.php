<?php

class PlansSeeder extends Seeder {
	public function run(){
		$this->db->truncate('plans');

		$data = [
			'title' => 'monthly',
			'description' => 'Monthly',
			'price' => '690',
			'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
		];
		$this->db->insert('plans', $data);

		$data = [
			'title' => 'yearly',
			'description' => 'Yearly',
			'price' => '7777',
			'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
		];
		$this->db->insert('plans', $data);
	}
}