<?php

class m150430_022917_add_workstation_card_type extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE `workstation_card_type` (
  			`id` bigint(20) NOT NULL,
  			`workstation` bigint(20) NOT NULL,
  			`card_type` bigint(20) NOT NULL,
  			`user` bigint(20) NOT NULL,
            PRIMARY KEY (`id`),
            CONSTRAINT `workstation_card_type_workstation` FOREIGN KEY (`workstation`) REFERENCES `workstation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
            CONSTRAINT `workstation_card_type_card_type` FOREIGN KEY (`card_type`) REFERENCES `card_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
            CONSTRAINT `workstation_card_user` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
	}

	public function down()
	{
		$this->execute("DROP TABLE IF EXISTS `workstation_card_type`");
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