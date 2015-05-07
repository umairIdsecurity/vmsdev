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
		
		$table = Yii::app()->db->schema->getTable('helpdesk_group');
        if(!isset($table)){

           echo "not set ";
		   exit();
           /* $this->execute("

                   CREATE TABLE IF NOT EXISTS `helpdesk_group` (
                            `id` bigint(20) NOT NULL AUTO_INCREMENT,
                            `name` varchar(255) NOT NULL,
                            `order_by` int(6) DEFAULT NULL,
							`created_by` bigint(20) DEFAULT NULL,
							`is_deleted` bigint(1) DEFAULT 0,
                            PRIMARY KEY (`id`)                             )
            ");
*/
        }
		echo "set";
		exit();
		$session = new CHttpSession;
        $model = new HelpDeskGroup;
        if(isset($_POST['HelpDeskGroup']))
		{
			$model->attributes=$_POST['HelpDeskGroup'];
			$model->created_by = $session['id'];
			if($model->save())
				$this->redirect(array('admin','id'=>$model->id));
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
