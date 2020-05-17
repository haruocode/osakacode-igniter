<?php
namespace Solid\Repositories;

use Solid\Collections\Discussion;

/**
 * Class DiscussionRepository
 * @package Solid\Repositories
 * @property \MY_Model $model
 * @property \MY_Model $post_model
 */
class DiscussionRepository implements Repository
{
	private $model;

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
			throw new \Exception("Model not set");
		}
	}


	/**
	 * @param $id
	 * @return Discussion
	 * @throws \Exception
	 */
	public function findById($id)
	{
		// TODO: Implement findById() method.
		$this->checkModel();
		$record = $this->model->fields('*')->get(['id' => $id]);
		return Discussion::create($record);
	}

	public function getAll()
	{
		// TODO: Implement getAll() method.
		$this->checkModel();
	}


	/**
	 * Get list discussion
	 * @var int $page current page
	 * @var int $pageSize limit of page
	 * @var int channelId
	 * @var array $order array field need order, field=>asc,desc
	 * @return array
	 */
	public function getList($totalRecord,$page, $pageSize, $channelId = null, array $order = null)
	{
		$this->checkModel();
		$page = $page > 1 ? $page : 1;
		$offset = (int)(($page - 1) * $pageSize);

		$trustLimit = \CommonService::get_instance()->generateTrustLimitData($totalRecord, $offset, $pageSize);
		$offset = $trustLimit['offset'];
		$pageSize = $trustLimit['pageSize'];

		$query = $this->model->fields('id,title')
			->with_user('fields:username')
			->with_channel('fields:name')
			->limit($pageSize, $offset);
		if ($channelId) {
			$query = $query->where(['channel_id' => $channelId]);
		}
		if ($order) {
			$query = $query->order_by($order);
		} else {
			$query = $query->order_by(['created_at' => 'DESC']);
		}
		$records = $query->get_all();
		return $records ? $records : [];
	}

	public function countAll($channelId=null)
	{
		$this->checkModel();
		$query = $this->model->fields('*');
		if(!is_null($channelId)){
			$query = $query->where(['channel_id'=>$channelId]);
		}
		return $query->count();
	}

	public function getDiscussById($discussId)
	{
		$this->checkModel();
		$records = $this->model->fields('id,title,user_id')
			->with_channel('fields:name')
			->where(['id' => $discussId])
			->get();
		return $records ?: 0;
	}

	public function validateData($data)
	{
		if ($data['title'] == '') return false;
		if ($data['content'] == '') return false;
		if ($data['channel_id'] == '0') return false;
		return true;
	}

	public function saveData($data)
	{
		return $this->model->insert($data);
	}

	public function updateData($data, $discussId)
	{
		return $this->model->update($data, $discussId);
	}

	public function checkDiscussOwner($discussId,$userId){
		$check = $this->model->fields('*')->where(['id' => $discussId, 'user_id' => $userId])->count();
		return $check;
	}

	public function getUserIdByDiscussId($discussId)
	{
		$this->checkModel();
		$record = $this->model->fields('user_id')
			->where(['id' => $discussId])
			->get();
		return $record ?$record->user_id: null;
	}

	public function setDiscussUpdatedAt($discussId,$updatedAt){
		$this->model->update(['updated_at'=>$updatedAt],$discussId);
	}
}