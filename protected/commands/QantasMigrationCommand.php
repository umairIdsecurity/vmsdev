<?php
/**
 * Created by PhpStorm.
 * User: geoffstewart
 * Date: 21/11/2015
 * Time: 10:28 AM
 */
class QantasMigrationCommand extends CConsoleCommand
{


    public function actionImportFile($fileName,$ibCode)
    {
        $helper = new QantasDataHelper();
        $helper->importFile($ibCode);

    }

}