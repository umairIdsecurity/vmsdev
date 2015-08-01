<?php

class VisitReasonController extends Controller {

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
                'actions' => array('update', 'admin','adminAjax', 'delete'),
                'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION)',
           
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create','GetAllReason','CheckReasonIfUnique', 'getCardTypeReason'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }


    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $session = new CHttpSession;
        $model = new VisitReason;
        $visitReasonService = new VisitReasonServiceImpl();
        
        //if viewfrom value is 1 ->do not redirect page after submit else redirect to admin
        $isViewedFromModal = 0;
        if (isset($_GET['register'])) {
            $isViewedFromModal = 1;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['VisitReason'])) {
            $model->attributes = $_POST['VisitReason'];
            $model->tenant = Yii::app()->user->tenant;
            if ($visitReasonService->save($model, $session['id'])) {

                switch ($isViewedFromModal) {
                    case 1:
                        break;
                    default:
                        $this->redirect(array('admin'));
                }
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
        $session = new CHttpSession;
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['VisitReason'])) {
            $model->attributes = $_POST['VisitReason'];

            if(isset($session['tenant']))
                $model->tenant = $session['tenant'];

            if(isset($session['tenant_agent']))
                $model->tenant = $session['tenant_agent'];

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
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new VisitReason('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['VisitReason']))
            $model->attributes = $_GET['VisitReason'];

        $this->render('_admin', array(
            'model' => $model,
        ),false,true);
    }
    
    public function actionAdminAjax() {
        $model = new VisitReason('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['VisitReason']))
            $model->attributes = $_GET['VisitReason'];

        $this->renderPartial('_admin', array(
            'model' => $model,
        ),false,true);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return VisitReason the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = VisitReason::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param VisitReason $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'visit-reason-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetAllReason() {
        $resultMessage['data'] = VisitReason::model()->GetAllReason();

        echo CJavaScript::jsonEncode($resultMessage);
        Yii::app()->end();
    }
    
    public function actionCheckReasonIfUnique($id) {
        if (VisitReason::model()->isReasonUnique($id)) {
            $aArray[] = array(
                'isTaken' => 0, //visitor reason is disabled by Geoff so isTaken is changed from 1 to 0 here for working of log visit
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
    
    /**
     * Get Selected CardType Reason
     * @param int $cardType CardType from Log Visit
     * 
     * @return array of Reason
     */
    public function actionGetCardTypeReason() {
        
         $cardType = Yii::app()->request->getParam("cardtype", 0);
        
        if($cardType > 4)
            $module = "AVMS";
        else
            $module = "CVMS";
        
        $criteria = new CDbCriteria;
        $criteria->condition = 'module = "'.$module.'" AND tenant = '.Yii::app()->user->tenant;
        $criteria->select = 'id,reason';

       $list =  VisitReason::model()->findAll($criteria);
                    
       echo CJSON::encode($list);
    }
}
