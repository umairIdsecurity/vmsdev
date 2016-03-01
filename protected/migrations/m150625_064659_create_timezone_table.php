<?php

class m150625_064659_create_timezone_table extends CDbMigration
{
	  // Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
            $this->createTable("timezone", array(
                'id'=>'pk',
                'timezone_name'=>'VARCHAR(250) NOT NULL',
                'timezone_value'=>'VARCHAR(250) NOT NULL',
              ));
	}

	public function safeDown()
	{
            $this->dropTable("timezone");
	}
}