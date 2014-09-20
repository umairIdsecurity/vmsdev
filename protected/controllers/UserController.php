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
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create',
                    'GetTenantAjax',
                    'GetTenantAgentCompany',
                    'GetTenantWorkstation', 'GetTenantAgentWorkstation'),
                'users' => array('*'),
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
                $user_role = array("1", "5", "6");
                if (in_array($CurrentRole, $user_role)) {
                    return true;
                }
                break;
            case "userTenant":
                $connection = Yii::app()->db;
                $ownerCondition = "where id ='" . $_GET['id'] . "'";
                if ($session['role'] == Roles::ROLE_ADMIN) {
                    $ownerCondition = "WHERE tenant = '" . $session['tenant'] . "' ";
                } else if ($session['role'] == Roles::ROLE_AGENT_ADMIN) {
                    $ownerCondition = "WHERE `tenant_agent`='" . $session['tenant_agent'] . "'";
                 }
                $ownerQuery = "select * FROM `user`
                            " . $ownerCondition . " and id ='" . $_GET['id'] . "' 
                            ";
                $command = $connection->createCommand($ownerQuery);
                $row = $command->query();
                if ($row->rowCount !== 0) {
                    return true;
                } else {
                    return false;
                }
                break;

            case "profile":
                $connection = Yii::app()->db;
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
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new User;
        $session = new CHttpSession;

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save()) {
                $connection = Yii::app()->db;
                if ($_POST['User']['role'] == Roles::ROLE_OPERATOR || $_POST['User']['role'] == Roles::ROLE_AGENT_OPERATOR) {
                    $command = $connection->createCommand('INSERT INTO `user_workstation` '
                            . '(`user`, `workstation`, `created_by`) VALUES (' . $model->id . ',' . $_POST['User']['workstation'] . ',' . $session['id'] . ' )');
                    $command->query();
                }
                $session['lastInsertId'] = $model->id;
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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save())
                $this->redirect(array('admin'));
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
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
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
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionSystemAccessRules() {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('systemAccessRule', array(
            'model' => $model,
        ));
    }

    public function actionProfile($id) {
        $this->layout = "//layouts/column1";
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save())
                $this->redirect(array('admin'));
        }

        $this->render('profile', array(
            'model' => $model,
        ));
    }

    public function actionGetTenantAjax($id) {
        $tenant = trim($id);

        $aArray = array();

        $connection = Yii::app()->db;
        $sql = "select id,concat(first_name,' ',last_name) as name from `user` where tenant=$id and role=6";
        $command = $connection->createCommand($sql);
        $row = $command->queryAll();
        foreach ($row as $key => $value) {

            $aArray[] = array(
                'id' => $value['id'],
                'name' => $value['name'],
            );
        }

        $resultMessage['data'] = $aArray;


        // echo json_encode($resultMessage);
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionGetTenantAgentCompany($id) {
        $aArray = array();

        $connection = Yii::app()->db;
        $sql = "SELECT company.id as id,company.name as company FROM `user`
                        LEFT JOIN company ON company.id = user.`company`
                        WHERE `user`.id=$id ";
        $command = $connection->createCommand($sql);
        $row = $command->queryAll();
        foreach ($row as $key => $value) {

            $aArray[] = array(
                'id' => $value['id'],
                'name' => $value['company'],
            );
        }

        $resultMessage['data'] = $aArray;


        // echo json_encode($resultMessage);
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionGetTenantWorkstation($id) {
        $aArray = array();

        $connection = Yii::app()->db;
        $sql = "SELECT id,name from workstation where tenant=$id";
        $command = $connection->createCommand($sql);
        $row = $command->queryAll();
        foreach ($row as $key => $value) {

            $aArray[] = array(
                'id' => $value['id'],
                'name' => $value['name'],
            );
        }

        $resultMessage['data'] = $aArray;


        // echo json_encode($resultMessage);
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionGetTenantAgentWorkstation($id, $tenant = NULL) {
        $aArray = array();

        $connection = Yii::app()->db;
        $sql = "SELECT id,name from workstation where tenant_agent=$id and tenant = $tenant";
        $command = $connection->createCommand($sql);
        $row = $command->queryAll();
        foreach ($row as $key => $value) {

            $aArray[] = array(
                'id' => $value['id'],
                'name' => $value['name'],
            );
        }

        $resultMessage['data'] = $aArray;


        // echo json_encode($resultMessage);
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

}
