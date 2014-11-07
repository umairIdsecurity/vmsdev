<?php

class VisitReasonController extends Controller {

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
                'actions' => array('create','GetAllReason','CheckReasonIfUnique'),
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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $session = new CHttpSession;
        $model = new VisitReason;
        $visitReasonService = new VisitReasonServiceImpl();
        $viewFrom = 0;
        if (isset($_GET['register'])) {
            $viewFrom = 1;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['VisitReason'])) {
            $model->attributes = $_POST['VisitReason'];
            if ($visitReasonService->save($model, $session['id'])) {

                switch ($viewFrom) {
                    case 1:
                        break;
                    default:
                        $this->redirect(array('admin'));
                }
            }
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

        if (isset($_POST['VisitReason'])) {
            $model->attributes = $_POST['VisitReason'];
            if ($model->save())
                $this->redirect(array('admin'));
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
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new VisitReason('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['VisitReason']))
            $model->attributes = $_GET['VisitReason'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return VisitReason the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = VisitReason::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param VisitReason $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'visit-reason-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetAllReason() {
        $resultMessage['data'] = VisitReason::model()->GetAllReason();

        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }
    
    public function actionCheckReasonIfUnique($id) {
        if (VisitReason::model()->checkIfReasonIsTaken($id)) {
            echo "1";
        } else {
            echo "0";
        }
    }
}
