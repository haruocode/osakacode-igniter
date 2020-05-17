<?php
/**
 * Migration: add_invoice_id
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/25 07:43:23
 */
class Migration_add_invoice_id extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('invoice', [
			'invoice_id' => [
				'type' => 'VARCHAR',
				'constraint' => 255
			]
		]);
	}

	public function down()
	{
		$this->dbforge->drop_column('invoice', 'invoice_id');
	}

}
