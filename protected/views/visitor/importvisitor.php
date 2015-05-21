<?php 
$session = new CHttpSession;
$company = Company::model()->findByPk($session['company']);
$companyLafPreferences = CompanyLafPreferences::model()->findByPk($company->company_laf_preferences); 
$company_neutral_bg_color = "";
if(!is_null($companyLafPreferences)){$company_neutral_bg_color = "background-color: ".$companyLafPreferences->neutral_bg_color;} 
?>
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
                 <label class="myLabel" style=" cursor:pointer;font-size:14px;<?php echo $company_neutral_bg_color ?>;">
                    <?php echo $form->fileField($model,'file'); ?>
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