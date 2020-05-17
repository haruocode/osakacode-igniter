<?php
/**
 * Migration: create_tags_table
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/08 03:11:32
 */
class Migration_create_tags_table extends CI_Migration {

	public function up()
	{
		// Creating a table
		$this->dbforge->add_field('id');
		$this->dbforge->add_field([
			'name'=>[
				'type'=>'VARCHAR',
				'constraint'=>255
			],
			'created_at' => [
				'type'=>'DATETIME',
				'NULL'=>TRUE,
			],
			'updated_at' => [
				'type'=>'DATETIME',
				'NULL'=>TRUE,
			]
		]);
		$this->dbforge->create_table('tags');
	}

	public function down()
	{
		$this->dbforge->drop_table('tags');
	}

}
