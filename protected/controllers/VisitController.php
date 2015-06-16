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
                    'update', 'detail', 'admin', 'view', 'exportFile', 'evacuationReport', 'evacuationReportAjax', 'vicTotalVisitCountAjax', 'DeleteAllVisitWithSameVisitorId'),
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('PrintEvacuationReport',
                    'visitorRegistrationHistory',
                    'corporateTotalVisitCount',
                    'vicTotalVisitCount',
                    'vicRegister',
                    'totalVicsByWorkstation',
                    'exportFileHistory',
                    'exportFileVisitorRecords',
                    'exportFileVicRegister',
                    'importVisitData',
                    'exportVisitorRecords', 'delete','resetVisitCount', 'negate',
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

            if (!isset($_POST['Visit']['date_check_in'])) {
                $_POST['Visit']['date_check_in'] = date('d-m-Y');
                $_POST['Visit']['time_check_in'] = date('h:i:s');
            }

            if (!isset($_POST['Visit']['reason']) || empty($_POST['Visit']['reason'])) {
                $_POST['Visit']['reason'] = 1;
            }

            $model->attributes = $_POST['Visit'];

            switch ($model->card_type) {
                case CardType::VIC_CARD_SAMEDATE: // VIC Sameday
                    $model->date_check_out = date('d-m-Y');
                    break;
                case CardType::VIC_CARD_MANUAL: // VIC Manual
                case CardType::VIC_CARD_24HOURS: // VIC 24 hour
                    $model->date_check_out = date('d-m-Y', strtotime($model->date_check_in . ' + 1 day'));
                    break;
                case CardType::VIC_CARD_EXTENDED: // VIC Extended
                case CardType::VIC_CARD_MULTIDAY: // VIC Multiday
                    $model->date_check_out = date('d-m-Y', strtotime($model->date_check_in . ' + 28 day'));
                    break;
            }

            $model->time_check_out = $model->time_check_in;

            // default workstation:
            if ((!isset($_POST['Visit']['workstation']) || empty($_POST['Visit']['workstation'])) && isset($session['workstation'])) {
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

                    /*$reason = VisitReason::model()->findAllReason();
                    if (count($reason) > 0) {
                        $model->reason = $reason[0]->id;
                    }*/

                }
            }

            //check $reasonId has exist until add new.
            if ($model->reason == 'Other' || !$model->reason){
                $newReason = new VisitReason();
                $newReason->setAttribute('reason',isset($_POST['Visit']['reason_note'])?$_POST['Visit']['reason_note']:'');
                if($newReason->save()){
                    $model->reason = $newReason->id;
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

            if (isset($_POST['closeVisitForm']) && $model->visit_status == VisitStatus::CLOSED) {
                $model->card_lost_declaration_file = CUploadedFile::getInstance($model, 'card_lost_declaration_file');
                $model->finish_time = date('H:i:s');
            }


            if ($visitService->save($model, $session['id'])) {
                if ($model->card_lost_declaration_file != null) {
                    $model->card_lost_declaration_file->saveAs(YiiBase::getPathOfAlias('webroot') . '/uploads/card_lost_declaration/'.$model->card_lost_declaration_file->name);
                }

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
        /** @var Visit $model */
        $model = Visit::model()->findByPk($id);
        // Check if model is empty then redirect to visit history
        if (empty($model)) {
            return $this->redirect(Yii::app()->createUrl('visit/view'));
        }
        $oldStatus = $model->visit_status;

        if (!$model) {
	        if (Yii::app()->request->isAjaxRequest) {
	        	echo '<script> window.location = "' . Yii::app()->createUrl('visit/view') . '"; </script>';
	        	exit();
	        } else {
	        	$this->redirect(Yii::app()->createUrl('visit/view'));
	        	exit();
	        }
        }

        $workstationModel = Workstation::model()->findByPk($model->workstation);

        if (empty($workstationModel) && in_array($model->visit_status, VisitStatus::$VISIT_STATUS_DENIED)) {
            Yii::app()->user->setFlash('error', 'Workstation of this visit has been deleted.');
            $this->redirect(Yii::app()->createUrl('visit/view'));
        }
        
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
		$visitCount = Visit::model()->getVisitCount($model->id);
        $visitCount['totalVisits'] = $model->visitCounts;
        $visitCount['remainingDays'] = $model->remainingDays;

        $newPatient = new Patient;
        $newHost = new User;

        if ($model->visitor_type == VisitorType::PATIENT_VISITOR) {
            $host = 16;
        } else {
            $host = $model->host;
        }
        $hostModel = User::model()->findByPk($host);


        if (isset($_POST['Visit'])) {
            if (empty($_POST['Visit']['finish_time'])) {
                $model->finish_time = date('H:i:s');
            }

            $model->attributes = $_POST['Visit'];

            if (isset($_POST['Visitor']['visitor_card_status']) && $_POST['Visitor']['visitor_card_status'] != $visitorModel->visitor_card_status) {
                $visitorModel->visitor_card_status = $_POST['Visitor']['visitor_card_status'];
                if ($visitorModel->visitor_card_status == Visitor::ASIC_ISSUED) {
                    $visitorModel->profile_type = Visitor::PROFILE_TYPE_ASIC;
                }

                if ($visitorModel->save()) {
                    if (in_array($visitorModel->visitor_card_status, [Visitor::ASIC_PENDING])) {
                        $model->date_check_in = $model->date_check_out;
                        if ($model->save()) {
                            $visitCount['totalVisits'] = $model->visitCounts;
                            $visitCount['remainingDays'] = $model->remainingDays;
                        }
                    }
                }
            }
            #check card type is V24h and present status visit is active
            if ($model->card_type == 6 && Visit::model()->findByPk($id)->visit_status == VisitStatus::ACTIVE && $model->visit_status == VisitStatus::CLOSED){

                #Change status autoclosed for vic 24h
                $model->visit_status = VisitStatus::AUTOCLOSED;

                #change datetime check in and out for vic 24h.
                $model->date_check_in = $model->date_check_out;
                $model->date_check_out = date('d-m-Y', strtotime('+1 day', strtotime( $model->date_check_out)));
                $model->time_check_in = date('H:i:s', strtotime('+1 minutes', strtotime($model->date_check_in.' '.$model->time_check_in)));
                $model->time_check_out = $model->time_check_in;


            }
            // close visit process
            if (isset($_POST['closeVisitForm']) && $model->visit_status == VisitStatus::CLOSED) {
                $fileUpload = CUploadedFile::getInstance($model, 'card_lost_declaration_file');
                if ($fileUpload != null) {
                    $path = YiiBase::getPathOfAlias('webroot') . '/uploads/card_lost_declaration';
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $model->card_lost_declaration_file = '/uploads/card_lost_declaration/'.$fileUpload->name;
                }

            }

            if ($model->save()) {
                if (isset($_POST['closeVisitForm'])) {
                    $visitCount['totalVisits'] = $model->visitCounts;
                    $visitCount['remainingDays'] = $model->remainingDays;
                }
                
                if (!empty($fileUpload)) {
                    $fileUpload->saveAs(YiiBase::getPathOfAlias('webroot') . $model->card_lost_declaration_file);
                }
            } else {
                $model->visit_status = $oldStatus;
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
			'visitCount' => $visitCount,
            'cardTypeModel' => $cardTypeModel,
        ));
    }

    /* Visitor Records */

    public function actionView() {
        $this->layout = "//layouts/column1";
        $session = new CHttpSession;
        $session['lastPage'] = 'visitorrecords';
        //Archive Expired 48 Old Pre-registered Visits
        Visit::model()->archivePregisteredOldVisits();
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
        $merge = new CDbCriteria;
        $merge->addCondition('profile_type = "'. Visitor::PROFILE_TYPE_CORPORATE .'"');

        $model = new Visitor('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visitor'])) {
            $model->attributes = $_GET['Visitor'];
        }

        $this->render('corporateTotalVisitCount', array(
            'model' => $model, 'merge' => $merge, false, true
        ));
    }

    public function actionVicTotalVisitCount() {
        $merge = new CDbCriteria;
        $merge->addCondition('profile_type = "'. Visitor::PROFILE_TYPE_VIC .'"');

        $model = new Visitor('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visitor'])) {
            $model->attributes = $_GET['Visitor'];
        }

        $this->render('vicTotalVisitCount', array(
            'model' => $model, 'merge' => $merge, false, true
        ));
    }

    public function actionVicRegister() {
        $merge = new CDbCriteria;
        $merge->addCondition('visitor0.profile_type = "'. Visitor::PROFILE_TYPE_VIC .'"');

        $model = new Visit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visit'])) {
            $model->attributes = $_GET['Visit'];
        }

        if (Yii::app()->request->getParam('export')) {
            $this->actionExportVicRegister();
            Yii::app()->end();
        }

        $this->render('vicRegister', array(
            'model' => $model, 'merge' => $merge, false, true
        ));
    }

    public function actionVicTotalVisitCountAjax() {
        $merge = new CDbCriteria;
        $merge->addCondition('profile_type = "'. Visitor::PROFILE_TYPE_VIC .'"');

        $model = new Visitor('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visitor'])) {
            $model->attributes = $_GET['Visitor'];
        }

        $this->renderPartial('corporateTotalVisitCount', array(
            'model' => $model, 'merge' => $merge, false, true
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
         * Write a header of csv file, Field are same as Import CSV
         */
          $headers = array(
            'visitor0.first_name',
            'visitor0.last_name',
            'visitor0.email',
            'date_check_in',
            'time_check_in',
            'date_check_out',
            'time_check_out', 
            'company0.name',  
            'visitor0.position',  
            'card0.card_number',
            'card0.date_printed',
            'card0.date_expiration',  
            'visitor0.contact_number',
            
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

        ///update data from $_POST
        $model->attributes = $_POST['Visit'];

        //set status to pre-registered
        if ($model->date_check_in > date('d-m-Y')) {
            $model->visit_status = VisitStatus::PREREGISTERED;
        }

        //update date checkout in case card 24h
        if (!empty($model)) {
            switch ($model->card_type) {
                case CardType::VIC_CARD_SAMEDATE:
                    $model->date_check_out = date('d-m-Y');
                    $model->time_check_out = $model->time_check_in;
                    break;
                case CardType::VIC_CARD_24HOURS:
                case CardType::VIC_CARD_MANUAL:
                    $model->date_check_out = date('d-m-Y', strtotime($model->date_check_in . ' + 1 day'));
                    $model->time_check_out = $model->time_check_in;
                    break;
                case CardType::VIC_CARD_EXTENDED:
                case CardType::VIC_CARD_MULTIDAY:
                    $model->date_check_out = date('d-m-Y', strtotime($model->date_check_in . ' + 28 day'));
                    $model->time_check_out = $model->time_check_in;
                    break;
            }
        }

        

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
        if (isset($photo[0])) {
            $resultMessage['data']["photo"] = $photo[0];
        }

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

    public function actionResetVisitCount() {
        $visitorModel = Visitor::model()->findByPk(Yii::app()->getRequest()->getQuery('id'));

        if($visitorModel->totalVisit > 0) {
            $resetHistory = new ResetHistory();
            $resetHistory->visitor_id = Yii::app()->getRequest()->getQuery('id');
            $resetHistory->reset_time = date("Y-m-d H:i:s");
            $resetHistory->reason = Yii::app()->getRequest()->getQuery('reason');

            if($resetHistory->save()) {
                $activeVisit = $visitorModel->activeVisits;
                foreach($activeVisit as $item) {
                    $item->reset_id = $resetHistory->id;
                    $item->save();
                    if($item->save()){
                    }
                }
            }
        }
    }

    public function actionNegate() {
        $visitIds = Yii::app()->getRequest()->getQuery('ids');
        foreach ($visitIds as $id) {
            $model = Visit::model()->findByPk($id);
            $model->negate_reason = Yii::app()->getRequest()->getQuery('reason');;
            $model->save();

        }
    }

    public function actionExportFileVicRegister()
    {
        Yii::app()->request->sendFile('VicRegister_' . date('dmYHis') . '.csv', Yii::app()->user->getState('export'));
        Yii::app()->user->clearState('export');
    }

    public function actionExportVicRegister() {
        $fp = fopen('php://temp', 'w');

        /*
         * Write a header of csv file
         */
        $headers = array(
            'id' => 'ID',
            'card0.card_number' => 'Card Number',
            'company0.code' => 'Airport Code',
            'visitor0.first_name' => 'First Name',
            'visitor0.last_name' => 'Last Name',
            'visitor0.date_of_birth' => 'Date of Birthday',
            'visitor0.contact_number' => 'Mobile',
            'visitor0.contact_street_no' => 'Street No',
            'visitor0.contact_street_name' => 'Street',
            'visitor0.contact_street_type' => 'Street Type',
            'visitor0.contact_suburb' => 'Suburbe',
            'visitor0.contact_state' => 'State',
            'visitor0.contact_postcode' => 'Postcode',
            'reason0.reason' => 'Reason',
            'company0.name' => 'Company Name',
            'visitor0.email' => 'Contact Email',
            'finish_date' => 'Date of Issue',
            'card_returned_date' => 'Date of Return',
            'identification_type' => 'Document Type',
            'identification_document_no' => 'Number',
            'identification_document_expiry' => 'Expiry',
            'visitor0.asic_no' => 'ASIC ID Number',
            'visitor0.asic_expiry' => 'ASIC Expiry',
            'workstation0.name' => 'Workstation'
        );
        $row = array();
        foreach ($headers as $header) {
            $row[] = Visit::model()->getAttributeLabel($header);
        }
        fputcsv($fp, $row);
        /*
         * Init dataProvider for first page
         */
        $merge = new CDbCriteria;
        $merge->addCondition('visitor0.profile_type = "'. Visitor::PROFILE_TYPE_VIC .'"');

        $model = new Visit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visitor'])) {
            $model->attributes = $_GET['Visitor'];
        }

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
            foreach ($headers as $head => $title) {
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

    public function actionTotalVicsByWorkstation()
    {
        $dateFromFilter = Yii::app()->request->getParam("date_from_filter");
        $dateToFilter = Yii::app()->request->getParam("date_to_filter");

        $dateCondition='';

        if( !empty($dateFromFilter) && !empty($dateToFilter) ) {

            $from = new DateTime($dateFromFilter);
            $to = new DateTime($dateToFilter);

            $dateCondition = '(visits.date_check_in BETWEEN "'.$from->format('d-m-Y').'"'
                . ' AND "'.$to->format('d-m-Y').'") OR (visits.date_check_in BETWEEN "'.$from->format('Y-m-d').'"'
                . ' AND "'.$to->format('Y-m-d').'") AND';

        }
        $dateCondition .= '(t.is_deleted = 0) AND (visits.is_deleted = 0) AND (visitors.is_deleted = 0) AND (visits.card_type >= 5) AND (t.tenant = '.Yii::app()->user->id.')';
        $visitsCount = Yii::app()->db->createCommand()
            ->select('min(visits.id) as visitId,visits.date_check_in as date_check_in,t.id,t.name,count(visits.id) as visits, t.id as workstationId')
            ->from('workstation t')
            ->leftJoin('visitor visitors' , '(t.id = visitors.visitor_workstation)')
            ->leftJoin('visit visits' , '(visits.visitor = visitors.id)')
            ->where($dateCondition)
            ->group('t.id')
            ->queryAll();


        $allWorkstations = Yii::app()->db->createCommand()
            ->select( 't.id,t.tenant,t.name')
            ->from('workstation t')
            ->where('t.tenant = '. Yii::app()->user->id)
            ->queryAll();
        $otherWorkstations = array();
        foreach ($allWorkstations as $workstation) {
            $hasVisitor = false;
            foreach($visitsCount as $visit) {
                if($visit['workstationId'] ==  $workstation['id']) {
                    $hasVisitor =  true;
                }
            }
            if ($hasVisitor == false) {
                array_push($otherWorkstations, $workstation);
            }
        }

        $this->render('totalVicsByWorkstation', array("visit_count" => $visitsCount, "otherWorkstations" => $otherWorkstations));
    }

    public function actionImportVisitData()
    {
        set_time_limit(0);
        ini_set("memory_limit", "-1");

        $model = new ImportCsvForm;
        $session = new CHttpSession;

        if (isset($_POST['ImportCsvForm'])) {
            $model->attributes = $_POST['ImportCsvForm'];

            $file = CUploadedFile::getInstance($model, 'file_xls');

            if ($file) {
                $file->saveAs(dirname(Yii::app()->request->scriptFile) . '/uploads/' . $file->name);
                $file_path = realpath(Yii::app()->basePath . '/../uploads/' . $file->name);

                $objPHPExcel = new PHPExcel();
                $objPHPExcel = PHPExcel_IOFactory::load($file_path);

                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

                if (!empty($sheetData)) {
                    array_shift($sheetData);
                    foreach ($sheetData as $row) {
                        $email = preg_replace('/\s+/', '', $row['B'] . $row['C'] . '@gmail.com');

                        $visitor = Visitor::model()->findByAttributes(array('email' => $email));
                        if (!$visitor['email']) {
                            $reason = VisitReason::model()->findByAttributes(array('reason' => $row['E']));

                            // Add workstation
                            $worstation = Workstation::model()->findByAttributes(array('name' => $row['P']));
                            if (empty($worstation)) {
                                $worstationModel = new Workstation();
                                $worstationModel->name = $row['P'];
                                $worstationModel->created_by = Yii::app()->user->id;
                                $worstationModel->tenant = Yii::app()->user->tenant;
                                $worstationModel->save();
                                $worstationId = $worstationModel->id;
                            } else {
                                $worstationId = $worstation['id'];
                            }

                            // Add visitor
                            $visitorModel = new Visitor();
                            $visitorModel->first_name = $row['B'];
                            $visitorModel->last_name = $row['C'];
                            $visitorModel->date_of_birth = $row['D'];
                            $visitorModel->profile_type = 'VIC';
                            $visitorModel->visitor_workstation = $worstationId;
                            $visitorModel->tenant = $session['tenant'];
                            $visitorModel->role = Roles::ROLE_VISITOR;
                            if ($row['J'] == 'TRUE') {
                                $visitorModel->visitor_card_status = 3;
                            } else {
                                $visitorModel->visitor_card_status = 2;
                            }
                            $visitorModel->email = preg_replace('/\s+/', '', $row['B'] . $row['C'] . '@gmail.com');
                            $visitorModel->contact_number = '123456';
                            $visitorModel->identification_type = 'PASSPORT';
                            $visitorModel->identification_country_issued = 13;
                            $visitorModel->identification_document_no = 123;
                            $visitorModel->identification_document_expiry = '2016-06-22';
                            $visitorModel->company = 15;
                            $visitorModel->visitor_type = 2;
                            $visitorModel->contact_street_no = 123;
                            $visitorModel->contact_street_name = 'abc';
                            $visitorModel->contact_street_type = 'ALLY';
                            $visitorModel->contact_suburb = 11;
                            $visitorModel->contact_state = 'ACT';
                            $visitorModel->contact_postcode = 121;
                            $visitorModel->contact_country = 13;

                            $visitorModel->save();
                            if ($visitorModel->save()) {
                                $visitorId = $visitorModel->id;
                            }

                            // Add card generate
                            $cardGenerated = CardGenerated::model()->findByAttributes(array('card_number' => $row['A']));
                            if (empty($cardGenerated)) {
                                $cardModel = new CardGenerated();
                                $cardModel->card_number = $row['A'];
                                $cardModel->visitor_id = isset($visitorId) ? $visitorId : $visitor['id'];
                                $cardModel->card_status = 1;
                                $cardModel->created_by = Yii::app()->user->id;
                                $cardModel->tenant = Yii::app()->user->tenant;
                                if ($cardModel->save()) {
                                    $cardId = $cardModel->id;
                                }
                            } else {
                                $cardId = $cardGenerated->id;
                            }

                            // Add visit
                            $visitModel = new Visit();
                            $visitModel->card = $cardId;
                            $visitModel->visitor = isset($visitorId) ? $visitorId : $visitor['id'];
                            $visitModel->reason = isset($reason) ? $reason['id'] : 1;
                            $visitModel->date_check_in = $row['F'];
                            $visitModel->date_check_out = $row['H'];
                            $visitModel->host = Yii::app()->user->id;
                            $visitModel->created_by = Yii::app()->user->id;
                            $visitModel->workstation = $session['workstation'];
                            $visitModel->tenant = Yii::app()->user->tenant;
                            $visitModel->save();
                        }
                    }
                }
                Yii::app()->user->setFlash('success', 'Import Success');
            } else {
                Yii::app()->user->setFlash('error', 'Please select a xls/xlsx file');
            }
        }

        $this->render('importVisitData', array('model' => $model));
    }

}
