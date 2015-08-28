<?php

class HelpDeskGroupController extends Controller {

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
            'accessControl'
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
                'actions' => array('create', 'update', 'admin', 'delete','adminAjax'),
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
		
		$session = new CHttpSession;
        $model = new HelpDeskGroup;
        if(isset($_POST['HelpDeskGroup']))
		{

            $transaction = Yii::app()->db->beginTransaction();

            try {
                $model->attributes=$_POST['HelpDeskGroup'];
                $model->created_by = $session['id'];
                $model->save();

                if(isset($_POST["roles"])) {
                    $roles = $_POST["roles"];
                    // add any new ones
                    foreach ($roles as $value) {
                        $new_row = new HelpdeskGroupUserRole;
                        $new_row->role = $value;
                        $new_row->helpdesk_group = $model->id;
                        $new_row->save();
                    }
                }
                if(isset($_POST["preregistrations"])) {
                    $roles = $_POST["preregistrations"];
                    // add any new ones
                    foreach ($roles as $value) {
                        $new_row = new HelpdeskGroupWebPreregistration;
                        $new_row->web_preregistration = $value;
                        $new_row->helpdesk_group = $model->id;
                        $new_row->save();
                    }
                }
                $transaction->commit();

                Yii::app()->user->setFlash('success', "Help Desk Group inserted Successfully");
                $this->redirect(array('admin','id'=>$model->id));

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
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['HelpDeskGroup'])) {
            $model->attributes = $_POST['HelpDeskGroup'];
            $transaction = Yii::app()->db->beginTransaction();

            try {
                if ($model->save()) {
                    // roles
                    if(isset($_POST["roles"]))
                        $roles = $_POST["roles"];
                    else
                        $roles = array();

                    $found = array();
                    $existing = HelpdeskGroupUserRole::model()->findAllByAttributes(array('helpdesk_group' => $id));

                    if (is_array($existing)) {
                        // delete roles not in the array
                        foreach ($existing as $key => $value) {
                            if (!in_array($value->role, $roles))
                                $value->delete();
                            else
                                array_push($found, $value->role);
                        }
                    }

                    // add any new ones
                    if (is_array($roles)) {
                        foreach ($roles as $value) {
                            if (!in_array($value, $found))
                            {
                                $new_row = new HelpdeskGroupUserRole;
                                $new_row->role = $value;
                                $new_row->helpdesk_group = $model->id;
                                $new_row->save();
                            }
                        }
                    }

                    // web preregistration
                    if(isset($_POST["preregistrations"]))
                        $preregistrations = $_POST["preregistrations"];
                    else
                        $preregistrations = array();

                    $found_preregistrations = array();
                    $existing_preregistrations = HelpdeskGroupWebPreregistration::model()->findAllByAttributes(array('helpdesk_group' => $id));

                    if (is_array($existing_preregistrations)) {
                        // delete preregistrations not in the array
                        foreach ($existing_preregistrations as $key => $value) {
                            if (!in_array($value->web_preregistration, $preregistrations))
                                $value->delete();
                            else
                                array_push($found_preregistrations, $value->web_preregistration);
                        }
                    }

                    // add any new ones
                    if (is_array($preregistrations)) {
                        foreach ($preregistrations as $value) {
                            if (!in_array($value, $found_preregistrations))
                            {
                                $new_row = new HelpdeskGroupWebPreregistration;
                                $new_row->web_preregistration = $value;
                                $new_row->helpdesk_group = $model->id;
                                $new_row->save();
                            }
                        }
                    }
                }

                $transaction->commit();

                $this->redirect(array('admin'));

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
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $roles = HelpdeskGroupUserRole::model()->findAllByAttributes(array('helpdesk_group' => $id));
        foreach ($roles as $role) {
            $role->delete();
        }

        $preregistrations = HelpdeskGroupWebPreregistration::model()->findAllByAttributes(array('helpdesk_group' => $id));

        foreach ($preregistrations as $preregistration) {
            $preregistration->delete();
        }
		
        HelpDeskGroup::model()->deleteByPK($id);

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new HelpDeskGroup('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['HelpDeskGroup']))
            $model->attributes = $_GET['HelpDeskGroup'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return HelpDeskGroup the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = HelpDeskGroup::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

   /**
     * Performs the AJAX validation.
     * @param VisitorType $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'helpdesk-group-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
    public function actionAdminAjax() {
        $model = new VisitorType('search');
        $model->unsetAttributes();  // clear any default values
      

        $this->renderPartial('_admin', array(
            'model' => $model,
                ), false, true);
    }
   

}
