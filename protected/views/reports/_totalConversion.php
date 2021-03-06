<!-- Listing and Pie Chart Div -->
<h1> Total Visitor from VIC to ASIC by Months</h1>
<div class="content" style="width:40%; float: left; margin:20px 10px 0px 5px;">
    <table class="table" cellpadding="4" width="100%">
        <thead>
        <tr>
            <th> Months </th>
            <th> Total Conversion </th>
        </tr>
        </thead>
        <tbody>
        <?php

        $datasetsConversion = array(
            array('Conversions', 'Conversions')
        );


        $totalConversion = 0;


        //**********************************************************************
        foreach ($reversed as $key=>$dt) {
            echo '<tr>'
                . '<td>'
                . $dt[0]
                . '</td>';

            if (!empty($resultsConversion)) {
				$i=0;
                foreach ($resultsConversion as $key => $val) {
                    foreach ($val as $k => $v) {
                        $myKey = $k . "-" . $key;
                        if ($myKey == $dt[1]) {
                            $totalConversion += count($v);
                            $datasetsConversion[] = array($dt[0], count($v));
                             $i=count($v);
                            break;
                        }
                    }

                }
				 echo '<td>'.$i.'</td>';
            } else {
                echo '<td>' . '0' . '</td>';
            }
        }
        //**********************************************************************

        ?>
        </tbody>
        <tfoot>
        <tr>
            <th>Total Conversion</th>
            <th><?php echo $totalConversion; ?></th>
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
        'data' => $datasetsConversion,
        'options' => array('title' => 'Total Conversions')));
    ?>

</div>
