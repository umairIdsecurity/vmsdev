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
                'actions' => array('customisation', 'create', 'update'),
                'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user, UserGroup::USERGROUP_ADMINISTRATION)',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
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
        $company = Company::model()->findByPk($session['company']);

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

    public function GenerateCss($company) {
        $session = new CHttpSession;
        $companyLafPreferences = CompanyLafPreferences::model()->findByPk($company->company_laf_preferences);

        $filename = $company->code . "-" . time() . ".css";
        $filepath = 'company_css/' . $filename;

        if (!file_exists(Yii::app()->request->baseUrl . "company_css")) {
            mkdir(Yii::app()->request->baseUrl . "company_css", 0777, true);
        }

        ob_start(); // Capture all output (output buffering)

        require_once(Yii::app()->basePath . '/views/companyLafPreferences/css_template.php');

        $css = ob_get_clean(); // Get generated CSS (output buffering)
        file_put_contents(Yii::app()->request->baseUrl . $filepath, $css, LOCK_EX); // Save it



        if ($companyLafPreferences->css_file_path != '') {

            unlink(Yii::getPathOfAlias('webroot') . $companyLafPreferences->css_file_path); //delete file
        }

        CompanyLafPreferences::model()->updateByPk($company->company_laf_preferences, array(
            'css_file_path' => '/company_css/' . $filename,
        ));
    }

}
