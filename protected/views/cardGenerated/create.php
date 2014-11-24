<?php
/* @var $this CardGeneratedController */
/* @var $model CardGenerated */

$this->breadcrumbs=array(
	'Card Generateds'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CardGenerated', 'url'=>array('index')),
	array('label'=>'Manage CardGenerated', 'url'=>array('admin')),
);
?>

<h1>Create CardGenerated</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>