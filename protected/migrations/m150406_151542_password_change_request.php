<?php

class m150406_151542_password_change_request extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `password_change_request` (
            `id` int(11)  NOT NULL AUTO_INCREMENT,
            `user_id` bigint(20) NOT NULL DEFAULT '0',
            `hash` varchar(255) NOT NULL DEFAULT '',
            `created_at` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
            `is_used` enum('YES','NO') NOT NULL DEFAULT 'NO',
            PRIMARY KEY (`id`),
            KEY user_id (`user_id`),
            CONSTRAINT `user_password_change_request_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
	}

	public function down()
	{
        $this->execute("DROP TABLE IF EXISTS `password_change_request`");
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}