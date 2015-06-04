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
            $date_check_in = $visitor['date_check_in'];
            $time=strtotime($date_check_in);
            $month=date("m",$time);
            $year=date("Y",$time);
            $m = intval($month);
            $y = intval($year);
            $countArray[$y][$m][]=1;
        }
        $reversed = $this->get1YearInterval();
        $this->render("newvisitorcount", array("results"=>$countArray,"reversed"=>$reversed));
       
    } 
    
    public function getTodayAnd1WeekBack(){
        $returnArray = array();
        $time = new DateTime('now');
        $from = $time->modify('-14 week');
        $to = new DateTime('now');
        
        $returnArray[0]=$from;
        $returnArray[1]=$to;
        return $returnArray;
    }
    
    public function getTodayAnd1YearBack(){
        $returnArray = array();
        $time = new DateTime('now');
        $from = $time->modify('-1 year');
        $to = new DateTime('now');
        
        $returnArray[0]=$from;
        $returnArray[1]=$to;
        return $returnArray;
    }
    
    public function get1YearInterval(){
        $today = time();
        $oneMonthLater = strtotime("+1 months", $today);
        $now = date('Y-m-d', $oneMonthLater);

        $time = new DateTime($now);


        $from = $time->modify('-1 year');

        $to = new DateTime($now);

        $start = new DateTime($from->format('Y-m-d'));
        $interval = new DateInterval('P1M');
        $end = new DateTime($to->format('Y-m-d'));
        $period = new DatePeriod($start, $interval, $end);

        $periods=[];
        foreach ($period as $dt) {
             $periods[]=array($dt->format('F Y'),$dt->format('n-Y'));
        }
        $reversed = array_reverse($periods);
        return $reversed;
    }
    
    public function get4WeeksInterval(){
        
    }
    
    
}
