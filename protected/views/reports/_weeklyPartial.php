<!-- Listing and Pie Chart Div -->
<div class="content" style="width:40%; float: left; margin:20px 10px 0px 5px;">
<table class="table" cellpadding="4" width="100%">
    <thead>
        <tr>
            <th> Weeks </th>
            <th> New Visitor Count </th>
        </tr>
    </thead>
    <tbody>
        <?php 
            
        $datasets = array(
            array('Visitors', 'Visitors')
        );
        $total = 0;
        
        if($results) { 
            
//            echo '<pre>';
//            print_r($results);
        
        //die;
            
            $start=0;
            while($start < sizeof($reversed)) {
                $arr=array();
                $first=$start;
                $last=$first+7;
                
                if (array_key_exists($first, $reversed) && array_key_exists($last, $reversed)) {
                    $firstWeekDay=$reversed[$first];
                    $lastWeekDay=$reversed[$last];
                    
                    $interval = $lastWeekDay[0]."  To  ".$firstWeekDay[0];
                    
                    //print week interval in table
                    echo '<tr>'
                    . '<td>'
                    .$interval
                    . '<td>';
                    
                    $dayInWeekCount=0;
                    
                    //looping through the each day of a week interval to check specific day count
                    for($i=$first;$i<=$last;$i++) {
                       
            
                        $days=$reversed[$i];
                        
                        foreach($results as $key=>$val) {
                            
                            foreach($val as $k=>$v) {
                                foreach($v as $daykey=>$dayV) {
                                    $myKey=$daykey."-".$k."-".$key;
                                    if($myKey == $days[0]){
                                        
                                        $total +=count($dayV);
                                        $dayInWeekCount = count($dayV);
                                        $arr[] = $dayInWeekCount;
                                    }
                                    
                                }
                                
                            }
                            
                        }
                        
                        
                    }
                    //$finalCount += $dayInWeekCount;
                    //$datasets[] = array($interval, count($dayV));
                    //echo $finalCount;
                    $datasets[] = array($interval, array_sum($arr));
                    echo array_sum($arr);
                }
                $start += 7;
            }
        } 
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Total Visitors</th>
            <th><?php echo $total; ?></th>
        </tr>
    </tfoot>
</table>
</div>

<div class="span6" style="width:55%; float: left; margin:10px 0px 0px 0px;">  
        <?php
        //very useful google chart
        $this->widget('ext.Hzl.google.HzlVisualizationChart', array('visualization' => 'PieChart',
            'data' => $datasets,
            'options' => array('title' => 'Total New Visitors')));
        ?>
    </div>

