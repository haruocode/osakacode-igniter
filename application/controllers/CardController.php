<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class CardController
 * @property User_model $user_model
 * @property Plan_model $plan
 * @property Payment $payment
 */
class CardController extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('plan_model','plan');
		$this->load->helper('url');
		if (!check_logged()) {
			redirect(base_url());
		}
	}

	public function edit () {
		//if user has plan => show. Or redirect to not found
		$user_data = $this->user_model->get_user($this->session->userdata['id']);
		$user_card = $this->user_model->get_card_info($this->session->userdata['id']);
		$current_plan = $this->plan->get_plan_detail($user_data->plan_id);
		$edit_data = [
			'sidebar_menu' => 'card_edit',
			'has_card'=>!!$user_card,
			'class_body' => 'settings',
			'user' => $user_data,
			'token' => $this->security->get_csrf_hash(),
		];

		if ($this->input->is_ajax_request()){
			$post_data = $this->input->post();
			if ($this->user_model->checkUserHaveCard($user_data->id)) {
				$card_info = $this->user_model->get_card_info($user_data->id);
				$card_detail = $this->payment->add_card($card_info[0]->user_object, $post_data['token']);
				if($card_detail->id) $this->payment->update_default_card($card_info[0]->user_object, $card_detail->id);
			} else {
				$customer_detail = $this->payment->create_customer($post_data['token']);
				$data_card_db = [
						'user_id' => $user_data->id,
						'user_object' => $customer_detail->id,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')
				];
				$this->user_model->insert_card_info($data_card_db);
			}
			return;
		}
		$this->blade->render('settings.edit', $edit_data);
	}
}