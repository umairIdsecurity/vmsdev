<?php
/* @var $this NewVisitorsController */
/* @var $model NewVisitors */

$this->breadcrumbs=array(
	'New Visitors'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List NewVisitors', 'url'=>array('index')),
	array('label'=>'Create NewVisitors', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#new-visitors-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage New Visitors</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'new-visitors-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'first_name',
		'middle_name',
		'last_name',
		'email',
		'contact_number',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
