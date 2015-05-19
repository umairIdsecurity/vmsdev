<h1> Import Host/Staff File (.csv) </h1>
 
<div class="form">
 
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'importcsv-form',
    'enableAjaxValidation'=>false,
    'method'=>'post',
     
    'htmlOptions'=>array(
    'enctype'=>'multipart/form-data'
    )
)); ?>
 
     
             <div class=" <?php if ($model->hasErrors('postcode')) echo "error"; ?>">                    
                    <?php echo $form->fileField($model,'file'); ?>
                    <?php echo $form->error($model,'file'); ?>
              </div>
              <div class="row">
             <?php echo CHtml::submitButton('Upload File'); ?>   
              </div>
              
 
       
  
 
<?php $this->endWidget(); ?>
 
</div><!-- form -->