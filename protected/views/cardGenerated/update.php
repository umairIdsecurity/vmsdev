
<?php
/* @var $this CardGeneratedController */
/* @var $model CardGenerated */

$this->breadcrumbs=array(
	'Card Generateds'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CardGenerated', 'url'=>array('index')),
	array('label'=>'Create CardGenerated', 'url'=>array('create')),
	array('label'=>'View CardGenerated', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CardGenerated', 'url'=>array('admin')),
);
?>

<h1>Update CardGenerated <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>