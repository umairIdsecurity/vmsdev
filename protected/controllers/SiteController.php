<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public $layout = '//layouts/noheaderLayout';

    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->redirect('index.php?r=site/login');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        $this->layout = '//layouts/column2';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {

                $session = new CHttpSession;
                switch ($session['role']) {
                    case Roles::ROLE_AGENT_OPERATOR:
                    case Roles::ROLE_OPERATOR:
                        if (!($model->findWorkstations($session['id']))) {
                            Yii::app()->user->setFlash('error', "No workstations currenlty assigned to you. Please ask your administrator. ");
                        } else {
                            $this->redirect('index.php?r=site/selectworkstation&id=' . $session['id']);
                        }
                        break;
                    case Roles::ROLE_STAFFMEMBER:
                        $this->redirect('index.php?r=dashboard/viewmyvisitors');
                        break;
                    case Roles::ROLE_ADMIN:
                    case Roles::ROLE_AGENT_ADMIN:
                        $this->redirect('index.php?r=dashboard/admindashboard');
                        break;
                    default:
                        $this->redirect('index.php?r=dashboard');
                }
            }
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect('index.php?r=site/login');
    }

    /**
     * Forgot password
     */
    public function actionForgot() {

        $model = new PasswordForgotForm();

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'forgot-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['PasswordForgotForm'])) {
            $model->attributes = $_POST['PasswordForgotForm'];
            if ($model->validate() && $model->restore()) {
                Yii::app()->user->setFlash('success', "Please check your email for reset password instructions");
                $this->redirect('index.php?r=site/login');
            }
        }

        $this->render('forgot', array('model' => $model));
    }

    /**
     * Reset password
     */
    public function actionReset() {

        $model = new PasswordResetForm();

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'password-reset-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        $hash = Yii::app()->request->getParam('hash');

        /** @var PasswordChangeRequest $passwordRequest */
        $passwordRequest = PasswordChangeRequest::model()->findByAttributes(array('hash' => $hash));

        if (!$passwordRequest) {
            Yii::app()->user->setFlash('error', "Reset password hash '$hash' not found. Looks like your reset password link is broken.");
        }

        if ($error = $passwordRequest->checkPasswordRequestByHash()) {
            Yii::app()->user->setFlash('error', $error);
            $this->redirect('index.php?r=site/forgot');
        }

        if (isset($_POST['PasswordResetForm'])) {
            $model->attributes = $_POST['PasswordResetForm'];
            if ($model->validate()) {
                /** @var User $user */
                $user = User::model()->findByPk($passwordRequest->user_id);
                $user->changePassword($model->password);
                $passwordRequest->markAsUsed();
                Yii::app()->user->setFlash('success', "Your password has been changed successfully");
                $this->redirect('index.php?r=site/login');
            }
        }

        $this->render('reset', array('model' => $model));
    }

    public function actionUpload($id) {
        $this->renderpartial('upload');
    }

    public function actionSelectWorkstation($id) {
        $row = Workstation::model()->findWorkstationAvailableForUser($id);

        if (count($row) > 0) {
            foreach ($row as $key => $value) {

                $aArray[] = array(
                    'id' => $value['id'],
                    'name' => $value['name'],
                );
            }
        } else {
            $aArray[] = array(
                'id' => '',
                'name' => '-',
            );
        }

        if (isset($_POST['submit']) && $_POST['userWorkstation'] != '') {
            $session = new CHttpSession;
            $session->open();
            $session['workstation'] = $_POST['userWorkstation'];
            $this->redirect('index.php?r=dashboard/adminDashboard');
        }

        // display the login form
        $this->render('selectworkstation', array('workstations' => $aArray));
    }

    public function actionTouch(){
          if(touch(Yii::getPathOfAlias('application').'/assets')){
              echo 'Assets folder modified successfully';
          }
    }
    
    
}
