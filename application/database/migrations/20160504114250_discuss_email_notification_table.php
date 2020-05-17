<?php
/**
 * Migration: discuss_email_notification_table
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2016/05/04 11:42:50
 * @property CI_DB_forge $dbforge
 */
class Migration_discuss_email_notification_table extends CI_Migration {

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
			'discussion_id'=>[
				'type'=>'INT'
			],
			'user_id'=>[
				'type'=>'INT'
			],
			'created_at'=>[
				'type'=>'INT',
				'null'=>TRUE
			],
			'updated_at'=>[
				'type'=>'INT',
				'null'=>TRUE
			],
			'status'=>[
				'type'=>'TINYINT',
				'default'=>0
			]
		]);
		$this->dbforge->add_key('discussion_id',TRUE);
		$this->dbforge->add_key('user_id',TRUE);
		$this->dbforge->add_key(['discussion_id','user_id','status']);
		$this->dbforge->create_table('discuss_email_notifications');
	}

	public function down()
	{
		// Dropping a table
		$this->dbforge->drop_table('discuss_email_notifications');

//		// Dropping a Column From a Table
//		$this->dbforge->drop_column('table_name', 'column_to_drop');
	}

}
