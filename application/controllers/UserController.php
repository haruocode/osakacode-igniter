<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Solid\Collections\EmailNotification as EmailNotification;
use Solid\Repositories\EmailNotificationRepository as EmailNotificationRepository;
use Solid\Repositories\UserRepository as UserRepository;

/**
 * Class UserController
 * @property UserRepository $userRepository
 * @property EmailNotificationRepository $emailNotificationRepository
 * @property User_history_model $user_history_model
 * @property CI_Form_validation $form_validation
 * @property User_model $user_model
 */
class UserController extends MY_Controller
{
	private $historyService;
	private $userRepository;
	private $emailNotificationRepository;

	public function __construct(\Solid\Services\HistoryService $historyService,
	                            UserRepository $userRepository,
	                            EmailNotificationRepository $emailNotificationRepository)
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('user_history_model');
		$this->load->model('invoice_model');
		$this->load->model('plan_model', 'plan');
		$this->load->model('discuss_email_notifications_model');
    $this->load->library('form_validation');
		$this->historyService = $historyService;
		$this->emailNotificationRepository = $emailNotificationRepository;
		$this->historyService->setUserModel($this->user_history_model);
		$this->historyService->setSession($this->session);
		$this->userRepository = $userRepository;
		$this->userRepository->setModel($this->user_model);
		$this->emailNotificationRepository->setModel($this->discuss_email_notifications_model);
	}

	public function index()
	{
		// Security for xss_clean
		$this->load->helper('security');

		$this->load->helper('form');
		$this->load->library('form_validation');

		// set rules for login form
		$this->form_validation->set_rules('email', '', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', '', 'trim|required|xss_clean');

		if ($this->form_validation->run() == TRUE) {
			$this->login();
		} else {
			if (check_logged()) {
				$this->session->unset_userdata('isLoggedIn');
				session_destroy();
			}
			$data = [
				'head_title' => '会員ログイン',
				'head_keyword' => 'プログラミング,学習,ログイン',
				'head_desc' => '「大阪コード学園」の会員ログイン画面です。',
				'token' => $this->security->get_csrf_hash()
			];
			$this->blade->render('front.login', $data);
		}
	}

	public function set_session($user)
	{
		$this->session->set_userdata([
			'id' => $user->id,
			'username' => $user->username,
			'email' => $user->email,
			'isLoggedIn' => TRUE,
		]);
	}

	protected function login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$ajax_return = [
			'error' => 0,
			'msg' => '',
			'success' => 0
		];

		$user = $this->user_model->find_user_by_email($email);

		if ($user && $this->user_model->validate_password($password, $user->password)) {
			setcookie('notifylogin', 1, time() + 60);
			$this->set_session($user);
			//write log user_login to user_history
			$this->historyService->writeLog();
			//delete reset_key
			$this->user_model->remove_resetkey($user->id);
			$ajax_return['success'] = 1;
			$ajax_return['msg'] = 'ログインに成功しました';
			echo json_encode($ajax_return);
			die();
		} else {
			$ajax_return['error'] = 1;
			$ajax_return['msg'] = 'ログインに失敗しました';
			echo json_encode($ajax_return);
			die();
		}
	}

	public function logout()
	{
		setcookie('notifylogout', 1, time() + 60);
		$this->session->unset_userdata('isLoggedIn');
		session_destroy();
		header('Location: /');
	}

	public function join()
	{
		$data = [
			'head_title' => '会員プラン選択',
			'head_keyword' => '会員,登録,プラン,選択',
			'head_desc' => '登録するプランを選択してください。'
		];
		$this->blade->render('front.join', $data);
	}

	public function signup($plan)
	{
		if (check_logged()) {
			redirect('');
		}
		if ($plan != 'monthly' && $plan != 'yearly' && $plan != 'none') show_404();
		$this->load->model('plan_model');
		$data_signup = [
			'head_title' => '会員登録',
			'head_keyword' => '会員登録',
			'head_desc' => '会員登録',
			'plan' => $plan,
			'plans' => $this->plan_model->get_all_plans(),
			'token' => $this->security->get_csrf_hash(),
		];
		$ajax_return = [
			'error' => 0,
			'success' => 0,
		];

		if ($plan == 'none') return $this->blade->render('front.signupfree');

		if ($this->input->post()) {
            $this->form_validation->set_rules($this->user_model->validate);
            if ($this->form_validation->run() == false)
            {
                //if validate fail
                $ajax_return['error'] = 1;
                echo json_encode($ajax_return);
                die();
            }
			$post_data = $this->input->post();
			if ($this->user_model->check_username_db($post_data['username'])) {
				$ajax_return['username_error'] = 1;
				$ajax_return['error'] = 1;
				echo json_encode($ajax_return);
				die();
			} else if ($this->user_model->check_email_db($post_data['email_create'])) {
				$ajax_return['email_error'] = 1;
				$ajax_return['error'] = 1;
				echo json_encode($ajax_return);
				die();
			} else {
				$create_user = $this->create_user($post_data);
				if($create_user){
					$temp = new stdClass();
					$temp->receiveEmail = $post_data['email_create'];
					$temp->emailTitle = trans('front.email.title', ['userName' => $post_data['username']]);
					$temp->htmlContent = EmailNotification::generateWelcomeEmailHtmlContent([
						'username' => $post_data['username']
					]);
					$temp->senderName = EMAIL_SUPPORT_NAME;
					$temp->senderEmail = EMAIL_SUPPORT_ADDRESS;
					$emailData = EmailNotification::create($temp);
					$this->_sendEmailDiscussionSubscribe($emailData);
				}
				if (!$create_user) {
					$ajax_return['error'] = 1;
					$ajax_return['card_error'] = 1;
					echo json_encode($ajax_return);
					die();
				}
				$ajax_return['success'] = 1;
				echo json_encode($ajax_return);
				die();
			}
		}
		$this->blade->render('front.signup', $data_signup);
	}

	public function postSignupfree()
	{

		if (check_logged()) {
			redirect(base_url());
		}
		if ($this->input->post()) {
			$this->form_validation->set_rules($this->user_model->validate);
			if ($this->form_validation->run() == false)
			{
				//if validate fail
                show_error("signup fail, validate form fail!!");
				redirect('signup/none');
			}
			$password = $this->input->post('password_create', true);
			$password_confirm = $this->input->post('password_confirmation_create', true);
			if ($password != $password_confirm || strlen($password) < 6) {
				show_error(trans('error.signup.password_wrong'),400,trans('error.signup.register_error'));
			}
			$data['username'] = $this->input->post('username', true);
			$data['email'] = $this->input->post('email_create', true);
			$data['password'] = password_hash($password, PASSWORD_DEFAULT);
			try {
				$this->userRepository->validateData($data);
			} catch (Exception $e) {
				show_error($e->getMessage(), 400, trans('error.signup.register_error'));
			}
			if ($this->userRepository->saveData($data)) {
				$this->session->set_flashdata('registerAlert', trans('front.homepage.register'));
				$temp = new stdClass();
				$temp->receiveEmail = $data['email'];
				$temp->emailTitle = trans('front.email.title', ['userName' => $data['username']]);
				$temp->htmlContent = EmailNotification::generateWelcomeEmailHtmlContent([
					'username' => $data['username']
				]);
				$temp->senderName = EMAIL_SUPPORT_NAME;
				$temp->senderEmail = EMAIL_SUPPORT_ADDRESS;
				$emailData = EmailNotification::create($temp);
				$this->_sendEmailDiscussionSubscribe($emailData);
			}
			redirect(base_url());
		}
	}

	private function _sendEmailDiscussionSubscribe(EmailNotification $notification)
	{
		$this->emailNotificationRepository->add($notification);
		$this->emailNotificationRepository->save();
	}

	private function set_recursion($plan_id, $user_id)
	{
		$card_data = $this->user_model->get_card_info($user_id);
		if ($card_data[0]->recursion_id == NULL) {
			if ($plan_id == 1) {
				$plan_detail = $this->plan->get_plan_detail($plan_id);
				$recursion = $this->payment->create_recursion(intval($plan_detail->price), 'jpy', $card_data[0]->user_object, 'month');
				$this->user_model->insert_recursion($user_id, $recursion->id);
			} else {
				$plan_detail = $this->plan->get_plan_detail($plan_id);
				$recursion = $this->payment->create_recursion(intval($plan_detail->price), 'jpy', $card_data[0]->user_object, 'year');
				$this->user_model->insert_recursion($user_id, $recursion->id);
			}
		} else if ($card_data[0]->recursion_id !== NULL) {
			if ($plan_id == 1) {
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

	private function create_user($post_data)
	{

		$temp = new stdClass();
		$temp->receiveEmail = $post_data['email_create'];
		$temp->emailTitle = trans('front.email.title', ['userName' => $post_data['username']]);
		$temp->htmlContent = EmailNotification::generateWelcomeEmailHtmlContent([
			'username' => $post_data['username']
		]);
		$temp->senderName = EMAIL_SUPPORT_NAME;
		$temp->senderEmail = EMAIL_SUPPORT_ADDRESS;
		$emailData = EmailNotification::create($temp);
		$this->_sendEmailDiscussionSubscribe($emailData);

		$data_user_db = [
			'username' => $post_data['username'],
			'email' => $post_data['email_create'],
			'plan_id' => $post_data['subscription-plan'],
			'password' => password_hash($post_data['password_create'], PASSWORD_DEFAULT),
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		];

		$this->user_model->insert_user($data_user_db);

		$user_data = $this->user_model->find_user_by_email($post_data['email_create']);

		$card_object_data = $this->payment->create_customer($post_data['token']);

		$data_card_db = [
			'user_id' => $user_data->id,
			'user_object' => $card_object_data->id,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		];
		$this->user_model->insert_card_info($data_card_db);

		$recursion_id = $this->set_recursion($post_data['subscription-plan'], $user_data->id);
		if ($recursion_id) {
			$recursion_detail = $this->payment->retrieve_recursion($recursion_id);
			if ($recursion_detail->status == 'active') {
				//$this->invoice_model->insert_invoice($recursion_detail, $post_data['subscription-plan'], $user_data->id);
				$this->invoice_model->insert_invoice($post_data['subscription-plan'], $user_data->id);
				return true;
			} else if ($recursion_detail->status == 'suspended') {
				$this->user_model->detele_user($user_data->id);
				return false;
			}
		}
	}
}