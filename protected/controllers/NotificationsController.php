<?php

class NotificationsController extends Controller
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
//			array('allow',  // allow all users to perform 'index' and 'view' actions
//				'actions'=>array('index','view'),
//				'users'=>array('*'),
//			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('view','index','delete','indexDelete'),
				'users'=>array('@'),
			),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array('admin','delete'),
//				'users'=>array('admin'),
//			),
                        array(
                            'allow',
                            'actions' => array('admin', 'create', 'delete', 'update','indexDelete'),
                            'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user, UserGroup::USERGROUP_SUPERADMIN)',
                        ),
                        array('allow',
                            'actions' => array('admin', 'create', 'delete', 'update','indexDelete'),
                            'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION)',
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
             // Mark All his/her notifications as READ
            $userNotify = UserNotification::model()->find("user_id = ".Yii::app()->user->id.' AND notification_id = '.$id);
                if($userNotify) {
                    $userNotify->has_read = 1;
                    $userNotify->save();          
            }
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
		$model=new Notification;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Notification']))
		{
			$model->attributes=$_POST['Notification'];
                        $model->created_by = Yii::app()->user->id;
                        $model->date_created = date("Y-m-d");
                        
			if($model->save()) {
                            
                            $criteria = new CDbCriteria;
                            //If Role ID is empty then send it to All CVMS and AVMS Users
                            if( empty($model->role_id) || is_null($model->role_id) )  {
                                $criteria->condition = 'is_deleted = 0 AND id != '.Yii::app()->user->id;
                            } else {                                
                                 
                                  // Expected CAVMS-427: When user selects 'Identity Security' option then system should send notifications to below users: 
                                  // Issuing Body admin, Airport Operators, Agent airport Administrators and Agent airport Operators.                              
                                if($model->role_id == Roles::ROLE_SUPERADMIN) {  // Super Admin is renamed as Identity security under Dropdown                               
                                    $roles = Roles::ROLE_ISSUING_BODY_ADMIN.','.Roles::ROLE_AIRPORT_OPERATOR.','.Roles::ROLE_AGENT_AIRPORT_OPERATOR.','.Roles::ROLE_AGENT_AIRPORT_ADMIN;
                                    $criteria->condition = 'role IN ('.$roles.') AND is_deleted = 0 ';
                                }
                                else {
                                    $criteria->condition = 'role ='.$model->role_id.' AND is_deleted = 0 ';
                                }
                                
                            } 
                            $users = User::model()->findAll($criteria);                               
                            foreach( $users as $key => $u ) {
                                    $notify = new UserNotification;
                                    $notify->user_id = $u->id;
                                    $notify->notification_id = $model->id;
                                    $notify->has_read = 0; //Not Yet
                                    $notify->save();
                                }
                                    
                            $this->redirect(array('admin'));
                        }
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
                $UserNotifyModel = new UserNotification;
                
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Notification']))
		{
			$model->attributes=$_POST['Notification'];
                        
			if($model->save())  {
                            // Notify Users that Message has been changed.
                            $UserNotifyModel->updateAll(array('has_read'=>'0'), 'notification_id = '.$id);
                            $this->redirect(array('notifications/admin'));
                        }
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
                UserNotification::model()->deleteAll('notification_id = '.$id);

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if(!isset($_GET['ajax'])){
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
               }
		
	}
        
        
        /**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionIndexDelete()
	{
           $id = Yii::app()->request->getParam('id');
           
            $userId = Yii::app()->user->id;
            
            UserNotification::model()->deleteAll('user_id = '.$userId.' AND notification_id = '.$id);

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax'])){
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
            	 
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
             // Mark All his/her notifications as READ
            $userNotify = UserNotification::model()->findAll("user_id = ".Yii::app()->user->id);
            
            foreach ($userNotify as $notification){
                if($notification) {
                    $notification->has_read = 1;
                    $notification->save();          
                }
            }
                     
            // Fetch Only His/Her Notifications
            $model=new Notification('indexSearch');
            
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['Notification']))
                    $model->attributes=$_GET['Notification'];

            $this->render('index',array(
                    'model'=>$model,
            ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Notification('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Notification']))
			$model->attributes=$_GET['Notification'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Notification the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Notification::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Notification $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='notification-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
