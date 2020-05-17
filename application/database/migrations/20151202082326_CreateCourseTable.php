<?php
/**
 * Migration: CreateCourseTable
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/02 08:23:26
 */
class Migration_CreateCourseTable extends CI_Migration {

	public function up()
	{
		// Creating a table
		$this->dbforge->add_field('id');
		$this->dbforge->add_field(array(
			'created_at' => array(
				'type'=>'DATETIME',
				'NULL'=>TRUE,
			),
			'updated_at' => array(
				'type'=>'DATETIME',
				'NULL'=>TRUE,
			)
		));

		$this->dbforge->add_field([
			'description'=>[
				'type'=>'VARCHAR',
				'constraint'=>255,
				'NULL'=>TRUE
			]
		]);
		$this->dbforge->add_field([
			'title'=>[
				'type'=>'VARCHAR',
				'constraint'=>255
			]
		]);
		$this->dbforge->add_field([
			'image'=>[
				'type'=>'VARCHAR',
				'constraint'=>255,
				'NULL'=>TRUE
			]
		]);
		$this->dbforge->create_table('courses');
	}

	public function down()
	{
		$this->dbforge->drop_table('courses');
	}

}
