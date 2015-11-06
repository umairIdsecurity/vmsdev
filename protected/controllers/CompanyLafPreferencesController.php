<?php

class CompanyLafPreferencesController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

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
        return array(
            array('allow',
                'actions' => array('customisation', 'create', 'update', 'ajaxCrop'),
                'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user, UserGroup::USERGROUP_ADMINISTRATION)',
            ),
            array('allow',
                'actions' => array('css','companyLogo'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionCss(){

        $session = new CHttpSession;
//        if(!isset($session['tenant.css'])) {
//            $this->GenerateCss();
//        }
        // Take Immediate Effect after change
        $this->GenerateCss();
        $size = strlen($session['tenant.css']);

        header('Content-Length: '. $size);
        header('Content-Type: text/css');
        echo $session['tenant.css'];
        exit;
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new CompanyLafPreferences;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CompanyLafPreferences'])) {
            $model->attributes = $_POST['CompanyLafPreferences'];
            if ($model->save()) {
                
            }
            //$this->redirect(array('view','id'=>$model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CompanyLafPreferences'])) {
            $model->attributes = $_POST['CompanyLafPreferences'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('CompanyLafPreferences');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new CompanyLafPreferences('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CompanyLafPreferences']))
            $model->attributes = $_GET['CompanyLafPreferences'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAjaxCrop() {
        $jpeg_quality = 90;
         
        //$src = $_REQUEST['imageUrl']; 
         $photo = Photo::model()->findByPk($_REQUEST["logo_id"]);
       echo  $src = $photo->relative_path;
          
        $file = fopen($src,"w");
        fwrite($file, base64_decode($photo->db_image));
        fclose($file);
 
        $img_r = imagecreatefromjpeg($src);
        $dst_r = imagecreatetruecolor(184, 114);
        $usernameHash = hash('adler32', "visitor");
        $uniqueFileName = 'visitor' . $usernameHash . '-' . time() . ".jpg";
        imagecopyresampled($dst_r, $img_r, 0, 0, $_REQUEST['x1'], $_REQUEST['y1'], 184, 114, $_REQUEST['width'], $_REQUEST['height']);
      
        header('Content-type: image/jpeg');
        imagejpeg($dst_r, "uploads/company_logo/" . $uniqueFileName, $jpeg_quality);

        // Now convert the same croped image into blob for save
        $cropedImage = file_get_contents("uploads/company_logo/" . $uniqueFileName);
        $saveImage = base64_encode($cropedImage);
        
        Photo::model()->updateByPk($_REQUEST['photoId'], array(
            'unique_filename' => $uniqueFileName,
            'relative_path' => "uploads/company_logo/" . $uniqueFileName,
            'db_image' => $saveImage,
        ));
        
          if (file_exists($src)) {
           // unlink($src);
        }

        exit;
        return true;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CompanyLafPreferences the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = CompanyLafPreferences::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CompanyLafPreferences $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-laf-preferences-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionCustomisation() {
        $session = new CHttpSession;
        $companyLafPreferencesService = new CompanyLafPreferencesServiceImpl();
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $company = Company::model()->findByPk($session['tenant']);

        if ($company->company_laf_preferences != '') {
            $model = $this->loadModel($company->company_laf_preferences);
        } else {
            $model = new CompanyLafPreferences;
        }
        if (isset($_POST['CompanyLafPreferences'])) {
            $model->attributes = $_POST['CompanyLafPreferences'];
            if ($companyLafPreferencesService->save($model, $company)) {
                $this->GenerateCss($company);
                Yii::app()->user->setFlash('success', 'Customisation Successfully updated!');
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function GenerateCss() {

        ob_start(); // Capture all output (output buffering)
        require_once(Yii::app()->basePath . '/views/companyLafPreferences/css_template.php');
        $css = ob_get_clean(); // Get generated CSS (output buffering)
        $session['tenant.css'] = $css;

    }

}
