<?php

class m150604_033456_add_police_report_number_column extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('visit', 'card_lost_declaration_file', "text DEFAULT NULL");
        $this->addColumn('visit', 'police_report_number', "varchar(50) DEFAULT ''");
    }

    public function safeDown()
    {
        $this->dropColumn('visit', 'card_lost_declaration_file');
        $this->dropColumn('visit', 'police_report_number');
    }

}