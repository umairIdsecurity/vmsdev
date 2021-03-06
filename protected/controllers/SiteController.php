<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public $layout = '//layouts/noheaderLayout';

    /**
     * @return array action filters
     */
    public function filters()
    {
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
    public function accessRules()
    {
        return array(
            array('allow', // allow user to perform all actions
                'actions'=>array('captcha', 'page', 'index', 'error', 'contact', 'login', 'logout', 'forgot', 'reset', 'upload', 'shutdown'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'selectWorkstation' actions
                'actions'=>array('selectWorkstation'),
                'users'=>array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }
    


    public function actionIndex() {

        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'


        if(isset(Yii::app()->params['on_premises_airport_code'])) {

            $airportCode= Yii::app()->params['on_premises_airport_code'];
            $tenantCompany = Company::model()->find("code='" . $airportCode . "' and company_type=1 and is_deleted=0");

            if($tenantCompany!=null){
                $session['tenant'] = $tenantCompany->id;
            } else {
                $session['tenant'] = 1;
            }
        }


        if( (isset($_SERVER['HTTP_HOST']) && substr($_SERVER['HTTP_HOST'],0,5) =='vmspr' ) ||
            (isset($_SERVER["HTTP_APPLICATION_ENV"]) && $_SERVER["HTTP_APPLICATION_ENV"]=='prereg') )
        {

            $this->redirect('index.php/preregistration');

        }
        else{
            $id = Yii::app()->session['id'];
            $role = Yii::app()->session['role'];
            if ($id && $role):
                switch ($role) {
                    case Roles::ROLE_AGENT_OPERATOR:
                    case Roles::ROLE_OPERATOR:
                            $this->redirect('index.php?r=site/selectworkstation&id=' . $id);
                        break;
                    case Roles::ROLE_STAFFMEMBER:
                        $this->redirect('index.php?r=dashboard/viewmyvisitors');
                        break;
                    case Roles::ROLE_ADMIN:
                    case Roles::ROLE_ISSUING_BODY_ADMIN: // issuing_body_admin is admin with VIC
                        $this->redirect('index.php?r=site/selectworkstation&id=' . $id);
                        break;
                    case Roles::ROLE_AGENT_ADMIN:
                        $this->redirect('index.php?r=dashboard/admindashboard');
                        break;
                    default:
                        $this->redirect('index.php?r=dashboard');
                }
            endif;
            $this->redirect('index.php?r=site/login');

        }


    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        $this->layout = '//layouts/column2';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = $model->name;
                $subject = $model->subject;
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/plain; charset=UTF-8";

                EmailTransport::mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }



    /**
     * Displays the login page
     */
    public function actionLogin() {

        Yii::app()->session->destroy();

        $session = new CHttpSession();
        $model = new LoginForm;


        if(isset(Yii::app()->params['on_premises_airport_code'])) {

            $airportCode= Yii::app()->params['on_premises_airport_code'];

            $tenantCompany = Company::model()->find("code='" . $airportCode . "' and company_type=1 and is_deleted=0");

            if($tenantCompany!=null){
                $session['tenant'] = $tenantCompany->id;
                $model->tenant = $tenantCompany->id;
                Yii::app()->request->cookies['tenant_selection'] = new CHttpCookie('tenant_selection', $tenantCompany->id);
            } else {
                $session['tenant'] = 1;
                $model['tenant'] = 1;
            }
        }


        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            
            $model->attributes = $_POST['LoginForm'];
            if(isset($session['tenant']) && $model->tenant==''){
                $model->tenant = $session['tenant'];
            }

            // set a cookie based on the selection
            Yii::app()->request->cookies['tenant_selection'] = new CHttpCookie('tenant_selection', $model->tenant);

            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $session = new CHttpSession;
				$this->trail_log_in();
                /***************************************************************
                 * 
                 * GETTING TIMEZONES:
                 * =================
                 * First, of browser, if empty then of user logged in
                 * and if empty, then of workstation
                 * and if empty then of the server default timezone
                 * will be available in SESSION VARIABLE named: timezone
                 * 
                 **************************************************************/
                $browserTimezone='';
                if (isset($_POST['timezone'])) {
                    $browserTimezone=$_POST['timezone'];
                }

                if(!empty($browserTimezone)){
                    $session['timezone'] = $browserTimezone;
                }
                //**************************************************************
                 
                switch ($session['role']) {
                    case Roles::ROLE_AIRPORT_OPERATOR:
                    case Roles::ROLE_AGENT_AIRPORT_ADMIN:
                    case Roles::ROLE_AGENT_AIRPORT_OPERATOR:
                        
                        $returnData=$model->checkInductions($session['id']);
                        
                        //AVMS USERS
                        if($returnData["role"]== 12 || $returnData["role"]== 13 || $returnData["role"]== 14){
                            if($returnData["success"] == false){
                                Yii::app()->user->setFlash('error', "Your Induction has expired. Please, contact ASIC Office. ");
                            }elseif($returnData["inducComplete"] == false){
                                Yii::app()->user->setFlash('error', "Access Denied! Please contact Administration to complete your induction. ");
                            }else{
                                $this->redirect('index.php?r=site/selectworkstation&id=' . $session['id']);
                            }
                        }
//                        CVMS USERS  
//                        else{
//                           if($returnData["success"] == false){
//                                Yii::app()->user->setFlash('error', "Your Induction has expired. Please, go to reception. ");
//                            }elseif($returnData["inducComplete"] == false){
//                                Yii::app()->user->setFlash('error', "Access Denied! Please contact Administration to complete your induction. ");
//                            }else{
//                                $this->redirect('index.php?r=site/selectworkstation&id=' . $session['id']);
//                            } 
//                        }
                        break;
                    case Roles::ROLE_AGENT_OPERATOR:
                    case Roles::ROLE_OPERATOR:
                        if (!($model->findWorkstations($session['id']))) {
                            Yii::app()->user->setFlash('error', "No workstations currenlty assigned to you. Please ask your administrator. ");
                        } else {
                            $this->redirect('index.php?r=site/selectworkstation&id=' . $session['id']);
                        }
                        break;
                    case Roles::ROLE_STAFFMEMBER:
                        $this->redirect('index.php?r=dashboard/viewmyvisitors');
                        break;
                    case Roles::ROLE_ADMIN:
                    case Roles::ROLE_ISSUING_BODY_ADMIN: // issuing_body_admin is admin with VIC
                        $this->redirect('index.php?r=site/selectworkstation&id=' . $session['id']);
                        break;
                    case Roles::ROLE_AGENT_ADMIN:
                        $this->redirect('index.php?r=dashboard/admindashboard');
                        break;
                    default:
                        $this->redirect('index.php?r=dashboard');
                }
            }
        }
        // display the login form
        $this->render('login', array('model' => $model)) ;
    }


    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() 
    {
        //commented below statement because of https://ids-jira.atlassian.net/browse/CAVMS-1200
        $this->audit_log_logout();		//logs the logout of the user
		$this->trail_log_out();
        Yii::app()->user->logout();
        $this->redirect('index.php?r=site/login');

    }

    public function audit_log_logout(){
        $log = new AuditLog();
        $log->action_datetime_new = date('Y-m-d H:i:s');
        $log->action = "LOGOUT FROM SYSTEM";
        $log->detail = 'ID: ' . Yii::app()->user->id;
        $log->user_email_address = (isset(Yii::app()->user->email) && Yii::app()->user->email != "") ? Yii::app()->user->email : $session['email'];
        $log->ip_address = (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != "") ? $_SERVER['REMOTE_ADDR'] : "UNKNOWN";
        $log->tenant = Yii::app()->user->tenant;
        $log->tenant_agent = Yii::app()->user->tenant_agent;
        $log->save();
    }
	  public function trail_log_in(){
       $log=new AuditTrail();
        $log->description = 'User ' . Yii::app()->user->Name . ' Logged in ';
        $log->old_value = '';
        $log->new_value = '';
        $log->action='Logged in';
        $log->model='Login';
        $log->model_id=	'';
        $log->field='N/A';
        $log->creation_date= date('Y-m-d H:i:s');
        $log->user_id=Yii::app()->user->id;
        $log->save();
    }
	  public function trail_log_out(){
       $log=new AuditTrail();
        $log->description = 'User ' . Yii::app()->user->Name . ' Logged Out ';
        $log->old_value = '';
        $log->new_value = '';
        $log->action='Logged Out';
        $log->model='Logout';
        $log->model_id=	'';
        $log->field='N/A';
        $log->creation_date= date('Y-m-d H:i:s');
        $log->user_id=Yii::app()->user->id;
        $log->save();
    }

    /**
     * Forgot password
     */
    public function actionForgot() {

        $model = new PasswordForgotForm();

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'forgot-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['PasswordForgotForm'])) {
            $model->attributes = $_POST['PasswordForgotForm'];
            if ($model->validate() && $model->restore()) {
                Yii::app()->user->setFlash('success', "Please check your email for reset password instructions");
                $this->redirect('index.php?r=site/login');
            }
        }

        $this->render('forgot', array('model' => $model));
    }

    /**
     * Reset password
     */
    public function actionReset() {

        $model = new PasswordResetForm();

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'password-reset-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        $hash = Yii::app()->request->getParam('hash');

        /** @var PasswordChangeRequest $passwordRequest */
        $passwordRequest = PasswordChangeRequest::model()->findByAttributes(array('hash' => $hash));

        if (!$passwordRequest) {
            Yii::app()->user->setFlash('error', "Reset password hash '$hash' not found. Looks like your reset password link is broken.");
        }

        if ($error = $passwordRequest->checkPasswordRequestByHash()) {
            Yii::app()->user->setFlash('error', $error);
            $this->redirect('index.php?r=site/forgot');
        }

        if (isset($_POST['PasswordResetForm'])) {
            $model->attributes = $_POST['PasswordResetForm'];
            if ($model->validate()) {
                /** @var User $user */
                $user = User::model()->findByPk($passwordRequest->user_id);
                $user->changePassword($model->password);
                $passwordRequest->markAsUsed($user);
                Yii::app()->user->setFlash('success', "Your password has been changed successfully");
                $this->redirect('index.php?r=site/login');
            }
        }

        $this->render('reset', array('model' => $model));
    }

    public function actionUpload($id) {
        $this->renderpartial('upload');
    }

    public function actionSelectWorkstation($id) {
        $row = array();
        if (isset(Yii::app()->user->role) && (Yii::app()->user->role == Roles::ROLE_ADMIN || Yii::app()->user->role == Roles::ROLE_ISSUING_BODY_ADMIN)) {
            $session = new CHttpSession;
            /*$Criteria = new CDbCriteria();
            if (isset($session['tenant']) && $session['tenant'] != NULL){
                $Criteria->condition = "tenant = " . $session['tenant'] . " AND is_deleted = 0";
                $row = Workstation::model()->findAll($Criteria);
            }*/

            $row = Yii::app()->db->createCommand()
                        ->select('w.id,w.name')
                        ->from('workstation w')
                        ->leftJoin('company c', 'c.id = w.tenant')
                        ->leftJoin('user u', 'u.company = c.id')
                        ->where("w.is_deleted = 0 and c.is_deleted = 0 and u.is_deleted = 0 and u.id ='".$session['id']."'")
                        ->order('w.id desc')
                        ->queryAll();

            /*$row = Yii::app()->db->createCommand()
                        ->select('w.id,w.name')
                        ->from('workstation w')
                        ->join('user u', 'w.tenant = u.id')
                        ->where("w.is_deleted = 0 and u.is_deleted = 0 and u.id ='".$session['id']."'")
                        ->order('w.id desc')
                        ->queryAll();*/
        } else {
            $row = Workstation::model()->findWorkstationAvailableForUser($id);
        }

        if ($row) {
            foreach ($row as $key => $value) {

                $aArray[] = array(
                    'id' => $value['id'],
                    'name' => $value['name'],
                );

            }
        } else {
            $aArray[] = array(
                'id' => '',
                'name' => '-',
            );
            /* if workstation is not available then redirect to dashboard for issuinng admin user*/
            if(Yii::app()->user->role == Roles::ROLE_ISSUING_BODY_ADMIN) {
                $this->redirect('index.php?r=dashboard/adminDashboard');
            }
            $addWorkstation = 1;
        }

        if (isset($_POST['submit']) && $_POST['userWorkstation'] != '') {
            $session = new CHttpSession;
            $session->open();
            
            $session['workstation'] = $_POST['userWorkstation'];
            
            //******************************************************************
            if(!isset($session['timezone']) || empty($session['timezone'])){
                $wokstationTimezone = Workstation::model()->with('workstationTimezones')->find('t.tenant='.Yii::App()->user->tenant.' and t.id='.$_POST['userWorkstation']);

                if(!empty($wokstationTimezone)){
                    $attributes = $wokstationTimezone->attributes;
                    $timezone=Timezone::model()->findByPk($attributes['timezone_id'])->timezone_value;
                    $session['timezone'] = $timezone;
                }else{
                    $this->checkTimezone();
                }
            }
            //******************************************************************
            //this will expire the all the ASICs of the USER just logged in based on it's TENANT 
            $this->expireASICsForLoggedUser();
            $this->redirect('index.php?r=dashboard/adminDashboard');
        }

        // display the login form
        $this->render('selectworkstation', array('workstations' => $aArray, 'addWorkstation' => isset($addWorkstation) ? $addWorkstation : 0));
    }
    
    //this will expire the all the ASICs of the USER just logged in based on it's TENANT 
    public function expireASICsForLoggedUser()
    {
        $allAsics = Visitor::model()->findAll("profile_type='ASIC' AND tenant='".Yii::app()->user->tenant."' AND is_deleted=0");
        $today = date("Y-m-d");
		//echo $days;
        foreach ($allAsics as $key => $asic) {
			$asicDate=date("Y-m-d",strtotime($asic->asic_expiry));
			$days=ceil(abs(strtotime($asicDate) - strtotime($today)) / 86400);
            if(($asic->asic_expiry != "") && (date("Y-m-d",strtotime($asic->asic_expiry)) <= $today)){
                Visitor::model()->updateByPk($asic->id,array("visitor_card_status"=>"8","profile_type"=>'VIC'));   
            }
			if(($asic->asic_expiry != "") && ($asic->email != "" && filter_var($asic->email,FILTER_VALIDATE_EMAIL)) && (date("Y-m-d",strtotime($asic->asic_expiry)) > $today) && $days==42 && date("Y-m-d",strtotime($asic->email_send_on))!=$today){
				$airport = Company::model()->findByPk(Yii::app()->user->tenant);
						$airportName = (isset($airport->name) && ($airport->name!="")) ? $airport->name:"Airport";
						$subject='Your ASIC is due to expire in 6 weeks';
						$templateParams = array(
						'email' => $asic->email,
						'Airport'=>$airportName,
						'name'=>  ucfirst($asic->first_name) . ' ' . ucfirst($asic->last_name),
						'Date'=> $asic->asic_expiry,
										);
							$emailTransport = new EmailTransport();
							Visitor::model()->updateByPk($asic->id,array("email_send_on"=>$today));
							$emailTransport->sendAsicNotification($templateParams,$asic->email, ucfirst($asic->first_name) . ' ' . ucfirst($asic->last_name),$subject );
				
			}
        }

    }

    public function checkTimezone(){
        $userTimezone = User::model()->with('userTimezones')->find('t.tenant='.Yii::App()->user->tenant.' AND t.id='.Yii::App()->user->id);
        $serverTimezone = date_default_timezone_get();
        if(!empty($userTimezone)){
            $attributes = $userTimezone->attributes;
            $timezone=$attributes['timezone_value'];
            $session['timezone'] = $timezone;
        }
        elseif(!empty($serverTimezone)){
            $session['timezone'] = $serverTimezone;
        }     
    }

    public function actionTouch(){
          if(touch(Yii::getPathOfAlias('application').'/assets')){
              echo 'Assets folder modified successfully';
          }
    }

    /**
     * @desc delete folders in assets folder
     */
    public function actionResetAssets()
    {
        $path = YiiBase::getPathOfAlias('webroot') . "/assets/*";

        $files = glob($path); // get all file names
        foreach($files as $file){ // iterate files
            Utils::RemoveDir($file);
        }
        echo "DONE";
    }

    /**
     * if System shutdown, all user except super admin, issue body admin, administrator will run this action
     */
    public function actionShutdown()
    {
        $this->render('shutdown');
    }

}
