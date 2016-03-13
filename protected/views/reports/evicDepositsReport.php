<h1>EVIC Deposits Report</h1>
<!-- Filter Form -->
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'visitor-type-filter-form',
	'enableAjaxValidation'=>false,
)); ?>
        <label>Check In Date From:  </label>
            <?php
                $this->widget( 'EDatePicker',array(
                    'attribute'   => 'date_from_filter',
                    'name'=>'date_from_filter',
                    'value'=>Yii::app()->request->getParam("date_from_filter")? Yii::app()->request->getParam("date_from_filter"):$dateFrom,
                    'options'=>array(
                            'onClose' => 'js:function (selectedDate) { $("#date_to_filter").datepicker("option", "minDate", selectedDate); }',
                    ),
                   'htmlOptions'=>array('readonly'=>"readonly"),
                ));
            ?>
            
        <br><br>
        <label>Check In Date To: </label>
                <?php 
                    $this->widget('EDatePicker', array(
                        'attribute'   => 'date_to_filter',
                        'language'=> 'en',
                        'name'=>'date_to_filter',
                        'value'=>Yii::app()->request->getParam("date_to_filter")?Yii::app()->request->getParam("date_to_filter"):$dateTo,
                        'htmlOptions'=>array('readonly'=>"readonly"),
                    )); 
                ?>
         
	 <?php echo CHtml::submitButton('Filter', array("class"=>"complete")); ?>
	 
        <?php $this->endWidget()?>    
    </div>

<!-- Listing and Pie Chart Div -->
<div class="content" style="width:40%; float: left; margin:20px 10px 0px 5px;">
<table class="table" cellpadding="4" width="100%">
    <thead>
        <tr>
            <th> Reports </th>
            <th> Count </th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $datasets = array(
            array('Reports', 'Count',),
            array("Deposit Paid", $deposit_paid),
            array("Expired", $expired),
            array("Not Returned", $not_returned),
            array("Closed & Refunded", $closed_returned),
        );
        ?>
        <tr>
            <td>Deposit Paid</td>
            <td><?php echo $deposit_paid;?></td>
        </tr>
        
         <tr>
            <td>Expired</td>
            <td><?php echo $expired;?></td>
        </tr>
        
         <tr>
            <td>Not Returned </td>
            <td><?php echo $not_returned;?></td>
        </tr>
        
         <tr>
            <td>Closed and Refunded </td>
            <td><?php echo $closed_returned;?></td>
        </tr>
     
    </tbody>
     
</table>
</div>

<div class="span6" style="width:55%; float: left; margin:10px 0px 0px 0px;">  
        <?php
//very useful google chart
        $this->widget('ext.Hzl.google.HzlVisualizationChart', array('visualization' => 'PieChart',
            'data' => $datasets,
            'options' => array('title' => 'EVIC Deposits Report')));
        ?>
    </div>