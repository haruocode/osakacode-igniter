<?php
/**
 * Migration: create_users_profile_table
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/09 07:37:24
 */
class Migration_create_users_profile_table extends CI_Migration {

	public function up()
	{
		// Creating a table
		$this->dbforge->add_field('id');
		$this->dbforge->add_field([
			'user_id'=>[
				'type'=>'INT'
			],
			'avatar'=>[
				'type'=>'VARCHAR',
				'constraint'=>255,
				'NULL'=>TRUE
			],
			'website'=>[
				'type'=>'VARCHAR',
				'constraint'=>255,
				'NULL'=>TRUE
			],
			'twitter'=>[
				'type'=>'VARCHAR',
				'constraint'=>255,
				'NULL'=>TRUE
			],
			'github'=>[
				'type'=>'VARCHAR',
				'constraint'=>255,
				'NULL'=>TRUE
			],
			'work_place'=>[
				'type'=>'VARCHAR',
				'constraint'=>255,
				'NULL'=>TRUE
			],
			'job_title'=>[
				'type'=>'VARCHAR',
				'constraint'=>255,
				'NULL'=>TRUE
			],
			'country'=>[
				'type'=>'VARCHAR',
				'constraint'=>255,
				'NULL'=>TRUE
			],
			'hometown'=>[
				'type'=>'VARCHAR',
				'constraint'=>255,
				'NULL'=>TRUE
			],
			'can_hire'=>[
				'type'=>'TINYINT',
				'constraint'=>255,
				'default'=>0
			],
			'public_profile'=>[
				'type'=>'TINYINT',
				'constraint'=>255,
				'default'=>0
			]
		]);
		$this->dbforge->add_field([
			'created_at' => [
				'type'=>'DATETIME',
				'NULL'=>TRUE,
			],
			'updated_at' => [
				'type'=>'DATETIME',
				'NULL'=>TRUE,
			]
		]);
		$this->dbforge->create_table('users_profile');
	}

	public function down()
	{
		$this->dbforge->drop_table('users_profile');
	}

}
