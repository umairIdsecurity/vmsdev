<?php

class m150621_111500_change_date_columns_to_date_data_type extends CDbMigration
{
    public function safeUp()
    {
        /*
         visit
            date_in
            date_out
            date_check_in
            date_check_out
            finish_date
            card_returned_date

         */
        $this->execute("UPDATE visit set date_in = NULL WHERE TRIM(date_in) = ''");
        $this->execute("UPDATE visit set date_out = NULL WHERE TRIM(date_out) = ''");
        $this->execute("UPDATE visit set date_check_in = NULL WHERE TRIM(date_check_in) = ''");
        $this->execute("UPDATE visit set date_check_out = NULL WHERE TRIM(date_check_out) = ''");
        $this->execute("UPDATE visit set finish_date = NULL WHERE TRIM(finish_date) = ''");
        $this->execute("UPDATE visit set card_returned_date = NULL WHERE TRIM(card_returned_date) = ''");

        $this->execute("UPDATE visit SET date_in = CONCAT(SUBSTR(date_in,7), '-' ,SUBSTR(date_in,4,2), '-' ,SUBSTR(date_in,1,2)) WHERE date_in IS NOT NULL");
        $this->execute("UPDATE visit SET date_out = CONCAT(SUBSTR(date_out,7), '-' ,SUBSTR(date_out,4,2), '-' ,SUBSTR(date_out,1,2)) WHERE date_out  IS NOT NULL");
        $this->execute("UPDATE visit SET date_check_in = CONCAT(SUBSTR(date_check_in,7), '-' ,SUBSTR(date_check_in,4,2), '-' ,SUBSTR(date_check_in,1,2)) WHERE date_check_in IS NOT NULL");
        $this->execute("UPDATE visit SET date_check_out = CONCAT(SUBSTR(date_check_out,7), '-' ,SUBSTR(date_check_out,4,2), '-' ,SUBSTR(date_check_out,1,2)) WHERE date_check_out IS NOT NULL");
        $this->execute("UPDATE visit SET finish_date = CONCAT(SUBSTR(finish_date,7), '-' ,SUBSTR(finish_date,4,2), '-' ,SUBSTR(finish_date,1,2)) WHERE finish_date  IS NOT NULL");
        $this->execute("UPDATE visit SET card_returned_date = CONCAT(SUBSTR(card_returned_date,7), '-' ,SUBSTR(card_returned_date,4,2), '-' ,SUBSTR(card_returned_date,1,2)) WHERE date_in  IS NOT NULL");

        $this->alterColumn("visit", "date_in", "DATE NULL");
        $this->alterColumn("visit", "date_out", "DATE NULL");
        $this->alterColumn("visit", "date_check_in", "DATE NULL");
        $this->alterColumn("visit", "date_check_out", "DATE NULL");
        $this->alterColumn("visit", "finish_date", "DATE NULL");
        $this->alterColumn("visit", "card_returned_date", "DATE NULL");

        /*
          card_generated
            date_printed
            date_expiration
            date_cancelled
            date_returned
         */
        $this->execute("UPDATE card_generated set date_printed = NULL WHERE TRIM(date_printed) = ''");
        $this->execute("UPDATE card_generated set date_expiration = NULL WHERE TRIM(date_expiration) = ''");
        $this->execute("UPDATE card_generated set date_cancelled = NULL WHERE TRIM(date_cancelled) = ''");
        $this->execute("UPDATE card_generated set date_returned = NULL WHERE TRIM(date_returned) = ''");

        $this->execute("UPDATE card_generated SET date_printed = CONCAT(SUBSTR(date_printed,7), '-' ,SUBSTR(date_printed,4,2), '-' ,SUBSTR(date_printed,1,2)) WHERE date_printed IS NOT NULL");
        $this->execute("UPDATE card_generated SET date_expiration = CONCAT(SUBSTR(date_expiration,7), '-' ,SUBSTR(date_expiration,4,2), '-' ,SUBSTR(date_expiration,1,2)) WHERE date_expiration  IS NOT NULL");
        $this->execute("UPDATE card_generated SET date_cancelled = CONCAT(SUBSTR(date_cancelled,7), '-' ,SUBSTR(date_cancelled,4,2), '-' ,SUBSTR(date_cancelled,1,2)) WHERE date_cancelled IS NOT NULL");
        $this->execute("UPDATE card_generated SET date_returned = CONCAT(SUBSTR(date_returned,7), '-' ,SUBSTR(date_returned,4,2), '-' ,SUBSTR(date_returned,1,2)) WHERE date_returned IS NOT NULL");

        $this->alterColumn("card_generated", "date_printed", "DATE NULL");
        $this->alterColumn("card_generated", "date_expiration", "DATE NULL");
        $this->alterColumn("card_generated", "date_cancelled", "DATE NULL");
        $this->alterColumn("card_generated", "date_returned", "DATE NULL");

    }

    public function safeDown()
    {
        $this->alterColumn("visit","date_in","VARCHAR(10)");
        $this->alterColumn("visit","date_out","VARCHAR(10)");
        $this->alterColumn("visit","date_check_in","VARCHAR(10)");
        $this->alterColumn("visit","date_check_out","VARCHAR(10)");
        $this->alterColumn("visit","finish_date","VARCHAR(10)");
        $this->alterColumn("visit","card_returned_date","VARCHAR(10)");

        $this->alterColumn("card_generated","date_printed","VARCHAR(10)");
        $this->alterColumn("card_generated","date_expiration","VARCHAR(10)");
        $this->alterColumn("card_generated","date_cancelled","VARCHAR(10)");
        $this->alterColumn("card_generated","date_returned","VARCHAR(10)");

        $this->execute("UPDATE card_generated SET date_printed = CONCAT(SUBSTR(date_printed,9), '-' ,SUBSTR(date_printed,6,2), '-' ,SUBSTR(date_printed,1,4)) WHERE date_printed IS NOT NULL");
        $this->execute("UPDATE card_generated SET date_expiration = CONCAT(SUBSTR(date_expiration,9), '-' ,SUBSTR(date_expiration,6,2), '-' ,SUBSTR(date_expiration,1,4)) WHERE date_expiration  IS NOT NULL");
        $this->execute("UPDATE card_generated SET date_cancelled = CONCAT(SUBSTR(date_cancelled,9), '-' ,SUBSTR(date_cancelled,6,2), '-' ,SUBSTR(date_cancelled,1,4)) WHERE date_cancelled IS NOT NULL");
        $this->execute("UPDATE card_generated SET date_returned = CONCAT(SUBSTR(date_returned,9), '-' ,SUBSTR(date_returned,6,2), '-' ,SUBSTR(date_returned,1,4)) WHERE date_returned IS NOT NULL");

        $this->execute("UPDATE visit SET date_in = CONCAT(SUBSTR(date_in,9), '-' ,SUBSTR(date_in,6,2), '-' ,SUBSTR(date_in,1,4)) WHERE date_in IS NOT NULL");
        $this->execute("UPDATE visit SET date_out = CONCAT(SUBSTR(date_out,9), '-' ,SUBSTR(v,6,2), '-' ,SUBSTR(date_out,1,4)) WHERE date_out  IS NOT NULL");
        $this->execute("UPDATE visit SET date_check_in = CONCAT(SUBSTR(date_check_in,9), '-' ,SUBSTR(date_check_in,6,2), '-' ,SUBSTR(date_check_in,1,4)) WHERE date_check_in IS NOT NULL");
        $this->execute("UPDATE visit SET date_check_out = CONCAT(SUBSTR(date_check_out,9), '-' ,SUBSTR(date_check_out,6,2), '-' ,SUBSTR(date_check_out,1,4)) WHERE date_check_out IS NOT NULL");
        $this->execute("UPDATE visit SET finish_date = CONCAT(SUBSTR(finish_date,9), '-' ,SUBSTR(finish_date,6,2), '-' ,SUBSTR(finish_date,1,4)) WHERE finish_date  IS NOT NULL");
        $this->execute("UPDATE visit SET card_returned_date = CONCAT(SUBSTR(card_returned_date,9), '-' ,SUBSTR(card_returned_date,6,2), '-' ,SUBSTR(card_returned_date,1,4)) WHERE date_in  IS NOT NULL");



    }
}