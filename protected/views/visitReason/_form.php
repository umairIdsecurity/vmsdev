
<?php
/* @var $this VisitReasonController */
/* @var $model VisitReason */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'visit-reason-form',
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
                <td  style="vertical-align: top;width:100px;">
                    <?php echo $form->labelEx($model,'reason'); ?>:
                </td>
                
                <td >
                    <textarea id="VisitReason_reason" maxlength="128" name="VisitReason[reason]" style="width:400px !important;text-transform: capitalize;" cols="80" rows="3"><?php 
                        echo $model->reason;
                    ?></textarea> <?php echo $form->error($model,'reason'); ?>
                </td>
            </tr>
        </table>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array('class'=> 'complete')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->