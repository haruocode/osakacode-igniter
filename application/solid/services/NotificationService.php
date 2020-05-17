<?php
namespace Solid\Services;
use Solid\Collections\Notification;


/**
 * Interface NotificationService
 * @package Solid\Services
 */
interface NotificationService {

	/**
	 * Set content for notification
	 * @param Notification $notification
	 * @return mixed
	 */
	public function setNotificationData(Notification $notification);

	/**
	 * Send notification
	 * @return mixed
	 */
	public function send();
}