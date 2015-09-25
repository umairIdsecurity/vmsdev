<!-- Listing and Pie Chart Div -->
<h1> Total New Visitor Profiles by Months</h1>
<div class="content" style="width:40%; float: left; margin:20px 10px 0px 5px;">
<table class="table" cellpadding="4" width="100%">
    <thead>
        <tr>
            <th> Months </th>
            <th> VIC Visitors </th>
            <th> ASIC Visitors </th>
        </tr>
    </thead>
    <tbody>
        <?php 
            
        $datasetsVIC = array(
            array('Visitors', 'Visitors')
        );
        
        $datasetsASIC = array(
            array('Visitors', 'Visitors')
        );

        $datasetsVICASIC = array(
            array('Visitors', 'Visitors')
        );
        
        $totalVIC = 0;
        $totalASIC = 0;
        //$grandTotal=0;
        
        //**********************************************************************
        foreach ($reversed as $key=>$dt) {
            echo '<tr>'
            . '<td>'
            .$dt[0]
            . '</td>';

            if(!empty($resultsVICASIC)){
                foreach($resultsVICASIC as $key=>$val) {
                    foreach($val as $k=>$v) {
                        $myKey=$k."-".$key;
                        if($myKey == $dt[1]){
                            $datasetsVICASIC[] = array($dt[0], count($v));
                            break;
                        }
                    }
                }
            }

            if(!empty($resultsVIC)){
                foreach($resultsVIC as $key=>$val) {
                    $flag=false;
                    foreach($val as $k=>$v) {
                        $myKey=$k."-".$key;
                        if($myKey == $dt[1]){
                            $totalVIC +=count($v);
                            //$grandTotal +=count($v);
                            $flag=true;
                            $datasetsVIC[] = array($dt[0], count($v));
                            echo '<td>'.count($v). '</td>';
                            break;
                        }
                    }
                    if(!$flag){
                            echo '<td>0</td>';
                    }
                }
            }else{
                echo '<td>'.'0'.'</td>';
            }

            if(!empty($resultsASIC)){
                foreach($resultsASIC as $key=>$val) {
                    $flag=false;
                    foreach($val as $k=>$v) {
                        $myKey=$k."-".$key;
                        if($myKey == $dt[1]){
                            $totalASIC +=count($v);
                            //$grandTotal +=count($v);
                            $flag=true;
                            $datasetsASIC[] = array($dt[0], count($v));
                            echo '<td>'.count($v). '</td>';
                           break;
                        }
                    }
                    if(!$flag){
                            echo '<td>0</td>';
                    }
                }
            }else{
                echo '<td>'.'0'.'</td>';
            }
            echo '</tr>';
        }
        //**********************************************************************
       
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Total Visitors</th>
            <th><?php echo $totalVIC; ?></th>
            <th><?php echo $totalASIC; ?></th>
        </tr>
        <!--<tr>
            <th>Grand Total</th>
            <th></th>
            <th><?php //echo $grandTotal; ?></th>
        </tr>-->
    </tfoot>
</table>
</div>

<div class="span6" style="width:55%; float: left; margin:10px 0px 0px 0px;">  
        <?php
        //very useful google chart
        $this->widget('ext.Hzl.google.HzlVisualizationChart', array('visualization' => 'PieChart',
            'data' => $datasetsVICASIC,
            'options' => array('title' => 'Total New Visitors')));
        ?>
    
    <br>
    </div>
