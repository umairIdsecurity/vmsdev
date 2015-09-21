<?php

class WorkstationController extends Controller {

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
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('delete', 'create'),
                'expression' => 'Yii::app()->user->role == Roles::ROLE_SUPERADMIN',
           
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'adminAjax', 'update', 'ajaxWorkstationCardtype'),
                'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION)',

            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Receive ajax POST type request with two variable workstation_id and
     * card_type_id. This two variables are used as composite primary key to
     * query the associated table 'workstation_card_type' of workstation
     * and card type. The function will work as if query return empty value
     * it insert new item 'workstation_card_type' otherwise remove the
     * existing row.
     *
     * @return void
     *
     * */
    public function actionAjaxWorkstationCardtype() {

        if (!empty($_POST['card_type_id']) && !empty($_POST['workstation_id'])) {

            $workstationId = $_POST['workstation_id'];
            $cardType = $_POST['card_type_id'];

            $ws_card = WorkstationCardType::model()->findByPk(
                    array(
                        'workstation' => $workstationId,
                        'card_type' => $cardType
                    )
            );

            if (!empty($ws_card)) {
                $ws_card->delete();
            } else {
                $session = new CHttpSession;
                $ws_card = new WorkstationCardType();
                $ws_card->workstation = $workstationId;
                $ws_card->card_type = $cardType;
                $ws_card->user = $session['id'];
                $ws_card->save();
            }
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Workstation;
        
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Workstation'])) {
            
            $model->attributes = $_POST['Workstation'];
            if ($model->save())
                $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'model' => $model,
                ), false, true);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $slectedCardType = WorkstationCardType::model()->findAllByAttributes(
                array('workstation' => $id)
        );

        $cards = array();
        if (!empty($slectedCardType)) {
            foreach ($slectedCardType as $cardTypes) {
                $cards[] = $cardTypes->card_type;
            }
        }

        $model->card_type = $cards;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Workstation'])) {
            $model->attributes = $_POST['Workstation'];
            if ($model->save()) {

                WorkstationCardType::model()->deleteAll(
                        "workstation=" . $model->id . ""
                );
                if (!empty($model->card_type)) {
                    foreach ($model->card_type as $card) {
                        $session = new CHttpSession;
                        $workstation = new WorkstationCardType();
                        $workstation->workstation = $model->id;
                        $workstation->card_type = $card;
                        $workstation->user = $session['id'];
                        $workstation->save();
                    }
                }

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

        if (Yii::app()->request->isPostRequest) {
        	
        	if (Yii::app()->request->isAjaxRequest) {
        		$type = Yii::app()->request->getPost("type", "");
        		if ($type == "check") {
        			$activeCri = new CDbCriteria();
        			$activeCri->compare("workstation", $id);
        			$activeCri->addInCondition("visit_status", array(1, 2));
        			$activeVisits = Visit::model()->findAll($activeCri);
        			echo json_encode(array("visit" => count($activeVisits)));
        			exit();
        		}
        	}
        	
            $criteria = new CDbCriteria();
            $criteria->addCondition("workstation=" . $id);
            $criteria->addInCondition("visit_status", array(1, 2));
            //$criteria->addCondition("str_to_date(t.date_check_in,'%d-%m-%Y') > DATE_ADD(now(),interval 0 day)");
            $criteria->addCondition("t.date_check_in > ". date("yyyy-mm-dd"));
            
            $visits = Visit::model()->findAll($criteria);
           
            if (!empty($visits) && count($visits) > 0) {
                if (Yii::app()->request->isAjaxRequest) {
                	echo json_encode(array("status" => 1, "message" => 'Please assign user in Set Access Rules before deleting workstation.'));
                	exit();
                } else {
                	Yii::app()->user->setFlash('error', 'Please assign user in Set Access Rules before deleting workstation.');
                	$this->redirect(Yii::app()->createUrl('workstation/admin'));
                }
            }
            $sql = "DELETE FROM workstation_card_type WHERE workstation=$id";
            $connection=Yii::app()->db;
            $connection->createCommand($sql)->execute();
                

            $workstation = Workstation::model()->findByPk($id);
            $workstation->is_deleted = 1;
            $workstation->save();
			
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (Yii::app()->request->isAjaxRequest) {
            	echo json_encode(array("status" => 1));
            	exit();
            } else {
            	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
            
            
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request');
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Workstation('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Workstation'])) {
            $model->attributes = $_GET['Workstation'];
        }

        $this->render('_admin', array(
            'model' => $model,
                ), false, true);
    }

    /**
     * Manages all models ajax.
     */
    public function actionAdminAjax() {
        $model = new Workstation('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Workstation'])) {
            $model->attributes = $_GET['Workstation'];
        }

        $this->renderPartial('_admin', array(
            'model' => $model,
                ), false, true);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Workstation the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Workstation::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Workstation $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'workstation-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
