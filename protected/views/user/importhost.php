<?php $this->renderPartial('//importHosts/buttonstyle', null, false); ?>
<h1> Import Host/Staff Profiles </h1>
<br>
 
        <ol>
            <li> Please download <?php echo CHtml::link("sample template", array("importHosts/downloadSampleHostCsv"))?> and upload from the browse button.</li>
            <li> Complete mandatory and import by sending from your browser. </li>
        </ol>
<br> 
 
<div class="form" style="width: 12%;">
 
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'importcsv-form',
    'enableAjaxValidation'=>false,
    'method'=>'post',
     
    'htmlOptions'=>array(
    'enctype'=>'multipart/form-data',
    )
)); ?>
 
     
             <div class=" <?php if ($model->hasErrors('file')) echo "error"; ?>">   
                 <label class="myLabel">
                    <?php echo $form->fileField($model,'file'); ?>
                      <span>Browse File</span>
                 </label> 
                 <div class="row">
                    <?php echo $form->error($model,'file'); ?>
                 </div>    
              </div>
    <br>
              <div class="row">
             <?php echo CHtml::submitButton('Upload File', array("class"=>"completeButton")); ?>   
              </div>
 
<?php $this->endWidget(); ?>     
</div><!-- form -->