<?php

class TenantController extends Controller {

    public $layout = '//layouts/column2';

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
            array('allow', // allow all users to perform 'GetCompanyList' and 'GetCompanyWithSameTenant' actions
                'actions' => array('GetCompanyList', 'GetCompanyWithSameTenant', 'create', 'delete'),
                 'users' => array('@'),
                'expression' => 'CHelper::check_module_authorization("Admin")'
            ),
            array('allow', // allow user if same company
                'actions' => array('update', 'edit'),
                'expression' => 'Yii::app()->controller->isUserAllowedToUpdate(Yii::app()->user)',
            ),
            array('allow', // allow superadmin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'adminAjax', 'delete'),
                'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_SUPERADMIN)',
            ),
            array('allow', // allow superadmin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'adminAjax' , 'delete'),
                'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION)',
            ),
            array('allow', // allow superadmin user to perform 'admin' and 'delete' actions
                'actions' => array('update'),
                'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION)',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function isUserAllowedToUpdate($user) {
        if(isset($user) && !empty($user->id)) {
            if ($user->role == Roles::ROLE_SUPERADMIN) {
                return true;
            } else {
                $currentlyEditedCompanyId = $_GET['id'];
                return Company::model()->isUserAllowedToViewCompany($currentlyEditedCompanyId, $user);
            }
        }
        return false;
    }

    public function actionCreate() {

        //     $this->layout = '//layouts/contentIframeLayout';
        $session = new CHttpSession;
        $model = new TenantForm;
        if(yii::app()->request->isAjaxRequest){
            if($_POST['TenantForm']['password_opt']==1){
                $model->scenario = "passwordrequire";
            }
            $this->performAjaxValidation($model);


        }
       
        if (isset($_POST['TenantForm'])) {

            $transaction = Yii::app()->db->beginTransaction();

            try {
                $tenantContact = new TenantContact;
                $tenantModel = new Tenant;
                $userModel = new User;
                $companyModel = new Company;
                $photo = new Photo;
                        
                $photolastId = 0;
                if (isset($_POST['TenantForm']['photo']) && $_POST['TenantForm']['photo'] != "") {
                    $photolastId = $_POST['TenantForm']['photo'];
                }else{
                    $photolastId = NULL;
                }
                $companyModel->company_type = 1; // tenant company type
                $companyModel->code = $_POST['TenantForm']['tenant_code'];
                $companyModel->name = $_POST['TenantForm']['tenant_name'];
                $companyModel->trading_name = $_POST['TenantForm']['tenant_name'];
                $companyModel->logo = $photolastId;/*logo image id*/
                $companyModel->contact = $_POST['TenantForm']['contact_number'];
                $companyModel->email_address = $_POST['TenantForm']['email'];
                $companyModel->office_number = $_POST['TenantForm']['contact_number'];
                $companyModel->mobile_number = $_POST['TenantForm']['contact_number'];
                $companyModel->is_deleted = 0;
                $companyModel->created_by_user = Yii::app()->user->id;

                $companyLastId = 0;
                if ($companyModel->validate()) {
                    
                    
                    $companyModel->save();
                    $companyLastId = $companyModel->id;

                    $companyModel->tenant = $companyModel->id;
                    $companyModel->save();

                    $userModel->first_name = $_POST['TenantForm']['first_name'];
                    $userModel->last_name = $_POST['TenantForm']['last_name'];
                    $userModel->email = $_POST['TenantForm']['email'];
                    $userModel->contact_number = $_POST['TenantForm']['contact_number'];
                    $userModel->company = $companyLastId;
                    $userModel->timezone_id = $_POST['TenantForm']['timezone_id'];
                    $userModel->tenant = $companyLastId;

                    $passwordval = NULL;
                    if(isset($_POST['TenantForm']['password']) && $_POST['TenantForm']['password'] != ""){
                        $passwordval = $_POST['TenantForm']['password'];
                    }
                    $userModel->password = $passwordval;
                    //$userModel->role = $_POST['TenantForm']['role'];
                    $userModel->role = 1;
                    
                    //$userModel->user_type = $_POST['TenantForm']['user_type'];
                    //$userModel->user_status = $_POST['TenantForm']['user_status'];
                    
                    $userModel->user_type = 1;
                    $userModel->user_status = 1;
                    
                    $userModel->created_by = Yii::app()->user->id;
                    $userModel->is_deleted = 0;
                    $userModel->notes = $_POST['TenantForm']['notes'];
                    $userModel->photo = $photolastId;//$_POST['TenantForm']['photo'];

                    //$userModel->asic_no = 10;
                    //$userModel->asic_expiry_day = 10;
                    //$userModel->asic_expiry_month = 10;
                    //$userModel->asic_expiry_year = 15;
                    /**
                     * Module Access
                     */ 
                    $access = CHelper::get_module_access($_POST);
                    $userModel->allowed_module = $access;    
                    $userLastID = 0;
                    if ( $userModel->validate() ) {
                                               
                        $userModel->save(false);
                        $userLastID = $userModel->id;                     
                        
                         
                        $tenantModel->id = $companyLastId;
                        $tenantModel->is_deleted = 0;
                        $tenantModel->created_by = Yii::app()->user->id;
                        if ($tenantModel->validate()) {
                            $tenantModel->save();
                            $tenantLastID = $tenantModel->id;
                            $tenantContact->tenant = $tenantLastID;
                            $tenantContact->user = $userLastID;
                            if ($tenantContact->validate()) {
                                $tenantContact->save();
                                
                                /**
                                 * Create and save New Workstation
                                 */
                                $this->saveTenantWorkstation($_POST, $companyModel->id, $userModel->id); 
                                $transaction->commit();

                                //email sending
                                if(!empty($_POST['TenantForm']['password_opt'])){
                                    
                                    $passwordRequire= intval($_POST['TenantForm']['password_opt']);

                                    if($passwordRequire == 1){
                                        $loggedUserEmail = Yii::app()->user->email;
                                        $headers = "MIME-Version: 1.0" . "\r\n";
                                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                        $headers .= "From: ".$loggedUserEmail."\r\nReply-To: ".$loggedUserEmail;
                                        $to=$_POST['TenantForm']['email'];
                                        $subject="Tenant registration notification email";
                                        $body = "<html><body>Hi,<br><br>".
                                                "This is Tenant registration confirmation.<br><br>".
                                                "Please click on the below URL to access application:<br><br>".
                                                Yii::app()->getBaseUrl(true)."/index.php?r=site/login<br>";
                                        $body .= "Password: ".$_POST['TenantForm']['password']."<br>";
                                        $body .="<br>"."Thanks,"."<br>Admin</body></html>";

                                        @mail($to, $subject, $body, $headers);
                                    }
                                    elseif ($passwordRequire == 2) {

                                        User::model()->restorePassword($_POST['TenantForm']['email']);
                                        
                                    }
                                }

                                Yii::app()->user->setFlash('success', "Tenant inserted Successfully");
                                // echo json_encode(array('success'=>TRUE));
                                $this->redirect(array('tenant/admin'));
                                
                            } else {
                                $transaction->rollback();
                                Yii::app()->user->setFlash('error',"Unable to create tenant. Please, fill all the fields and try again");
                            }

                        } else {
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error',"Unable to create tenant. Please, fill all the fields and try again");
                            
                        }
 
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Unable to create tenant. Please, fill all the fields and try again");
                    }
 
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Unable to create tenant. Please, fill all the fields and try again");
                }


                /*Yii::app()->user->setFlash('success', "Tenant inserted Successfully");
               // echo json_encode(array('success'=>TRUE));
                $this->redirect(array('tenant/admin'));*/

            }catch (CDbException $e)
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', $e->getMessage());
                 
            }
            
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }
    
    /**
     * Tenant Edit for Tenant Admin 
     */
    public function actionEdit($id) {
        
        $model = Tenant::model()->with("id0", "user0")->find("t.id = ".$id . " AND user0.id = ".Yii::app()->user->id);
        $modelForm = new TenantForm;
        $this->performAjaxValidation($modelForm);
        
        if (isset($_POST['TenantForm'])) {
            // Save Updated Data
           $company = Company::model()->findByPk($model->id);
           $company->name = $_POST['TenantForm']['tenant_name'];
           $company->code = $_POST['TenantForm']['tenant_code'];
           $company->save(false); // Dont validate as we have already Validated it.
           
           //User Tenant user data
           $user = User::model()->findByPk($model->user0[0]['id']);
           $user->first_name = $_POST['TenantForm']['first_name'];
           $user->last_name  = $_POST['TenantForm']['last_name'];
           $user->email = $_POST['TenantForm']['email'];
           $user->contact_number = $_POST['TenantForm']['contact_number'];
           $user->timezone_id = $_POST['TenantForm']['timezone_id'];
          //Save Password. 
           if( !empty( $_POST['TenantForm']['password']) && $_POST['TenantForm']['password'] == $_POST['TenantForm']['cnf_password']){
                 $user->password = CPasswordHelper::hashPassword($_POST['TenantForm']['password']);          
           }
           //Save Photo
            if (isset($_POST['TenantForm']['photo']) && $_POST['TenantForm']['photo'] != "") {
                $user->photo = $_POST['TenantForm']['photo'];
            } 
           $user->save(false); 
           Yii::app()->user->setFlash("success", "Organization Settings Updated Succcessfully");
           $this->redirect(array("tenant/edit/&id=".$id));
        } 
         
         $this->render('edit', array(
            'model' => $modelForm,
            'TenantModel'=>$model,
        ));
    }
/**
 * Create and save new Workstation for newly created Tenant
 * @param array $post 
 * @param int $tenant_id
 */
    public function saveTenantWorkstation($post, $tenant_id, $user_id) {
        
        $workstation = new Workstation;
        $workstation->name = $post["TenantForm"]["workstation"];
        $workstation->contact_name = $post["TenantForm"]["first_name"].' '.$post["TenantForm"]["last_name"];
        $workstation->contact_email_address = $post["TenantForm"]["email"];
        $workstation->contact_number = $post["TenantForm"]["contact_number"];
        $workstation->createdBy = Yii::app()->user->id;
        $workstation->tenant = $tenant_id;
        $workstation->tenant_agent = $user_id;
        $workstation->password = NULL;
        $workstation->timezone_id = $post["TenantForm"]["timezone_id"];
        if( $workstation->save() ) {
            $userWorkstation = new UserWorkstations;
            $userWorkstation->user_id = $user_id;
            $userWorkstation->workstation = $workstation->id;
            $userWorkstation->createdBy = Yii::app()->user->id;
            $userWorkstation->is_primary = 1;
            
            $userWorkstation->save();
            return true;
        }
        return;
        
    }
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='tenant-form')
        {
            $model->scenario = "save";
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
         if(isset($_POST['ajax']) && $_POST['ajax']==='tenant-edit-form')
        {
            $model->scenario = "edit_form"; 
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        
    }

    private function isCompanyUnique($sessionTenant, $sessionRole, $companyName, $selectedTenant) {
        if ($sessionRole == Roles::ROLE_ADMIN) {
            $countCompany = Company::model()->isCompanyUniqueWithinTheTenant($companyName, $sessionTenant);
        } else {
            $countCompany = Company::model()->isCompanyUniqueWithinTheTenant($companyName, $selectedTenant);
        }

        return $countCompany;
    }

    private function isCompanyCodeUnique($sessionTenant, $sessionRole, $companyCode, $selectedTenant) {
        if ($sessionRole == Roles::ROLE_ADMIN) {
            $countCompany = Company::model()->isWithoutCompanyCodeUniqueWithinTheTenant($sessionTenant);
        } else {
            $countCompany = Company::model()->isCompanyCodeUniqueWithinTheTenant($companyCode, $selectedTenant);
        }

        return $countCompany;
    }

    public function actionUpdate($id) {
        //$this->layout = '//layouts/contentIframeLayout';
        $session = new CHttpSession;
        $model = $this->loadModel($id);
        $model->scenario = "updatetenant";
        $lastEmail = $model->email_address;               
        if(isset($_POST['Company'])){
            //print_r($_POST['Company']);
            $model->attributes = $_POST['Company'];
            $model->office_number = $_POST['Company']['mobile_number'];
            $model->contact = $_POST['Company']['mobile_number'];
            
            if($model->validate()){
                $model->save();
                $userModel = User::model()->find('company=:c AND email=:e', ['c' => $model->id, 'e'=>$lastEmail]);
                /**
                  * Module Access
                 */ 
                $access = CHelper::get_module_access($_POST);
                if( !is_null($access))
                    $userModel->allowed_module = $access; 
                $userModel->email = $_POST['Company']['email_address'];
                $userModel->contact_number = $_POST['Company']['mobile_number'];               
                $userModel->save(false);
         
                Yii::app()->user->setFlash('success', "Tenant updated Successfully");
                $this->redirect(array('tenant/admin'));
                //$this->redirect(array("tenant/update&id=".$id));

            }else{
                //print_r($model->getErrors());
                Yii::app()->user->setFlash('error', "There was an error processing request");
                $this->redirect(array("tenant/update&id=".$id));
            }

        }

        $contacts = User::model()->findAll('company=:c', ['c' => $model->id]);
        $this->render('_updateform', array(
            'model' => $model,
            'contacts' => $contacts,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
     public function actionDelete($id) {

        if(Yii::app()->request->isPostRequest)
        {  
            // Now Disable Tenant Record
            $sql = "UPDATE tenant SET is_deleted = 1 WHERE id=$id";
            $connection=Yii::app()->db;
            $connection->createCommand($sql)->execute();
            
            // Disable user from User table 
            $users = new User;
            $users->updateAll( array('is_deleted'=>1), 'tenant = '.$id);
            
            //Disable Company     
            $company = new Company;
            $company->updateAll( array('is_deleted'=>1), 'tenant = '.$id); 
      
            //Workstation of this tenant   
            $workstation = new Workstation;
            $workstation->updateAll( array('is_deleted'=>1), 'tenant = '.$id);
            
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request');

    }


    /**
     * Manages all models.
     */
     public function actionAdmin() {
        //  $this->layout = '//layouts/contentIframeLayout';
        $model = new Tenant('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Tenant']))
            $model->attributes = $_GET['Tenant'];

        //Check whether a login user/tenant allowed to view 
         CHelper::check_module_authorization("Admin");
        $this->render('_admin', array(
            'model' => $model,
        ), false, true);
    }

    public function actionAdminAjax() {
        //  $this->layout = '//layouts/contentIframeLayout';
        $model = new Tenant('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Tenant'])){
            //print_r($_GET['Tenant']);exit;
            $model->attributes = $_GET['Tenant'];
        }


        $this->renderPartial('_admin', array(
            'model' => $model,
        ), false, true);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Company the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $tenant = Tenant::model()->findAllByPk($id);
        if ($tenant) {
            $model = Company::model()->findByPk($id);
            if ($model === null) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            return $model;
        }else{
            throw new CHttpException(404, 'The requested company is not a tenant.');
        }

    }

    /**
     * Performs the AJAX validation.
     * @param Company $model the model to be validated
     */

    public function actionGetCompanyList() {
        $resultMessage['data'] = Company::model()->findAllCompany();

        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionGetCompanyWithSameTenant($id) {
        $resultMessage['data'] = Company::model()->findAllCompanyWithSameTenant($id);
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

}
