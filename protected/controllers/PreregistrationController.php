<?php

class PreregistrationController extends Controller
{

	public $layout = '';

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
			array('allow',
				'actions' => array('index','privacyPolicy' , 'declaration' , 'Login' ,'registration','confirmDetails', 'visitReason' , 'addAsic' ),
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
				$this->redirect(array('preregistration/privacypolicy'));
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
			isset($session['declaration3']) && $session['declaration3'] == 1 &&
			isset($session['declaration4']) && $session['declaration4'] == 1
		)
		{
			$model->declaration1 = $session['declaration1'];
			$model->declaration2 = $session['declaration2'];
			$model->declaration3 = $session['declaration3'];
			$model->declaration4 = $session['declaration4'];
		}



		if(isset($_POST['Declaration'])){

			$model->attributes=$_POST['Declaration'];
			if($model->validate())
			{
				$session['declaration1'] = $model->declaration1;
				$session['declaration2'] = $model->declaration2;
				$session['declaration3'] = $model->declaration3;
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

		if (isset($_POST['Registration'])) {
			$model->profile_type = $session['account_type'];
			$model->email 		 = $session['username'];
			$model->password 	 = $session['password'];
			$model->attributes = $_POST['Registration'];

			$model->date_of_birth = date('Y-m-d', strtotime($model->birthdayYear . '-' . $model->birthdayMonth . '-' . $model->birthdayDay));

			if ($model->save()) {
				$session['visitor_id'] = $model->id;
				$this->redirect(array('preregistration/visitReason'));
			}
			//print_r($model->getErrors());
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

			if(
				empty($model->visitor_type) OR
				empty($model->reason)
			){
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

				if($registrationModel->save()){
					$this->redirect(array('preregistration/addAsic'));
				}
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
		$this->render('asic-sponsor');
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