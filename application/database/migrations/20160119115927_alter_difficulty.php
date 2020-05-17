<?php
/**
 * Migration: alter_difficulty
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2016/01/19 11:59:27
 */
class Migration_alter_difficulty extends CI_Migration {

	public function up()
	{
		$this->dbforge->modify_column('lessons',[
			'difficulty' => [
				'type'=> 'INT',
				'constraint'=>2,
				'default'=>1
			]
		]);
	}

	public function down()
	{
		$this->dbforge->modify_column('lessons',[
			'difficulty' => [
				'type'=> 'INT',
				'constraint'=>2,
				'default'=>0
			]
		]);

	}

}
