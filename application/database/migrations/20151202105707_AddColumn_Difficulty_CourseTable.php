<?php
/**
 * Migration: AddColumn_Difficulty_CourseTable
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/02 10:57:07
 */
class Migration_AddColumn_Difficulty_CourseTable extends CI_Migration {

	public function up()
	{
		$fields = [
			'difficulty' => [
				'type'=> 'INT',
				'constraint'=>2,
				'default'=>0
			]
		];
		$this->dbforge->add_column('courses',$fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('courses','difficulty');
	}

}
