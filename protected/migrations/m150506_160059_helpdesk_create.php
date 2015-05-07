<?php

class m150506_160059_helpdesk_create extends CDbMigration
{
	public function safeUp()
	{
        $table = Yii::app()->db->schema->getTable('helpdesk');
        if(!isset($table)){

            $this->execute("

                   CREATE TABLE IF NOT EXISTS `helpdesk` (
                            `id` bigint(20) NOT NULL AUTO_INCREMENT,
                            `question` varchar(255) NOT NULL,
							`answer` text NOT NULL,
                            `helpdesk_group_id` bigint(20) NOT NULL,
							`order_by` int(6) DEFAULT NULL,
							`created_by` bigint(20) DEFAULT NULL,
							`is_deleted` int(1) DEFAULT 0,
                            PRIMARY KEY (`id`),
                            CONSTRAINT `helpdesk_helpdesk_group` FOREIGN KEY (`helpdesk_group_id`) REFERENCES `helpdesk_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE                             )
            ");

        }

	}

	public function safeDown()
	{
        $table = Yii::app()->db->schema->getTable('helpdesk');
        if(isset($table)) {

            $this->execute("DELETE FROM `helpdesk` ");

            $this->execute("DROP TABLE `helpdesk` ");

        }

      
    }
}