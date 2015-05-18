<?php
/* @var $this ImportVisitorController */
/* @var $data ImportVisitor */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('first_name')); ?>:</b>
	<?php echo CHtml::encode($data->first_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_name')); ?>:</b>
	<?php echo CHtml::encode($data->last_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company')); ?>:</b>
	<?php echo CHtml::encode($data->company); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('check_in_date')); ?>:</b>
	<?php echo CHtml::encode($data->check_in_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('check_out_date')); ?>:</b>
	<?php echo CHtml::encode($data->check_out_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('card_code')); ?>:</b>
	<?php echo CHtml::encode($data->card_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('imported_by')); ?>:</b>
	<?php echo CHtml::encode($data->imported_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('import_date')); ?>:</b>
	<?php echo CHtml::encode($data->import_date); ?>
	<br />

	*/ ?>

</div>