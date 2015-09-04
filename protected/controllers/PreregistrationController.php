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
				'actions' => array('uploadProfilePhoto','forgot','index','privacyPolicy' , 'declaration' , 'Login' ,'registration','personalDetails', 'visitReason' , 'addAsic' , 'asicPass', 'error' , 'uploadPhoto','ajaxAsicSearch' , 'visitDetails' ,'success','checkEmailIfUnique','checkUserProfile','asicPrivacyPolicy','asicRegistration','companyAdminRegistration'),
				'users' => array('*'),
			),
			array('allow',
				'actions'=>array('details','logout','dashboard'),
				'users' => array('@'),
				//'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION)',
			),
			array(
                'allow',
                'actions' => array('profile','visitHistory','helpdesk'),
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

	public function actionIndex(){

		$session = new CHttpSession;

		$model = new EntryPoint();

		/*if(isset($session['workstation']) && $session['workstation']!=""){
			$model->entrypoint = $session['workstation'];
		}*/

		unset($session['workstation']);


		if(isset($_POST['EntryPoint'])){

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

	public function actionPrivacyPolicy(){
		$this->render('privacy-policy');
	}

	public function actionDeclaration(){

		$session = new CHttpSession;

		$model = new Declaration();

		if(!isset($session['workstation']) || empty($session['workstation']) || is_null($session['workstation'])){
			$this->redirect(array('preregistration/index'));
		}

		if(
			isset($session['declaration1']) && $session['declaration1'] == 1 &&
			isset($session['declaration2']) && $session['declaration2'] == 1 &&
			//isset($session['declaration3']) && $session['declaration3'] == 1 &&
			isset($session['declaration4']) && $session['declaration4'] == 1
		)
		{
			$model->declaration1 = $session['declaration1'];
			$model->declaration2 = $session['declaration2'];

			//$model->declaration3 = $session['declaration3'];
			//$model->declaration4 = $session['declaration4'];
		}

		if(isset($_POST['Declaration']))
		{

			$model->attributes=$_POST['Declaration'];
			if($model->validate())
			{
				$session['declaration1'] = $model->declaration1;
				$session['declaration2'] = $model->declaration2;

            	/*if ( isset(Yii::app()->user->id) ) {
            		$this->redirect(array('preregistration/visitReason'));
            	}
            	else
            	{*/
            		$this->redirect(array('preregistration/personalDetails'));
            	/*}*/

				
			}
		}
		$this->render('declaration' , array('model'=>$model) );

	}

	public function actionPersonalDetails()
	{

		$session = new CHttpSession;

		$model = '';

		//if he is logged in, update its data rather than create new visitor
		if(isset(Yii::app()->user->id) && !empty(Yii::app()->user->id)){
			$model = Registration::model()->findByPk(Yii::app()->user->id);
		}else{
			$model = new Registration();	
		}
		

		if(!isset($session['workstation']) || empty($session['workstation']) || is_null($session['workstation'])){
			$this->redirect(array('preregistration/index'));
		}

		$model->scenario = 'preregistration';

		$error_message = '';

		if (isset($_POST['Registration'])) {

			$model->attributes = $_POST['Registration'];
			
			//$model->profile_type = $session['account_type'];
			//$model->email 		 = $session['username'];
			//$model->password 	 = $session['password'];
			//$model->password_repeat = $session['password'];


			$model->tenant = $session['tenant'];
			$model->created_by = $session['created_by'];
			$model->visitor_workstation = $session['workstation'];

			$model->identification_country_issued = $_POST['Registration']['identification_country_issued'];
			
			if (!empty($_POST['Registration']['contact_state']))
			{
				if ($model->save(false)) 
				{
					//**********************************************
					$session['visitor_id'] = $model->id;
					$this->redirect(array('preregistration/visitReason'));
					//***********************************************
				}
				else{
					$msg = print_r($model->getErrors(),1);
					throw new CHttpException(400,'Please refresh, data not saved because: '.$msg );
				}
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

		$model = new Visit();

		$companyModel = new Company();

		$companyModel->scenario = 'preregistration';
		
		$model->scenario = 'preregistration';

		if (isset($_POST['Visit'])) 
		{

			$model->attributes    = $_POST['Visit'];

			$reasonModel = new VisitReason();
			$reasonModel->reason    = $_POST['Visit']['other_reason'];
			if($reasonModel->validate())
			{
				$reasonModel->save();
			}

			if( empty($model->visitor_type) || empty($model->reason) ){
				$model->visitor_type = null;
				$model->reason 		 = null;
			}
			elseif($_POST['Visit']['reason']=='other')
			{
				$model->reason 		 = $reasonModel->id;
			}

			$model->visitor  = $session['visitor_id'];
			
			$model->card_type = 6; //VIC 24 hour Card
			$model->created_by = $session['created_by'];
			$model->workstation  = $session['workstation'];
			$model->tenant = $session['tenant'];

			$model->visit_status  = 2; //default visit status is 2=PREREGISTER

			if($model->validate())
			{
				$model->save();
				$session['visit_id'] = $model->id;
			}

			$registrationModel = Registration::model()->findByPk($session['visitor_id']);
			$registrationModel->company = $_POST['Company']['name'];;
			$registrationModel->visitor_type = $_POST['Visit']['visitor_type'];

			if($registrationModel->save(true,array('company','visitor_type'))){

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

	public function actionRegistration()
	{
		$session = new CHttpSession;

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
						throw new CHttpException(400,'Not redirected because: '.$msg );
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

			$model->company = $_POST['Registration']['company'];
			$model->profile_type = "ASIC";
			$model->role = 10; //role is 10: Visitor/Kiosik

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
			$model->company = ( ($_POST['Registration']['company'] != null) && ( !empty($_POST['Registration']['company']) ) ) ? $_POST['Registration']['company'] : null ;
			$model->profile_type = "CORPORATE";
			$model->role = 10; //role is 10: Visitor/Kiosik

			if ($model->save(false)) 
			{
				//**********************************************
				$company = new Company();
				$company->name = $_POST['Registration']['first_name'];
                $company->contact = $_POST['Registration']['first_name'] . ' ' . $_POST['Registration']['last_name'];
                $company->email_address = $_POST['Registration']['email'];
                $company->mobile_number = $_POST['Registration']['contact_number'];
                $company->office_number = $_POST['Registration']['contact_number'];                
                /*$company->created_by_user = $session['created_by'];
                $company->tenant = $session['tenant'];*/
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
                                                'tenant'=> empty($session['tenant']) ? NULL : $session['tenant'],
                                                'user_type'=>1,
                                                'user_status'=>1,
                                                'role'=>9,
                                                //'created_by'=> empty($session['created_by']) ? NULL : $session['created_by'],
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

		$model->scenario = 'asic';

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'add-asic-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['Registration'])) {

			$model->attributes = $_POST['Registration'];

			if($_POST['Registration']['is_asic_verification']==0){
				
				$this->redirect(array('preregistration/uploadPhoto'));
			}
			else
			{
				if(!empty($model->selected_asic_id)){

					$asicModel = Registration::model()->findByPk($model->selected_asic_id);

					$session['host'] = $asicModel->id;

					$loggedUserEmail = 'Admin@perthairport.com.au';
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					$headers .= "From: ".$loggedUserEmail."\r\nReply-To: ".$loggedUserEmail;
					$to=$asicModel->email;
					$subject="Request for verification of VIC profile";
					$body = "<html><body>Hi,<br><br>".
						"VIC Holder urgently requires your Verification of their visit.<br><br>".
						"Link of the VIC profile<br>".
						"<a href=' " .Yii::app()->getBaseUrl(true)."/index.php/preregistration/login'>".Yii::app()->getBaseUrl(true)."/index.php/preregistration/login</a><br>";
					$body .="<br>"."Thanks,"."<br>Admin</body></html>";
					mail($to, $subject, $body, $headers);

				}
				else{

					if( !empty($model->email) && !empty($model->contact_number) ){

						$model->profile_type = 'ASIC';
						$model->key_string = hash('ripemd160', uniqid());

						$model->tenant = $session['tenant'];

						$model->visitor_workstation = $session['workstation'];
						$model->created_by = $session['created_by'];

						$model->role = 9; //Staff Member/Intranet

						if ($model->save(false)) {

							$session['host'] = $model->id;

							$loggedUserEmail = 'Admin@perthairport.com.au';
							$headers = "MIME-Version: 1.0" . "\r\n";
							$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
							$headers .= "From: ".$loggedUserEmail."\r\nReply-To: ".$loggedUserEmail;
							$to=$model->email;
							$subject="Request for verification of VIC profile";
							$body = "<html><body>Hi,<br><br>".
								"VIC Holder urgently requires your Verification of their visit.<br><br>".
								"Link of the VIC profile<br>".
								"<a href=' " .Yii::app()->getBaseUrl(true)."/index.php/preregistration/asicPass/?id=".$model->id."&email=".$model->email."&k_str=" .$model->key_string." '>".Yii::app()->getBaseUrl(true)."/index.php/preregistration/asicPass/?id=".$model->id."&email=".$model->email."&k_str=".$model->key_string."</a><br>";
							$body .="<br>"."Thanks,"."<br>Admin</body></html>";
							mail($to, $subject, $body, $headers);
						}
						else{
							$msg = print_r($model->getErrors(),1);
							throw new CHttpException(400,'Data not saved in for asic because: '.$msg );
						}
					}

				}

				$this->redirect(array('preregistration/uploadPhoto'));
			}

		}

		$companyModel = new Company();
		$companyModel->scenario = 'preregistrationAddComp';

		$this->render('asic-sponsor' , array('model'=>$model,'companyModel'=>$companyModel) );
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

	public function actionUploadPhoto(){

		$session = new CHttpSession;
		
		unset(Yii::app()->session['imgName']);
		if(!isset($session['workstation']) || empty($session['workstation']) || is_null($session['workstation'])){
			$this->redirect(array('preregistration/index'));
		}

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

					if($photoModel->save()){
						
						if (file_exists($fullImgSource)) {
				            unlink($fullImgSource);
				        }

						$visitorModel = Registration::model()->findByPk($session['visitor_id']);

						$visitorModel->photo = $photoModel->id;
						$visitorModel->save(true,array('photo'));
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

	public function actionVisitDetails(){

		$session = new CHttpSession;

		if(!isset($session['workstation']) || empty($session['workstation']) || is_null($session['workstation'])){
			$this->redirect(array('preregistration/index'));
		}

		$model = Visit::model()->findByPk($session['visit_id']);
		//$model = Visit::model()->findByAttributes(array('visitor'=>$session['visitor_id']));

		$model->detachBehavior('DateTimeZoneAndFormatBehavior');

		if(isset($_POST['Visit']))
		{
			/*$oClock = $_POST['Visit']['ampm'];*/
			

			$model->attributes=$_POST['Visit'];

			$model->time_in = date("H:i:s", strtotime($_POST['Visit']['time_in_hours'].":".$_POST['Visit']['time_in_minutes']));
			$model->time_out = date("H:i:s", strtotime($_POST['Visit']['time_in_hours'].":".$_POST['Visit']['time_in_minutes']. " + 24 hour"));

			$model->time_check_in = date("H:i:s", strtotime($_POST['Visit']['time_in_hours'].":".$_POST['Visit']['time_in_minutes']));
			$model->time_check_out = date("H:i:s", strtotime($_POST['Visit']['time_in_hours'].":".$_POST['Visit']['time_in_minutes']. " + 24 hour"));

			$model->date_in = date("Y-m-d", strtotime($_POST['Visit']['date_in']));
			$model->date_out = date("Y-m-d", strtotime($_POST['Visit']['date_in']. " +1 day"));

			$model->date_check_in = date("Y-m-d", strtotime($_POST['Visit']['date_in']));
			$model->date_check_out = date("Y-m-d", strtotime($_POST['Visit']['date_in']. " +1 day"));

			
			/*$model->time_in
				= $oClock == 'am' ? $model->time_in :
				date("H:i", strtotime($model->time_in . " + 12 hour"));*/

			$model->host = $session['host'];
				
			if($model->save()){
				$this->redirect(array('preregistration/success'));
			}

		}

		$this->render('visit-details' , array('model'=>$model) );
	}

	public function actionSuccess()
	{	

		$session = new CHttpSession;

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
    	$session = new CHttpSession;

    	$model = $this->loadModel($id);

        $model->scenario = 'preregistration';

    	$new_passwordErr='';$repeat_passwordErr='';$old_passwordErr = '';

    	$companyModel = Company::model()->findByPk($model->company);

    	$cond="";
    	if(isset($companyModel)){$cond=isset($_POST['Visitor'],$_POST['Company']);}else{$cond=isset($_POST['Visitor']);}

        if ($cond) 
        {	
        	$model->attributes = $_POST['Visitor'];

        	if(isset($companyModel)){$companyModel->attributes = $_POST['Company'];}

           	
            if( $_POST['Visitor']['old_password'] =="" && $_POST['Visitor']['new_password'] =="" && $_POST['Visitor']['repeat_password']=="")
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
		            if(!empty($_POST['Visitor']['visitor_type'])){
						$model->visitor_type = $_POST['Visitor']['visitor_type'];             	
		            }else{
		            	$model->visitor_type = NULL;             	
		            }

		            /*
					* This removes Integrity Constraint Issue
		            */
		            if(!empty($_POST['Visitor']['photo'])){
						$model->photo = $_POST['Visitor']['photo'];             	
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
			        	$model->password = $_POST['Visitor']['new_password'];


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

        /* Visitor Visits history */

    public function actionVisitHistory() {
    	
    	$per_page = 10;

    	$page = (isset($_GET['page']) ? $_GET['page'] : 1);  // define the variable to “LIMIT” the query

    	
        $condition = "(t.is_deleted = 0 AND v.is_deleted =0 AND c.is_deleted =0 AND v.id=".Yii::app()->user->id.")";
        

        $rawData = Yii::app()->db->createCommand()
                        ->select("t.date_in,t.date_out,v.first_name,v.last_name,c.name,vs.name as status") 
                        ->from("visit t")
                        ->join("visitor v","v.id = t.visitor")
                        ->join("visit_status vs","vs.id = t.visit_status")
                        ->leftJoin("company c","c.id = v.company")
                        ->where($condition)
                        ->queryAll();
        $item_count = count($rawData);

        $query1 = Yii::app()->db->createCommand()
                        ->select("t.date_in,t.date_out,v.first_name,v.last_name,c.name,vs.name as status") 
                        ->from("visit t")
                        ->join("visitor v","v.id = t.visitor")
                        ->join("visit_status vs","vs.id = t.visit_status")
                        ->leftJoin("company c","c.id = v.company")
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

    	$helpDeskGroupRecords = HelpDeskGroup::model()->getAllHelpDeskGroup();

    	
        $session = new CHttpSession;

        $this->render('helpdesk', array(
            'helpDeskGroupRecords' => $helpDeskGroupRecords
        ));
    	
    }

    public function loadModel($id)
    {
        $model = Visitor::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }


    //**************************************************************************************
	public function actionDashboard(){
		$this->render('dashboard');
	}

	public function actionAsicPrivacyPolicy(){
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





    public function actionUploadProfilePhoto() {

        //if (Yii::app()->request->isAjaxRequest) {
            $session = new CHttpSession;
            
            $folderKey = '/profile/';
            $output_dir = Yii::getPathOfAlias('webroot') . "/uploads" . $folderKey;

			if (!file_exists($output_dir)) {
			    mkdir($output_dir, 0777, true);
			}

			if (isset($_FILES["fileInput"])) 
			{
			    
			    $error = $_FILES["fileInput"]["error"];
			    if (!is_array($_FILES["fileInput"]["name"])) 
			    { //single file
			        $fileName = $_FILES["fileInput"]["name"];
			        $uniqueFileName = $_FILES["fileInput"]["name"] . '-' . time() . ".jpg";

			        $path = "uploads" . $folderKey . $uniqueFileName;

			        //temporay uploaded -- will be deleted after saving in DB
			        move_uploaded_file($_FILES["fileInput"]["tmp_name"], $output_dir . $uniqueFileName);
			        
			        //save in database
			        //save image in db as diretced by Geoff
			        $uploadedFile = $output_dir.$uniqueFileName;
			        $file=file_get_contents($uploadedFile);
			        $image = base64_encode($file);

			        $connection = Yii::app()->db;
			        $command = $connection->createCommand("INSERT INTO photo". "(filename, unique_filename, relative_path, db_image) VALUES ('" . $fileName . "','" . $uniqueFileName . "','" . $path . "','" . $image . "')");
			        $command->query();

			        $lastId = Yii::app()->db->lastInsertID;

			        $update = $connection->createCommand("update visitor set photo=" . $lastId . " where id=" . Yii::app()->user->id);
			        $update->query();

			        $photoModel=Photo::model()->findByPk($lastId);

			        $ret = array("photoId" =>  $lastId, "db_image" => $photoModel->db_image);

                    echo json_encode($ret);
			        //delete uploaded file from folder as inserted in DB -- directed by Geoff
			        if (file_exists($uploadedFile)) {
			            unlink($uploadedFile);
			        }
			    }

			}
			Yii::app()->end();
        //}
    }

}


