<?php

class User_model extends MY_Model
{

	public $table = 'users';

	public $primary_key = 'id';

	public function __construct()
	{
		$this->has_one['plans'] = [
			'foreign_model' => 'Plan_model',
			'foreign_table' => 'plans',
			'foreign_key' => 'id',
			'local_key' => 'plan_id'
		];
		$this->has_one['profile'] = [
			'foreign_model' => 'Profile_model',
			'foreign_table' => 'users_profile',
			'foreign_key' => 'user_id',
			'local_key' => 'id'
		];
		parent::__construct();
	}

	public $validate = [
		['field' => 'username', 'label' => 'Username', 'rules' => 'required|trim'],
		['field' => 'password_create', 'label' => 'Password', 'rules' => 'required|trim|min_length[6]|matches[password_confirmation_create]'],
		['field' => 'password_confirmation_create', 'label' => 'Password', 'rules' => 'required|trim|min_length[6]'],
		['field' => 'email_create', 'label' => 'Email', 'rules' => 'required|trim|valid_email'],
	];

	public function get_user_active()
	{
		$query = $this->where('plan_id', '>', 0)->get();
		return $query;
	}

	public function update_data($data)
	{
		$update = array(
			'username' => $data['username'],
			'email' => $data['email'],
			'updated_at' => date('Y-m-d H:i:s'),
		);
		if ($data['pass1'] != '') {
			$update['password'] = password_hash($data['pass1'], PASSWORD_DEFAULT);
		}
		$this->update($update,['id'=>$data['id']]);
		$ci = CI_Controller::get_instance();
		if (isset($data['show_profile'])) {
			$ci->db->where('user_id', $data['id'])->update('users_profile', [
				'public_profile' => 1,
				'updated_at' => date('Y-m-d H:i:s')
			]);
		} else {
			$ci->db->where('user_id', $data['id'])->update('users_profile', [
				'public_profile' => 0,
				'updated_at' => date('Y-m-d H:i:s')
			]);
		}

		return TRUE;
	}

	public function update_profile_data($data)
	{
		$update = [
			'user_id' => $data['user_id'],
			'country' => $data['country'],
			'website' => $data['website'],
			'twitter' => $data['twitter'],
			'github' => $data['github'],
			'work_place' => $data['employment'],
			'job_title' => $data['job_title'],
			'can_hire' => isset($data['available_for_hire']) ? 1 : 0,
			'hometown' => $data['location'],
			'updated_at' => date('Y-m-d H:i:s'),
		];
		$ci = CI_Controller::get_instance();
		$ci->db->where('user_id', $update['user_id'])->update('users_profile', $update);
		return;
	}

	public function update_exp($user_id, $exp)
	{
		$update = [
			'id' => $user_id,
			'exp' => $exp,
			'updated_at' => date('Y-m-d H:i:s'),
		];
		$ci = CI_Controller::get_instance();
		$ci->db->where('id', $user_id)->update('users', $update);
		return;
	}

	public function find_user($id = FALSE)
	{
		return $this->get(['id' => $id]);
	}

	public function find_user_by_email($email = FALSE)
	{
		return $this->get(['email' => $email]);
	}

	public function validate_password($request_password, $hash_in_database)
	{
		return password_verify($request_password, $hash_in_database);
	}

	public function get_one_plan($user_id)
	{
		$user = $this->get_user($user_id);
		$ci = CI_Controller::get_instance();
		$query = $ci->db->get_where('plans', array('id' => $user->plan_id));
		return $query->result();
	}

	public function get_user($user_id = FALSE)
	{
		$query = $this->get(['id' => $user_id]);
		return $query;
	}

	public function get_card_info($user_id)
	{
		$ci = CI_Controller::get_instance();
		$query = $ci->db->get_where('card_info', ['user_id' => $user_id]);
		return $query->result();
	}

	public function get_profile($user_id)
	{
		$profile = $this->fields('id')->with('profile')->get(['id'=>$user_id]);
		return $profile ? $profile->profile : null;
	}

	public function update_plan($user_id, $plan_id)
	{
		$ci = CI_Controller::get_instance();
		$ci->db->update('users', ['plan_id' => intval($plan_id), 'updated_at' => date('Y-m-d H:i:s')], array('id' => $user_id));
		return;
	}

	public function update_customer($customer_id)
	{
		$ci = CI_Controller::get_instance();
		$update = [
			'user_object' => $customer_id,
			'updated_at' => date('Y-m-d H:i:s')
		];
		$ci->db->where('user_id', $this->session->userdata['id'])->update('card_info', $update);
		return;
	}

	public function check_username_db($username)
	{
		$ci = CI_Controller::get_instance();
		$query = $ci->db->get_where('users', ['username' => $username]);
		return $query->result();
	}

	public function check_email_db($email)
	{
		$ci = CI_Controller::get_instance();
		$query = $ci->db->get_where('users', ['email' => $email]);
		return $query->result();
	}

	public function insert_card_info($data_card_info)
	{
		$data_card_db = [
			'user_id' => $data_card_info['user_id'],
			'user_object' => $data_card_info['user_object'],
			'created_at' => $data_card_info['created_at'],
			'updated_at' => $data_card_info['updated_at']
		];
		$ci = CI_Controller::get_instance();
		$ci->db->insert('card_info', $data_card_db);
	}

	public function insert_user($data_user)
	{
		$data_user_db = [
			'username' => $data_user['username'],
			'email' => $data_user['email'],
			'plan_id' => $data_user['plan_id'],
			'password' => $data_user['password'],
			'created_at' => $data_user['created_at'],
			'updated_at' => $data_user['updated_at']
		];
		$ci = CI_Controller::get_instance();
		$ci->db->insert('users', $data_user_db);
		$insert_id = $ci->db->insert_id();

		$data_user_profile = [
			'user_id' => $insert_id,
			'can_hire' => 0,
			'public_profile' => 0,
			'created_at' => $data_user['created_at'],
			'updated_at' => $data_user['updated_at']
		];
		$ci->db->insert('users_profile', $data_user_profile);
	}

	public function insert_recursion($user_id, $recursion_id)
	{
		$ci = CI_Controller::get_instance();
		$ci->db->where('user_id', $user_id)->update(
			'card_info', [
			'recursion_id' => $recursion_id,
			'updated_at' => date('Y-m-d H:i:s')
		]);
	}

	public function remove_recursion($user_id)
	{
		$ci = CI_Controller::get_instance();
		$ci->db->where('user_id', $user_id)->update(
			'card_info', [
			'recursion_id' => NULL,
			'updated_at' => date('Y-m-d H:i:s')
		]);
		$ci->db->where('id', $user_id)->update('users', [
			'plan_id' => NULL,
			'updated_at' => date('Y-m-d H:i:s'),
		]);
	}

	public function create_reset_key($email)
	{
		$ci = CI_Controller::get_instance();
		$ci->load->helper('string');
		$reset_key = random_string('alnum', 30);
		$data = [
			'reset_key' => $reset_key,
			'updated_at' => date('Y-m-d H:i:s')
		];
		$ci->db->where('email', $email)->update('users', $data);
		return $reset_key;
	}

	public function update_password($password, $key)
	{
		$user = $this->check_reset_key($key)[0];
		$data = [
			'password' => password_hash($password, PASSWORD_DEFAULT),
			'reset_key' => NULL,
			'updated_at' => date('Y-m-d H:i:s')
		];
		$ci = CI_Controller::get_instance();
		$ci->db->where('id', $user->id)->update('users', $data);
	}

	public function check_reset_key($key)
	{
		$ci = CI_Controller::get_instance();
		$query = $ci->db->get_where('users', ['reset_key' => $key]);
		return $query->result();
	}

	public function remove_resetkey($user_id)
	{
		$ci = CI_Controller::get_instance();
		$ci->db->where('id', $user_id)->update('users', [
			'reset_key' => NULL
		]);
	}

	public function detele_user($user_id)
	{
		$ci = CI_Controller::get_instance();
		$ci->db->delete('card_info', ['user_id' => $user_id]);
		$ci->db->delete('users', ['id' => $user_id]);
	}

	public function checkUserHaveCard($userId){
		$ci = CI_Controller::get_instance();
		$query = $ci->db->get_where('card_info', ['user_id' => $userId]);
		return !empty($query->result());
	}
}