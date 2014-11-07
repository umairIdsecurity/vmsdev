<?php

class VisitController extends Controller {

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
                'actions' => array('create', 'update', 'detail', 'admin', 'view'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }


    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Visit;
        $visit = new VisitServiceImpl();
        $session = new CHttpSession;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Visit'])) {
            $model->attributes = $_POST['Visit'];
            if ($visit->save($model, $session['id'])) {
                
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
        $visit = new VisitServiceImpl();
        $session = new CHttpSession;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Visit'])) {
            $model->attributes = $_POST['Visit'];
            if ($visit->save($model, $session['id'])) {
                
            }
            // $this->redirect(array('view', 'id' => $model->id));
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
        $dataProvider = new CActiveDataProvider('Visit');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Visit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visit']))
            $model->attributes = $_GET['Visit'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Visit the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Visit::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Visit $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'visit-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionDetail($id) {
        $model = $this->loadModel($id);
        $visitorModel = Visitor::model()->findByPk($model->visitor);
        $reasonModel = VisitReason::model()->findByPk($model->reason);
        $patientModel = Patient::model()->findByPk($model->patient);
        $cardTypeModel = CardType::model()->findByPk($model->card_type);

        $newPatient = new Patient;
        $newHost = new User;

        if ($model->visitor_type == VisitorType::PATIENT_VISITOR) {
            $host = 16;
        } else {
            $host = $model->host;
        }
        $hostModel = User::model()->findByPk($host);



        $visitorService = new VisitorServiceImpl();
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Visit'])) {
            $model->attributes = $_POST['Visit'];
            if ($model->save()) {
                
            }
        }

        $this->render('visitordetail', array(
            'model' => $model,
            'visitorModel' => $visitorModel,
            'reasonModel' => $reasonModel,
            'hostModel' => $hostModel,
            'patientModel' => $patientModel,
            'newPatient' => $newPatient,
            'newHost' => $newHost,
            'cardTypeModel' => $cardTypeModel,
        ));
    }

    /* Visitor Records */

    public function actionView() {
        $this->layout = "//layouts/column1";
        $model = new Visit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visit'])) {
            $model->attributes = $_GET['Visit'];
        }

        $this->render('viewrecords', array(
            'model' => $model,
        ));
    }

}
