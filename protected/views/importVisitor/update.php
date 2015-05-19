<?php
/* @var $this ImportVisitorController */
/* @var $model ImportVisitor */

$this->breadcrumbs=array(
	'Import Visitors'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ImportVisitor', 'url'=>array('index')),
	array('label'=>'Create ImportVisitor', 'url'=>array('create')),
	array('label'=>'View ImportVisitor', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ImportVisitor', 'url'=>array('admin')),
);
?>

<h1>Update ImportVisitor <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>