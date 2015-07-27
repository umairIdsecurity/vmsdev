<?php

/**
 * Upload File
 * Manager File uploaded
 * by Dat Nguyen.
 * * */
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

    /**
     * Create new folder
     */
    public function actionCreate()
    {
        if (isset($_POST['Folder'])) {
            //Check Folder has exist
            if (!Folder::model()->checkNameExist($_POST['Folder']['user_id'], $_POST['Folder']['name']) && Folder::model()->getNumberFolders($_POST['Folder']['user_id']) <= 30) {
                $folder = new Folder();
                $folder->name = $_POST['Folder']['name'];
                $folder->user_id = $_POST['Folder']['user_id'];
                $folder->date_created = date('Y-m-d H:i:s');
                if ($folder->validate())
                    if ($folder->save()) {
                        echo CJSON::encode(array('success' => 1));
                        exit();
                    }
            } else {
                echo CJSON::encode(array('success' => 2, 'error' => 'Name folder has exist or number folders larger than 30.'));
                exit();
            }
        }
        echo CJSON::encode(array('success' => 2, 'error' => 'Invalid request'));
    }

    /**
     * Update name File
     */
    public function actionUpdateFile()
    {
        if (isset($_POST)) {
            $id = $_POST['id'];
            $name = $_POST['file'];
            if (!File::model()->checkFileExist($id, $name)) {
                $file = File::model()->findByPk($id);
                if ($file) {
                    $file->name = trim($name);
                    if ($file->save()) {
                        echo CJSON::encode(array('success' => 1));
                        exit();
                    }
                }
            } else {
                echo CJSON::encode(array('success' => 2, 'error' => 'Name file has exist'));
                exit();
            }
            echo CJSON::encode(array('success' => 2, 'error' => 'Request invalid.'));
        }
    }

    /**
     * Upload File On server
     */
    public function actionUploadedFile()
    {
        if (isset($_POST['File']) && isset($_FILES)) {
            $folder_id = $_POST['File']['folder_id'];
            $user_id = $_POST['File']['user_id'];
            if (isset($_FILES)) {
                $root = dirname(Yii::app()->request->scriptFile) .'/uploads/files';
                $folderUser = $root . '/' . $user_id;
                $folderFile = $folderUser . '/' . $folder_id;
                if (!is_dir($root)) {
                    mkdir($root, 0777, true);

                }
                if (!is_dir($folderUser)) {
                    mkdir($folderUser, 0777, true);

                }
                if (!is_dir($folderFile)) {
                    mkdir($folderFile, 0777, true);
                }
                $files = $_FILES['file'];
                $listError = array();
                for ($i = 0; $i < count($files['name']); $i++) {
                    $ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
                    if ($files['size'][$i] <= 10485760 && in_array($ext, File::$EXT_ALLOWED)) {
                        if ($files['error'][$i] == UPLOAD_ERR_OK) {
                            $tmp_name = $files['tmp_name'][$i];
                            $name = $files['name'][$i];
                            $name_file = strtotime(date('Y-m-d H:i:s')).rand(0,100).'-'.$name;
                            if (move_uploaded_file($tmp_name, "$folderFile/$name_file")) {
                                $objectFile = new File();
                                $objectFile->folder_id = $folder_id;
                                $objectFile->user_id = $user_id;
                                $objectFile->file = $name_file;
                                $objectFile->name = $name;
                                $objectFile->uploaded = date('Y-m-d H:i:s');
                                $objectFile->uploader = $user_id;
                                $objectFile->size = $files['size'][$i];
                                $objectFile->ext = $ext;
                                $objectFile->save();
                            } else {
                                $listError[] = $files['name'][$i];
                            }
                        } else {
                            $listError[] = $files['name'][$i];
                        }
                    } else {
                        $listError[] = $files['name'][$i];
                    }
                }
                if ($listError) {
                    echo CJSON::encode(array('success' => 2, 'error' => $listError));
                    exit();
                } else {
                    echo CJSON::encode(array('success' => 1));
                    exit();
                }
            }
        }
        //$this->redirect(Yii::app()->createUrl('uploadFile'));
    }

    /**
     * delete File
     */
    public function actionDelete()
    {
        if (isset($_POST['File'])) {
            if (is_array($_POST['File']['id'])) {
                $root = dirname(Yii::app()->request->scriptFile) . '/uploads/files';
                foreach ($_POST['File']['id'] as $fi) {
                    $file = File::model()->findByPk($fi);
                    if ($file) {
                        $folderUser = $root . '/' . $file->user_id;
                        $folderFile = $folderUser . '/' . $file->folder_id;
                        unlink($folderFile . '/' . $file->file);
                        $file->delete();
                    }
                }
                echo CJSON::encode(array('success' => 1));
                exit();
            }
            echo CJSON::encode(array('success' => 2, 'error' => 'Invalid Request.'));
        }

    }

    /**
     * View file
     */
    public function actionView($id = 0)
    {
        if ($id > 0) {
            $files = File::model()->findAll("id = $id and user_id =" . Yii::app()->user->id);
            if ($files) {
                $file = $files[0];
                $root = dirname(Yii::app()->request->scriptFile) . '/uploads/files';
                $folderUser = $root . '/' . $file->user_id;
                $folderFile = $folderUser . '/' . $file->folder_id;
                //ext allowed: jpg|png|pdf|xls|xlsx|doc|docx|txt|ppt|xml
                switch ($file->ext) {
                    case 'xlsx':
                    case 'doc':
                    case 'docx':
                    case 'pdf':
                    case 'ppt':
                    case 'pptx':
                    case 'xls':
                    case 'xml':
                        //render view
                        $this->renderPartial('_view', array(
                            'source' => '/uploads/files' . '/' . $file->user_id . '/' .$file->folder_id . '/' . $file->file,
                        ));
                        break;
                    case 'png':
                    case 'jpg':
                    case 'jpeg':
                    case 'gif':
                        echo "<image src='" . '/uploads/files' . '/' . $file->user_id . '/' . $file->folder_id . '/' . $file->file . "'>";
                        break;
                    case 'txt':
                    case 'inf':
                    case 'ini':
                        echo file_get_contents($folderFile . '/' . $file->file);
                        break;
                }

                exit();
            }
        }
        throw new CHttpException(404, 'File not found');
    }

    /**
     * download file
     * @param $id
     */
    public function actionDownload($id = 0)
    {

        $fullPath = File::model()->getPathFile($id);
        if ($fullPath) {
            ignore_user_abort(true);
            set_time_limit(0); // disable the time limit for this script

            if ($fd = fopen($fullPath, "r")) {
                $fsize = filesize($fullPath);
                $path_parts = pathinfo($fullPath);
                $ext = strtolower($path_parts["extension"]);
                switch ($ext) {
                    case "pdf":
                        header("Content-type: application/pdf");
                        header("Content-Disposition: attachment; filename=\"" . $path_parts["basename"] . "\""); // use 'attachment' to force a file download
                        break;
                    // add more headers for other content types here
                    default;
                        header("Content-type: application/octet-stream");
                        header("Content-Disposition: filename=\"" . $path_parts["basename"] . "\"");
                        break;
                }
                header("Content-length: $fsize");
                header("Cache-control: private"); //use this to open files directly
                while (!feof($fd)) {
                    $buffer = fread($fd, 2048);
                    echo $buffer;
                }
            }
            fclose($fd);
            exit;
        }

    }

}