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
				'actions'=>array('visitorsByProfiles','profilesAvmsVisitors'),
				'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION)',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
    /*
     * This is MAIN function renders daily,weekly or monthly new visitor profiles
     * all actions in new visitors from profiles link are coming to here
     * and here decision are make that which report to be RENDERED
     */    
    public function actionVisitorsByProfiles() {
        
        $rangeRadio = Yii::app()->request->getParam("rangeRadio");
         // Post Date
        $dateFromFilter = Yii::app()->request->getParam("date_from_filter", date("Y-m-d", strtotime("-1 year") ));
        $dateToFilter = Yii::app()->request->getParam("date_to_filter", date("Y-m-d", time()));
        
        if(!empty($rangeRadio)) {
            if($rangeRadio == "weekly"){
                $weeks = Yii::app()->request->getParam("weeklyInterval");
                if(empty($weeks)){
                    $weeks="1";
                    $this->visitorsByProfilesWeekly($weeks);
                }else{
                    $this->visitorsByProfilesWeekly($weeks);
                }
            }
            elseif($rangeRadio == "daily"){
               $date30DaysBack = $this->getTodayAnd30DaysBack();
               $this->newVisitorsDaily($dateFromFilter,$dateToFilter,$date30DaysBack[0],$date30DaysBack[1]);
            }
            else{
                $date1YearBack = $this->getTodayAnd1YearBack();
                $this->newVisitors($dateFromFilter,$dateToFilter,$date1YearBack[0],$date1YearBack[1]);
            }
        } 
        else{
            $date1YearBack = $this->getTodayAnd1YearBack();
            $this->newVisitors($dateFromFilter,$dateToFilter,$date1YearBack[0],$date1YearBack[1]);
        }
       
    } 
    
    /*
     * this function returns today date and 30 days back date only from today
     * e.g. if today date is 11-june-2015
     * it will give us in array having two dates 11-06-2015,one month back date from today
     */
    public function getTodayAnd30DaysBack(){
        $returnArray = array();
        
        $time = new DateTime();
        $from = $time->modify('-30 days');
        $to = new DateTime();
        
        $returnArray[0]=$from;
        $returnArray[1]=$to;
        return $returnArray;
    }
    
    /*
     * @param $dateFromFilter: user input from date
     * @param $dateFromFilter: user input to date
     * @param $from: default from date(came from getTodayAnd30DaysBack()) if user not selected any filter input
     * @param $to: user input to date(came from getTodayAnd30DaysBack()) if user not selected any filter input
     * @param profile type having values of ALL, CORPORATE, VIC, ASIC
     * this function renders daily new visitor profiles
     * based on default 30 days daily new visitor profiles
     * OR in a specified date range based on from and to filters
     */
    function newVisitorsDaily($dateFromFilter,$dateToFilter,$from,$to){
        
        if( !empty($dateFromFilter) && !empty($dateToFilter) ) {
            $from = new DateTime($dateFromFilter);
            $to = new DateTime($dateToFilter);
        }
        
        $visitors = $this->getNewVisitorsData ($from,$to );

        $countArray=array();
       
        foreach($visitors as $visitor){
            $date_check_in = $visitor['date_check_in'];
            $time=strtotime($date_check_in);
            $month=date("m",$time);
            $year=date("Y",$time);
            $day=date("d",$time);
            $m = intval($month);
            $y = intval($year);
            $d = intval($day);
            $countArray[$y][$m][$d][]=1;
        }
        
        $reversed = $this->get30DaysInterval();
        $this->render("newvisitorcount", array("results"=>$countArray,"reversed"=>$reversed));
    }
    
    /*
     * @param $dateFromFilter: user input from date
     * @param $dateFromFilter: user input to date
     * @param $from: default from date(came from getTodayAnd1YearBack()) if user not selected any filter input
     * @param $to: user input to date(came from getTodayAnd1YearBack()) if user not selected any filter input
     * this function renders monthly new visitor profiles
     * based on default 1 year monthly new visitor profiles
     * OR in a specified date range based on from and to filters
     */
    public function newVisitors($dateFromFilter,$dateToFilter,$from,$to){
        
        if( !empty($dateFromFilter) && !empty($dateToFilter) ) {
            $from = new DateTime($dateFromFilter);
            $to = new DateTime($dateToFilter);
        }
       
        $countArray=array();
        
        $visitors = $this->getNewVisitorsData ($from, $to);
        
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
    
    /*
     * @param $weeks(last 1,2,3,4 weeks). $weeks variable is integer
     
     * this function renders weekly new visitor profiles
     * 
     */
    function visitorsByProfilesWeekly($weeks){
      
        if( $weeks == 1 ){
            $lastWeeks = "-1 week";
        }
        else{
            $lastWeeks = "-".$weeks." weeks";
        }
        
        $time = new DateTime();
        $from = $time->modify($lastWeeks);
        $to = new DateTime();
        
        // Get New visitors between From and To date
        $data = $this->getNewVisitorsData($from,$to);
        
        $return = array();  
                
        if( count($data) ){
            for( $i = 1; $i <= $weeks; $i++ ) {
              
                $wk = $i == 1 ? "week":"weeks";           
                $to_stamp = "-".($i-1)." ".$wk;              
                $from_stamp =  "-".$i." ".$wk;                
                
                $forToDate = new DateTime();
                $forFromDate = new DateTime();
                
                $to_date = strtotime($forToDate->modify($to_stamp)->format("Y-m-d"));
                $from_date = strtotime($forFromDate->modify($from_stamp)->format("Y-m-d"));
                            
                foreach( $data as $key=>$val ) { 
                    $checkin_date = $val['date_check_in']; 
                    if(strtotime($checkin_date) >= $from_date && strtotime($checkin_date) <= $to_date ) {
                        $return[$i][] = 1;
                   }
                }
            }
        }
        
                  
        $this->render("newvisitorcount",array("data" => $return, "weeks" => $weeks));
    }
    
    /**
     * Get New Visitors by Dates
     * 
     * @param date $from From date
     * @param date $to to date 
     * @return array Data array
     */
    function getNewVisitorsData( $from, $to ) {
        $dateCondition = "( DATE(t.date_created) BETWEEN  '".$from->format("Y-m-d")."' AND  '".$to->format("Y-m-d")."' )"
                         ." AND (t.is_deleted =0 ) AND (t.profile_type='CORPORATE')";
        
        $data = Yii::app()->db->createCommand()
                ->select("DATE(t.date_created) AS date_check_in, t.first_name, t.id") 
                ->from("visitor t")
                ->where($dateCondition)
                ->queryAll();
        return $data;
    }
    
    

    /*
     * this function returns today date and 1 year back date only from today
     * e.g. if today date is 11-june-2015
     * it will give us in array having two dates 11-06-2015,11-06-2014
     */
    public function getTodayAnd1YearBack(){
        $returnArray = array();
        
        $time = new DateTime();
        $from = $time->modify('-1 year');
        $to = new DateTime();
        
        $returnArray[0]=$from;
        $returnArray[1]=$to;
        return $returnArray;
    }
    
    /*
     * this function returns a 1 year interval month from today
     * e.g. if today date is 11-june-2015
     * it will give us in array of array having two index each of data 6-2015(June-2015),5-2015(May-2015)
     * and so on after 1 year from today
     */
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
    
    /*
     * this function returns a 30 days interval dates from today
     * e.g. if today date is 11-june-2015
     * it will give us in array having 11-6-2015,10-6-2015,9-6-2015 
     * and so on after 30 days from today
     */
    public function get30DaysInterval(){
        
        $today = time();
        $oneDayLater = strtotime("+1 days", $today);
        $now = date('Y-m-d', $oneDayLater);

        $time = new DateTime($now);

        $from = $time->modify('-30 days');

        $to = new DateTime($now);

        $start = new DateTime($from->format('Y-m-d'));
        $interval = new DateInterval('P1D');
        $end = new DateTime($to->format('Y-m-d'));
        $period = new DatePeriod($start, $interval, $end);

        $periods=[];
        foreach ($period as $dt) {
             $periods[]=array($dt->format('j-n-Y'));
        }
        $reversed = array_reverse($periods);
        return $reversed;
    }
    
    
    
    //***************************************************************************
    
    /*
     * This is MAIN function renders monthly new visitor profiles
     */    
    public function actionProfilesAvmsVisitors() {
        // Post Date
        $dateFromFilter = Yii::app()->request->getParam("date_from_filter");
        $dateToFilter = Yii::app()->request->getParam("date_to_filter");
       
        $date1YearBack = $this->getTodayAnd1YearBack();
        $this->avmsNewVisitors($dateFromFilter,$dateToFilter,$date1YearBack[0],$date1YearBack[1]);
        
    }
    
        /*
     * @param $dateFromFilter: user input from date
     * @param $dateFromFilter: user input to date
     * @param $from: default from date(came from getTodayAnd1YearBack()) if user not selected any filter input
     * @param $to: user input to date(came from getTodayAnd1YearBack()) if user not selected any filter input
     * this function renders monthly new visitor profiles
     * based on default 1 year monthly new visitor profiles
     * OR in a specified date range based on from and to filters
     */
    public function avmsNewVisitors($dateFromFilter,$dateToFilter,$from,$to){
        
        if( !empty($dateFromFilter) && !empty($dateToFilter) ) {
            $from = new DateTime($dateFromFilter);
            $to = new DateTime($dateToFilter);
            
           $reversed = $this->getGivenPeriodInterval($from,$to);
        }
        else{
            $reversed = $this->get1YearInterval();
        }
        

        
        $countArrayVIC=array();$countArrayASIC=array();
        
        $visitorsVIC = $this->getNewVICVisitorsData ($from,$to);
        $visitorsASIC = $this->getNewASICVisitorsData ($from,$to);
        
        foreach($visitorsVIC as $visitorVIC){
            $date_check_in = $visitorVIC['date_check_in'];
            $time=strtotime($date_check_in);
            $month=date("m",$time);
            $year=date("Y",$time);
            $m = intval($month);
            $y = intval($year);
            $countArrayVIC[$y][$m][]=1;
        }
        
        foreach($visitorsASIC as $visitorASIC){
            $date_check_in = $visitorASIC['date_check_in'];
            $time=strtotime($date_check_in);
            $month=date("m",$time);
            $year=date("Y",$time);
            $m = intval($month);
            $y = intval($year);
            $countArrayASIC[$y][$m][]=1;
        }
        
        
        $this->render("avmsnewvisitorcount", array("resultsVIC"=>$countArrayVIC,"resultsASIC"=>$countArrayASIC,"reversed"=>$reversed));
    }
    
    
    /*
     * this function returns an interval month from given dates (FROM to TO date )
     * e.g. if FROM date given is 11-june-2015 and TO date given is 11-june-2014
     * it will give us in array of array having two index each of data 6-2015(June-2015),5-2015(May-2015)
     * and so on after 1 year from today
    */
    public function getGivenPeriodInterval($from,$to){
        
        $interval = new DateInterval('P1M');
        $period = new DatePeriod($from, $interval, $to);

        $periods=[];
        foreach ($period as $dt) {
             $periods[]=array($dt->format('F Y'),$dt->format('n-Y'));
        }
        $reversed = array_reverse($periods);
        return $reversed;
    }
    
    
        /**
     * Get New Visitors by Dates
     * 
     * @param date $from From date
     * @param date $to to date 
     * @return array Data array
     */
    function getNewVICVisitorsData( $from, $to ) {
        $dateCondition = "( DATE(t.date_created) BETWEEN  '".$from->format("Y-m-d")."' AND  '".$to->format("Y-m-d")."' )"
                         ." AND (t.is_deleted =0 ) AND (t.profile_type='VIC')";
        
        $data = Yii::app()->db->createCommand()
                ->select("DATE(t.date_created) AS date_check_in, t.first_name, t.id") 
                ->from("visitor t")
                ->where($dateCondition)
                ->queryAll();
        return $data;
    }
    
       /**
     * Get New Visitors by Dates
     * 
     * @param date $from From date
     * @param date $to to date 
     * @return array Data array
     */
    function getNewASICVisitorsData( $from, $to ) {
        
        $dateCondition = "( DATE(t.date_created) BETWEEN  '".$from->format("Y-m-d")."' AND  '".$to->format("Y-m-d")."' )"
                         ." AND (t.is_deleted =0 ) AND (t.profile_type='ASIC')";
        
        $data = Yii::app()->db->createCommand()
                ->select("DATE(t.date_created) AS date_check_in, t.first_name, t.id") 
                ->from("visitor t")
                ->where($dateCondition)
                ->queryAll();
        return $data;
    }

    
}
