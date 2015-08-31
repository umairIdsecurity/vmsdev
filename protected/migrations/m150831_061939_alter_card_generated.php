<?php

class m150831_061939_alter_card_generated extends CDbMigration
{
 
	 
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
           $this->dropForeignKey("card_generated_ibfk_3", "card_generated");
	}

	public function safeDown()
	{
	}
	 
}