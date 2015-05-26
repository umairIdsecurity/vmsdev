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
     
    'htmlOptions'=>array(
    'enctype'=>'multipart/form-data'
    )
)); ?>
 
     
             <div class=" <?php if ($model->hasErrors('postcode')) echo "error"; ?>">
                 <label class="myLabel" for="ImportCsvForm_file">
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