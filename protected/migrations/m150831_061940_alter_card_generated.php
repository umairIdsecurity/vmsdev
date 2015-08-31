<?php

class m150831_061940_alter_card_generated extends CDbMigration
{
 
	 
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
             $fkName = DatabaseIndexHelper::getForeignKeyName('card_generated','tenant','user','id');
             if(isset($fkName) && $fkName!='') {
			$this->dropForeignKey($fkName, "card_generated");
		}
	}

	public function safeDown()
	{
	}
	 
}