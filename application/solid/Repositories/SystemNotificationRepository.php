<?php
/**
 * Created by PhpStorm.
 * User: Administrator PC
 * Date: 4/29/2016
 * Time: 4:59 PM
 */

namespace Solid\Repositories;

use Solid\Collections\Notification;
use Solid\Collections\SystemNotification;
use Solid\Services\SystemNotificationService;


/**
 * Class SystemNotificationRepository
 * @package Solid\Repositories
 * @property \MY_Model $model
 */
class SystemNotificationRepository extends NotificationRepository
{
	public $service;

	public function __construct(SystemNotificationService $service)
	{
		$this->service = $service;
	}


	/**
	 * @param $userId
	 * @return array SystemNotification
	 */
	public function getUnread($userId)
	{
		$listCollection = [];
		$listId = $this->model->fields('id')
			->where([
				'status' => SystemNotification::STATUS_UNREAD,
				'user_id' => $userId
			])
			->order_by('created_at', 'DESC')
			->limit(20)
			->get_all();
		if($listId) {
			$arrayId = [];
			foreach ($listId as $notify) {
				$arrayId[] = (int)$notify->id;
			}
			//get notification content
			$listDetail = $this->model->fields('*')
				->where('id',$arrayId)->get_all();
			foreach ($listDetail as $item) {
				$listCollection[] = SystemNotification::create($item);
			}
		}
		return $listCollection ?: [];
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


	public function save()
	{
		$this->checkModel();
		$this->service->setModel($this->model);
		$this->service->send();
		return false;
	}

	public function setReadAllNotify($listId){
		$this->model->update(['status'=>SystemNotification::STATUS_READ],['id'=>$listId]);
	}

	public function checkNotifyOwnerByListNotify($listId,$userId){
		$records = $this->model->fields('user_id')
			->where(['id'=>$listId])
			->get_all();
		if($records) {
			foreach ($records as $record) {
				if ($record->user_id != $userId) {
					return false;
				}
			}
			return true;
		}
		return false;
	}
	
	public function setReadAllOwnerNotify($userId){
		$this->model->update(['status'=>SystemNotification::STATUS_READ],['user_id'=>$userId]);
	}
}