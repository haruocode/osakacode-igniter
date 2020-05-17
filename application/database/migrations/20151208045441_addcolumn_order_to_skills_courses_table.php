<?php
/**
 * Migration: addcolumn_order_to_skills_courses_table
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/08 04:54:41
 */
class Migration_addcolumn_order_to_skills_courses_table extends CI_Migration {

	public function up()
	{
		//add column
		$fields = [
			'order'=>[
				'type'=>'TINYINT',
				'default'=>0
			]
		];
		$this->dbforge->add_column('skills_courses',$fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('skills_courses','order');
	}

}
