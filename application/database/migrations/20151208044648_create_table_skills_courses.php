<?php
/**
 * Migration: create_table_skills_courses
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/08 04:46:48
 */
class Migration_create_table_skills_courses extends CI_Migration {

	public function up()
	{
		// Creating a table
		$this->dbforge->add_field('id');
		$this->dbforge->add_field([
			'skill_id'=>[
				'type'=>'INT'
			],
			'course_id'=>[
				'type'=>'INT'
			]
		]);
		$this->dbforge->create_table('skills_courses');
	}

	public function down()
	{
		$this->dbforge->drop_table('skills_courses');
	}
}
