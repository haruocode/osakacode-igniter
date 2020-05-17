<?php
/**
 * Created by PhpStorm.
 * User: Administrator PC
 * Date: 4/29/2016
 * Time: 4:50 PM
 */

namespace Solid\Repositories;


use Solid\Collections\Notification;

abstract class NotificationRepository extends BaseRepository
{
	
	abstract function add(Notification $notification);
	/**
	 * @return mixed
	 */
	public function save()
	{
		// TODO: Implement save() method.
	}

	/**
	 * @return mixed
	 */
	public function getAll()
	{
		// TODO: Implement getAll() method.
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function findById($id)
	{
		// TODO: Implement findById() method.
	}

}