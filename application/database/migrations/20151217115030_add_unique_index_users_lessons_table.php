<?php
/**
 * Migration: add_unique_index_users_lessons_table
 *
 * Created by: Cli for CodeIgniter <https://github.com/kenjis/codeigniter-cli>
 * Created on: 2015/12/17 11:50:30
 */
class Migration_add_unique_index_users_lessons_table extends CI_Migration {

	public function up()
	{
		$this->db->query('ALTER TABLE `users_lessons`
							ADD UNIQUE INDEX `unique_index` (`user_id`, `lesson_id`)');
	}

	public function down()
	{
		$this->db->query("ALTER TABLE `users_lessons`
							DROP INDEX `unique_index`");
	}

}
