<?php
/**
 * Migration: add_column_cources_table
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2016/01/08 10:07:30
 */
class Migration_add_column_cources_table extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_column('courses', [
                    'link_id'=>[
                        'type'=>'LONGTEXT',
                        ]
                    ]);
	}

	public function down()
	{
                $this->dbforge->drop_column('courses','link_id');
	}

}
