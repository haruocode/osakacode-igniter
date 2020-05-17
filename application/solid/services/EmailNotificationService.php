<?php
/**
 * Created by PhpStorm.
 * User: Administrator PC
 * Date: 4/29/2016
 * Time: 5:01 PM
 */

namespace Solid\Services;



use Solid\Collections\EmailNotification;
use Solid\Collections\Notification;


class EmailNotificationService implements NotificationService
{
	/**
	 * @var EmailNotification[]
	 */
	private $notifyData = [];

	/**
	 * @param Notification $notification
	 * @return EmailNotificationService
	 */
	public function setNotificationData(Notification $notification)
	{
		// TODO: Implement setNotificationData() method.
		$this->notifyData[] = $notification;
		return $this;
	}


	/**
	 * @return mixed
	 */
	public function send()
	{
		$sendGrid = new \SendGrid(GRID_USER, GRID_PASS);
		foreach ($this->notifyData as $data) {
			$email    = new \SendGrid\Email();
			// Content of the email
			$email
				->addTo($data->getReceiveEmail())
				->setFrom($data->getSenderEmail())
				->setFromName($data->getSenderName())
				->setSubject($data->getEmailTitle())
				->setHtml($data->getHtmlContent());

			$sendGrid->send($email);
		}
	}
}