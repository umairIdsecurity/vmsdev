<?php

class PasswordController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

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
            
            array('allow',
                'actions' => array('update'),
                'expression' => 'Yii::app()->controller->allowOnlyOwner()',
            ),
            
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function allowOnlyOwner() {

        $example = Password::model()->findByPk($_GET["id"]);
        return $example->id === Yii::app()->user->id;
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

        if (isset($_POST['Password'])) {
            $model->attributes = $_POST['Password'];
		
            $user = User::model()->findByPK($id);
            
           // if (User::model()->validatePassword($_POST['Password']['currentpassword'], $user->password)) {
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', 'Password successfully updated');
					  $templateParams = array(
								'email' => $user->email,
									);
	
				//TODO: Change to YiiMail
						$emailTransport = new EmailTransport();
						$emailTransport->sendResetPasswordConfirmationEmail(
						$templateParams, $user->email, $user->first_name . ' ' . $user->last_name
						);
                    $this->redirect(array('user/profile', 'id' => $model->id));
                }
//            } else {
//                Yii::app()->user->setFlash('error', "Current password does not match password in your account. ");
//            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Password the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Password::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Password $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'password-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
