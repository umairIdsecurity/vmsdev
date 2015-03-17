<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Issue81Patch extends CComponent {

    public static function Issue81Process() {
        try {
            $db = Yii::app()->db;
            /* update company code */
            $command = $db->createCommand("select id,tenant,company_code,card_count from card_generated");
            $result = $command->queryAll();

            foreach ($result as $row) {
                $sql = 'update card_generated set '
                        . 'company_code=(select `code` from company '
                        . 'where id=(select company from `user` where id="' . $row['tenant'] . '")) where'
                        . ' tenant = "' . $row['tenant'] . '"';
                $db->createCommand($sql)->execute();
                $command = $db->createCommand('select MAX(card_count)+1 as max from card_generated where tenant="' . $row['tenant'] . '"');
                $max = $command->query();
                foreach ($max as $maxRow) {
                    $sql = 'update card_generated set card_count="' . $maxRow['max'] . '" where id="' . $row['id'] . '"';
                    $db->createCommand($sql)->execute();
                }

                $sql = 'update card_generated set card_count="' . $maxRow['max'] . '" where id="' . $row['id'] . '"';
                $db->createCommand($sql)->execute();
            }

            $commandA = $db->createCommand("select id,visit_status,visitor,tenant,tenant_agent from visit where visit_status=1 and (card IS NULL or card ='')");
            $resultA = $commandA->queryAll();
            foreach ($resultA as $key => $value) {
                $commandB = $db->createCommand("select code from company where id=(Select company from user where id='".$value['tenant']."')");
                $resultB = $commandB->queryAll();
                foreach ($resultB as $key => $valueB) {
                    $card_code = $valueB['code'];
                }
                
                $commandC = $db->createCommand("select max(card_count) + 1 as max from card_generated where tenant='".$value['tenant']."'");
                $resultC = $commandC->queryAll();
                foreach ($resultC as $key => $valueC) {
                    $card_count = $valueC['max'];
                }
                $t_agent = ',NULL,';
                if($value['tenant_agent'] != ''){
                    $t_agent = ',"'.$value['tenant_agent'].'",';
                }
                $sqlA = 'INSERT INTO `card_generated` (`date_printed`,`date_expiration`, `date_cancelled`, `date_returned`, 
                        `card_image_generated_filename`, `visitor_id`, `card_status`, 
                        `created_by`, `tenant`, `tenant_agent`, `company_code`, 
                        `card_count`, `print_count`) VALUES (NULL, NULL, 
                        NULL, NULL, NULL, "'.$value['visitor'].'", 
                        NULL, "'.$value['tenant'].'",  "'.$value['tenant'].'"
                        '.$t_agent.' "'.$card_code.'", "'.$card_count.'", "0")';
                $db->createCommand($sqlA)->execute();
                
                $sqlB = 'update visit set card="'.Yii::app()->db->getLastInsertID().'" where id="'.$value['id'].'"';
                $db->createCommand($sqlB)->execute();
            }
            echo "<br>Done patch for issue81";
            return true;
        } catch (Exception $ex) {
            echo 'ERROR IN PATCH 81 PATCHER';
            return false;
        }
    }

}
