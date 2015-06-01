<?php

class VisitorTypeController extends Controller {

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
                'actions' => array('create', 'update', 'admin', 'delete','adminAjax', 'visitorsByTypeReport'),
                'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION)',
           
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
        $model = new VisitorType;
        $visitorTypeService = new VisitorTypeServiceImpl();
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['VisitorType'])) {
            $model->attributes = $_POST['VisitorType'];
            if ($visitorTypeService->save($model, Yii::app()->user))
                $this->redirect(array('admin'));
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

        if (isset($_POST['VisitorType'])) {
            $model->attributes = $_POST['VisitorType'];
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
        $model = new VisitorType('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['VisitorType']))
            $model->attributes = $_GET['VisitorType'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return VisitorType the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = VisitorType::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param VisitorType $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'visitor-type-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
    public function actionAdminAjax() {
        $model = new VisitorType('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['VisitorType']))
            $model->attributes = $_GET['VisitorType'];

        $this->renderPartial('_admin', array(
            'model' => $model,
                ), false, true);
    }
    
   /* 
    * Report: Corporate Reporting: Total Visits by Visitor Type
    * Total Visitors by Visitor Type
    * 
    * @return view
    */
    public function actionVisitorsByTypeReport() {
        
        $criteria = new CDbCriteria(); 
        // Post Date
        $dateFromFilter = Yii::app()->request->getParam("date_from_filter");
        $dateToFilter = Yii::app()->request->getParam("date_to_filter");
        
        
        if( !empty($dateFromFilter) && !empty($dateToFilter) ) {
//            $criteria->condition =  'visits.is_deleted=0 And visits.date_check_in BETWEEN "'.Yii::app()->request->getParam("date_from_filter").'" '
//                                . ' AND "'.Yii::app()->request->getParam("date_to_filter").'"';   
//            $criteria->together = true;
            $visitsCount = Yii::app()->db->createCommand()
                    ->select('t.id, t.name,count(visits.id) as visits')
                    ->from('visitor_type t')
                    ->leftJoin('visit visits' ,'t.id = visits.visitor_type  AND (t.is_deleted = 0) and (visits.is_deleted = 0)'.' And visits.date_check_in BETWEEN "'.Yii::app()->request->getParam("date_from_filter").'" '
                                . ' AND "'.Yii::app()->request->getParam("date_to_filter").'"')
                    ->where('t.is_deleted = 0')
                    ->group('t.id')
                    ->queryAll(); // this will be returned as an array of arrays
        }else{
            $visitsCount = Yii::app()->db->createCommand()
                    ->select('t.id, t.name,count(visits.id) as visits')
                    ->from('visitor_type t')
                    ->leftJoin('visit visits' , '(t.id = visits.visitor_type)  AND (t.is_deleted = 0) and (visits.is_deleted = 0)')
                    ->where('t.is_deleted = 0')
                    ->group('t.id')
                    ->queryAll(); // this will be returned as an array of arrays
        }
        

        $this->render("visitortypecount", array("visit_count"=>$visitsCount));
    } 

}
