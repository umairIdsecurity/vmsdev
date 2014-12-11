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
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('GetCompanyList','GetCompanyWithSameTenant'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create'),
                'expression' => 'Yii::app()->controller->accessRoles("canCreateCompany")',
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('update'),
                'expression' => 'Yii::app()->controller->accessRoles("update")',
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'expression' => 'Yii::app()->controller->accessRoles("admin")',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function accessRoles($action) {
        $session = new CHttpSession;
        $CurrentRole = $session['role'];

        switch ($action) {
            case "admin":
                $user_role = array(Roles::ROLE_SUPERADMIN);
                if (in_array($CurrentRole, $user_role)) {
                    return true;
                }
                break;
            case "canCreateCompany":
                $user_role = array(Roles::ROLE_SUPERADMIN, Roles::ROLE_ADMIN);
                if (in_array($CurrentRole, $user_role)) {
                    return true;
                }
                break;
            case "update":

                if ($session['role'] == Roles::ROLE_SUPERADMIN) {
                    return true;
                } else {
                    return Company::model()->validateIfCurrentLoggedUserCanViewTheCompany($_GET['id'], $session['id']);
                }
                break;
            default:
                return false;
        }
    }

    public function actionCreate() {
        $model = new Company;
        $session = new CHttpSession;
        $companyService = new CompanyServiceImpl();
        $viewFromModal = '';
        if (isset($_GET['viewFrom'])) {
            $viewFromModal = 1;
        }
        if (isset($_POST['Company'])) {
            $model->attributes = $_POST['Company'];

            if ($this->checkIfCompanyIsUnique($session['tenant'], $session['role'], $_POST['Company']['name'], $_POST['Company']['tenant']) == 0) {
                if ($companyService->save($model, $session['tenant'], $session['role'], 'create')) {
                    $lastId = $model->id;
                    $cs = Yii::app()->clientScript;
                    $cs->registerScript('closeParentModal', 'window.parent.dismissModal(' . $lastId . ');', CClientScript::POS_READY);
                    $model->unsetAttributes();

                    switch ($viewFromModal) {
                        case 1:
                            Yii::app()->user->setFlash('success', 'Company Successfully added!');
                            break;
                        default:
                            $this->redirect(array('company/admin'));
                    }
                }
            } else {
                Yii::app()->user->setFlash('error', 'Company name has already been taken.');
            }
        }


        $this->render('create', array(
            'model' => $model,
        ));
    }

    private function checkIfCompanyIsUnique($sessionTenant, $sessionRole, $companyName, $selectedTenant) {
        if ($sessionRole == Roles::ROLE_ADMIN) {
            $countCompany = Company::model()->validateIfCompanyIsUniqueWithinTheTenant($companyName, $sessionTenant);
        } else {
            $countCompany = Company::model()->validateIfCompanyIsUniqueWithinTheTenant($companyName, $selectedTenant);
        }

        return $countCompany;
    }

    public function actionUpdate($id) {
        //$this->layout = '//layouts/contentIframeLayout';
        $model = $this->loadModel($id);
        $session = new CHttpSession;
        if (isset($_POST['Company'])) {
            $model->attributes = $_POST['Company'];
            if ($model->save()) {
                switch ($session['role']) {
                    case Roles::ROLE_SUPERADMIN:
                        $this->redirect(array('company/admin'));
                        break;

                    default:
                        Yii::app()->user->setFlash('success', 'Organisation Settings Updated');
                }
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
        $model = new Company('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Company']))
            $model->attributes = $_GET['Company'];

        $this->render('admin', array(
            'model' => $model,
        ));
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
