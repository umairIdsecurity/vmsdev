<?php

/**
 * Created by PhpStorm.
 * User: gistewart
 * Date: 29/11/2015
 * Time: 8:39 AM
 */
class VmsDatabaseCommand extends CConsoleCommand
{
    public function actionClearAllVisitors()
    {
        $this->runQueries(['clear_all_visits_and_visitors.sql']);
    }

    public function actionRebuild()
    {
        $dbName = $this->getDBName();

        $dropAndRecreate = null;

        if(Yii::app()->db->driverName == "mysql"){

            $dropAndRecreate = "DROP DATABASE IF EXISTS `$dbName`;
                           CREATE DATABASE IF NOT EXISTS `$dbName` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
                           USE `$dbName`";

        } elseif(Yii::app()->db->driverName == "mssql" || Yii::app()->db->driverName == "sqlsrv"){
            $dropAndRecreate = "DECLARE @Sql NVARCHAR(500) DECLARE @Cursor CURSOR

                            SET @Cursor = CURSOR FAST_FORWARD FOR
                            SELECT DISTINCT sql = 'ALTER TABLE [' + tc2.TABLE_NAME + '] DROP [' + rc1.CONSTRAINT_NAME + ']'
                            FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS rc1
                              LEFT JOIN INFORMATION_SCHEMA.TABLE_CONSTRAINTS tc2 ON tc2.CONSTRAINT_NAME =rc1.CONSTRAINT_NAME

                            OPEN @Cursor FETCH NEXT FROM @Cursor INTO @Sql

                            WHILE (@@FETCH_STATUS = 0)
                              BEGIN
                                Exec SP_EXECUTESQL @Sql
                                FETCH NEXT FROM @Cursor INTO @Sql
                              END

                            CLOSE @Cursor DEALLOCATE @Cursor
                            GO

                            EXEC sp_MSForEachTable 'DROP TABLE ?'
                            GO";
        }


        $this->runSQL($dropAndRecreate);

        $this->runQueries([
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

    public function actionResetDatabaseAndCreateTestTenant(){
        $this->actionRebuild();
        $this->actionCreateTestTenant();
    }
    public function actionCreateTestTenant(){
        $manager = new TenantManager();
        $manager->createTestTenantFromJsonFile("behat/data/Test Tenant.tenant");
    }

    public function actionDeleteTestTenants(){

        $manager = new TenantManager();
        $manager->deleteAllTest();
    }

    public function actionImportTenant($fileName,$overrideName=null,$overrideCode=null){
        $manager = new TenantManager();
        $manager->importTenantFromJsonFile($fileName,$overrideName,$overrideCode);
    }

    public function actionReloadTenant($fileName,$overrideName=null,$overrideCode=null){
        $manager = new TenantManager();
        $manager->reloadTenantFromFile($fileName,$overrideName,$overrideCode);
    }

    public function clearVisitors($tenantCode){

    }

    private function runSQL($sql){
            echo "\r\n".$sql;
            $cmd = Yii::app()->db->createCommand($sql);
            $cmd->execute();
    }
    private function runQueries($queries){

        echo "running queries against ".Yii::app()->db->connectionString;

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

    private function getDBName(){
        if(Yii::app()->db->driverName == "mysql"){
            return $this->getValue("SELECT DATABASE()");
        } elseif(Yii::app()->db->driverName == "mssql" || Yii::app()->db->driverName == "sqlsrv"){
            return $this->getValue("SELECT DB_NAME()");
        }
        throw new Exception("Database driver ". Yii::app()->db->driverName . " not supported");
    }

    private function getValue($sql){

        $command = Yii::app()->db->createCommand($sql);
        $command->execute();
        $reader = $command->query();
        foreach($reader as $row){
            return array_values($row)[0];
        }
        return null;
    }


}