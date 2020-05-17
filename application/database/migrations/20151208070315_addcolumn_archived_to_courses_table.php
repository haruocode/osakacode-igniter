<?php
/**
 * Migration: addcolumn_archived_to_courses_table
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/08 07:03:15
 */
class Migration_addcolumn_archived_to_courses_table extends CI_Migration {

	public function up()
	{
		$fields = [
			'archived'=>[
				'type'=>'TINYINT',
				'default'=>0
			]
		];
		$this->dbforge->add_column('courses',$fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('courses','archived');
	}

}
