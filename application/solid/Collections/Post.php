<?php
/**
 * Created by PhpStorm.
 * User: Administrator PC
 * Date: 4/21/2016
 * Time: 2:33 PM
 */

namespace Solid\Collections;


class Post implements CollectionInterface
{
	/**
     * @var int
     */
    private $id;
	/**
     * @var int
     */
    private $userId;
	/**
     * @var int
     */
    private $discussionId;
	/**
     * @var string
     */
    private $content;
	/**
     * @var int
     */
    private $createdAt;
	/**
     * @var int
     */
    private $updatedAt;
	/**
     * @var int
     */
    private $deletedAt;
	/**
     * @var int
     */
    private $bestAnswer;
	/**
     * @var User
     */
    private $user;
	/**
     * @var Discussion
     */
    private $discussion;
    
    public function __construct($modelRecord)
    {
	    $list_property = ['id','content','user_id','discussion_id'
		    ,'created_at','updated_at','deleted_at','user','discussion','best_answer'];
	    foreach($list_property as $property){
		    if(property_exists($modelRecord,$property)) {
			    $this->{camel_case($property)} = $modelRecord->{$property};
		    }
	    }
    }

	/**
	 * @param $dbRecord
	 * @return Post
	 */
	public static function create($dbRecord)
	{
		return new Post($dbRecord);
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
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
	public function getDiscussionId()
	{
		return $this->discussionId;
	}

	/**
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
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
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	/**
	 * @return int
	 */
	public function getDeletedAt()
	{
		return $this->deletedAt;
	}

	/**
	 * @return int
	 */
	public function getBestAnswer()
	{
		return $this->bestAnswer;
	}

	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * @return Discussion
	 */
	public function getDiscussion()
	{
		return $this->discussion;
	}
	
    public static function getRecentUser($dbRecord)
    {
        $post = end($dbRecord);
        if (isset($post->user->username)) {
            return $post->user->username;
        } else {
            return null;
        }
    }

    public static function getQuestionPost($dbRecord)
    {
        if ($dbRecord) {
            return $dbRecord[0];
        }
    }

    public static function getRecentCreatedTime($dbRecord)
    {
        $post = end($dbRecord);
        return $post->created_at;
    }
	public static function generateUserLinkToMention($username) {
		return '<a href="'.link_profile($username).'">@'.$username.'</a>';
	}
	
}