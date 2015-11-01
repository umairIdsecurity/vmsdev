<?php

/**
 * Created by PhpStorm.
 * User: gistewart
 * Date: 31/10/2015
 * Time: 5:46 PM
 */
class DatabaseResetCommand extends CConsoleCommand
{

    public function actionIndex()
    {
        

        $driverName = Yii::app()->db->driverName;

        $sql = get_file_contents(Yii::app()->getBasePath().DIRECTORY_SEPARATOR ."database".DIRECTORY_SEPARATOR.$driverName.DIRECTORY_SEPARATOR."schema.sql");
        Yii::app()->db->createCommand($sql)->execute();

        $sql = get_file_contents(Yii::app()->getBasePath().DIRECTORY_SEPARATOR ."database".DIRECTORY_SEPARATOR.$driverName.DIRECTORY_SEPARATOR."statup-data.sql");
        Yii::app()->db->createCommand($sql)->execute();

    }



    private function runMigrationTool() {
        $commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
        $runner = new CConsoleCommandRunner();
        $runner->addCommands($commandPath);
        $commandPath = Yii::getFrameworkPath() . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . 'commands';
        $runner->addCommands($commandPath);
        $args = array('yiic', 'migrate', '--interactive=0');
        ob_start();
        $runner->run($args);
        echo htmlentities(ob_get_clean(), null, Yii::app()->charset);
    }

}