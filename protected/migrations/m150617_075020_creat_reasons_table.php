<?php

class m150617_075020_creat_reasons_table extends CDbMigration
{
	public function safeUp()
	{
            $this->createTable("reasons", array(
                'id' =>'pk',
                'reason_name'=>'VARCHAR(50) NOT NULL',
                'date_created' =>'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
            ));
	}

	public function safeDown()
	{
            $this->dropTable("reasons");
	}
}