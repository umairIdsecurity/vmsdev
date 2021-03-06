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
                'actions' => array('update', 'delete', 'admin', 'adminAjax', 'csvSampleDownload','getActiveVisit'),
                'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION)',
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('getAsicEscort','csvSampleDownload','importVisitHistory', 'addVisitor', 'ajaxCrop', 'create', 'GetIdOfUser','GetHostDetails',
                                    'GetPatientDetails','CheckAlreadyVisitorProfile','CheckAlreadyVisitor', 'CheckEmailIfUnique', 'GetVisitorDetails', 'findVisitor', 'FindHost', 'GetTenantAgentWithSameTenant',
                                    'GetCompanyWithSameTenant', 'GetCompanyWithSameTenantAndTenantAgent','CheckAsicStatusById', 'addAsicSponsor', 'CheckCardStatus', 'UpdateIdentificationDetails','checkAsicEscort',
                                ),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Creates a new model. Register and Preregister a visitor page
     */
    public function actionCreate() 
    {

        $session      = new CHttpSession;
        $model        = new Visitor;
        $userModel    = new User;
        $patientModel = new Patient;
        $reasonModel  = new VisitReason;
        $visitModel   = new Visit;

        $visitorService = new VisitorServiceImpl();

        $userModel->scenario = "add_sponsor";
        if (isset($_POST['Visitor'])) {
				
           $model->attributes = $_POST['Visitor'];

            if (isset($_POST['VisitCardType']) && $_POST['VisitCardType'] > CardType::CONTRACTOR_VISITOR) {
                $model->profile_type = Visitor::PROFILE_TYPE_VIC;
            } else
                  $model->profile_type = Visitor::PROFILE_TYPE_CORPORATE;

            //check validate for LOG VISIT PROCESS
            if (isset($_REQUEST['view']) && $_REQUEST['view'] == 1) {
                $model->scenario = 'vic_log_process';
            }

				
              if ($visitorService->save($model, $_POST['Visitor']['reason'], $session['id'])) 
			  {
				  
                   // nasty hack to transfer visitor id ro visit controller - need to seriously rethink create visit
                   $_SESSION['id_of_last_visitor_created'] = $model->id;

                 //email sending
                if(!empty($model->password_option))
                {
					
                    $passwordRequire= intval($model->password_option);
						
                    if($passwordRequire == 1 && !empty($model->password)){
						
						$airport = Company::model()->findByPk(Yii::app()->user->tenant);
						$airportName = (isset($airport->name) && ($airport->name!="")) ? $airport->name:"Airport";
						$subject='Registration details for'.' '.$airportName.' '.'Aviation Visitor Management System';
						$templateParams = array(
						'email' => $model->email,
						'Username' =>	$model->email,
						'Password' =>	$_POST['Visitor']['password'],
						'Airport'=>$airportName,
						'Link' => "https://vmspr.identitysecurity.com.au/index.php/preregistration/login",
						'name'=>  ucfirst($model->first_name) . ' ' . ucfirst($model->last_name),
										);
							$emailTransport = new EmailTransport();
							$emailTransport->sendRegistration($templateParams,$model->email, ucfirst($model->first_name) . ' ' . ucfirst($model->last_name),$subject );
				
                    }
                    elseif ($passwordRequire == 2) {
						$airport = Company::model()->findByPk(Yii::app()->user->tenant);
						$airportName = (isset($airport->name) && ($airport->name!="")) ? $airport->name:"Airport";
                        Visitor::model()->restorePassword($model->email,$airportName);
						
                    }
                }
				Yii::app()->end();
                
            } else { //todo: for debugging
               print_r($model->errors);
                die("--DONE--");
           }
      
        }
        $this->render('create', array(
            'model'        => $model,
            'userModel'    => $userModel,
            'patientModel' => $patientModel,
            'reasonModel'  => $reasonModel,
            'visitModel'   => $visitModel
    	), false, true);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {                           
        $model = $this->loadModel($id);
        $oldProfileType        = $model->profile_type;
        $visitorService     = new VisitorServiceImpl;
        $session            = new CHttpSession;
        $updateErrorMessage = '';
        // if view value is 1 do not redirect page else redirect to admin
        $isViewedFromModal  = 0;

        if (isset($_GET['view'])) {
            $isViewedFromModal = 1;
        }
        $model->scenario = $this->getValidationScenario( $model, $model->profile_type );
        // Uncomment the following line if AJAX validation is needed             
        $this->performAjaxValidation($model);
        	
		
        $visitorParams = Yii::app()->request->getPost('Visitor');

        if (isset($visitorParams)) {
				
            $currentCardStatus = $model->visitor_card_status;
			
            if (isset($visitorParams['visitor_card_status']) && $currentCardStatus != $visitorParams['visitor_card_status'] && $visitorParams['visitor_card_status'] == Visitor::VIC_ASIC_PENDING) {
                $activeVisit = $model->activeVisits;
                foreach ($activeVisit as $item) {
                    if ($item->visit_status == VisitStatus::ACTIVE) {
                        $updateErrorMessage = 'Please close the active visits before changing the status to ASIC Pending.';
                    }
                }
                if ($updateErrorMessage == '') {
                    $totalVisitCountBefore = $model->totalVisit;
                    $model->attributes = $visitorParams;
                    if ($visitorService->save($model, NULL, $session['id'])) {

                        switch ($isViewedFromModal) {
                            case "1":
                                break;

                            default:
                                echo $updateErrorMessage;
                        }
                    }
                    /** 
                     * CLOSE all Auto close EVIC visits of this visitor that is now having ASIC PENDING 
                     * card status and Reset if first visit
                     */
                    if( $model->visitor_card_status == Visitor::VIC_ASIC_PENDING && $oldProfileType == Visitor::PROFILE_TYPE_VIC) {
                        $this->closeAsicPendingAndReset( $model );
                    }
                        
                    } else {
                    echo $updateErrorMessage;
                    return;
                }
            } elseif (isset($visitorParams['visitor_card_status']) && in_array($visitorParams['visitor_card_status'], [Visitor::ASIC_ISSUED, Visitor::ASIC_APPLICANT, Visitor::ASIC_EXPIRED, Visitor::ASIC_DENIED]) && $model->profile_type == Visitor::PROFILE_TYPE_VIC) {
                $model->attributes          = $visitorParams;
                $model->profile_type        = Visitor::PROFILE_TYPE_ASIC;
                // $model->visitor_card_status = Visitor::ASIC_ISSUED;
                $model->visitor_card_status = $visitorParams['visitor_card_status'];
				
                if($visitorService->save($model, NULL, $session['id'])) {
                    $logCardstatusConvert               = new CardstatusConvert;
                    $logCardstatusConvert->visitor_id   = $model->id;
                    $logCardstatusConvert->convert_time = date("Y-m-d");
                    $logCardstatusConvert->save();
                }
            } else {
				
                $model->attributes = $visitorParams;
                if ($visitorService->save($model, NULL, $session['id'])) {
                    switch ($isViewedFromModal) {
                        case "1":
                            break;

                        default:
                            echo $updateErrorMessage;
                    }
                }
            }

            // If operator convert from VIC to ASIC profile then generate a company contact
            if ($oldProfileType == Visitor::PROFILE_TYPE_VIC && $model->profile_type == Visitor::PROFILE_TYPE_ASIC) 
            {
                $contact                 = new User('add_company_contact');
                $contact->company        = $model->company;
                $contact->first_name     = $model->first_name;
                $contact->last_name      = $model->last_name;
                $contact->email          = $model->email;
                $contact->contact_number = $model->contact_number;
                $contact->created_by     = Yii::app()->user->id;
                
                // Todo: temporary value for saving contact, will be update later
                $contact->timezone_id    = 1;
                $contact->photo          = 0;
                
                // foreign keys // todo: need to check and change for HARD-CODE
                $contact->tenant         = $session['tenant'];
                $contact->user_type      = 1;
                $contact->user_status    = 1;
                $contact->role           = 9;

                if ($contact->save()) {               
                    switch ($isViewedFromModal) {
                        case "1":
                            break;
                        
                        default:
                            echo $updateErrorMessage;
                }
                }
            } 
            
            //logs the UPDATION of ASIC SPONSOR
            if($model->profile_type == "ASIC" ) 
            {
                $this->audit_logging_visit_statuses("UPDATE ASIC SPONSOR",$model);
            }

            Yii::app()->user->setFlash('success', 'Profile Updated Successfully');
            if( $model->profile_type == "CORPORATE" ) {
                $this->redirectAddUpdateRoleBased("id={$id}&vms=cvms");
            } else {
                $this->redirectAddUpdateRoleBased("id={$id}&vms=avms");
            }
            
        } else{
			//echo "<pre>";
			//print_r($model);
			//echo "</pre>";
			//Yii::app()->end();
            $this->render('update', array(
                'model' => $model,
            ));
        }
    }

    //log the UPDATION of ASIC SPONSOR
    public function audit_logging_visit_statuses($action,$visitor)
    {
        $log = new AuditLog();
        $log->action_datetime_new = date('Y-m-d H:i:s');
        $log->action = $action;
        $log->detail = 'Logged user ID: ' . Yii::app()->user->id." ASIC Sponsor ID: ".$visitor->id;
        $log->user_email_address = Yii::app()->user->email;
        $log->ip_address = (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != "") ? $_SERVER['REMOTE_ADDR'] : "UNKNOWN";
        $log->tenant = Yii::app()->user->tenant;
        $log->tenant_agent = Yii::app()->user->tenant_agent;
        $log->save();
    }

    /**
     * Close all auto Close EVIC visits if Changed to ASIC Pending
     * And Reset visit if its first visit of the Visitor
     * @param type $visitor
     */
    protected function closeAsicPendingAndReset( $visitor ) {
        $update = array();
        $update["visit_status"] = VisitStatus::CLOSED;
        $update["visit_closed_date"] = date("Y-m-d H:i:s");
        /**
         * Get all EVIC Auto Closed Visits now
         */
        $criteria = new CDbCriteria();
        $criteria->addCondition("visitor = ".$visitor->id);
        $criteria->addCondition("visit_status = ".VisitStatus::AUTOCLOSED);
        $criteria->addCondition("card_type = ".CardType::VIC_CARD_EXTENDED);
                
        $visits = Visit::model()->findAll($criteria);
        foreach( $visits as $v ) {
            if( is_null( $v["parent_id"]) ) {
                $update["reset_id"] = 1;
                
                Visit::model()->updateByPk($v["id"], $update);
            }
        }
         return;               
    }
    /* Visitor detail page */

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {

        if(Yii::app()->request->isPostRequest)
        {
            $model = $this->loadModel($id);
            $model->scenario = "delete";
            if ($model->delete()) {
                //throw new CHttpException(400, "This is a required field and cannot be deleted");
            } else {
                $visitorExists = Visit::model()->exists('is_deleted = 0 and visitor =' . $id . ' and (visit_status=' . VisitStatus::PREREGISTERED . ' or visit_status=' . VisitStatus::ACTIVE . ')');
                $visitorExistsClosed = Visit::model()->exists('is_deleted = 0 and visitor =' . $id . ' and (visit_status=' . VisitStatus::CLOSED . ' or visit_status=' . VisitStatus::EXPIRED . ')');

                if (!$visitorExists && !$visitorExistsClosed) {

                    return false;
                }
            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

        }

    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        //$merge = new CDbCriteria;
        //$merge->addCondition("profile_type = '". Visitor::PROFILE_TYPE_VIC ."' OR profile_type = '". Visitor::PROFILE_TYPE_ASIC ."'");

        $model = new Visitor('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visitor']))
            $model->attributes = $_GET['Visitor'];

        if (Yii::app()->request->getParam('vms')) {
            if (CHelper::is_avms_visitor()) {
                
                //Check whether a login user/tenant allowed to view 
                CHelper::check_module_authorization("AVMS");
                $model = $model->avms_visitor();
            } else {
                
                //Check whether a login user/tenant allowed to view 
                CHelper::check_module_authorization("CVMS");
                $model = $model->cvms_visitor();
            }
        }

        $this->render('_admin', array(
            'model' => $model,
        ), false, true);
    }

    public function actionAdminAjax() {
        $model = new Visitor('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visitor']))
            $model->attributes = $_GET['Visitor'];

        $this->renderPartial('_admin', array(
            'model' => $model,
                ), false, true);
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
        // Corporate Add Form
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'visitor-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        
        // ASIC Add Form
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'asic-register-form') {  
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        
        // Vic Add Form
          // ASIC Add Form
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'vic-register-form') {  
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

    public function actionFindVisitor() {
        $this->layout = '//layouts/column1';
        $model = new Visitor('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visitor']))
            $model->attributes = $_GET['Visitor'];

        $this->renderPartial('findVisitor', array(
                'model' => $model
            ), false, true);
    }

    public function actionFindHost($id,$tenant,$tenant_agent, $cardType = null) 
    {
        $this->layout = '//layouts/column1';
        $visitorType = $_GET['visitortype'];
        $searchInfo = $_GET['id'];
        $tenant = 'tenant='.Yii::app()->user->tenant.' AND ';
        if (isset($_GET['tenant_agent']) && $_GET['tenant_agent'] != '') {
            $tenant_agent = "tenant_agent=" . $_GET["tenant_agent"] . " and";
        } else {
            $tenant_agent = "";
        } $tenant_agent = "";

        $criteria = new CDbCriteria;

        if (isset($_GET['cardType']) && $_GET['cardType'] > CardType::CONTRACTOR_VISITOR) 
        {
            $model = new Visitor('search');
            $model->unsetAttributes();

            //because of https://ids-jira.atlassian.net/browse/CAVMS-1188
            if(is_numeric($searchInfo))
            {   //pure Numerics -- Search Only by ASIC No. (e.g. Asic No = 1234)
                $conditionString = $tenant. $tenant_agent . " (asic_no ='".$searchInfo."')";
                $hostTitle = 'ASIC Sponsor';
                // $conditionString .= " AND profile_type = '" . Visitor::PROFILE_TYPE_ASIC . "' ";
                $conditionString .= " AND (profile_type = '" . Visitor::PROFILE_TYPE_VIC . "' OR profile_type = '". Visitor::PROFILE_TYPE_ASIC ."')";
                // Don't show Expired ASIC Sponsors
                $conditionString .= " AND (visitor_card_status != '".Visitor::ASIC_EXPIRED."') ";

            }
            else
            {
                if(preg_match('/[A-Za-z]/', $searchInfo) && preg_match('/[0-9]/', $searchInfo))//Contains at least one letter and one number
                {   //English Alphabets with numbers -- Search Only by ASIC No. (e.g. Asic No = ROI1234)
                    $conditionString = $tenant. $tenant_agent . " (asic_no ='".$searchInfo."')";
                    $hostTitle = 'ASIC Sponsor';
                    // $conditionString .= " AND profile_type = '" . Visitor::PROFILE_TYPE_ASIC . "' ";
                    $conditionString .= " AND (profile_type = '" . Visitor::PROFILE_TYPE_VIC . "' OR profile_type = '". Visitor::PROFILE_TYPE_ASIC ."')";
                    // Don't show Expired ASIC Sponsors
                    $conditionString .= " AND (visitor_card_status != '".Visitor::ASIC_EXPIRED."') ";
                }
                else
                {   //pure English Alphabets -- Names do not have numbers
                    $conditionString = $tenant. $tenant_agent . " (CONCAT(first_name,' ',last_name) like '%" . $searchInfo
                    . "%' or first_name like '%" . $searchInfo
                    . "%' or last_name like '%" . $searchInfo
                    . "%' or email like '%" . $searchInfo
                    . "%' or identification_document_no LIKE '%" . $searchInfo
                    . "%' or identification_alternate_document_no1 LIKE '%" . $searchInfo
                    . "%' or identification_alternate_document_no2 LIKE '%" . $searchInfo
                    . "%')";
                    $hostTitle = 'ASIC Sponsor';
                    // $conditionString .= " AND profile_type = '" . Visitor::PROFILE_TYPE_ASIC . "' ";
                    $conditionString .= " AND (profile_type = '" . Visitor::PROFILE_TYPE_VIC . "' OR profile_type = '". Visitor::PROFILE_TYPE_ASIC ."')";
                    // Don't show Expired ASIC Sponsors
                    $conditionString .= " AND (visitor_card_status != '".Visitor::ASIC_EXPIRED."') ";

                }
            }
            
        } 
        else 
        {
            $model = new User('search');
            $model->unsetAttributes();
            if (isset($_GET['User'])){
                $model->attributes = $_GET['User'];
            }
            $conditionString = $tenant. $tenant_agent . " (CONCAT(first_name,' ',last_name) like '%" . $searchInfo
                . "%' or first_name like '%" . $searchInfo
                . "%' or last_name like '%" . $searchInfo
                . "%' or email like '%" . $searchInfo
                . "%')";
            $hostTitle = 'Host';
        }
        
        $criteria->addCondition($conditionString);

        $this->renderPartial('findHost', array(
            'model' => $model,
            'criteria' => $criteria,
            'hostTitle' => $hostTitle,
            'visitorType' => $visitorType
            ), false, true);
    }

    public function actionGetVisitorDetails($id) {
        $resultMessage['data'] = Visitor::model()->findAllByPk($id);
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionGetHostDetails($id) {
        $resultMessage['data'] = Visitor::model()->findAllByPk($id);
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

    public function actionCheckEmailIfUnique($email, $id = 0) {
        if (Visitor::model()->isEmailAddressTaken($email, $id)) {
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

    public function actionCheckAlreadyVisitor($email, $id = 0) {
        if (Visitor::model()->isEmailAddressTaken($email, $id)) {
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

    public function actionCheckAlreadyVisitorProfile($firstname,$middlename,$lastname,$dateofbirth,$id = 0) {
        if (Visitor::model()->isVisitorProfileTaken($firstname,$middlename,$lastname,$dateofbirth,$id)) {
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



    public function actionCheckAsicStatusById($id){
        echo Visitor::model()->checkAsicStatusById($id);
    }

    public function actionAjaxCrop() {
        function imageCreateFromAny($filepath) {
            $type = exif_imagetype($filepath); // [] if you don't have exif you could use getImageSize()
            $allowedTypes = array(
                1,  // [] gif
                2,  // [] jpeg
                3,  // [] png
                4,  // [] jpg
                6   // [] bmp
            );
            if (!in_array($type, $allowedTypes)) {
                return false;
            }
            switch ($type) {
                case 1 :
                    $im = imageCreateFromGif($filepath);
                    break;
                case 2 :
                    $im = imageCreateFromJpeg($filepath);
                    break;
                case 3 :
                    $im = imageCreateFromPng($filepath);
                    break;
                case 4 :
                    $im = imageCreateFromJpg($filepath);
                    break;
                case 6 :
                    $im = imageCreateFromBmp($filepath);
                    break;
            }
            return $im;
        }
        $jpeg_quality = 90;

        //for my localhost directory
        //$path = "E:/installed/xampp/htdocs/vmspro/vms/uploads/visitor";

        //for accessing server files
        $path = Yii::getPathOfAlias('webroot') . "/uploads/visitor";

        $photo = Photo::model()->findByPk($_REQUEST['photoId']);
        $photoAttr = $photo->attributes;

        $db_image_contents = $photoAttr['db_image'];
        $db_image_name = $photoAttr['unique_filename'];


        $file = fopen($path."/".$db_image_name,"w");
        fwrite($file, base64_decode($db_image_contents));
        fclose($file);

        //option 2 (one liner)
        //file_put_contents($path."/".$db_image_name, base64_decode($db_image_contents));

        $src = $path."/".$db_image_name;        
        $img_r = imageCreateFromAny($src);

        $dst_r = imagecreatetruecolor(200, 200);
        $usernameHash = hash('adler32', "visitor");
        $uniqueFileName = 'visitor' . $usernameHash . '-' . time() . ".png";
        imagecopyresampled($dst_r, $img_r, 0, 0, $_REQUEST['x1'], $_REQUEST['y1'], 200, 200, $_REQUEST['width'], $_REQUEST['height']);
        

        header('Content-type: image/jpeg');
        imagejpeg($dst_r, "uploads/visitor/" . $uniqueFileName, $jpeg_quality);

        $uploadedFile = "uploads/visitor/" . $uniqueFileName;
        $file=file_get_contents($uploadedFile);
        $image = base64_encode($file);

        Photo::model()->updateByPk($_REQUEST['photoId'], array(
            'unique_filename' => $uniqueFileName,
            'relative_path' => "uploads/visitor/" . $uniqueFileName,
            'db_image' => $image,
        ));

        
        if (file_exists($src)) {
            unlink($src);
        }

        if (file_exists($uploadedFile)) {
            unlink($uploadedFile);
        }

        echo json_encode("exit");
        exit;
        //return true;
    }

    /**
     * Get Validation Scenario for Add Visitor Profile
     * @param type $profile Corporate/Asic/Vic
     * @return string
     */
    public function getValidationScenario( $model, $profile) {
        switch ($profile) { 
            case "CORPORATE":
                return 'corporateVisitor';
                break;
            case "ASIC":
               return "asic";
               break;
           
           case "VIC":
               return "VicScenario";
               break;
           
           default :
               return "";
               break;
        }
        return $model;
    }
    public function actionAddVisitor() 
    {

        $model = new Visitor;
        $profile_type = Yii::app()->request->getParam("profile_type", "CORPORATE");
        $model->scenario = $this->getValidationScenario( $model, $profile_type );
        //AJAX validation is needed
        $this->performAjaxValidation($model);
            
        $visitorService = new VisitorServiceImpl;
        $session = new CHttpSession;
		
        if (isset($_POST['Visitor'])) 
        {    
            $model->attributes = $_POST['Visitor'];
           
            if (isset($_POST['Visitor']['profile_type'])) {
                $model->profile_type = $_POST['Visitor']['profile_type'];
            }

            if (empty($model->visitor_workstation)) {
                $model->visitor_workstation = $session['workstation'];
            }
             if (empty($model->tenant)) {
                $model->tenant = $session['tenant'];
            }
                
            if ($result = $visitorService->save($model, NULL, $session['id'])) {
                // Add company contact for this visitor if profile is ASIC
                if (isset($_POST['profile_type']) && $_POST['profile_type'] == 'ASIC') {
                    $company = Company::model()->findByPk($model->company);
                    if ($company) {
                        $contact = new User('add_company_contact');
                        $contact->company = $company->id;
                        $contact->first_name = $model->first_name;
                        $contact->last_name = $model->last_name;
                        $contact->email = $model->email;
                        $contact->contact_number = $model->contact_number;
                        $contact->created_by = Yii::app()->user->id;

                        // Todo: temporary value for saving contact, will be update later
                        $contact->timezone_id = 1; 
                        $contact->photo = 0;

                        // foreign keys // todo: need to check and change for HARD-CODE
                        $contact->tenant = $session['tenant'];
                        $contact->user_type = UserType::USERTYPE_INTERNAL;
                        $contact->user_status = 1;
                        $contact->role = Roles::ROLE_STAFFMEMBER;
                        if (!$contact->save()) {
                            echo 0;
                            Yii::app()->end();
                        }
                    }
                }
                //email sending
                if(!empty($model->password_option))
                {
                    $passwordRequire= intval($model->password_option);
                    if($passwordRequire == 1)
                    {
                        $loggedUserEmail = Yii::app()->user->email;
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                        $headers .= "From: ".$loggedUserEmail."\r\nReply-To: ".$loggedUserEmail;
                        $to=$model->email;
                        $subject="Preregistration email notification";
                        $body = "<html><body>Hi,<br><br>".
                                "This is preregistration email.<br><br>".
                                "Please click on the below URL:<br>".
                                Yii::app()->request->baseUrl."/index.php/preregistration/login<br>";
                        if(!empty($model->password_option)){
                            $passwordCreate= intval($model->password_option);
                            if($passwordCreate == 1){
                                $body .= "Password: ".$_POST['Visitor']['password']."<br>";
                            }
                        }
                        $body .="<br>"."Thanks,"."<br>Admin</body></html>";
                        
                        EmailTransport::mail($to, $subject, $body, $headers);
                    }
                    elseif ($passwordRequire == 2) 
                    {
                        User::model()->restorePassword($model->email);
                    }
                }
                Yii::app()->user->setFlash('success', 'Profile Added Successfully.');
                if( $model->profile_type == "CORPORATE" ) {
                    $this->redirectAddUpdateRoleBased("vms=cvms");
                }
                else {
                    $this->redirectAddUpdateRoleBased("vms=avms");
                    Yii::app()->end();
                }
                
            }  else {  // Not Save record then
                 //$errors = $model->getErrors(); print_r($errors); exit;
                 if( $model->profile_type == "CORPORATE" ) {
                     $this->redirect(array("visitor/addvisitor/&profile_type=CORPORATE"));
                 }
            }
        }
              
        $this->render('addvisitor', array(
            'model' => $model,
        ));
    }
    /**
     * Import Visit History
     * 3. It should search for duplicate visits  and prompt the administrator to delete second entry if nessecary
     * 4. It should also match duplicate first names and last names and allow the user to verify whether they are a the same person or 
     * 
     * @return View
     */
    public function actionImportVisitHistory() 
    { 
        $model = new ImportCsvForm;
        $session = new CHttpSession;
        if(isset($_POST['ImportCsvForm']))
        {
                $model->attributes=$_POST['ImportCsvForm'];
				
                if($model->validate())
                {   
                    //Delete all previous uploads of this user
                    ImportVisitor::model()->deleteAll(
                        "imported_by = :user_id",
                        array(':user_id' => Yii::app()->user->id)
                    );
                    
                    // Read and save in ImportVisitor
                    $csvFile = CUploadedFile::getInstance($model,'file');  
                    $tempLoc = $csvFile->getTempName();
                    $handle = fopen($tempLoc, "r");
                    $i = 0; $duplicates = false;
					//$line=fgetcsv($handle,2000);
                   set_time_limit (0);
					
                    while( $line = fgetcsv($handle, 2000) )
                    {  
						
						
                       if( !isset($line[12]))
                           $this->redirect(array("visitor/importVisitHistory"));
                        //Dont insert first row as it will be title
                        $i = $i + 1;
                        if($i == 1) {
							//$i=0;
                           continue;
                        }
						// echo "<pre>";
						//print_r($line);
						//echo "</pre>";
						$check=date("Y-m-d", strtotime(str_replace('/', '-',$line[6])));
						
                        // Find Duplicate Visitor if any or asic sponsor
                        $visitor = Visitor::model()->find(" ( first_name = '{$line[3]}' AND last_name = '{$line[5]}' AND date_of_birth = '{$check}' )"); //AND email= '{$line[7]}'
						$asicVisitor=Visitor::model()->find("first_name = '{$line[29]}' AND last_name = '{$line[30]}' AND profile_type='ASIC'");
                      // echo "<pre>";
					//print_r($line);
						//echo "</pre>";
						//echo $check;
                        // Duplicate Visitor Found 
						if( $visitor )  { 
						//echo "here";
								if($line[1]!="")
								{
									$card = new CardGenerated;
                                    $card->card_number = $line[1];
                                    $card->date_printed = date("Y-m-d", strtotime(str_replace('/', '-',$line[37])));
                                    $card->date_expiration = date("Y-m-d", strtotime(str_replace('/', '-',$line[38])));
                                    $card->visitor_id = $visitor->id;
                                    $card->card_status  = 1;
                                    $card->created_by = Yii::app()->user->id;
                                    $card->tenant = Yii::app()->user->tenant;
                                    $card->save();     
								}
								$visitInfo = new Visit;
                                $visitInfo->visitor = $visitor->id;
                                $visitInfo->visitor_status = 1;
                                $visitInfo->card = isset($card) ? $card->id:"";
								$visitInfo->card_type='5';
								if($asicVisitor)
								{
									//echo "here";
									$visitInfo->host = $asicVisitor->id;
									if($asicVisitor->asic_no!=$line[33] && $line[33]!="")
									{
										
										$asicVisitor->asic_no=$line[33];
										$todayDate = date("Y-m-d");
										if($asicVisitor->asic_expiry<=$todayDate)
										{
											$asicVisitor->visitor_card_status='8';
										}
										else
											$asicVisitor->visitor_card_status='6';
										$asicVisitor->update();
									}
									if($asicVisitor->asic_expiry!=date("Y-m-d",strtotime(str_replace('/', '-',$line[34])))&& $line[34]!="")
									{
										$asicVisitor->asic_expiry=date("Y-m-d",strtotime(str_replace('/', '-',$line[34])));
										$todayDate = date("Y-m-d");
										if($asicVisitor->asic_expiry<=$todayDate)
										{
											$asicVisitor->visitor_card_status='8';
										}
										else
											$asicVisitor->visitor_card_status='6';
										$asicVisitor->update();
									}
									
									
								}
								else 
								{
									$asicVisitor=new Visitor('importVisitor');
									$asicVisitor->first_name = $line[29];
									$asicVisitor->last_name  = $line[30];
									$asicVisitor->email= $line[32];
									$asicVisitor->date_of_birth=date("Y-m-d",strtotime(str_replace('/', '-',$line[31])));
									$asicVisitor->profile_type='ASIC';
									$asicVisitor->asic_no=$line[33];
									$asicVisitor->asic_expiry=date("Y-m-d",strtotime(str_replace('/', '-',$line[34])));
									$asicVisitor->created_by = Yii::app()->user->id;
									$asicVisitor->tenant = Yii::app()->user->tenant;
									$todayDate = date("Y-m-d");
										if($asicVisitor->asic_expiry<=$todayDate)
										{
											$asicVisitor->visitor_card_status='8';
										}
										else
											$asicVisitor->visitor_card_status='6';
									$asicVisitor->save(false);
									/*$errrossss=$asicVisitor->getErrors();
									echo "<pre>";
									var_dump($errrossss);
									echo "</pre>";
									$visitInfo->host = $asicVisitor->id;*/
								}
								// $company = Company::model()->find(" name LIKE '%{$line[18]}%' OR trading_name LIKE '%{$line[18]}%' ");
                            //if( $company )
							//{
							  //$visitorInfo->company = $company->id;
							  $PreviouUser=User::model()->find("first_name='{$line[19]}' AND last_name='{$line[20]}' AND company='{$visitor->company}'");
							  if(!$PreviouUser)
							  {
								 $companyUser= new User();
								$companyUser->first_name=$line[19];
								$companyUser->last_name=$line[20];
								$companyUser->email=$line[21];
								$companyUser->contact_number=$line[22];
								
								$companyUser->company=$visitor->company;
							
								$companyUser->created_by = Yii::app()->user->id;
								
								$companyUser->tenant = Yii::app()->user->tenant;
								$companyUser->role='9';
								$companyUser->is_deleted='0';
								$companyUser->user_type='1';
								$companyUser->save(false);
							  }
							 
							//}
                                //$visitInfo->host = Yii::app()->user->id;
                                $visitInfo->created_by = Yii::app()->user->id;
                                $visitInfo->date_check_in = date("Y-m-d", strtotime(str_replace('/', '-',$line[26])));
                                $visitInfo->time_check_in = date("H:i:s", strtotime($line[35]));
                                $visitInfo->time_check_out = date("H:i:s", strtotime($line[36]));
                                $visitInfo->date_check_out = date("Y-m-d", strtotime(str_replace('/', '-',$line[27])));
                                $visitInfo->visit_status = 3; //Closed visit History
                                $visitInfo->workstation = $session['workstation'];                               
                                $visitInfo->tenant = Yii::app()->user->tenant;
								$visitInfo->visitor_type='113';
								if($line[17]!=NULL)
								{
									$visitReason=VisitReason::model()->find("reason='{$line[17]}'");
									if($visitReason)
									{
										$visitInfo->reason=$visitReason->id;
									}
									else 
									{
										$visitReason= new VisitReason;
										$visitReason->reason=$line[17];
										$visitReason->is_deleted='0';
										$visitReason->module='AVMS';
										$visitReason->created_by = Yii::app()->user->id;
										$visitReason->tenant = Yii::app()->user->tenant;
										$visitReason->save();
										$visitInfo->reason=$visitReason->id;
									}
									
								}
								else
								{
								$visitInfo->reason = NULL;	
								}
								$visitInfo->save();
								//$errrosssss=$visitInfo->getErrors();
								//echo "<pre>";
								//var_dump($errrosssss);
								//echo "</pre>";
                        } 
						
						
					else {
							
							
                            // If not a duplicate Visitor then Add it to Visitor and Visits tables
							$visitorInfo = new Visitor('importVisitor');
                            $visitorInfo->first_name = $line[3];
						
						
							if($line[4]!=null)
							{
								$visitorInfo->middle_name =$line[4];
							}
                            $visitorInfo->last_name  = $line[5];
							$visitorInfo->date_of_birth=date("Y-m-d",strtotime(str_replace('/', '-',$line[6])));
                            $visitorInfo->email= $line[7];
                            $visitorInfo->contact_number = $line[8];
							
						
							if($line[9]!=null)
							{
								$visitorInfo->contact_unit =$line[9];
							}
							$visitorInfo->contact_street_no=$line[10];
							$visitorInfo->contact_street_name=$line[11];
							$visitorInfo->contact_street_type=$line[12];
							$visitorInfo->contact_suburb=$line[13];
							$visitorInfo->contact_state=$line[14];
							$visitorInfo->contact_postcode=$line[15];
					
							if($line[16]!='Australia' || $line[16]!='australia' || $line[16]!='AUSTRALIA')
							{
								
								$country= Country::model()->find("name='{$line[16]}'");
								$visitorInfo->contact_country=$country->id;
						    
								
							}
							else
							{
							$visitorInfo->contact_country='13';
							}
							if($line[39]!='Australia' || $line[39]!='australia' || $line[39]!='AUSTRALIA')
							{
								
								$country= Country::model()->find("name='{$line[16]}'");
								$visitorInfo->identification_country_issued=$country->id;
						    
								
							}
							else
							{
							$visitorInfo->identification_country_issued='13';
							}
							$visitorInfo->visitor_type='113';
							$visitorInfo->profile_type='VIC';
							$visitorInfo->identification_type=strtoupper($line[23]);
							$visitorInfo->identification_document_no=$line[24];
							$visitorInfo->identification_document_expiry=date("Y-m-d",strtotime(str_replace('/', '-',$line[25])));
							
							
								
							
							
                            $visitorInfo->position = $line[8];
                            $company = Company::model()->find(" name LIKE '%{$line[18]}%' OR trading_name LIKE '%{$line[18]}%' ");
                            if( $company )
							{
							
							  $visitorInfo->company = $company->id;
							}
                            else
							{
								$company= new Company();
								$company->name=$line[18];
								$company->code = strtoupper(substr($company->name, 0, 3));
								$company->contact=$line[19]." ".$line[20];
								$company->email_address=$line[21];
								$company->mobile_number=$line[22];
								$company->company_type='3';
								$company->is_deleted='0';
								$company->tenant= Yii::app()->user->tenant;
								$company->save();
								
								$companyUser= new User();
								$companyUser->first_name=$line[19];
								$companyUser->last_name=$line[20];
								$companyUser->email=$line[21];
								$companyUser->contact_number=$line[22];
								
								$companyUser->company=$company->id;
							
								$companyUser->created_by = Yii::app()->user->id;
								
								$companyUser->tenant = Yii::app()->user->tenant;
								$companyUser->role='9';
								$companyUser->is_deleted='0';
								$companyUser->user_type='1';
								$companyUser->save(false);
								//$errros=$company->getErrors();
								//echo "<pre>";
								//var_dump($errros);
								//echo "</pre>";
								//$errross=$companyUser->getErrors();
								//echo "<pre>";
								//var_dump($errross);
								//echo "</pre>";
							}
                            $visitorInfo->company = $company->id;
                            $visitorInfo->role = Roles::ROLE_VISITOR;
                            $visitorInfo->visitor_status = '1'; // Active
                            //$visitorInfo->visitor_type= '2';
                            //$visitorInfo->vehicle= $line[12]; 
                            $visitorInfo->created_by = Yii::app()->user->id;
                            $visitorInfo->tenant = Yii::app()->user->tenant;
							
							
							   
								$visitorInfo->save();
								//$errrosss=$visitorInfo->getErrors();
								//echo "<pre>";
								//var_dump($errrosss);
								//echo "</pre>";
                                
								
						if($line[1]!="")
								{
									$card = new CardGenerated;
                                    $card->card_number = $line[1];
                                    $card->date_printed = date("Y-m-d", strtotime(str_replace('/', '-',$line[37])));
                                    $card->date_expiration = date("Y-m-d", strtotime(str_replace('/', '-',$line[38])));
                                    $card->visitor_id = $visitorInfo->id;
                                    $card->card_status  = 1;
                                    $card->created_by = Yii::app()->user->id;
                                    $card->tenant = Yii::app()->user->tenant;
                                    $card->save();     
								}
								$visitInfo = new Visit;
                                $visitInfo->visitor = $visitorInfo->id;
                                $visitInfo->visitor_status = 1;
                                $visitInfo->card = isset($card) ? $card->id:"";
								$visitInfo->card_type='5';
								if($asicVisitor)
								{
									//echo "here";
									$visitInfo->host = $asicVisitor->id;
									if($asicVisitor->asic_no!=$line[33] && $line[33]!="")
									{
										
										$asicVisitor->asic_no=$line[33];
										$todayDate = date("Y-m-d");
										if($asicVisitor->asic_expiry<=$todayDate)
										{
											$asicVisitor->visitor_card_status='8';
										}
										else
											$asicVisitor->visitor_card_status='6';
										$asicVisitor->update();
									}
									if($asicVisitor->asic_expiry!=date("Y-m-d",strtotime(str_replace('/', '-',$line[34])))&& $line[34]!="")
									{
										$asicVisitor->asic_expiry=date("Y-m-d",strtotime(str_replace('/', '-',$line[34])));
										$todayDate = date("Y-m-d");
										if($asicVisitor->asic_expiry<=$todayDate)
										{
											$asicVisitor->visitor_card_status='8';
										}
										else
											$asicVisitor->visitor_card_status='6';
										$asicVisitor->update();
									}
									
									
								}
								else 
								{
									$asicVisitor=new Visitor('importVisitor');
									$asicVisitor->first_name = $line[29];
									$asicVisitor->last_name  = $line[30];
									$asicVisitor->email= $line[32];
									$asicVisitor->date_of_birth=date("Y-m-d",strtotime(str_replace('/', '-',$line[31])));
									$asicVisitor->profile_type='ASIC';
									$asicVisitor->asic_no=$line[33];
									$asicVisitor->asic_expiry=date("Y-m-d",strtotime(str_replace('/', '-',$line[34])));
									$asicVisitor->created_by = Yii::app()->user->id;
									$asicVisitor->tenant = Yii::app()->user->tenant;
									$todayDate = date("Y-m-d");
										if($asicVisitor->asic_expiry<=$todayDate)
										{
											$asicVisitor->visitor_card_status='8';
										}
										else
											$asicVisitor->visitor_card_status='6';
									$asicVisitor->save(false);
									$visitInfo->host = $asicVisitor->id;
								}
								//$errrossss=$asicVisitor->getErrors();
								//echo "<pre>";
								//print_r($errrossss);
								//echo "</pre>";
                                
                                //$visitInfo->host = Yii::app()->user->id;
                                $visitInfo->created_by = Yii::app()->user->id;
                                $visitInfo->date_check_in = date("Y-m-d", strtotime(str_replace('/', '-',$line[26])));
                                $visitInfo->time_check_in = date("H:i:s", strtotime($line[35]));
                                $visitInfo->time_check_out = date("H:i:s", strtotime($line[36]));
                                $visitInfo->date_check_out = date("Y-m-d", strtotime(str_replace('/', '-',$line[27])));
                                $visitInfo->visit_status = 3; //Closed visit History
                                $visitInfo->workstation = $session['workstation'];                               
                                $visitInfo->tenant = Yii::app()->user->tenant;
								$visitInfo->visitor_type='113';
								if($line[17]!=NULL)
								{
									$visitReason=VisitReason::model()->find("reason='{$line[17]}'");
									if($visitReason)
									{
										$visitInfo->reason=$visitReason->id;
									}
									else 
									{
										$visitReason= new VisitReason;
										$visitReason->reason=$line[17];
										$visitReason->is_deleted='0';
										$visitReason->module='AVMS';
										$visitReason->created_by = Yii::app()->user->id;
										$visitReason->tenant = Yii::app()->user->tenant;
										$visitReason->save();
										//$errrosssss=$visitReason->getErrors();
										//echo "<pre>";
										//print_r($errrosssss);
										//echo "</pre>";
										$visitInfo->reason=$visitReason->id;
									}
								}
								else
								{
								$visitInfo->reason = NULL;	
								}
								$visitInfo->save();
						    //$errrosssss=$visitInfo->getErrors();
								//echo "<pre>";
								//print_r($errrosssss);
								//echo "</pre>";
                       
						}
                    //echo "<pre>";
					//print_r($visitorInfo);
					//echo "</pre>";
					$i++;
                   }  
				  //var_dump(getErrors());
				  //Yii::app()->end();
                    /*if( $duplicates )
                        $this->redirect(array("importVisitor/admin"));
                    else*/
						Yii::app()->user->setFlash('importrecords', "Total $i Records Successfully Added");
                        $this->redirect(array("visitor/admin"));
                 }
             }
        return $this->render("importvisitor", array("model"=>$model));
    }
    /**
     * Download Sample Visitor Import File
     * 
     * @return type
     * @throws CHttpException
     */
    public function actionCsvSampleDownload() {
        $dir_path = Yii::getPathOfAlias('webroot') . '/uploads/';
        $fileName = $dir_path . "/visit_history.csv";
        if (file_exists($fileName))
           return Yii::app()->getRequest()->sendFile('visit_history.csv', @file_get_contents($fileName));
        else
           throw new CHttpException(404, 'The requested page does not exist.');
    }

    public function actionGetActiveVisit($id)
    {
        $model = new Visit();
        $criteria = new CDbCriteria();
        $criteria->compare('visitor', $id);
        $criteria->addCondition('negate_reason IS NULL');
        $criteria->addCondition('reset_id IS NULL');
        $criteria->addCondition('visit_status='.VisitStatus::CLOSED);

        $dataProvider=new CActiveDataProvider($model, array(
            'criteria'=>$criteria,
        ));

        return $this->renderPartial('activeVisit',array('dataProvider' => $dataProvider));
    }

    /**
     * Add asic sponsor for Log Visit process
     */
    public function actionAddAsicSponsor() 
    {
        // If asic sponsor existed
        $model='';
        if (isset($_POST['User']['email']) && !empty($_POST['User']['email'])) { 

            $userEmail = $_POST['User']['email'];

            $model = Visitor::model()->findByAttributes(array('email' => $userEmail));
			//print_r($model);
        }

        // If does not exist then create new
        if (!$model) {
            $model = new Visitor;
        }

        $visitorService = new VisitorServiceImpl;
        $session        = new CHttpSession;

        if (isset($_POST['User']) && isset($_POST['Visitor'])) {
            $userParams        = Yii::app()->request->getPost('User');
            $visitorParams     = Yii::app()->request->getPost('Visitor');
            $model->attributes = $userParams;
            $model->attributes = $visitorParams;
			//echo 2;
            if (isset($userParams['asic_expiry']) && !empty($userParams['asic_expiry'])) {
                $model->asic_expiry = date('Y-m-d', strtotime($userParams['asic_expiry']));
            }

            $model->profile_type = Visitor::PROFILE_TYPE_ASIC;

            if (empty($model->visitor_workstation)) {
                $model->visitor_workstation = $session['workstation'];
            }

            if ($result = $visitorService->save($model, NULL, $session['id'])) {
                /*
                CHECKPOINT:
                    because of CAVMS-1004
                    =====================
                    This adds an ASIC SPONSOR to USER table as well
                    which is listed under CVMS USERS and is not intended by the task. According to the
                    task: "ASIC sponsor profile is also getting displayed in CVMS USERS list".

                $company = Company::model()->findByPk($model->company);
                if (!empty($userParams['company']) && $company) 
                {
                    $contact                 = new User('add_company_contact');
                    $contact->company        = $company->id;
                    $contact->first_name     = $model->first_name;
                    $contact->last_name      = $model->last_name;
                    $contact->email          = $model->email;
                    $contact->contact_number = $model->contact_number;
                    $contact->created_by     = Yii::app()->user->id;
                    
                    // Todo: temporary value for saving contact, will be update later
                    $contact->timezone_id    = 1; 
                    $contact->photo          = 0;
                    
                    // foreign keys // todo: need to check and change for HARD-CODE
                    $contact->tenant         = $session['tenant'];
                    $contact->user_type      = UserType::USERTYPE_INTERNAL;
                    $contact->user_status    = 1;
                    $contact->role           = Roles::ROLE_STAFFMEMBER;
                    if (!$contact->save()) {
                        echo 0;
                        Yii::app()->end();
                    }
                }*/
                echo 1;
                Yii::app()->end();
            }
        }
    }

    public function actionCheckCardStatus($id){
        $visitor = Visitor::model()->findByPk($id);
        if ($visitor){
            if ($visitor->visitor_card_status && ($visitor->profile_type == Visitor::PROFILE_TYPE_VIC || $visitor->profile_type == Visitor::PROFILE_TYPE_ASIC))
            {echo 1; die();}

        }
        echo 0;
    }

    public function actionUpdateIdentificationDetails($id) {
        $model = $this->loadModel($id);
        $model->setscenario('updateIdentification');
        if ($model) {
            $model->attributes = Yii::app()->request->getPost('Visitor');
            if (!$model->save(false)) {
                echo 0; Yii::app()->end();
            }
        }
        echo 1;
		//echo 1;
		//echo "<pre>";
		//print_r(Yii::app()->request->getPost('Visitor'));
		//echo "</pre>";
		Yii::app()->end();
        
    }

    public function actionCheckAsicEscort() {
        $existed = Visitor::model()->findAllByAttributes([
            'email' => $_POST['emailEscort'],
        ]);
        if (count($existed)> 0) {
            echo 'existed';
        } else {
            echo 'ok';
        }
    }

    public function actionGetAsicEscort()
    {
        if (isset($_GET['searchInfo'])) {
            $searchInfo = $_GET['searchInfo'];
            $merge = new CDbCriteria;
            $conditionString = "(profile_type = 'VIC' OR profile_type = 'ASIC') AND (CONCAT(first_name,' ',last_name) like '%" . $searchInfo
                . "%' or first_name like '%" . $searchInfo
                . "%' or last_name like '%" . $searchInfo
                . "%' or email like '%" . $searchInfo
                . "%')";
            $merge->addCondition($conditionString);

            $model = new Visitor('search');
            $model->unsetAttributes();

            return $this->renderPartial('findAsicEscort', array(
                'merge' => $merge,
                'model' => $model,
            ),false,true);
        }
    }
    /**
     * Redirect after Add Visitor or Update Visitor On Role Based
     * 
     * @param type $model
     */
    private function redirectAddUpdateRoleBased($queryString) {
        $userRole = Yii::app()->user->role;
        //because of https://ids-jira.atlassian.net/browse/CAVMS-1147
        if( in_array($userRole, [7,8,12,14]) ) 
        {
            Yii::app()->user->setFlash('success','Profile has been saved successfully');
            $this->redirect(array("visit/view"));
        } elseif ( $userRole == 9 ) {
             $this->redirect(array("visit/view"));
        } else {
             $this->redirect( array("visitor/admin&".$queryString) );
        }
    }
}
