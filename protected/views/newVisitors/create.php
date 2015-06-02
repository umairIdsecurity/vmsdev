<?php
/* @var $this NewVisitorsController */
/* @var $model NewVisitors */

$this->breadcrumbs=array(
	'New Visitors'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List NewVisitors', 'url'=>array('index')),
	array('label'=>'Manage NewVisitors', 'url'=>array('admin')),
);
?>

<h1>Create NewVisitors</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>