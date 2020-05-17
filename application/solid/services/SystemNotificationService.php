<?php
/**
 * Created by PhpStorm.
 * User: Administrator PC
 * Date: 4/29/2016
 * Time: 4:09 PM
 */

namespace Solid\Services;
use Solid\Collections\Notification;


/**
 * Class SystemNotificationService
 * @package Solid\Services
 * @property \MY_Model $model
 * @property array $notifyData
 */
class SystemNotificationService implements NotificationService
{
	private $notifyData = [];
	private $model;
	/**
	 * @param Notification $notification
	 * @return mixed
	 */
	public function setNotificationData(Notification $notification)
	{
		// TODO: Implement setNotificationData() method.
		//check in array
		if(!in_array($notification, $this->notifyData)) {
			$this->notifyData[] = $notification;	
		}
		return $this;
	}
	public function resetNotificationData() {
		$this->notifyData = [];
		return $this;
	}

	public function setModel($model) {
		$this->model = $model;
	}

	/**
	 * @return mixed
	 */
	public function send()
	{
		$result = false;
		foreach ($this->notifyData as $key=>$notify) {
			$result = $this->model->insert([
				'type'=>$notify->getType(),
				'user_id'=>$notify->getUserId(),
				'description'=>$notify->getDescription(),
				'created_at'=>$notify->getCreatedAt(),
				'updated_at'=>$notify->getUpdatedAt(),
				'status'=>$notify->getStatus(),
				'link'=>$notify->getLink()
			]);
		}
		if($result) {
			//clear notify data
			$this->resetNotificationData();
		}
		return $result;
	}
}