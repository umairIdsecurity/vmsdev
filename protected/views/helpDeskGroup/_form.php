<?php
/* @var $this HelpDeskGroupController */
/* @var $model HelpDeskGroup */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'helpdesk-group-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model,'name'); ?></td>
                <td><?php echo $form->textField($model,'name',array('size'=>25,'maxlength'=>25)); ?><?php echo "<br>".$form->error($model,'name'); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model,'order_by'); ?></td>
                <td><?php echo $form->textField($model,'order_by',array('size'=>5,'maxlength'=>5)); ?></td>
            </tr>
        </table>

	<div class="row buttons buttonsAlignToRight">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array("class" => "complete")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->