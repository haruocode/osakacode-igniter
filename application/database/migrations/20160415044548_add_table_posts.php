<?php
/**
 * Migration: add_table_posts
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2016/04/15 04:45:48
 */
class Migration_add_table_posts extends CI_Migration {

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
		$this->dbforge->add_field('id');
		$this->dbforge->add_field([
			'user_id'=>[
				'type'=>'INT'
			],
			'discussion_id'=>[
				'type'=>'INT'
			],
			'content'=>[
				'type'=>'TEXT'
			],
			'created_at'=>[
				'type'=>'INT'
			],
			'updated_at'=>[
				'type'=>'INT'
			],
			'deleted_at'=>[
				'type'=>'INT',
				'null'=>TRUE
			]
		]);
		$this->dbforge->add_key(['user_id','discussion_id','created_at','updated_at','deleted_at']);
		$this->dbforge->create_table('posts');
	}

	public function down()
	{
//		// Dropping a table
//		$this->dbforge->drop_table('blog');

//		// Dropping a Column From a Table
//		$this->dbforge->drop_column('table_name', 'column_to_drop');
		$this->dbforge->drop_table('posts');
	}

}
