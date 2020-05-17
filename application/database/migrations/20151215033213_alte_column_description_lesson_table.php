<?php
/**
 * Migration: alte_column_description_lesson_table
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/15 03:32:13
 */
class Migration_alte_column_description_lesson_table extends CI_Migration {

	public function up()
	{
		$fields = array(
			'description'=>[
				'type'=>'TEXT'
			]
		);
		$this->dbforge->modify_column('lessons',$fields);
	}

	public function down()
	{
		$this->dbforge->modify_column('lessons',[
			'description'=>[
				'type'=>'VARCHAR',
				'constraint'=>255
			]
		]);
	}

}
