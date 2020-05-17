<?php

class Invoice_model extends MY_model {
	public function __construct() {
		parent:: __construct();
		$this->load->database();
	}

	public function get_all_invoice ($user_id){
		$query = $this->db->get_where('invoice', ['user_id' => $user_id]);
		$this->db->from('invoice');
		$this->db->where('user_id', $user_id);
		return [
			'invoices_data' => $query->result(),
			'num_of_data' => ($query->result()!==NULL) ? $this->db->count_all_results(): 0,
		];
	}

	public function get_plan_from_invoice($plan_id){
		$query = $this->db->get_where('plans', ['id' => $plan_id]);
		return $query->result();
	}

	public function get_one_invoice ($invoice_id) {
		$query = $this->db->get_where('invoice', ['id' => $invoice_id]);
		return $query->result();
	}

	public function get_invoice_by_invoiceid($invoice_id){
		$query = $this->db->get_where('invoice', ['invoice_id' => $invoice_id]);
		return $query->result();
	}

	public function insert_invoice($plan_id, $user_id){

		$data_invoice_db = [
			'user_id' => $user_id,
			'plan_id' => $plan_id,
			'status' => 1,
			'quantity' => 1,
			'invoice_id' => uniqid(),
			'created_at'=>date('Y-m-d H:i:s'),
			'updated_at'=>date('Y-m-d H:i:s')
		];

		$this->db->insert('invoice', $data_invoice_db);
	}
}