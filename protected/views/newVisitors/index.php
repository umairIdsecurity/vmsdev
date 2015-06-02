<?php
/* @var $this NewVisitorsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'New Visitors',
);

$this->menu=array(
	array('label'=>'Create NewVisitors', 'url'=>array('create')),
	array('label'=>'Manage NewVisitors', 'url'=>array('admin')),
);
?>

<h1>New Visitors</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
