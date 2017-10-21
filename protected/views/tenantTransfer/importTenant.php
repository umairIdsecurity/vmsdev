<?php $this->renderPartial('//importHosts/buttonstyle', null, false); ?>
<h1> Import Tenant </h1>
<br>
    <ol>

        <li> Select a file to import.</li>
    </ol>
<br>

<div class="form">

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'importtenant-form',
    'enableAjaxValidation'=>false,
    'method'=>'post',
    'htmlOptions'=>array(
        'enctype'=>'multipart/form-data'
    )
)); ?>


    <div class=" <?php if ($model->hasErrors('postcode')) echo "error"; ?>">
        <label class="myLabel" for="ImportTenantForm_tenantFile" style="width: 120px;">
            <?php echo $form->fileField($model,'tenantFile'); ?>
            <span>Select Tenant File</span>
        </label>

        <div class="row message-no-margin">
            <?php echo $form->error($model,'file'); ?>
        </div>
    </div>
<!--    <div class=" --><?php //if ($model->hasErrors('postcode')) echo "error"; ?><!--">-->
<!--        <label class="myLabel" for="ImportTenantForm_avms7File" style="width: 120px;">-->
<!--            --><?php //echo $form->fileField($model,'avms7File'); ?>
<!--            <span>Select AVMS 7 File</span>-->
<!--        </label>-->
<!---->
<!--        <div class="row message-no-margin">-->
<!--            --><?php //echo $form->error($model,'file'); ?>
<!--        </div>-->
<!--    </div>-->

    <div class="row">
        <?php echo CHtml::submitButton('Upload File(s)', array("class"=>"completeButton")); ?>
    </div>

<?php $this->endWidget(); ?>

</div>