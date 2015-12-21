<?php

/**
 * Created by PhpStorm.
 * User: geoffstewart
 * Date: 17/12/2015
 * Time: 2:47 PM
 */
class DataIntegrityCheckCommand extends CConsoleCommand
{
    public function actionIndex(){

        DataIntegrityHelper::checkDatabase();
        echo "integrity check passed\r\n";
    }
}