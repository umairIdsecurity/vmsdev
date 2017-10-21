<?php

class CardTypeController extends Controller {

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
                'actions' => array('create', 'update', 'edit', 'admin', 'delete', 'index', 'view', 'selectWorkstation', 'backtext'),
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
    public function actionCreate() {
        $model = new CardType;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CardType'])) {
            $model->attributes = $_POST['CardType'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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

        if (isset($_POST['CardType'])) {
            $model->attributes = $_POST['CardType'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionEdit() {
        if (yii::app()->request->isPostRequest) {
            if (isset($_POST['card_id'])&&isset($_POST['tenantID'])) {
				$Criteria = new CDbCriteria();
				$Criteria->condition = "card_id=".$_POST['card_id']." and tenant_id=".$_POST['tenantID'];
                //$card = CardType::model()->findByPk($_POST['card_id']);
				$card= TenantCardType::model()->find($Criteria);
                $card->back_text = $_POST['back-card'];
                $card->save(false);
                $this->redirect(array('workstation/admin'));
            }
        } else {
            throw new CHttpException('400', "Bad Request");
        }
    }

    public function actionBacktext() {
        if (yii::app()->request->isAjaxRequest) {
			$Criteria = new CDbCriteria();
			$Criteria->condition = "card_id=".$_POST['cardid']." and tenant_id=".$_POST['tenantid'];
            //$cardType = CardType::model()->findByPk($_POST['cardid']);
			$cardType = TenantCardType::model()->find($Criteria);
            echo $cardType->back_text;
            die;
        } else {
             throw new CHttpException('400', "Bad Request");
        }
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
        $dataProvider = new CActiveDataProvider('CardType');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new CardType('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CardType']))
            $model->attributes = $_GET['CardType'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CardType the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = CardType::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CardType $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'card-type-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionSelectWorkstation() {
        if (isset($_POST['workstation'])) {
            //$resultMessage['data'] = array('workstation' => $_POST['workstation']);
            $cardTypeWorkstationModel = WorkstationCardType::model()->findAllByAttributes(
                    array('workstation' => $_POST['workstation'])
            );
        }

        $html = $this->renderPartial('_card_types', array('cardTypeWorkstationModel' => $cardTypeWorkstationModel), true);
        echo json_encode(array('html' => $html));
    }

}
