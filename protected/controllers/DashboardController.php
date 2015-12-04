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
                'actions' => array('create', 'index', 'update', 'addHost', 'content', 'ContactSupport','helpDesk'),
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
        // Auto Closed TO Closed the EVIC and 24 Hour Visits
        Visit::model()->setClosedAutoClosedVisits();
        $model = new Visit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visit']))
            $model->attributes = $_GET['Visit'];
//        $this->render('viewdashboard', array(
//            'model' => $model,
//        ));
        $this->render('admindashboard', array(
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
        //Archive Expired 48 Old SAVED Visits
        Visit::model()->archivePregisteredOldVisits();
        // Closed/Expired Visits that will expire today or already Expired
        Visit::model()->setExpireOrClosedVisits(Yii::app()->user->tenant);
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

            if ($model->validate()) {
                $contactPersonModel = ContactPerson::model()->findByPk($model->contact_person_name);
                $reason = Reasons::model()->findByPk($contactPersonModel->reason_id);

                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= "From: {$userModel->email}\r\nReply-To: {$userModel->email}";

                $content = "Reason: ".$reason->reason_name."<br><br>Message: ".$model->message . "<br><br>~This message was sent via Visitor Management System~";

                $contactModel = new ContactSupport;
                $contactModel->contact_person_id = $contactPersonModel->id;
                $contactModel->contact_reason_id = $reason->id;
                $contactModel->user_id = $userModel->id;
                $contactModel->contact_message = $model->message;
                $contactModel->save();

                EmailTransport::mail($contactPersonModel->contact_person_email, "Contact Support", $content, $headers);

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
	$helpDeskGroupRecords = HelpDeskGroup::model()->getAllHelpDeskGroup(true);
        $session = new CHttpSession;
        $this->render('helpdesk', array(
            'helpDeskGroupRecords' => $helpDeskGroupRecords
        ));
    }

}
