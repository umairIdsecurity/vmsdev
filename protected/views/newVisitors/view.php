<?php
/* @var $this NewVisitorsController */
/* @var $model NewVisitors */

$this->breadcrumbs=array(
	'New Visitors'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List NewVisitors', 'url'=>array('index')),
	array('label'=>'Create NewVisitors', 'url'=>array('create')),
	array('label'=>'Update NewVisitors', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete NewVisitors', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage NewVisitors', 'url'=>array('admin')),
);
?>

<h1>View NewVisitors #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'first_name',
		'middle_name',
		'last_name',
		'email',
		'contact_number',
		'date_of_birth',
		'company',
		'department',
		'position',
		'staff_id',
		'notes',
		'password',
		'role',
		'visitor_type',
		'visitor_status',
		'vehicle',
		'photo',
		'created_by',
		'is_deleted',
		'tenant',
		'tenant_agent',
		'visitor_card_status',
		'visitor_workstation',
		'profile_type',
		'identification_type',
		'identification_country_issued',
		'identification_document_no',
		'identification_document_expiry',
		'identification_alternate_document_name1',
		'identification_alternate_document_no1',
		'identification_alternate_document_expiry1',
		'identification_alternate_document_name2',
		'identification_alternate_document_no2',
		'identification_alternate_document_expiry2',
		'contact_unit',
		'contact_street_no',
		'contact_street_name',
		'contact_street_type',
		'contact_suburb',
		'contact_state',
		'contact_country',
		'asic_no',
		'asic_expiry',
		'verifiable_signature',
		'contact_postcode',
	),
)); ?>
