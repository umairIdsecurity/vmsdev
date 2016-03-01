<?php
/* @var $this ContactPersonController */
/* @var $data ContactPerson */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_person_name')); ?>:</b>
	<?php echo CHtml::encode($data->contact_person_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_person_email')); ?>:</b>
	<?php echo CHtml::encode($data->contact_person_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_role')); ?>:</b>
	<?php echo CHtml::encode($data->user_role); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reason_id')); ?>:</b>
	<?php echo CHtml::encode($data->reason_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_created')); ?>:</b>
	<?php echo CHtml::encode($data->date_created); ?>
	<br />


</div>