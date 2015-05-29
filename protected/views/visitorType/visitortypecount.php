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
        <?php if($visit_count) { 
                foreach($visit_count as $key => $vc ) {
?>
        <tr>
            <td><?php echo $vc->name?></td>
            <td><?php echo count($vc['visits']);?></td>
        </tr>
                <?php }
        } ?>
    </tbody>
</table>
</div>

<div class="float:left; width:55%; margin:20px 10px 0px 5px;">
    <tab>
        sadf
    </tab>
</div>