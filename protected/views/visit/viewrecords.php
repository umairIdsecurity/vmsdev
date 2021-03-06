<?php

/* @var $this VisitController */
/* @var $model Visit */
?>
<style>
    .grid-view .summary {
        margin-left: 998px !important;
    }
</style>
<?php if (Yii::app()->user->hasFlash('error')): ?>
    <div class="alert alert-danger" style="margin-top: 10px;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Warning!</strong> <?php echo Yii::app()->user->getFlash('error');?>
    </div>
<?php endif;?>

<!-- //because of https://ids-jira.atlassian.net/browse/CAVMS-1147 -->      
<?php if(in_array(Yii::app()->user->role, [7,8,12,14])): ?>
	<?php if(Yii::app()->user->hasFlash('success')): ?>
		<div class="flash-success" style="margin-top: 10px;">
			<?php echo Yii::app()->user->getFlash('success'); ?>
		</div>
	<?php endif; ?>
<?php endif; ?>


<h1>Visit History</h1>
<?php
$session = new CHttpSession;

// this is the date picker
$date_check_in = $this->widget('EDatePicker', array(
	'language'    => 'id',
	'model'       => $model,
	'attribute'   => 'date_check_in',
), true);

// this is the date picker
$date_check_out = $this->widget('EDatePicker', array(
	'model'=>$model,
	'attribute'        => 'date_check_out',
), true);

// this is the date picker
$date_of_birth = $this->widget('EDatePicker', array(
	'model'       => $model,
	'attribute'  => 'date_of_birth',
	'mode' 		=> 'date_of_birth'
), true);

$login_url = $this->createUrl('site/login');

//jQuery('#Visit_date_of_birth').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'showAnim':'fold','dateFormat':'mm-dd-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));

$this->widget('zii.widgets.grid.CGridView', array(
	'id'              => 'view-visitor-records',
	'dataProvider'    => $model->search_history(),
	'enableSorting'   => false,
	'hideHeader'      => true,
	'pager'           => array('class' => 'CLinkPager', 'header' => ''),
	'filter'          => $model,
	'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
        jQuery('#Visit_date_check_in').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'showAnim':'fold','dateFormat':'dd-mm-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
        jQuery('#Visit_date_check_out').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'showAnim':'fold','dateFormat':'dd-mm-yy','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
        
    }",
    'ajaxUpdateError' => "function(id, data) {window.location.replace('$login_url');}",

	'columns'         => array(
		array(
			'name'               => 'visit_status',
			'filter'             => false,
			'value'              => 'CHtml::link(VisitStatus::$VISIT_STATUS_LIST[$data->visit_status],Yii::app()->createUrl("visit/detail",array("id"=>$data->id)),array("class" =>"statusLink"))',
			'type'               => 'raw',
			'header'             => 'Status',
			'filter'             => VisitStatus::$VISIT_STATUS_LIST,
			'cssClassExpression' => 'changeStatusClass($data->visit_status)',
			'htmlOptions'        => array('width' => '120px'),
		),
		/*array(
		'name' => 'visitor_type',
		'value' => '$data->visitorType->name',
		'filter' => VisitorType::model()->returnVisitorTypes(),
		'htmlOptions'=>array('width'=>'170px'),
		),*/
		array(
			'name'        => 'cardnumber',
			'header'      => 'Card No.',
			'filter'      => CHtml::activeTextField($model, 'cardnumber', array('placeholder' => 'Card No.')),
			'value'       => 'CardGenerated::model()->getCardCode($data->card)',
			'htmlOptions' => array('width' => '120px'),
		),
		array(
			'name'        => 'firstname',
			'filter'      => CHtml::activeTextField($model, 'firstname', array('placeholder' => 'First Name')),
			'value'       => '!empty($data->visitor0->first_name) ? $data->visitor0->first_name : ""',
			'header'      => 'First Name',
			'htmlOptions' => array('width' => '120px'),
		),
		array(
			'name'        => 'lastname',
			'filter'      => CHtml::activeTextField($model, 'lastname', array('placeholder' => 'Last Name')),
			'value'       => '!empty($data->visitor0->last_name) ? $data->visitor0->last_name : ""',
			'header'      => 'Last Name',
			'htmlOptions' => array('width' => '120px'),
		),
		array(
			'name'        => 'date_of_birth',
			'type'        => 'html',
			'filter'      => $date_of_birth,
			'htmlOptions' => array('width' => '110px'),
			'value'		  => '!empty($data->visitor0->date_of_birth) ? CHelper::formatDate($data->visitor0->date_of_birth) : ""',	
		),
		array(
			'name'        => 'company',
			'filter'      => CHtml::activeTextField($model, 'company', array('placeholder' => 'Company')),
			'value'       => '!empty($data->company0->name) ? $data->company0->name : ""',
			'htmlOptions' => array('width' => '120px'),
		),
		array(
			'name'        => 'date_check_in',
			'filter'      => $date_check_in,
			'type'        => 'html',
			'htmlOptions' => array('width' => '100px'),
			 'value'       => 'CHelper::formatDate($data->date_check_in)',
		),
		array(
			'name'        => 'time_check_in',
			'type'        => 'html',
			'value'       => 'formatTime($data->time_check_in)',
			'filter'      => CHtml::activeTextField($model, 'time_check_in', array('placeholder' => 'Check In Time')),
			'htmlOptions' => array('width' => '100px'),
		),
		array(
			'name'        => 'date_check_out',
			'type'        => 'html',
			'filter'      => $date_check_out,
			'htmlOptions' => array('width' => '110px'),
			'value'       => 'CHelper::formatDate($data->date_check_out)',
		),
		array(
			'name'        => 'time_check_out',
			'type'        => 'html',
			'value'       => 'formatTime($data->time_check_out)',
			'filter'      => CHtml::activeTextField($model, 'time_check_out', array('placeholder' => 'Check Out Time')),
			'htmlOptions' => array('width' => '110px'),
		),
		// 'card0.date_expiration',
		/*array(
			'name' => 'date_out',
			'type' => 'html',
			'header' => 'Date Expiration',
			'filter'=>CHtml::activeTextField($model, 'date_out', array('placeholder'=>'Date Expiration')),
			'htmlOptions'=>array('width'=>'110px'),
		),*/
	),
));

function getCompany($id) {

	$company_id = Visitor::model()->findByPk($id)->company;

	if (isset($company_id)) {

		$companyModel = Company::model();

		$company = $companyModel->findByPk($company_id, "is_deleted >= 0 ");

		if (isset($company)) {
			return $company->name;
		}
	}
	return "Not Available";

}

function formatTime($time) {
	if ($time == '' || $time == '00:00:00') {
		return "-";
	} else {
		return date('h:i A', strtotime($time));
	}
}

function formatDate($date, $visitStatus) {
	if ($date == '' || $visitStatus != 1 || $date == '0000-00-00') {
		return "-";
	} else {
		return Yii::app()->dateFormatter->format("dd-MM-y", strtotime($date));
	}
}

function changeStatusClass($visitStatus) {
	// return "red";
	switch ($visitStatus) {
		case VisitStatus::ACTIVE:
			return "green";
			break;

		case VisitStatus::PREREGISTERED:
			return "blue";
			break;

		case VisitStatus::CLOSED:
			return "black";
			break;

		case VisitStatus::SAVED:
			return "grey";
			break;

		case VisitStatus::EXPIRED:
			return "red";
			break;

		default:
			break;
	}
}
?>
