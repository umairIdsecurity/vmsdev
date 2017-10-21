<?php $this->renderPartial('//importHosts/buttonstyle', null, false); ?>
<h1> Import Visit History </h1>
<br>
    <ol>
        <li> Please download <?php echo CHtml::link("sample template", array("visitor/csvSampleDownload"))?> and upload from the browse button.</li>
        <li> Complete mandatory and import by sending from your browser. </li>
    </ol>
<br>  

<div class="form">
 
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'importcsv-form',
    'enableAjaxValidation'=>false,
    'method'=>'post',
	'stateful'=>true,
    'htmlOptions'=>array(
        'enctype'=>'multipart/form-data'
    )
)); ?>
 
     
     <div class=" <?php if ($model->hasErrors('postcode')) echo "error"; ?>">
         <label >
             <?php echo $form->fileField($model,'file', array('class'=>'input-file')); ?>
             <!--<span>Browse File</span>-->
			 <?php //echo $data->fileName;?>
         </label>

          <div class="row message-no-margin">
            <?php echo $form->error($model,'file'); ?>
         </div>
      </div>
      <div class="row">
        <?php echo CHtml::submitButton('Upload File', array("class"=>"completeButton")); ?>
      </div>

<?php $this->endWidget(); ?>
 
</div><!-- form -->