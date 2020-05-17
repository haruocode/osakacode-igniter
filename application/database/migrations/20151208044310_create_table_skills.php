<?php
/**
 * Migration: create_table_skills
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/08 04:43:10
 */
class Migration_create_table_skills extends CI_Migration {

	public function up()
	{
		// Creating a table
		$this->dbforge->add_field('id');
		$this->dbforge->add_field([
			'name'=>[
				'type'=>'VARCHAR',
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
		$this->dbforge->create_table('skills');
	}

	public function down()
	{
		$this->dbforge->drop_table('skills');
	}

}
