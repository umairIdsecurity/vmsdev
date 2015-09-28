<?php

/**
 * Created by PhpStorm.
 * User: gistewart
 * Date: 30/08/15
 * Time: 7:39 AM
 */
class DatabaseCommand extends CConsoleCommand
{
    public function actionIndex()
    {
        $connection = new CDbConnection("mysql:host=localhost;dbname=avms7",'root','root');
        $connection->active = true;
        $transformer = new Avms7DataTransformer($connection);
        $transformer->exportTenant("BKQ");
    }

}