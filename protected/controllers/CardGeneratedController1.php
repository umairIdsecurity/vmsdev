<?php

class CardGeneratedController extends Controller {

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
                'actions' => array('create', 'update', 'admin', 'delete', 'print', 'preprint', 'pdfprint'),
                'users' => array('@'),
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
    public function actionCreate($visitId, $preCardNo = '') {
        $session = new CHttpSession;
        $model = new CardGenerated;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CardGenerated'])) {
            if ($_POST['CardGenerated']['tenant_agent'] == '') {
                $_POST['CardGenerated']['tenant_agent'] = null;
            }

            $model->attributes = $_POST['CardGenerated'];

            if (empty($preCardNo)) {
                if (isset($_POST['CardGenerated']['enter_card_number']) && !empty($_POST['CardGenerated']['enter_card_number'])) {
                    $model->card_number = $_POST['CardGenerated']['enter_card_number'];
                } else {
                    $model->card_number = $_POST['CardGenerated']['card_number'];
                }
            } else {
                $model->card_number = $preCardNo;
            }

            //$model->tenant = $session['tenant'];
            //becasue of https://ids-jira.atlassian.net/browse/CAVMS-1197
            if ($model->save()) {
                Visit::model()->updateByPk($visitId, array('card' => $model->id));
                //$tenant = User::model()->findByPk($model->tenant);

                $company = Company::model()->findByPk($_POST['CardGenerated']['tenant']);

                if (!empty($company)) {
                    $cardCount = $company->card_count;

                    if ($cardCount != "") {
                        $company->card_count = $cardCount + 1;
                    } else {
                        $company->card_count = 1;
                    }

                    $company->save(false);
                }
                
                /*Company::model()->updateByPk($tenant->company, array(
                    'card_count' => (Company::model()->findByPk($tenant->company)->card_count)+1,
                ));*/
            }

            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->end();
            }

        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionPrint($id = NULL) {

        $session = new CHttpSession;
        $this->layout = '//layouts/column1';

        $cardGenerated = new CardGenerated;
        $cardGeneratedService = new CardGeneratedServiceImpl();
        $session = new CHttpSession;
        $model = Visit::model()->findByPk($id);
        $visitorModel = Visitor::model()->findByPk($model->visitor);
        $tenant = User::model()->findByPk($visitorModel->tenant);
        $companyTenant = Company::model()->findByPk($tenant->company);

        /* get card code */
        $card = CardGenerated::model()->findByPk($model->card);

 
        $print_count = CardGenerated::model()->findByPk($model->card)->print_count;

        if ($session['count'] == 1) {

            CardGenerated::model()->updateByPk($model->card, array(
                'date_printed' => date("d-m-Y"),
                'date_expiration' => date("d-m-Y"),
                'visitor_id' => $model->visitor,
                'tenant' => $model->tenant,
                'tenant_agent' => $model->tenant_agent,
                'card_status' => CardStatus::ACTIVE,
                'created_by' => $session['id'],
                'print_count' => $print_count + 1,
            ));

            $usernameHash = hash('adler32', $visitorModel->email);
            $unique_fileName = 'card' . $usernameHash . '-' . time() . ".png";
            $path = "uploads/card_generated/" . $unique_fileName;
            Yii::app()->params['photo_unique_filename'] = $unique_fileName;

            $connection = Yii::app()->db;
            $command = $connection->createCommand('INSERT INTO photo '
                    . "(filename, unique_filename, relative_path) VALUES ('" . $unique_fileName . "','" . $unique_fileName . "','" . $path . "' )");
            $command->query();


            $photoUpload = Photo::model()->findByAttributes(array('unique_filename' => $unique_fileName));
            if (count($photoUpload) > 0) {
                CardGenerated::model()->updateByPk($model->card, array(
                    'card_image_generated_filename' => $photoUpload->id,
                ));
            }
        }

        $this->renderPartial('print', array(
            'model' => $model,
            'visitorModel' => $visitorModel,
                ), false, true);
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

        if (isset($_POST['CardGenerated'])) {
            $model->attributes = $_POST['CardGenerated'];
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
        $dataProvider = new CActiveDataProvider('CardGenerated');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new CardGenerated('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CardGenerated']))
            $model->attributes = $_GET['CardGenerated'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }
    /**
     * Generate PDFs for VIC.
     */
    public function actionPdfprint($id) {
        
        if (!isset($_GET['type'])){
            throw new CHttpException(404,'Parameter missing');
        } else {
            $type=$_GET['type'];
        }
            
        
        #data of user of card
        $model = Visit::model()->findByPk($id);
        $a = $model->card;

        $visitorModel = Visitor::model()->findByPk($model->visitor);

        //needs photo of the visitor as stored in DB to be shown in printing the card
        $userPhotoModel = Photo::model()->findByPk($visitorModel->photo);

        //needs photo of the comapny as stored in DB to be shown in the footer while printing the card
        //$tenant = User::model()->findByPk($visitorModel->created_by);
        $company = Company::model()->findByPk($visitorModel->tenant);
        $companyPhotoModel =  Photo::model()->findByPk($company->logo);

        
        $data = array('model' => $model, 'visitorModel' => $visitorModel, 'type' => $type, 'userPhotoModel' => $userPhotoModel, 'companyPhotoModel' => $companyPhotoModel);

        if($type == 1){
            $html2pdf = Yii::app()->ePdf->HTML2PDF('P', 'A4', 'en',TRUE,'UTF-8',array(0,0,0,0));
        }else{
            $html2pdf = Yii::app()->ePdf->HTML2PDF('P', 'CARDPRINT', 'en',TRUE,'UTF-8',array(0,0,0,0));
        }

        if ($model->card_type > 4) {
            $html2pdf->WriteHTML($this->renderPartial('printpdf', $data, true));
        } else {
            //$html2pdf->WriteHTML($this->renderPartial('_card-corporate', $data, true));
             $html2pdf->WriteHTML($this->renderPartial('printpdf', $data, true));
        }


       $html2pdf->Output();
       // $this->render('printpdf', $data);

    }

    public function actionPreprint($id) {

        if (!isset($_GET['type'])){
            throw new CHttpException(404,'Parameter missing');
        } else {
            $type=$_GET['type'];
        }
        #data of user of card
        $model = Visit::model()->findByPk($id);
        $visitorModel = Visitor::model()->findByPk($model->visitor);
        $data = array('model' => $model, 'visitorModel' => $visitorModel, 'type' => $type);

        if ($model->card_type > 4) {
            $this->renderPartial('printpdf', $data);
        } else {
            $this->renderPartial('_card-corporate', $data);
        }

    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CardGenerated the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = CardGenerated::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CardGenerated $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'card-generated-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
