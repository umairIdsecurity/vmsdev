<?php

/**
 * SystemController
 * Emergency shutdown, and standard number for system
 * Date: 7/20/15
 * Time: 4:25 PM
 * By Dat Nguyen
 */
class SystemController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
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
        return array(
            array('allow', // allow authenticated user to perform 'shutdown' actions
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }


    public function actionShutdown(){

        $shutdown = System::model()->find("key_name = '" . System::$EMERGENCY_SHUTDOWN.":".$_SESSION['tenant'] ."'");
        if (!$shutdown) $shutdown = System::model()->createNewKey(System::$EMERGENCY_SHUTDOWN.":".$_SESSION['tenant'], System::OFF);

        if($_POST){
            $key_name = $_POST['key_name'];
            $key_value = $_POST['key_value'];
            if($key_name && $key_value){
                $model = System::model()->find("key_name ='".$key_name."'");
                if($model){
                    $model->key_value = $key_value;
                    if($model->save())
                    echo CJSON::encode(array('success'=>1));
                    else echo CJSON::encode(array('success'=>2,'error'=>'Cant shutdown system.'));
                    exit();
                }
            }
        }
        $this->render('shutdown',
            array('shutdown' => $shutdown));
    }

}