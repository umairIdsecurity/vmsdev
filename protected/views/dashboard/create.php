
<?php
/* @var $this DashboardController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<h1>Add User</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>