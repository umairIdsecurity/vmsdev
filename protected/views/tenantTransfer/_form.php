<?php $this->renderPartial('//importHosts/buttonstyle', null, false); ?>
<br>

<ol>
    <li> Select a tenant file to import.</li>
</ol>
<br>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id'=>'importtenant-form',
        'enableAjaxValidation'=>false,
        /*'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),*/
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