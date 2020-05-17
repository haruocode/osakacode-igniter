<?php
/**
 * Created by PhpStorm.
 * User: Administrator PC
 * Date: 5/5/2016
 * Time: 9:59 AM
 */

namespace Solid\Collections;


/**
 * Class EmailNotification
 * @package Solid\Collections
 */
class EmailNotification implements Notification
{
	/**
	 * @var string
	 */
	private $receiveEmail;
	/**
	 * @var string
	 */
	private $htmlContent;
	/**
	 * @var string
	 */
	private $emailTitle;
	/**
	 * @var string
	 */
	private $senderEmail;

	/**
	 * @var string
	 */
	private $senderName;

	/**
	 * EmailNotification constructor.
	 * @param $emailData
	 */
	public function __construct($emailData)
	{
		$this->receiveEmail = $emailData->receiveEmail;
		$this->emailTitle = $emailData->emailTitle;
		$this->htmlContent = $emailData->htmlContent;
		$this->senderEmail = $emailData->senderEmail;
		$this->senderName = $emailData->senderName;
	}

	/**
	 * @param $modelRecord
	 * @return EmailNotification
	 */
	public static function create($modelRecord)
	{
		// TODO: Implement create() method.
		return new EmailNotification($modelRecord);
	}

	/**
	 * @param $replier
	 * @param $discussionTitle
	 * @return mixed
	 */
	public static function generateEmailSubscribeTitle($replier, $discussionTitle)
	{
		return trans('front.notification.emailSubscribeTitle', ['replier' => $replier, 'discussionTitle' => $discussionTitle]);
	}


	/**
	 * @param array $data
	 * @return string
	 */
	public static function generateHtmlContent($data) {
		return \CI_Controller::get_instance()->blade->render('email.notify_subscribe',$data,true);
	}

	/**
	 * @return string
	 */
	public function getReceiveEmail()
	{
		return $this->receiveEmail;
	}

	/**
	 * @return string
	 */
	public function getHtmlContent()
	{
		return $this->htmlContent;
	}

	/**
	 * @return string
	 */
	public function getEmailTitle()
	{
		return $this->emailTitle;
	}

	/**
	 * @return string
	 */
	public function getSenderEmail()
	{
		return $this->senderEmail;
	}

	/**
	 * @return string
	 */
	public function getSenderName()
	{
		return $this->senderName;
	}

	public static function generateWelcomeEmailHtmlContent($data) {
		return \CI_Controller::get_instance()->blade->render('email.welcome_email',$data,true);
	}
	
}