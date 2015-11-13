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
                'actions' => array('update', 'delete', 'admin', 'adminAjax', 'csvSampleDownload','getActiveVisit','getAsicEscort'),
                'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION)',
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('csvSampleDownload','importVisitHistory', 'addVisitor', 'ajaxCrop', 'create', 'GetIdOfUser','GetHostDetails',
                                    'GetPatientDetails', 'CheckEmailIfUnique', 'GetVisitorDetails', 'FindVisitor', 'FindHost', 'GetTenantAgentWithSameTenant',
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
    public function actionCreate() {
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

               if ($visitorService->save($model, $_POST['Visitor']['reason'], $session['id'])) {
                 //email sending
                if(!empty($model->password_option)){

                    $passwordRequire= intval($model->password_option);

                    if($passwordRequire == 1 && empty($model->password)){
                        $loggedUserEmail = Yii::app()->user->email;
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                        $headers .= "From: ".$loggedUserEmail."\r\nReply-To: ".$loggedUserEmail;
                        $to=$model->email;
                        $subject="Preregistration email notification";
                        $body = "<html><body>Hi,<br><br>".
                                "This is preregistration email.<br><br>".
                                "Please click on the below URL:<br>".
                                "http://vmsprdev.identitysecurity.info/index.php/preregistration/login<br>";
                        if(!empty($model->password_option)){
                            $passwordCreate= intval($model->password_option);
                            if($passwordCreate == 1){
                                $body .= "Password: ".$_POST['Visitor']['password']."<br>";
                            }
                        }
                        $body .="<br>"."Thanks,"."<br>Admin</body></html>";
                        mail($to, $subject, $body, $headers);
                    }
                    elseif ($passwordRequire == 2) {
                        User::model()->restorePassword($model->email);
                    }
                }
                
                //email sending
                // if(!empty($model->password_requirement)){
                //     $passwordRequire= intval($model->password_requirement);
                //     if($passwordRequire == 2){
                //         $loggedUserEmail = Yii::app()->user->email;
                //         $headers = "MIME-Version: 1.0" . "\r\n";
                //         $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                //         $headers .= "From: ".$loggedUserEmail."\r\nReply-To: ".$loggedUserEmail;
                //         $to=$model->email;
                //         $subject="Preregistration email notification";
                //         $body = "<html><body>Hi,<br><br>".
                //                 "This is preregistration email.<br><br>".
                //                 "Please click on the below URL:<br>".
                //                 "http://vmsprdev.identitysecurity.info/index.php/preregistration/login<br>";
                //         if(!empty($model->password_option)){
                //             $passwordCreate= intval($model->password_option);
                //             if($passwordCreate == 1){
                //                 $body .= "Password: ".$_POST['Visitor']['password']."<br>";
                //             }
                //         }
                //         $body .="<br>"."Thanks,"."<br>Admin</body></html>";
                //         mail($to, $subject, $body, $headers);
                //     }
                // }
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
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
         // For Corporate Visitor
        if( Yii::app()->request->getParam("profile_type", "CORPORATE") == "CORPORATE")  
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
                    if( $model->visitor_card_status == Visitor::VIC_ASIC_PENDING ) {
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
            if ($oldProfileType == Visitor::PROFILE_TYPE_VIC && $model->profile_type == Visitor::PROFILE_TYPE_ASIC) {
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
            if( $model->profile_type == "CORPORATE" ) {
                Yii::app()->user->setFlash('success', 'Corporate Visitor Updated Successfully!');
                // $this->redirect(array("visitor/update&id=".$id));
                $this->redirect(array('visitor/update', 'id' => $id, 'vms' => Yii::app()->request->getParam('vms')));
            }
        } else{
            $this->render('update', array(
                'model' => $model,
            ));
        }
   
    
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

    public function actionFindHost($id,$tenant,$tenant_agent, $cardType = null) {
        $this->layout = '//layouts/column1';
        $visitorType = $_GET['visitortype'];
        $searchInfo = $_GET['id'];
        $tenant = 'tenant='.Yii::app()->user->tenant.' AND ';
        if (isset($_GET['tenant_agent']) && $_GET['tenant_agent'] != '') {
            $tenant_agent = "tenant_agent=" . $_GET["tenant_agent"] . " and";
        } else {
            $tenant_agent = "";
        }

        $criteria = new CDbCriteria;

        if (isset($_GET['cardType']) && $_GET['cardType'] > CardType::CONTRACTOR_VISITOR) {
            $model = new Visitor('search');
            $model->unsetAttributes();
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
        } else {
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

    public function actionAddVisitor() {
        $model = new Visitor;
        $profile_type = Yii::app()->request->getParam("profile_type", "CORPORATE");
        // For Corporate Visitor
        if( $profile_type == "CORPORATE")  
            $this->performAjaxValidation($model);
        
        $visitorService = new VisitorServiceImpl;
        $session = new CHttpSession;
		
        if (isset($_POST['Visitor'])) {
                
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
                if(!empty($model->password_option)){

                    $passwordRequire= intval($model->password_option);

                    if($passwordRequire == 1){
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
                        mail($to, $subject, $body, $headers);
                    }
                    elseif ($passwordRequire == 2) {
                        User::model()->restorePassword($model->email);
                    }
                }

                //email sending 
                // if(!empty($model->password_requirement)){
                //     $passwordRequire= intval($model->password_requirement);
                //     if($passwordRequire == 2){
                //         $loggedUserEmail = Yii::app()->user->email;
                //         $headers = "MIME-Version: 1.0" . "\r\n";
                //         $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                //         $headers .= "From: ".$loggedUserEmail."\r\nReply-To: ".$loggedUserEmail;
                //         $to=$model->email;
                //         $subject="Preregistration email notification";
                //         $body = "<html><body>Hi,<br><br>".
                //                 "This is preregistration email.<br><br>".
                //                 "Please click on the below URL:<br>".
                //                 Yii::app()->request->baseUrl."/index.php/preregistration/login<br>";
                //         if(!empty($model->password_option)){
                //             $passwordCreate= intval($model->password_option);
                //             if($passwordCreate == 1){
                //                 $body .= "Password: ".$_POST['Visitor']['password']."<br>";
                //             }
                //         }
                //         $body .="<br>"."Thanks,"."<br>Admin</body></html>";
                //         @mail($to, $subject, $body, $headers);
                //     }
                // }
                if( $model->profile_type == "CORPORATE" ) {
                    Yii::app()->user->setFlash('success', 'Corporate Visitor Created Successfully!');
                    $this->redirect(array("visitor/admin&vms=cvms"));
                    echo '<script> window.location = "'.Yii::app()->createUrl("/visitor/admin&vms=cvms").'"; </script>';
                }
                else {
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
    public function actionImportVisitHistory() {
        
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
                    
                    while( $line = fgetcsv($handle, 2000) ){
                        
                        if( !isset($line[12]))
                           $this->redirect(array("visitor/importVisitHistory"));
                        //Dont insert first row as it will be title
                        $i = $i + 1;
                        if($i == 1) {
                           continue;
                        }

                        // Find Duplicate Visitor if any
                        $visitor = Visitor::model()->find(" ( first_name = '{$line[0]}' AND last_name = '{$line[1]}' ) OR email  = '{$line[2]}'");
                        
                        // Duplicate Visitor Found and store it now
                        if( $visitor )  {                   
                            $importVisits = new ImportVisitor; 
                            $duplicates = $importVisits->saveVisitors($line);
                    
                        } else {
                               // If not a duplicate Visitor then Add it to Visitor and Visits tables
                            $visitorInfo = new Visitor;
                            $visitorInfo->first_name = $line[0];
                            $visitorInfo->last_name  = $line[1];
                            $visitorInfo->email      = $line[2];
                            $visitorInfo->contact_number = $line[12];
                            $visitorInfo->position = $line[8];
                            $company = Company::model()->find(" name LIKE '%{$line[7]}%' OR trading_name LIKE '%{$line[7]}%' ");
                            if( $company )
                               $visitorInfo->company = $company->id;
                            else
                               $visitorInfo->company = $session['company'];
                            $visitorInfo->role = Roles::ROLE_VISITOR;
                            $visitorInfo->visitor_status = '1'; // Active
                            //$visitorInfo->visitor_type= '2';
                            //$visitorInfo->vehicle= $line[12]; 
                            $visitorInfo->created_by = Yii::app()->user->id;
                            $visitorInfo->tenant = Yii::app()->user->tenant;
                            
                            if( $visitorInfo->validate() ) 
                            {
                                $visitorInfo->save();
                                
                                //insert Card Code
                                if( !empty($line[9])) {
                                    $card = new CardGenerated;
                                    $card->card_number = $line[9];
                                    $card->date_printed = date("Y-m-d", strtotime($line[10]));
                                    $card->date_expiration = date("Y-m-d", strtotime($line[11]));
                                    $card->visitor_id = $visitorInfo->id;
                                    $card->card_status  = 1;
                                    $card->created_by = Yii::app()->user->id;
                                    $card->tenant = Yii::app()->user->tenant;
                                    $card->save();                     
                                }
                                
                                // Insert Visit Now
                                $visitInfo = new Visit;
                                $visitInfo->visitor = $visitorInfo->id;
                                $visitInfo->visitor_status = 1;
                                $visitInfo->card = isset($card) ? $card->id:"";
                                $visitInfo->host = Yii::app()->user->id;
                                $visitInfo->created_by = Yii::app()->user->id;
                                $visitInfo->date_check_in = date("Y-m-d", strtotime($line[3]));
                                $visitInfo->time_check_in = $line[4];
                                $visitInfo->time_check_out = $line[6];
                                $visitInfo->date_check_out = date("Y-m-d", strtotime($line[5]));
                                $visitInfo->visit_status = 3; //Closed visit History
                                $visitInfo->workstation = $session['workstation'];                               
                                $visitInfo->tenant = Yii::app()->user->tenant;
                                $visitInfo->reason = NULL;
                    
                                $visitInfo->save();
                            }                 
                        }
                    
                   }  
                    if( $duplicates )
                        $this->redirect(array("importVisitor/admin"));
                    else
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

        $dataProvider=new CActiveDataProvider($model, array(
            'criteria'=>$criteria,
        ));
        return $this->renderPartial('activeVisit',array('dataProvider' => $dataProvider));
    }

    /**
     * Add asic sponsor for Log Visit process
     */
    public function actionAddAsicSponsor() {
        
        // If asic sponsor existed
        if (isset($_POST['User']['email']) && !empty($_POST['User']['email'])) { 

            $userEmail = $_POST['User']['email'];

            $model = Visitor::model()->findByAttributes(array('email' => $userEmail));
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

            if (isset($userParams['asic_expiry']) && !empty($userParams['asic_expiry'])) {
                $model->asic_expiry = date('Y-m-d', strtotime($userParams['asic_expiry']));
            }

            $model->profile_type = Visitor::PROFILE_TYPE_ASIC;

            if (empty($model->visitor_workstation)) {
                $model->visitor_workstation = $session['workstation'];
            }

            if ($result = $visitorService->save($model, NULL, $session['id'])) {
                $company = Company::model()->findByPk($model->company);
                if (!empty($userParams['company']) && $company) {
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
                }
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
            if (!$model->save()) {
                echo 0; Yii::app()->end();
            }
        }
        echo 1; Yii::app()->end();
        
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
            /*$conditionString = "profile_type = 'ASIC' AND (CONCAT(first_name,' ',last_name) like '%" . $searchInfo
                . "%' or first_name like '%" . $searchInfo
                . "%' or last_name like '%" . $searchInfo
                . "%' or email like '%" . $searchInfo
                . "%')";*/
            $conditionString = "profile_type = 'VIC' OR profile_type = 'ASIC' AND (CONCAT(first_name,' ',last_name) like '%" . $searchInfo
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
}
