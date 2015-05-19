<?php

class UserController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    

    /**
     * @return array action filters
     */
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
        $session = new CHttpSession;
        return array(
            array('allow',
                'actions' => array('create', 
                    'GetTenantAgentWithSameTenant',
                    'GetIdOfUser',
                    'CheckEmailIfUnique',
                    'GetTenantAgentAjax',
                    'GetTenantOrTenantAgentCompany',
                    'GetTenantWorkstation', 'GetTenantAgentWorkstation','getCompanyOfTenant'),
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('update'),
                'expression' => 'Yii::app()->controller->isTenantOfUserViewed(Yii::app()->user)',
               
            ),
            array('allow',
                'actions' => array('profile'),
                'expression' => '(Yii::app()->user->id == ($_GET[\'id\']))',
            ),
            array('allow',
                'actions' => array('admin', 'adminAjax', 'delete', 'systemaccessrules', 'importHost' ),
                'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user, UserGroup::USERGROUP_ADMINISTRATION)',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    
    public function isTenantOfUserViewed($user){
        return User::model()->isTenantOrTenantAgentOfUserViewed($_GET['id'], $user);
    }
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
         
    
        $model = new User;
        $userService = new UserServiceImpl();
        $session = new CHttpSession;
    
        if (isset($_POST['User'])) {
           
            $model->attributes = $_POST['User'];

	if(isset($_POST['User']['password_option']))
            $model->password_option = $_POST['User']['password_option'];
	else
            $model->password_option = '';
            $workstation = NULL;
            if (isset($_POST['User']['workstation'])) {
                $workstation = $_POST['User']['workstation'];
            }
            if ($userService->save($model, Yii::app()->user, $workstation)) {
               
                if (!isset($_GET['view'])) {
                    $this->redirect(array('admin', 'vms'=>CHelper::is_accessing_avms_features()? 'avms':'cvms'));
                }
            }
            
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $userService = new UserServiceImpl();
        $session = new CHttpSession;

        if (isset($_POST['User'])) {
            if($_POST['User']['password'] == ''){
                $_POST['User']['password'] = $model->password;
            } else {
                $_POST['User']['password'] = User::model()->hashPassword($_POST['User']['password']);
            }
            $model->attributes = $_POST['User'];

            if ($userService->save($model,Yii::app()->user, NULL)) {
                $this->redirect(array('admin', 'vms'=>$model->is_avms_user()?'avms':'cvms'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        //$this->loadModel($id)->delete();
       
        $model = $this->loadModel($id);
       
        if ($model->delete()) {
             
            //throw new CHttpException(400, "This is a required field and cannot be deleted"); 
        } else {
            $visitExists = Visit::model()->exists('is_deleted = 0 and host ="' . $id . '"');
            $isTenant = Company::model()->exists('is_deleted = 0 and tenant ="' . $id . '"');
            $userWorkstation = UserWorkstations::model()->exists('user = "' . $id . '"');
            $visitorExists = Visitor::model()->exists('tenant = "' . $this->id  . '" and is_deleted=0');
            $isTenantAgent = Company::model()->exists('tenant_agent = "' . $this->id  . '" and is_deleted=0');
            if (!$visitExists && !$isTenant && !$userWorkstation && !$visitorExists && !$isTenantAgent) {
                
                return false;
            } 
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('User');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['User'])) {
            $model->attributes = $_GET['User'];
        }

        if(CHelper::is_avms_users_requested()){
            $model = $model->avms_user();
        }else{
            $model = $model->cvms_user();
        }


        $this->render('_admin', array(
            'model' => $model,
                ), false, true);
    }

    public function actionAdminAjax() {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User'])) {
            $model->attributes = $_GET['User'];
        }

        if(Yii::app()->request->getParam('vms') == 'avms'){
            $model = $model->avms_user();
        }elseif(Yii::app()->request->getParam('vms') == 'cvms'){
            $model = $model->cvms_user();
        }

        $this->renderPartial('_admin', array(
            'model' => $model,
                ), false, true);
    }

    public function actionSystemAccessRules() {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User'])) {
            $model->attributes = $_GET['User'];
        }

        $this->render('systemAccessRule', array(
            'model' => $model,
        ));
    }

    public function actionProfile($id) {
        $this->layout = "//layouts/column1";
        $model = $this->loadModel($id);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save())
                Yii::app()->user->setFlash('success', "Profile Updated Successfully.");
        }

        $this->render('profile', array(
            'model' => $model,
        ));
    }

    public function actionGetTenantAgentAjax($id) {
        $resultMessage['data'] = User::model()->findAllTenantAgent($id);

        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionGetTenantOrTenantAgentCompany($id) {

        $resultMessage['data'] = User::model()->findCompanyDetailsOfUser($id);

        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionGetTenantWorkstation($id) {
        $resultMessage['data'] = User::model()->findWorkstationsWithSameTenant($id);

        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }
    
    public function actionGetCompanyOfTenant($id,$tenantAgentId = NULL) {
        $resultMessage['data'] = User::model()->findCompanyOfTenant($id, $tenantAgentId);

        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionGetTenantAgentWorkstation($id, $tenant) {
        $resultMessage['data'] = User::model()->findWorkstationsWithSameTenantAndTenantAgent($id, $tenant);

        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionCheckEmailIfUnique($id, $tenant = NULL) {
        if (User::model()->isEmailAddressUnique($id, $tenant)) {
            $aArray[] = array(
                'isTaken' => 1,
            );
        } else {
            $aArray[] = array(
                'isTaken' => 0,
            );
        };

        $resultMessage['data'] = $aArray;
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionGetIdOfUser($id) {
        $resultMessage['data'] = User::model()->getIdOfUser($id);
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }
    
    /**
     * Import Host CSV file to DB
     * First Name, Last Name, Department, Staff ID, Email, Contact Number
     * Import should detect duplicate records and give the option to delete or override previous record
     * 
     * @return view
     */
    public function actionImportHost() {
        
        $model = new ImportCsvForm;
        
        $session = new CHttpSession;
        if(isset($_POST['ImportCsvForm']))
             {
                $model->attributes=$_POST['ImportCsvForm'];
                if($model->validate())
                 {         
                    $csvFile = CUploadedFile::getInstance($model,'file');  
                    $tempLoc = $csvFile->getTempName();
                    $handle = fopen($tempLoc, "r");
                    $i = 1;
                    while($line = fgetcsv($handle, 2000)){
                        //Dont insert first row as it will be title
                        if($i == 1) {
                           $i++; continue;
                        }
                        $user  = new User;
                        $user->first_name = $line[0];
                        $user->last_name = $line[1];
                        $user->department = $line[2];
                        $user->staff_id = $line[3];
                        $user->email = $line[4];
                        $user->contact_number = $line[5];
                        $user->role = Roles::ROLE_STAFFMEMBER;  
                        $user->user_type = UserType::USERTYPE_INTERNAL;
                        $user->company = $session["company"];
                        $user->user_status = 1;
                        $user->created_by = $session['id'];
                        $user->tenant = Yii::app()->user->tenant;
                        $user->tenant_agent = $session['tenant_agent']; 
                        if( $user->validate() ) {
                            $user->save();
                        }
                    }
                     
                    Yii::app()->user->setFlash('success', "Records Imported Successfully");
                 }
             }  
 
         
        
        return $this->render("importhost", array("model"=>$model));
    }
}
