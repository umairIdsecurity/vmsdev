<!-- Listing and Pie Chart Div -->
<div class="content" style="width:40%; float: left; margin:20px 10px 0px 5px;">
<table class="table" cellpadding="4" width="100%">
    <thead>
        <tr>
            <th> Months </th>
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
            
                $time = new DateTime('now');
                
                $from = $time->modify('-1 year');
                $to = new DateTime('now');
                
                $start = new DateTime($from->format('Y-m-d'));
                $interval = new DateInterval('P1M');
                $end = new DateTime($to->format('Y-m-d'));
                $period = new DatePeriod($start, $interval, $end);
                
                $periods=[];
                foreach ($period as $dt) {
                     $periods[]=array($dt->format('F Y'),$dt->format('n-Y'));
                }
                $reversed = array_reverse($periods);

                
                foreach ($reversed as $key=>$dt) {
                   
                    echo '<tr>'
                    . '<td>'
                    .$dt[0]
                    . '<td>';
                    
                    foreach($results as $key=>$val) {
                        foreach($val as $k=>$v) {
                            $myKey=$k."-".$key;
                            if($myKey == $dt[1]){
                                $total +=count($v);
                                
                                $datasets[] = array($dt[0], count($v));
                                
                                echo    
                                        count($v)
                                        . '</tr>';
                                
                            }else{
                                 $datasets[] = array($dt[0],0);
                                echo    
                                        '0'
                                        
                                        . '</tr>';
                                
                            }
                    
                        }
                    
                    }
                    
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
