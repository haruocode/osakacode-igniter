<?php
/**
 * Migration: add_table_user_history
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/29 16:18:29
 */
class Migration_add_table_user_history extends CI_Migration {

	public function up()
	{
		// Creating a table
		$this->dbforge->add_field('id');
		$this->dbforge->add_field([
			'user_id'=>[
				'type'=>'INT'
			],
			'last_login'=>[
				'type'=>'DATETIME'
			]
		]);
		$this->dbforge->add_field([
			'created_at' => [
				'type'=>'DATETIME',
				'NULL'=>TRUE,
			],
			'updated_at' => [
				'type'=>'DATETIME',
				'NULL'=>TRUE,
			]
		]);
		$this->dbforge->create_table('user_history');
	}

	public function down()
	{
		$this->dbforge->drop_table('user_history');
	}
}
