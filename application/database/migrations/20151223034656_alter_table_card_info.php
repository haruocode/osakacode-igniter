<?php
/**
 * Migration: alter_table_card_info
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/23 03:46:56
 */
class Migration_alter_table_card_info extends CI_Migration {

	public function up()
	{
		$this->dbforge->drop_column('card_info','card_number');
		$this->dbforge->drop_column('card_info','card_expire_month');
		$this->dbforge->drop_column('card_info','card_expire_year');
		$this->dbforge->drop_column('card_info','card_cvv');
		$this->dbforge->add_column('card_info',[
			'card_token'=>[
				'type'=>'LONGTEXT'
			]
		]);
	}

	public function down()
	{
		$this->dbforge->drop_column('card_info','card_token');
		$this->dbforge->add_column('card_info',[
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
			]
		]);
	}

}
