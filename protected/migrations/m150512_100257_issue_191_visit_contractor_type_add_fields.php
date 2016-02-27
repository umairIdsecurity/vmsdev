<?php

class m150512_100257_issue_191_visit_contractor_type_add_fields extends CDbMigration
{

	public function safeUp()
	{
        $this->addColumn('visit', 'finish_date', "varchar(10) DEFAULT NULL");
        $this->addColumn('visit', 'finish_time', "time DEFAULT NULL");
        $this->addColumn('visit', 'card_returned_date', "varchar(10) DEFAULT NULL");
	}

	public function safeDown()
	{
        $this->dropColumn('visit', 'finish_date');
        $this->dropColumn('visit', 'finish_time');
        $this->dropColumn('visit', 'card_returned_date');
	}
}