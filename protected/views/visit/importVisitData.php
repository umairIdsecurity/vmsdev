<br>
<?php
foreach (Yii::app()->user->getFlashes() as $key => $message) {
    echo '<div class="flash-' . $key . '" style="width:450px !important;">' . $message . "</div>\n";
}
?>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'excel-form',
        'enableAjaxValidation'=>false,
        'method'=>'post',
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    )); ?>
    <div class="row">
        <b>Select XLS file: </b>
        <?php echo $form->fileField($model,'file_xls',array('size'=>60,'maxlength'=>200)); ?>
        <?php echo $form->error($model,'file_xls'); ?>
        <?php echo CHtml::submitButton('Import', array("class"=>"completeButton")); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>