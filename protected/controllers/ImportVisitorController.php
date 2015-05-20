<?php

class ImportVisitorController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'admin', 'delete', 'import'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ImportVisitor;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ImportVisitor']))
		{
			$model->attributes=$_POST['ImportVisitor'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ImportVisitor']))
		{
			$model->attributes=$_POST['ImportVisitor'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ImportVisitor');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ImportVisitor('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ImportVisitor']))
			$model->attributes=$_GET['ImportVisitor'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ImportVisitor the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ImportVisitor::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ImportVisitor $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='import-visitor-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        /**
         * Import From ImportVisitor and Add them into Visitor and Visits
         * 
         * @return redirect
         */
        public function actionImport() {
            
            $importVisit = ImportVisitor::model()->findAll('imported_by = '.Yii::app()->user->id);
            $session     = new CHttpSession;
            
            if($importVisit) {
                foreach( $importVisit as $key=>$visit ) {
                    
                    // If not a duplicate Visitor then Add it to Visitor and Visits tables
                            $visitorInfo = new Visitor;
                            $visitorInfo->first_name = $visit->first_name;
                            $visitorInfo->last_name  = $visit->last_name;
                            $visitorInfo->email      = $visit->email;
                            $visitorInfo->contact_number = $visit->contact_number;
                            $visitorInfo->position = $visit->position;
                            $company = Company::model()->find(" name LIKE '%{$visit->company}%' OR trading_name LIKE '%{$visit->company}%' ");
                            if( $company )
                               $visitorInfo->company = $company->id;
                            else
                               $visitorInfo->company = $session['company'];
                            $visitorInfo->role = Roles::ROLE_VISITOR;
                            $visitorInfo->visitor_status = '1'; // Active
                            $visitorInfo->visitor_type= '2'; 
                            $visitorInfo->created_by = Yii::app()->user->id;
                            $visitorInfo->tenant = Yii::app()->user->tenant;
                            if( $visitorInfo->validate() ) 
                            {
                                $visitorInfo->save();
                                //insert Card Code
                                if( !empty($visit->card_code)) {
                                    $card = new CardGenerated;
                                    $card->card_number = $visit->card_code;
                                    $card->date_printed = date("Y-m-d", strtotime($visit->date_printed));
                                    $card->date_expiration = date("Y-m-d", strtotime($visit->date_expiration));
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
                                $visitInfo->host = Yii::app()->user->id;
                                $visitInfo->card = $card ? $card->id:"";
                                $visitInfo->created_by = Yii::app()->user->id;
                                $visitInfo->date_check_in  = date("Y-m-d", strtotime($visit->check_in_date) );
                                $visitInfo->date_check_out = date("Y-m-d", strtotime($visit->check_out_date) );
                                $visitInfo->time_check_in = $visit->check_in_time;
                                $visitInfo->time_check_out = $visit->check_out_time;
                                $visitInfo->visit_status = 1;
                                $visitInfo->workstation = $session['workstation'];                               
                                $visitInfo->tenant = Yii::app()->user->tenant;
                                $visitInfo->reason = '1';
                                                
                                $visitInfo->save();
                            }                 
                }
                //Delete all previous uploads of this user
                    ImportVisitor::model()->deleteAll(
                        "`imported_by` = :user_id",
                        array(':user_id' => Yii::app()->user->id)
                    );
                    
            }
            return $this->redirect(array("visitor/admin"));
        }
}
