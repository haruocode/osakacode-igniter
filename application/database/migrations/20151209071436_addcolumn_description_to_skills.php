<?php
/**
 * Migration: addcolumn_description_to_skills
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/09 07:14:36
 */
class Migration_addcolumn_description_to_skills extends CI_Migration {

	public function up()
	{
		$fields = [
			'description'=>[
				'type'=>'VARCHAR',
				'constraint'=>255,
				'NULL'=>TRUE
			]
		];
		$this->dbforge->add_column('skills', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('skills','description');
	}

}
