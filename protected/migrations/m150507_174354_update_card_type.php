<?php

class m150507_174354_update_card_type extends CDbMigration
{
	public function safeUp()
	{
		$this->execute("UPDATE card_type SET card_background_image_path='images/corporate/same-day.png' WHERE id=1");
		$this->execute("UPDATE card_type SET card_background_image_path='images/corporate/multi-day.png' WHERE id=2");
		$this->execute("UPDATE card_type SET card_background_image_path='images/corporate/manual.png' WHERE id=3");
		$this->execute("UPDATE card_type SET card_background_image_path='images/corporate/contractor.png' WHERE id=4");
		$this->execute("UPDATE card_type SET card_background_image_path='images/vic/same_day.png' WHERE id=5");
		$this->execute("UPDATE card_type SET card_background_image_path='images/vic/24_hour.png' WHERE id=6");
		$this->execute("UPDATE card_type SET card_background_image_path='images/vic/extended.png' WHERE id=7");
		$this->execute("UPDATE card_type SET card_background_image_path='images/vic/multi_day.png' WHERE id=8");
		$this->execute("UPDATE card_type SET card_background_image_path='images/vic/manual.png' WHERE id=9");
	}

	public function safeDown()
	{

	}

}