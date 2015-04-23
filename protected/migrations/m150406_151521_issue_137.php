<?php

class m150406_151521_issue_137 extends CDbMigration
{
	public function up()
	{
        try {

            $db = Yii::app()->db;
            /* update */
            $checkIfColumnExists = $db->createCommand("SHOW COLUMNS FROM `company` LIKE 'card_number'");
            $result = $checkIfColumnExists->query();

            $checkIfColumnExists2 = $db->createCommand("SHOW COLUMNS FROM `card_generated` LIKE 'card_count'");
            $result2 = $checkIfColumnExists2->query();


            if ($result->rowCount == 0 && $result2->rowCount != 0) {
                $sql = 'ALTER TABLE `card_generated` ADD COLUMN `card_number` VARCHAR(10) NULL AFTER `id`;
                    ALTER TABLE `company` ADD COLUMN `card_count` BIGINT NULL AFTER `is_deleted`;
                    ';
                $db->createCommand($sql)->execute();

                $command = $db->createCommand("select * from card_generated");
                $result = $command->queryAll();

                foreach ($result as $row) {
                    $sql = 'update card_generated set '
                        . 'card_number="' . IssuePatch::generateCardNumber($row['tenant'], $row['card_count']) . '" where'
                        . ' id = "' . $row['id'] . '"';
                    $db->createCommand($sql)->execute();

                    $command = $db->createCommand('select MAX(card_count) as max from card_generated where tenant="' . $row['tenant'] . '"');
                    $max = $command->query();

                    foreach ($max as $maxRow) {
                        $sql = 'update company set card_count="' . $maxRow['max'] . '" where id=(select company from `user`'
                            . 'where id="' . $row['tenant'] . '")';
                        $db->createCommand($sql)->execute();
                    }
                }
                $sql = 'ALTER TABLE `card_generated` DROP COLUMN `company_code`, DROP COLUMN `card_count`; ';
                $db->createCommand($sql)->execute();
                echo "<br>Done patch for issue137";
            } else {
                echo "<br>Issue 137 Already patched.";
            }

            return true;
        } catch (Exception $ex) {
            echo ' ERROR IN PATCH 137 PATCHER';
            return false;
        }
	}

    public static function generateCardNumber($tenant, $card_count) {
        $inc = 6 - (strlen(($card_count)));
        $int_code = '';
        for ($x = 1; $x <= $inc; $x++) {

            $int_code .= "0";
        }
        $tenant = User::model()->findByPk($tenant);
        return Company::model()->findByPk($tenant->company)->code . $int_code . ($card_count);
    }

	public function down()
	{

	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}