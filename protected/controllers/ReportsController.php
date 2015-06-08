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
        
        $rangeRadio = Yii::app()->request->getParam("rangeRadio");
         // Post Date
        $dateFromFilter = Yii::app()->request->getParam("date_from_filter");
        $dateToFilter = Yii::app()->request->getParam("date_to_filter");
        
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
    
    
    public function getTodayAnd30DaysBack(){
        $returnArray = array();
        $time = new DateTime('now');
        $from = $time->modify('-30 days');
        $to = new DateTime('now');
        
        $returnArray[0]=$from;
        $returnArray[1]=$to;
        return $returnArray;
    }
    
    
    function newVisitorsDaily($dateFromFilter,$dateToFilter,$from,$to){
        
        $dateCondition='';
  
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
            $day=date("d",$time);
            $m = intval($month);
            $y = intval($year);
            $d = intval($day);
            $countArray[$y][$m][$d][]=1;
        }
        
        $reversed = $this->get30DaysInterval();
        $this->render("newvisitorcount", array("results"=>$countArray,"reversed"=>$reversed));
    }
    
    
    public function newVisitors($dateFromFilter,$dateToFilter,$from,$to){
        $dateCondition='';
  
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
    
    

    
    function visitorsByProfilesWeekly($weeks){
        
        if( $weeks == 1 ){
            $lastWeeks = "-1 week";
        }
        else{
            $lastWeeks = "-".$weeks." weeks";
        }
        
        $to = date("Y-m-d");
        $from = date("Y-m-d", strtotime($lastWeeks));
        // Get New visitors between From and To date
        $data = $this->getNewVisitorsData($from, $to );
        
        $return = array();  
        
        if( count($data) ){
            for( $i = 1; $i <= $weeks; $i++ ) {
              
                $wk = $i == 1 ? "week":"weeks";
                $to_stamp = strtotime("-".($i-1)." ".$wk);              
                $from_stamp =  strtotime("-".$i." ".$wk);
                
                foreach( $data as $key=>$val ) { 
                    $checkin_date = $val['date_check_in_1'] != '' ? $val['date_check_in_1']: $val['date_check_in_2'];                              
                    if(strtotime($checkin_date) >= $from_stamp && strtotime($checkin_date) <= $to_stamp ) {
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
        
        $data = Yii::app()->db->createCommand()
                ->select("min(vst.id), t.id, t.first_name, date_format(str_to_date(vst.date_check_in, '%d-%m-%Y'), '%Y-%m-%d') AS date_check_in_1, date_format(str_to_date(vst.date_check_in, '%Y-%m-%d') , '%Y-%m-%d') AS date_check_in_2") 
                ->from("visitor t")
                ->leftJoin("visit vst", "vst.visitor = t.id")
                ->where("vst.date_check_in BETWEEN '".$from."' AND '".$to."' AND t.is_deleted = 0 AND vst.visit_status != 2")
                ->group("t.id")
                ->queryAll();
        return $data;
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
}
