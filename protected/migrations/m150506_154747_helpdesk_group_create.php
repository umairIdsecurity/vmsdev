<?php

class m150506_154747_helpdesk_group_create extends CDbMigration
{
	
	public function safeUp()
	{
        $table = Yii::app()->db->schema->getTable('helpdesk_group');
        if(!isset($table)){

            $this->execute("

                   CREATE TABLE IF NOT EXISTS `helpdesk_group` (
                            `id` bigint(20) NOT NULL AUTO_INCREMENT,
                            `name` varchar(255) NOT NULL,
                            `order_by` int(6) DEFAULT NULL,
							`created_by` bigint(20) DEFAULT NULL,
							`is_deleted` bigint(1) DEFAULT 0,
                            PRIMARY KEY (`id`)                             )
            ");

        }

	}

	public function safeDown()
	{
        $table = Yii::app()->db->schema->getTable('helpdesk_group');
        if(isset($table)) {

            $this->execute("DELETE FROM `helpdesk_group` ");

            $this->execute("DROP TABLE `helpdesk_group` ");

        }

      
    }

}