<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Solid\Repositories\UserRepository as UserRepository;
use Solid\Collections\User as User;

/**
 * Class ProfileController
 * @property User_model $user_model
 * @property Profile_model $profile_model
 */
class ProfileController extends MY_Controller {
	/**
	 * @var UserRepository $userRepository
	 */
	private $userRepository;

	public function __construct(UserRepository $userRepository){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('profile_model');
		$this->load->helper('url');

		$this->userRepository = $userRepository;
		$this->userRepository->setModel($this->user_model);
		$this->userRepository->setProfileModel($this->profile_model);
	}

	public function index ($username) {
		$username = urldecode($username);
		$this->current_menu = 'profile';
		//get user data from user name
		try{
			$userData = $this->userRepository->findByUsername($username);
			$dataView = [
				'countries'=>User::COUNTRIES,
				'isMyProfile'=>$userData->getId() == $this->session->userdata('id'),
				'userData'=>$userData,
				'profile'=>$userData->getProfile()
			];
			//var_dump($dataView);die();
			$this->blade->render('front.profile', $dataView);
		}catch (Exception $e) {
			show_404();
		}
	}
	public function updateProfile() {
		if(!$this->checkUserLogin()){
			show_error('You are not login',400);
		};
		try{
			$isUserHasProfile = $this->userRepository->getProfileOfUser($this->session->userdata('id'));
			$userData = $this->userRepository->findById($this->session->userdata('id'));
			$postData = $this->input->post();
			$postData['user_id'] = $this->session->userdata('id');
			if($isUserHasProfile) {
				$this->user_model->update_profile_data($postData);
			}else{
				$save=$this->userRepository->saveNewProfileOfUser($postData);
			}
			redirect(link_profile($userData->getUsername()));
		}catch (Exception $e) {
			show_404();
		}
	}
	public function uploadAvatar() {
		if(!$this->checkUserLogin()){
			show_error('You are not login',400);
		};
		$avatar = $this->input->post('avatar-upload',true);
		if (!$avatar) {
			# code...
			redirect(link_profile(CommonService::get_instance()->user_name()));
		}
		if($this->_saveFileFromTmpUpload($avatar)){
			//update avatar current user
			if($this->userRepository->updateAvatar($avatar,$this->session->userdata('id'))) {
				redirect(link_profile(CommonService::get_instance()->user_name()));
			}else{
				show_error(trans('error.common_error'));
			}
		}else{
			redirect(link_profile(CommonService::get_instance()->user_name()));
		}
	}
}
