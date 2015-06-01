<?php
/* @var $this AuditTrailController */
/* @var $model AuditTrail */
?>

<h1>Details Audit Trail</h1>

<table class="table table-bordered">
	<tbody>
	<tr>
		<td>ID</td>
		<td><?=$model->id?></td>
	</tr>
	<tr>
		<td>Description</td>
		<td><?=$model->description?></td>
	</tr>
	<tr>
		<td>Old Value</td>
		<td><?=$model->old_value?></td>
	</tr>
	<tr>
		<td>New Value</td>
		<td><?=$model->new_value?></td>
	</tr>
	<tr>
		<td>Action</td>
		<td><?=$model->action?></td>
	</tr>
	<tr>
		<td>Model</td>
		<td><?=$model->model?></td>
	</tr>
	<tr>
		<td>Model ID</td>
		<td><?=$model->model_id?></td>
	</tr>
	<tr>
		<td>Field</td>
		<td><?=$model->field?></td>
	</tr>
	<tr>
		<td>Creation Date</td>
		<td><?=$model->creation_date?></td>
	</tr>
	<tr>
		<td>User ID</td>
		<td><?=$model->user_id?></td>
	</tr>

	</tbody>
</table>