<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'excel-form',
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    )); ?>
    <div class="row">
        <b>Select XLS file: </b>
        <?php echo $form->fileField($model,'file',array('size'=>60,'maxlength'=>200)); ?>
        <?php echo CHtml::submitButton('Import'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>