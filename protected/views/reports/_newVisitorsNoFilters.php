<!-- Listing and Pie Chart Div -->
<h1> Total New Visitor Profiles by Months</h1>
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

                foreach ($reversed as $key=>$dt) {
                    echo '<tr>'
                    . '<td>'
                    .$dt[0]
                    . '<td>';
                    foreach($results as $key=>$val) {
                        $flag=false;
                        foreach($val as $k=>$v) {
                            $myKey=$k."-".$key;
                            if($myKey == $dt[1]){
                                $total +=count($v);
                                $flag=true;
                                $datasets[] = array($dt[0], count($v));
                                echo count($v);
                               break;
                            }
                        }
                        if(!$flag){
                                echo '0';
                        }
                    }
                }
        } else{
            
            foreach ($reversed as $key=>$dt) {
                    echo '<tr>'
                    . '<td>'
                    .$dt[0]
                    . '<td>'
                    .'0';
                    
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
