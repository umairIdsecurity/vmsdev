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
                'actions' => array('create', 'update', 'admin', 'delete','adminAjax','visitorsByWorkstationReport','visitorsByTypeReport', 'index'),
                'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION)',
           
            ),
            
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('GetFromCardType'),
                'users' => array("@"),
           
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

        $model = new VisitorType;


        //$visitorTypeService = new VisitorTypeServiceImpl();
        // Uncomment the following line if AJAX validation is needed
       //$this->performAjaxValidation($model);


        if (isset($_POST['VisitorType'])) {
            
            $model->attributes = $_POST['VisitorType'];

            $transaction = Yii::app()->db->beginTransaction();

            try {

                //if ($visitorTypeService->save($model, Yii::app()->user)) {

                $model->created_by = Yii::app()->user->id;
                $model->tenant = Yii::app()->user->tenant;
                $model->tenant_agent = Yii::app()->user->tenant_agent;

                $model->save();

                if(isset($_POST["card_types"])) {

                    $card_types = $_POST["card_types"];

                    // add any new ones
                    foreach ($card_types as $value) {

                        $new_row = new VisitorTypeCardType;
                        $new_row->card_type = $value;
                        $new_row->visitor_type = $model->id;
                        $new_row->tenant = !empty($session['tenant'])?$session['tenant']:NULL;
                        $new_row->tenant_agent = !empty($session['tenant_agent'])?$session['tenant_agent']:NULL;
                        $new_row->save();
                    }
                }
                $transaction->commit();

                Yii::app()->user->setFlash('success', "Visitor Type inserted Successfully");
                $this->redirect(array('admin', 'vms' => strtolower($model->module)));

            } catch (CDbException $e)
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', $e->getMessage());

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

        if (isset($_POST['VisitorType'])) {

            $model->attributes = $_POST['VisitorType'];

            $transaction = Yii::app()->db->beginTransaction();

            try {


                if ($model->save()) {

                        if(isset($_POST["card_types"]))
                            $card_types = $_POST["card_types"];
                        else
                            $card_types = array();

                        $found = array();
                        $existing = VisitorType::model()->getActiveCardTypes($id);
 
                        if (is_array($existing)) {

                            // delete card types not in the array
                            foreach ($existing as $key =>$value) {
                                if (!in_array($value->card_type, $card_types))
                                    $value->delete();
                                else
                                    array_push($found, $value->card_type);
                            }
                        }

                        // add any new ones
                        if (is_array($card_types)) {
                           $vctype = VisitorTypeCardType::model()->find("visitor_type =". $id);   
                           if( $vctype ) { 
                               VisitorTypeCardType::model()->deleteAll("visitor_type =". $id);
                           }
                            foreach ($card_types as $value) {
                                //if (!in_array($value, $found)) {
                                    $new_row = new VisitorTypeCardType;
                                    $new_row->card_type = $value;
                                    $new_row->visitor_type = $model->id;
                                    $new_row->tenant = !empty($session['tenant'])?$session['tenant']:NULL;
                                    $new_row->tenant_agent = !empty($session['tenant_agent'])?$session['tenant_agent']:NULL;
                                    $new_row->save();
                                //}
                            }
                        }
                    //}

                }

                $transaction->commit();

                $this->redirect(array('admin',array('vms' => $model->module)));

            } catch (CDbException $e)
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', $e->getMessage());
                throw $e;
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));

        //$this->redirect(array('index', 'vms' => CHelper::is_accessing_avms_features() ? 'avms' : 'cvms'));

    }



    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {

        $session = new CHttpSession;
        $transaction = Yii::app()->db->beginTransaction();

        try {

            $this->loadModel($id)->delete();

            $cardTypes = VisitorTypeCardType::model()->find('visitor_type=' . $id. " AND tenant=".$session['tenant']);
            if(is_array($cardTypes)) {
                foreach ($cardTypes as $value) {
                    $value->delete();
                }
            }

            $transaction->commit();

        } catch (CDbException $e)
        {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', $e->getMessage());
        }

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
        $model->module = CHelper::get_module_focus();

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
        $model->module = CHelper::get_module_focus();
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
            $dateCondition .= "( visitors.date_created BETWEEN  '".$from->format("Y-m-d H:i:s")."' AND  '".$to->format("Y-m-d H:i:s")."' ) AND ";
        }
        
        if(Roles::ROLE_SUPERADMIN != Yii::app()->user->role){
            $dateCondition .= "(visitors.tenant=".Yii::app()->user->tenant.") AND ";
        }
        
        $dateCondition .= "(t.is_deleted = 0) AND (visitors.is_deleted = 0) AND (visitors.profile_type='CORPORATE')";
        
        $visitsCount = Yii::app()->db->createCommand()
                ->select("t.id,t.name,count(visitors.id) as visitors") 
                ->from('visitor_type t')
                ->join("visitor visitors",'t.id = visitors.visitor_type')
                ->where($dateCondition)
                ->group('t.id, t.name')
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
            $dateCondition = "( visitors.date_created BETWEEN  '".$from->format("Y-m-d H:i:s")."' AND  '".$to->format("Y-m-d H:i:s")."' ) AND ";
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
                ->select("count(visitors.id) as visitors, t.id, t.name, t.id  as workstationId")
                ->from('workstation t')
                ->join("visitor visitors",'t.id = visitors.visitor_workstation')
                ->where($dateCondition)
                ->group('t.id, t.name')
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
