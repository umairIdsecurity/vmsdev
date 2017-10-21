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
                foreach($results as $key=>$val) {
                    foreach($val as $k=>$v) {
                        $total +=count($v);
                        $myDate = date('F', mktime(0, 0, 0, intval($k), 10)) . " ".$key;
                        $datasets[] = array($myDate, count($v));
?>
        <tr>
            <td><?php echo $myDate; ?></td>
            <td><?php echo count($v);?></td>
        </tr>
                <?php
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
