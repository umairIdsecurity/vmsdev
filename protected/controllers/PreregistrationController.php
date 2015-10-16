<?php

class PreregistrationController extends Controller
{

	public $layout = '';

	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete , ajaxAsicSearch', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() {
		 $session = new CHttpSession;
		return array(
			array('allow',
				'actions' => array('uploadProfilePhoto','forgot','index','privacyPolicy' , 'declaration' , 'Login' ,'registration','personalDetails', 'visitReason' , 'addAsic' , 'asicPass', 'error' , 'uploadPhoto','ajaxAsicSearch','ajaxVICHolderSearch', 'visitDetails' ,'success','checkEmailIfUnique','findAllCompanyContactsByCompany','findAllCompanyFromWorkstation','checkUserProfile','asicPrivacyPolicy','asicRegistration','companyAdminRegistration','createAsicNotificationRequestedVerifications'),
				'users' => array('*'),
			),
			array('allow',
				'actions'=>array('details','logout','dashboard'),
				'users' => array('@'),
				//'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION)',
			),
			array(
                'allow',
                'actions' => array('assignAsicholder','vicholderDeclined','declineVicholder','verifyVicholder','profile','visitHistory','helpdesk','notifications','verifications','verificationDeclarations','verifyDeclarations'),
                //'expression' => '(Yii::app()->user->id == ($_GET["id"]))',
                'users' => array('@')
            ),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	public function actionIndex()
	{
		$session = new CHttpSession;
		$session['stepTitle'] = 'PREREGISTRATION FOR VISITOR IDENTIFICATION CARD (VIC)';
		$session['step1Subtitle'] = 'Preregister for a VIC';
		unset($session['step2Subtitle']);unset($session['step3Subtitle']);unset($session['step4Subtitle']);unset($session['step5Subtitle']);
		unset($session['step6Subtitle']);unset($session['step7Subtitle']);unset($session['step8Subtitle']);
		$model = new EntryPoint();
		unset($session['workstation']);
		if(isset($_POST['EntryPoint']))
		{
			$model->attributes=$_POST['EntryPoint'];
			if($model->validate())
			{
				$workstation = Workstation::model()->findByPk($model->entrypoint);
				//these will be used to ensure the nothing left in flow
				$session['workstation'] = $workstation->id;
				$session['created_by'] = $workstation->created_by;
				$session['tenant'] = $workstation->tenant;
				$session['pre-page'] = 2;
				$this->redirect(array('preregistration/privacyPolicy'));
			}
		}

		$this->render('index',array('model'=>$model));
	}

	public function actionPrivacyPolicy()
	{
		$session = new CHttpSession;
		$session['stepTitle'] = 'VIC REQUIREMENTS';
		$session['step2Subtitle'] = ' > Requirements';
		unset($session['step3Subtitle']);unset($session['step4Subtitle']);unset($session['step5Subtitle']);
		unset($session['step6Subtitle']);unset($session['step7Subtitle']);unset($session['step8Subtitle']);

		$this->render('privacy-policy');
	}

	public function actionDeclaration()
	{
		$session = new CHttpSession;
		$session['stepTitle'] = 'DECLARATIONS';
		$session['step3Subtitle'] = ' > Declarations';
		unset($session['step4Subtitle']);unset($session['step5Subtitle']);
		unset($session['step6Subtitle']);unset($session['step7Subtitle']);unset($session['step8Subtitle']);
		if(!isset($session['workstation']) || empty($session['workstation']) || is_null($session['workstation'])){
			$this->redirect(array('preregistration/index'));
		}
		$this->render('declaration');

	}

	public function actionPersonalDetails()
	{
		$session = new CHttpSession;
		$session['stepTitle'] = 'PERSONAL INFORMATION';
		$session['step4Subtitle'] = ' > Personal Information';
		unset($session['step5Subtitle']);
		unset($session['step6Subtitle']);unset($session['step7Subtitle']);unset($session['step8Subtitle']);
		
		unset($session['vic_model']);

		$model = '';

		if(isset(Yii::app()->user->id) && !empty(Yii::app()->user->id)){
			if(isset($session['visitor_model']) && $session['visitor_model'] != ''){
				$model = $session['visitor_model'];
			}else{
				$model = Registration::model()->findByPk(Yii::app()->user->id);
			}
		}
		elseif(isset($session['visitor_model']) && $session['visitor_model'] != ''){
			$model = $session['visitor_model'];
		}
		else{
			$model = new Registration();	
		}

		if(!isset($session['workstation']) || empty($session['workstation']) || is_null($session['workstation'])){
			$this->redirect(array('preregistration/index'));
		}
		$model->scenario = 'preregistration';
		$error_message = '';
		if (isset($_POST['Registration']))
		{
			if(isset($_POST['Registration']['selected_asic_id']) && !empty($_POST['Registration']['selected_asic_id'])){
				$vic = Registration::model()->findByPk($_POST['Registration']['selected_asic_id']);
				$session['vic_model'] = $vic;
				$this->redirect(array('preregistration/visitReason'));
			}	
			$model->attributes = $_POST['Registration'];
			if($model->tenant == null || $model->tenant == ""){$model->tenant = $session['tenant'];}
			if($model->created_by == null || $model->created_by == ""){$model->created_by =  $session['created_by'];}
			if($model->visitor_workstation == null || $model->visitor_workstation == ""){$model->visitor_workstation = $session['workstation'];}
			$model->identification_country_issued = $_POST['Registration']['identification_country_issued'];
			
			if (!empty($_POST['Registration']['contact_state']))
			{
				$session['visitor_model'] = $model;
				$this->redirect(array('preregistration/visitReason'));
            } 
            else {
            	$model->contact_country = Visitor::AUSTRALIA_ID;
                $error_message = "Please select state";
            }
		}

		$preModel = new PreregLogin();
		$this->render('confirm-details' , array('model' => $model,'preModel' => $preModel,'error_message' => $error_message));
	}

	public function actionVisitReason()
	{
		$session = new CHttpSession;

		if(!isset($session['workstation']) || empty($session['workstation']) || is_null($session['workstation'])){
			$this->redirect(array('preregistration/index'));
		}

		$session['stepTitle'] = 'REASON FOR VISIT';
		$session['step5Subtitle'] = ' > Reason for Visit';
		unset($session['step6Subtitle']);unset($session['step7Subtitle']);unset($session['step8Subtitle']);

		$model = '';
		if(isset($session['visit_model']) && $session['visit_model'] != ''){
			$model = $session['visit_model'];
		}
		else
		{
			$model = new Visit();
		}
		$companyModel = new Company();
		$companyModel->scenario = 'preregistration';
		$model->scenario = 'preregistration';

		if (isset($_POST['Visit'])) 
		{
			$model->attributes    = $_POST['Visit'];
			if($_POST['Visit']['other_reason'] != ""){
				$reasonModel = new VisitReason();
				$reasonModel->reason  = $_POST['Visit']['other_reason'];
				if($reasonModel->save(false)){
					$model->reason  = $reasonModel->id;
				}
			}
			$model->card_type = 6; //VIC 24 hour Card
			$model->created_by = $session['created_by'];
			$model->workstation  = $session['workstation'];
			$model->tenant = $session['tenant'];
			$model->visit_status  = 2; //default visit status is 2=PREREGISTER
			$model->company =  $_POST['Company']['name'];

			if($model->validate())
			{
				$session['visit_model'] = $model;
				$session['company_id'] =  $_POST['Company']['name'];
				$this->redirect(array('preregistration/addAsic'));
			}
		}

		$this->render(
			'visit-reason',
			array(
				'model'=>$model ,
				'companyModel' => $companyModel
			)
		);
	}

	public function actionAddAsic(){
		$session = new CHttpSession;
		if(isset(Yii::app()->user->id,$session['account_type']) &&($session['account_type'] != "") && ($session['account_type'] == "ASIC")){
			$model = Registration::model()->findByPk(Yii::app()->user->id,"profile_type=:param",array(":param"=>"ASIC"));
		}else{
			$model = new Registration();
		}
		if(!isset($session['workstation']) || empty($session['workstation']) || is_null($session['workstation'])){
			$this->redirect(array('preregistration/index'));
		}
		$session['stepTitle'] = 'ASIC SPONSOR';
		$session['step6Subtitle'] = ' > ASIC Sponsor';
		unset($session['step7Subtitle']);unset($session['step8Subtitle']);
		unset($session['is_listed']);
		$model->scenario = 'preregistrationAsic';
		
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'add-asic-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if (isset($_POST['Registration'])) 
		{
			$model->attributes = $_POST['Registration'];
			if(!empty($model->selected_asic_id))
			{
				$asicModel = Registration::model()->findByPk($model->selected_asic_id);
				$session['host'] = $asicModel->id;
				//***************** Send Email on Request ASIC SPONSOR VERIFICATION *************
				if(isset($_POST['Registration']['is_asic_verification']) && $_POST['Registration']['is_asic_verification'] == 1)
				{
					$loggedUserEmail = 'Admin@perthairport.com.au';
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					$headers .= "From: ".$loggedUserEmail."\r\nReply-To: ".$loggedUserEmail;
					$to=$asicModel->email;
					$subject="Request for verification of VIC profile";
					$body = "<html><body>Hi,<br><br>".
						"VIC Holder urgently requires your Verification of their visit.<br><br>".
						"Link of the VIC profile<br>".
						"<a href='" .Yii::app()->getBaseUrl(true)."/index.php/preregistration/verifyVicholder?id=".$session['visit_id']."'>".Yii::app()->getBaseUrl(true)."/index.php/preregistration/verifyVicholder?id=".$session['visit_id']."</a><br>";
					$body .="<br>"."Thanks,"."<br>Admin</body></html>";
					mail($to, $subject, $body, $headers);
				}else{
					$session['is_listed'] = 0;
				}
				//*******************************************************************************
			}
			else{
				if( !empty($model->email) && !empty($model->contact_number) ){
					$model->profile_type = 'ASIC';
					$model->key_string = hash('ripemd160', uniqid());

					$model->tenant = $session['tenant'];

					$model->visitor_workstation = $session['workstation'];
					$model->created_by = $session['created_by'];
					$model->role = 9; //Staff Member/Intranet
					$model->visitor_card_status = 6; //6: Asic Issued

					if ($model->save(false)) 
					{
						$session['host'] = $model->id;
						//***************** Send Email on Request ASIC SPONSOR VERIFICATION *************
						if(isset($_POST['Registration']['is_asic_verification']) && $_POST['Registration']['is_asic_verification'] == 1)
						{
				
							$loggedUserEmail = 'Admin@perthairport.com.au';
							$headers = "MIME-Version: 1.0" . "\r\n";
							$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
							$headers .= "From: ".$loggedUserEmail."\r\nReply-To: ".$loggedUserEmail;
							$to=$model->email;
							$subject="Request for verification of VIC profile";
							$body = "<html><body>Hi,<br><br>".
								"VIC Holder urgently requires your Verification of their visit.<br><br>".
								"Link of the VIC profile<br>".
								//"<a href=' " .Yii::app()->getBaseUrl(true)."/index.php/preregistration/asicPass/?id=".$model->id."&email=".$model->email."&k_str=" .$model->key_string." '>".Yii::app()->getBaseUrl(true)."/index.php/preregistration/asicPass/?id=".$model->id."&email=".$model->email."&k_str=".$model->key_string."</a><br>";
								"<a href='" .Yii::app()->getBaseUrl(true)."/index.php/preregistration/verifyVicholder?id=".$session['visit_id']."'>".Yii::app()->getBaseUrl(true)."/index.php/preregistration/verifyVicholder?id=".$session['visit_id']."</a><br>";
							$body .="<br>"."Thanks,"."<br>Admin</body></html>";
							mail($to, $subject, $body, $headers);
						}
						else{
							$session['is_listed'] = 0;
						}
						//*******************************************************************************
					}
					else{
						$msg = print_r($model->getErrors(),1);
						throw new CHttpException(400,'Data not saved in for asic because: '.$msg );
					}
				}
			}
			$this->redirect(array('preregistration/uploadPhoto'));
		}
		$companyModel = new Company();
		$companyModel->scenario = 'preregistrationAddComp';

		$this->render('asic-sponsor' , array('model'=>$model,'companyModel'=>$companyModel) );
	}

	public function actionUploadPhoto()
	{
		$session = new CHttpSession;
		unset(Yii::app()->session['imgName']);
		if(!isset($session['workstation']) || empty($session['workstation']) || is_null($session['workstation'])){
			$this->redirect(array('preregistration/index'));
		}
		$session['stepTitle'] = 'PHOTO';
		$session['step7Subtitle'] = ' > Photo';
		unset($session['step8Subtitle']);
		$model = new UploadForm();
		if(isset($_POST['UploadForm']))
		{
			$model->attributes=$_POST['UploadForm'];
			$name  = $_FILES['UploadForm']['name']['image'];
			if(!empty($name)){
				$ext  = pathinfo($name, PATHINFO_EXTENSION);
				$newNameHash = hash('adler32', time());
				$newName    = $newNameHash.'-' . time().'.'.$ext;
				$model->image=CUploadedFile::getInstance($model,'image');
				$fullImgSource = Yii::getPathOfAlias('webroot').'/uploads/visitor/'.$newName;
				$relativeImgSrc = 'uploads/visitor/'.$newName;
				if($model->image->saveAs($fullImgSource)){
					$photoModel = new Photo();
					$photoModel->filename = $name;
					$photoModel->unique_filename = $newName;
					$photoModel->relative_path = $relativeImgSrc;
			        $file=file_get_contents($fullImgSource);
			        $image = base64_encode($file);
			        $photoModel->db_image = $image;
					if($photoModel->save())
					{
						if (file_exists($fullImgSource)) {
				            unlink($fullImgSource);
				        }

						//$visitorModel = Registration::model()->findByPk($session['visitor_id']);
				        //$visitorModel->photo = $photoModel->id;
				        //$visitorModel->save(true,array('photo'));

				        $session['photo'] = $photoModel->id;

						$session['imgName'] = $newName;
						$this->redirect(array('preregistration/visitDetails'));
					}
				}
			}
			else{
				$this->redirect(array('preregistration/visitDetails'));
			}

		}

		$this->render('upload-photo',array('model'=>$model) );
	}

	public function actionVisitDetails()
	{
		$session = new CHttpSession;
		if(!isset($session['workstation']) || empty($session['workstation']) || is_null($session['workstation'])){
			$this->redirect(array('preregistration/index'));
		}
		$session['stepTitle'] = 'LOG VISIT DETAILS';
		$session['step8Subtitle'] = ' > Log Visit Details';

		$sessionVisitor = (isset($session['visitor_model']) && ($session['visitor_model'] != "")) ? $session['visitor_model'] : $session['vic_model'];
		$visitor='';

		if(isset(Yii::app()->user->id) && !empty(Yii::app()->user->id))
		{
			if(isset($session['vic_model']) && $session['vic_model'] != ''){
				$visitor = Registration::model()->findByPk($session['vic_model']->attributes['id']);
			}else{
				$visitor = Registration::model()->findByPk(Yii::app()->user->id);
			}
		}
		else{
			$visitor = new Registration();	
		}

		$sessionVisit = $session['visit_model'];
		$model = new Visit();

		$model->detachBehavior('DateTimeZoneAndFormatBehavior');

		if(isset($_POST['Visit']))
		{
			$model->attributes = $sessionVisit->attributes;
			$model->time_in = date("H:i:s", strtotime($_POST['Visit']['time_in_hours'].":".$_POST['Visit']['time_in_minutes']));
			$model->time_out = date("H:i:s", strtotime($_POST['Visit']['time_in_hours'].":".$_POST['Visit']['time_in_minutes']. " + 24 hour"));
			$model->time_check_in = date("H:i:s", strtotime($_POST['Visit']['time_in_hours'].":".$_POST['Visit']['time_in_minutes']));
			$model->time_check_out = date("H:i:s", strtotime($_POST['Visit']['time_in_hours'].":".$_POST['Visit']['time_in_minutes']. " + 24 hour"));
			$model->date_in = $_POST['Visit']['date_in'] == "" ? date("Y-m-d",strtotime("+1 day")) : date("Y-m-d", strtotime($_POST['Visit']['date_in']));
			$model->date_out = date("Y-m-d", strtotime($model->date_in." +1 day"));
			$model->date_check_in = $_POST['Visit']['date_in'] == "" ? date("Y-m-d",strtotime("+1 day")) : date("Y-m-d", strtotime($_POST['Visit']['date_in']));
			$model->date_check_out = date("Y-m-d", strtotime($model->date_check_in." +1 day"));
			$model->host = $session['host'];
			$model->company = $sessionVisit->attributes['company']; 
			if(isset($session['is_listed']) && $session['is_listed'] == 0){
				$model->is_listed = $session['is_listed'];
			}

			$visitor->attributes=$sessionVisitor->attributes;

			if(!isset($session['vic_model']) || $session['vic_model'] == ''){
				$visitor->photo=$session['photo'];
			}
			
			if($visitor->company == null || $visitor->company == ""){
				$visitor->company = $sessionVisit->attributes['company'];
			}
			if($visitor->visitor_type == null || $visitor->visitor_type == ""){
				$visitor->visitor_type = $sessionVisit->attributes['visitor_type'];
			}

			if($visitor->save(false))
			{
				$model->visitor =  $visitor->id;
				$session['visitor_id'] = $visitor->id;

				if($visitor->profile_type == "VIC"){
					$this->createVicNotificationIdentificationExpiry();
				}
				elseif($visitor->profile_type == "ASIC"){
					$this->createAsicNotificationAsicExpiry();
				}

				if($model->save())
				{	
					unset($session['visitor_model']);unset($session['visit_model']);unset($session['vic_model']);
					if($session['account_type'] == 'VIC')
					{
						$this->createVicNotificationPreregisterVisit($model->date_check_in);
						$this->createVicNotification20and28Visits();
					}
					elseif ($session['account_type'] == 'CORPORATE') {
						$this->createCompAdminNotificationPreregisterVisit($session['company_id'],$model->date_check_in);
						$this->createCompAdminNotification20and28Visits($session['company_id']);
					}

					$asicModel = Registration::model()->findByPk($model->host);
					$asicId=$asicModel->id;
					$this->actionCreateAsicNotificationRequestedVerifications($asicId,$model->id);

					$this->redirect(array('preregistration/success'));
				}
			}else{
				$msg = print_r($visitor->getErrors(),1);
				throw new CHttpException(400,'Error in visitor saving because: '.$msg );
			}
		}
		$this->render('visit-details' , array('model'=>$model) );
	}

	public function actionRegistration()
	{

		$session = new CHttpSession;

		$session['stepTitle'] = 'CREATE AVMS LOGIN';

		$session['step1Subtitle'] = 'Create Login';
		unset($session['step2Subtitle']);unset($session['step3Subtitle']);unset($session['step4Subtitle']);unset($session['step5Subtitle']);
		unset($session['step6Subtitle']);unset($session['step7Subtitle']);unset($session['step8Subtitle']);

		$model = new CreateLogin();

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'preregistration-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['CreateLogin'])) 
		{
			$model->attributes = $_POST['CreateLogin'];

			$session['account_type'] = $model->account_type; $session['username'] = $model->username; $session['password'] = $model->password;

			if($model->account_type == "VIC")
			{	
				$userModel = '';
				if(isset($session['visitor_id']) && $session['visitor_id'] != "")
				{
					$userModel = Registration::model()->findByPk($session['visitor_id']);
				}
				else
				{
					$userModel = new Registration();
				}

				$userModel->email = $model->username;
				$userModel->password = User::model()->hashPassword($model->password);
				
				$userModel->profile_type = "VIC";
				$userModel->role = 10; //role is 10: Visitor/Kiosik
				$userModel->visitor_card_status = 2; //visitor card status is 2: VIC holder

				
				if ($userModel->save(false)) 
				{
					//**********************************************
					$loginModel = new PreregLogin();

					$loginModel->username = $userModel->email;
					$loginModel->password = $model->password;

					if ($loginModel->validate() && $loginModel->login())
					{
						$this->redirect(array('preregistration/dashboard'));
					}
					else
					{
						$msg = print_r($loginModel->getErrors(),1);
						throw new CHttpException(400,'Not logged in because: '.$msg );
					}
					//***********************************************
				}
				else{
					$msg = print_r($model->getErrors(),1);
					throw new CHttpException(400,'Data not saved because: '.$msg );
				}

			}
			elseif ($model->account_type == "ASIC") 
			{
				$this->redirect(array('preregistration/asicPrivacyPolicy'));
			}
			else
			{
				$this->redirect(array('preregistration/companyAdminRegistration'));

			}


			$this->redirect(array('preregistration/personalDetails'));

		}

		$preModel = new PreregLogin();
		$this->render('registration', array('model' => $model,'preModel' => $preModel));
	}

	public function actionAsicRegistration()
	{
		$session = new CHttpSession;

		$session['stepTitle'] = 'ASIC SPONSOR CREATE LOGIN';

		$session['step3Subtitle'] = ' > ASIC Sponsor Details';
		unset($session['step4Subtitle']);unset($session['step5Subtitle']);
		unset($session['step6Subtitle']);unset($session['step7Subtitle']);unset($session['step8Subtitle']);

		$model = '';
		if(isset($session['visitor_id']) && $session['visitor_id'] != "")
		{
			$model = Registration::model()->findByPk($session['visitor_id']);
		}
		else
		{
			$model = new Registration();
		}

		$model->scenario = "preregistrationAsic";

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'add-asic-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['Registration'])) 
		{	
			$model->attributes = $_POST['Registration'];

			$model->email = $session['username'];
			$model->password = User::model()->hashPassword($session['password']);

			$model->asic_no = $_POST['Registration']['asic_no'];
			$model->asic_expiry = $_POST['Registration']['asic_expiry'];

			if(empty($model->company) || $model->company == "" || $model->company == null){
				$model->company = $_POST['Registration']['company'];
			}
			
			if(empty($model->visitor_workstation) || $model->visitor_workstation == "" || $model->visitor_workstation == null){
				$model->visitor_workstation = $_POST['Registration']['visitor_workstation'];
			}

			if(empty($model->tenant) || $model->tenant == "" || $model->tenant == null){
				$workstation = Workstation::model()->findByPk($_POST['Registration']['visitor_workstation']);
				$model->tenant = $workstation->tenant;
			}

			$model->profile_type = "ASIC";
			$model->role = 10; //role is 10: Visitor/Kiosik
			$model->visitor_card_status = 2; //visitor card status is 2: VIC holder

			if ($model->save(false)) 
			{
				//**********************************************
				$loginModel = new PreregLogin();

				$loginModel->username = $model->email;
				$loginModel->password = $session['password'];

				if ($loginModel->validate() && $loginModel->login())
				{
					$this->redirect(array('preregistration/dashboard'));
				}
				else
				{
					$msg = print_r($loginModel->getErrors(),1);
					throw new CHttpException(400,'Not redirected because: '.$msg );
				}
				//***********************************************
			}
			else
			{
				$msg = print_r($model->getErrors(),1);
				throw new CHttpException(400,'Data not saved because: '.$msg );
			}

		}

		$companyModel = new Company();
		$companyModel->scenario = 'preregistration';

		$this->render('asic-create-login' , array('model'=>$model,'companyModel'=>$companyModel) );

	}

	public function actionCompanyAdminRegistration()
	{
		$session = new CHttpSession;

		$session['stepTitle'] = 'COMPANY INFORMATION';

		$session['step2Subtitle'] = ' > Company Information';
		unset($session['step3Subtitle']);unset($session['step4Subtitle']);unset($session['step5Subtitle']);
		unset($session['step6Subtitle']);unset($session['step7Subtitle']);unset($session['step8Subtitle']);

		$model = '';
		if(isset($session['visitor_id']) && $session['visitor_id'] != "")
		{
			$model = Registration::model()->findByPk($session['visitor_id']);
		}
		else
		{
			$model = new Registration();
		}

		$model->scenario = 'preregistrationCompanyAdmin';

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'add-companyAdmin-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['Registration'])) 
		{
			$model->attributes = $_POST['Registration'];


			
			$model->first_name = $_POST['Registration']['first_name'];
			$model->last_name = $_POST['Registration']['last_name'];
			$model->contact_number = $_POST['Registration']['contact_number'];
			$model->email = $session['username'];
			$model->password = User::model()->hashPassword($session['password']);
			

			if(empty($model->company) || $model->company == "" || $model->company == null){
				$model->company = $_POST['Registration']['company'];
			}
			
			if(empty($model->visitor_workstation) || $model->visitor_workstation == "" || $model->visitor_workstation == null){
				$model->visitor_workstation = $_POST['Registration']['visitor_workstation'];
			}

			if(empty($model->tenant) || $model->tenant == "" || $model->tenant == null){
				$workstation = Workstation::model()->findByPk($_POST['Registration']['visitor_workstation']);
				$model->tenant = $workstation->tenant;
			}

			$model->profile_type = "CORPORATE";
			$model->role = 10; //role is 10: Visitor/Kiosik
			$model->visitor_card_status = 2; //visitor card status is 2: VIC holder

			if ($model->save(false)) 
			{
				//**********************************************
				$company = new Company();
				$company->name = $_POST['Registration']['first_name'];
                $company->contact = $_POST['Registration']['first_name'] . ' ' . $_POST['Registration']['last_name'];
                $company->email_address = $_POST['Registration']['email'];
                $company->mobile_number = $_POST['Registration']['contact_number'];
                $company->office_number = $_POST['Registration']['contact_number'];                
                
                //$company->created_by_user = $session['created_by'];
                $company->tenant = $model->tenant;

               	$company->created_by_visitor  = $model->id;
                $company->company_type = 3;
                if ($company->tenant_agent == '') {$company->tenant_agent = NULL;}
                if ($company->code == '') {$company->code = strtoupper(substr($company->name, 0, 3));}
				//************6****************************************************************************************************************
                if ($company->save(false)) 
                {
                	//integrity constraint violation fix.
                    //From preregisteration set attribute from session as it was set in session 
                    //for USER because Yii:app()->user->id in preregistration has Visitor Id and not USER id.
                    //If wrong handled then it will throws Integrity Constraint Violation as foreign key 
                    //of created_by in user refers to User table and not visitor table 
                	$command = Yii::app()->db->createCommand();
					$result=$command->insert('user',array(
                    							//'id'=>it is autoincrement,
                                                'company'=>$company->id,
                                                'first_name'=>$_POST['Registration']['first_name'],
                                                'last_name'=>$_POST['Registration']['first_name'],
                                                'email'=>$_POST['Registration']['email'],
                                                'contact_number'=>$_POST['Registration']['contact_number'],
                                                'timezone_id'=>1,
                                                'photo'=>NULL,
                                                'tenant'=> $company->tenant,
                                                'user_type'=>1,
                                                'user_status'=>1,
                                                'role'=>9,
                                                //'created_by'=>$company->created_by_user
                                            ));
                }
				//****************************************************************************************************************************
				//**********************************************

				//**********************************************
				$loginModel = new PreregLogin();

				$loginModel->username = $model->email;
				$loginModel->password = $session['password'];

				if ($loginModel->validate() && $loginModel->login())
				{
					$this->redirect(array('preregistration/dashboard'));
				}
				else
				{
					$msg = print_r($loginModel->getErrors(),1);
					throw new CHttpException(400,'Not redirected because: '.$msg );
				}
				//***********************************************
			}
			else
			{
				$msg = print_r($model->getErrors(),1);
				throw new CHttpException(400,'Data not saved because: '.$msg );
			}

		}

		$companyModel = new Company();
		$companyModel->scenario = 'preregistration';

		$this->render('companyadmin-create-login' , array('model'=>$model,'companyModel'=>$companyModel) );

	}

	public function actionAjaxAsicSearch(){

		if(isset($_POST['search_value']) && !empty($_POST['search_value'])){

			$searchValue = trim($_POST['search_value']);
			$purifier = new CHtmlPurifier();
			$searchValue = $purifier->purify($searchValue);

			if (filter_var($searchValue, FILTER_VALIDATE_EMAIL)) {
				$model =  Registration::model()->findAllByAttributes(
					array(
						'email'=>$searchValue,
						'profile_type'=>'ASIC',
					)
				);
				if(!empty($model)){
					/*foreach($model as $data){
						echo '<tr>
						<th scope="row">
							<input type="radio" name="selected_asic" class="selected_asic" value="'.$data->id.'">
						</th>
						<td>'.$data->first_name.'</td>
						<td>'.$data->last_name.'</td>
						<td>'.$data->visitorStatus->name.'</td>
					</tr>';
					}*/
					foreach($model as $data){
						$companyModel = Company::model()->findByPk($data->company);
						if(!empty($companyModel)){
							$companyName = $companyModel->name;
						}
						else{
							$companyName = '-';
						}

						$dataSet[] = array('<input type="radio" name="selected_asic" class="selected_asic" value='.$data->id.'>',$data->first_name,$data->last_name,$companyName);

					}

					echo json_encode($dataSet);

				}
				else{
					echo "No Record";
				}

			}
			else{

				$connection=Yii::app()->db;
				$sql="SELECT * FROM visitor WHERE
					  (first_name LIKE '%$searchValue%' OR last_name LIKE '%$searchValue%')
					  AND profile_type = 'ASIC' AND is_deleted=0";

				$command = $connection->createCommand($sql);

				$records = $command->queryAll();

				if(!empty($records)){

					foreach($records as $data){
						//$dataSet = array();
						$companyModel = Company::model()->findByPk($data['company']);
						if(!empty($companyModel)){
							$companyName = $companyModel->name;
						}
						else{
							$companyName = '-';
						}

						$dataSet[] = array('<input type="radio" name="selected_asic" class="selected_asic" value="'.$data['id'].'">',$data['first_name'],$data['last_name'],$companyName);

					}

					echo json_encode($dataSet);
				}
				else{
					echo "No Record";
				}

			}
		}
		else{
			throw new CHttpException(400,'Unable to solve the request');
		}
	}

	public function actionAjaxVICHolderSearch(){

		if(isset($_POST['search_value']) && !empty($_POST['search_value'])){

			$searchValue = trim($_POST['search_value']);
			$purifier = new CHtmlPurifier();
			$searchValue = $purifier->purify($searchValue);

			$connection=Yii::app()->db;

			$sql = "";
			if(Yii::app()->user->account_type == "ASIC"){
				$sql="SELECT * FROM visitor WHERE
					  (first_name LIKE '%$searchValue%' OR last_name LIKE '%$searchValue%' OR email LIKE '%$searchValue%')
					  AND profile_type = 'VIC' AND is_deleted=0";
			}
			elseif (Yii::app()->user->account_type == "CORPORATE") {
				$corporateVisitor = Registration::model()->findByPk(Yii::app()->user->id);
				$compId = $corporateVisitor->company;

				$sql="SELECT * FROM visitor WHERE
					  (first_name LIKE '%$searchValue%' OR last_name LIKE '%$searchValue%' OR email LIKE '%$searchValue%')
					  AND profile_type = 'VIC' AND is_deleted=0 AND company='$compId'";
			}
			$command = $connection->createCommand($sql);
			$records = $command->queryAll();
			if(!empty($records)){
				foreach($records as $data){
					//$dataSet = array();
					$companyModel = Company::model()->findByPk($data['company']);
					if(!empty($companyModel)){
						$companyName = $companyModel->name;
					}
					else{
						$companyName = '-';
					}
					$dataSet[] = array('<input type="radio" name="selected_asic" class="selected_asic" value="'.$data['id'].'">',$data['first_name'],$data['last_name'],$companyName);
				}
				echo json_encode($dataSet);
			}
			else{
				echo "No Record";
			}
		}
		else{
			throw new CHttpException(400,'Unable to solve the request');
		}
	}


	public function createCompAdminNotificationPreregisterVisit($company_id,$date_of_visit){
		//create Company Admin Notifications: 1. VIC Holder in your company has Preregistered a Visit
		$session = new CHttpSession;
		$cond = "company=".$company_id." and profile_type='CORPORATE'";
		$companyAdmins = Registration::model()->findAll($cond);
		if($companyAdmins){
	    	$notification = new Notification();
			$notification->created_by = null;
	        $notification->date_created = date("Y-m-d");
	        $notification->subject = 'VIC Holder in your company has Preregistered a Visit';
	        $notification->message = 'VIC Holder in your company has Preregistered a Visit ('.$date_of_visit.')';
	        $notification->notification_type = 'Company Notification';
	        $notification->role_id = 10;
	        if($notification->save()){
	        	foreach ($companyAdmins as $key => $companyAdmin) {
					$notify = new UserNotification;
		            $notify->user_id = $companyAdmin->id;
		            $notify->notification_id = $notification->id;
		            $notify->has_read = 0; //Not Yet
		            $notify->save();
				}
        	}
		}
	}

	public function createCompAdminNotification20and28Visits($company_id){
		//create Company Admin Notifications: 2. VIC Holder in your company has reached their 20 day visit count
		$session = new CHttpSession;
		$cond = "company=".$company_id." and profile_type='CORPORATE'";
		$companyAdmins = Registration::model()->findAll($cond);

		if($companyAdmins){
			foreach ($companyAdmins as $key => $companyAdmin) {
				$visits = Yii::app()->db->createCommand()
                    ->select("t.id") 
                    ->from("visit t")
                    ->join("visitor v","v.id = t.visitor")
                    ->join("company c","c.id = v.company")
                    ->join("visit_status vs","vs.id = t.visit_status")
                    ->where("(vs.name='Pre-registered' AND t.is_deleted = 0 AND v.is_deleted =0 AND v.id=".$session['visitor_id'].")")
                    ->queryAll();
				$visitCount = count($visits);

				if($visitCount == 20){
					//create Company Admin Notifications: 2. You have reached a Visit Count of 20 days
					$notification = Notification::model()->findByAttributes(array('subject'=>'VIC Holder in your company has reached their 20 day visit count'));
					if($notification){
						$notify = new UserNotification;
		                $notify->user_id = $companyAdmin->id;
		                $notify->notification_id = $notification->id;
		                $notify->has_read = 0; //Not Yet
		                $notify->save();
					}else{
						$notification = new Notification();
						$notification->created_by = null;
		                $notification->date_created = date("Y-m-d");
		                $notification->subject = 'VIC Holder in your company has reached their 20 day visit count';
		                $notification->message = 'VIC Holder in your company has reached their 20 day visit count';
		                $notification->notification_type = 'Company Notification';
		                $notification->role_id = 10;
		                if($notification->save()){
		                	$notify = new UserNotification;
		                    $notify->user_id = $companyAdmin->id;
		                    $notify->notification_id = $notification->id;
		                    $notify->has_read = 0; //Not Yet
		                    $notify->save();
		                }	
					}
				}

				if($visitCount == 28){
					//create Company Admin Notifications: 3. VIC Holder in your company has reached their 28 day limit
					$notification = Notification::model()->findByAttributes(array('subject'=>'VIC Holder in your company has reached their 28 day limit'));
					if($notification){
						$notify = new UserNotification;
		                $notify->user_id = $companyAdmin->id;
		                $notify->notification_id = $notification->id;
		                $notify->has_read = 0; //Not Yet
		                $notify->save();
					}else{
						$notification = new Notification();
						$notification->created_by = null;
		                $notification->date_created = date("Y-m-d");
		                $notification->subject = 'VIC Holder in your company has reached their 28 day limit';
		                $notification->message = 'VIC Holder in your company has reached their 28 day limit';
		                $notification->notification_type = 'Company Notification';
		                $notification->role_id = 10;
		                if($notification->save()){
		                	$notify = new UserNotification;
		                    $notify->user_id = $companyAdmin->id;
		                    $notify->notification_id = $notification->id;
		                    $notify->has_read = 0; //Not Yet
		                    $notify->save();
		                }	
					}
				}

			}
		}

	}

    public function createVicNotificationPreregisterVisit($date_of_visit) {
    	//create VIC Notifications: 1. You have Preregistered a Visit
    	$session = new CHttpSession;
    	$notification = new Notification();
		$notification->created_by = null;
        $notification->date_created = date("Y-m-d");
        $notification->subject = 'You have Preregistered a Visit';
        $notification->message = 'You have Preregistered a Visit ('.$date_of_visit.')';
        $notification->notification_type = 'VIC Holder Notification';
        $notification->role_id = 10;
        if($notification->save()){
        	$notify = new UserNotification;
            $notify->user_id = $session['visitor_id'];
            $notify->notification_id = $notification->id;
            $notify->has_read = 0; //Not Yet
            $notify->save();
        }
    }

    public function createVicNotification20and28Visits() {
    	$session = new CHttpSession;
        $visits = Yii::app()->db->createCommand()
                    ->select("t.id") 
                    ->from("visit t")
                    ->join("visitor v","v.id = t.visitor")
                    ->join("visit_status vs","vs.id = t.visit_status")
                    ->where("(vs.name='Pre-registered' AND t.is_deleted = 0 AND v.is_deleted =0 AND v.id=".$session['visitor_id'].")")
                    ->queryAll();
		$visitCount = count($visits);

		if($visitCount == 20){
			//create VIC Notifications: 2. You have reached a Visit Count of 20 days
			$notification = Notification::model()->findByAttributes(array('subject'=>'You have reached a Visit Count of 20 days'));
			if($notification){
				$notify = new UserNotification;
                $notify->user_id = $session['visitor_id'];
                $notify->notification_id = $notification->id;
                $notify->has_read = 0; //Not Yet
                $notify->save();
			}else{
				$notification = new Notification();
				$notification->created_by = null;
                $notification->date_created = date("Y-m-d");
                $notification->subject = 'You have reached a Visit Count of 20 days';
                $notification->message = 'You have reached a Visit Count of 20 days';
                $notification->notification_type = 'VIC Holder Notification';
                $notification->role_id = 10;
                if($notification->save()){
                	$notify = new UserNotification;
                    $notify->user_id = $session['visitor_id'];
                    $notify->notification_id = $notification->id;
                    $notify->has_read = 0; //Not Yet
                    $notify->save();
                }	
			}
		}

		if($visitCount == 28){
			//create VIC Notifications: 3. You have reached your 28 Day Visit Count Limit
			$notification = Notification::model()->findByAttributes(array('subject'=>'You have reached your 28 Day Visit Count Limit'));
			if($notification){
				$notify = new UserNotification;
                $notify->user_id = $session['visitor_id'];
                $notify->notification_id = $notification->id;
                $notify->has_read = 0; //Not Yet
                $notify->save();
			}else{
				$notification = new Notification();
				$notification->created_by = null;
                $notification->date_created = date("Y-m-d");
                $notification->subject = 'You have reached your 28 Day Visit Count Limit';
                $notification->message = 'You have reached your 28 Day Visit Count Limit';
                $notification->notification_type = 'VIC Holder Notification';
                $notification->role_id = 10;
                if($notification->save()){
                	$notify = new UserNotification;
                    $notify->user_id = $session['visitor_id'];
                    $notify->notification_id = $notification->id;
                    $notify->has_read = 0; //Not Yet
                    $notify->save();
                }	
			}
		}
    }

   	public function createVicNotificationVerifiedYourVisit($visit)
    {
    	//create VIC Notifications: 4. ASIC Sponsor has verified your visit
    	$host = Registration::model()->findByPk($visit->host);
		$notification = new Notification();
		$notification->created_by = null;
        $notification->date_created = date("Y-m-d");
        $notification->subject = 'ASIC Sponsor has verified your visit';
        $notification->message = 'ASIC Sponsor has verified your visit (ASIC Sponsor Name: '.$host->first_name.' '.$host->last_name.' Date: '.date("d-m-Y",strtotime($visit->date_check_in)).' Time: '.$visit->time_check_in.')';
        $notification->notification_type = 'VIC Holder Notification';
        $notification->role_id = 10;
        if($notification->save()){
        	$notify = new UserNotification;
            $notify->user_id = $visit->visitor;
            $notify->notification_id = $notification->id;
            $notify->has_read = 0; //Not Yet
            $notify->save();
        }
    }

    public function createVicNotificationDeclinedYourVisit($visit)
    {
    	//create VIC Notifications: 4. ASIC Sponsor has declined your visit
    	$host = Registration::model()->findByPk($visit->host);
		$notification = new Notification();
		$notification->created_by = null;
        $notification->date_created = date("Y-m-d");
        $notification->subject = 'ASIC Sponsor has rejected your visit';
        $notification->message = 'ASIC Sponsor has rejected your visit (ASIC Sponsor Name: '.$host->first_name.' '.$host->last_name.' Date: '.date("d-m-Y",strtotime($visit->date_check_in)).' Time: '.$visit->time_check_in.')';
        $notification->notification_type = 'VIC Holder Notification';
        $notification->role_id = 10;
        if($notification->save()){
        	$notify = new UserNotification;
            $notify->user_id = $visit->visitor;
            $notify->notification_id = $notification->id;
            $notify->has_read = 0; //Not Yet
            $notify->save();
        }
    }


    public function createVicNotificationIdentificationExpiry()
    {
    	$session = new CHttpSession;
    	$visitor = '';
    	if(isset(Yii::app()->user->id) && Yii::app()->user->id != ""){
    		$visitor = Registration::model()->findByPk(Yii::app()->user->id);
    	}else{
    		$visitor = Registration::model()->findByPk($session['visitor_id']);
    	}

    	$notifications = Yii::app()->db->createCommand()
                    ->select("*") 
                    ->from("notification n")
                    ->join("user_notification u","n.id = u.notification_id")
                    ->where("u.has_read = 0 AND u.user_id = " . $visitor->id)
                    ->order("u.notification_id DESC")
                    ->queryAll();

        if(!$notifications){
	    	if($visitor->identification_document_expiry != "" && $visitor->identification_document_expiry != null){
	    		$day_before = date( 'Y-m-d', strtotime($visitor->identification_document_expiry.' -8 days' ) );
				$today = date('Y-m-d');
				
				if ( strtotime($day_before) <= strtotime($today) ){
					//create VIC Notifications: 5. Your Identification is about to expiry please update
					$notification = Notification::model()->findByAttributes(array('subject'=>'Your Identification is about to expire'));
					if($notification){
						$notify = new UserNotification;
			            $notify->user_id = $session['visitor_id'] == "" ? Yii::app()->user->id : $session['visitor_id'];
			            $notify->notification_id = $notification->id;
			            $notify->has_read = 0; //Not Yet
			            $notify->save();
					}else{
						$notification = new Notification();
						$notification->created_by = null;
			            $notification->date_created = date("Y-m-d");
			            $notification->subject = 'Your Identification is about to expire';
			            $notification->message = 'Your Identification is about to expire (Please update your Profile)';
			            $notification->notification_type = 'VIC Holder Notification';
			            $notification->role_id = 10;
			            if($notification->save()){
			            	$notify = new UserNotification;
			                $notify->user_id = $session['visitor_id'] == "" ? Yii::app()->user->id : $session['visitor_id'];
			                $notify->notification_id = $notification->id;
			                $notify->has_read = 0; //Not Yet
			                $notify->save();
			            }	
					}
				}
	    	}
	    }
    }

    public function actionCreateAsicNotificationRequestedVerifications($asicId,$visitId)
    {
    	//create VIC Notifications: 1. VIC Holder has requested ASIC Sponsor verification
		$notification = Notification::model()->findByAttributes(array('subject'=>'VIC Holder has requested ASIC Sponsor verification'));
		if($notification){
			$notify = new UserNotification;
            $notify->user_id = $asicId;
            $notify->notification_id = $notification->id;
            $notify->has_read = 0; //Not Yet
            $notify->verify_visit_id = $visitId;
            $notify->save();
		}else{
			$notification = new Notification();
			$notification->created_by = null;
            $notification->date_created = date("Y-m-d");
            $notification->subject = 'VIC Holder has requested ASIC Sponsor verification';
            $notification->message = 'VIC Holder has requested ASIC Sponsor verification';
            $notification->notification_type = 'ASIC Notification';
            $notification->role_id = 10;
            if($notification->save()){
            	$notify = new UserNotification;
                $notify->user_id = $asicId;
                $notify->notification_id = $notification->id;
                $notify->has_read = 0; //Not Yet
                $notify->verify_visit_id = $visitId;
                $notify->save();
            }	
		}
    }

    public function createAsicNotificationAssignedVicHolder($visit)
    {
    	//create VIC Notifications: 2. ASIC Sponsor has assigned you a VIC holder Verification 
		$notification = Notification::model()->findByAttributes(array('subject'=>'ASIC Sponsor has assigned you a VIC holder Verification '));
		if($notification){
			//************** EMAIL SENDING *****************************
			$loggedUserEmail = Yii::app()->user->email;
			$asic = Registration::model()->findByPk($visit->host);
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= "From: ".$loggedUserEmail."\r\nReply-To: ".$loggedUserEmail;
			$to=$asic->email;
			$subject="Request for verification of VIC profile";
			$body = "<html><body>Hi,<br><br>".
				"VIC Holder urgently requires your Verification of their visit.<br><br>".
				"Link of the VIC profile<br>".
				//"<a href=' " .Yii::app()->getBaseUrl(true)."/index.php/preregistration/asicPass/?id=".$asic->id."&email=".$asic->email."&k_str=" .$asic->key_string." '>".Yii::app()->getBaseUrl(true)."/index.php/preregistration/asicPass/?id=".$asic->id."&email=".$asic->email."&k_str=".$asic->key_string."</a><br>";
				"<a href='" .Yii::app()->getBaseUrl(true)."/index.php/preregistration/verifyVicholder?id=".$visit->id."'>".Yii::app()->getBaseUrl(true)."/index.php/preregistration/verifyVicholder?id=".$visit->id."</a><br>";
			$body .="<br>"."Thanks,"."</body></html>";
			mail($to, $subject, $body, $headers);
			//***********************************************************	
			$notify = new UserNotification;
            $notify->user_id = $visit->host;
            $notify->notification_id = $notification->id;
            $notify->has_read = 0; //Not Yet
            $notify->verify_visit_id = $visit->id;
            $notify->save();
		}else{
			$notification = new Notification();
			$notification->created_by = null;
            $notification->date_created = date("Y-m-d");
            $notification->subject = 'ASIC Sponsor has assigned you a VIC holder Verification';
            $notification->message = 'ASIC Sponsor has assigned you a VIC holder Verification';
            $notification->notification_type = 'ASIC Notification';
            $notification->role_id = 10;
            if($notification->save())
            {
            	//************** EMAIL SENDING *****************************
				$loggedUserEmail = Yii::app()->user->email;
				$asic = Registration::model()->findByPk($visit->host);
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= "From: ".$loggedUserEmail."\r\nReply-To: ".$loggedUserEmail;
				$to=$asic->email;
				$subject="Request for verification of VIC profile";
				$body = "<html><body>Hi,<br><br>".
					"VIC Holder urgently requires your Verification of their visit.<br><br>".
					"Link of the VIC profile<br>".
					//"<a href=' " .Yii::app()->getBaseUrl(true)."/index.php/preregistration/asicPass/?id=".$asic->id."&email=".$asic->email."&k_str=" .$asic->key_string." '>".Yii::app()->getBaseUrl(true)."/index.php/preregistration/asicPass/?id=".$asic->id."&email=".$asic->email."&k_str=".$asic->key_string."</a><br>";
					"<a href='" .Yii::app()->getBaseUrl(true)."/index.php/preregistration/verifyVicholder?id=".$visit->id."'>".Yii::app()->getBaseUrl(true)."/index.php/preregistration/verifyVicholder?id=".$visit->id."</a><br>";
				$body .="<br>"."Thanks,"."</body></html>";
				mail($to, $subject, $body, $headers);
				//***********************************************************
            	$notify = new UserNotification;
                $notify->user_id = $visit->host;
                $notify->notification_id = $notification->id;
                $notify->has_read = 0; //Not Yet
                $notify->verify_visit_id = $visit->id;
                $notify->save();
            }	
		}
    }

    public function createAsicNotificationAsicExpiry()
    {
    	$session = new CHttpSession;
    	$visitor = '';
    	if(isset(Yii::app()->user->id) && Yii::app()->user->id != ""){
    		$visitor = Registration::model()->findByPk(Yii::app()->user->id);
    	}else{
    		$visitor = Registration::model()->findByPk($session['visitor_id']);
    	}

    	$notifications = Yii::app()->db->createCommand()
            ->select("*") 
            ->from("notification n")
            ->join("user_notification u","n.id = u.notification_id")
            ->where("u.has_read = 0 AND u.user_id = " . $visitor->id)
            ->order("u.notification_id DESC")
            ->queryAll();

        if(!$notifications){
        	if($visitor->asic_expiry != "" && $visitor->asic_expiry != null){
	    		$day_before = date( 'Y-m-d', strtotime($visitor->asic_expiry.' -8 days' ) );
				$today = date('Y-m-d');
				
				if ( strtotime($day_before) <= strtotime($today) ){
					//create VIC Notifications: 3. Your ASIC is about to Expire
					$notification = Notification::model()->findByAttributes(array('subject'=>'Your ASIC is about to Expire'));
					if($notification){
						$notify = new UserNotification;
			            $notify->user_id = $session['visitor_id'] == "" ? Yii::app()->user->id : $session['visitor_id'];
			            $notify->notification_id = $notification->id;
			            $notify->has_read = 0; //Not Yet
			            $notify->save();
					}else{
						$notification = new Notification();
						$notification->created_by = null;
			            $notification->date_created = date("Y-m-d");
			            $notification->subject = 'Your ASIC is about to Expire';
			            $notification->message = 'Your ASIC is about to Expire (Apply for an ASIC or Update your Profile)';
			            $notification->notification_type = 'ASIC Notification';
			            $notification->role_id = 10;
			            if($notification->save()){
			            	$notify = new UserNotification;
			                $notify->user_id = $session['visitor_id'] == "" ? Yii::app()->user->id : $session['visitor_id'];
			                $notify->notification_id = $notification->id;
			                $notify->has_read = 0; //Not Yet
			                $notify->save();
			            }	
					}
				}
	    	}
	    }	
    }

	public function actionSuccess()
	{	
		$session = new CHttpSession;
		$session['stepTitle'] = 'CREATE LOGIN';
		if(!isset($session['workstation']) || empty($session['workstation']) || is_null($session['workstation'])){
			$this->redirect(array('preregistration/index'));
		}
		$model = Registration::model()->findByPk($session['visitor_id']);
		//if he has not created a login, redirect to create login
		if(!isset($model->password) || ($model->password =="") || ($model->password == null))
		{
			$this->render('success');
		}
		//if they are logged in, redirect to visit history page
		if(isset(Yii::app()->user->id) && !empty(Yii::app()->user->id)){
			$this->redirect(array('preregistration/visitHistory'));
		}
	}

	public function actionAsicPass(){
		if(
			isset($_GET['id'], $_GET['email'], $_GET['k_str']) &&
			!empty($_GET['id']) && !empty($_GET['email']) && !empty($_GET['k_str'])
		){
			$model = Registration::model()->findByPk($_GET['id']);

			$model->scenario = 'asic-pass';
			if(!empty($model)){
				if( $model->key_string === $_GET['k_str'] || $model->key_string=null){
					$model->password = '';

					if (isset($_POST['Registration'])) {

						$model->attributes = $_POST['Registration'];
						$model->key_string = null;
						if($model->save()){
							$this->redirect(array('preregistration/login'));
						}
					}

					$this->render('asic-password', array('model' => $model));
				}
				else{
					throw new CHttpException(403,'Unable to solve the request');
				}
			}
			else{
				throw new CHttpException(403,'Unable to solve the request');
			}

		}
		else{
			throw new CHttpException(400,'Unable to solve the request');
		}
	}

	public function actionLogin(){

		Yii::app()->session->destroy();

		$model = new PreregLogin();

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'prereg-login-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['PreregLogin'])) {

			$model->attributes = $_POST['PreregLogin'];

			if ($model->validate() && $model->login()) {

				$session = new CHttpSession;

				if(Yii::app()->user->account_type == "VIC"){
					$this->createVicNotificationIdentificationExpiry();
				}
				elseif(Yii::app()->user->account_type == "ASIC") {
					$this->createAsicNotificationAsicExpiry();
				}

				$this->redirect(array('preregistration/dashboard'));
			}
		}
		$this->render('prereg-login', array('model' => $model));

	}

	//**************************************************************************************
	/**
     * Forgot password
    */
    public function actionForgot() {

        $model = new PreregPasswordForgot();

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'forgot-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['PreregPasswordForgot'])) {
            $model->attributes = $_POST['PreregPasswordForgot'];
            if ($model->validate() && $model->restore()) {
                Yii::app()->user->setFlash('success', "Please check your email for reset password instructions");
                $this->redirect(array('preregistration/login'));
            }
        }

        $this->render('forgot', array('model' => $model));
    }


    public function actionProfile($id)
    {
    	$this->unsetVariablesForGui();

    	$session = new CHttpSession;

    	$model = $this->loadModel($id);

        $model->scenario = 'preregistrationPass';

    	$new_passwordErr='';$repeat_passwordErr='';$old_passwordErr = '';

    	$companyModel = Company::model()->findByPk($model->company);

    	$cond="";
    	if(isset($companyModel)){$cond=isset($_POST['Registration'],$_POST['Company']);}else{$cond=isset($_POST['Registration']);}

        if ($cond) 
        {	
        	$model->attributes = $_POST['Registration'];

        	if(isset($companyModel)){$companyModel->attributes = $_POST['Company'];}

           	
            if( $_POST['Registration']['old_password'] =="" && $_POST['Registration']['new_password'] =="" && $_POST['Registration']['repeat_password']=="")
            {	
            	//**********************************************************************************
            	//****************************************************************
					//this is because to pass the validation rules for visitor
		        	if(empty($model->visitor_card_status) || is_null($model->visitor_card_status)){
		        		$model->visitor_card_status = 1; //saved
		        	}
		            /*
					* This removes Integrity Constraint Issue
		            */
		            if(!empty($_POST['Registration']['visitor_type'])){
						$model->visitor_type = $_POST['Registration']['visitor_type'];             	
		            }else{
		            	$model->visitor_type = NULL;             	
		            }

		            /*
					* This removes Integrity Constraint Issue
		            */
		            if(!empty($_POST['Registration']['photo'])){
						$model->photo = $_POST['Registration']['photo'];             	
		            }else{
		            	$model->photo = NULL;             	
		            }

		            if(isset($companyModel)){
		            	$companyModel->created_by_visitor = $model->id;
				    	//$companyModel->mobile_number = $_POST['Company']['mobile_number'];
				    	//$companyModel->tenant = Yii::app()->user->tenant;
					}


		            $model->password_saver = "";

		            /*if($model->validate())
		            {*/
		            	if($model->save(false))
				        {
				        	if(isset($companyModel))
				        	{	
				        		/*if($companyModel->validate())
					        	{*/
					        		if ($companyModel->save(false)) 
						            {
										Yii::app()->user->setFlash('success', "Profile Updated Successfully.");
									}
									else
									{
										Yii::app()->user->setFlash('error', "Something went wrong. Please, try again.");
										$msg = print_r($companyModel->getErrors(),1);
										throw new CHttpException(400,'Data not saved in company because: '.$msg );
									}
					        	/*}
					        	else
					        	{
					        		Yii::app()->user->setFlash('error', "Something went wrong. Please, try again.");
									$msg = print_r($companyModel->getErrors(),1);
									throw new CHttpException(400,'Data not saved in company because: '.$msg );
					        	}*/

				        	}else{
				        		Yii::app()->user->setFlash('success', "Profile Updated Successfully.");
				        	}
				        }
				        else
				        {
				        	Yii::app()->user->setFlash('error', "Something went wrong. Please, try again.");
				        	$msg = print_r($model->getErrors(),1);
							throw new CHttpException(400,'Data not saved in visitor because: '.$msg );
				        }
		            /*}
		            else
		            {
		            	Yii::app()->user->setFlash('error', "Something went wrong. Please, try again.");
				        $msg = print_r($model->getErrors(),1);
						throw new CHttpException(400,'Data not saved in visitor because: '.$msg );
		            }*/
            	//**********************************************************************************
            }
            else
            {
            	//**********************************************************************************
            	if( ($model->old_password !="") && ($model->new_password=="" || $model->repeat_password=="") )
	            {
	            	if($model->new_password==""){$new_passwordErr = "Please enter new password";}else{$repeat_passwordErr = "Please enter repeat password";}	            
	            }
	            else
	            {

	            	if(crypt($model->old_password, $model->password) === $model->password) 
			        {
			        	//****************************************************************
						//this is because to pass the validation rules for visitor
			        	if(empty($model->visitor_card_status) || is_null($model->visitor_card_status)){
			        		$model->visitor_card_status = 1; //saved
			        	}

			        	/*
						* This removes Integrity Constraint Issue
			            */
			            if($model->photo == null){
							$model->photo = NULL;               	
			            }

			        	//$model->password = User::model()->hashPassword($_POST['Visitor']['new_password']);
			        	$model->password = $_POST['Registration']['new_password'];


			        	if(isset($companyModel)){
			            	$companyModel->created_by_visitor = $model->id;
					    	//$companyModel->mobile_number = $_POST['Company']['mobile_number'];
					    	//$companyModel->tenant = Yii::app()->user->tenant;
						}
					   

			            $model->password_saver = "yes";

				        /*if($model->validate())
			            {*/
			            	if($model->save(false))
					        {
					        	/*if($companyModel->validate())
					        	{*/
					        		if ($companyModel->save(false)) 
						            {
										Yii::app()->user->setFlash('success', "Profile Updated Successfully.");
									}
									else
									{
										Yii::app()->user->setFlash('error', "Something went wrong. Please, try again.");
										$msg = print_r($companyModel->getErrors(),1);
										throw new CHttpException(400,'Data not saved in company because: '.$msg );
									}
					        	/*}
					        	else
					        	{
					        		Yii::app()->user->setFlash('error', "Something went wrong. Please, try again.");
									$msg = print_r($companyModel->getErrors(),1);
									throw new CHttpException(400,'Data not saved in company because: '.$msg );
					        	}*/
					        }
					        else
					        {
					        	Yii::app()->user->setFlash('error', "Something went wrong. Please, try again.");
					        	$msg = print_r($model->getErrors(),1);
								throw new CHttpException(400,'Data not saved in visitor because: '.$msg );
					        }
			            /*}
			            else
			            {
			            	Yii::app()->user->setFlash('error', "Something went wrong. Please, try again.");
					        $msg = print_r($model->getErrors(),1);
							throw new CHttpException(400,'Data not saved in visitor because: '.$msg );
			            }*/
						//****************************************************************
					} 
					else
					{
						$old_passwordErr = "Please enter correct old password";
					}
	            }
            	//**********************************************************************************
            }
        }
    	$companyModel = Company::model()->findByPk($model->company);
        $this->render('profile', array(
            'model' => $model,
            'companyModel' => $companyModel,
            'new_passwordErr' => $new_passwordErr,
            'repeat_passwordErr' => $repeat_passwordErr,
            'old_passwordErr' => $old_passwordErr,
        ));	
    }

    /* notifications */
    public function actionNotifications()
    {
    	$this->unsetVariablesForGui();
    	Yii::app()->db->createCommand()->update("user_notification",array('has_read' => 1),"user_id = " . Yii::app()->user->id);
    	/*$notifications = Yii::app()->db->createCommand()
                    ->select("*") 
                    ->from("notification n")
                    ->join("user_notification u","n.id = u.notification_id")
                    ->where("u.user_id = " . Yii::app()->user->id)
                    ->order("u.notification_id DESC")
                    ->queryAll();*/

        $criteriaArray = array();
        $notifications = '';

        if(Yii::app()->user->account_type == "VIC")
        {
        	$criteriaArray = array('You have Preregistered a Visit','You have reached a Visit Count of 20 days','You have reached your 28 Day Visit Count Limit','ASIC Sponsor has verified your visit','ASIC Sponsor has rejected your visit','Your Identification is about to expire');
        	$notifications = $this->criteriaBasedNotifications($criteriaArray); 
    	}
    	elseif (Yii::app()->user->account_type == "ASIC") 
    	{
    		$criteriaArray = array('VIC Holder has requested ASIC Sponsor verification','ASIC Sponsor has assigned you a VIC holder Verification','Your ASIC is about to Expire');
        	$notifications = $this->criteriaBasedNotifications($criteriaArray); 
    	}
    	else
    	{
    		$criteriaArray = array('VIC Holder in your company has Preregistered a Visit','VIC Holder in your company has reached their 20 day visit count','VIC Holder in your company has reached their 28 day limit');
        	$notifications = $this->criteriaBasedNotifications($criteriaArray); 
    	}
    	$this->render('notifications',array('notifications' => $notifications ));	
    }

    public function criteriaBasedNotifications($criteriaArray)
    {
    	$notifications = array();
    	for($i=0; $i < sizeof($criteriaArray); $i++)
    	{
    		$notification = Yii::app()->db->createCommand()
                    ->select("*") 
                    ->from("notification n")
                    ->join("user_notification u","n.id = u.notification_id")
                    ->where("u.user_id = " . Yii::app()->user->id. " AND subject='".$criteriaArray[$i]."'")
                    ->order("u.notification_id DESC")
                    ->queryAll();
            array_push($notifications, $notification);        
    	}
    	return $notifications;
    }

    /* asic sponsor verifications */
    public function actionVerifications()
    {
    	$this->unsetVariablesForGui();
    	$per_page = 10;
    	$page = (isset($_GET['page']) ? $_GET['page'] : 1);  // define the variable to “LIMIT” the query
        $condition = "t.is_listed = 1 AND t.is_deleted = 0 AND v.is_deleted=0 AND t.host != 'NULL' AND t.host !=''"; 

        if(isset(Yii::app()->user->account_type) && Yii::app()->user->account_type == "ASIC"){
        	$condition .= " AND t.host=".Yii::app()->user->id;
        }else{
        	$condition .= " AND t.visitor=".Yii::app()->user->id;
        }
        $rawData = Yii::app()->db->createCommand()
                        ->select("t.id,t.date_check_in,t.host,v.first_name,v.last_name,t.visit_prereg_status") 
                        ->from("visit t")
                        ->join("visitor v","v.id = t.visitor")
                        ->where($condition)
                        ->queryAll();
        $item_count = count($rawData);
        $query1 = Yii::app()->db->createCommand()
                        ->select("t.id,t.date_check_in,t.host,v.first_name,v.last_name,t.visit_prereg_status") 
                        ->from("visit t")
                        ->join("visitor v","v.id = t.visitor")
                        ->where($condition)
                        ->order("t.id DESC")
                        ->limit($per_page,$page-1) // the trick is here!
                        ->queryAll();   

		// the pagination itself
        $pages = new CPagination($item_count);
        $pages->setPageSize($per_page);

		// render
        $this->render('visit-history-verifications',array(
            'query1'=>$query1,
            'item_count'=>$item_count,
            'page_size'=>$per_page,
            'pages'=>$pages,
        ));
    }

    public function actionVerifyVicholder($id)
    {
    	if( !isset(Yii::app()->user->account_type) || (Yii::app()->user->account_type != "ASIC") ){
			$this->redirect(array('preregistration/dashboard'));
		}

    	$this->unsetVariablesForGui();
    	$session = new CHttpSession;
    	$session['verify_visit_id'] = $id;

    	$visit = Visit::model()->findByPk($id);
    	$visitor = Registration::model()->findByPk($visit->visitor);
    	$company = Company::model()->findByPk($visitor->company);
    	$this->render('verify-vic-holder',array('visit'=>$visit,'visitor'=>$visitor,'company'=>$company));

    }	

    /* asic sponsor verifications */
    public function actionVerificationDeclarations()
    {
    	if( !isset(Yii::app()->user->account_type) || (Yii::app()->user->account_type != "ASIC") ){
			$this->redirect(array('preregistration/dashboard'));
		}
    	$this->unsetVariablesForGui();
		$this->render('verification-declarations');
    }

    public function actionVerifyDeclarations()
    {
    	if( !isset(Yii::app()->user->account_type) || (Yii::app()->user->account_type != "ASIC") ){
			$this->redirect(array('preregistration/dashboard'));
		}

    	$session = new CHttpSession;
		$visit = Visit::model()->findByPk($session['verify_visit_id']);

		$visit->visit_prereg_status = "Verified";
		$visit->asic_declaration = 1;
		$visit->asic_verification = 1;

		if($visit->save(false))
		{
			$this->createVicNotificationVerifiedYourVisit($visit);
			$this->redirect(array('preregistration/verifications'));
		}
    }


    public function actionDeclineVicholder(){
    	if( !isset(Yii::app()->user->account_type) || (Yii::app()->user->account_type != "ASIC") ){
			$this->redirect(array('preregistration/dashboard'));
		}
    	$this->render('decline-vic');
    }

    public function actionVicholderDeclined(){

    	if( !isset(Yii::app()->user->account_type) || (Yii::app()->user->account_type != "ASIC") ){
			$this->redirect(array('preregistration/dashboard'));
		}
    	$session = new CHttpSession;
    	$visit = Visit::model()->findByPk($session['verify_visit_id']);
		$visit->visit_prereg_status = "Rejected";
		$visit->asic_declaration = 0;
		$visit->asic_verification = 0;
		
		if($visit->save(false))
		{
			$this->createVicNotificationDeclinedYourVisit($visit);
			$this->redirect(array('preregistration/verifications'));
		}
    }

    public function actionAssignAsicholder()
    {
    	if( !isset(Yii::app()->user->account_type) || (Yii::app()->user->account_type != "ASIC") ){
			$this->redirect(array('preregistration/dashboard'));
		}

    	$this->unsetVariablesForGui();
    	$session = new CHttpSession;

		$model = new Registration();
		$model->scenario = 'preregistrationAsic';


		$companyModel = new Company();
		$companyModel->scenario = 'preregistration';
		

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'add-asic-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['Registration'])) 
		{
			$model->attributes = $_POST['Registration'];

			if(!empty($model->selected_asic_id))
			{
				$visit = Visit::model()->findByPk($session['verify_visit_id']);
				$visit->visit_prereg_status = "Reassigned";

				$visit->host = $model->selected_asic_id;

				if($visit->save(false))
				{
					$this->createAsicNotificationAssignedVicHolder($visit);
					$this->redirect(array('preregistration/verifications'));
				}
			}
			else
			{
				$visitor = Registration::model()->findByPk(Yii::app()->user->id);

				$model->profile_type = 'ASIC';
				$model->key_string = hash('ripemd160', uniqid());
				$model->tenant = $visitor->tenant;
				$model->visitor_workstation = $visitor->visitor_workstation; 
				$model->created_by = $visitor->created_by;
				$model->role = 9; //Staff Member/Intranet
				$model->visitor_card_status = 6; //Asic Issued

				if($model->save(false))
				{
					$visit = Visit::model()->findByPk($session['verify_visit_id']);
					$visit->visit_prereg_status = "Reassigned";
					
					$visit->host = $model->id;

					if($visit->save(false))
					{
						$this->createAsicNotificationAssignedVicHolder($visit);
						$this->redirect(array('preregistration/verifications'));
					}
				}
			}

		}
		
    	$this->render('reassign-asic',array('model'=>$model,'companyModel' => $companyModel));
    }

    /* Visitor Visits history */
    public function actionVisitHistory() {
    	$this->unsetVariablesForGui();
    	$per_page = 10;
    	$page = (isset($_GET['page']) ? $_GET['page'] : 1);  // define the variable to “LIMIT” the query
        $condition = "(t.is_deleted = 0 AND v.is_deleted =0 AND v.id=".Yii::app()->user->id.")";
        $rawData = Yii::app()->db->createCommand()
                        ->select("t.company,t.date_check_in,t.date_check_out,v.first_name,v.last_name,vs.name as status") 
                        ->from("visit t")
                        ->join("visitor v","v.id = t.visitor")
                        ->join("visit_status vs","vs.id = t.visit_status")
                        ->where($condition)
                        ->queryAll();
        $item_count = count($rawData);
		$query1 = Yii::app()->db->createCommand()
                        ->select("t.company,t.date_check_in,t.date_check_out,v.first_name,v.last_name,vs.name as status") 
                        ->from("visit t")
                        ->join("visitor v","v.id = t.visitor")
                        ->join("visit_status vs","vs.id = t.visit_status")
                        ->order("t.id DESC")
                        ->where($condition)
                        ->limit($per_page,$page-1) // the trick is here!
                        ->queryAll();   
        // the pagination itself
        $pages = new CPagination($item_count);
        $pages->setPageSize($per_page);
        // render
        $this->render('visit-history',array(
            'query1'=>$query1,
            'item_count'=>$item_count,
            'page_size'=>$per_page,
            'pages'=>$pages,
        ));
    }
    /* Help Desk history */
    public function actionHelpdesk() {
    	$this->unsetVariablesForGui();
    	$helpDeskGroupRecords = HelpDeskGroup::model()->getAllHelpDeskGroup();
        $session = new CHttpSession;
        $this->render('helpdesk', array(
            'helpDeskGroupRecords' => $helpDeskGroupRecords
        ));
    }

    public function loadModel($id)
    {
        $model = Registration::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }


    //**************************************************************************************
	public function actionDashboard(){
		$this->unsetVariablesForGui();
		$this->render('dashboard');
	}

	public function actionAsicPrivacyPolicy(){
		$session = new CHttpSession;
		$session['stepTitle'] = 'ASIC SPONSOR CREATE LOGIN';
		$session['step2Subtitle'] = ' > Privacy Policy';
		unset($session['step3Subtitle']);unset($session['step4Subtitle']);unset($session['step5Subtitle']);
		unset($session['step6Subtitle']);unset($session['step7Subtitle']);unset($session['step8Subtitle']);
		$this->render('asic-privacy-policy');
	}

	public function actionDetails(){
		echo "welcome";
		echo Yii::app()->user->id;
		print_r(Yii::app()->user);
	}

	public function actionLogout() {
		Yii::app()->user->logout();
		$this->redirect(array('preregistration/login'));
	}

	public function actionCheckEmailIfUnique() 
	{
		$email = '';
		if(isset($_POST['email'])){$email = $_POST['email'];}
		if(!empty($email))
		{
			if(Visitor::model()->findByAttributes(array("email"=>$email)))
			{
				$aArray[] = array(
		        	'isTaken' => 1,
		        );
			} 
			else
			{
				$aArray[] = array(
		        	'isTaken' => 0,
		        );
			}

			$resultMessage['data'] = $aArray;
	        echo CJavaScript::jsonEncode($resultMessage);
	        Yii::app()->end();
		}
		else
		{
			$aArray[] = array(
	        	'isTaken' => 0,
	        );
	        $resultMessage['data'] = $aArray;
	        echo CJavaScript::jsonEncode($resultMessage);
	        Yii::app()->end();
		}
    }

    public function actionCheckUserProfile() 
	{
		$firstname = '';$lastname='';$dob='';
		if(isset($_POST['firstname'])){$firstname = $_POST['firstname'];}
		if(isset($_POST['lastname'])){$lastname = $_POST['lastname'];}
		if(isset($_POST['dob'])){$dob = $_POST['dob'];}

		if(!empty($firstname) && !empty($lastname) && !empty($dob))
		{
			if(Registration::model()->findByAttributes(array("first_name"=>$firstname,"last_name"=>$lastname,"date_of_birth"=>$dob)))
			{
			  	$aArray[] = array(
	                'isTaken' => 1,
	            );
			} 
			else
			{
				$aArray[] = array(
	                'isTaken' => 0,
	            );
			}

	        $resultMessage['data'] = $aArray;
	        echo CJavaScript::jsonEncode($resultMessage);
	        Yii::app()->end();
		}
		else
		{
			$aArray[] = array(
	                'isTaken' => 0,
	            );

	        $resultMessage['data'] = $aArray;
	        echo CJavaScript::jsonEncode($resultMessage);
	        Yii::app()->end();
		}
		
    }

    public function actionFindAllCompanyContactsByCompany() {
    	if(isset($_POST['compId'])){$compId = $_POST['compId'];}
        $Criteria = new CDbCriteria();
        $Criteria->condition = "company = ".$compId." and is_deleted = 0";
        $user = User::model()->findAll($Criteria);
        
        $resultMessage['data'] = $user;
	    echo CJavaScript::jsonEncode($resultMessage);
	    Yii::app()->end();
    }

    public function actionFindAllCompanyFromWorkstation()
    {
    	if(isset($_POST['workstationId'])){$workstationId = $_POST['workstationId'];}

        $worsktation = Workstation::model()->findByPk($workstationId);

        $Criteria = new CDbCriteria();
        $Criteria->condition = "tenant = ".$worsktation->tenant." and is_deleted = 0";
        $companies = Company::model()->findAll($Criteria);

        $resultMessage['data'] = $companies;
	    echo CJavaScript::jsonEncode($resultMessage);
	    Yii::app()->end();
    }

    public function actionUploadProfilePhoto() {
        //if (Yii::app()->request->isAjaxRequest) {
            if (isset($_FILES["fileInput"])) 
			{
				//*******************************************************************************
				$name  = $_FILES["fileInput"]["name"];
				if(!empty($name)){
					$ext  = pathinfo($name, PATHINFO_EXTENSION);
					$newNameHash = hash('adler32', time());
					$newName    = $newNameHash.'-' . time().'.'.$ext;
					$fullImgSource = Yii::getPathOfAlias('webroot').'/uploads/visitor/'.$newName;
					$relativeImgSrc = 'uploads/visitor/'.$newName;
			        $fileInputInstance=CUploadedFile::getInstanceByName('fileInput');
			        if($fileInputInstance->saveAs($fullImgSource))
			        {
			        	$file=file_get_contents($fullImgSource);
					    $image = base64_encode($file);

				        $connection = Yii::app()->db;
				        $command = $connection->createCommand("INSERT INTO photo". "(filename, unique_filename, relative_path, db_image) VALUES ('" . $name . "','" . $newName . "','" . $relativeImgSrc . "','" . $image . "')");
				        $command->query();

				        $lastId = Yii::app()->db->lastInsertID;

				        $update = $connection->createCommand("update visitor set photo=" . $lastId . " where id=" . Yii::app()->user->id);
				        $update->query();

				        $photoModel=Photo::model()->findByPk($lastId);

				        $ret = array("photoId" =>  $lastId, "db_image" => $photoModel->db_image);

	                    echo json_encode($ret);
				        //delete uploaded file from folder as inserted in DB -- directed by Geoff
				        if (file_exists($fullImgSource)) {
				            unlink($fullImgSource);
				        }
			        }
				}
				//*******************************************************************************
			}
			Yii::app()->end();
        //}
    }

    public function unsetVariablesForGui(){
    	$session = new CHttpSession;
    	unset($session['stepTitle']);
		unset($session['step1Subtitle']);unset($session['step2Subtitle']);unset($session['step3Subtitle']);
		unset($session['step4Subtitle']);unset($session['step5Subtitle']);unset($session['step6Subtitle']);
		unset($session['step7Subtitle']);unset($session['step8Subtitle']);
    }

}


