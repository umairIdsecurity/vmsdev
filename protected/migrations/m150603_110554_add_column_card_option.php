<?php

class m150603_110554_add_column_card_option extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('visit', 'card_option', "varchar(25) DEFAULT 'Returned'");
    }

    public function safeDown()
    {
        $this->dropColumn('visit', 'card_option');
    }
}