<?php
/**
 * Created by PhpStorm.
 * User: Administrator PC
 * Date: 5/6/2016
 * Time: 5:24 PM
 */

namespace Solid\Repositories;


use Solid\Collections\User;

/**
 * Class UserRepository
 * @package Solid\Repositories
 * @property \User_model $model
 */
class UserRepository extends BaseRepository
{
	/**
	 * @var \Profile_model $profileModel
	 */
	private $profileModel;
	/**
	 * @return mixed
	 */
	public function save()
	{
		// TODO: Implement save() method.
	}

	/**
	 * @param \Profile_model $profile_model
	 */
	public function setProfileModel(\Profile_model $profile_model) {
		$this->profileModel = $profile_model;
	}

	/**
	 * @return mixed
	 */
	public function getAll()
	{
		// TODO: Implement getAll() method.
	}

	/**
	 * @param $id
	 * @return User
	 * @throws \Exception
	 */
	public function findById($id)
	{
		// TODO: Implement findById() method.
		$result = $this->model->fields('*')
			->with('profile')
			->where(['id' => $id])->get();
		if (!$result) {
			throw new \Exception("User not found");
		}
		return User::create($result);
	}


	/**
	 * @param string $username
	 * @return User
	 * @throws \Exception
	 */
	public function findByUsername($username)
	{
		$result = $this->model->fields('*')
			->with('profile')
			->where(['username' => $username])->get();
		if (!$result) {
			throw new \Exception("User not found");
		}
		return User::create($result);
	}

	/**
	 * @param $str
	 * @param $limit
	 * @return User[]|array
	 */
	public function getSuggestUser($str, $limit)
	{
		$modelRecords = $this->model->fields('username')
			->where('username LIKE "%' . $str . '%"', null, null, false, false, true)
			->limit($limit)
			->order_by('username', 'ASC')
			->get_all();
		$listResult = [];
		if ($modelRecords) {
			foreach ($modelRecords as $record) {
				$listResult[] = User::create($record);
			}
		}
		return $listResult;
	}

	public function saveData($data)
	{
		return $this->model->insert($data);
	}

	/**
	 * @param $data
	 * @return bool
	 * @throws \Exception
	 */
	public function validateData($data)
	{
		$ci = \CI_Controller::get_instance();
		$ci->load->library('form_validation');
		/**
		 * @var \CI_Form_validation $formValidator
		 */
		$formValidator = $ci->form_validation;
		//validate require field
		if (!($formValidator->required($data['username']) && $formValidator->required('email'))) {
			throw new \Exception(trans('error.signup.require_username_email'));
		}
		//validate email field
		if (!$formValidator->valid_email($data['email'])) {
			throw new \Exception(trans('error.signup.email_not_valid'));
		}
		//validate max length of username
		if (!$formValidator->max_length($data['username'], User::USERNAME_MAX_LENGTH)) {
			throw new \Exception(trans('error.signup.username_maxlength', ['maxlength' => User::USERNAME_MAX_LENGTH]));
		}
		//validate min length of username
		if (!$formValidator->min_length($data['username'], User::USERNAME_MIN_LENGTH)) {
			throw new \Exception(trans('error.signup.username_minlength', ['minlength' => User::USERNAME_MIN_LENGTH]));
		}
		//validate unique email and username
		if(!$formValidator->is_unique($data['username'],$this->model->table . '.username')) {
			throw new \Exception(trans('error.signup.username_exist',['username'=>$data['username']]));
		}
		if(!$formValidator->is_unique($data['email'],$this->model->table . '.email')) {
			throw new \Exception(trans('error.signup.email_exist',['email'=>$data['email']]));
		}
		//validate weak password
		
		return true;
	}

	public function updateAvatar($avatar, $userId) {
		$this->checkModel();
		$profile = $this->profileModel->fields('id')->where(['user_id'=>$userId])->get();
		//if user has profile then update
		if($profile) {
			return $this->profileModel->update(['avatar'=>$avatar],['user_id'=>$userId]);
		}else{
			return $this->profileModel->insert(['user_id'=>$userId,'avatar'=>$avatar]);
		}
	}

	public function getProfileOfUser($userId){
		return $this->profileModel->fields('avatar,country')
			->where(['user_id'=>$userId])
			->get();
	}

	public function saveNewProfileOfUser($data){
		$this->profileModel->insert($data);
	}
}