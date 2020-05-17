<?php
/**
 * Migration: create_card_info_table
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/09 07:43:08
 */
class Migration_create_card_info_table extends CI_Migration {

	public function up()
	{
		// Creating a table
		$this->dbforge->add_field('id');
		$this->dbforge->add_field([
			'user_id' => [
				'type'=>'INT'
			],
			'card_number'=>[
				'type'=>'TEXT'
			],
			'card_expire_month'=>[
				'type'=>'INT'
			],
			'card_expire_year'=>[
				'type'=>'INT'
			],
			'card_cvv'=>[
				'type'=> 'INT'
			],
			'created_at' => [
				'type'=>'DATETIME',
				'NULL'=>TRUE,
			],
			'updated_at' => [
				'type'=>'DATETIME',
				'NULL'=>TRUE,
			]
		]);
		$this->dbforge->create_table('card_info');
	}

	public function down()
	{
		$this->dbforge->drop_table('card_info');
	}

}
