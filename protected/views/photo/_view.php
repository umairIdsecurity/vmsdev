<?php
/* @var $this PhotoController */
/* @var $data Photo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('filename')); ?>:</b>
	<?php echo CHtml::encode($data->filename); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unique_filename')); ?>:</b>
	<?php echo CHtml::encode($data->unique_filename); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('relative_path')); ?>:</b>
	<?php echo CHtml::encode($data->relative_path); ?>
	<br />


</div>