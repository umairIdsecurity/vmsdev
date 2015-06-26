<?php

class m150624_083025_create_table_log_convert_visitor_card_type extends CDbMigration
{

    public function safeUp()
    {
        $this->createTable("cardstatus_convert", array(
            'id'         =>'pk',
            'visitor_id' =>'BIGINT(20) NOT NULL',
            'convert_time' =>'DATE  NOT NULL',
        ));
    }

    public function safeDown()
    {
        $this->dropTable('cardstatus_convert');
    }
}