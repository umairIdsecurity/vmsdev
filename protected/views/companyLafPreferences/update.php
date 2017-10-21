<?php
/* @var $this UserLafPreferencesController */
/* @var $model UserLafPreferences */

$this->breadcrumbs=array(
	'User Laf Preferences'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UserLafPreferences', 'url'=>array('index')),
	array('label'=>'Create UserLafPreferences', 'url'=>array('create')),
	array('label'=>'View UserLafPreferences', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage UserLafPreferences', 'url'=>array('admin')),
);
?>

<h1>Update UserLafPreferences <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>