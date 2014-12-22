
<?php
/* @var $this VisitorController */
/* @var $model Visitor */

$this->breadcrumbs=array(
	'Visitors'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Visitor', 'url'=>array('index')),
	array('label'=>'Create Visitor', 'url'=>array('create')),
	array('label'=>'View Visitor', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Visitor', 'url'=>array('admin')),
);
?>

<h1>Edit Visitor </h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>