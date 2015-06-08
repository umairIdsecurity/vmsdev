<!-- Listing and Pie Chart Div -->
<h1> Total New Visitor Profiles by Weeks</h1>
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
        
        $total = 0;
        $datasets = array(
            array('Visitors', 'Visitors')
        );
        //if($data) { 
                for($i = 1; $i <= $weeks; $i++) {
                    $toWeek     = date("d-M-Y", strtotime("- ".($i-1)." week"));
                    $fromWeek   =  date("d-M-Y", strtotime("- ".($i)." week"));
                    
                    echo '<tr><td>' . $toWeek . ' <b>-</b> ' . $fromWeek . ''
                    . '</td>';

                    echo '<td>';
                        if (isset($data[$i])) {
                            echo count($data[$i]);
                            $total += count($data[$i]);
                            $datasets[] = array($toWeek . ' - ' . $fromWeek, count($data[$i]));
                        } else {
                            echo '0';
                            
                        }
                    echo '</td></tr>';
                }
        //} 
        
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
