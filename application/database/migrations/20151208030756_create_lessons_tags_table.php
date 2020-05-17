<?php
/**
 * Migration: create_lessons_tags_table
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/08 03:07:56
 */
class Migration_create_lessons_tags_table extends CI_Migration {

	public function up()
	{
		// Creating a table
		$this->dbforge->add_field('id');
		$this->dbforge->add_field([
			'tag_id'=>[
				'type'=>'INT'
			],
			'lesson_id'=>[
				'type'=>'INT'
			]
		]);
		$this->dbforge->create_table('lessons_tags');
	}

	public function down()
	{
		$this->dbforge->drop_table('lessons_tags');
	}

}
