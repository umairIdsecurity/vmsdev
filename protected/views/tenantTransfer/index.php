<?php $this->renderPartial('//importHosts/buttonstyle', null, false); ?>
<h1> Import Tenant </h1>
<br>

<ol>
    <li> Select a tenant import file.</li>
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
        <label class="myLabel" for="ImportTenantForm_file" style="width: 70px;">
            <?php echo $form->fileField($model,'file'); ?>
            <span>Browse File</span>
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