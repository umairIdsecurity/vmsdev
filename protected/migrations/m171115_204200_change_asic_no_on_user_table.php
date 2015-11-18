<?php

class m171115_204200_change_asic_no_on_user_table extends CDbMigration
{
	public function safeUp()
	{
		$this->alterColumn('user', 'asic_no', 'VARCHAR(20)');
	}

	public function safeDown()
	{

	}

}