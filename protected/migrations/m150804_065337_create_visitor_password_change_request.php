<?php

class m150804_065337_create_visitor_password_change_request extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE visitor_password_change_request (
            id int(11)  NOT NULL AUTO_INCREMENT,
            visitor_id bigint(20) NOT NULL DEFAULT '0',
            hash varchar(255) NOT NULL DEFAULT '',
            created_at DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
            is_used enum('YES','NO') NOT NULL DEFAULT 'NO',
            PRIMARY KEY (id),
            UNIQUE KEY (hash),
            KEY visitor_id (visitor_id),
            CONSTRAINT visitor_password_change_request_visitor_id FOREIGN KEY (visitor_id) REFERENCES visitor (id) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
	}

	public function down()
	{
        $this->execute("DROP TABLE IF EXISTS visitor_password_change_request");
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