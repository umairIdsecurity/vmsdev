<?php
/* @var $this NotificationsController */
/* @var $model Notification */

$this->breadcrumbs=array(
	'Notifications'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Notification', 'url'=>array('index')),
	array('label'=>'Create Notification', 'url'=>array('create')),
	array('label'=>'Update Notification', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Notification', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Notification', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->subject; ?></h1>
<br> 
<div class="container">
    <p>
    <strong> Detail </strong> <br>
        <?php echo $model->message;?>
    </p>
    <p><strong> Date </strong>  <br><?php echo $model->date_created;?></p>
    <p><strong> Type </strong> <br><?php echo $model->notification_type;?></p>
 </div>
     
 <?php echo CHtml::submitButton('Back',array("submit"=>array('notifications/index'))); ?>

 
