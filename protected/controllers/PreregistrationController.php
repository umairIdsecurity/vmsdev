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
				'actions' => array('index','privacyPolicy' , 'declaration' , 'Login' ,'registration','confirmDetails', 'visitReason' ),
				'users' => array('*'),
			),
			array('allow',
				'actions'=>array('details','logout'),
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

		$model = new Declaration();

		if(isset($_POST['Declaration'])){

			$model->attributes=$_POST['Declaration'];
			if($model->validate())
			{
				$this->redirect(array('preregistration/registration'));
			}
		}
		$this->render('declaration' , array('model'=>$model) );

	}

	public function actionRegistration(){

		$session = new CHttpSession;
		$model = new Registration();

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'preregistration-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['Registration'])) {
			$model->attributes = $_POST['Registration'];
			$session['account_type'] = $model->account_type;
			$session['username'] 	 = $model->username;
			$session['password']     = $model->password;

			$this->redirect(array('preregistration/confirmDetails'));

		}

		$this->render('registration', array('model' => $model));
	}

	public function actionConfirmDetails(){
		$model = new Visitor;
		$session = new CHttpSession;

		if (isset($_POST['Visitor'])) {
			$model->profile_type = $session['account_type'];
			$model->tenant = 47;
			$model->email 		 = $session['username'];
			$model->password 	 = $session['password'];
			$model->attributes = $_POST['Visitor'];

			//$model->save();
			if ($model->save()) {
				$this->redirect(array('preregistration/visitReason'));
			}
			//print_r($model->getErrors());
		}
		
		$this->render('confirm-details' , array('model' => $model));
	}

	public function actionVisitReason(){
		$this->render('visit-reason');
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
				$this->redirect(array('preregistration/details'));
			}
		}
		$this->render('prereg-login', array('model' => $model));

	}

	public function actionDetails(){
		$session = new CHttpSession;
		echo $session['account_type']."<br>";
		echo $session['username']."<br>";
		echo $session['password']."<br>";
		//echo "welcome";
	}

	public function actionLogout() {
		Yii::app()->user->logout();
		//$this->redirect('index.php?r=site/login');
	}

}