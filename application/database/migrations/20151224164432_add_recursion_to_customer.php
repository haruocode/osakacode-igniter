<?php
/**
 * Migration: add_recursion_to_customer
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/24 16:44:32
 */
class Migration_add_recursion_to_customer extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('card_info', [
			'recursion_id' => [
				'type' => 'LONGTEXT',
				'NULL' => TRUE
			]
		]);
	}

	public function down()
	{
		$this->dbforge->drop_column('card_info', 'recursion_id');
	}

}
