<?php

class CompanyController extends Controller {

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
                'actions' => array('GetCompanyList', 'GetCompanyWithSameTenant', 'create'),
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
                'actions' => array('admin', 'adminAjax', 'delete'),
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
        $model = new Company;

        if (isset($_POST['is_user_field']) && $_POST['is_user_field']==1) {
            $session['is_field']=1;
            $model->scenario = 'company_contact';
        }else{
            unset($_SESSION['is_field']);
        }

		if (isset($_POST['user_role'])) {
			$model->userRole = $_POST['user_role'] ;
		}

        $companyService = new CompanyServiceImpl();
        $isUserViewingFromModal = '';
        if (isset($_GET['viewFrom'])) {
            $isUserViewingFromModal = 1;
        }

        if (isset($_POST['Company'])) {

            $model->attributes = $_POST['Company'];

            if ($this->isCompanyUnique($session['tenant'], $session['role'], $_POST['Company']['name'], $_POST['Company']['tenant']) == 0) {

				if(isset($_POST['Company']['code'])){
					 if ((($this->isCompanyCodeUnique($session['tenant'], $session['role'], $_POST['Company']['code'], $_POST['Company']['tenant']) == 0)) && ($session['role'] != Roles::ROLE_ADMIN)) {
	                    if ($companyService->save($model, $session['tenant'], $session['role'], 'create')) {
	                        $lastId = $model->id;

                            $cs = Yii::app()->clientScript;
	                        $cs->registerScript('closeParentModal', 'window.parent.dismissModal(' . $lastId . ');', CClientScript::POS_READY);
	                        $model->unsetAttributes();

	                        switch ($isUserViewingFromModal) {
	                            case 1:
	                                Yii::app()->user->setFlash('success', 'Company Successfully added!');
	                                break;
	                            default:
	                                $this->redirect(array('company/admin'));
	                        }
	                    }
	                } else {
	                    Yii::app()->user->setFlash('error', 'Company code has already been taken');
	                }
				}
				else{

					if ($companyService->save($model, $session['tenant'], $session['role'], 'create')) {

                        $lastId = $model->id;

                        $userModel = new User();

                        $userModel->first_name = $model->user_first_name;
                        $userModel->last_name = $model->user_last_name;
                        $userModel->email = $model->user_email;
                        $userModel->contact_number = $model->user_contact_number;

                        $userModel->user_type = 2;
                        $userModel->password = 12345;
                        $userModel->role = 10;
                        $userModel->company = $lastId;
                        $userModel->asic_no = 10;
                        $userModel->asic_expiry_day = 10;
                        $userModel->asic_expiry_month = 10;
                        $userModel->asic_expiry_year = 15;
                        $userModel->save();
                        unset($_SESSION['is_field']);

                        $cs = Yii::app()->clientScript;
                        $cs->registerScript('closeParentModal', 'window.parent.dismissModal(' . $lastId . ');', CClientScript::POS_READY);
                        $model->unsetAttributes();

                        switch ($isUserViewingFromModal) {
                            case 1:
                                Yii::app()->user->setFlash('success', 'Company Successfully added!');
                                break;
                            default:
                                $this->redirect(array('company/admin'));
                        }
                    }
				}

            } else {
                Yii::app()->user->setFlash('error', 'Company name has already been taken');
            }
        }


        $this->render('create', array(
            'model' => $model
        ));
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
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        //  $this->layout = '//layouts/contentIframeLayout';
        $model = new Company('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Company']))
            $model->attributes = $_GET['Company'];

        $this->render('_admin', array(
            'model' => $model,
                ), false, true);
    }

    public function actionAdminAjax() {
        //  $this->layout = '//layouts/contentIframeLayout';
        $model = new Company('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Company']))
            $model->attributes = $_GET['Company'];

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
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'company-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

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
