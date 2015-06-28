<?php
require_once(Yii::app()->basePath . '/data/HelpDeskContents.php');

/**
 * Created by PhpStorm.
 * User: geoffstewart
 * Date: 24/06/15
 * Time: 6:52 PM
 */

class tenantDataCheckCommand extends CConsoleCommand {

    public function actionIndex()
    {

    }

    public function actionCleanStandalone()
    {

        $db = Yii::app()->db;

        $db->createCommand("update company set tenant = 1, tanent_agent = NULL where tenant != 1");
        $db->query();

        $db->createCommand("update user set tenant = 1, tenant_agent = null where tenant != 1");
        $db->query();



    }

}