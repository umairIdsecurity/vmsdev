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
        $transformer = new Avms7DataTransformer();
        $transformer->exportTenant("BKQ");
    }

}