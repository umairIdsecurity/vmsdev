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
        //Create default folders for user until exist.
        Folder::model()->setDefaultFoldersForUser(Yii::app()->user->id);

        //get All Folders of user
        $menuFolder  = Folder::model()->getAllFoldersOfCurrentUser(Yii::app()->user->id);

        //render view
        $this->render('index', array(
            'menuFolder' => $menuFolder,
            'folder' => Yii::app()->request->getParam('f')
        ));
    }

    public function actionCreate(){
        if ($_POST['Folder']) {
            //Check Folder has exist
            if(!Folder::model()->checkNameExist($_POST['Folder']['user_id'])){
                $folder = new Folder();
                $folder->name = $_POST['Folder']['name'];
                $folder->user_id = $_POST['Folder']['user_id'];
                if($folder->validate())
                    if($folder->save()) CJSON::encode(array('success'=>1));
            }
        }
        CJSON::encode(array('success'=>0));
    }
}