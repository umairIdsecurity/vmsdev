<h1> Total Visitors by Visitor Type </h1>
<!-- Filter Form -->
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'visitor-type-filter-form',
	'enableAjaxValidation'=>false,
)); ?>
        <label> Date From:  </label>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(    
                        'name'=>'date_from_filter',
                        'value'=>Yii::app()->request->getParam("date_from_filter"),
                        // additional javascript options for the date picker plugin
                        'options'=>array(
                             'changeYear' => true,
                            'dateFormat'=>'dd-mm-yy',
                            'changeMonth'=> true,
                        ),

            )); ?>  
        
             <label> Date To: </label>
              <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(    
                        'name'=>'date_to_filter',
                        'value'=>Yii::app()->request->getParam("date_to_filter"),
                        // additional javascript options for the date picker plugin
                        'options'=>array(
                            'changeYear' => true,
                            'dateFormat'=>'dd-mm-yy',
                            'changeMonth'=> true,
                        ),

            )); ?>
         
	 <?php echo CHtml::submitButton('Filter'); ?>
	 
        <?php $this->endWidget()?>    
    </div>

<!-- Listing and Pie Chart Div -->
<div class="content" style="width:40%; float: left; margin:20px 10px 0px 5px;">
<table class="table" cellpadding="4" width="100%">
    <thead>
        <tr>
            <th> Visitor Type </th>
            <th> Visits Count </th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        $datasets = array(
            array('VisitorType', 'Visits per Visitor')
        );
        
        $total=0;
        
        if($visit_count) { 
                
                $count=1;
                
                foreach($visit_count as $vc ) {
                    $datasets[$count] =  array($vc['name'],intval($vc['visits']));
                    $count++;
                    $total += intval($vc['visits']);
?>
        <tr>
            <td><?php echo $vc['name']; ?></td>
            <td><?php echo $vc['visits'];?></td>
        </tr>
                <?php }
        } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Total Visits</th>
            <th><?= $total ?></th>
        </tr>
    </tfoot>
</table>
</div>

<div class="span6" style="width:55%; float: left; margin:10px 0px 0px 0px;">  
        <?php
//very useful google chart
        $this->widget('ext.Hzl.google.HzlVisualizationChart', array('visualization' => 'PieChart',
            'data' => $datasets,
            'options' => array('title' => 'Total Visitors by Visitor Type')));
        ?>
    </div>