<?php

class ReportsController extends Controller
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
				'actions'=>array('visitorsByProfiles'),
				'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION)',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionVisitorsByProfiles() {
        $dateCondition='';
        
        $time = new DateTime('now');
        $from = $time->modify('-1 year');
        $to = new DateTime();
        
        // Post Date
        $dateFromFilter = Yii::app()->request->getParam("date_from_filter");
        $dateToFilter = Yii::app()->request->getParam("date_to_filter");
        
         if( !empty($dateFromFilter) && !empty($dateToFilter) ) {
            $from = new DateTime($dateFromFilter);
            $to = new DateTime($dateToFilter);
       }
        
        $dateCondition = '(visits.date_check_in BETWEEN "'.$from->format('d-m-Y').'"'
                                . ' AND "'.$to->format('d-m-Y').'") OR (visits.date_check_in BETWEEN "'.$from->format('Y-m-d').'"'
                                . ' AND "'.$to->format('Y-m-d').'") AND (t.is_deleted = 0) AND (visits.is_deleted = 0) AND (visits.visit_status != 2)';

        $visitors = Yii::app()->db->createCommand()
                    ->select('min(visits.id) as visitId,min(visits.date_check_in) as date_check_in,t.first_name,t.id')
                    ->from('visitor t')
                    ->join('visit visits' , '(t.id=visits.visitor)')
                    ->where($dateCondition)
                    ->group('t.id')
                    ->queryAll(); // this will be returned as an array of arrays
       
        $countArray=array();
       
        foreach($visitors as $visitor){
            $date = DateTime::createFromFormat("Y-m-d", $visitor['date_check_in']);
            $m = intval($date->format("m"));
            $y = intval($date->format("Y"));
            
            $countArray[$y][$m][]=1;
        }
        
          
        $this->render("newvisitorcount", array("results"=>$countArray));
        
       
    } 
}
