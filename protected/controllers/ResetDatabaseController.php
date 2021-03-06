<?php

class ResetDatabaseController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/noheaderLayout';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        $session = new CHttpSession;
        return array(
            array('allow', // allow superadmin user to perform 'admin' and 'delete' actions
                'actions' => array('resetAsEmpty', 'resetWithTestData'),
                'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_SUPERADMIN)',
            ),
            array('allow', // allow superadmin user to perform 'admin' and 'delete' actions
                'actions' => array('updateSuperAdminPassword'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionResetAsEmpty()
    {
        runSqlFile("database/schema.sql");
        runSqlFile("database/installData.sql");
        actionDbPatch();

    }
    public function actionResetWithTestData()
    {
        runSqlFile("database/schema.sql");
        runSqlFile("database/testData.sql");
        actionDbPatch();

    }

    public function runSqlFile($filename) {
        $db = Yii::app()->db;

        $filename = Yii::getPathOfAlias('webroot') . '/' . $filename . '.sql';
        $templine = '';
        $lines = file($filename);

        foreach ($lines as $line) {
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;

            $templine .= $line;
            if (substr(trim($line), -1, 1) == ';') {
                $db->createCommand($templine)->execute();
                //     mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
                $templine = '';
            }
        }
        echo $filename . "executed successfully";
    }

    public function actionDbPatch() {
        GeneralPatcher::startPatcher();
    }
    

}
