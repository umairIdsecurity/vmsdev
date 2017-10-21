<?php

class m150626_060107_change_columns_to_date_and_time extends CDbMigration
{
    public function safeUp()
    {
        /*
         user
            asic_expiry
         */
        $this->execute("UPDATE user set asic_expiry = NULL WHERE TRIM(asic_expiry) = ''");
        
        $this->execute("UPDATE user SET asic_expiry = CONCAT(SUBSTR(asic_expiry,7), '-' ,SUBSTR(asic_expiry,4,2), '-' ,SUBSTR(asic_expiry,1,2)) WHERE asic_expiry IS NOT NULL");
        
        $this->alterColumn("user", "asic_expiry", "DATE NULL");
        
        /*
          import_visitor
            check_in_time
            check_out_time
         */
        $this->execute("UPDATE import_visitor set check_in_time = NULL WHERE TRIM(check_in_time) = ''");
        $this->execute("UPDATE import_visitor set check_out_time = NULL WHERE TRIM(check_out_time) = ''");
        
        $this->execute("UPDATE import_visitor SET check_in_time = CONCAT(SUBSTR(check_in_time,1,2), ':' ,SUBSTR(check_in_time,4,2), ':' ,SUBSTR(check_in_time,7,2)) WHERE check_in_time IS NOT NULL");
        $this->execute("UPDATE import_visitor SET check_out_time = CONCAT(SUBSTR(check_out_time,1,2), ':' ,SUBSTR(check_out_time,4,2), ':' ,SUBSTR(check_out_time,7,2)) WHERE check_out_time  IS NOT NULL");
        
        $this->alterColumn("import_visitor", "check_in_time", "TIME NULL");
        $this->alterColumn("import_visitor", "check_out_time", "TIME NULL");
        
        
        

    }

    public function safeDown()
    {
        //asic_expiry was int(11)
        $this->alterColumn("user","asic_expiry","INT(11)");

        $this->alterColumn("import_visitor","check_in_time","VARCHAR(20)");
        $this->alterColumn("import_visitor","check_out_time","VARCHAR(20)");

        $this->execute("UPDATE user SET asic_expiry = CONCAT(SUBSTR(asic_expiry,9), '-' ,SUBSTR(asic_expiry,6,2), '-' ,SUBSTR(asic_expiry,1,4)) WHERE asic_expiry IS NOT NULL");
        

    }
}