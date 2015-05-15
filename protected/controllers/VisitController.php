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
                'actions' => array('create',
                    'DuplicateVisit', 'isDateConflictingWithAnotherVisit',
                    'GetVisitDetailsOfVisitor', 'getVisitDetailsOfHost', 'IsVisitorHasCurrentSavedVisit',
                    'update', 'detail', 'admin', 'view', 'exportFile', 'evacuationReport', 'evacuationReportAjax', 'DeleteAllVisitWithSameVisitorId'),
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('PrintEvacuationReport',
                    'visitorRegistrationHistory',
                    'corporateTotalVisitCount',
                    'exportFileHistory',
                    'exportFileVisitorRecords',
                    'exportVisitorRecords', 'delete',
                ),
                'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION)',
            ),
            array('allow',
                'actions' => array('RunScheduledJobsClose', 'RunScheduledJobsExpired'
                ),
                'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_SUPERADMIN)',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'detail' page.
     */
    public function actionCreate() {
        $model = new Visit;
        $visitService = new VisitServiceImpl();
        $session = new CHttpSession;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Visit'])) {
            $model->attributes = $_POST['Visit'];

            // default workstation:
            if (isset($session['workstation'])) {
                $model->workstation = $session['workstation'];
            }

            // get the lastest visitor type:
            if ($model->visitor_type == null) {
                $lastVisit = Visit::model()->find("visitor = " . $model->visitor);

                if ($lastVisit){
                    $model->visitor_type = $lastVisit->visitor_type;
                    $model->reason = $lastVisit->reason;

                } else {
                    // default value:
                    // todo: check this default later
                    $model->visitor_type = VisitorType::CORPORATE_VISITOR;

                    $reason = VisitReason::model()->findAllReason();
                    if (count($reason) > 0) {
                        $model->reason = $reason[0]->id;
                    }

                }
            }

            if ($visitService->save($model, $session['id'])) {
                $this->redirect(array('visit/detail', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $oldVisitorType = $model->visitor_type;
        $oldReason = $model->reason;

        $visitService = new VisitServiceImpl();
        $session = new CHttpSession;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Visit'])) {
            $model->attributes = $_POST['Visit'];

			if ($model->visitor_type == null) {
                $model->visitor_type = $oldVisitorType;
            }
            if ($model->reason == null) {
                $model->reason = $oldReason;
            }

             if (isset($_POST['User']['photo']) && $model->host > 0) {
                 User::model()->updateByPk($model->host, array('photo' => $_POST['User']['photo']));
			 }
			
            if ($model->date_check_in > date('d-m-Y')) {
                $visitStatus = VisitStatus::model()->findByAttributes(array('name' => 'Pre-registered'));
                if ($visitStatus) {
                    $model->visit_status = $visitStatus->id;
                }
            }
            if ($visitService->save($model, $session['id'])) {
                $this->redirect(array('visit/detail', 'id' => $id));
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
        //  $this->layout = '//layouts/contentIframeLayout';
        $model = new Visit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visit']))
            $model->attributes = $_GET['Visit'];

        $this->renderPartial('_admin', array(
            'model' => $model,
                ), false, true);
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

    /* Displays details of a visit
     * @param integer $id the ID of the model to be viewed
     *   
     */

    public function actionDetail($id) {
        $model = $this->loadModel($id);
        //update status for Contractor Card Type
        if ($model && $model->card_type == CardType::CONTRACTOR_VISITOR) {
            if (isset($model->date_check_out) && strtotime($model->date_check_out) < strtotime(date("d-m-Y"))) {
                $model->visit_status = VisitStatus::EXPIRED;
                $model->save();
            }
        }

        $visitorModel = Visitor::model()->findByPk($model->visitor);
        $reasonModel = VisitReason::model()->findByPk($model->reason);
        $patientModel = Patient::model()->findByPk($model->patient);
        $cardTypeModel = CardType::model()->findByPk($model->card_type);
		$visitModel = Visit::model()->getVisitCount($model->id);

        $newPatient = new Patient;
        $newHost = new User;

        if ($model->visitor_type == VisitorType::PATIENT_VISITOR) {
            $host = 16;
        } else {
            $host = $model->host;
        }
        $hostModel = User::model()->findByPk($host);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Visit'])) {
            if (empty($_POST['Visit']['finish_time'])) {
                $model->finish_time = date('H:i:s');
            }

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
			'visitModel' => $visitModel,
            'cardTypeModel' => $cardTypeModel,
        ));
    }

    /* Visitor Records */

    public function actionView() {
        $this->layout = "//layouts/column1";
        $session = new CHttpSession;
        $session['lastPage'] = 'visitorrecords';
        $model = new Visit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visit'])) {
            $model->attributes = $_GET['Visit'];
        }

        $this->render('viewrecords', array(
            'model' => $model,
        ));
    }

    /* Evacuation Report */

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

        $this->render('_evacuationreport', array(
            'model' => $model,
                ), false, true);
    }

    public function actionEvacuationReportAjax() {
        $model = new Visit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visit'])) {
            $model->attributes = $_GET['Visit'];
        }

        if (Yii::app()->request->getParam('export')) {
            $this->actionExport();
            Yii::app()->end();
        }

        $this->renderPartial('_evacuationreport', array(
            'model' => $model,
                ), false, true);
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

    public function actionCorporateTotalVisitCount() {
        $model = new Visitor('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visitor'])) {
            $model->attributes = $_GET['Visitor'];
        }

        $this->render('corporateTotalVisitCount', array(
            'model' => $model,false, true
        ));
    }

    public function actionExport() {
        $fp = fopen('php://temp', 'w');

        /*
         * Write a header of csv file
         */
        $headers = array(
            'visitorType.name',
            'card0.card_code',
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
        $row[] = 'Accounted for';
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
        Yii::app()->request->sendFile('Evacuation Report_' . date('dmYHis') . '.csv', Yii::app()->user->getState('export'));
        Yii::app()->user->clearState('export');
    }

    /* Export Visitor Registration History */

    public function actionExportHistory() {
        $fp = fopen('php://temp', 'w');

        /*
         * Write a header of csv file
         */
        $headers = array(
            'visitorType.name',
            'card0.card_code',
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
        Yii::app()->request->sendFile('Visitor Registration History_' . date('dmYHis') . '.csv', Yii::app()->user->getState('export'));
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
            'card0.card_code',
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
        Yii::app()->request->sendFile('Visit History_' . date('dmYHis') . '.csv', Yii::app()->user->getState('export'));
        Yii::app()->user->clearState('export');
    }

    public function actionRunScheduledJobsClose() {

        echo "Scheduled Jobs - Close <br>";
        $visit = new VisitServiceImpl();
        $visit->notreturnCardIfVisitIsClosedAutomatically();
    }

    public function actionRunScheduledJobsExpired() {

        echo "Scheduled Jobs - Expired <br>";
        $visit = new VisitServiceImpl();
        $visit->notreturnCardIfVisitIsExpiredAutomatically();
    }

    public function actionDeleteAllVisitWithSameVisitorId($id) {
        Visit::model()->updateCounters(array('is_deleted' => 1), 'visitor=:visitor', array(':visitor' => $id));
        Visitor::model()->updateByPk($id, array('is_deleted' => '1'));
        return true;
    }

    public function actionDuplicateVisit($id) {
        $visitService = new VisitServiceImpl();
        $session = new CHttpSession;
        $model = $this->loadModel($id); // record that we want to duplicate
        $model->id = null;
        $model->visit_status = VisitStatus::SAVED;
        $model->date_in = '';
        $model->time_in = '';
        $model->time_out = '';
        $model->date_out = '';
        $model->date_check_in = '';
        $model->time_check_in = '';
        $model->time_check_out = '';
        $model->date_check_out = '';
        $model->card = NULL;

        $model->isNewRecord = true;
        $model->attributes = $_POST['Visit'];

        if ($visitService->save($model, $session['id'])) {
            echo $model->id;
        }
    }

    public function actionIsVisitorHasCurrentSavedVisit($id) {
        if (Visit::model()->isVisitorHasCurrentSavedVisit($id)) {
            $aArray[] = array(
                'isTaken' => 1,
            );
        } else {
            $aArray[] = array(
                'isTaken' => 0,
            );
        }

        $resultMessage['data'] = $aArray;
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionGetVisitDetailsOfVisitor($id) {
        $Criteria = new CDbCriteria();
        $Criteria->condition = "visitor = '" . $id . "' and visit_status='" . VisitStatus::SAVED . "'";
        $visit = Visit::model()->findAll($Criteria);
        $resultMessage['data'] = $visit;
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionGetVisitDetailsOfHost($id) {
        $user = User::model()->findAllByPk($id);
		$photo = Photo::model()->findAllByPk($user[0]->photo);
		$resultMessage['data'] = $user;
		$resultMessage['data']["photo"] = $photo[0];
		  
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionIsDateConflictingWithAnotherVisit($date_in, $date_out, $visitorId, $visitStatus) {
        if (Visit::model()->isDateConflictingWithAnotherVisit($date_in, $date_out, $visitorId, $visitStatus)) {
            $aArray[] = array(
                'isConflicting' => 1,
            );
        } else {
            $aArray[] = array(
                'isConflicting' => 0,
            );
        }

        $resultMessage['data'] = $aArray;
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    private function populateWorkstation() {
        $session = new CHttpSession;

        switch ($session['role']) {
            case Roles::ROLE_SUPERADMIN:
                $workstationList = Workstation::model()->findAll();
                break;

            case Roles::ROLE_OPERATOR:
            case Roles::ROLE_AGENT_OPERATOR:
                $Criteria = new CDbCriteria();
                $Criteria->condition = "id ='" . $session['workstation'] . "'";
                $workstationList = Workstation::model()->findAll($Criteria);
                break;

            case Roles::ROLE_STAFFMEMBER:
                if ($session['tenant'] == NULL) {
                    $tenantsearchby = "IS NULL";
                } else {
                    $tenantsearchby = "='" . $session['tenant'] . "'";
                }

                if ($session['tenant_agent'] == NULL) {
                    //$tenantagentsearchby = "and tenant_agent IS NULL";
                    $tenantagentsearchby = "";
                } else {
                    $tenantagentsearchby = "and tenant_agent ='" . $session['tenant_agent'] . "'";
                }
                $Criteria = new CDbCriteria();
                $Criteria->condition = "tenant $tenantsearchby  $tenantagentsearchby";
                $workstationList = Workstation::model()->findAll($Criteria);
                break;

            case Roles::ROLE_ADMIN:
                $Criteria = new CDbCriteria();
                $Criteria->condition = "tenant ='" . $session['tenant'] . "'";
                $workstationList = Workstation::model()->findAll($Criteria);
                break;

            case Roles::ROLE_AGENT_ADMIN:
                $Criteria = new CDbCriteria();
                $Criteria->condition = "tenant ='" . $session['tenant'] . "' and tenant_agent ='" . $session['tenant_agent'] . "'";
                $workstationList = Workstation::model()->findAll($Criteria);
                break;
        }

        return $workstationList;
    }
}
