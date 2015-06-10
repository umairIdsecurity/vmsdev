<?php

class PreregistrationController extends Controller
{

	//public $layout = '//layouts/template-prereg';

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
				'actions' => array('index','privacyPolicy' , 'declaration' , 'Login' ),
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
		//echo $session['workstation'];

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
				$this->redirect(array('preregistration/login'));
			}
		}
		$this->render('declaration' , array('model'=>$model) );

	}

	public function actionLogin(){

		//echo "hello";
		$model = new PreregLogin();
		// if it is ajax validation request
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if (isset($_POST['PreregLogin'])) {
			$model->attributes = $_POST['PreregLogin'];
			// validate user input and redirect to the previous page if valid
			if ($model->validate() && $model->login()) {
				//$session = new CHttpSession;
				//echo "login";
				$this->redirect(array('preregistration/details'));
			}
		}
		$this->render('prereg-login', array('model' => $model));

	}

	public function actionDetails(){
		echo "welcome";
	}

	public function actionLogout() {
		Yii::app()->user->logout();
		//$this->redirect('index.php?r=site/login');
	}

}