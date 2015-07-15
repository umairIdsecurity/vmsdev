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
        $folderName = Yii::app()->request->getParam('f');

        //Create default folders for user until exist.
        Folder::model()->setDefaultFoldersForUser(Yii::app()->user->id);

        //get All Folders of user
        $menuFolder  = Folder::model()->getAllFoldersOfCurrentUser(Yii::app()->user->id);

        $folder = null;
        if(isset($folderName)){
            $fltemp = Folder::model()->findAll("name = '$folderName' and user_id = '".Yii::app()->user->id."'");
            if($fltemp) $folder = $fltemp[0];
        }else{
            $fltemp = Folder::model()->findAll("`default` = 1 and user_id = '".Yii::app()->user->id."'");
            if($fltemp) $folder = $fltemp[0];
            $folderName = $folder->name;
        }

        $model = new File();
        $criteria = new CDbCriteria();
        $criteria->compare('id', $model->id, true);
        $criteria->compare('folder_id', $model->folder_id, true);
        $criteria->compare('file', $model->file, true);
        if ($folder->name != 'Help Documents')
            $criteria->addCondition("folder_id ='" . $folder->id . "'");
        else {
            $criteria->addCondition("folder_id ='" . $folder->id . "'", 'OR');
            $criteria->addCondition("folder_id ='0'",'OR');
        }

        $dataProvider = new CActiveDataProvider($model, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.uploaded DESC',
                'attributes' => array(
                    'file' => array(
                        'asc' => 't.file',
                        'desc' => 't.file DESC',
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
            'allow_create_new_folder' => Folder::model()->getNumberFolders(Yii::app()->user->id)>=30?0:1,
        ));
    }

    /**
     * Create new folder
     */
    public function actionCreate(){
        if (isset($_POST['Folder'])) {
            //Check Folder has exist
            if(!Folder::model()->checkNameExist($_POST['Folder']['user_id'],$_POST['Folder']['name']) && Folder::model()->getNumberFolders($_POST['Folder']['user_id']) <= 30){
                $folder = new Folder();
                $folder->name = $_POST['Folder']['name'];
                $folder->user_id = $_POST['Folder']['user_id'];
                if($folder->validate())
                    if ($folder->save()) {
                        echo CJSON::encode(array('success' => 1));
                        exit();
                    }
            }else{
                echo CJSON::encode(array('success'=>2,'error'=>'Name folder has exist or number folders larger than 30.'));
                exit();
            }
        }
        echo CJSON::encode(array('success'=>2,'error'=>'Invalid request'));
    }

    /**
     * Update name File
     */
    public function actionUpdateFile(){
        if(isset($_POST)){
            $id = $_POST['id'];
            $name = $_POST['file'];
            if(!File::model()->checkFileExist($id,$name)){
                $file = File::model()->findByPk($id);
                if($file){
                    $file->file = $name;
                    $file->save();
                    echo CJSON::encode(array('success'=>1));
                    exit();
                }
            }else {
                echo CJSON::encode(array('success' => 2,'error'=>'Name file has exist'));
                exit();
            }
            echo CJSON::encode(array('success' => 2,'error'=>'Request invalid.'));
        }
    }

    /**
     * Upload File On server
     */
    public function actionUploadedFile(){
       if(isset($_POST['File']) && isset($_FILES)){
           $folder_id = $_POST['File']['folder_id'];
           $user_id = $_POST['File']['user_id'];
           if(isset($_FILES)){
               $root=Yii::app()->basePath.'/uploads/files';
               $root = str_replace('/protected','',$root);
               $folderUser = $root.'/'.$user_id;
               $folderFile = $folderUser.'/'.$folder_id;
               if(!is_dir($root)){
                   mkdir($root,0777,true);
                   if(!is_dir($folderUser)){
                       mkdir($folderUser,0777,true);
                       if(!is_dir($folderFile)){
                           mkdir($folderFile,0777,true);
                       }
                   }
               }
               $files = $_FILES['file'];
               $listError=array();
               for($i = 0; $i < count($files['name']);$i++){
                   if($files['size'][$i] <= 10485760){
                       if ($files['error'][$i] == UPLOAD_ERR_OK) {
                           $tmp_name = $files['tmp_name'][$i];
                           $name = $files['name'][$i];
                               if (move_uploaded_file($tmp_name, "$folderFile/$name")) {
                                   $objectFile = new File();
                                   $objectFile->folder_id = $folder_id;
                                   $objectFile->user_id = $user_id;
                                   $objectFile->file = $name;
                                   $objectFile->uploader = $user_id;
                                   $objectFile->size = $files['size'][$i];
                                   $objectFile->ext = pathinfo($name, PATHINFO_EXTENSION);
                                   $objectFile->save();
                               } else {
                                   $listError[] = $files['name'][$i];
                               }
                       }else{
                           $listError[] = $files['name'][$i];
                       }
                   }else{
                       $listError[] = $files['name'][$i];
                   }
               }
               if($listError){
                   echo CJSON::encode(array('success'=>2,'error'=>$listError));
                   exit();
               }else{
                   echo CJSON::encode(array('success'=>1));
                   exit();
               }
           }
        }
    }

    /**
     * delete File
     */
    public function actionDelete(){
        if (isset($_POST['File'])) {
            if(is_array($_POST['File']['id'])){
                foreach($_POST['File']['id'] as $fi){
                    $file = File::model()->findByPk($fi);
                    if($file) $file->delete();
                }
                echo CJSON::encode(array('success'=>1));
                exit();
            }
            echo CJSON::encode(array('success'=>2,'error'=>'Invalid Request.'));
        }

    }

}