<?php
/**
 * Migration: remove_card_token
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/24 13:33:12
 */
class Migration_remove_card_token extends CI_Migration {

	public function up()
	{
		$this->dbforge->drop_column('card_info','card_token');
	}

	public function down()
	{
		$this->dbforge->add_column('card_info',[
			'card_token'=>[
				'type'=>'LONGTEXT'
			]
		]);
	}

}
