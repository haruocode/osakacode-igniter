<?php
/**
 * Created by PhpStorm.
 * User: Administrator PC
 * Date: 4/21/2016
 * Time: 9:16 AM
 */

namespace Solid\Collections;


/**
 * Class Discussion
 * @package Solid\Collections
 */
class Discussion implements CollectionInterface
{
	/**
	 * @var int
	 */
	private $id;
	/**
	 * @var string
	 */
	private $title;
	/**
	 * @var int 
	 */
	private $userId;
	/**
	 * @var int
	 */
	private $channelId;
	/**
	 * @var int
	 */
	private $updatedAt;
	/**
	 * @var int
	 */
	private $createdAt;
	/**
	 * @var int
	 */
	private $deletedAt;
	/**
	 * @var User
	 */
	private $user;

	/**
	 * @var Channel
	 */
	private $channel;

	/**
	 * Discussion constructor.
	 * @param $modelRecord
	 */
	public function __construct($modelRecord)
	{
		$list_property = ['id','title','user_id','channel_id'
							,'created_at','updated_at','deleted_at','user','channel'];
		foreach($list_property as $property){
			if(property_exists($modelRecord,$property)) {
				$this->{camel_case($property)} = $modelRecord->{$property};
			}
		}
	}

	/**
	 * @param $modelRecord
	 * @return Discussion
	 */
    public static function create($modelRecord)
    {
	    if(!property_exists($modelRecord,'created_at')) {
		    $modelRecord->created_at = time();
	    }
	    if(!property_exists($modelRecord,'updated_at')) {
		    $modelRecord->updated_at = time();
	    }
	    return new Discussion($modelRecord);
    }

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @return int
	 */
	public function getUserId()
	{
		return $this->userId;
	}

	/**
	 * @return int
	 */
	public function getChannelId()
	{
		return $this->channelId;
	}

	/**
	 * @return int
	 */
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	/**
	 * @return int
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	/**
	 * @return int
	 */
	public function getDeletedAt()
	{
		return $this->deletedAt;
	}

	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * @return Channel
	 */
	public function getChannel()
	{
		return $this->channel;
	}

	
	
    public static function getColorCodeByChannel($channelName)
    {
        $channel['Code Review'] = '#8cd362';
        $channel['Elixir'] = '#f7c953';
        $channel['Eloquent'] = '#09d7c1';
        $channel['Envoyer'] = '#F56857';
        $channel['Forge'] = '#5db3b7';
        $channel['General'] = '#4E89DA';
        $channel['Laravel'] = '#F56857';
        $channel['Lumen'] = '#F9A97A';
        $channel['Request'] = '#BB824E';
        $channel['Server'] = '#F9A97A';
        $channel['Site Feedback'] = '#88AD48';
        $channel['Spark'] = '#66add3';
        $channel['Testing'] = '#da5757';
        $channel['Tips'] = '#837eb6';
        $channel['Vue'] = '#3ab981';
        return $channel[$channelName];
    }

}