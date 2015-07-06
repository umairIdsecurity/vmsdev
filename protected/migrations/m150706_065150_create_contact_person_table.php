<?php

class m150706_065150_create_contact_person_table extends CDbMigration
{
	  // Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
            $this->createTable("contact_person", array(
                'id'=>'pk',
                'contact_person_name'=>'VARCHAR(50) NOT NULL',
                'contact_person_email'=>'VARCHAR(50) NOT NULL',
                'contact_person_message'=>'VARCHAR(100) NULL',
                'date_created' =>'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
              ));
	}

	public function safeDown()
	{
            $this->dropTable("contact_person");
	}
}