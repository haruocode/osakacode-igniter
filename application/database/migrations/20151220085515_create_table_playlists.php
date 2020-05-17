<?php
/**
 * Migration: create_table_playlists
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/20 08:55:15
 */
class Migration_create_table_playlists extends CI_Migration {

	public function up()
	{
		// Creating a table
		$this->dbforge->add_field('id');
		$this->dbforge->add_field([
			'object_id'=>[
				'type'=>'INT'
			],
			'user_id'=>[
				'type'=>'INT'
			],
			'object_type'=>[
				'type'=>'TINYINT'
			],
			'playlist_type'=>[
				'type'=>'TINYINT'
			],
			'created_at' => [
				'type'=>'DATETIME',
				'NULL'=>TRUE,
			],
			'updated_at' => [
				'type'=>'DATETIME',
				'NULL'=>TRUE,
			]
		]);
		$this->dbforge->create_table('playlist');
		$this->db->query('ALTER TABLE `playlist`
							ADD UNIQUE INDEX `unique_index` (`object_id`, `user_id`, `object_type`, `playlist_type`)');
	}

	public function down()
	{
		$this->dbforge->drop_table('playlist');
	}

}
