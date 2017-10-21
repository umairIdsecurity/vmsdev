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
				'actions'=>array('evicDepositsReport', 'evicDepositsRecord', 'notReturnedVic', 'visitorsByProfiles','profilesAvmsVisitors','visitorsVicByType','visitorsVicByCardType','visitorsVicByCardStatus','exportFileVicByCardStatus','conversionVicToAsic','exportFileVicByType','exportFileVicByCardType','exportFileNewVisitors','exportFileVicToAsic','exportFileNotReturned','exportDepositsRecord'),
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
        
        $dateCondition ='';
        
        if(Roles::ROLE_SUPERADMIN != Yii::app()->user->role){
            $dateCondition .= "(t.created_by=".Yii::app()->user->id.") AND ";
        }
        
        $dateCondition .= "( t.date_created BETWEEN  '".$from->format("Y-m-d H:i:s")."' AND  '".$to->format("Y-m-d H:i:s")."' )"
                         ." AND (t.is_deleted =0 ) AND (t.profile_type='CORPORATE')";
        
        $data = Yii::app()->db->createCommand()
                ->select("t.date_created AS date_check_in, t.first_name, t.id") 
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
		
		if (Yii::app()->request->getParam('export')) {
            $this->actionExportNewVisitors();
            Yii::app()->end();
        }
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
        

        
        $countArrayVIC=array();
        $countArrayASIC=array();
        $countArrayVICASIC=array();
        
        $visitorsVIC = $this->getNewVICVisitorsData ($from,$to);
        $visitorsASIC = $this->getNewASICVisitorsData ($from,$to);
        $visitors = $this->getNewVICASICVisitorsData($from,$to);
        
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

        foreach($visitors as $visitor){
            $date_check_in = $visitor['date_check_in'];
            $time=strtotime($date_check_in);
            $month=date("m",$time);
            $year=date("Y",$time);
            $m = intval($month);
            $y = intval($year);
            $countArrayVICASIC[$y][$m][]=1;
        }
        
        
        $this->render("avmsnewvisitorcount", array("resultsVIC"=>$countArrayVIC,"resultsASIC"=>$countArrayASIC, "resultsVICASIC"=>$countArrayVICASIC,"reversed"=>$reversed));
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
    function getNewVICASICVisitorsData( $from, $to ) {
        
        $dateCondition='';
        
        if(Roles::ROLE_SUPERADMIN != Yii::app()->user->role){
            $dateCondition .= "(t.tenant=".Yii::app()->user->tenant.") AND ";
        }
        
        $dateCondition .= "(t.date_created BETWEEN  '".$from->format("Y-m-d H:i:s")."' AND  '".$to->format("Y-m-d H:i:s")."' )"
                         ." AND (t.is_deleted =0 ) AND (t.profile_type='VIC' OR t.profile_type='ASIC')";
        
        $data = Yii::app()->db->createCommand()
                //->select("convert(varchar(10), t.date_created, 120) AS date_check_in, t.first_name, t.id")
                ->select("t.date_created AS date_check_in, t.first_name, t.id")
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
    function getNewVICVisitorsData( $from, $to ) {
        
        $dateCondition='';
        
        if(Roles::ROLE_SUPERADMIN != Yii::app()->user->role){
            $dateCondition .= "(t.tenant=".Yii::app()->user->tenant.") AND ";
        }
        
        $dateCondition .= "(t.date_created BETWEEN  '".$from->format("Y-m-d H:i:s")."' AND  '".$to->format("Y-m-d H:i:s")."' )"
                         ." AND (t.is_deleted =0 ) AND (t.profile_type='VIC')";
        
        $data = Yii::app()->db->createCommand()
                //->select("convert(varchar(10), t.date_created, 120) AS date_check_in, t.first_name, t.id")
                ->select("t.date_created AS date_check_in, t.first_name, t.id")
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
        
        $dateCondition='';
        
        if(Roles::ROLE_SUPERADMIN != Yii::app()->user->role){
            $dateCondition .= "(t.created_by=".Yii::app()->user->id.") AND ";
        }
        
        $dateCondition .= "(t.date_created BETWEEN  '".$from->format("Y-m-d H:i:s")."' AND  '".$to->format("Y-m-d H:i:s")."' )"
                         ." AND (t.is_deleted =0 ) AND (t.profile_type='ASIC')";
        
        
        $data = Yii::app()->db->createCommand()
                //->select("convert(varchar(10), t.date_created, 120) AS date_check_in, t.first_name, t.id")
                ->select("t.date_created AS date_check_in, t.first_name, t.id")
                ->from("visitor t")
                ->where($dateCondition)
                ->queryAll();
        return $data;
    }
    
    
    //**************************************************************************
    /* 
    * Report: VIC Reporting: Total VIC Visitors by Visitor Type
    * Total Visitors by Visitor Type
    * 
    * @return view
    */
    public function actionVisitorsVicByType() {
        // Post Date
        $dateFromFilter = Yii::app()->request->getParam("date_from_filter");
        $dateToFilter = Yii::app()->request->getParam("date_to_filter");
        
        $dateCondition='';
        
        if( !empty($dateFromFilter) && !empty($dateToFilter) ) {
            $from = new DateTime($dateFromFilter);
            $to = new DateTime($dateToFilter);
            $dateCondition = "( v.date_created BETWEEN  '".$from->format("Y-m-d H:i:s")."' AND  '".$to->format("Y-m-d H:i:s")."' ) AND ";
        }
        
        if(Roles::ROLE_SUPERADMIN != Yii::app()->user->role){
            $dateCondition .= "(visitors.tenant=".Yii::app()->user->tenant.") AND ";
        }
        
        $dateCondition .= " (v.is_deleted = 0) AND (v.profile_type='VIC') AND t.module='AVMS'";
        
        $config = Yii::app()->getComponents(false);
        $visitsCount = Yii::app()->db->createCommand()
                ->select("t.id,t.name,count(visitors.id) as visitors") 
                ->from('visitor_type t')
                 ->join('visit visitors' , 't.id = visitors.visitor_type AND (visitors.is_deleted = 0 AND visitors.tenant ='.Yii::app()->user->tenant .')')
				->join('visitor v' , 'v.id = visitors.visitor AND (visitors.is_deleted = 0 AND visitors.tenant ='.Yii::app()->user->tenant .')')
                ->where($dateCondition)
                ->group('t.id, t.name')
                ->queryAll();
			if (Yii::app()->request->getParam('export')) {
            $this->actionExportVicByType();
            Yii::app()->end();
        }
        
        $this->render("visitorvictypecount", array("visit_count"=>$visitsCount));
    }
     public function actionExportFileVicByType()
    {
        Yii::app()->request->sendFile('VisitorByTypeVIC_' . date('dmYHis') . '.csv', Yii::app()->user->getState('export'));
        Yii::app()->user->clearState('export');
    }
	public function actionExportVicByType() {
        $fp = fopen('php://temp', 'w');

        /*
         * Write a header of csv file
         */
        $headers = array(
           'Visitor Type'=>'Visitor Type',
			'Total Vics'=>'Vics Total Count',
            
        );
        $row = array();
        foreach ($headers as $header) {
            $row[] = $header;
        }
        fputcsv($fp, $row);
		
		 $dateCondition='';
		 if(Roles::ROLE_SUPERADMIN != Yii::app()->user->role){
            $dateCondition .= "(visitors.tenant=".Yii::app()->user->tenant.") AND ";
        }
        
        $dateCondition .= " (v.is_deleted = 0) AND (v.profile_type='VIC') AND t.module='AVMS'";
        
        $config = Yii::app()->getComponents(false);
        $visitsCount = Yii::app()->db->createCommand()
                ->select("t.id,t.name,count(visitors.id) as visitors") 
                ->from('visitor_type t')
                 ->join('visit visitors' , 't.id = visitors.visitor_type AND (visitors.is_deleted = 0 AND visitors.tenant ='.Yii::app()->user->tenant .')')
				->join('visitor v' , 'v.id = visitors.visitor AND (visitors.is_deleted = 0 AND visitors.tenant ='.Yii::app()->user->tenant .')')
                ->where($dateCondition)
                ->group('t.id, t.name')
                ->queryAll();
		
        
			
			//$i=0;
            foreach($visitsCount as $visit) {
			$row=array();
			$row[]=$visit['name'];
			$row[]=$visit['visitors'];
			
			 fputcsv($fp, $row);
            }
		
			
        
		
        rewind($fp);
        Yii::app()->user->setState('export', stream_get_contents($fp));
        fclose($fp);
    }
    //**************************************************************************
    /* 
    * Report: VIC Reporting: Total VIC Visitors' VISITS by VISIT CARD TYPE 
    * and also if between DIFFERENT DATE RANGES
    * 
    * @return view
    */
    public function actionVisitorsVicByCardStatus() {
        // Post Date
        $dateFromFilter = Yii::app()->request->getParam("date_from_filter");
        $dateToFilter = Yii::app()->request->getParam("date_to_filter");
        
        $dateCondition='';
        
        if( !empty($dateFromFilter) && !empty($dateToFilter) ) {
            $from = new DateTime($dateFromFilter);
            $to = new DateTime($dateToFilter);
            $dateCondition = "( visitors.date_created BETWEEN  '".$from->format("Y-m-d H:i:s")."' AND  '".$to->format("Y-m-d H:i:s")."' ) AND ";
        }
        
        
        if(Roles::ROLE_SUPERADMIN != Yii::app()->user->role){
            $dateCondition .= "(visitors.tenant=".Yii::app()->user->tenant.") AND ";
        }
        
        $dateCondition .= "(visitors.is_deleted = 0)";

        $visitorCount = Yii::app()->db->createCommand()
                ->select("cards.id as cardId,cards.name,count(visitors.id) as visitors")
                ->from('visitor visitors')
                ->join("visitor_card_status cards",'cards.id = visitors.visitor_card_status')
                ->where($dateCondition)
                ->group('cards.id,cards.name')
                ->queryAll();

        $allCards = Yii::app()->db->createCommand()
                ->select("cards.id,cards.name")
                ->from('visitor_card_status cards')
                ->queryAll();
        $otherCards = array();
        
        foreach ($allCards as $card) {
            $hasVisitor = false;
            foreach($visitorCount as $visitor) {
                if($visitor['cardId'] ==  $card['id']) {
                    $hasVisitor =  true;
                }
            }
            if ($hasVisitor == false) {
                array_push($otherCards, $card);
            }
        }
		if (Yii::app()->request->getParam('export')) {
            $this->actionExportVicByCardStatus();
            Yii::app()->end();
        }
        
        $this->render("visitorviccardstatuscount", array("visitor_count"=>$visitorCount,"otherCards" => $otherCards));
    }
 public function actionExportFileVicByCardStatus()
    {
        Yii::app()->request->sendFile('VisitorByCardStatus_' . date('dmYHis') . '.csv', Yii::app()->user->getState('export'));
        Yii::app()->user->clearState('export');
    }
	public function actionExportVicByCardStatus() {
        $fp = fopen('php://temp', 'w');

        /*
         * Write a header of csv file
         */
        $headers = array(
           'Card Name'=>'Card Status',
			'Total Vics'=>'Visitor Count',
            
        );
        $row = array();
        foreach ($headers as $header) {
            $row[] = $header;
        }
        fputcsv($fp, $row);
		
		 $dateCondition='';
		if(Roles::ROLE_SUPERADMIN != Yii::app()->user->role){
            $dateCondition .= "(visitors.tenant=".Yii::app()->user->tenant.") AND ";
        }
        
         $dateCondition .= "(visitors.is_deleted = 0)";

        $visitorCount = Yii::app()->db->createCommand()
                ->select("cards.id as cardId,cards.name,count(visitors.id) as visitors")
                ->from('visitor visitors')
                ->join("visitor_card_status cards",'cards.id = visitors.visitor_card_status')
                ->where($dateCondition)
                ->group('cards.id,cards.name')
                ->queryAll();

        $allCards = Yii::app()->db->createCommand()
                ->select("cards.id,cards.name")
                ->from('visitor_card_status cards')
                ->queryAll();
        $otherCards = array();
        
        foreach ($allCards as $card) {
            $row=array();
			$row[0]=$card['name'];
			$i=0;
            foreach($visitorCount as $visitor) {
                if($visitor['cardId'] ==  $card['id']) {
                    $row[1]=$visitor['visitors'];
					$i=1;
				}
				if($i!=1)
				{
				  $row[1]='0';
				}
              }
			  fputcsv($fp, $row);
            }

        rewind($fp);
        Yii::app()->user->setState('export', stream_get_contents($fp));
        fclose($fp);
    }
	    public function actionVisitorsVicByCardType() {
        // Post Date
        $dateFromFilter = Yii::app()->request->getParam("date_from_filter");
        $dateToFilter = Yii::app()->request->getParam("date_to_filter");
        
        $dateCondition='';
        
        if( !empty($dateFromFilter) && !empty($dateToFilter) ) {
            $from = new DateTime($dateFromFilter);
            $to = new DateTime($dateToFilter);
            $dateCondition = "( visitors.date_created BETWEEN  '".$from->format("Y-m-d H:i:s")."' AND  '".$to->format("Y-m-d H:i:s")."' ) AND ";
        }
        
        
        if(Roles::ROLE_SUPERADMIN != Yii::app()->user->role){
            $dateCondition .= "(visitors.tenant=".Yii::app()->user->tenant.") AND ";
        }
        
        $dateCondition .= "(visits.is_deleted = 0) AND (visitors.is_deleted = 0) AND (visitors.profile_type='VIC') AND (cards.module=2)";

        $visitorCount = Yii::app()->db->createCommand()
                ->select("cards.id as cardId,cards.name,count(distinct(visits.id)) as visitors")
                ->from('visitor visitors')
                ->join("visit visits",'visitors.id = visits.visitor')
                ->join("card_type cards",'cards.id = visits.card_type')
                ->where($dateCondition)
                ->group('cards.id,cards.name')
                ->queryAll();

        $allCards = CardType::model()->findAll("module=2");
        $otherCards = array();
        
        foreach ($allCards as $card) {
            $hasVisitor = false;
            foreach($visitorCount as $visitor) {
                if($visitor['cardId'] ==  $card['id']) {
                    $hasVisitor =  true;
                }
            }
            if ($hasVisitor == false) {
                array_push($otherCards, $card);
            }
        }
		if (Yii::app()->request->getParam('export')) {
            $this->actionExportVicByCardType();
            Yii::app()->end();
        }
        
        $this->render("visitorviccardtypecount", array("visitor_count"=>$visitorCount,"otherCards" => $otherCards));
    }
 public function actionExportFileVicByCardType()
    {
        Yii::app()->request->sendFile('VisitorByCardTypeVIC_' . date('dmYHis') . '.csv', Yii::app()->user->getState('export'));
        Yii::app()->user->clearState('export');
    }
	public function actionExportVicByCardType() {
        $fp = fopen('php://temp', 'w');

        /*
         * Write a header of csv file
         */
        $headers = array(
           'Card Name'=>'Card Type',
			'Total Vics'=>'Vics Total Count',
            
        );
        $row = array();
        foreach ($headers as $header) {
            $row[] = $header;
        }
        fputcsv($fp, $row);
		
		 $dateCondition='';
		if(Roles::ROLE_SUPERADMIN != Yii::app()->user->role){
            $dateCondition .= "(visitors.tenant=".Yii::app()->user->tenant.") AND ";
        }
        
        $dateCondition .= "(visits.is_deleted = 0) AND (visitors.is_deleted = 0) AND (visitors.profile_type='VIC') AND (cards.module=2)";

        $visitorCount = Yii::app()->db->createCommand()
                ->select("cards.id as cardId,cards.name,count(distinct(visits.id)) as visitors")
                ->from('visitor visitors')
                ->join("visit visits",'visitors.id = visits.visitor')
                ->join("card_type cards",'cards.id = visits.card_type')
                ->where($dateCondition)
                ->group('cards.id,cards.name')
                ->queryAll();

        $allCards = CardType::model()->findAll("module=2");
        $otherCards = array();
        
        foreach ($allCards as $card) {
            $row=array();
			$row[0]=$card['name'];
			$i=0;
            foreach($visitorCount as $visitor) {
                if($visitor['cardId'] ==  $card['id']) {
                    $row[1]=$visitor['visitors'];
					$i=1;
				}
				if($i!=1)
				{
				  $row[1]='0';
				}
              }
			  fputcsv($fp, $row);
            }

        rewind($fp);
        Yii::app()->user->setState('export', stream_get_contents($fp));
        fclose($fp);
    }
	 public function actionExportFileNewVisitors()
    {
        Yii::app()->request->sendFile('NewVisitors_' . date('dmYHis') . '.csv', Yii::app()->user->getState('export'));
        Yii::app()->user->clearState('export');
    }
	public function actionExportNewVisitors() {
        $fp = fopen('php://temp', 'w');

        /*
         * Write a header of csv file
         */
        $headers = array(
           'Month-Year'=>'Month-Year',
			'Vics'=>'Total Vics',
			'Asics'=>'Total Asics',
            
        );
        $row = array();
        foreach ($headers as $header) {
            $row[] = $header;
        }
        fputcsv($fp, $row);
		
		$reversed = $this->get1YearInterval(); 
		$date1YearBack = $this->getTodayAnd1YearBack();
		$from=$date1YearBack[0];
		$to=$date1YearBack[1];
        $countArrayVIC=array();
        $countArrayASIC=array();

        
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
		
		 foreach ($reversed as $key=>$dt) {
            $row=array();
            $row[0]=$dt[0];
			
            if(!empty($countArrayVIC)){
				$i=0;
                foreach($countArrayVIC as $key=>$val) {
                    foreach($val as $k=>$v) {
                        $myKey=$k."-".$key;
                        if($myKey == $dt[1]){
						   $i=count($v);
                            break;
                        }
                    }
                }
				 $row[1]=$i;
            }

            if(!empty($countArrayASIC)){
				$j=0;
                foreach($countArrayASIC as $key=>$val) {
                    foreach($val as $k=>$v) {
                        $myKey=$k."-".$key;
                        if($myKey == $dt[1]){
							$j=count($v);
                           break;
                        }
                    }
				}
			$row[2]=$j;	
            }
			fputcsv($fp, $row);
        }

        rewind($fp);
        Yii::app()->user->setState('export', stream_get_contents($fp));
        fclose($fp);
    }
    //**************************************************************************
    /*
    * Report: Visitor Reporting: Conversion of Total VICs to ASIC
    *
    * @return view
    */
    public function actionConversionVicToAsic() {

        $dateFromFilter = Yii::app()->request->getParam("date_from_filter");
        $dateToFilter = Yii::app()->request->getParam("date_to_filter");

        $date1YearBack = $this->getTodayAnd1YearBack();
			if (Yii::app()->request->getParam('export')) {
            $this->actionExportVicToAsic();
            Yii::app()->end();
        }
        $this->avmsConversionCardType($dateFromFilter,$dateToFilter,$date1YearBack[0],$date1YearBack[1]);
    }

    public function avmsConversionCardType($dateFromFilter,$dateToFilter,$from,$to){
        if( !empty($dateFromFilter) && !empty($dateToFilter) ) {
            $from = new DateTime($dateFromFilter);
            $to = new DateTime($dateToFilter);

            $reversed = $this->getGivenPeriodInterval($from,$to);
        }
        else{
            $reversed = $this->get1YearInterval();
        }
        $countArrayConversion=array();

        $Conversions = $this->getConversionData($from,$to);

        foreach($Conversions as $Conversion){
            $Conversion = $Conversion['convert_time'];
            $time=strtotime($Conversion);
            $month=date("m",$time);
            $year=date("Y",$time);
            $m = intval($month);
            $y = intval($year);
            $countArrayConversion[$y][$m][]=1;
        }

        $this->render("conversionvictoasic", array("resultsConversion" => $countArrayConversion, "reversed"=>$reversed));
    }

    function getConversionData($from, $to) {
        $dateCondition="(v.tenant=".Yii::app()->user->tenant.") AND ";

        $dateCondition .= "(t.convert_time BETWEEN '".$from->format("Y-m-d")."' AND '".$to->format("Y-m-d")."' )";

        $data = Yii::app()->db->createCommand()
            ->select("t.convert_time AS convert_time, t.visitor_id, t.id")
            ->from("cardstatus_convert t")
			->join("visitor v" ,"v.id=t.visitor_id")
            ->where($dateCondition)
            ->queryAll();
        return $data;
    }
    public function actionExportFileVicToAsic()
    {
        Yii::app()->request->sendFile('VicToAsic_Conversion_' . date('dmYHis') . '.csv', Yii::app()->user->getState('export'));
        Yii::app()->user->clearState('export');
    }
	public function actionExportVicToAsic() {
        $fp = fopen('php://temp', 'w');


        $headers = array(
           'Month-Year'=>'Month-Year',
			'Conversions'=>'Total Conversions',        
        );
        $row = array();
        foreach ($headers as $header) {
            $row[] = $header;
        }
        fputcsv($fp, $row);
		
		$reversed = $this->get1YearInterval(); 
		$date1YearBack = $this->getTodayAnd1YearBack();
		$from=$date1YearBack[0];
		$to=$date1YearBack[1];
        $countArrayConversion=array();

        $Conversions = $this->getConversionData($from,$to);

        foreach($Conversions as $Conversion){
            $Conversion = $Conversion['convert_time'];
            $time=strtotime($Conversion);
            $month=date("m",$time);
            $year=date("Y",$time);
            $m = intval($month);
            $y = intval($year);
            $countArrayConversion[$y][$m][]=1;
        }
		
		  foreach ($reversed as $key=>$dt) 
		  {
			$row=array();
            $row[0]=$dt[0];
            if (!empty($countArrayConversion)) {
				$i=0;
                foreach ($countArrayConversion as $key => $val) {
                    foreach ($val as $k => $v) {
                        $myKey = $k . "-" . $key;
                        if ($myKey == $dt[1]) {
                             $i=count($v);
                            break;
                        }
                    }

                }
			$row[1]=$i;
            } 
			 fputcsv($fp, $row);
        }

        rewind($fp);
        Yii::app()->user->setState('export', stream_get_contents($fp));
        fclose($fp);
    }
    /**
     * Not Returned and Lost/stolen VICs Reports
     * Depends upons the Expired Visits having Card Option Not Returned or Lost/Stolen Report
     * 
     */
    public function actionNotReturnedVic() {
        $criteria = new CDbCriteria;
        $criteria->addCondition("(visit_status = ".VisitStatus::EXPIRED ." OR visit_status = ".VisitStatus::CLOSED." ) AND card_type > 4 AND card_type != ".CardType::VIC_CARD_24HOURS 
                ." AND card_option != 'Returned'");
        
        $model = new Visit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visit'])) {
                $model->attributes = $_GET['Visit'];
            }
	if (Yii::app()->request->getParam('export')) {
            $this->actionExportNotReturned();
            Yii::app()->end();
        }
        
        $this->render("notReturnedVic", array("model"=>$model, "criteria"=>$criteria));
    }
     public function actionExportFileNotReturned()
    {
        Yii::app()->request->sendFile('LostVICs_' . date('dmYHis') . '.csv', Yii::app()->user->getState('export'));
        Yii::app()->user->clearState('export');
    }
	 public function actionExportNotReturned() {
        $fp = fopen('php://temp', 'w');

        $headers = array(
			'card0.card_number' => 'Card Number',
            'visitor0.first_name' => 'First Name',
            'visitor0.last_name' => 'Last Name',
            'date_check_in'=>'Check IN',
			'date_check_out'=>'Check OUT',
			'police_report_number'=>'Report Number',
            
        );
        $row = array();
        foreach ($headers as $header) {
            $row[] = Visit::model()->getAttributeLabel($header);
        }
        fputcsv($fp, $row);

        $criteria = new CDbCriteria;
        $criteria->addCondition("(visit_status = ".VisitStatus::EXPIRED ." OR visit_status = ".VisitStatus::CLOSED." ) AND card_type > 4 AND card_type != ".CardType::VIC_CARD_24HOURS 
                ." AND card_option != 'Returned'");
        

        $model = new Visit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visit'])) {
            $model->attributes = $_GET['Visit'];
        }

        $dp = $model->search($criteria);


        $dp->setPagination(false);

       

        $models = $dp->getData();
        foreach ($models as $model) {
            $row = array();
            foreach ($headers as $head => $title) {
				
				$row[] = CHtml::value($model, $head);
			}
            fputcsv($fp, $row);
        }

        rewind($fp);
        Yii::app()->user->setState('export', stream_get_contents($fp));
        fclose($fp);
    }
    /**
     *  CAVMS- 803: 'EVIC Deposits Record'
     */
    public function actionEvicDepositsRecord() {
        $criteria = new CDbCriteria;
        $criteria->addCondition("visit_status IN (".VisitStatus::ACTIVE.", ".VisitStatus::CLOSED.", ".VisitStatus::EXPIRED.")");
        $criteria->addCondition("card_type = ".CardType::VIC_CARD_EXTENDED);
        $model = new Visit("search");
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visit'])) {
                $model->attributes = $_GET['Visit'];
            }
		if (Yii::app()->request->getParam('export')) {
            $this->actionExportDepositsRec();
            Yii::app()->end();
        }
        $this->render("depositsRecord", array("criteria"=>$criteria, "model"=>$model) );    
        
    }
	 public function actionExportDepositsRecord()
    {
        Yii::app()->request->sendFile('EVICDeposits_' . date('dmYHis') . '.csv', Yii::app()->user->getState('export'));
        Yii::app()->user->clearState('export');
    }
	 public function actionExportDepositsRec() {
        $fp = fopen('php://temp', 'w');

        $headers = array(
			'card0.card_number' => 'Card Number',
            'visitor0.first_name' => 'First Name',
            'visitor0.last_name' => 'Last Name',
			'visitor0.email' => 'Email',
			'company0.name' => 'Company',
            'date_check_in'=>'Check IN',
			'date_check_out'=>'Check OUT',
			'deposit_paid'=>'Deposit',
            
        );
        $row = array();
        foreach ($headers as $header) {
            $row[] = Visit::model()->getAttributeLabel($header);
        }
        fputcsv($fp, $row);

      $criteria = new CDbCriteria;
        $criteria->addCondition("visit_status IN (".VisitStatus::ACTIVE.", ".VisitStatus::CLOSED.", ".VisitStatus::EXPIRED.")");
        $criteria->addCondition("card_type = ".CardType::VIC_CARD_EXTENDED);

        $model = new Visit('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visit'])) {
            $model->attributes = $_GET['Visit'];
        }

        $dp = $model->search($criteria);


        $dp->setPagination(false);

       

        $models = $dp->getData();
        foreach ($models as $model) {
            $row = array();
            foreach ($headers as $head => $title) {
				
				
				if($title=='Deposit')
				{
				if((CHtml::value($model, $head))==null)
				{
					$row[] = 'PAID';
				}
				else
				{
					$row[] = CHtml::value($model, $head);
				}
				}
				else
					$row[] = CHtml::value($model, $head);
			}
            fputcsv($fp, $row);
        }

        rewind($fp);
        Yii::app()->user->setState('export', stream_get_contents($fp));
        fclose($fp);
    }
    /**
     *  CAVMS- 802: 'EVIC Deposits Report'
     *  1. Deposit Paid [EVIC’s activated with Deposit Paid]
     *  2. Expired [EVIC’s Expired (Inactive)]
     *  3. Not Returned [EVIC’s Not Returned (Not refunded)]
     *  4. Closed and Refunded [EVIC’s Closed and Deposit Refunded]
     */
    public function actionEvicDepositsReport() {

        $criteria = new CDbCriteria;
        $criteria->addCondition("visit_status IN (".VisitStatus::ACTIVE.", ".VisitStatus::CLOSED.", ".VisitStatus::EXPIRED.")");
        $criteria->addCondition("card_type = ".CardType::VIC_CARD_EXTENDED." AND tenant = ".Yii::app()->user->tenant );
        $dateFrom = Yii::app()->request->getParam("date_from_filter", date("d-m-Y", strtotime("-1 month")));
        $dateTo = Yii::app()->request->getParam("date_to_filter", date("d-m-Y"));
        $criteria->addCondition("date_check_in >= '".date("Y-m-d", strtotime($dateFrom))."' AND date_check_in <= '".date("Y-m-d", strtotime($dateTo))."'");
        
        $visits = Visit::model()->findAll($criteria);
        $deposit_paid = 0; $expired = 0; $not_returned = 0; $closed_returned = 0;
        if( $visits )
         foreach($visits as $v ) {
            // all EVIC are must Deposit Paid therefore 
            $deposit_paid++;
            
            switch($v["visit_status"]) {
                case VisitStatus::EXPIRED:
                    $expired++;
                    break;
                case VisitStatus::CLOSED:
                    if($v->card_option != "Returned")
                        $not_returned++;
                    else
                        $closed_returned++;
                    break;
                default :
                    break;
            }
            
        }
        $this->render("evicDepositsReport", array(
            "deposit_paid" => $deposit_paid,
            "expired" => $expired,
            "not_returned" => $not_returned,
            "closed_returned" => $closed_returned,
            "dateFrom" => $dateFrom, "dateTo" => $dateTo
                )
        );
    }

}
