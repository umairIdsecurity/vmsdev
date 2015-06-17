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
                'actions' => array('csvSampleDownload','importVisitHistory', 'AddVisitor', 'ajaxCrop', 'create', 'GetIdOfUser','GetHostDetails', 'GetPatientDetails', 'CheckEmailIfUnique', 'GetVisitorDetails', 'FindVisitor', 'FindHost', 'GetTenantAgentWithSameTenant', 'GetCompanyWithSameTenant', 'GetCompanyWithSameTenantAndTenantAgent'),
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
        $session = new CHttpSession;
        $model = new Visitor;
        $userModel = new User();
        $patientModel = new Patient();
        $reasonModel = new VisitReason();
        $visitModel = new Visit();

        $visitorService = new VisitorServiceImpl();

        if (isset($_POST['Visitor'])) {
            $model->attributes = $_POST['Visitor'];

            if (isset($_POST['VisitCardType']) && $_POST['VisitCardType'] > CardType::CONTRACTOR_VISITOR) {
                if (isset($_POST['Visitor']['visitor_card_status']) && $_POST['Visitor']['visitor_card_status'] != Visitor::ASIC_ISSUED) {
                    $model->profile_type = Visitor::PROFILE_TYPE_VIC;
                } else {
                    $model->profile_type = Visitor::PROFILE_TYPE_ASIC;
                }
            }

            //check validate for LOG VISIT PROCESS
            if (isset($_REQUEST['view']) && $_REQUEST['view'] == 1) {
                $model->scenario = 'vic_log_process';
            }

            if ($visitorService->save($model, $_POST['Visitor']['reason'], $session['id'])) {
                Yii::app()->end();
            } else { //todo: for debugging
                print_r($model->errors);
                die("--DONE--");
            }
        }

        $this->render('create', array(
            'model' => $model,
            'userModel' => $userModel,
            'patientModel' => $patientModel,
            'reasonModel' => $reasonModel,
            'visitModel' => $visitModel,
		), false, true);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $visitorService = new VisitorServiceImpl();
        $session = new CHttpSession;
        // if view value is 1 do not redirect page else redirect to admin
        $isViewedFromModal = 0;
        if (isset($_GET['view'])) {
            $isViewedFromModal = 1;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Visitor'])) {
            $currentCardStatus = $model->visitor_card_status;
            $model->attributes = $_POST['Visitor'];
            if ($visitorService->save($model, NULL, $session['id'])) {
                if ($currentCardStatus == 2 && $_POST['Visitor']['visitor_card_status'] == 3) {
                    if (Yii::app()->user->role == 1 || Yii::app()->user->role == 5) {
                        if ($model->totalVisit > 0) {
                            $resetHistory = new ResetHistory();
                            $resetHistory->visitor_id = $model->id;
                            $resetHistory->reset_time = date("Y-m-d H:i:s");
                            $resetHistory->reason = 'Update Visitor Card Type form VIC Holder to ASIC Pending';

                            if ($resetHistory->save()) {
                                $activeVisit = $model->activeVisits;
                                foreach ($activeVisit as $item) {
                                    $item->reset_id = $resetHistory->id;
                                    $item->save();
                                    if ($item->save()) {
                                    }
                                }
                            }
                        }
                    }
                }
                switch ($isViewedFromModal) {
                    case "1":
                        break;

                    default:
                        $this->redirect(array('admin'));
                }

            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
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
        $model = new Visitor('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visitor']))
            $model->attributes = $_GET['Visitor'];

        $this->render('_admin', array(
            'model' => $model,
                ), false, false);
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

    public function actionFindVisitor($id,$tenant,$tenant_agent, $cardType=0) {
        $this->layout = '//layouts/column1';
        $model = new Visitor('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visitor']))
            $model->attributes = $_GET['Visitor'];

        $this->renderPartial('findVisitor', array(
            'model' => $model,
                ), false, true);
    }

    public function actionFindHost($id,$tenant,$tenant_agent, $cardType) {
        $this->layout = '//layouts/column1';
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->renderPartial('findHost', array(
            'model' => $model, 'cardType' => $cardType
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

    public function actionCheckEmailIfUnique($id) {
        if (Visitor::model()->isEmailAddressTaken($id)) {
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

        $src = $_REQUEST['imageUrl'];
        $img_r = imageCreateFromAny($src);
        $dst_r = imagecreatetruecolor(200, 200);
        $usernameHash = hash('adler32', "visitor");
        $uniqueFileName = 'visitor' . $usernameHash . '-' . time() . ".png";
        imagecopyresampled($dst_r, $img_r, 0, 0, $_REQUEST['x1'], $_REQUEST['y1'], 200, 200, $_REQUEST['width'], $_REQUEST['height']);
        if (file_exists($src)) {
            unlink($src);
        }
        header('Content-type: image/jpeg');
        imagejpeg($dst_r, "uploads/visitor/" . $uniqueFileName, $jpeg_quality);


        Photo::model()->updateByPk($_REQUEST['photoId'], array(
            'unique_filename' => $uniqueFileName,
            'relative_path' => "uploads/visitor/" . $uniqueFileName,
        ));


        exit;
        return true;
    }

    public function actionAddVisitor() {
        
        $model = new Visitor;
        $visitorService = new VisitorServiceImpl();
        $session = new CHttpSession;
		
        if (isset($_POST['Visitor'])) {
            $model->profile_type = $_POST['Visitor']['profile_type'];
            $model->attributes = $_POST['Visitor'];
            
            if (empty($model->visitor_workstation)) {
                $model->visitor_workstation = $session['workstation'];
            }
            

            if ($result = $visitorService->save($model, NULL, $session['id'])) {
                
                if(!empty($model->password_requirement)){
                    
                    $passwordRequire= intval($model->password_requirement);
                    
                    if($passwordRequire == 2){
                        
                        $loggedUserEmail = Yii::app()->user->email;

                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                        $headers .= "From: ".$loggedUserEmail."\r\nReply-To: ".$loggedUserEmail;

                        $to=$model->email;

                        $subject="Preregistration email notification";

                        $body = "<html><body>Hi,<br><br>".
                                "This is preregistration email.<br><br>".
                                "Please click on the below URL:<br>".
                                "http://vmsprdev.identitysecurity.info/index.php/preregistration<br>";
                        
                        if(!empty($model->password_option)){
                            $passwordCreate= intval($model->password_option);
                            if($passwordCreate == 1){
                                $body .= "Password: ".$_POST['Visitor']['password']."<br>";
                            }
                        }
                        $body .="<br>"."Thanks,"."<br>Admin</body></html>";
                        mail($to, $subject, $body, $headers);
                    }
                }
                
            	Yii::app()->end();
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
                        "`imported_by` = :user_id",
                        array(':user_id' => Yii::app()->user->id)
                    );
                    
                    // Read and save in ImportVisitor
                    $csvFile = CUploadedFile::getInstance($model,'file');  
                    $tempLoc = $csvFile->getTempName();
                    $handle = fopen($tempLoc, "r");
                    $i = 1; $duplicates = false;
                    
                    while( $line = fgetcsv($handle, 2000) ){
                        
                        if( !isset($line[12]))
                           $this->redirect(array("visitor/importVisitHistory"));
                        //Dont insert first row as it will be title
                        if($i == 1) {
                           $i++; continue;
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
                            $visitorInfo->visitor_type= '2'; 
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
                                $visitInfo->visitor_type = '2'; // Corporate
                                $visitInfo->visitor_status = 1;
                                $visitInfo->card = $card ? $card->id:"";
                                $visitInfo->host = Yii::app()->user->id;
                                $visitInfo->created_by = Yii::app()->user->id;
                                $visitInfo->date_check_in  = date("Y-m-d", strtotime($line[3]) );
                                $visitInfo->time_check_in = $line[4];
                                $visitInfo->time_check_out = $line[6];
                                $visitInfo->date_check_out = date("Y-m-d", strtotime($line[5]) );
                                $visitInfo->visit_status = 3; //Closed visit History
                                $visitInfo->workstation = $session['workstation'];                               
                                $visitInfo->tenant = Yii::app()->user->tenant;
                                $visitInfo->reason = '1';
                                $visitInfo->visitor_type = '2';
                    
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
}
