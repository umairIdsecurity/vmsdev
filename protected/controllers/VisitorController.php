<?php

class VisitorController extends Controller {

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
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('update', 'admin', 'delete'),
                'expression' => 'Yii::app()->controller->checkIfUserCanAccess("superadmin")',
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create','GetIdOfUser', 'GetHostDetails', 'GetPatientDetails', 'CheckEmailIfUnique', 'GetVisitorDetails', 'FindVisitor', 'FindHost', 'GetTenantAgentWithSameTenant', 'GetCompanyWithSameTenant', 'GetCompanyWithSameTenantAndTenantAgent'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function checkIfUserCanAccess($action) {
        $session = new CHttpSession;
        $CurrentRole = $session['role'];

        switch ($action) {
            case "superadmin":
                $user_role = array(Roles::ROLE_SUPERADMIN,  Roles::ROLE_STAFFMEMBER);
                if (in_array($CurrentRole, $user_role)) {
                    return true;
                }
                break;

            default:
                return false;
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $session = new CHttpSession;
        $model = new Visitor;
        $userModel = new User();
        $patientModel = new Patient();
        $reasonModel = new VisitReason();
        $visitModel = new Visit();

        $visitorService = new VisitorServiceImpl();

        if (isset($_POST['Visitor'])) {
            $model->attributes = $_POST['Visitor'];

            if ($visitorService->save($model, $_POST['Visitor']['reason'], $session['id'])) {
                
            }
        }

        $this->render('create', array(
            'model' => $model,
            'userModel' => $userModel,
            'patientModel' => $patientModel,
            'reasonModel' => $reasonModel,
            'visitModel' => $visitModel,
                ), false, true);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $visitorService = new VisitorServiceImpl();
        $session = new CHttpSession;
        $view = 0;
        if (isset($_GET['view'])) {
            $view = 1;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Visitor'])) {
            $model->attributes = $_POST['Visitor'];
            if ($visitorService->save($model, NULL, $session['id'])) {
                switch ($view){
                    case "1":
                        break;

                    default:
                       $this->redirect(array('admin'));
                }
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /* Visitor detail page */

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
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Visitor('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visitor']))
            $model->attributes = $_GET['Visitor'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Visitor the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Visitor::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Visitor $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'visitor-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetTenantAgentWithSameTenant($id) {
        $resultMessage['data'] = User::model()->findAllTenantAgent($id);
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionGetCompanyWithSameTenant($id) {

        $resultMessage['data'] = Visitor::model()->findAllCompanyWithSameTenant($id);
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionGetCompanyWithSameTenantAndTenantAgent($id, $tenantagent) {

        $resultMessage['data'] = Visitor::model()->findAllCompanyWithSameTenantAndTenantAgent($id, $tenantagent);
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionFindVisitor($id) {
        $this->layout = '//layouts/column1';
        $model = new Visitor('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visitor']))
            $model->attributes = $_GET['Visitor'];

        $this->render('findVisitor', array(
            'model' => $model,
                ), false, true);
    }

    public function actionFindHost($id) {
        $this->layout = '//layouts/column1';
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('findHost', array(
            'model' => $model,
                ), false, true);
    }

    public function actionGetVisitorDetails($id) {
        $resultMessage['data'] = Visitor::model()->findAllByPk($id);
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionGetHostDetails($id) {
        $resultMessage['data'] = User::model()->findAllByPk($id);
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionGetPatientDetails($id) {
        $resultMessage['data'] = Patient::model()->findAllByPk($id);
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionGetIdOfUser($id) {
        $resultMessage['data'] = Visitor::model()->getIdOfUser($id);
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionCheckEmailIfUnique($id) {
        if (Visitor::model()->checkIfEmailAddressIsTaken($id)) {
            echo "1";
        } else {
            echo "0";
        }
    }
    
    

}
