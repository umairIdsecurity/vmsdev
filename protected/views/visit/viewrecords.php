<?php

/* @var $this VisitController */
/* @var $model Visit */
?>
<style>
    .grid-view .summary {
        margin-left: 998px !important;
    }
</style>
<?php if(Yii::app()->user->hasFlash('error')):?>
    <div class="alert alert-danger" style="margin-top: 10px;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Warning!</strong> <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>
<h1>Visit History</h1>
<?php
$session = new CHttpSession;

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'view-visitor-records',
    'dataProvider' => $model->search_history(),
    'enableSorting' => false,
    'hideHeader'=>true,
    'filter' => $model,
    'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",

    'columns' =>
    array(
        array(
            'name' => 'visit_status',
            'filter' => false,
            'value' => 'CHtml::link(VisitStatus::$VISIT_STATUS_LIST[$data->visit_status],Yii::app()->createUrl("visit/detail",array("id"=>$data->id)),array("class" =>"statusLink"))',
            'type' => 'raw',
            'header' => 'Status',
            'filter' => VisitStatus::$VISIT_STATUS_LIST,
            'cssClassExpression' => 'changeStatusClass($data->visit_status)',
            'htmlOptions'=>array('width'=>'120px'),
        ),
        /*array(
            'name' => 'visitor_type',
            'value' => '$data->visitorType->name',
            'filter' => VisitorType::model()->returnVisitorTypes(),
            'htmlOptions'=>array('width'=>'170px'),
        ),*/
        array(
            'name' => 'cardnumber',
            'header' => 'Card No.',
            'filter'=>CHtml::activeTextField($model, 'cardnumber', array('placeholder'=>'Card No.')),
            'value'=>  'CardGenerated::model()->getCardCode($data->card)',
            'htmlOptions'=>array('width'=>'120px'),
        ),
        array(
            'name' => 'firstname',
            'filter'=>CHtml::activeTextField($model, 'firstname', array('placeholder'=>'First Name')),
            'value' => '$data->visitor0->first_name',
            'header' => 'First Name',
            'htmlOptions'=>array('width'=>'120px'),
        ),
        array(
            'name' => 'lastname',
            'filter'=>CHtml::activeTextField($model, 'lastname', array('placeholder'=>'Last Name')),
            'value' => '$data->visitor0->last_name',
            'header' => 'Last Name',
            'htmlOptions'=>array('width'=>'120px')
        ),
        array(
            'name' => 'company',
            'filter'=>CHtml::activeTextField($model, 'company', array('placeholder'=>'Company')),
            'value' => '$data->company0->name',
            'htmlOptions'=>array('width'=>'120px')
        ),
        array(
            'name' => 'date_check_in',
            'filter'=>CHtml::activeTextField($model, 'date_check_in', array('placeholder'=>'Check In Date')),
            'type' => 'html',
            'htmlOptions'=>array('width'=>'100px'),
            'value' => 'formatDate($data->date_check_in, $data->visit_status)',
        ),
        array(
            'name' => 'time_check_in',
            'type' => 'html',
            'value' => 'formatTime($data->time_check_in)',
            'filter'=>CHtml::activeTextField($model, 'time_check_in', array('placeholder'=>'Check In Time')),
            'htmlOptions'=>array('width'=>'100px'),
        ),
        array(
            'name' => 'date_check_out',
            'type' => 'html',
            'filter'=>CHtml::activeTextField($model, 'date_check_out', array('placeholder'=>'Check Out Date')),
            'htmlOptions'=>array('width'=>'110px'),
            'value' => 'formatDate($data->date_check_out, $data->visit_status)',
        ),
        array(
            'name' => 'time_check_out',
            'type' => 'html',
            'value' => 'formatTime($data->time_check_out)',
            'filter'=>CHtml::activeTextField($model, 'time_check_out', array('placeholder'=>'Check Out Time')),
            'htmlOptions'=>array('width'=>'110px'),
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

        $company = $companyModel->findByPk($company_id, "is_deleted >= 0 " );

        if(isset($company))
        {
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
    if ($date == '' || $visitStatus != 1) {
        return "-";
    } else {
        return Yii::app()->dateFormatter->format("d/MM/y", strtotime($date));
    }
}

function changeStatusClass($visitStatus){
   // return "red";
   switch ($visitStatus) {
       case VisitStatus::ACTIVE:
           return "green";
           break;
       
       case VisitStatus::PREREGISTERED:
           return "blue";
           break;
       
       case VisitStatus::CLOSED:
           return "red";
           break;
       
       case VisitStatus::SAVED:
           return "grey";
           break;

       default:
           break;
   }
}
?>
