<?php

class ImportHostsController extends Controller
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
				'actions'=>array('create','update', 'downloadSampleHostCsv', 'admin','delete', 'import'),
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
		$model=new ImportHosts;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ImportHosts']))
		{
			$model->attributes=$_POST['ImportHosts'];
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

		if(isset($_POST['ImportHosts']))
		{
			$model->attributes=$_POST['ImportHosts'];
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
		$dataProvider=new CActiveDataProvider('ImportHosts');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ImportHosts('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ImportHosts']))
			$model->attributes=$_GET['ImportHosts'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ImportHosts the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ImportHosts::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ImportHosts $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='import-hosts-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        
   /**
     * Download Sample Host Import File
     * 
     * @return type
     * @throws CHttpException
     */
    public function actionDownloadSampleHostCsv() {
        $dir_path = Yii::getPathOfAlias('webroot') . '/uploads/';
        $fileName = $dir_path . "/host_import_file.csv";
        if (file_exists($fileName))
           return Yii::app()->getRequest()->sendFile('host_import_file.csv', @file_get_contents($fileName));
        else
           throw new CHttpException(404, 'The requested page does not exist.');
    }
    /**
     * Import updated records from ImportHosts to Users
     * 
     * 
     */
    public function actionImport() {
        $hosts = ImportHosts::model()->findAll( "imported_by = ".Yii::app()->user->id );
        $session = new CHttpSession;
        
        if($hosts) {
            foreach( $hosts as $key => $h ) {
                $user  = new User;
                $user->first_name = $h->first_name;
                $user->last_name = $h->last_name;
                $user->email = $h->email;
                $user->department = $h->department;                    
                $user->staff_id = $h->staff_id;                        
                $user->contact_number = $h->contact_number;
                $user->date_of_birth = date("Y-m-d" , strtotime($h->date_of_birth));
                $user->position = $h->position;
                            
                 $user->role = $h->role;  
                 $user->user_type = UserType::USERTYPE_INTERNAL;
                 $user->company = $session["company"];
                 $user->user_status = 1;
                 $user->created_by = Yii::app()->user->id;
                 $user->tenant = Yii::app()->user->tenant;
                 $user->tenant_agent = $session['tenant_agent']; 
                 $user->save();                
            }
            //Delete all previous uploads of this user
              ImportHosts::model()->deleteAll(
                  "`imported_by` = :user_id",
                  array(':user_id' => Yii::app()->user->id)
              );
        }
        return $this->redirect(array("user/admin&vms=cvms")); 
        
    }
}
