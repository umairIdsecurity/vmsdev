
<?php
/* @var $this CardTypeController */
/* @var $data CardType */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_day_validity')); ?>:</b>
	<?php echo CHtml::encode($data->max_day_validity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_time_validity')); ?>:</b>
	<?php echo CHtml::encode($data->max_time_validity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_entry_count_validity')); ?>:</b>
	<?php echo CHtml::encode($data->max_entry_count_validity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('card_icon_type')); ?>:</b>
	<?php echo CHtml::encode($data->card_icon_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('card_background_image_path')); ?>:</b>
	<?php echo CHtml::encode($data->card_background_image_path); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	*/ ?>

</div>