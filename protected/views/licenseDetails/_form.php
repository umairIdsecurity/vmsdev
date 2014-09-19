<?php
/* @var $this LicenseDetailsController */
/* @var $model LicenseDetails */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'license-details-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->labelEx($model,'description'); ?>
    <?php $this->widget('ext.widgets.redactorjs.Redactor', array('name' => 'LicenseDetails[description]','model' => $model, 'attribute' => 'description')); ?>


    <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>
    

<?php $this->endWidget(); ?>

</div><!-- form -->

