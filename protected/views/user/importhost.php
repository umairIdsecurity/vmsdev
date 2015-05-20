<h1> Import Host/Staff Profiles </h1>
<br>
 
        <ol>
            <li> Please download <?php echo CHtml::link("sample template", array("importHosts/downloadSampleHostCsv"))?> and upload from the browse button.</li>
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
 
     
             <div class=" <?php if ($model->hasErrors('file')) echo "error"; ?>">   
                 <label class="myLabel">
                    <?php echo $form->fileField($model,'file', array("")); ?>
                      <span>Browse File</span>
                 </label>   
                    <?php echo $form->error($model,'file'); ?>
              </div>
    <br>
              <div class="row">
             <?php echo CHtml::submitButton('Upload File'); ?>   
              </div>
 
<?php $this->endWidget(); ?>     
</div><!-- form -->