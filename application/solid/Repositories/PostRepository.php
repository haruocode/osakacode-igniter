<?php

/* 
 * Created by someone with Netbeans IDE
 * Date: 25-4-2016
 */

namespace Solid\Repositories;
use Solid\Collections\Post;

/**
 * Class PostRepository
 * @package Solid\Repositories
 * @property \MY_Model $model
 */
class PostRepository implements Repository
{
	private $model;
	private $postStatModel;

	public function setPostStatModel(\MY_Model $model)
	{
		$this->postStatModel = $model;
	}

	public function setModel(\MY_Model $model)
	{
		// TODO: Implement setModel() method.
		$this->model = $model;
	}

	public function save()
	{
		// TODO: Implement save() method.
		$this->checkModel();
	}

	private function checkModel()
	{
		if (!$this->model) {
			throw new \Error("Model not set");
		}
	}

	public function findById($id){

	}

	public function getAll()
	{
		// TODO: Implement getAll() method.
		$this->checkModel();
	}

	public function getAllPostByDiscussionId($discussion_id)
	{
		$this->checkModel();
		$records = $this->model->fields('*')
			->where(['discussion_id' => $discussion_id])
			->with_user('fields:username')
			->get_all();
		return $records ? $records : [];
	}

	/**
	 * @param $arrayDiscussionId
	 * @return array array(discussion_id=>data)
	 * @throws \Exception
	 */
	public function getLatestInDiscussion(array $arrayDiscussionId)
	{
		if (!$arrayDiscussionId) {
			throw new \Exception("No discussion found");
		}
		$compile = implode(',', $arrayDiscussionId);
		$CI = get_instance();
		$query = $CI->db->query('
                                SELECT
                                    t1.created_at as created_at,
                                    t2.id as id,
                                    t2.discussion_id as discussion_id,
                                    users.username as username
                                FROM
                                    (
                                        SELECT
                                            MAX(created_at) AS created_at,
                                            discussion_id
                                        FROM
                                            posts
                                        WHERE
                                            discussion_id IN (' . $compile . ')
                                        GROUP BY
                                            discussion_id
                                    ) AS t1
                                INNER JOIN (
                                    SELECT
                                        id,
                                        created_at,
                                        discussion_id,
                                        user_id
                                    FROM
                                        posts
                                    WHERE
                                        discussion_id IN (' . $compile . ')
                                ) AS t2 ON t1.created_at = t2.created_at
                                AND t1.discussion_id = t2.discussion_id
                                INNER JOIN users ON t2.user_id = users.id');
		$list = [];

		foreach ($query->result() as $row) {
			$list[$row->discussion_id] = $row;
		}
		$query->free_result();
		return $list ?: [];
	}

	/**
	 * @param array $arrayDiscussionId
	 * @return array
	 * @throws \Exception
	 */
	public function countReplyInDiscussion(array $arrayDiscussionId)
	{
		$countData = [];
		if (!$arrayDiscussionId) {
			throw new \Exception("No discussion found");
		}
		$compile = implode(',', $arrayDiscussionId);
		$CI = get_instance();
		$query = $CI->db->query('SELECT discussion_id, count(*) as countReply 
                        FROM posts 
                        WHERE discussion_id IN (' . $compile . ') 
                        AND deleted_at IS NULL
                        GROUP BY discussion_id');
		foreach ($query->result() as $row) {
			//logic, count all exclude owner post
			$countData[$row->discussion_id] = $row->countReply > 1 ? $row->countReply - 1 : 0;
		}
		return $countData;
	}

	public function countReplyByDiscussion($discussId)
	{
		return $this->model->fields('*')
			->where(['discussion_id' => $discussId])
			->count();
	}

	public function getList($discusId, $page, $pageSize)
	{
		$page = $page > 1 ? $page : 1;
		$offset = (int)(($page - 1) * $pageSize);
		$this->checkModel();
		//count total
		$countAll = $this->model->count(['discussion_id' => $discusId]);
		$trustLimit = \CommonService::get_instance()->generateTrustLimitData($countAll, $offset, $pageSize);
		$offset = $trustLimit['offset'];
		$pageSize = $trustLimit['pageSize'];
		$records = $this->model->fields('id,created_at')
			->where(['discussion_id' => $discusId])
			->with_discussion('fields:title,user_id')
			->with_user('fields:username')
			->with_user_profile('fields:avatar,country')
			->order_by('created_at')
			->limit($pageSize, $offset)
			->get_all();
		if (empty($records)) return false;
		//optimize query
		$listID = [];
		foreach ($records as $record) {
			$listID[] = $record->id;
		}
		if ($listID) {
			//get content after
			$dbRecord = $this->model->fields('id,content,markdown')
				->where('id', $listID)
				->get_all();
			$listContent = [];
			foreach ($dbRecord as $item) {
				$listContent[$item->id]['content'] = $item->content;
				$listContent[$item->id]['markdown'] = $item->markdown;
			}
			foreach ($records as $record) {
				$record->content = isset($listContent[$record->id]) ? $listContent[$record->id]['content'] : '';
				$record->markdown = isset($listContent[$record->id]) ? $listContent[$record->id]['markdown'] : '';
			}
		}

		return $records ? $records : [];
	}

	public function getPostById($postId)
	{
		$record = $this->model->fields('*')
			->with_discussion('fields:title,user_id')
			->with_user('fields:username')
			->with_user_profile('fields:avatar,country')
			->where(['id' => $postId])
			->get();
		return $record ? $record : null;
	}

	public function saveData($data)
	{
		return $this->model->insert($data);
	}

	public function getQuestionByDiscussionId($discussion_id)
	{
		$this->checkModel();
		$record = $this->model->fields('id')
			->where(['discussion_id' => $discussion_id])
			->order_by('created_at')
			->get();
		return $record ? $record : null;
	}

	public function getPostContentByPostId($postId)
	{
		$record = $this->model->fields('content,markdown')
			->where(['id' => $postId])
			->get();
		return $record ? $record : null;
	}

	/**
	 * @param $postId
	 * @return Post
	 */
	public function getStandalonePostById($postId) {
		$record = $this->model->fields('*')
						->get(['id'=>$postId]);
		return Post::create($record);
	}
	public function updateData($data, $postId)
	{
		return $this->model->update($data, $postId);
	}

	public function deleteData($postId)
	{
		return $this->model->delete(['id' => $postId]);
	}

	//Find by id function of post stat table.

	public function newPostStats($postId)
	{
		$data = [
			'post_id' => $postId,
			'like_count' => 0,
			'spam_count' => 0,
		];
		return $this->postStatModel->insert($data);
	}

	public function likeInc($postId)
	{
		$record = $this->findPostStatById($postId);
		$like_count = $record->like_count + 1;
		$data = [
			'post_id' => $postId,
			'like_count' => $like_count,
		];
		$this->postStatModel->update($data, $postId);

	}

	public function findPostStatById($id)
	{
		$record = $this->postStatModel->fields('*')
			->where(['post_id' => $id])
			->get();
		return $record;

	}

	public function likeDec($postId)
	{
		$record = $this->findPostStatById($postId);

		$like_count = $record->like_count - 1;
		$data = [
			'post_id' => $postId,
			'like_count' => $like_count,
		];
		$this->postStatModel->update($data, $postId);

	}

	public function spamInc($postId)
	{
		$record = $this->findPostStatById($postId);

		$spam_count = $record->spam_count + 1;
		$data = [
			'post_id' => $postId,
			'spam_count' => $spam_count,
		];
		$this->postStatModel->update($data, $postId);

	}

	public function spamDec($postId)
	{
		$record = $this->findPostStatById($postId);
		$spam_count = $record->spam_count - 1;
		$data = [
			'post_id' => $postId,
			'spam_count' => $spam_count,
		];
		$this->postStatModel->update($data, $postId);
	}

	public function checkDiscussHaveBestAnswer($discussId)
	{
		$record = $this->model->fields('id,created_at,content')
			->where(['discussion_id' => $discussId, 'best_answer' => 1])
			->with_user('fields:username')
			->with_user_profile('fields:avatar,country')
			->get();
		return $record;
	}

	public function markBestPost($postId, $discussId)
	{
		$record = $this->model->fields('id,content,best_answer')
			->where(['discussion_id' => $discussId, 'best_answer' => 1])
			->get();
		if ($record) {
			if ($record->id == $postId) return true;
			$data = [
				'best_answer' => null,
			];
			$this->model->update($data, $record->id);
		}

		$record = $this->model->fields('id,content,best_answer')
			->where(['id' => $postId])
			->get();
		if ($record) {
			$data = [
				'best_answer' => 1,
			];
			$this->model->update($data, $record->id);
			return true;
		} else {
			return false;
		}
	}

	public function checkPostOwner($userId, $postId)
	{
		$check = $this->model->fields('*')->where(['id' => $postId, 'user_id' => $userId])->count();
		return !!$check;
	}

	public function getUserIdByPostId($postId)
	{
		$record = $this->model->fields('user_id')
			->where(['id' => $postId])
			->get();
		return $record ? $record->user_id : null;
	}
}

