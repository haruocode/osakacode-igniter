<?php
/**
 * Migration: CreateLessonTable
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/02 07:29:38
 */
class Migration_CreateLessonTable extends CI_Migration {

	public function up()
	{
		// Creating a table
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'title' => [
				'type' => 'VARCHAR',
				'constraint' => 255
			],
			'course_id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'NULL' => TRUE
			],
			'order' => [
				'type' => 'INT',
				'constraint'=>11,
				'unsigned'=> TRUE,
			],
			//a lesson time - by second
			'time' => [
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE
			],
			'description' => [
				'type' => 'VARCHAR',
				'NULL'=>TRUE,
				'constraint' => 255
			],
			'point' => [
				'type' => 'INT',
				'default'=>0,
				'constraint' => 11
			],
			'created_at' => array(
				'type'=>'DATETIME',
				'NULL'=>TRUE,
			),
			'updated_at' => array(
				'type'=>'DATETIME',
				'NULL'=>TRUE,
			)
		));


		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('lessons', TRUE);

	}

	public function down()
	{
		$this->dbforge->drop_table('lessons');
	}

}
