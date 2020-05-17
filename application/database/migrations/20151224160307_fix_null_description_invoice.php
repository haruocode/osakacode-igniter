<?php
/**
 * Migration: fix_null_description_invoice
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/24 16:03:07
 */
class Migration_fix_null_description_invoice extends CI_Migration {

	public function up()
	{
		$this->dbforge->modify_column('invoice',[
			'description'=>[
				'type'=> 'LONGTEXT',
				'NULL'=> TRUE
			]
		]);
	}

	public function down()
	{
		$this->dbforge->modify_column('invoice',[
			'description'=>[
				'type'=> 'VARCHAR',
				'constraint' => 255,
				'NULL'=> FALSE
			]
		]);
	}

}
