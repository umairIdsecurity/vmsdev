<?php
/* @var $this WorkstationsController */
/* @var $model Workstations */
/* @var $form CActiveForm */
$session = new CHttpSession;
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'workstations-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model,'name'); ?></td>
                <td><?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?></td>
                <td><?php echo $form->error($model,'name'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model,'location'); ?></td>
                <td><?php echo $form->textField($model,'location',array('size'=>60,'maxlength'=>100)); ?></td>
                <td><?php echo $form->error($model,'location'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model,'contact_name'); ?></td>
                <td><?php echo $form->textField($model,'contact_name',array('size'=>50,'maxlength'=>50)); ?></td>
                <td><?php echo $form->error($model,'contact_name'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model,'contact_number'); ?></td>
                <td><?php echo $form->textField($model,'contact_number'); ?></td>
                <td><?php echo $form->error($model,'contact_number'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model,'contact_email_address'); ?></td>
                <td><?php echo $form->textField($model,'contact_email_address',array('size'=>50,'maxlength'=>50)); ?></td>
                <td><?php echo $form->error($model,'contact_email_address'); ?></td>
            </tr>
            <?php if ($this->action->id !='update') {?>
            <tr>
                <td><?php echo $form->labelEx($model,'password'); ?></td>
                <td><input type="password" id="Workstation_password" name="Workstation[password]" ></td>
                <td><?php echo $form->error($model,'password'); ?></td>
            </tr>
            <?php } ?>
            <input type="hidden" id="Workstation_created_by" name="Workstation[created_by]" value="<?php echo $session['id'];?>">
            <input type="hidden" id="Workstation_tenant" name="Workstation[tenant]" value="<?php echo $session['tenant'];?>">
            <input type="hidden" id="Workstation_tenant_agent" name="Workstation[tenant_agent]" value="<?php echo $session['tenant_agent']?>">
        </table>
	

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->