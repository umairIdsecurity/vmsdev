<?php

/**
 * Created by PhpStorm.
 * User: dai
 * Date: 7/13/2015
 * Time: 11:56 AM
 */
class UploadFileController extends Controller
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
    public function accessRules()
    {
        /*$session = new CHttpSession;
        return array(
            array(
                'allow',
                'actions' => array(
                    'create',
                    'GetTenantAgentWithSameTenant',
                    'GetIdOfUser',
                    'CheckEmailIfUnique',
                    'GetTenantAgentAjax',
                    'GetTenantOrTenantAgentCompany',
                    'GetTenantWorkstation',
                    'GetTenantAgentWorkstation',
                    'getCompanyOfTenant'
                ),
                'users' => array('@'),
            ),
            array(
                'allow',
                'actions' => array('update'),
                'expression' => 'Yii::app()->controller->isTenantOfUserViewed(Yii::app()->user)',

            ),
            array(
                'allow',
                'actions' => array('profile'),
                'expression' => '(Yii::app()->user->id == ($_GET[\'id\']))',
            ),
            array(
                'allow',
                'actions' => array('admin', 'adminAjax', 'delete', 'systemaccessrules', 'importHost'),
                'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user, UserGroup::USERGROUP_ADMINISTRATION)',
            ),
            array(
                'deny', // deny all users
                'users' => array('*'),
            ),
        );*/
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Folder');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }
}