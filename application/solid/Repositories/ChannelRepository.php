<?php
namespace Solid\Repositories;

/**
 * Class ChannelRepository
 * @package Solid\Repositories
 * @property \MY_Model $model
 */
class ChannelRepository extends BaseRepository implements Repository {

	public function save()
	{
		// TODO: Implement save() method.
		$this->checkModel();
	}

	public function getAll()
	{
		// TODO: Implement getAll() method.
		$this->checkModel();
		$list = $this->model->get_all();
		return $list ?: [];
	}

	public function findById($id)
	{
		// TODO: Implement findById() method.
		$this->checkModel();
	}

	public function getChannelNameById($channelId){
		$this->checkModel();
		$record = $this->model->fields('name')
			->where(['id'=>$channelId])
			->get();
		return $record?$record->name:null;
	}
}