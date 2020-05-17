<?php
/**
 * Migration: create_table_plan
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/09 07:25:12
 */
class Migration_create_table_plan extends CI_Migration {

	public function up()
	{
		// Creating a table
		$this->dbforge->add_field('id');
		$this->dbforge->add_field([
			'title'=>[
				'type'=>'VARCHAR',
				'constraint'=>255
			],
			'description'=>[
				'type'=>'VARCHAR',
				'constraint'=>255,
				'NULL'=>TRUE
			],
			'price'=>[
				'type'=>'INT',
				'default'=>0
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
		$this->dbforge->create_table('plans');
	}

	public function down()
	{
		$this->dbforge->drop_table('plans');
	}

}
