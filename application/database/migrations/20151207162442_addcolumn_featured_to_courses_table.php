<?php
/**
 * Migration: addcolumn_featured_to_courses_table
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/07 16:24:42
 */
class Migration_addcolumn_featured_to_courses_table extends CI_Migration {

	public function up()
	{
		$column = [
			'featured'=>[
				'type'=>'TINYINT',
				'default'=>0
			]
		];
		$this->dbforge->add_column('courses', $column);
	}

	public function down()
	{
		$this->dbforge->drop_column('courses', 'featured');
	}

}
