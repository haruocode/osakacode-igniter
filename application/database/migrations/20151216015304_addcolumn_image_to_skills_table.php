<?php
/**
 * Migration: addcolumn_image_to_skills_table
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/16 01:53:04
 */
class Migration_addcolumn_image_to_skills_table extends CI_Migration {

	public function up()
	{
		$fields = [
			'image'=>[
				'type'=>'VARCHAR',
				'constraint'=>255
			]
		];
		$this->dbforge->add_column('skills',$fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('skills','image');
	}

}
