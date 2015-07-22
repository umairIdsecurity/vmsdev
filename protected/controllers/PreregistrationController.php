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
		return array(
			array('allow',
				'actions' => array('index','privacyPolicy' , 'declaration' , 'Login' ,'registration','confirmDetails', 'visitReason' , 'addAsic' , 'asicPass', 'error' , 'uploadPhoto','ajaxAsicSearch' ),
				'users' => array('*'),
			),
			array('allow',
				'actions'=>array('details','logout' , 'dashboard'),
				'users' => array('@'),
				//'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION)',
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

		if(isset($session['workstation']) && $session['workstation']!=""){
			$model->entrypoint = $session['workstation'];
		}
		if(isset($_POST['EntryPoint'])){

			$model->attributes=$_POST['EntryPoint'];
			if($model->validate())
			{
				$session['workstation'] = $model->entrypoint;
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
			$model->declaration4 = $session['declaration4'];
		}



		if(isset($_POST['Declaration'])){

			$model->attributes=$_POST['Declaration'];
			if($model->validate())
			{
				$session['declaration1'] = $model->declaration1;
				$session['declaration2'] = $model->declaration2;
				//$session['declaration3'] = $model->declaration3;
				$session['declaration4'] = $model->declaration4;
				$this->redirect(array('preregistration/registration'));
			}
		}
		$this->render('declaration' , array('model'=>$model) );

	}

	public function actionRegistration(){

		$session = new CHttpSession;
		$model = new CreateLogin();

		if(
			isset($session['account_type']) && $session['account_type'] !='' &&
			isset($session['username']) 	&& $session['username']		!='' &&
			isset($session['password']) 	&& $session['password']		!=''
		){
			$model->account_type = $session['account_type'];
			$model->username     = $session['username'];
			$model->password     = $session['password'];
		}

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'preregistration-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['CreateLogin'])) {
			$model->attributes = $_POST['CreateLogin'];

			$session['account_type'] = $model->account_type;
			$session['username'] 	 = $model->username;
			$session['password']     = $model->password;

			$this->redirect(array('preregistration/confirmDetails'));

		}

		$this->render('registration', array('model' => $model));
	}

	public function actionConfirmDetails(){
		$session = new CHttpSession;

		$model = new Registration();

		$model->scenario = 'preregistration';

		if (isset($_POST['Registration'])) {
			$model->profile_type = $session['account_type'];
			$model->email 		 = $session['username'];
			$model->password 	 = $session['password'];
			$model->password_repeat 	 = $session['password'];
			$model->attributes = $_POST['Registration'];

			$model->date_of_birth = date('Y-m-d', strtotime($model->birthdayYear . '-' . $model->birthdayMonth . '-' . $model->birthdayDay));

			if ($model->save()) {
				$session['visitor_id'] = $model->id;
				$this->redirect(array('preregistration/visitReason'));
			}
			print_r($model->getErrors());

		}
		
		$this->render('confirm-details' , array('model' => $model));
	}

	public function actionVisitReason(){

		$session = new CHttpSession;

		if($session['visitor_id']=="" or $session['visitor_id']==null){
			$this->redirect(array('preregistration/registration'));
		}

		$model = new Visit();

		$companyModel = new Company();

		$companyModel->scenario = 'preregistration';

		if (isset($_POST['Visit']) && isset($_POST['Company']) ) {

			$reasonModel = new VisitReason();

			$reasonModel->reason    = $_POST['Visit']['other_reason'];
			if($reasonModel->validate())
			{
				$reasonModel->save();
			}

			$model->attributes    = $_POST['Visit'];

			if( empty($model->visitor_type) OR empty($model->reason) ){
				$model->visitor_type = null;
				$model->reason 		 = null;
			}
			elseif($_POST['Visit']['reason']=='other')
			{
				$model->reason 		 = $reasonModel->id;
			}

			$model->visitor 	  = $session['visitor_id'];

			if($model->validate())
			{
				$model->save();
			}

			$companyModel->attributes    = $_POST['Company'];

			if($companyModel->validate())
			{
				$companyModel->save();

				$registrationModel =
					Registration::model()->findByPk(
						$session['visitor_id']
					);

				$registrationModel->company = $companyModel->id;

				if($registrationModel->save(true,array('company'))){

					$this->redirect(array('preregistration/addAsic'));
				}
				print_r($registrationModel->getErrors());
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

		$model = new Registration();

		$model->scenario = 'asic';

		if (isset($_POST['Registration'])) {

			$model->attributes = $_POST['Registration'];

			if($_POST['Registration']['is_asic_verification']==0){
				$this->redirect(array('preregistration/uploadPhoto'));
			}
			else{
				if(!empty($model->selected_asic_id)){

					$asicModel =
						Registration::model()->findByPk(
							$model->selected_asic_id
						);

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

						if ($model->save()) {
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
					}

				}

				$this->redirect(array('preregistration/uploadPhoto'));
			}

		}

		$this->render('asic-sponsor' , array('model'=>$model) );
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
					foreach($model as $data){
						echo '<tr>
						<th scope="row">
							<input type="radio" name="selected_asic" class="selected_asic" value="'.$data->id.'">
						</th>
						<td>'.$data->first_name.'</td>
						<td>'.$data->last_name.'</td>
						<td>'.$data->visitorStatus->name.'</td>
					</tr>';
					}
				}
				else{
					echo "No Record";
				}

			}
			else{

				$connection=Yii::app()->db;
				$sql="SELECT * FROM `visitor` WHERE
					  (first_name LIKE '%$searchValue%' OR last_name LIKE '%$searchValue%')
					  AND profile_type = 'ASIC' ";

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

		if($session['visitor_id']=="" or $session['visitor_id']==null){
			$this->redirect(array('preregistration/registration'));
		}

		$model = new UploadForm();

		if(isset($_POST['UploadForm']))
		{

			$model->attributes=$_POST['UploadForm'];

			$name       = $_FILES['UploadForm']['name']['image'];

			$ext        = pathinfo($name, PATHINFO_EXTENSION);

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

				if($photoModel->save()){
					$visitorModel =
						Registration::model()->findByPk(
							$session['visitor_id']
						);
					$visitorModel->photo = $photoModel->id;
					$visitorModel->save();
					$session['imgName'] = $newName;
				}
			}

		}

		$this->render('upload-photo',array('model'=>$model) );
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

		$model = new PreregLogin();

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'prereg-login-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['PreregLogin'])) {
			$model->attributes = $_POST['PreregLogin'];

			if ($model->validate() && $model->login()) {
				$this->redirect(array('preregistration/dashboard'));
			}
		}
		$this->render('prereg-login', array('model' => $model));

	}

	public function actionDashboard(){
		$this->render('dashboard');
	}

	public function actionDetails(){
		echo "welcome";
		echo Yii::app()->user->id;
		print_r(Yii::app()->user);
	}

	public function actionLogout() {
		Yii::app()->user->logout();
		//$this->redirect('index.php?r=site/login');
	}

}


