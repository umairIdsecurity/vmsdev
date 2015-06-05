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
            ),
            array('allow', // allow user if same company
                'actions' => array('update'),
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
        if ($user->role == Roles::ROLE_SUPERADMIN) {
            return true;
        } else {
            $currentlyEditedCompanyId = $_GET['id'];
            return Company::model()->isUserAllowedToViewCompany($currentlyEditedCompanyId, $user);
        }
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
        //print_r($_POST);exit;
        if (isset($_POST['TenantForm'])) {
            //echo $_POST['TenantForm']['photo'];exit;

            //$companyModel = new Company();
            //$companyModel->attribute = $_POST['TenantForm']['contact_number'];
            //$companyModel->mobile_number = $_POST['TenantForm']['contact_number'];
            $transaction = Yii::app()->db->beginTransaction();

            try {
                $tenantContact = new TenantContact();
                $tenantModel = new Tenant();
                $userModel = new User();
                $companyModel = new Company();
                $photo = new Photo();

                $photolastId = 0;
                if (isset($_POST['TenantForm']['photo']) && $_POST['TenantForm']['photo'] != "") {
                    $photolastId = $_POST['TenantForm']['photo'];
                } else {

                }

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
                /*$companyModel->created_by_visitor = $_POST['TenantForm']['first_name'];
                $companyModel->tenant = $_POST['TenantForm']['first_name'];
                $companyModel->tenant_agent = $_POST['TenantForm']['first_name'];
                $companyModel->billing_address = $_POST['TenantForm']['first_name'];
                $companyModel->website = $_POST['TenantForm']['first_name'];
                $companyModel->company_laf_number = $_POST['TenantForm']['first_name'];
                $companyModel->card_count = $_POST['TenantForm']['first_name'];*/

                $comapanylastId = 0;
                if ($companyModel->validate()) {
                    $companyModel->save();
                    $comapanylastId = $companyModel->id;
                    //echo "companyModel inserted:". $comapanylastId;
                } else {
                    //throw new CHttpException(500, 'Something went wrong');
                    /*print_r($companyModel->getErrors());
                    exit;*/
                }

                $userModel->first_name = $_POST['TenantForm']['first_name'];
                $userModel->last_name = $_POST['TenantForm']['last_name'];
                $userModel->email = $_POST['TenantForm']['email'];
                $userModel->contact_number = $_POST['TenantForm']['contact_number'];
                $userModel->company = $comapanylastId;

                $passwordval = NULL;
                if(isset($_POST['TenantForm']['password']) && $_POST['TenantForm']['password']!=""){
                    $passwordval = $_POST['TenantForm']['password'];
                }
                $userModel->password = $passwordval;
                $userModel->role = $_POST['TenantForm']['role'];
                $userModel->user_type = $_POST['TenantForm']['user_type'];
                $userModel->user_status = $_POST['TenantForm']['user_status'];
                $userModel->created_by = Yii::app()->user->id;
                $userModel->is_deleted = 0;
                $userModel->notes = $_POST['TenantForm']['notes'];
                $userModel->photo = $photolastId;//$_POST['TenantForm']['photo'];

                $userModel->asic_no = 10;
                $userModel->asic_expiry_day = 10;
                $userModel->asic_expiry_month = 10;
                $userModel->asic_expiry_year = 15;
                $userLastID = 0;
                if ($userModel->validate()) {
                    $userModel->save();
                    $userLastID = $userModel->id;
                    //echo ":userModel:".$userLastID;
                } else {
                    //throw new CHttpException(500, 'Something went wrong');
                    /*print_r($userModel->getErrors());
                    exit;*/
                }

                $tenantModel->id = $comapanylastId;
                $tenantModel->created_by = Yii::app()->user->id;
                if ($tenantModel->validate()) {
                    $tenantModel->save();
                    $tenantLastID = $tenantModel->id;
                    //echo ":tenantModel:".$tenantLastID;
                } else {
                    //throw new CHttpException(500, 'Something went wrong');
                    /*print_r($tenantModel->getErrors());
                    exit;*/
                }

                $tenantContact->tenant = $tenantLastID;
                $tenantContact->user = $userLastID;
                if ($tenantContact->validate()) {
                    $tenantContact->save();
                    $transaction->commit();
                    //echo ":tenantModel:";
                } else {
                    //throw new CHttpException(500, 'Something went wrong');
                    /*print_r($tenantContact->getErrors());
                    exit;*/
                }
                Yii::app()->user->setFlash('success', "Tenant inserted Successfully");
                echo json_encode(array('success'=>TRUE));
            }catch (CDbException $e)
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "There was an error processing request");
                echo json_encode(array('success'=>FALSE));
            }
            //
            //echo json_encode(array('redirect'=>$this->createUrl('user/admin')));
            exit;
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='tenant-form')
        {
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

        if (isset($_POST['is_user_field']) && $_POST['is_user_field']==1) {
            $session['is_field']=1;
            $model->scenario = 'company_contact';
        }else{
            unset($_SESSION['is_field']);
        }

        $userModel = User::model()->findByAttributes(
            array('company' => $model->id)
        );
        if(!empty($userModel)){
            $session['is_field']=1;
            $model->user_first_name = $userModel->first_name;
            $model->user_last_name = $userModel->last_name;
            $model->user_email = $userModel->email;
            $model->user_contact_number = $userModel->contact_number;
        }

        if (isset($_POST['user_role'])) {
            $model->userRole = $_POST['user_role'] ;
        }
        $session = new CHttpSession;

        if (isset($_POST['Company'])) {

            if ($model->name != $_POST['Company']['name']) {

                if (0 != $this->isCompanyUnique($session['tenant'], $session['role'], $_POST['Company']['name'], $_POST['Company']['tenant_'])) {
                    Yii::app()->user->setFlash('error', 'Company name has already been taken');
                }
            }

            if (isset($_POST['Company']['code']) && $model->code != $_POST['Company']['code']) {

                if (0 != $this->isCompanyCodeUnique($session['tenant'], $session['role'], $_POST['Company']['code'], $_POST['Company']['tenant_'])) {
                    Yii::app()->user->setFlash('error', 'Company code has already been taken');
                }
            }

            if (is_null($errorFlashMessage = Yii::app()->user->getFlash('error'))) {

                $model->attributes = $_POST['Company'];

                if ($model->save()) {

                    if(!empty($userModel)){
                        $userModel->first_name = $model->user_first_name;
                        $userModel->last_name = $model->user_last_name;
                        $userModel->email = $model->user_email;
                        $userModel->contact_number = $model->user_contact_number;
                        $userModel->asic_no = 10;
                        $userModel->asic_expiry_day = 10;
                        $userModel->asic_expiry_month = 10;
                        $userModel->asic_expiry_year = 15;
                        $userModel->save();
                    }else{
                        $userModel = new User();

                        $userModel->first_name = $model->user_first_name;
                        $userModel->last_name = $model->user_last_name;
                        $userModel->email = $model->user_email;
                        $userModel->contact_number = $model->user_contact_number;

                        $userModel->user_type = 2;
                        $userModel->password = 12345;
                        $userModel->role = 10;
                        $userModel->company = $model->id;
                        $userModel->asic_no = 10;
                        $userModel->asic_expiry_day = 10;
                        $userModel->asic_expiry_month = 10;
                        $userModel->asic_expiry_year = 15;
                        $userModel->save();
                    }


                    switch ($session['role']) {
                        case Roles::ROLE_SUPERADMIN:
                            $this->redirect(array('company/admin'));
                            break;

                        default:
                            Yii::app()->user->setFlash('success', 'Organisation Settings Updated');
                    }
                }

            } else {
                // Because of flash is a stack return back encountered error in order it can be displayed in the view
                Yii::app()->user->setFlash('error', $errorFlashMessage);
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

        if(Yii::app()->request->isPostRequest)
        {

            $sql = "UPDATE `company` SET `is_deleted`=1 WHERE `id`=$id";
            $connection=Yii::app()->db;
            $connection->createCommand($sql)->execute();

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
        if (isset($_GET['Company']))
            $model->attributes = $_GET['Company'];

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
    public function loadModel($id) {
        $model = Company::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
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
