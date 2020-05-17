<?php
/**
 * Migration: CreateUserTable
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/02 08:43:05
 */
class Migration_CreateUserTable extends CI_Migration {

	public function up()
	{
		// Creating a table
		$this->dbforge->add_field('id');
		$this->dbforge->add_field([
			'username'=>[
				'type'=>'VARCHAR',
				'constraint'=>255
			]
		]);
		$this->dbforge->add_field([
			'email'=>[
				'type'=>'VARCHAR',
				'constraint'=>255
			]
		]);
		$this->dbforge->add_field([
			'password' => [
				'type'=> 'VARCHAR',
				'constraint'=>255
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
		$this->dbforge->create_table('users');
	}

	public function down()
	{
		$this->dbforge->drop_table('users');
	}

}
