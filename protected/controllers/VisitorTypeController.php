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
                'actions' => array('create', 'update', 'admin', 'delete','adminAjax','visitorsByWorkstationReport','visitorsByTypeReport', 'index','GetFromCardType'),
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
     * Return list Vistor Type suitable with cardtype chose
     * @param int $cardtype the id cardtype
     */
    public function actionGetFromCardType($cardtype = 0)
    {
        echo VisitorType::model()->getFromCardType($cardtype);
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

    public function actionIndex()
    {
        $model = new VisitorType('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['VisitorType'])) {
            $model->attributes = $_GET['VisitorType'];
        }

        $this->render('_admin', array('model' => $model));
    }
    
   /* 
    * Report: Corporate Reporting: Total Visitors by Visitor Type
    * Total Visitors by Visitor Type
    * 
    * @return view
    */
    public function actionVisitorsByTypeReport() {
        // Post Date
        $dateFromFilter = Yii::app()->request->getParam("date_from_filter");
        $dateToFilter = Yii::app()->request->getParam("date_to_filter");
        
        $dateCondition='';
        
        if( !empty($dateFromFilter) && !empty($dateToFilter) ) {
            $from = new DateTime($dateFromFilter);
            $to = new DateTime($dateToFilter);
            $dateCondition .= "( DATE(visitors.date_created) BETWEEN  '".$from->format("Y-m-d")."' AND  '".$to->format("Y-m-d")."' ) AND ";
        }
        
        if(Roles::ROLE_SUPERADMIN != Yii::app()->user->role){
            $dateCondition .= "(visitors.tenant=".Yii::app()->user->tenant.") AND ";
        }
        
        $dateCondition .= "(t.is_deleted = 0) AND (visitors.is_deleted = 0) AND (visitors.profile_type='CORPORATE')";
        
        $visitsCount = Yii::app()->db->createCommand()
                ->select("t.id,t.name,count(visitors.id) as visitors,DATE(visitors.date_created) as date_check_in") 
                ->from('visitor_type t')
                ->join("visitor visitors",'t.id = visitors.visitor_type')
                ->where($dateCondition)
                ->group('t.id')
                ->queryAll();
        
        $this->render("visitortypecount", array("visit_count"=>$visitsCount));
    } 
    
    /* 
    * Report: Corporate Reporting: Total Visitors by Workstations
    * Total Visitors by Workstations
    * 
    * @return view
    */
    public function actionVisitorsByWorkstationReport() {
        // Post Date
        $dateFromFilter = Yii::app()->request->getParam("date_from_filter");
        $dateToFilter = Yii::app()->request->getParam("date_to_filter");
        
        $dateCondition='';
        
        if( !empty($dateFromFilter) && !empty($dateToFilter) ) {
            $from = new DateTime($dateFromFilter);
            $to = new DateTime($dateToFilter);
            $dateCondition = "( DATE(visitors.date_created) BETWEEN  '".$from->format("Y-m-d")."' AND  '".$to->format("Y-m-d")."' ) AND ";
        }
        
        $allWorkstations='';
        
        if(Roles::ROLE_SUPERADMIN != Yii::app()->user->role){
            
            $dateCondition .= "(visitors.tenant=".Yii::app()->user->tenant.") AND ";
            //show curren logged in user Workstations
            $allWorkstations = Workstation::model()->findAll("tenant = " . Yii::app()->user->tenant . " AND is_deleted = 0");
        }else{
            //show all work stations to SUPERADMIN
            $allWorkstations = Workstation::model()->findAll();
        }
        
        $dateCondition .= "(t.is_deleted = 0) AND (visitors.is_deleted = 0) AND (visitors.profile_type='CORPORATE')";
        
        $visitors = Yii::app()->db->createCommand()
                ->select("count(visitors.id) as visitors,DATE(visitors.date_created) AS date_check_in,t.id,t.name, t.id  as workstationId")
                ->from('workstation t')
                ->join("visitor visitors",'t.id = visitors.visitor_workstation')
                ->where($dateCondition)
                ->group('t.id')
                ->queryAll();
        
        $otherWorkstations = array();
        foreach ($allWorkstations as $workstation) {
            $hasVisitor = false;
            foreach($visitors as $visitor) {
                if($visitor['workstationId'] ==  $workstation->id) {
                    $hasVisitor =  true;
                }
            }
            if ($hasVisitor == false) {
                array_push($otherWorkstations, $workstation);
            }
        }

        $this->render("visitorbyworkstationcount", array("visitor_count"=>$visitors, "otherWorkstations" => $otherWorkstations));
    }

}
