<h1> Total VICs by Card Type </h1>
<!-- Filter Form -->
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'visitor-type-filter-form',
	'enableAjaxValidation'=>false,
)); ?>
        <label> Date From:  </label>
            <?php
                $this->widget( 'zii.widgets.jui.CJuiDatePicker',array(
                    'attribute'   => 'date_from_filter',
                    'language'=> 'en',
                    'name'=>'date_from_filter',
                    'value'=>Yii::app()->request->getParam("date_from_filter"),
                    'options'=>array(
                            'changeYear' => true,
                            'dateFormat'=>'dd-mm-yy',
                            'changeMonth'=> true,
                            'onClose' => 'js:function (selectedDate) { $("#date_to_filter").datepicker("option", "minDate", selectedDate); }',
                    ),
                   'htmlOptions'=>array('readonly'=>"readonly"),
                ));
            ?>
            
        <br><br>
        <label> Date To: </label>
                <?php 
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array( 
                        'attribute'   => 'date_to_filter',
                        'language'=> 'en',
                        'name'=>'date_to_filter',
                        'value'=>Yii::app()->request->getParam("date_to_filter"),
                        // additional javascript options for the date picker plugin
                        'options'=>array(
                            'changeYear' => true,
                            'dateFormat'=>'dd-mm-yy',
                            'changeMonth'=> true,
                        ),
                        'htmlOptions'=>array('readonly'=>"readonly"),
                    )); 
                ?>
         
	 <?php echo CHtml::submitButton('Filter'); ?>
	 
        <?php $this->endWidget()?>    
    </div>

<!-- Listing and Pie Chart Div -->
<div class="content" style="width:40%; float: left; margin:20px 10px 0px 5px;">
<table class="table" cellpadding="4" width="100%">
    <thead>
        <tr>
            <th> Card Type </th>
            <th> VIC Count </th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        $datasets = array(
            array('VisitorType', 'Visitors per Visitor')
        );
        
        $total=0;
        
        if($visitor_count) { 
                
                $count=1;
                
                foreach($visitor_count as $vc ) {
                    $datasets[$count] =  array($vc['name'],intval($vc['visitors']));
                    $count++;
                    $total += intval($vc['visitors']);
?>
                    <tr>
                        <td><?php echo $vc['name']; ?></td>
                        <td><?php echo $vc['visitors'];?></td>
                    </tr>
                <?php }
                
        } 
        foreach ($otherCards as $card) {
            ?>
            <tr>
                <td><?php echo $card['name']; ?></td>
                <td>0</td>
            </tr>
        <?php
        }
        ?>            
    </tbody>
    <tfoot>
        <tr>
            <th>Total VIC </th>
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
            'options' => array('title' => 'Total VICs by Visitor Type')));
        ?>
    </div>