<?php

class m150617_022554_add_column_lodgement_date_to_reset_history extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('reset_history', 'lodgement_date', 'DATE');
    }

    public function safeDown()
    {
        $this->dropColumn('reset_history', 'lodgement_date');
    }
}