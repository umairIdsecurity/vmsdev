<?php
/* @var $this AuditLogController */
/* @var $model AuditLog */

/*$this->breadcrumbs=array(
	'Audit Logs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AuditLog', 'url'=>array('index')),
	array('label'=>'Create AuditLog', 'url'=>array('create')),
	array('label'=>'Update AuditLog', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AuditLog', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AuditLog', 'url'=>array('admin')),
);
?>

<h1>View AuditLog #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'action_datetime',
		'action',
		'detail',
		'user_email_address',
		'ip_address',
		'tenant',
		'tenant_agent',
	),
)); */
?>

<h1>Details Audit Trail</h1>

<table class="table table-bordered">
	<tbody>
	<tr>
		<td>ID</td>
		<td><?=$model->id?></td>
	</tr>
	<tr>
		<td>Action Datetime</td>
		<td><?=$model->action_datetime?></td>
	</tr>
	<tr>
		<td>Action</td>
		<td><?=$model->action?></td>
	</tr>
	<tr>
		<td>Detail</td>
		<td><?=$model->detail?></td>
	</tr>
	<tr>
		<td>User Email Address</td>
		<td><?=$model->user_email_address?></td>
	</tr>
	<tr>
		<td>Ip Address</td>
		<td><?=$model->ip_address?></td>
	</tr>
	<tr>
		<td>Tenant</td>
		<td><?=$model->tenant?></td>
	</tr>
	<tr>
		<td>Tenant Agent</td>
		<td><?=$model->tenant_agent?></td>
	</tr>
	</tbody>
</table>
