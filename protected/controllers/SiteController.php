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
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        $this->layout = '//layouts/column2';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
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
                if ($session['role'] == Roles::ROLE_ADMIN || $session['role'] == Roles::ROLE_AGENT_ADMIN || $session['role'] == Roles::ROLE_SUPERADMIN) {
                    $this->redirect('index.php?r=user/admin');
                } else if ($session['role']==Roles::ROLE_AGENT_OPERATOR || $session['role']==Roles::ROLE_OPERATOR){
                    $this->redirect('index.php?r=site/selectworkstation&id=' . $session['id']);
                }
                else {
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

    public function actionUpload($id) {
        $this->renderpartial('upload');
    }

    public function actionSelectWorkstation($id) {
        $aArray = array();

        $connection = Yii::app()->db;
        $sql = "SELECT workstation.id,workstation.name as name
                        FROM user_workstation 
                        LEFT JOIN workstation ON workstation.id=user_workstation.`workstation`
                        WHERE user_workstation.`user`='$id' ORDER BY workstation.name";
        $command = $connection->createCommand($sql);
        $row = $command->queryAll();

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
        
        if(isset($_POST['submit']) && $_POST['userWorkstation']!=''){
            $session = new CHttpSession;
            $session->open();
            $session['workstation'] = $_POST['userWorkstation'];
            $this->redirect('index.php?r=dashboard');
        }else {
            
        }

        // display the login form
        $this->render('selectworkstation', array('workstations' => $aArray));
    }

}
