<?php

class m150611_114540_visitor_add_date_created_column extends CDbMigration
{
	public function safeUp()
    {
        $this->addColumn('visitor', 'date_created', "timestamp DEFAULT CURRENT_TIMESTAMP");
    }

    public function safeDown()
    {
        $this->dropColumn('visitor', 'date_created');
    }
}

