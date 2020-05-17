<?php
/**
 * Migration: create_skills_lessons_table
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/16 16:07:42
 */
class Migration_create_skills_lessons_table extends CI_Migration {

	public function up()
	{
		// Creating a table
		$this->dbforge->add_field('id');

		$this->dbforge->add_field([
			'skill_id'=>[
				'type'=>'INT'
			],
			'lesson_id'=>[
				'type'=>'INT'
			],
			'order'=>[
				'type'=>'INT'
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
		$this->dbforge->create_table('skills_lessons');
	}

	public function down()
	{
		$this->dbforge->drop_table('skills_lessons');
	}
}
