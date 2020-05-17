<?php
/**
 * Created by PhpStorm.
 * User: Administrator PC
 * Date: 5/3/2016
 * Time: 9:09 PM
 */

namespace Solid\Collections;


class SystemNotification implements Notification
{
	const TYPE_MENTION = 1;
	const TYPE_LIKE = 2;
	const TYPE_REPLY = 3;
	const STATUS_UNREAD = 0;
	const STATUS_READ = 1;
	private $id;
	private $userId;
	private $type;
	private $description;
	private $status;
	private $link;
	private $createdAt;
	private $updatedAt;

	public function __construct($modelRecord)
	{
		$list_property = ['id', 'user_id', 'type', 'description', 'link', 'status', 'created_at', 'updated_at'];
		foreach ($list_property as $property) {
			if (property_exists($modelRecord, $property)) {
				$this->{camel_case($property)} = $modelRecord->{$property};
			}
		}
	}

	public static function create($modelRecord)
	{
		if(!property_exists($modelRecord,'created_at')) {
			$modelRecord->created_at = time();
		}
		if(!property_exists($modelRecord,'updated_at')) {
			$modelRecord->updated_at = time();
		}
		return new SystemNotification($modelRecord);
	}

	public static function generateMentionDescription($senderName, $discussionTitle)
	{
		return trans('front.notification.mention', ['senderName' => $senderName, 'discussionTitle' => $discussionTitle]);
	}

	public static function generateLikeDescription($senderName, $discussionTitle)
	{
		return trans('front.notification.postlike', ['senderName' => $senderName, 'discussionTitle' => $discussionTitle]);
	}
	
	public static function generateReplyDescription($senderName, $discussionTitle)
	{
		return trans('front.notification.reply', ['senderName' => $senderName, 'discussionTitle' => $discussionTitle]);
	}
	/**
	 * @return mixed
	 */
	public function getUserId()
	{
		return $this->userId;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @return mixed
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @return mixed
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * @return mixed
	 */
	public function getLink()
	{
		return $this->link;
	}

	/**
	 * @return mixed
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	/**
	 * @return mixed
	 */
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}
}