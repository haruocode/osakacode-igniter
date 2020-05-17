<?php
/**
 * Migration: create_invoices_table
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/09 08:40:55
 */
class Migration_create_invoices_table extends CI_Migration {

	public function up()
	{
		// Creating a table
		$this->dbforge->add_field('id');
		$this->dbforge->add_field([
			'user_id'=>[
				'type'=>'INT'
			],
			'description'=>[
				'type'=>'VARCHAR',
				'constraint'=>255
			],
			'quantity'=>[
				'type'=>'INT'
			],
			'plan_id'=>[
				'type'=>'INT'
			],
			'status'=>[
				'type'=>'TINYINT'
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
		$this->dbforge->create_table('invoice');
	}

	public function down()
	{
		$this->dbforge->drop_table('invoice');
	}
}
