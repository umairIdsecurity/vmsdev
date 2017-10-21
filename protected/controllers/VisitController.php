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
                    'update', 'detail', 'admin', 'view', 'exportFile','evacuationReport', 'evacuationReportAjax', 'exportVicRegister','DeleteAllVisitWithSameVisitorId', 'closeVisit', 'visitResetById'),
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
                    'exportVisitorRecords', 'delete','resetVisitCount', 'negate','exportFileVicTotalCount','exportFileVicWorkstation',
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

            // other side of nasty hack to transfer visitor id to this controller
            if((!isset($model->visitor) || $model->visitor == "")  && isset($_SESSION['id_of_last_visitor_created'])) {
                $model->visitor = $_SESSION['id_of_last_visitor_created'];
            }

            // If datepicker is disabled then date check out is empty
            if (!isset($visitParams['date_check_out'])) {
                switch ($model->card_type) {
                    case CardType::VIC_CARD_EXTENDED: // VIC Extended
                        $model->date_check_out = date('Y-m-d', strtotime($model->date_check_in . ' + 28 day'));
                        break;
                    case CardType::VIC_CARD_SAMEDATE: // VIC Sameday
					case CardType::TEMPORARY_ASIC: // Temporary asic
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
                /*$newReason = new VisitReason();
                $newReason->setAttribute('reason',isset($visitParams['reason_note']) ? $visitParams['reason_note'] : 'Other');
                $newReason->created_by = Yii::app()->user->id;
                $newReason->tenant = Yii::app()->user->tenant;
                if ($model->card_type > CardType::CONTRACTOR_VISITOR)
                    $newReason->module = "AVMS";
                else
                    $newReason->module = "CVMS";
                if($newReason->save()){
                    $model->reason = $newReason->id;
                }*/
                if(isset($visitParams['reason_note'])){
                    $model->visit_reason = $visitParams['reason_note'];
                    $model->reason = NULL;
                }
            }
            $model->reset_id = NULL;

            if ($visitService->save($model, $session['id'])) {
                 if((isset($_POST['Visit']['sendMail']) && $_POST['Visit']['sendMail'] == '1') || isset($_POST["requestVerifyAsicSponsor"]) ){
                    
                    $visitor = Visitor::model()->findByPk($model->visitor);
                    $host = Visitor::model()->findByPk($model->host);
                   
                    $this->renderPartial('_email_asic_verify', array('visitor' => $visitor, 'host' => $host));
                }

                //logs the INSERT NEW VISIT
                $this->audit_logging_visit_statuses("INSERT NEW VISIT",$model);
                /**
                * If operator Selects VIC as Asic Sponsor then Convert VIC to ASIC
                */
                $this->convertVicToAsicSponsor($model->host); 
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

        // save asic no when activate visit
        if (isset($_POST['asic_sponsor_id'])) {
            $asic_sponsor = Visitor::model()->findByPk($_POST['asic_sponsor_id']);
            $asic_sponsor->asic_no = $_POST['asic_no'];
            $asic_sponsor->asic_expiry = date('Y-m-d', strtotime($_POST['asic_expiry']));
            $asic_sponsor->setScenario('updateVic');
            $asic_sponsor->save();
        }

        if (isset($_POST['Visit'])) 
        {
			
            $oldhost = $model->host;
            $visitParams = Yii::app()->request->getPost('Visit');
            $model->attributes = $visitParams;
			if($model->card_type==CardType::VIC_CARD_SAMEDATE || $model->card_type==CardType::TEMPORARY_ASIC) //change 12/10/2017
			{
				$model->date_check_out=$model->date_check_in;
				$model->finish_date=null;
				$model->finish_time=null;
				//$model->card_returned_date=null;
				//$model->card_option='Not Returned';
				//$model->visit_status='1';
				//$model->time_check_out='23:59:59.0000000';
			}
			//echo '<pre>';
			//print_r($visitParams);
			//echo '</pre>';
			//Yii:: app()->end();
			
            if ($model->visitor_type == null) {
                $model->visitor_type = $oldVisitorType;
            }
            if ($model->reason == null) {
                $model->reason = $oldReason;
            }
			if(isset($_POST['reason']))
			{
				$model->reason=$_POST['reason'];
			}
			if(isset($_POST['asic_expiry']) && isset($_POST['asic_no']))
			{
				$asic=Visitor::model()->findByPk($_POST['asic_sponsor_id']);
				$asic->asic_expiry=$_POST['asic_expiry'];
				$asic->asic_no=$_POST['asic_no'];
				$asic->visitor_card_status='6';
				$asic->save(false);
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
            if($visitParams['visit_status']!=null)
			{
				$model->visit_status=$visitParams['visit_status'];
			}
            if ($visitService->save($model, $session['id'])) {
				//echo '<pre>';
				//print_r($visitParams['visit_status']);
				//echo '</pre>';
				//Yii:: app()->end();
                if ($model->card_lost_declaration_file != null) {
                    $model->card_lost_declaration_file->saveAs(YiiBase::getPathOfAlias('webroot') . '/uploads/card_lost_declaration/'.$model->card_lost_declaration_file->name);
                }
                if($oldhost != $model->host){
                     if((isset($_POST['Visit']['sendMail']) && $_POST['Visit']['sendMail'] == '1') || isset($_POST["requestVerifyAsicSponsor"]) ){
                        $visitor = Visitor::model()->findByPk($model->visitor);
                        $host = Visitor::model()->findByPk($model->host);
                        $this->renderPartial('_email_asic_verify',array('visitor'=>$visitor,'host'=>$host));
                    }
               }
               /**
                * If operator Selects VIC as Asic Sponsor then Convert VIC to ASIC
                */
                $this->convertVicToAsicSponsor($model->host);    
                $this->redirect(array('visit/detail', 'id' => $id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }
    /**
     * If operator Selects VIC as Asic Sponsor then Convert VIC to ASIC
     * @param model $host The person that selected as Asic Sponsor
     */
    public function convertVicToAsicSponsor($host) {
        //check if the $host is VIC 
        $visitor = Visitor::model()->findByPk($host);
        if( isset($visitor) && $visitor->profile_type == visitor::PROFILE_TYPE_VIC) {
            Visitor::model()->updateByPk($host, array("profile_type"=>Visitor::PROFILE_TYPE_ASIC, "visitor_card_status"=>  Visitor::ASIC_ISSUED));
        }
        return;
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
        // set Close visit that are Auto Closed and will expire today.
        Visit::model()->setClosedAutoClosedVisits($id);  
        $session = new CHttpSession;
		//echo $session['workstation'];
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
      // echo '<pre>';
	  // print_r($visitCount);
	  // echo '</pre>';
	  //Yii:: app()->end();
        $newPatient    = new Patient;
        $newHost       = new User;

        //if ($model->visitor_type == VisitorType::PATIENT_VISITOR) {
        //    $host = 16;
        //} else {
        $host = $model->host;
        //}

        $hostModel = User::model()->findByPk($host);
        $errorMsg="";


        // Update visitor detail form (left column on visitor detail page )
        //this chunk of deals with: update card type, workstation, reason and visitor type as well
        if(isset($_POST['updateVisitorDetailForm']) && isset($_POST['Visit'])) 
        {
		   
            if((isset($model->visit_status)) && ($model->visit_status != "") && ($model->visit_status == VisitStatus::ACTIVE))
            {
				
                $errorMsg="Card type can not be updated whilst visit is active.";
                //card type cannot be updated for Active Visit whereas other fields on left column can be updated
                if (isset($_POST['Visitor']['visitor_card_status']) && $_POST['Visitor']['visitor_card_status'] != "") {$visitorModel->visitor_card_status = $_POST['Visitor']['visitor_card_status'];}
					
                if (isset($_POST['Visit']['workstation']) && $_POST['Visit']['workstation'] != "") {$model->workstation = $_POST['Visit']['workstation'];}
                if (isset($_POST['Visit']['reason']) && $_POST['Visit']['reason'] != "") {
					
					$model->reason = $_POST['Visit']['reason'];
					
					}
                if (isset($_POST['Visit']['visitor_type']) && $_POST['Visit']['visitor_type'] != "") {$model->visitor_type = $_POST['Visit']['visitor_type'];}
                if(!isset($model->visit_status) || $model->visit_status == ""){$model->visit_status = $oldStatus;}
                
                if ((isset($_POST['Visit']['workstation']) && $_POST['Visit']['workstation'] != "") || (isset($_POST['Visit']['reason']) && $_POST['Visit']['reason'] != "") || (isset($_POST['Visit']['visitor_type']) && $_POST['Visit']['visitor_type'] != ""))
                {
                    $model->save();
                } 

                if (isset($_POST['Visitor']['visitor_card_status']) && $_POST['Visitor']['visitor_card_status'] != "") 
                {
                    $visitorModel->save(false);
                }    

            }
            else
            {
                if (isset($_POST['Visitor']['visitor_card_status']) && $_POST['Visitor']['visitor_card_status'] != "") {$visitorModel->visitor_card_status = $_POST['Visitor']['visitor_card_status'];}
            
                if (isset($_POST['Visit']['card_type']) && $_POST['Visit']['card_type'] != "") {$model->card_type = $_POST['Visit']['card_type'];}
                if (isset($_POST['Visit']['workstation']) && $_POST['Visit']['workstation'] != "") {$model->workstation = $_POST['Visit']['workstation'];}
                if (isset($_POST['Visit']['reason']) && $_POST['Visit']['reason'] != ""){
					if($_POST['Visit']['reason'] == "Other"){
						//echo "<pre>";
						//print_r($_POST);
						//echo "</pre>";
						//Yii::app()->end();
						$model->reason = NULL;
						}
						else{
							
							$model->reason =$_POST['Visit']['reason'] ;
						
							}
							}
                if (isset($_POST['Visit']['visitor_type']) && $_POST['Visit']['visitor_type'] != "") {$model->visitor_type = $_POST['Visit']['visitor_type'];}
                if(!isset($model->visit_status) || $model->visit_status == ""){$model->visit_status = $oldStatus;}
                
                if ((isset($_POST['Visit']['card_type']) && $_POST['Visit']['card_type'] != "") || (isset($_POST['Visit']['workstation']) && $_POST['Visit']['workstation'] != "") || (isset($_POST['Visit']['reason']) && $_POST['Visit']['reason'] != "") || (isset($_POST['Visit']['visitor_type']) && $_POST['Visit']['visitor_type'] != ""))
                {	
                    $model->save();
					
                } 

                if (isset($_POST['Visitor']['visitor_card_status']) && $_POST['Visitor']['visitor_card_status'] != "") 
                {
                    $visitorModel->save(false);
                }
            }
        }

        //this chunk of code deals with visitor card status on the left column on visit detail page
        if (isset($_POST['updateVisitorDetailForm']) && isset($_POST['Visitor'])) 
        {
			
			
            $visitorModel->attributes = Yii::app()->request->getPost('Visitor');
			
            $visitorModel->password_requirement = PasswordRequirement::PASSWORD_IS_NOT_REQUIRED;
            if ($visitorModel->visitor_card_status == Visitor::VIC_ASIC_ISSUED) {
                $visitorModel->profile_type = Visitor::PROFILE_TYPE_ASIC;
            }
			
			if(isset($_POST['ASIC'])&& $_POST['ASIC']['asic_exp']!=$_POST['ASIC']['asic_expiry'])
			{
				//echo '<pre>';
				//print_r($_POST);
				//echo '</pre>';
				//Yii:: app()->end();
				$ifCheck=0;
				$asic = $model->getAsicSponsor();
				if($asic->asic_no!=$_POST['ASIC']['asic_no'])
				{
					$asic->asic_no=$_POST['ASIC']['asic_no'];
					$ifCheck=1;
				}
				if($asic->asic_expiry!=date("Y-m-d", strtotime(str_replace('/', '-',$_POST['ASIC']['asic_expiry']))))
				{
					$asic->asic_expiry=date("Y-m-d", strtotime(str_replace('/', '-',$_POST['ASIC']['asic_expiry'])));
					$ifCheck=1;
				}
				if($ifCheck==1)
				{
					$asic->visitor_card_status=Visitor::ASIC_ISSUED;
					$asic->profile_type='ASIC';
					$asic->save(false);
				}
				
				
			//echo "<pre>";
			//print_r($asic);
			//echo "</pre>";
			//Yii::app()->end();
			}
				
				if(isset($_POST['ASIC']))
				{
				if($_POST['ASIC']['date_of_birth']!=null && isset($_POST['ASIC']['date_of_birth']))
				{
					$asic = $model->getAsicSponsor();
					$asic->date_of_birth=$_POST['ASIC']['date_of_birth'];
					$asic->visitor_card_status=Visitor::ASIC_ISSUED;
					$asic->profile_type='ASIC';
					$asic->save(false);
				}
				}
            /**
             * If Visit status = Auto Closed and Operator Manually Set cardStatus to ASIC PENDING 
             * Then Imemdialty Closed this visit
             */
            $this->closedAsicPending($model, $visitorModel);
            if($visitorModel->profile_type=='ASIC')
			{
				$visitorModel->scenario = 'updateAsic';
			}
			else
			$visitorModel->scenario = 'updateVic';
			//$visitorModel->save();
			/* echo "<pre>";
			 print_r($visitorModel);
			 echo "</pre>";
			Yii::app()->end();*/
            if ($visitorModel->save()) 
            {
                // If visitor card status is VIC ASIC Issued then add new card status convert
                if ($visitorModel->visitor_card_status == Visitor::VIC_ASIC_ISSUED) 
                {
                    $logCardstatusConvert               = new CardstatusConvert;
                    $logCardstatusConvert->visitor_id   = $visitorModel->id;
                    $logCardstatusConvert->convert_time = date("Y-m-d");

                    // save Log 
                    if (!$logCardstatusConvert->save()) {
                        // Do something if save process failure
                    }
                }
            }
            $this->redirect(array("visit/detail&id=".$id));
        }


        #update Visitor and Host form ( middle column on visitor detail page )
        if (isset($_POST['updateVisitorInfo'])) 
        {
			
            // Change date formate from d-m-Y to Y-m-d
            if (!empty($this->date_of_birth)) 
                $this->date_of_birth =  date('Y-m-d', strtotime($this->date_of_birth));

            if (!empty($this->asic_expiry)) 
                $this->asic_expiry =  date('Y-m-d', strtotime($this->asic_expiry));

            if (!empty($this->identification_document_expiry)) 
                $this->identification_document_expiry =  date('Y-m-d', strtotime($this->identification_document_expiry));
            
            if (isset($_POST['Host']) && isset($hostModel)) 
            {
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

            if (isset($_POST['Company'])) 
            {

                $companyParams = Yii::app()->request->getPost('Company');
                // If visitor has company id then save / continue
                if (!empty($visitorModel->company)) 
                {
                    $companyModel = Company::model()->findByPk($visitorModel->company);
                    //because of https://ids-jira.atlassian.net/browse/CAVMS-1223
                    if ($companyModel)
                    {
                        $companyModel->name = $companyParams['name'];
                        $companyModel->contact = $companyParams['contact'];
                        $companyModel->email_address = $companyParams['email_address'];
                        $companyModel->mobile_number = $companyParams['mobile_number'];
                        $companyModel->save(false);
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

            if (isset($_POST['ASIC'])) 
            {
                $asicModel                       = Visitor::model()->findByPk($model->host);
                // Get visitor params
                $asicParams                      = Yii::app()->request->getPost('ASIC');
                $asicModel->attributes           = $asicParams;
                $asicModel->password_requirement = PasswordRequirement::PASSWORD_IS_NOT_REQUIRED;
                $asicModel->scenario             = 'updateAsic';
                // Save asic profile
                if (!$asicModel->save()) {
                    // Do something if save escort failure
                    echo "<pre>";
                    $msg = print_r($asicModel->getErrors(),1);
                    throw new CHttpException(400,'Asic Sponsor error: '.$msg);
                }
            }

        }

        if (isset($_POST['Visit']) && !isset($_POST['updateVisitorDetailForm'])) 
        {
			
			
            $visitParams = Yii::app()->request->getPost('Visit');
            $model->attributes = $visitParams;

            if (empty($_POST['Visit']['finish_time'])) {
                $model->finish_time = date('H:i:s');
            }

            if (isset($_POST['Visit']['visit_reason']) && ($_POST['Visit']['visit_reason'] != "")) {
                $model->visit_reason = $_POST['Visit']['visit_reason'];
            }

            // If operator select other reason then save new one
            if (isset($_POST['VisitReason'])) {
				$oldReason=$model->reason;
                $visitReasonModel             = new VisitReason;
                $visitReasonService           = new VisitReasonServiceImpl;
                $visitReasonParams            = Yii::app()->request->getPost('VisitReason');
                $visitReasonModel->attributes = $visitReasonParams;
                $newReasonID = $visitReasonService->save($visitReasonModel, $session['id']);
                if (!$newReasonID) {
                    $model->reason = $oldReason;
                }  else {
                    $model->reason = $newReasonID;
                }
            }else{
                //$model->reason = (isset($_POST['Visit']['reason']) && ($_POST['Visit']['reason'] != "")) ? $_POST['Visit']['reason'] : NULL;
            }
            // close visit process
            if (isset($_POST['closeVisitForm']) && $visitParams['visit_status'] == VisitStatus::CLOSED) {
                // Date  visit CLOSED by operator
				//echo "umair";
				//Yii:: app()->end();
                $model->visit_closed_date = date("Y-m-d");
                $model->closed_by = Yii::app()->user->id;
                $model->visit_status = VisitStatus::CLOSED;
               
                if (in_array($model->card_type, [CardType::VIC_CARD_EXTENDED]) && strtotime(date('Y-m-d')) <= strtotime($model->date_check_out)) {
                    $model->visit_status = VisitStatus::AUTOCLOSED;
                    // If Visitor card status is Asic Pending then CLose the visit otherwise AutoClose
                    if( $model->card_type == CardType::VIC_CARD_EXTENDED && $visitorModel->visitor_card_status == Visitor::VIC_ASIC_PENDING)
                         $model->visit_status = VisitStatus::CLOSED;
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
            if ($model->save())
            {
                ////logs the visit which has been CLOSED
                if($model->visit_status == VisitStatus::CLOSED){$this->audit_logging_visit_statuses("CLOSE VISIT",$model);}
                
                // if has file upload then upload and save
                if (!empty($fileUpload)) {
                    $fileUpload->saveAs(YiiBase::getPathOfAlias('webroot') . $model->card_lost_declaration_file);
                }
            } else {
         
              $model->visit_status = $oldStatus;
				
            }
        }
		
        //introduced because of https://ids-jira.atlassian.net/browse/CAVMS-1241, 1242 and 1243
        $totalVisit = 0;
        $remainingDays = 0;
        $closedVisits = Visit::model()->findAllByAttributes([
            'visitor' => $model->visitor,
            'reset_id'      => null,
            'negate_reason' => null,
            'is_deleted' => 0,
            'visit_status' => VisitStatus::CLOSED
        ]);
	 foreach($closedVisits as $visit) {
            $totalVisit += $visit->visitCounts;
        } 

        if($totalVisit > 28 ) {
            $totalVisit = 28;
        } 
        $remainingDays = 28 - $totalVisit;
 
        // Get visit count and remaining days
       // $visitCount['totalVisits'] = $model->visitCounts;
        //$visitCount['remainingDays'] = $model->remainingDays;

       $visitCount['totalVisits'] = $totalVisit;
        $visitCount['remainingDays'] = $remainingDays;
	

        $model->beforeShowDetail($visitCount);
		

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
            'new_created' => $new_created,
            'errorMsg' => $errorMsg
        ));
    }

    //log the closing of visit
    public function audit_logging_visit_statuses($action,$visit){
        $log = new AuditLog();
        $log->action_datetime_new = date('Y-m-d H:i:s');
        $log->action = $action;
        $log->detail = 'Logged user ID: ' . Yii::app()->user->id." Visit ID: ".$visit->id." Visitor ID: ".$visit->visitor;
        $log->user_email_address = Yii::app()->user->email;
        $log->ip_address = (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != "") ? $_SERVER['REMOTE_ADDR'] : "UNKNOWN";
        $log->tenant = Yii::app()->user->tenant;
        $log->tenant_agent = Yii::app()->user->tenant_agent;
        $log->save();
    }

    /**
      * If Visit status = Auto Closed and Operator Manually Set cardStatus to ASIC PENDING 
      * Then Imemdialty Closed this visit
      * @param object $visitModel Visit model of an visit
      * @param Object $visittorModel visitor record model
      * 
      */
     public function closedAsicPending($visitModel, $visitorModel) {
            if( $visitModel->visit_status = VisitStatus::AUTOCLOSED && 
                    $visitModel->card_type == CardType::VIC_CARD_EXTENDED &&
                        $visitorModel->visitor_card_status ==  Visitor::VIC_ASIC_PENDING )   {
                
                // Close Visit on manual Update
                $update = array();
                $update["visit_status"] = VisitStatus::CLOSED;
                $update["visit_closed_date"] = date("Y-m-d H:i:s");
                // Reset for the first time only
                if( is_null( $visitModel->parent_id ) )
                   $update["reset_id"] = 1;
                Visit::model()->updateByPk($visitModel->id, $update);
            }
            return;
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
        // Auto Closed TO Closed the EVIC and 24 Hour Visits
        Visit::model()->setClosedAutoClosedVisits();
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

    public function actionVicTotalVisitCount() 
    {
        $merge = new CDbCriteria;
        $merge->addCondition("profile_type = '". Visitor::PROFILE_TYPE_VIC ."' OR profile_type = '". Visitor::PROFILE_TYPE_ASIC ."' "); //12/10/2017

        $model = new Visitor('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visitor'])) {
            $model->attributes = $_GET['Visitor'];
        }
		 if (Yii::app()->request->getParam('export')) {
            $this->actionExportVicVisitCount();
            Yii::app()->end();
        }
		//echo "<pre>";
		//var_dump($model->attributes);
		//echo "</pre>";
		//Yii::app()->end();
        $this->render('vicTotalVisitCount', array(
            'model' => $model, 'merge' => $merge, false, true
        ));
    }
	 public function actionExportFileVicTotalCount()
    {
        Yii::app()->request->sendFile('VisitCount_' . date('dmYHis') . '.csv', Yii::app()->user->getState('export'));
        Yii::app()->user->clearState('export');
    }
	    public function actionExportVicVisitCount() {
        $fp = fopen('php://temp', 'w');

        /*
         * Write a header of csv file
         */
        $headers = array(
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'company0.name' => 'Company Name',
			'totalVisit'=>'Total Visits',
            
        );
        $row = array();
        foreach ($headers as $header) {
            $row[] = Visitor::model()->getAttributeLabel($header);
        }
        fputcsv($fp, $row);
        /*
         * Init dataProvider for first page
         */
        $merge = new CDbCriteria;
        $merge->addCondition("profile_type = '". Visitor::PROFILE_TYPE_VIC ."'");
		//$merge->addCondition("company0.code = '".Yii::app()->user->tenant."'");
		

        $model = new Visitor('search');
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
				
				if($title=='Total Visits')
				{
				if((CHtml::value($model, $head))==null)
				{
					$row[] = '0';
				}
				else
				{
					$row[] = CHtml::value($model, $head);
				}
				}
				else
				{
				$row[] = CHtml::value($model, $head);
				}
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
    public function actionVicRegister() 
    {
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
            //'visitor0.position',  
			'reason0.reason',
            'card0.card_number',
            'card0.date_printed',
            'card0.date_expiration',  
            'visitor0.contact_number',
            
        );
        $row = array();
        foreach ($headers as $header) {
            $row[] = Visit::model()->getAttributeLabel($header);
        }
			//echo "<pre>";
			//var_dump($row);
			//echo "</pre>";
			//Yii::app()->end();
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
				$model['time_check_in']=date("g:i a", strtotime($model['time_check_in']));
				$model['time_check_out']=date("g:i a", strtotime($model['time_check_out']));
                $row[] = CHtml::value($model, $head);
            }
            fputcsv($fp, $row);
		  // echo "<pre>";
			//print_r($model['time_check_out']);
			//echo "</pre>";
			
		   
        }
	//Yii::app()->end();
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
        $model->date_check_in  = date('d/m/Y');
        $model->time_check_in  = date('h:iA');
        $model->time_check_out = '';
        $model->date_check_out = '';
        $model->card           = NULL;
        $model->isNewRecord    = true;

        // update data from $_POST
        $model->attributes     = Yii::app()->request->getPost('Visit');
        $model->card_option = "Returned";
        // set status to pre-registered
        //if (strtotime($model->date_check_in) > strtotime(date('d-m-Y'))) {
            $model->visit_status = VisitStatus::PREREGISTERED;
        //}

        // If type not null & is backdate
        if ($type == 'backdate') {
            $model->visit_status = VisitStatus::CLOSED;
        }
        
        $model->reset_id = NULL;
        $model->visit_closed_date = NULL;
        // Parent ID if a EVIC visit is auto Closed
        if ($model->card_type == CardType::VIC_CARD_EXTENDED )
           $model->parent_id = $id; 
            
        //update date checkout in case card 24h
        if (!empty($model) && empty($model->date_check_out)) {
            switch ($model->card_type) {
                 case CardType::VIC_CARD_SAMEDATE:
                case CardType::TEMPORARY_ASIC: //12/10/2017
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
                break;
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
                $resetHistory->lodgement_date = date('Y-m-d',strtotime(Yii::app()->getRequest()->getQuery('lodgementDate')));
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
            'company1.code' => 'Airport Code',
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
            'date_check_in' => 'Date of Issue',
            'date_check_out' => 'Date of Return',
            'visitor0.identification_type' => 'Document Type',
            'visitor0.identification_document_no' => 'Number',
            'visitor0.identification_document_expiry' => 'Expiry',
            'visitor1.asic_no' => 'ASIC ID Number',
            'visitor1.asic_expiry' => 'ASIC Expiry',
            'workstation0.name' => 'Workstation',
			'user0.email'=>'Issuer Email'
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
		//$merge->addCondition("company0.code = '".Yii::app()->user->tenant."'");
		

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
				if($head=='company0.contact' && $model->visitor0->staff_id!='' && $model->visitor0->staff_id!=null)
				{
				$contact=User::model()->findByPk($model->visitor0->staff_id);
				$fullname=$contact->first_name.' '.$contact->last_name;
				$model->company0->contact=$fullname;
				$model->company0->email_address=$contact->email;
				$model->company0->mobile_number=$contact->contact_number;
				}
				if($head=='reason0.reason'  && $model->reason==null && $model->visit_reason!=null)
				{
					$reason=new VisitReason();
					$exist=$reason->exists("( reason = '{$model->visit_reason}' AND tenant='{$model->tenant}')");
					if($exist)
					{
						
						$model->reason=$reason->find("( reason = '{$model->visit_reason}' AND tenant='{$model->tenant}')")->id;
						$model->save(false);
					}
					else
					{
						$reason->reason=$model->visit_reason;
						$reason->tenant=$model->tenant;
						$reason->created_by=$model->created_by;
						$reason->is_deleted=0;
						$reason->module='AVMS';
						$reason->save(false);
						$model->reason=$reason->id;
						$model->save(false);
						//Yii::app()->end();
					}
					
				}
                $row[] = CHtml::value($model, $head);
            }
            fputcsv($fp, $row);
        }
				//print_r($row);
				//Yii::app()->end();
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
            
            $dateCondition = "( v.date_created BETWEEN  '".$from->format("Y-m-d H:i:s")."' AND  '".$to->format("Y-m-d  H:i:s")."' ) AND ";
            
            //OTHER PERSON CODE FIXED---THE CODE SHOULD BE LIKE THAT AS JULIE WANTS TOTAL VICs VISITORS BY WORKSTATIONS OF CURRENT USER
            //COMMENETED CODE IS OF THAT PERSON CODE
//            $dateCondition = '(visits.date_check_in BETWEEN "'.$from->format('Y-m-d').'"'
//                . ' AND "'.$to->format('Y-m-d').'") OR (visits.date_check_in BETWEEN "'.$from->format('Y-m-d').'"'
//                . ' AND "'.$to->format('Y-m-d').'") AND';

        }
        
        $allWorkstations='';
        
        if(Roles::ROLE_SUPERADMIN != Yii::app()->user->role){

            $dateCondition .="(visitors.tenant=".Yii::app()->user->tenant.") AND ";
            //show curren logged in user Workstations
            $allWorkstations = Workstation::model()->findAll("tenant = " . Yii::app()->user->tenant . " AND is_deleted = 0");
        }else{
            //show all work stations to SUPERADMIN
            $allWorkstations = Workstation::model()->findAll();
        }
        
        $dateCondition .= "(t.is_deleted = 0) AND (v.is_deleted = 0) AND (v.profile_type='VIC')";
        
        //$dateCondition .= '(t.is_deleted = 0) AND (visits.is_deleted = 0) AND (visitors.is_deleted = 0) AND (visits.card_type >= 5) AND (t.tenant = '.Yii::app()->user->tenant.')';
        //$wherecondition=$dateCondition.$allWorkstations;
        //count(visitors.id) as visitors,DATE(visitors.date_created) AS date_check_in,t.id,t.name, t.id  as workstationId
        $visitsCount = Yii::app()->db->createCommand()
            ->select('count(visitors.id) as visitors, t.id, t.name, t.id as workstationId')
            //->select('count(visitors.id) as visitors, convert(varchar(10), visitors.date_created, 120) AS date_check_in, t.id, t.name, t.id as workstationId')
            ->from('workstation t')
            ->join('visit visitors' , 't.id = visitors.workstation AND (visitors.is_deleted = 0 AND visitors.tenant ='.Yii::app()->user->tenant .')')
			->join('visitor v' , 'v.id = visitors.visitor AND (visitors.is_deleted = 0 AND visitors.tenant ='.Yii::app()->user->tenant .')')
            ->where($dateCondition)
            ->group('t.id, t.name')
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
		 if (Yii::app()->request->getParam('export')) {
            $this->actionExportVicWorkstations();
            Yii::app()->end();
        }

        $this->render('totalVicsByWorkstation', array("visit_count" => $visitsCount, "otherWorkstations" => $otherWorkstations));
    }
	 public function actionExportFileVicWorkstation()
    {
        Yii::app()->request->sendFile('WorkstationsVIC_' . date('dmYHis') . '.csv', Yii::app()->user->getState('export'));
        Yii::app()->user->clearState('export');
    }
	  public function actionExportVicWorkstations() {
        $fp = fopen('php://temp', 'w');

        /*
         * Write a header of csv file
         */
        $headers = array(
           'Workstation Name'=>'Workstations',
			'Total Vics'=>'Vics Total Count',
            
        );
        $row = array();
        foreach ($headers as $header) {
            $row[] = $header;
        }
        fputcsv($fp, $row);
		
		 $dateCondition='';
		 $allWorkstations='';
		  if(Roles::ROLE_SUPERADMIN != Yii::app()->user->role){
        $dateCondition .="(v.tenant=".Yii::app()->user->tenant.") AND ";
            //show curren logged in user Workstations
            $allWorkstations = Workstation::model()->findAll("tenant = " . Yii::app()->user->tenant . " AND is_deleted = 0");
        }else{
            //show all work stations to SUPERADMIN
            $allWorkstations = Workstation::model()->findAll();
        }
        
         $dateCondition .= "(t.is_deleted = 0) AND (v.is_deleted = 0) AND (v.profile_type='VIC')";
        
        $visitsCount = Yii::app()->db->createCommand()
            ->select('count(visitors.id) as visitors, t.id, t.name, t.id as workstationId')
            ->from('workstation t')
           ->join('visit visitors' , 't.id = visitors.workstation AND (visitors.is_deleted = 0 AND visitors.tenant ='.Yii::app()->user->tenant .')')
			->join('visitor v' , 'v.id = visitors.visitor AND (visitors.is_deleted = 0 AND visitors.tenant ='.Yii::app()->user->tenant .')')
            ->where($dateCondition)
            ->group('t.id, t.name')
			->queryAll();
        $otherWorkstations = array();
		
        foreach ($allWorkstations as $workstation) {
			$row=array();
			$row[0]=$workstation['name'];
			$i=0;
            foreach($visitsCount as $visit) {
				
			if($visit['workstationId'] ==  $workstation['id']) {
					$row[1]=$visit['visitors'];
					$i=1;
				}
              if($i!=1)
			  {
				  $row[1]='0';
			  }
			 
            }
		
			fputcsv($fp, $row);
        }
		
        rewind($fp);
        Yii::app()->user->setState('export', stream_get_contents($fp));
        fclose($fp);
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
    /**
     * Reset Count of a Visit
     * 
     * @return int
     */
    public function actionVisitResetById() {
        $visit_id =  Yii::app()->request->getParam("id", 0);
        if($visit_id != 0 )
           Visit::model()->updateByPk($visit_id, array("reset_id" => 1));
        return 1;
    }

}
