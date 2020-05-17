<?php
/**
 * Migration: alter_column_course_id_tableLesson
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/22 11:13:23
 */
class Migration_alter_column_course_id_tableLesson extends CI_Migration {

	public function up()
	{
		$this->dbforge->modify_column('lessons',[
			'course_id'=>[
				'type'=>'INT',
				'NULL'=>FALSE,
				'default'=>0
			]
		]);
	}

	public function down()
	{
		$this->dbforge->modify_column('lessons',[
			'course_id'=>[
				'type'=>'INT',
				'NULL'=>TRUE,
				'default'=>NULL
			]
		]);
	}
}
