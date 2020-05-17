<?php
/**
 * Migration: alter_column_description_course_table
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/15 07:10:13
 */
class Migration_alter_column_description_course_table extends CI_Migration {

	public function up()
	{
		$fields = [
			'description'=>[
				'type'=>'TEXT'
			]
		];
		$this->dbforge->modify_column('courses', $fields);
	}

	public function down()
	{
		$fields = [
			'description'=>[
				'type'=>'VARCHAR',
				'constraint'=>255
			]
		];
		$this->dbforge->modify_column('courses', $fields);
	}
}
