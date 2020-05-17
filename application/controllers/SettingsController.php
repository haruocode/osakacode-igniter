<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class SettingsController
 * @property User_model $user_model
 */
class SettingsController extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper('url');
		!check_logged() ? redirect('') : [];   
	}

	public function account(){
		$user_card = $this->user_model->get_card_info($this->session->userdata['id']);
		$this->current_menu = 'settings';
		$this->load->helper('form');
		$data_account = [
			'class_body' => 'settings',
			'has_card'=>$user_card ? true : false,
			'user' => $this->user_model->get_user($this->session->userdata['id']),
            'profile' => $this->user_model->get_profile($this->session->userdata['id']),
			'token' => $this->security->get_csrf_hash(),
			'current_menu' => $this->current_menu,
			'sidebar_menu' => 'settings_account',
		];
        $ajax_return = [
            'error' => 0,
            'success' => 0,
        ];
		if ($this->input->post()){
			$post_data = $this->input->post(NULL, TRUE);
			if ($this->user_model->check_username_db($post_data['username']) && ($this->session->userdata['username'] != $post_data['username'])){
				$ajax_return['username_error'] = 1;
                $ajax_return['error'] = 1;
                echo json_encode($ajax_return); die();
			} else if ($this->user_model->check_email_db($post_data['email']) && ($this->session->userdata['email'] != $post_data['email'])){
				$ajax_return['email_error'] = 1;
                $ajax_return['error'] = 1;
                echo json_encode($ajax_return); die();
			} else {
				$post_data['id'] = $this->session->userdata('id');
				$this->user_model->update_data($post_data);
                $this->session->set_userdata('username', $post_data['username']);
                $this->session->set_userdata('email', $post_data['email']);
				$ajax_return['success'] = 1;
                echo json_encode($ajax_return); die();
			}
		}
		$this->blade->render('settings.account', $data_account);
	}

}