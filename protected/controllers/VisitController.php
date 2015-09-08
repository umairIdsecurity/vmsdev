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
                    'update', 'detail', 'admin', 'view', 'exportFile', 'evacuationReport', 'evacuationReportAjax', 'DeleteAllVisitWithSameVisitorId', 'closeVisit'),
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
        $visitService = new VisitServiceImpl;
        $session = new CHttpSession;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Visit'])) {
            $visitParams = Yii::app()->request->getPost('Visit');

            if (!isset($visitParams['date_check_in'])) {
                $visitParams['date_check_in'] = date('Y-m-d');
                $visitParams['time_check_in'] = date('h:i:s');
            }

            if (!isset($visitParams['reason']) || empty($visitParams['reason'])) {
                $visitParams['reason'] = NULL;
            }

            $model->attributes = $visitParams;

            // If datepicker is disabled then date check out is empty
            if (!isset($visitParams['date_check_out'])) {
                switch ($model->card_type) {
                    case CardType::VIC_CARD_EXTENDED: // VIC Extended
                        $model->date_check_out = date('Y-m-d', strtotime($model->date_check_in . ' + 28 day'));
                        break;
                    case CardType::VIC_CARD_SAMEDATE: // VIC Sameday
                    case CardType::VIC_CARD_MANUAL: // VIC Manual
                    case CardType::VIC_CARD_24HOURS: // VIC 24 hour
                        $model->date_check_out = date('Y-m-d', strtotime($model->date_check_in . ' + 1 day'));
                        break;
                }
            }

            // default workstation:
            if ((!isset($visitParams['workstation']) || empty($visitParams['workstation'])) && isset($session['workstation'])) {
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
                    //$model->visitor_type = VisitorType::CORPORATE_VISITOR;

                    /*$reason = VisitReason::model()->findAllReason();
                    if (count($reason) > 0) {
                        $model->reason = $reason[0]->id;
                    }*/

                }
            }

            //check $reasonId has exist until add new.
            if ($model->reason == 'Other' || !$model->reason){
                $newReason = new VisitReason();
                $newReason->setAttribute('reason',isset($visitParams['reason_note']) ? $visitParams['reason_note'] : 'Other');
                $newReason->created_by = Yii::app()->user->id;
                $newReason->tenant = Yii::app()->user->tenant;
                $newReason->module = "AVMS";
                if($newReason->save()){
                    $model->reason = $newReason->id;
                }
            }

            if ($visitService->save($model, $session['id'])) {
                if(isset($_POST['Visit']['sendMail']) && $_POST['Visit']['sendMail'] == 'true' ){
                    $visitor = Visitor::model()->findByPk($model->visitor);
                    $host = Visitor::model()->findByPk($model->host);

                    $this->renderPartial('_email_asic_verify', array('visitor' => $visitor, 'host' => $host));
                }
                $this->redirect(array('visit/detail', 'id' => $model->id, 'new_created' => true));
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
        $model          = $this->loadModel($id);
        
        $oldVisitorType = $model->visitor_type;
        $oldReason      = $model->reason;
        
        $visitService   = new VisitServiceImpl;
        $session        = new CHttpSession;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Visit'])) {

            $oldhost = $model->host;
            $visitParams = Yii::app()->request->getPost('Visit');
            $model->attributes = $visitParams;

			if ($model->visitor_type == null) {
                $model->visitor_type = $oldVisitorType;
            }
            if ($model->reason == null) {
                $model->reason = $oldReason;
            }

            if (isset($_POST['User']['photo']) && $model->host > 0) {
                User::model()->updateByPk($model->host, array('photo' => $_POST['User']['photo']));
            }
			
            if (strtotime($model->date_check_in) > strtotime(date('d-m-Y'))) {
                $visitStatus = VisitStatus::model()->findByAttributes(array('name' => 'Pre-registered'));
                if ($visitStatus) {
                    $model->visit_status = $visitStatus->id;
                }
            }

            if (isset($_POST['closeVisitForm']) && $model->visit_status == VisitStatus::CLOSED) {
                $model->card_lost_declaration_file = CUploadedFile::getInstance($model, 'card_lost_declaration_file');
                $model->finish_time = date('H:i:s');
            }

             

            if(isset($_POST['AddAsicEscort']) && isset($_POST['createEscort']) && $_POST['createEscort']=='true') {
                $asicEscort                      = new Visitor;
                $visitorService                  = new VisitorServiceImpl;
                $asicEscort->attributes          = Yii::app()->request->getPost('AddAsicEscort');

                $asicEscort->profile_type        = Visitor::PROFILE_TYPE_ASIC;
                $asicEscort->visitor_card_status = 6;
                $asicEscort->escort_flag         = 1;
                $asicEscort->date_created        = date("Y-m-d H:i:s");
                $asicEscort->tenant              = Yii::app()->user->tenant;

                if (empty($asicEscort->visitor_workstation)) {
                    $asicEscort->visitor_workstation = $session['workstation'];
                }
                if ($result = $visitorService->save($asicEscort, NULL, $session['id'])) {
                    $model->asic_escort = $asicEscort->id;
                } else {
                    Yii::app()->end();
                }
            }

            if(isset($_POST['selectedAsicEscort'])){
                $model->asic_escort = Yii::app()->request->getPost('selectedAsicEscort');
            }

            if ($visitService->save($model, $session['id'])) {
                if ($model->card_lost_declaration_file != null) {
                    $model->card_lost_declaration_file->saveAs(YiiBase::getPathOfAlias('webroot') . '/uploads/card_lost_declaration/'.$model->card_lost_declaration_file->name);
                }
                if($oldhost != $model->host){
                    if(isset($_POST['Visit']['sendMail']) && $_POST['Visit']['sendMail'] == 'true' ){
                        $visitor = Visitor::model()->findByPk($model->visitor);
                        $host = Visitor::model()->findByPk($model->host);
                        $this->renderPartial('_email_asic_verify',array('visitor'=>$visitor,'host'=>$host));
                    }
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
         
        //Check whether a login user/tenant allowed to view 
        CHelper::check_module_authorization("Admin");
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

    public function actionDetail($id, $new_created=NULL) {
        $session = new CHttpSession;
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
            if (isset($model->date_check_out) && strtotime($model->date_check_out) < strtotime(date("Y-m-d"))) {
                $model->visit_status = VisitStatus::EXPIRED;
                $model->save();
            }
        }

        /**
         * Define needed models
         */
        $visitorModel  = Visitor::model()->findByPk($model->visitor);
        $reasonModel   = VisitReason::model()->findByPk($model->reason);
        $patientModel  = Patient::model()->findByPk($model->patient);
        $cardTypeModel = CardType::model()->findByPk($model->card_type);
        $visitCount    = Visit::model()->getVisitCount($model->id);
        
        $newPatient    = new Patient;
        $newHost       = new User;

        //if ($model->visitor_type == VisitorType::PATIENT_VISITOR) {
        //    $host = 16;
        //} else {
        $host = $model->host;
        //}

        $hostModel = User::model()->findByPk($host);

        // Update visitor detail form ( left column on visitor detail page )
        if (isset($_POST['updateVisitorDetailForm']) && isset($_POST['Visitor'])) {
            $visitorModel->attributes = Yii::app()->request->getPost('Visitor');

            $visitorModel->password_requirement = PasswordRequirement::PASSWORD_IS_NOT_REQUIRED;

            if ($visitorModel->visitor_card_status == Visitor::VIC_ASIC_ISSUED) {
                $visitorModel->profile_type = Visitor::PROFILE_TYPE_ASIC;
            }

            $visitorModel->scenario = 'updateVic';
            if ($visitorModel->save()) {
                // If visitor card status is VIC ASIC Issued then add new card status convert
                if ($visitorModel->visitor_card_status == Visitor::VIC_ASIC_ISSUED) {
                    $logCardstatusConvert               = new CardstatusConvert;
                    $logCardstatusConvert->visitor_id   = $visitorModel->id;
                    $logCardstatusConvert->convert_time = date("Y-m-d");

                    // save Log 
                    if (!$logCardstatusConvert->save()) {
                        // Do something if save process failure
                    }
                }
            }
        }

        #update Visitor and Host form ( middle column on visitor detail page )
        if (isset($_POST['updateVisitorInfo'])) {

            // Change date formate from d-m-Y to Y-m-d
            if (!empty($this->date_of_birth)) 
                $this->date_of_birth =  date('Y-m-d', strtotime($this->date_of_birth));

            if (!empty($this->asic_expiry)) 
                $this->asic_expiry =  date('Y-m-d', strtotime($this->asic_expiry));

            if (!empty($this->identification_document_expiry)) 
                $this->identification_document_expiry =  date('Y-m-d', strtotime($this->identification_document_expiry));
            
            if (isset($_POST['ASIC'])) {
                $asicModel                       = Visitor::model()->findByPk($model->host);

                // Get visitor params
                $asicParams                      = Yii::app()->request->getPost('ASIC');
                $asicModel->attributes           = $asicParams;
                $asicModel->password_requirement = PasswordRequirement::PASSWORD_IS_NOT_REQUIRED;
                $asicModel->scenario             = 'updateVic';
                
                // Save asic profile
                if (!$asicModel->save()) {
                    // Do something if save process failure
                }
            }

            if (isset($_POST['Host'])) {
                // Get visitor params
                $hostParams                      = Yii::app()->request->getPost('Host');
                $hostModel->attributes           = $hostParams;
                $hostModel->password_requirement = PasswordRequirement::PASSWORD_IS_NOT_REQUIRED;
                $hostModel->scenario             = 'updateVic';

                // Save host profile
                if (!$hostModel->save()) {
                    // Do something if save process failure
                }
            }

            if (isset($_POST['Escort'])) {
                $escortParams = Yii::app()->request->getPost('Escort');
                $escortModel  = Visitor::model()->findByPk($escortParams['id']);

                $escortModel->attributes = $escortParams;
                $escortModel->scenario   = 'updateVic';
                // Save escort profile
                if (!$escortModel->save()) {
                    // Do something if save escort failure
                }
            }

            if (isset($_POST['Company'])) {
                $companyParams = Yii::app()->request->getPost('Company');
                // If visitor has company id then save / continue
                if (!empty($visitorModel->company)) {
                    $companyModel = Company::model()->findByPk($visitorModel->company);

                    if ($companyModel) {
                        $companyModel->attributes = $companyParams;
                        $companyModel->save();
                    }

                    // Update company contact process
                    $staffModel = User::model()->findByPk($visitorModel->staff_id);
                    if ($staffModel) {
                        if (isset($companyParams['mobile_number'])) 
                            $staffModel->contact_number = $companyParams['mobile_number'];
                        if (isset($companyParams['email_address'])) 
                            $staffModel->email          = $companyParams['email_address'];
                        if (isset($companyParams['contact'])) {
                            if (strpos($companyParams['contact'], ' ') !== false) {
                                $arrFullName = explode(' ', $companyParams['contact']);
                                $staffModel->first_name = $arrFullName[0];
                                $staffModel->last_name = $arrFullName[1];
                            } else {
                                // Todo: if operator enter company contact with wrong format
                            }
                        }
                        // Save staff member
                        if (!$staffModel->save()) {
                            // Do something if save staff failure
                        }
                    }
                }
            }

            $visitorModel->attributes           = Yii::app()->request->getPost('Visitor');
            $visitorModel->password_requirement = PasswordRequirement::PASSWORD_IS_NOT_REQUIRED;
            $visitorModel->setScenario('updateVic');

            // Save visitor
            if (!$visitorModel->save()) {
                // Do something if save visitor failure
            }
        }

        if (isset($_POST['Visit'])) {
            $visitParams = Yii::app()->request->getPost('Visit');
            if (empty($_POST['Visit']['finish_time'])) {
                $model->finish_time = date('H:i:s');
            }

            $model->attributes = $visitParams;
            // If operator select other reason then save new one
            if (isset($_POST['VisitReason'])) {
                $visitReasonModel             = new VisitReason;
                $visitReasonService           = new VisitReasonServiceImpl;
                $visitReasonParams            = Yii::app()->request->getPost('VisitReason');
                $visitReasonModel->attributes = $visitReasonParams;
                $newReasonID = $visitReasonService->save($visitReasonModel, $session['id']);
                if (!$newReasonID) {
                    $model->reason = NULL;
                }  else {
                    $model->reason = $newReasonID;
                }
            }
            
            // close visit process
            if (isset($_POST['closeVisitForm']) && $visitParams['visit_status'] == VisitStatus::CLOSED) {
                // Date  visit CLOSED by operator
                $model->visit_closed_date = date("Y-m-d");
                $model->closed_by = Yii::app()->user->id;
                if (in_array($model->card_type, [CardType::VIC_CARD_EXTENDED, CardType::VIC_CARD_24HOURS]) && strtotime(date('Y-m-d')) <= strtotime($model->date_check_out)) {
                    $model->visit_status = VisitStatus::AUTOCLOSED;

                    switch ($model->card_type) {
                        case CardType::VIC_CARD_EXTENDED: // VIC Extended
                            if ($visitParams['finish_date'] != NULL) {
                                $model->finish_date =  date('Y-m-d', strtotime($visitParams['finish_date']));
                            } else { 
                                $model->finish_date =  date('Y-m-d', strtotime($visitParams['date_check_out']));
                            }
                            break;
                        case CardType::VIC_CARD_MULTIDAY: // VIC Multiday
                            break;
                    }
                }

                $fileUpload = CUploadedFile::getInstance($model, 'card_lost_declaration_file');
                if ($fileUpload != null) {
                    $path = YiiBase::getPathOfAlias('webroot') . '/uploads/card_lost_declaration';
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $model->card_lost_declaration_file = '/uploads/card_lost_declaration/'.$fileUpload->name;
                }

            } 

            // save visit model
            if ($model->save()) {
                // if has file upload then upload and save
                if (!empty($fileUpload)) {
                    $fileUpload->saveAs(YiiBase::getPathOfAlias('webroot') . $model->card_lost_declaration_file);
                }
            } else {
               
                $model->visit_status = $oldStatus;
            }
        }

        // Get visit count and remaining days
        $visitCount['totalVisits'] = $model->visitCounts;
        $visitCount['remainingDays'] = $model->remainingDays;
        $this->render('visitordetail', array(
            'model'         => $model,
            'visitorModel'  => $visitorModel ? $visitorModel : new Visitor,
            'reasonModel'   => $reasonModel,
            'hostModel'     => $hostModel,
            'patientModel'  => $patientModel,
            'newPatient'    => $newPatient,
            'newHost'       => $newHost,
            'visitCount'    => $visitCount,
            'cardTypeModel' => $cardTypeModel,
            'new_created' => $new_created
        ));
    }

    public function actionCloseVisit($id) {
        $model = $this->loadModel($id);

        if ($model) {
            parse_str(Yii::app()->request->getPost('data'), $request);
            $model->attributes = $request['Visit'];
            
            $model->visit_status = VisitStatus::CLOSED;

            if (!$model->save()) {
                echo 0;
                Yii::app()->end();
            }
            echo 1;
            Yii::app()->end();
        } else {
            echo 0;
            Yii::app()->end();
        }
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
        $merge->addCondition("profile_type = '". Visitor::PROFILE_TYPE_CORPORATE ."'");

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
        $merge->addCondition("profile_type = '". Visitor::PROFILE_TYPE_VIC ."'");

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
        $merge->addCondition("visitor0.profile_type = '". Visitor::PROFILE_TYPE_VIC ."'");

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
        $merge->addCondition("visit_status =" . VisitStatus::ACTIVE . "");

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
        $merge->addCondition("visit_status =" . VisitStatus::CLOSED . "");

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

    public function actionDuplicateVisit($id, $type = '', $new_created = NULL) {
        if($new_created){
            $visitService          = new VisitServiceImpl;
            $session               = new CHttpSession;
            $model = $this->loadModel($id);
            $model->attributes = Yii::app()->request->getPost('Visit');
            $model->save();
            echo $model->id;
            Yii::app()->end();
        }
        $visitService          = new VisitServiceImpl;
        $session               = new CHttpSession;
        $model                 = $this->loadModel($id); // record that we want to duplicate
        $model->id             = null;
        $model->visit_status   = '';
        $model->date_in        = '';
        $model->time_in        = '';
        $model->time_out       = '';
        $model->date_out       = '';
        $model->date_check_in  = '';
        $model->time_check_in  = '';
        $model->time_check_out = '';
        $model->date_check_out = '';
        $model->card           = NULL;
        $model->isNewRecord    = true;

        // update data from $_POST
        $model->attributes     = Yii::app()->request->getPost('Visit');
        $model->card_option = "Returned";
        // set status to pre-registered
        if (strtotime($model->date_check_in) > strtotime(date('d-m-Y'))) {
            $model->visit_status = VisitStatus::PREREGISTERED;
        }

        // If type not null & is backdate
        if ($type == 'backdate') {
            $model->visit_status = VisitStatus::CLOSED;
        }

        //update date checkout in case card 24h
        if (!empty($model) && empty($model->date_check_out)) {
            switch ($model->card_type) {
                case CardType::VIC_CARD_SAMEDATE:
                    $model->date_check_out = date('Y-m-d');
                    $model->time_check_out = $model->time_check_in;
                    break;
                case CardType::VIC_CARD_24HOURS:
                case CardType::VIC_CARD_MANUAL:
                    $model->date_check_out = date('Y-m-d', strtotime($model->date_check_in . ' + 1 day'));
                    $model->time_check_out = $model->time_check_in;
                    break;
                case CardType::VIC_CARD_EXTENDED:
                case CardType::VIC_CARD_MULTIDAY:
                    $model->date_check_out = date('Y-m-d', strtotime($model->date_check_in . ' + 28 day'));
                    $model->time_check_out = $model->time_check_in;
                    break;
            }
        }

        if(isset($_POST['AddAsicEscort'])&& isset($_POST['createEscort']) && $_POST['createEscort']=='true') {
            $asicEscort                      = new Visitor;
            $visitorService                  = new VisitorServiceImpl;
            $asicEscort->attributes          = Yii::app()->request->getPost('AddAsicEscort');
            $asicEscort->profile_type        = Visitor::PROFILE_TYPE_ASIC;
            $asicEscort->visitor_card_status = 6;
            $asicEscort->escort_flag         = 1;
            $asicEscort->date_created        = date("Y-m-d H:i:s");
            $asicEscort->tenant              = Yii::app()->user->tenant;

            if (empty($asicEscort->visitor_workstation)) {
                $asicEscort->visitor_workstation = $session['workstation'];
            }

            if ($result = $visitorService->save($asicEscort, NULL, $session['id'])) {
                $model->asic_escort = $asicEscort->id;
            } else {
                Yii::app()->end();
            }
        }

        if(isset($_POST['selectedAsicEscort'])){
            $model->asic_escort = Yii::app()->request->getPost('selectedAsicEscort');
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
        $Criteria->condition = "visitor = " . $id . " and visit_status=" . VisitStatus::SAVED . "";
        $visit = Visit::model()->findAll($Criteria);
        $resultMessage['data'] = $visit;
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionGetVisitDetailsOfHost($id) {
        $user = User::model()->findAllByPk($id);
        $resultMessage['data'] = [];

        if (isset($user[0])) {
            $photo = Photo::model()->findAllByPk($user[0]->photo);
            $resultMessage['data'] = $user;
        }

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

    public function actionResetVisitCount()
    {
        $visitorModel = Visitor::model()->findByPk(Yii::app()->getRequest()->getQuery('id'));

        //if ($visitorModel->totalVisit > 0) {
        $activeVisit = $visitorModel->activeVisits;
        $resetErrorMessage = '';
        foreach ($activeVisit as $item) {
            if ($item->visit_status == VisitStatus::ACTIVE) {
                $resetErrorMessage = 'Please close the active visit before resetting visit count.';
            }
        }
        if ($resetErrorMessage == '') {
            $visitorModel->visitor_card_status = 3;
            $visitorModel->update();
            if ($visitorModel->update()) {
                $resetHistory = new ResetHistory();
                $resetHistory->visitor_id = Yii::app()->getRequest()->getQuery('id');
                $resetHistory->reset_time = date("Y-m-d H:i:s");
                $resetHistory->reason = Yii::app()->getRequest()->getQuery('reason');
                $resetHistory->lodgement_date = Yii::app()->getRequest()->getQuery('lodgementDate');
                $visitorModel->visitor_card_status = 3;
                $visitorModel->save();

                if ($resetHistory->save()) {
                    foreach ($activeVisit as $item) {
                        $item->reset_id = $resetHistory->id;
                        $item->save();
                    }

                }
            }
        } else {
            echo $resetErrorMessage;
        }
        //}
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
            'company0.contact' => 'Contact Person',
            'company0.name' => 'Company Name',
            'company0.email_address' => 'Contact Email',
            'company0.mobile_number' => 'Contact Phone',
            'finish_date' => 'Date of Issue',
            'card_returned_date' => 'Date of Return',
            'visitor0.identification_type' => 'Document Type',
            'visitor0.identification_document_no' => 'Number',
            'visitor0.identification_document_expiry' => 'Expiry',
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
        $merge->addCondition("visitor0.profile_type = '". Visitor::PROFILE_TYPE_VIC ."'");

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
            
            $dateCondition = "( visitors.date_created BETWEEN  '".$from->format("Y-m-d H:i:s")."' AND  '".$to->format("Y-m-d  H:i:s")."' ) AND ";
            
            //OTHER PERSON CODE FIXED---THE CODE SHOULD BE LIKE THAT AS JULIE WANTS TOTAL VICs VISITORS BY WORKSTATIONS OF CURRENT USER
            //COMMENETED CODE IS OF THAT PERSON CODE
//            $dateCondition = '(visits.date_check_in BETWEEN "'.$from->format('Y-m-d').'"'
//                . ' AND "'.$to->format('Y-m-d').'") OR (visits.date_check_in BETWEEN "'.$from->format('Y-m-d').'"'
//                . ' AND "'.$to->format('Y-m-d').'") AND';

        }
        
        $allWorkstations='';
        
        if(Roles::ROLE_SUPERADMIN != Yii::app()->user->role){

            $dateCondition .= "(visitors.created_by=".Yii::app()->user->id.") AND ";
            //show curren logged in user Workstations
            $allWorkstations = Workstation::model()->findAll("created_by = " . Yii::app()->user->id . " AND is_deleted = 0");
        }else{
            //show all work stations to SUPERADMIN
            $allWorkstations = Workstation::model()->findAll();
        }
        
        $dateCondition .= "(t.is_deleted = 0) AND (visitors.is_deleted = 0) AND (visitors.profile_type='VIC')";
        
        //$dateCondition .= '(t.is_deleted = 0) AND (visits.is_deleted = 0) AND (visitors.is_deleted = 0) AND (visits.card_type >= 5) AND (t.tenant = '.Yii::app()->user->tenant.')';
        
        //count(visitors.id) as visitors,DATE(visitors.date_created) AS date_check_in,t.id,t.name, t.id  as workstationId
        $visitsCount = Yii::app()->db->createCommand()
            ->select('count(visitors.id) as visitors, visitors.date_created AS date_check_in, t.id, t.name, t.id as workstationId')
            //->select('count(visitors.id) as visitors, convert(varchar(10), visitors.date_created, 120) AS date_check_in, t.id, t.name, t.id as workstationId')
            ->from('workstation t')
            ->join('visitor visitors' , 't.id = visitors.visitor_workstation')
            ->where($dateCondition)
            ->group('t.id, visitors.date_created, t.name')
            ->queryAll();
//        $allWorkstations = Yii::app()->db->createCommand()
//            ->select( 't.id,t.tenant,t.name')
//            ->from('workstation t')
//            ->where('t.tenant = '. Yii::app()->user->tenant)
//            ->queryAll();
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
                    $sheetData = array_filter(array_map('array_filter', $sheetData));

                    foreach ($sheetData as $row) {
                        $email = preg_replace('/[^A-Za-z0-9\-]/', '', $row['B']) . '@' . preg_replace('/[^A-Za-z0-9\-]/', '', $row['C']) . '.com';

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
                                if (!$worstationModel->save()) {
                                    $worstationId = $worstationModel->id;
                                }
                            } else {
                                $worstationId = $worstation['id'];
                            }

                            // Add visitor
                            $visitorModel = new Visitor();
                            $visitorModel->first_name = $row['B'];
                            $visitorModel->last_name = $row['C'];
                            $visitorModel->date_of_birth = date('Y-m-d', strtotime($row['D']));
                            $visitorModel->profile_type = 'VIC';
                            $visitorModel->visitor_workstation = isset($worstationId) ? $worstationId : '';
                            $visitorModel->tenant = $session['tenant'];
                            $visitorModel->role = Roles::ROLE_VISITOR;
                            if (isset($row['J']) && $row['J'] == 'TRUE') {
                                $visitorModel->visitor_card_status = 3;
                            } else {
                                $visitorModel->visitor_card_status = 2;
                            }
                            $visitorModel->email = $email;
                            $visitorModel->contact_number = 'dummy';
                            $visitorModel->identification_type = 'PASSPORT';
                            $visitorModel->identification_country_issued = 13;
                            $visitorModel->identification_document_no = 'dummy';
                            $visitorModel->identification_document_expiry = date("Y-m-d");
                            $visitorModel->company = 15;
                            //$visitorModel->visitor_type = 2;
                            $visitorModel->contact_street_no = 'dummy';
                            $visitorModel->contact_street_name = 'dummy';
                            $visitorModel->contact_street_type = 'ALLY';
                            $visitorModel->contact_suburb = 'dummy';
                            $visitorModel->contact_state = 'ACT';
                            $visitorModel->contact_postcode = 'dummy';
                            $visitorModel->contact_country = 13;

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
                            $visitModel->card = isset($cardId) ? $cardId : '';
                            $visitModel->visitor = isset($visitorId) ? $visitorId : $visitor['id'];
                            $visitModel->reason = isset($reason) ? $reason['id'] : NULL;
                            $visitModel->date_check_in = $row['F'];
                            $visitModel->date_check_out = $row['H'];
                            $visitModel->host = Yii::app()->user->id;
                            $visitModel->created_by = Yii::app()->user->id;
                            $visitModel->workstation = $session['workstation'];
                            $visitModel->tenant = Yii::app()->user->tenant;
                            //$visitModel->visitor_type = 2;
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
