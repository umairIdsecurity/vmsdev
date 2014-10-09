<?php

class LicenseDetailsController extends Controller {

    
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
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'expression' => 'Yii::app()->controller->accessRoles("canManageLicenseDetails")',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    
    public function accessRoles($action) {
        $session = new CHttpSession;
        $CurrentRole = $session['role'];

        switch ($action) {
            case "canManageLicenseDetails":
                $user_role = array(Roles::ROLE_SUPERADMIN);
                if (in_array($CurrentRole, $user_role)) {
                    return true;
                }
                break;
            
            default:
                return false;
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $session = new CHttpSession;

        if (isset($_POST['LicenseDetails'])) {
            $model->attributes = $_POST['LicenseDetails'];
            if ($model->save()) {
                $this->redirect(array('company/admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return LicenseDetails the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = LicenseDetails::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param LicenseDetails $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'license-details-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
