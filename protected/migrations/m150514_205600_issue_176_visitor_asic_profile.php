<?php

Yii::import('ext.tools.IdempotentDbOperation');

class m150514_205600_issue_176_visitor_asic_profile extends CDbMigration
{
    public function safeUp()
    {
        $idempotent = new IdempotentDbOperation($this);

        $idempotent->addColumn('visitor', 'asic_no', "varchar(50) DEFAULT NULL");
        $idempotent->addColumn('visitor', 'asic_expiry', "date DEFAULT NULL");
        $idempotent->addColumn('visitor', 'verifiable_signature', "integer DEFAULT 0");
        
        $this->execute("INSERT IGNORE INTO visitor_card_status (id, name, profile_type) VALUES
                (6, 'ASIC Issued', 'ASIC'),
                (7, 'ASIC Applicant', 'ASIC');");

        $this->execute("UPDATE visitor_card_status SET profile_type = 'VIC' WHERE id <= 5;");
    }

    public function safeDown()
    {
        $idempotent = new IdempotentDbOperation($this);

        $idempotent->dropColumn('visitor', 'asic_no');
        $idempotent->dropColumn('visitor', 'asic_expiry');
        $idempotent->dropColumn('visitor', 'verifiable_signature');

        $this->execute("DELETE FROM visitor_card_status WHERE id IN (6, 7);");
    }
}