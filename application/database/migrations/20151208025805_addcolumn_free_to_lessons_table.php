<?php
/**
 * Migration: addcolumn_free_to_lessons_table
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/08 02:58:05
 */
class Migration_addcolumn_free_to_lessons_table extends CI_Migration {

	public function up()
	{
		$fields = [
			'free'=>[
				'type'=>'TINYINT',
				'default'=>0
			]
		];
		$this->dbforge->add_column('lessons',$fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('lessons','free');
	}
}
