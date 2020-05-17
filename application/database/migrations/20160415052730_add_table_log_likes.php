<?php
/**
 * Migration: add_table_log_likes
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2016/04/15 05:27:30
 */
class Migration_add_table_log_likes extends CI_Migration {

	public function up()
	{
//		// Creating a table
//		$this->dbforge->add_field(array(
//			'blog_id' => array(
//				'type' => 'INT',
//				'constraint' => 11,
//				'auto_increment' => TRUE
//			),
//			'blog_title' => array(
//				'type' => 'VARCHAR',
//				'constraint' => 100,
//			),
//			'blog_author' => array(
//				'type' =>'VARCHAR',
//				'constraint' => '100',
//				'default' => 'King of Town',
//			),
//			'blog_description' => array(
//				'type' => 'TEXT',
//				'null' => TRUE,
//			),
//		));
//		$this->dbforge->add_key('blog_id', TRUE);
//		$this->dbforge->create_table('blog');

//		// Adding a Column to a Table
//		$fields = array(
//			'preferences' => array('type' => 'TEXT')
//		);
//		$this->dbforge->add_column('table_name', $fields);
		$this->dbforge->add_field([
			'user_id'=>[
				'type'=>'INT'
			],
			'user_name'=>[
				'type'=>'VARCHAR',
				'null'=>TRUE,
				'constraint'=>255
			],
			'post_id'=>[
				'type'=>'INT'
			],
			'created_at'=>[
				'type'=>'INT'
			]
		]);
		$this->dbforge->add_key(['user_id','post_id'],TRUE);
		$this->dbforge->create_table('log_likes');
	}

	public function down()
	{
//		// Dropping a table
		$this->dbforge->drop_table('log_likes');

//		// Dropping a Column From a Table
//		$this->dbforge->drop_column('table_name', 'column_to_drop');
	}

}
