<?php

class m150501_222214_update_card_type extends CDbMigration
{
	public function up()
	{
		$this->execute("UPDATE card_type SET card_icon_type='images/corporate/visitor.png' WHERE id=3");
		$this->execute("UPDATE card_type SET card_icon_type='images/corporate/contractor.png' WHERE id=4");
		$this->execute("UPDATE card_type SET card_icon_type='images/corporate/manual.png' WHERE id=5");
		$this->execute("UPDATE card_type SET card_icon_type='images/vic/extended.png' WHERE id=6");
		$this->execute("UPDATE card_type SET card_icon_type='images/vic/24_hour.png' WHERE id=7");
		$this->execute("UPDATE card_type SET card_icon_type='images/vic/manual.png' WHERE id=8");
		$this->execute("UPDATE card_type SET card_icon_type='images/vic/same_day.png' WHERE id=9");
		$this->execute("UPDATE card_type SET card_icon_type='images/vic/multi_day.png' WHERE id=10");
	}

	public function down()
	{

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