
<?php
/* @var $this LicenseDetailsController */
/* @var $model LicenseDetails */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'license-details-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->labelEx($model,'description'); ?>
    <?php $this->widget('ext.widgets.redactorjs.Redactor', array(
    'name' => 'LicenseDetails[description]',
    'model' => $model, 
    'attribute' => 'description',
    'editorOptions' => array(
        'fileUpload'=>Yii::app()->createUrl('licenseDetails/fileUpload',array(
            'attr'=>'description'
        )),
        'fileUploadErrorCallback'=>new CJavaScriptExpression(
            'function(obj,json) { alert(json.error); }'
        ),
        'imageUpload'=>Yii::app()->createUrl('licenseDetails/imageUpload',array(
            'attr'=>'description'
        )),
        'imageGetJson'=>Yii::app()->createUrl('licenseDetails/imageList',array(
            'attr'=>'description'
        )),
        'imageUploadErrorCallback'=>new CJavaScriptExpression(
            'function(obj,json) { alert(json.error); }'
        ),
    ),
    )); 
    ?>




    <div class="row buttons buttonsAlignToRight">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save',array('class'=>'complete')); ?>
    </div>
    

<?php $this->endWidget(); ?>

</div><!-- form -->

