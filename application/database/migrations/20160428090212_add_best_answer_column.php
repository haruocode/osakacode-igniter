<?php
/**
 * Migration: add_best_answer_column
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2016/04/28 09:02:12
 */
class Migration_add_best_answer_column extends CI_Migration {

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
		$fields = [
			'best_answer'=>[
				'type'=>'INT',
				null=>TRUE
			]
		];
		$this->dbforge->add_column('posts',$fields);
		$this->db->query('ALTER TABLE `posts`
						  ADD INDEX `best_answer` (`best_answer`)');
	}

	public function down()
	{
//		// Dropping a table
//		$this->dbforge->drop_table('blog');

//		// Dropping a Column From a Table
//		$this->dbforge->drop_column('table_name', 'column_to_drop');
		$this->dbforge->drop_column('posts','best_answer');
		$this->db->query('ALTER TABLE `posts` DROP INDEX `best_answer`');
	}

}
