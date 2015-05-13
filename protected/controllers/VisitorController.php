<?php

class VisitorController extends Controller {

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
                'actions' => array('update', 'delete', 'admin', 'adminAjax'),
                'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION)',
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('AddVisitor', 'ajaxCrop', 'create', 'GetIdOfUser','GetHostDetails', 'GetPatientDetails', 'CheckEmailIfUnique', 'GetVisitorDetails', 'FindVisitor', 'FindHost', 'GetTenantAgentWithSameTenant', 'GetCompanyWithSameTenant', 'GetCompanyWithSameTenantAndTenantAgent'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Creates a new model. Register and Preregister a visitor page
     */
    public function actionCreate() {
        $session = new CHttpSession;
        $model = new Visitor;
        $userModel = new User();
        $patientModel = new Patient();
        $reasonModel = new VisitReason();
        $visitModel = new Visit();

        $visitorService = new VisitorServiceImpl();

        if (isset($_POST['Visitor'])) {
            $model->attributes = $_POST['Visitor'];

            if ($visitorService->save($model, $_POST['Visitor']['reason'], $session['id'])) {

            }
        }

        $this->render('create', array(
            'model' => $model,
            'userModel' => $userModel,
            'patientModel' => $patientModel,
            'reasonModel' => $reasonModel,
            'visitModel' => $visitModel,
                ), false, true);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $visitorService = new VisitorServiceImpl();
        $session = new CHttpSession;
        // if view value is 1 do not redirect page else redirect to admin
        $isViewedFromModal = 0;
        if (isset($_GET['view'])) {
            $isViewedFromModal = 1;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Visitor'])) {
            $model->attributes = $_POST['Visitor'];
            if ($visitorService->save($model, NULL, $session['id'])) {
                switch ($isViewedFromModal) {
                    case "1":
                        break;

                    default:
                        $this->redirect(array('admin'));
                }
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /* Visitor detail page */

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        if ($model->delete()) {
            //throw new CHttpException(400, "This is a required field and cannot be deleted"); 
        } else {
            $visitorExists = Visit::model()->exists('is_deleted = 0 and visitor =' . $id . ' and (visit_status=' . VisitStatus::PREREGISTERED . ' or visit_status=' . VisitStatus::ACTIVE . ')');
            $visitorExistsClosed = Visit::model()->exists('is_deleted = 0 and visitor =' . $id . ' and (visit_status=' . VisitStatus::CLOSED . ' or visit_status=' . VisitStatus::EXPIRED . ')');

            if (!$visitorExists && !$visitorExistsClosed) {
                
                return false;
            } 
        }


        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Visitor('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visitor']))
            $model->attributes = $_GET['Visitor'];

        $this->render('_admin', array(
            'model' => $model,
                ), false, false);
    }

    public function actionAdminAjax() {
        $model = new Visitor('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visitor']))
            $model->attributes = $_GET['Visitor'];

        $this->renderPartial('_admin', array(
            'model' => $model,
                ), false, true);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Visitor the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Visitor::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Visitor $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'visitor-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetTenantAgentWithSameTenant($id) {
        $resultMessage['data'] = User::model()->findAllTenantAgent($id);
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionGetCompanyWithSameTenant($id) {

        $resultMessage['data'] = Visitor::model()->findAllCompanyWithSameTenant($id);
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionGetCompanyWithSameTenantAndTenantAgent($id, $tenantagent) {

        $resultMessage['data'] = Visitor::model()->findAllCompanyWithSameTenantAndTenantAgent($id, $tenantagent);
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionFindVisitor($id,$tenant,$tenant_agent) {
        $this->layout = '//layouts/column1';
        $model = new Visitor('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visitor']))
            $model->attributes = $_GET['Visitor'];

        $this->render('findVisitor', array(
            'model' => $model,
                ), false, true);
    }

    public function actionFindHost($id,$tenant,$tenant_agent) {
        $this->layout = '//layouts/column1';
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('findHost', array(
            'model' => $model,
                ), false, true);
    }

    public function actionGetVisitorDetails($id) {
        $resultMessage['data'] = Visitor::model()->findAllByPk($id);
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionGetHostDetails($id) {
        $resultMessage['data'] = User::model()->findAllByPk($id);
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionGetPatientDetails($id) {
        $resultMessage['data'] = Patient::model()->findAllByPk($id);
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionGetIdOfUser($id) {
        $resultMessage['data'] = Visitor::model()->getIdOfUser($id);
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionCheckEmailIfUnique($id) {
        if (Visitor::model()->isEmailAddressTaken($id)) {
            $aArray[] = array(
                'isTaken' => 1,
            );
        } else {
            $aArray[] = array(
                'isTaken' => 0,
            );
        }

        $resultMessage['data'] = $aArray;
        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }

    public function actionAjaxCrop() {
        $jpeg_quality = 90;

        $src = $_REQUEST['imageUrl'];
        $img_r = imagecreatefromjpeg($src);
        $dst_r = imagecreatetruecolor(200, 200);
        $usernameHash = hash('adler32', "visitor");
        $uniqueFileName = 'visitor' . $usernameHash . '-' . time() . ".png";
        imagecopyresampled($dst_r, $img_r, 0, 0, $_REQUEST['x1'], $_REQUEST['y1'], 200, 200, $_REQUEST['width'], $_REQUEST['height']);
        if (file_exists($src)) {
            unlink($src);
        }
        header('Content-type: image/jpeg');
        imagejpeg($dst_r, "uploads/visitor/" . $uniqueFileName, $jpeg_quality);


        Photo::model()->updateByPk($_REQUEST['photoId'], array(
            'unique_filename' => $uniqueFileName,
            'relative_path' => "uploads/visitor/" . $uniqueFileName,
        ));


        exit;
        return true;
    }

    public function actionAddVisitor() {
        $model = new Visitor;
        $visitorService = new VisitorServiceImpl();
        $session = new CHttpSession;

        if (isset($_POST['Visitor'])) {
            $model->profile_type = $_POST['Visitor']['profile_type'];
            $model->attributes = $_POST['Visitor'];

            if ($result = $visitorService->save($model, NULL, $session['id'])) {
//                $this->redirect(array('admin'));
            }
        }

        $this->render('addvisitor', array(
            'model' => $model,
        ));
    }

    

}
