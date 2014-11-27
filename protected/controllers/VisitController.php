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
            array('allow',
                'actions' => array('evacuationReport', 'PrintEvacuationReport',
                    'visitorRegistrationHistory',
                    'exportFile',
                    'exportFileHistory',
                    'exportFileVisitorRecords',
                    'exportVisitorRecords',
                ),
                'expression' => 'Yii::app()->controller->accessRoles("administration")',
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
            case "administration":
                $user_role = array(Roles::ROLE_ADMIN, Roles::ROLE_SUPERADMIN, Roles::ROLE_AGENT_ADMIN);
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
        $model = new Visit;
        $visit = new VisitServiceImpl();
        $session = new CHttpSession;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Visit'])) {
            $model->attributes = $_POST['Visit'];
            if ($visit->save($model, $session['id'])) {
                $this->redirect(array('visit/detail', 'id' => $model->id));
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

    public function actionEvacuationReport() {
        $model = new Visit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visit'])) {
            $model->attributes = $_GET['Visit'];
        }

        if (Yii::app()->request->getParam('export')) {
            $this->actionExport();
            Yii::app()->end();
        }

        $this->render('evacuationreport', array(
            'model' => $model,
        ));
    }

    public function actionVisitorRegistrationHistory() {
        $model = new Visit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visit'])) {
            $model->attributes = $_GET['Visit'];
        }
        
        if (Yii::app()->request->getParam('export')) {
            $this->actionExportHistory();
            Yii::app()->end();
        }
        
        $this->render('visitorRegistrationHistory', array(
            'model' => $model,
        ));
    }

    public function actionExport() {
        $fp = fopen('php://temp', 'w');

        /*
         * Write a header of csv file
         */
        $headers = array(
            'visitorType.name',
            'card',
            'visitor0.first_name',
            'visitor0.last_name',
            'visitor0.contact_number',
            'visitor0.email',
            'date_in',
            'time_in',
            'date_out',
            'time_out'
        );
        $row = array();
        foreach ($headers as $header) {
            $row[] = Visit::model()->getAttributeLabel($header);
        }
        fputcsv($fp, $row);

        /*
         * Init dataProvider for first page
         */
        $model = new Visit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visit'])) {
            $model->attributes = $_GET['Visit'];
        }
       
            $merge = new CDbCriteria;
            $merge->addCondition('visit_status ="' . VisitStatus::ACTIVE . '"');

            $dp = $model->search($merge);
        

        /*
         * Get models, write to a file, then change page and re-init DataProvider
         * with next page and repeat writing again
         */
        $dp->setPagination(false);

        /*
         * Get models, write to a file
         */

        $models = $dp->getData();
        foreach ($models as $model) {
            $row = array();
            foreach ($headers as $head) {
                $row[] = CHtml::value($model, $head);
            }
            fputcsv($fp, $row);
        }

        /*
         * save csv content to a Session
         */
        rewind($fp);
        Yii::app()->user->setState('export', stream_get_contents($fp));
        fclose($fp);
    }

    public function actionExportFile() {
        Yii::app()->request->sendFile('evacuationreport.csv', Yii::app()->user->getState('export'));
        Yii::app()->user->clearState('export');
    }

    public function actionExportHistory() {
        $fp = fopen('php://temp', 'w');

        /*
         * Write a header of csv file
         */
        $headers = array(
            'visitorType.name',
            'card',
            'visitor0.first_name',
            'visitor0.last_name',
            'visitor0.contact_number',
            'visitor0.email',
            'date_in',
            'time_in',
            'date_out',
            'time_out'
        );
        $row = array();
        foreach ($headers as $header) {
            $row[] = Visit::model()->getAttributeLabel($header);
        }
        fputcsv($fp, $row);

        /*
         * Init dataProvider for first page
         */
        $model = new Visit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visit'])) {
            $model->attributes = $_GET['Visit'];
        }

        $merge = new CDbCriteria;
        $merge->addCondition('visit_status ="' . VisitStatus::CLOSED . '"');

        $dp = $model->search($merge);

        /*
         * Get models, write to a file, then change page and re-init DataProvider
         * with next page and repeat writing again
         */
        $dp->setPagination(false);

        /*
         * Get models, write to a file
         */

        $models = $dp->getData();
        foreach ($models as $model) {
            $row = array();
            foreach ($headers as $head) {
                $row[] = CHtml::value($model, $head);
            }
            fputcsv($fp, $row);
        }

        /*
         * save csv content to a Session
         */
        rewind($fp);
        Yii::app()->user->setState('export', stream_get_contents($fp));
        fclose($fp);
    }

    public function actionExportFileHistory() {
        Yii::app()->request->sendFile('viewregistrationHistory.csv', Yii::app()->user->getState('export'));
        Yii::app()->user->clearState('export');
    }
    
    public function actionExportVisitorRecords() {
        $model = new Visit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visit'])) {
            $model->attributes = $_GET['Visit'];
        }

        if (Yii::app()->request->getParam('export')) {
            $this->actionExportVisitorRecordsCSV();
            Yii::app()->end();
        }

        $this->render('exportvisitorrecords', array(
            'model' => $model,
        ));
    }
    
    public function actionExportVisitorRecordsCSV() {
        $fp = fopen('php://temp', 'w');

        /*
         * Write a header of csv file
         */
        $headers = array(
            
            'card',
            'visitor0.first_name',
            'visitor0.last_name',
            'visitor0.visitor_status',
            'visitor0.email',
            'visitor0.contact_number',
            'visitorType.name',
            'date_in',
            'time_in',
        );
        $row = array();
        foreach ($headers as $header) {
            $row[] = Visit::model()->getAttributeLabel($header);
        }
        fputcsv($fp, $row);

        /*
         * Init dataProvider for first page
         */
        $model = new Visit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visit'])) {
            $model->attributes = $_GET['Visit'];
        }

       
        $dp = $model->search();

        /*
         * Get models, write to a file, then change page and re-init DataProvider
         * with next page and repeat writing again
         */
        $dp->setPagination(false);

        /*
         * Get models, write to a file
         */

        $models = $dp->getData();
        foreach ($models as $model) {
            $row = array();
            foreach ($headers as $head) {
                $row[] = CHtml::value($model, $head);
            }
            fputcsv($fp, $row);
        }

        /*
         * save csv content to a Session
         */
        rewind($fp);
        Yii::app()->user->setState('export', stream_get_contents($fp));
        fclose($fp);
    }

    public function actionExportFileVisitorRecords() {
        Yii::app()->request->sendFile('visitorrecords.csv', Yii::app()->user->getState('export'));
        Yii::app()->user->clearState('export');
    }
    

}
