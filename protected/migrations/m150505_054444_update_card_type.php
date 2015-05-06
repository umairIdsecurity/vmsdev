<?php

class m150505_054444_update_card_type extends CDbMigration
{
	public function up()
	{
		$this->execute("UPDATE card_type SET module=1 WHERE id=1");
		$this->execute("UPDATE card_type SET module=1 WHERE id=2");
		$this->execute("UPDATE card_type SET name='Manual' ,max_day_validity=NULL ,card_icon_type=NULL WHERE id=3");
		$this->execute("UPDATE card_type SET name='Contractor' ,max_day_validity=NULL , card_icon_type=NULL WHERE id=4");
		$this->execute("UPDATE card_type SET name='Same Day' ,max_day_validity=NULL , card_icon_type=NULL , module=2 WHERE id=5");
		$this->execute("UPDATE card_type SET name='24 Hour' ,max_day_validity=NULL , card_icon_type=NULL WHERE id=6");
		$this->execute("UPDATE card_type SET name='Extended' ,max_day_validity=NULL , card_icon_type=NULL WHERE id=7");
		$this->execute("UPDATE card_type SET name='Multi Day' , max_day_validity=NULL ,card_icon_type=NULL WHERE id=8");
		$this->execute("UPDATE card_type SET name='Manual' , max_day_validity=NULL ,card_icon_type=NULL WHERE id=9");
		$this->execute("Delete from card_type WHERE id=10");
	}

	public function down()
	{
		/*echo "m150505_054444_update_card_type does not support migration down.\n";
		return false;*/
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