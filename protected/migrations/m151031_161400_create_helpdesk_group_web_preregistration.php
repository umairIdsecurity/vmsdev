<?php

class m151031_161400_create_helpdesk_group_web_preregistration extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        if(!in_array('helpdesk_group_web_preregistration',$this->dbConnection->getSchema()->tableNames)) {

            $this->createTable('helpdesk_group_web_preregistration', array(
                'helpdesk_group' => 'BIGINT NOT NULL',
                'web_preregistration' => 'VARCHAR(20)',
            ));
        }

        $name = DatabaseIndexHelper::getForeignKeyName('helpdesk_group_web_preregistration', 'helpdesk_group', 'helpdesk_group', 'id');
        if($name==null) {
            $this->addForeignKey('helpdesk_group_web_preregistration_helpdesk_group_fk', 'helpdesk_group_web_preregistration', 'helpdesk_group', 'helpdesk_group', 'id');
        }

        $name = DatabaseIndexHelper::getForeignKeyName('helpdesk_group_user_role', 'helpdesk_group', 'helpdesk_group', 'id');
        if($name==null) {
            $this->addForeignKey('helpdesk_group_user_role_helpdesk_group_fk', 'helpdesk_group_user_role', 'helpdesk_group', 'helpdesk_group', 'id');
        }

    }

	public function safeDown()
	{
	}
	
}