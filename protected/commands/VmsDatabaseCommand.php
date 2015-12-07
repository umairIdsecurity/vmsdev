<?php

/**
 * Created by PhpStorm.
 * User: gistewart
 * Date: 29/11/2015
 * Time: 8:39 AM
 */
class VmsDatabaseCommand extends CConsoleCommand
{
    public function actionVisitorsAndVisits()
    {
        $this->runQueries(['clear_all_visits_and_visitors.sql']);
    }

    public function actionRebuild()
    {
        $this->runQueries([
            'drop_and_create_database.sql',
            'schema.sql',
            'startup-data.sql'
        ]);

        $this->runMigrationTool();

    }

    public function actionExportTenant($code,$fileName)
    {
        $manager = new TenantManager();
        $json = $manager->exportWithCodeToJson($code);
        file_put_contents($fileName,$json);
    }

    public function actionDeleteTenant($code)
    {
        $manager = new TenantManager();
        $manager->deleteWithCode($code);
    }

    public function actionImportTenant($fileName){
        $manager = new TenantManager();
        $manager->importFromJsonFile($fileName);
    }

    public function actionReloadTenant($fileName){
        $manager = new TenantManager();
        $manager->reloadTenantFromFile($fileName);
    }


    private function runQueries($queries){

        foreach($queries as $query){
            $scriptPath = dirname(Yii::app()->basePath)."/database/".Yii::app()->db->driverName."/".$query;
            $sql = file_get_contents($scriptPath);
            echo "\r\n".$sql;
            $cmd = Yii::app()->db->createCommand($sql);
            $cmd->execute();
        }

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