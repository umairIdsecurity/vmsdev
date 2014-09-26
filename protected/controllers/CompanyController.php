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
                'actions' => array('index', 'view', 'GetCompanyList'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create'),
                'users' => array('@'),
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
                $user_role = array("5");
                if (in_array($CurrentRole, $user_role)) {
                    return true;
                }
                break;
            case "update":
                $connection = Yii::app()->db;
                if ($session['role'] == Roles::ROLE_SUPERADMIN) {
                    return true;
                } else {
                    $ownerQuery = "select company FROM `user` where company = '" . $_GET['id'] . "' and id='" . $session['id'] . "'";
                    $command = $connection->createCommand($ownerQuery);
                    $row = $command->query();
                    if ($row->rowCount !== 0) {
                        return true;
                    } else {
                        return false;
                    }
                }
                break;
            default:
                return false;
        }
    }

    public function actionCreate() {
        $model = new Company;
        $session = new CHttpSession;

        if (isset($_POST['Company'])) {
            $model->attributes = $_POST['Company'];
            // if admin check if company is unique with the tenant
            if ($session['role'] == Roles::ROLE_ADMIN) {
                $connection = Yii::app()->db;
                $command = $connection->createCommand('SELECT `name` FROM company WHERE `name`="' . $_POST['Company']['name'] . '" AND tenant="' . $session['tenant'] . '"');

                $row = $command->query();
                //if no match
                if ($row->rowCount == 0) {
                    if ($model->save()) {
                        $lastId = Yii::app()->db->getLastInsertID();
                        $cs = Yii::app()->clientScript;
                        $cs->registerScript('closeParentModal', 'window.parent.dismissModal(' . $lastId . ');', CClientScript::POS_READY);
                        $model->unsetAttributes();
                        Yii::app()->user->setFlash('success', 'Company Successfully added!');
                    }
                } else {
                    Yii::app()->user->setFlash('error', 'Company name has already been taken.');
                }
            } else {
                $connection = Yii::app()->db;
                $command = $connection->createCommand('SELECT `name` FROM company WHERE `name`="' . $_POST['Company']['name'] . '" AND tenant="' . $_POST['Company']['tenant'] . '"');

                $row = $command->query();
                //if no match
                if ($row->rowCount == 0) {
                    if ($model->save()) {
                        $lastId = Yii::app()->db->getLastInsertID();
                        $cs = Yii::app()->clientScript;
                        $cs->registerScript('closeParentModal', 'window.parent.dismissModal(' . $lastId . ');', CClientScript::POS_READY);
                        $model->unsetAttributes();
                        Yii::app()->user->setFlash('success', 'Company Successfully added!');
                    }
                } else {
                    Yii::app()->user->setFlash('error', 'Company name has already been taken.');
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['Company'])) {
            $model->attributes = $_POST['Company'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Organization Settings Updated');
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
        $aArray = array();

        $connection = Yii::app()->db;
        $sql = "SELECT id,name from company";
        $command = $connection->createCommand($sql);
        $row = $command->queryAll();
        foreach ($row as $key => $value) {

            $aArray[] = array(
                'id' => $value['id'],
                'name' => $value['name'],
            );
        }

        $resultMessage['data'] = $aArray;

        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

}
