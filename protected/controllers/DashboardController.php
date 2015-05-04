<?php

class DashboardController extends Controller {

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
                'actions' => array('create', 'update', 'addHost', 'content', 'ContactSupport'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('ViewMyVisitors'),
                'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_STAFFMEMBER)',
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index'),
                'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_SUPERADMIN_DASHBOARD)',
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('AdminDashboard'),
                'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION_DASHBOARD)',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new User;


        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
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

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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
     * Lists all models.
     */
    public function actionIndex() {
        $session = new CHttpSession;
        $session['lastPage'] = 'dashboard';
        $this->layout = '//layouts/column2';
        $model = new Visit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visit']))
            $model->attributes = $_GET['Visit'];

        $this->render('viewdashboard', array(
            'model' => $model,
        ));
    }

    public function actionContent() {
        $this->layout = '//layouts/contentIframeLayout';
        $this->render('index');
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionViewMyVisitors() {
        $this->layout = '//layouts/column2';
        $model = new Visit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visit']))
            $model->attributes = $_GET['Visit'];

        $this->render('viewmyvisitors', array(
            'model' => $model,
        ));
    }

    public function actionAdminDashboard() {
        $this->layout = '//layouts/column2';
        $session = new CHttpSession;
        $session['lastPage'] = 'dashboard';
        $model = new Visit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visit'])) {
            $model->attributes = $_GET['Visit'];
        }

        $this->render('admindashboard', array(
            'model' => $model,
        ));
    }

    public function actionAddHost() {
        $userModel = new User();
        $patientModel = new Patient();

        $this->renderPartial('_addhost', array(
            'userModel' => $userModel,
            'patientModel' => $patientModel
                ), false, true);
    }

    public function actionContactSupport() {
        $session = new CHttpSession;
        $user_id = Yii::app()->user->id;
        $userModel = User::model()->findByPk($user_id);

        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            $model->name = $userModel->first_name . ' ' . $userModel->last_name;
            $model->email = $userModel->email;

            if ($model->validate()) {
                $headers = "From: {$model->email}\r\nReply-To: {$model->email}";

                $content = $model->message . "\r\n\r\n~This message was sent via Visitor Management System~";

                switch ($session['role']) {
                    case Roles::ROLE_SUPERADMIN:
                        $to_address = 'support@idsecurity.com.au';
                        break;

                    case Roles::ROLE_ADMIN:
                        if ($model->subject == 'Technical Support') {
                            $to_address = 'support@idsecurity.com.au';
                        } else {
                            if ($session['tenant'] == Yii::app()->user->id) {
                                $email = User::model()->find("role = " . Roles::ROLE_SUPERADMIN)->email;
                            } else {
                                $email = User::model()->findByPk($session['tenant'])->email;
                            }
                            $to_address = $email;
                        }
                        break;


                    default:
                        if ($model->subject == 'Technical Support') {
                            $to_address = 'support@idsecurity.com.au';
                        } else {

                            $to_address = User::model()->findByPk($session['tenant'])->email;
                        }

                        break;
                }


                mail($to_address, $model->subject, $content, $headers);

                Yii::app()->user->setFlash(
                        'contact', 'Thank you for contacting us. We will respond to you as soon as possible.'
                );
                $this->refresh();
            }
        }

        $this->render('contactsupport', array(
            'model' => $model,
            'userModel' => $userModel
        ));
    }
	
	  public function actionHelpDesk() {
        $session = new CHttpSession;
        $this->render('helpdesk');
    }

}
