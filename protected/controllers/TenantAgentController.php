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
                 'actions' => array('index', 'create', 'AvmsAgents'),
                 'users' => array('@'),
                 //'expression' => 'CHelper::check_module_authorization("Admin")'
            ),
//            array('allow', // allow all users to perform 'GetCompanyList' and 'GetCompanyWithSameTenant' actions
//                 'actions' => array('create'),
//                 'users' => array('admin'),
//                 //'expression' => 'CHelper::check_module_authorization("Admin")'
//            ),
            
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    
    public function actionAvmsAgents() {
        
         $model = new TenantAgent('search');
         $model->unsetAttributes();  // clear any default values

        if (isset($_GET['User'])) {
            $model->attributes = $_GET['TenantAgent'];
        }
 
        $this->render('_admin', array(
            'model' => $model, "module"=>"AVMS"
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
                        $tenantAgent->for_module = $access == 1?"avms":"cvms";
                        if($access == 3)
                             $tenantAgent->for_module = "both";
                        
                        if( $tenantAgent->save() )
                        {
                              $this->saveTenantWorkstation($_POST, $companyModel->id, $userModel->id); 
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
	 
}