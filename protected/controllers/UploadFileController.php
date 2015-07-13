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
    public $layout = '//layouts/uploadfile';

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
     * Lists all models.
     */
    public function actionIndex()
    {
        $menuFolder  = Folder::model()->getAllFoldersOfCurrentUser(Yii::app()->user->id);
        $dataProvider = new CActiveDataProvider('Folder');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }
}