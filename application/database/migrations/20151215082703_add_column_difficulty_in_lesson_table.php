<?php
/**
 * Migration: add_column_difficulty_in_lesson_table
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/15 08:27:03
 */
class Migration_add_column_difficulty_in_lesson_table extends CI_Migration {

	public function up()
	{
		// Creating a table
		$fields = [
			'difficulty'=>[
                'type'=>'INT',
                'default'=>0
            ]
		];
        $this->dbforge->add_column('lessons',$fields);
	}

	public function down()
	{
        $this->dbforge->drop_column('lessons','difficulty');
	}
}
