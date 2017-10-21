<?php

class m150601_044057_drop_table_contacts extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->dropTable("contacts");
	}

	public function safeDown()
	{
        $this->createTable("contacts", array(
            'id'         =>'pk',
            'company_id' =>'BIGINT(20) NOT NULL',
            'first_name'     =>'VARCHAR(50) NOT NULL',
            'last_name'     =>'VARCHAR(50) NOT NULL',
            'email'     =>'VARCHAR(50) NOT NULL',
            'mobile'     =>'VARCHAR(50) NOT NULL',
            'is_primary'     =>'TINYINT(1) NOT NULL DEFAULT "0"',
            'created_by'     =>'BIGINT(20) NOT NULL',
            'created_date'     =>'INT(10) DEFAULT NULL'
        ));
	}

}