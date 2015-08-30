<?php

/**
 * Created by PhpStorm.
 * User: gistewart
 * Date: 30/08/15
 * Time: 7:39 AM
 */
class ResetDatabaseCommand extends CConsoleCommand
{
    public function actionIndex()
    {

        echo ForeignKeyHelper::getForeignKeyName('user','tenant_agent','user','id');

    }
}