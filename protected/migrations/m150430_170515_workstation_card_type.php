<?php

class m150430_170515_workstation_card_type extends CDbMigration
{
	public function safeUp()
	{
        $table = Yii::app()->db->schema->getTable('workstation_card_type');
        if(!isset($table)){

            $this->execute("

                    CREATE TABLE `workstation_card_type` (
                            `workstation` bigint(20) NOT NULL,
                            `card_type` bigint(20) NOT NULL,
                            `user` bigint(20) NOT NULL,
                            PRIMARY KEY (`workstation`,`card_type`),
                            CONSTRAINT `workstation_card_type_workstation` FOREIGN KEY (`workstation`) REFERENCES `workstation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                            CONSTRAINT `workstation_card_type_card_type` FOREIGN KEY (`card_type`) REFERENCES `card_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                            CONSTRAINT `workstation_card_user` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
                            )
            ");

        }

        $table = Yii::app()->db->schema->getTable('module');
        if(!isset($table)) {
            $this->execute("

                  CREATE TABLE IF NOT EXISTS `module` (
                          `id` bigint(20) NOT NULL AUTO_INCREMENT,
                          `name` varchar(255) NOT NULL,
                          `about` varchar(255) DEFAULT NULL,
                          `created_by` datetime DEFAULT NULL,
                          PRIMARY KEY (`id`)
			              )
            ");


            $this->execute("

                  INSERT INTO `module` (`id`, `name`, `about`, `created_by`) VALUES
			              (1, 'Corporate', NULL, NULL),
			              (2, 'VIC Issuing', NULL, NULL);
                  ");
        }

        $table = Yii::app()->db->schema->getTable('card_type');
        if(!isset($table->columns['module'])) {


            $this->execute("ALTER TABLE card_type ADD module bigint(20)");

            $this->execute("ALTER TABLE `card_type` ADD CONSTRAINT `card_type_module` FOREIGN KEY (`module`) REFERENCES `module` (`id`)");


            $this->execute("

                    INSERT INTO `card_type` (`name`, `max_day_validity`, `max_time_validity`, `max_entry_count_validity`, `card_icon_type`, `card_background_image_path`, `created_by` , `module`) VALUES
                        ('Corporate Visitor', 1, NULL, NULL, NULL, NULL, NULL,1),
                        ('Corporate Visitor Contractor', 1, NULL, NULL, NULL, NULL, NULL,1),
                        ('Manual', 1, NULL, NULL, NULL, NULL, NULL,1),
                        ('Extended VIC', 1, NULL, NULL, NULL, NULL, NULL,2),
                        ('24 hour VIC', 1, NULL, NULL, NULL, NULL, NULL,2),
                        ('Manual VIC', 1, NULL, NULL, NULL, NULL, NULL,2),
                        ('Same Day VIC', 1, NULL, NULL, NULL, NULL, NULL,2),
                        ('Multiday VIC', 1, NULL, NULL, NULL, NULL, NULL,2);

            ");
        }
	}

	public function safeDown()
	{
        $table = Yii::app()->db->schema->getTable('card_type');
        if(isset($table->columns['module'])) {

            $this->execute("DELETE FROM `card_type` ");

                $this->execute("ALTER TABLE `card_type` DROP CONSTRAINT `card_type_module`");

            $this->execute("ALTER TABLE card_type DROP COLUMN module");
        }

        $table = Yii::app()->db->schema->getTable('module');
        if(isset($table)) {

            $this->execute("DELETE FROM `module` ");

            $this->execute("DROP TABLE `module` ");

        }

        $table = Yii::app()->db->schema->getTable('workstation_card_type');
        if(isset($table)) {

            $this->execute("DROP TABLE `workstation_card_type`");
        }
    }

}