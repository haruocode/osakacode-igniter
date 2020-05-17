<?php 

class TestInvoiceSeeder extends Seeder {
	public function run() {
		$this->db->truncate('invoice');
		$data = [
			'user_id' => '2',
			'description' => 'Extend expire',
			'quantity' => '1',
			'plan_id' => '1',
			'status' => '1',
			'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
		];

		$this->db->insert('invoice', $data);

		$data = [
			'user_id' => '2',
			'description' => 'Extend expire',
			'quantity' => '1',
			'plan_id' => '2',
			'status' => '1',
			'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
		];

		$this->db->insert('invoice', $data);

		$data = [
			'user_id' => '2',
			'description' => 'Extend expire',
			'quantity' => '1',
			'plan_id' => '2',
			'status' => '0',
			'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
		];

		$this->db->insert('invoice', $data);
	}
}