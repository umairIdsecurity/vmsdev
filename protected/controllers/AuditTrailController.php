<?php

class AuditTrailController extends Controller {
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';


	private $query = "select v.id,
						ct.name,
						r.reason,
						v.date_check_in,
						v.time_check_in,
						t.code,
						p.first_name,
						p.middle_name,
						p.last_name,
						p.email,
						p.contact_number,
						v.created_by,
						v.closed_by,
						'hyperlink to visit'
						from visit v
						join visitor p on p.id = v.visitor
						left join card_generated c on c.id = v.card
						join company t on t.id = t.tenant
						left join visit_reason r on r.id = v.reason
						left join card_type ct on v.card_type = ct.id
						where tenant = 'tenant if not superadmin'
						and tenant_agent = 'tenant_agent if user is in a tenant_agent'
						";





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
				'actions'    => array('view', 'cvms', 'avms'),
				'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION)',
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
	 * Manages all models.
	 */
	public function actionCvms() {
		$model = new AuditTrail('search');
		$model->unsetAttributes(); // clear any default values
		if (isset($_GET['AuditTrail'])) {
			$model->attributes = $_GET['AuditTrail'];
		}

		$this->render('_cvms', array(
			'model' => $model,
		));
	}

	public function actionAvms() {
		$model = new AuditTrail('search');
		$model->unsetAttributes(); // clear any default values
		if (isset($_GET['AuditTrail'])) {
			$model->attributes = $_GET['AuditTrail'];
		}

		$this->render('_avms', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AuditTrail the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id) {
		$model = AuditTrail::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AuditTrail $model the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'audit-trail-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
