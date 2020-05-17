<?php
/**
 * Migration: add_reset_key
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2016/01/06 11:47:04
 */
class Migration_add_reset_key extends CI_Migration {

	public function up()
	{
		// Adding a Column to a Table
		$fields = array(
			'reset_key' => array('type' => 'TEXT')
		);
		$this->dbforge->add_column('users', $fields);
	}

	public function down()
	{
		// Dropping a Column From a Table
		$this->dbforge->drop_column('users', 'reset_key');
	}

}
