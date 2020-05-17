<?php

/**
 * Created by PhpStorm.
 * User: Administrator PC
 * Date: 5/12/2016
 * Time: 9:12 AM
 */
use Solid\Repositories\UserRepository as UserRepository;

/**
 * Class ApiController
 * @property User_model $user_model
 * @property CI_Loader $load
 */
class ApiController extends MY_Controller
{
	/**
	 * @var UserRepository
	 */
	private $userRepository;
	public function __construct(UserRepository $userRepository)
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->userRepository = $userRepository;
		$this->userRepository->setModel($this->user_model);
	}

	public function findUser() {
		$arrayReturn = [];
		$keyword = $this->input->get('q',TRUE);
		if($keyword && strlen($keyword) >= 3) {
			$listUser = $this->userRepository->getSuggestUser($keyword,10);
			foreach ($listUser as $user) {
				$arrayReturn[] = $user->getUsername();
			}
		}
		echo json_encode($arrayReturn);
		die();
	}
}