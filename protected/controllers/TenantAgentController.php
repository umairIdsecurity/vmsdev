<?php

class TenantAgentController extends Controller
{
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
                 'actions' => array('index', 'avmsagents', 'cvmsagents'),
                 'users' => array('@'),
                 //'expression' => 'CHelper::check_module_authorization("Admin")'
            ),
            array('allow', // allow all users to perform 'GetCompanyList' and 'GetCompanyWithSameTenant' actions
                 'actions' => array('create', 'delete', 'update'),
                  'expression' => 'Yii::app()->user->role  == Roles::ROLE_SUPERADMIN'
            ),
            
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    
    public function actionAdmin() {
        
         $model = new TenantAgent('search');
         $model->unsetAttributes();  // clear any default values

        if (isset($_GET['TenantAgent'])) {
            $model->attributes = $_GET['TenantAgent'];
        }
 
        $this->render('_admin', array(
            'model' => $model, "module"=>"AVMS"
        ), false, true);
        
        
        
    }
    
      public function actionAvmsagents() {
        
         $model = new TenantAgent('search');
         $model->unsetAttributes();  // clear any default values

        if (isset($_GET['TenantAgent'])) {
            $model->attributes = $_GET['TenantAgent'];
        }
 
        $this->render('avmsadmin', array(
            'model' => $model, "module"=>"AVMS"
        ), false, true);
        
        
        
    }
    
     public function actionCvmsagents() {
        
         $model = new TenantAgent('search');
         $model->unsetAttributes();  // clear any default values

        if (isset($_GET['TenantAgent'])) {
            $model->attributes = $_GET['TenantAgent'];
        }
 
        $this->render('avmsadmin', array(
            'model' => $model, "module"=>"cvms"
        ), false, true);
        
        
        
    }
    
    /**
     * Create Tenant Agent
     */
    public function actionCreate() {
        
         $model = new TenantForm;
         $model->scenario = "tenant_agent";
         $allTenant = Tenant::model()->with("id0")->findAll("t.is_deleted = 0");
         
          if(yii::app()->request->isAjaxRequest){
            if($_POST['TenantForm']['password_opt']==1){
                $model->scenario = "passwordrequire";
            }
            $this->performAjaxValidation($model);
          }
           
            // If post then save
            if (isset($_POST['TenantForm'])) {
                
                 $transaction = Yii::app()->db->beginTransaction();
              
                $photolastId = NULL;
                if (isset($_POST['TenantForm']['photo']) && $_POST['TenantForm']['photo'] != "") {
                    $photolastId = $_POST['TenantForm']['photo'];
                } 
                // 1. Save Tenant Agent
                $companyModel = new Company;
                $companyModel->company_type = 2; // tenant Agent company type
                $companyModel->name = $_POST['TenantForm']['tenant_agent_name'];
                $companyModel->tenant = $_POST['TenantForm']['tenant_name']; // Its an ID actually
                $companyModel->trading_name = $_POST['TenantForm']['tenant_agent_name'];
                $companyModel->logo = $photolastId; /*logo image id*/
                $companyModel->contact = $_POST['TenantForm']['contact_number'];
                $companyModel->email_address = $_POST['TenantForm']['email'];
                $companyModel->office_number = $_POST['TenantForm']['contact_number'];
                $companyModel->mobile_number = $_POST['TenantForm']['contact_number'];
                $companyModel->is_deleted = 0;
                $companyModel->created_by_user = Yii::app()->user->id;
                $companyModel->code = substr($companyModel->name , 0,3);
                $companyModel->scenario = "add_tenant_agent";
                  if ($companyModel->validate()) {
                    
                    $companyModel->save();
                    
                    //2. Save Agent Admin User
                    $userModel = new User;                   
                    $userModel->first_name = $_POST['TenantForm']['first_name'];
                    $userModel->last_name = $_POST['TenantForm']['last_name'];
                    $userModel->email = $_POST['TenantForm']['email'];
                    $userModel->contact_number = $_POST['TenantForm']['contact_number'];
                    $userModel->company = $companyModel->id;
                    $userModel->timezone_id = $_POST['TenantForm']['timezone_id'];
                    $userModel->tenant = $companyModel->id;

                    $passwordval = NULL;
                    if(isset($_POST['TenantForm']['password']) && $_POST['TenantForm']['password'] != ""){
                        $passwordval = $_POST['TenantForm']['password'];
                    }
                    $userModel->password = $passwordval;
                    $userModel->role = $_POST['TenantForm']['role'];            
                    $userModel->user_type = $_POST['TenantForm']['user_type'];;
                    $userModel->user_status = 1;
                    $userModel->created_by = Yii::app()->user->id;
                    $userModel->is_deleted = 0;
                    $userModel->notes = $_POST['TenantForm']['notes'];
                    $userModel->photo = $photolastId;
                    $userModel->asic_no = 10;
                    $userModel->asic_expiry_day = 10;
                    $userModel->asic_expiry_month = 10;
                    $userModel->asic_expiry_year = 25;
                    /**
                     * Module Access
                     */ 
                    $access = CHelper::get_module_access($_POST);
                    $userModel->allowed_module = $access;    
                    if ( $userModel->validate() ) {
                        $userModel->save(false);
                        
                        //3. Save relational keys in Tenant_agent table
                        $tenantAgent = new TenantAgent;
                        $tenantAgent->id = $companyModel->id;
                        $tenantAgent->user_id = $userModel->id;
                        $tenantAgent->tenant_id = $companyModel->tenant;
                        $tenantAgent->is_deleted = 0;
                        $tenantAgent->created_by = Yii::app()->user->id; 
                        $tenantAgent->date_created = date("Y-m-d");
//                        $tenantAgent->for_module = $access == 1?"avms":"cvms";
//                        if($access == 3)
//                             $tenantAgent->for_module = "both";
                        $tenantAgent->for_module = $_POST["for_module"];
                        if( $tenantAgent->save() )
                        {
                              $agentContact = new TenantAgentContact;
                              $agentContact->tenant_id = $companyModel->tenant;
                              $agentContact->tenant_agent_id = $tenantAgent->id;
                              $agentContact->user_id = $userModel->id;
                              $agentContact->save();
                              
                              $this->saveTenantWorkstation($_POST, $tenantAgent->tenant_id, $userModel->id, $tenantAgent->id); 
                              $transaction->commit();
                                
                            Yii::app()->user->setFlash("success", "Tenant Agent Created Successfully");
                            $this->redirect(array("tenantAgent/create/&module=".$_POST["for_module"]) );
                        } else {
                            
                             $transaction->rollback();
                            Yii::app()->user->setFlash("error", "Sorry Unable to create new Tenant Agent");
                            $this->redirect(array("tenantAgent/create/&module=".$_POST["for_module"]));
                        }
                            
                    }
                }
            }
         
         $this->render("create", array("model"=>$model, "allTenant"=>$allTenant));
    }
    
    /**
 * Create and save new Workstation for newly created Tenant
 * @param array $post 
 * @param int $tenant_id
 */
    public function saveTenantWorkstation($post, $tenant_id, $user_id, $tenant_agent) {
        
        $workstation = new Workstation;
        $workstation->name = $post["TenantForm"]["workstation"];
        $workstation->contact_name = $post["TenantForm"]["first_name"].' '.$post["TenantForm"]["last_name"];
        $workstation->contact_email_address = $post["TenantForm"]["email"];
        $workstation->contact_number = $post["TenantForm"]["contact_number"];
        $workstation->createdBy = Yii::app()->user->id;
        $workstation->tenant = $tenant_id;
        $workstation->tenant_agent = $tenant_agent;
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
    
    /**
     * Update Tenant Agent Information
     * @param type $id
     */
    public function actionUpdate($id) {
        
        $model = TenantAgent::model()->with("id0", "user0", "tenant0")->find("t.id = ".$id);
        $allTenant = Tenant::model()->with("id0")->findAll("t.is_deleted = 0");
        $modelForm = new TenantForm;
        $modelForm->scenario = "edit_agent_form"; 
        $this->performAjaxValidation($modelForm);
        
        if (isset($_POST['TenantForm'])) {
            // Save Updated Data
           $company = Company::model()->findByPk($model->id);
           $company->tenant = $_POST['TenantForm']['tenant_name'];
           $company->name = $_POST['TenantForm']['tenant_agent_name'];
           $company->save(false); // Dont validate as we have already Validated it.
           
           //User Tenant user data
           $user = User::model()->findByPk($model->user_id);
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
           
           $model->tenant_id = $company->tenant; 
           $model->save(false);
           
           Yii::app()->user->setFlash("success", "Tenant Agent Updated Succcessfully");
           $this->redirect(array("tenantAgent/update/&id=".$id));
        } 
         
         $this->render('update', array(
            'model' => $modelForm,
            'TenantModel'=>$model,
             'allTenant' => $allTenant
        ));
        
    }
    /**
     * Delete Tenant Agent related Information
     * @param type $model
     */
    
    public function actionDelete($id) {
      $model = TenantAgent::model()->with("id0", "user0", "tenant0")->find("t.id = ".$id);
      $module = $model->for_module;
      //1. Disable Tenant Agent Relation
      $model->is_deleted = 1;
      $model->save(false);
      
      //2. Tenant Agent 
      $company = Company::model()->findByPk($model->id);
      $company->is_deleted = 1;
      $company->save(false);
      
      //3. Disable Agent Admin
      $user = User::model()->findByPk($model->user_id);
      $user->is_deleted = 1;
      $user->save(false);
      
      //4. Disable Workstation
      $workstation = UserWorkstations::model()->find("user_id = ".$model->user_id);
      $workstation->delete();
      if($module == "avms")
        $this->redirect(array("tenantAgent/avmsagents"));
    else  
         $this->redirect(array("tenantAgent/cvmsagents"));
     
    }
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='tenant-form' )
        {
            
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
         if(isset($_POST['ajax']) && $_POST['ajax']==='tenant-agent-edit-form')
        {
            $model->scenario = "edit_agent_form"; 
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        
    }
	 
}