
<?php
/* @var $this CardGeneratedController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Card Generateds',
);

$this->menu=array(
	array('label'=>'Create CardGenerated', 'url'=>array('create')),
	array('label'=>'Manage CardGenerated', 'url'=>array('admin')),
);
?>

<h1>Card Generateds</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
