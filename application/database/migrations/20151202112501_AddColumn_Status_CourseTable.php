<?php
/**
 * Migration: AddColumn_Status_CourseTable
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/02 11:25:01
 */
class Migration_AddColumn_Status_CourseTable extends CI_Migration {

	public function up()
	{
		$fields = [
			'status' => [
				'type' => 'INT',
				'constraint'=>2,
				'default'=>0
			]
		];
		$this->dbforge->add_column('courses', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('courses', 'status');
	}

}
