<h1> Import Visit History </h1>
<br>
 
        <ol>
            <li> To Import Visit History <?php echo CHtml::link("download sample template", array("visitor/csvSampleDownload"))?></li>
            <li> Complete mandatory and import by sending from your browser. </li>
        </ol>
<br>  

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