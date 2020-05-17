<?php
/**
 * Migration: addcolumn_video_url_to_lessons_table
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/08 02:34:11
 */
class Migration_addcolumn_video_url_to_lessons_table extends CI_Migration {

	public function up()
	{
		$fields = [
			'video_url'=>[
				'type'=>'VARCHAR',
				'constraint'=>255
			]
		];
		$this->dbforge->add_column('lessons',$fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('lessons','video_url');
	}

}
