<?php

/**
 * Support Lists
 * Help list uploaded
 * by Dat Nguyen.
 * * */
class SupportController extends Controller
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
     * Lists all models.
     */
    public function actionIndex()
    {
        $folderName = Yii::app()->request->getParam('f');

        //Create default folders for user until exist.
        Folder::model()->setDefaultFoldersForUser(Yii::app()->user->id);

        //get All Folders of user
        $menuFolder = Folder::model()->getAllFoldersOfCurrentUser(Yii::app()->user->id);

        $fltemp = null;
        if (isset($folderName)) {
            $fltemp = Folder::model()->findAll("name = '$folderName' and user_id = '" . Yii::app()->user->id . "'");
        } else {
            $fltemp = Folder::model()->findAll("`default` = 1 and user_id = '" . Yii::app()->user->id . "'");
        }
        $folder = $fltemp[0];

        $model = new File();
        $criteria = new CDbCriteria();
        $criteria->compare('id', $model->id, true);
        $criteria->compare('folder_id', $model->folder_id, true);
        $criteria->compare('file', $model->file, true);
        if ($folder->default != 1)
            $criteria->addCondition("folder_id ='" . $folder->id . "'");
        else {
            $criteria->addCondition("folder_id ='" . $folder->id . "'", 'OR');
            $criteria->addCondition("folder_id ='0'", 'OR');
        }

        $dataProvider = new CActiveDataProvider($model, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.uploaded DESC',
                'attributes' => array(
                    'file' => array(
                        'asc' => 't.name',
                        'desc' => 't.name DESC',
                    ),

                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));

        //render view
        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'menuFolder' => $menuFolder,
            'folder' => $folder,
            'allow_create_new_folder' => Folder::model()->getNumberFolders(Yii::app()->user->id) >= 30 ? 0 : 1,
        ));
    }


}