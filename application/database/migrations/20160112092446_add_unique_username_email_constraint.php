<?php
/**
 * Migration: add_unique_username_email_constraint
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2016/01/12 09:24:46
 */
class Migration_add_unique_username_email_constraint extends CI_Migration {

	public function up()
	{
        $this->dbforge->modify_column('users',[
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
            ],
        ]);
	}

	public function down()
	{
        $this->dbforge->modify_column('users',[
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
	}

}
