<?php
/**
 * Created by PhpStorm.
 * User: Administrator PC
 * Date: 4/29/2016
 * Time: 5:00 PM
 */

namespace Solid\Repositories;


use Solid\Collections\Discussion;
use Solid\Collections\Notification;
use Solid\Collections\User;
use Solid\Services\EmailNotificationService as EmailNotificationService;

/**
 * Class EmailNotificationRepository
 * @package Solid\Repositories
 * @property Notification $notification
 * @property EmailNotificationService $service
 * @property \Discuss_email_notifications_model $model
 */
class EmailNotificationRepository extends NotificationRepository
{
	public $service;

	public function __construct(EmailNotificationService $service)
	{
		$this->service = $service;
	}

	/**
	 * @param Notification $notification
	 * @return mixed
	 */
	function add(Notification $notification)
	{
		// TODO: Implement add() method.
		$this->service->setNotificationData($notification);
		return $this;
	}

	/**
	 * @param User $user
	 * @param Discussion $discussion
	 * @return bool
	 */
	public function toggleSubscribe(User $user, Discussion $discussion)
	{
		$this->checkModel();
		//check if discussion has subscribe
		$checkSubscribe = $this->model->get([
			'discussion_id' => $discussion->getId(),
			'user_id' => $user->getId()
		]);
		if ($checkSubscribe) {
			//update subscribe status
			try {
				$this->model->update([
					'status' => (int)!($checkSubscribe->status),
					'updated_at' => time()
				], [
					'discussion_id' => $discussion->getId(),
					'user_id' => $user->getId()
				]);
				$result = true;
			} catch (\Exception $e) {
				$result = false;
			}

		} else {
			try {
				//insert subscribe status
				$this->model->insert([
					'discussion_id' => $discussion->getId(),
					'user_id' => $user->getId(),
					'created_at' => time(),
					'updated_at' => time(),
					'status' => 1
				]);
				$result = true;
			} catch (\Exception $e) {
				$result = false;
			}
		}
		return $result;
	}

	public function save()
	{
		$this->checkModel();
		$this->service->send();
	}

	/**
	 * @param $discussionId
	 * @return User[]
	 */
	public function getUserSubscribe($discussionId)
	{
		$this->checkModel();
		$listUser = [];
		$data = $this->model->fields('user_id')
			->with('user')
			->where(['discussion_id' => $discussionId, 'status' => 1])
			->get_all();
		if ($data) {
			foreach ($data as $record) {
				$listUser[] = User::create($record->user);
			}
		}
		return $listUser ?: [];
	}

	/**
	 * @param int $userId
	 * @param int $discussionId
	 * @return bool
	 * @throws \Exception
	 */
	public function checkSubscribeDiscussion($userId, $discussionId) {
		$this->checkModel();
		$checkSubscribe = $this->model->get([
			'discussion_id' => $discussionId,
			'user_id' => $userId
		]);
		return $checkSubscribe && $checkSubscribe->status ? true : false;
	}
}