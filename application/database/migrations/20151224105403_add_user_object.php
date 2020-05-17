<?php
/**
 * Migration: add_user_object
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/24 10:54:03
 */
class Migration_add_user_object extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('card_info',[
			'user_object'=>[
				'type'=>'LONGTEXT'
			]
		]);
	}

	public function down()
	{
		$this->dbforge->drop_column('card_info','user_object');
	}

}
