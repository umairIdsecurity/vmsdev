<?php

class m150701_085157_add_column_escort_flag_visitor extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('visitor','escort_flag','boolean NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('visitor', 'escort_flag');
    }
}