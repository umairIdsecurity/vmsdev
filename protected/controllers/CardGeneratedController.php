<?php

class CardGeneratedController extends Controller {

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
                'actions' => array('create', 'update', 'admin', 'delete', 'print', 'reprint'),
                'users' => array('@'),
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
        $model = new CardGenerated;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CardGenerated'])) {
            $model->attributes = $_POST['CardGenerated'];
            if ($model->save()) {
                
            }
            //$this->redirect(array('view','id'=>$model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionPrint($id) {
        $this->layout = '//layouts/column1';
        
        $cardGenerated = new CardGenerated;
        $cardGeneratedService = new CardGeneratedServiceImpl();
        $session = new CHttpSession;
        $model = Visit::model()->findByPk($id);
        $visitorModel = Visitor::model()->findByPk($model->visitor);
        $tenant = User::model()->findByPk($visitorModel->tenant);
        if ($tenant->company != '') {
            $inc = 6 - (strlen($model->id));
            $int_code = '';
            for ($x = 1; $x <= $inc; $x++) {

                $int_code .= "0";
            }
            $code = Company::model()->findByPk($tenant->company)->code . $int_code . $model->id;
        } else {
            $code ='';
        }

        $cardGeneratedArray = array(
            'card_code' => $code,
            'date_printed' => date("d-m-Y"),
            'date_expiration' => date("d-m-Y"),
            'visitor_id' => $model->visitor,
            'tenant' => $model->tenant,
            'tenant_agent' => $model->tenant_agent,
            'card_status' => CardStatus::ACTIVE,
            'created_by' => $session['id'],
        );
        $cardGenerated->attributes = $cardGeneratedArray;
        if ($cardGeneratedService->save($cardGenerated, $model, Yii::app()->user)) {

            $this->renderPartial('print', array(
                'model' => $model,
                'visitorModel' => $visitorModel,
            ));
        }
    }

    public function actionReprint($id) {
        $this->layout = '//layouts/column1';

        $cardGenerated = new CardGenerated;
        $cardGeneratedService = new CardGeneratedServiceImpl();
        $session = new CHttpSession;
        $model = Visit::model()->findByPk($id);
        $visitorModel = Visitor::model()->findByPk($model->visitor);
        $tenant = User::model()->findByPk($visitorModel->tenant);
        if ($tenant->company != '') {
            $inc = 6 - (strlen($model->id));
            $int_code = '';
            for ($x = 1; $x <= $inc; $x++) {

                $int_code .= "0";
            }
            $code = Company::model()->findByPk($tenant->company)->code . $int_code . $model->id;
        } else {
            $code ='';
        }


        $cardGeneratedArray = array(
            'card_code' => $code,
            'date_printed' => date("d-m-Y"),
            'date_expiration' => date("d-m-Y"),
            'visitor_id' => $model->visitor,
            'tenant' => $model->tenant,
            'tenant_agent' => $model->tenant_agent,
            'card_status' => CardStatus::ACTIVE,
            'created_by' => $session['id'],
        );
        $cardGenerated->attributes = $cardGeneratedArray;

        if ($cardGeneratedService->updateCard($cardGenerated, $model, Yii::app()->user)) {
            $this->render('print', array(
                'model' => $model,
                'visitorModel' => $visitorModel,
            ));
        }
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

        if (isset($_POST['CardGenerated'])) {
            $model->attributes = $_POST['CardGenerated'];
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
        $dataProvider = new CActiveDataProvider('CardGenerated');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new CardGenerated('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CardGenerated']))
            $model->attributes = $_GET['CardGenerated'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CardGenerated the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = CardGenerated::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CardGenerated $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'card-generated-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
