<?php
/* @var $this NewVisitorsController */
/* @var $model NewVisitors */

$this->breadcrumbs=array(
	'New Visitors'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List NewVisitors', 'url'=>array('index')),
	array('label'=>'Create NewVisitors', 'url'=>array('create')),
	array('label'=>'View NewVisitors', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage NewVisitors', 'url'=>array('admin')),
);
?>

<h1>Update NewVisitors <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>