<?php
/**
 * Migration: create_users_lessons_table
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/09 08:37:22
 */
class Migration_create_users_lessons_table extends CI_Migration {

	public function up()
	{
		// Creating a table
		$this->dbforge->add_field('id');
		$this->dbforge->add_field([
			'user_id'=>[
				'type'=>'INT'
			],
			'lesson_id'=>[
				'type'=>'INT'
			],
			'status'=>[
				'type'=>'TINYINT',
				'default'=>0
			]
		]);
		$this->dbforge->create_table('users_lessons');
	}

	public function down()
	{
		$this->dbforge->drop_table('users_lessons');
	}

}
