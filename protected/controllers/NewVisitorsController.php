<?php

class NewVisitorsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
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
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('create', 'update', 'admin', 'delete','adminAjax', 'visitorsByProfiles'),
				'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION)',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
//	public function actionView($id)
//	{
//		$this->render('view',array(
//			'model'=>$this->loadModel($id),
//		));
//	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new NewVisitors;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['NewVisitors']))
		{
			$model->attributes=$_POST['NewVisitors'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['NewVisitors']))
		{
			$model->attributes=$_POST['NewVisitors'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
//	public function actionIndex()
//	{
//		$dataProvider=new CActiveDataProvider('NewVisitors');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
//	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new NewVisitors('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['NewVisitors']))
			$model->attributes=$_GET['NewVisitors'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return NewVisitors the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=NewVisitors::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param NewVisitors $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='new-visitors-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
    public function actionVisitorsByProfiles() {
        // Post Date
        $dateFromFilter = Yii::app()->request->getParam("date_from_filter");
        $dateToFilter = Yii::app()->request->getParam("date_to_filter");
        
        $dateCondition='';
        
        if( !empty($dateFromFilter) && !empty($dateToFilter) ) {

            $from = new DateTime($dateFromFilter);
            $to = new DateTime($dateToFilter);
            
            $dateCondition = ' AND ((visits.date_check_in BETWEEN "'.$from->format('d-m-Y').'"'
                                . ' AND "'.$to->format('d-m-Y').'") OR (visits.date_check_in BETWEEN "'.$from->format('Y-m-d').'"'
                                . ' AND "'.$to->format('Y-m-d').'"))';
        }
        
        $visitors = Yii::app()->db->createCommand()
                    ->select('min(visits.id) as visitId,visits.date_check_in,t.first_name,t.id')
                    ->from('visitor t')
                    ->join('visit visits' , '(t.id=visits.visitor) AND (visits.is_deleted = 0) AND (visits.visit_status != 2)' . $dateCondition)
                    ->where('t.is_deleted = 0')
                    ->group('t.id')
                    ->queryAll(); // this will be returned as an array of arrays
        
        
        $jan=$feb=$march=$april=$may=$june=$july=$aug=$sep=$oct=$nov=$dec=0;
        
        $plottingArr = array();
        
        foreach ($visitors as $visitor) {
            $date_check_in=$visitor['date_check_in'];
            if(!empty($date_check_in)){
                $parts = explode('-',$date_check_in);
                $month = $parts[1];
                
                switch ($month) {
                    case "01":
                        $jan += 1;
                        break;
                    case "02":
                        $feb += 1;
                        break;
                    case "03":
                        $march += 1;
                        break;
                    case "04":
                        $april += 1;
                        break;
                    case "05":
                        $may += 1;
                        break;
                    case "06":
                        $june += 1;
                        break;
                    case "07":
                        $july += 1;
                        break;
                    case "08":
                        $aug += 1;
                        break;
                    case "09":
                        $sep += 1;
                        break;
                    case "10":
                        $oct += 1;
                        break;
                    case "11":
                        $nov += 1;
                        break;
                    case "12":
                        $dec += 1;
                        break;
                    default:
                        
                }
                
            }
        }
        
        $datasets = array(
            array('Visitors', 'Visitors Regiseration'),
            array('January',$jan),
            array('Febuary',$feb),
            array('March',$march),
            array('April',$april),
            array('May',$may),
            array('June',$june),
            array('July',$july),
            array('August',$aug),
            array('September',$sep),
            array('October',$oct),
            array('November',$nov),
            array('December',$dec),
        );
        
        $total = $jan+$feb+$march+$april+$may+$june+$july+$aug+$sep+$oct+$nov+$dec;
        
//        echo $total;
//        
//        echo '<pre>';
//        print_r($datasets);
//        die();
        
        
        
//        $plottingArr = array(
//            'January' => $jan,
//            'Febuary' => $feb,
//            'March' => $march,
//            'April' => $april,
//            'May' => $may,
//            'June' => $june,
//            'July' => $july,
//            'August' => $aug,
//            'September' => $sep,
//            'October' => $oct,
//            'November' => $nov,
//            'December' => $dec,
//        );
        
        $this->render("newvisitorcount", array("results"=>$datasets,"total" => $total));
    } 
}
