<?php
/**
 * Migration: addcolumn_exp_to_users_table
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/09 07:22:32
 */
class Migration_addcolumn_exp_to_users_table extends CI_Migration {

	public function up()
	{
		$fields = [
			'exp'=>[
				'type'=>'INT',
				'default'=>0
			],
			'plan_id'=>[
				'type'=>'INT',
				'NULL'=>TRUE
			]
		];
		$this->dbforge->add_column('users',$fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('users','exp');
		$this->dbforge->drop_column('users','plan_id');
	}

}
