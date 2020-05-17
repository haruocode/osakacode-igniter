<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class SubscriptionController
 * @property User_model $user_model
 * @property Invoice_model $invoice_model
 * @property Plan_model $plan
 * @property Payment $payment
 */
class SubscriptionController extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('invoice_model');
		$this->load->helper('url');
		$this->load->model('plan_model','plan');
		!check_logged() ? redirect('') : [];
		$user_card = $this->user_model->get_card_info($this->session->userdata['id']);
		if(!$user_card ) {
			redirect(add_credit_card_url());
		}
	}

	private function set_recursion($plan_id, $user_id){
		$card_data = $this->user_model->get_card_info($user_id);
		if($card_data[0]->recursion_id == NULL){
			if($plan_id == 1) {
				$plan_detail = $this->plan->get_plan_detail($plan_id);
				$recursion = $this->payment->create_recursion(intval($plan_detail->price), 'jpy', $card_data[0]->user_object, 'month');
				$this->user_model->insert_recursion($user_id, $recursion->id);
			} else {
				$plan_detail = $this->plan->get_plan_detail($plan_id);
				$recursion = $this->payment->create_recursion(intval($plan_detail->price), 'jpy', $card_data[0]->user_object, 'year');
				$this->user_model->insert_recursion($user_id, $recursion->id);
			}
		} else if($card_data[0]->recursion_id !== NULL){
			if($plan_id == 1) {
				$plan_detail = $this->plan->get_plan_detail($plan_id);
				$this->payment->delete_recursion($card_data[0]->recursion_id);
				$recursion = $this->payment->create_recursion(intval($plan_detail->price), 'jpy', $card_data[0]->user_object, 'month');
				$this->user_model->insert_recursion($user_id, $recursion->id);
			} else {
				$plan_detail = $this->plan->get_plan_detail($plan_id);
				$this->payment->delete_recursion($card_data[0]->recursion_id);
				$recursion = $this->payment->create_recursion(intval($plan_detail->price), 'jpy', $card_data[0]->user_object, 'year');
				$this->user_model->insert_recursion($user_id, $recursion->id);
			}
		}
		return $recursion->id;
	}

	public function plan(){
		//if user has plan => show. Or redirect to not found
		$user_data = $this->user_model->get_user($this->session->userdata['id']);
		if($this->input->post()) {
			$plan_id = $this->input->post('subscription-plan');
            if($plan_id!=$user_data->plan_id) {
                //check plan
                //if ($this->plan->check_plan($plan_id)) {
                    $post_data = $this->input->post();
                    $recursion_id = $this->set_recursion($plan_id, $this->session->userdata['id']);
                    if ($recursion_id) {
                        $recursion_detail = $this->payment->retrieve_recursion($recursion_id)->__toArray(true);
                        if ($recursion_detail['status'] == 'active') {
                            $this->user_model->update_plan($this->session->userdata['id'], $post_data['subscription-plan']);
                            $this->invoice_model->insert_invoice($plan_id, $this->session->userdata['id']);
                        }
                    }
                //}
                $this->session->set_tempdata('updatePlan', TRUE, 5);
                //header('Location: /home');
            }
		}
        $user_data = $this->user_model->get_user($this->session->userdata['id']);
        $user_card = $this->user_model->get_card_info($this->session->userdata['id']);
        $current_plan = $this->plan->get_plan_detail($user_data->plan_id);
		$data_view = [
            'sidebar_menu' => 'subscription_plan',
			'user_data' => $user_data,
			'class_body' => 'settings',
			'has_card'=>!!$user_card,
			'plans' => $this->plan->get_all_plans(),
			'current_plan' => $current_plan,
			'token' => $this->security->get_csrf_hash(),
		];
		$this->blade->render('settings.plan', $data_view);
	}

	public function invoices() {
		$user_data = $this->user_model->get_user($this->session->userdata['id']);
		$get_invoice = $this->invoice_model->get_all_invoice($user_data->id);
		//if user has plan => show. Or redirect to not found
		$user_card = $this->user_model->get_card_info($this->session->userdata['id']);
		$data_payments = [
			'sidebar_menu' => 'subscription_invoices',
			'has_card'=>!!$user_card,
			'class_body' => 'settings',
			'invoices' => $get_invoice['invoices_data'],
			'next_invoice' => NULL,
			'token' => $this->security->get_csrf_hash(),
			'user' => $user_data,
		];
		$card_data = $this->user_model->get_card_info($this->session->userdata['id']);

		if ($card_data[0]->recursion_id) {
			try{
				$recursion_detail = $this->payment->retrieve_recursion($card_data[0]->recursion_id);
				$data_payments['next_invoice'] = $recursion_detail->__toArray(true);
			}catch (Exception $e) {
				log_message('error',$e->__toString());
			}

		}
			
		$this->blade->render('settings.payments', $data_payments);
	}

	public function cancel() {
		$user_data = $this->user_model->get_user($this->session->userdata['id']);
		$user_card = $this->user_model->get_card_info($this->session->userdata['id']);
		$card_data = $this->user_model->get_card_info($this->session->userdata['id']);
		$dataview = [
            'sidebar_menu' => 'subscription_cancel',
			'class_body' => 'settings',
			'has_card'=>!!$user_card,
		];
		if ($card_data[0]->recursion_id)
			$this->blade->render('settings.cancel', $dataview);
		else $this->blade->render('settings.cancel_error', $dataview);
	}

	public function cancel_confirm() {
		$card_data = $this->user_model->get_card_info($this->session->userdata['id']);
		$this->payment->delete_recursion($card_data[0]->recursion_id);
		$this->user_model->remove_recursion($this->session->userdata['id']);
		header('Location: /settings/account');
	}

	public function invoice_detail($invoice_id) {
		$invoice_data = $this->invoice_model->get_invoice_by_invoiceid($invoice_id);
		$user_data = $this->user_model->get_user($invoice_data[0]->user_id);
		$plan_data = $this->plan->get_plan_detail($invoice_data[0]->plan_id);

		$data_detail = [
			'user_data' => $user_data,
			'invoice_data' => $invoice_data,
			'plan_data' => $plan_data
		];
		$this->blade->render('settings.invoice_print', $data_detail);
	}
}