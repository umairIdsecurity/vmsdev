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
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create',
                    'GetTenantAgentWithSameTenant',
                    'GetIdOfUser',
                    'CheckEmailIfUnique',
                    'GetTenantAgentAjax',
                    'GetTenantOrTenantAgentCompany',
                    'GetTenantWorkstation', 'GetTenantAgentWorkstation'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('update'),
                'expression' => 'Yii::app()->controller->accessRoles("userTenant")',
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('profile'),
                'expression' => 'Yii::app()->controller->accessRoles("profile")',
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'systemaccessrules'),
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
                $user_role = array(Roles::ROLE_ADMIN, Roles::ROLE_SUPERADMIN, Roles::ROLE_AGENT_ADMIN);
                if (in_array($CurrentRole, $user_role)) {
                    return true;
                }
                break;
            case "userTenant":

                return User::model()->validateIfUserHasSameTenantOrTenantAgent($_GET['id'], $session['role'], $session['tenant'], $session['tenant_agent']);
                break;

            case "profile":
                if ($session['id'] == $_GET['id']) {
                    return true;
                } else {
                    return false;
                }
                break;
            default:
                return false;
        }
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
            $workstation = NULL;
            if (isset($_POST['User']['workstation'])) {
                $workstation = $_POST['User']['workstation'];
            }
            if ($userService->save($model, $session['tenant'], $session['tenant_agent'], $session['role'], $session['id'], $workstation)) {
                $this->redirect(array('admin'));
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
            $model->attributes = $_POST['User'];

            if ($userService->save($model, $session['tenant'], $session['tenant_agent'], $session['role'], $session['id'], NULL)) {
                $this->redirect(array('admin'));
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

        $this->render('admin', array(
            'model' => $model,
        ));
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

    public function actionCheckEmailIfUnique($id) {
        if (User::model()->checkIfEmailAddressIsTaken($id)) {
            echo "1";
        } else {
            echo "0";
        };
    }

    public function actionGetIdOfUser($id) {
        $resultMessage['data'] = User::model()->getIdOfUser($id);
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

}
