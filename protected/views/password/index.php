<?php
/* @var $this PasswordController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Passwords',
);

$this->menu=array(
	array('label'=>'Create Password', 'url'=>array('create')),
	array('label'=>'Manage Password', 'url'=>array('admin')),
);
?>

<h1>Passwords</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
