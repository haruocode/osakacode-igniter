<?php
/**
 * Migration: fix_invoice_table
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/24 15:35:57
 */
class Migration_fix_invoice_table extends CI_Migration {

	public function up()
	{
		$this->dbforge->drop_column('invoice', 'card_number');
		$this->dbforge->drop_column('invoice', 'card_expire_month');
		$this->dbforge->drop_column('invoice', 'card_expire_year');
		$this->dbforge->drop_column('invoice', 'card_cvv');
	}

	public function down()
	{
		$this->dbforge->add_column('invoice',[
			'card_cvv'=>[
				'type'=>'INT'
			]
		]);
		$this->dbforge->add_column('invoice',[
			'card_number'=>[
				'type'=>'INT'
			]
		]);
		$this->dbforge->add_column('invoice',[
			'card_expire_month'=>[
				'type'=>'INT'
			]
		]);
		$this->dbforge->add_column('invoice',[
			'card_expire_year'=>[
				'type'=>'INT'
			]
		]);
	}

}
