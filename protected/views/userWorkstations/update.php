<?php
/* @var $this UserWorkstationsController */
/* @var $model UserWorkstations */

$this->breadcrumbs=array(
	'User Workstations'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UserWorkstations', 'url'=>array('index')),
	array('label'=>'Create UserWorkstations', 'url'=>array('create')),
	array('label'=>'View UserWorkstations', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage UserWorkstations', 'url'=>array('admin')),
);
?>

<h1>Update UserWorkstations <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>