<?php
$session = new CHttpSession;
/* @var $this VisitController */
/* @var $model Visit */
$session = new CHttpSession();
if ($session['role'] == Roles::ROLE_AGENT_OPERATOR || $session['role'] == Roles::ROLE_OPERATOR) {
    echo "<h1>" . Workstation::model()->findByPk($session['workstation'])->name . "</h1>";
} else {
    echo "<h1>Dashboard</h1>";
}

$merge = new CDbCriteria;
$merge->addCondition('visit_status ="' . VisitStatus::ACTIVE . '" or visit_status ="' . VisitStatus::PREREGISTERED . '"');

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'visit-gridDashboard',
    'dataProvider' => $model->search($merge),
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
            'filter' => VisitStatus::$VISIT_STATUS_DASHBOARD_FILTER,
            'cssClassExpression' => 'changeStatusClass($data->visit_status)',
            'htmlOptions'=>array('width'=>'40px'),
        ),
        //'date_in',
        array(
            'name' => 'cardnumber',
            'header' => 'Card No.',
            'filter'=>CHtml::activeTextField($model, 'cardnumber', array('placeholder'=>'Card No.')),
            'value'=>  'CardGenerated::model()->getCardCode($data->card)',
            'htmlOptions'=>array('width'=>'90px'),
        ),
        array(
            'name' => 'firstname',
            'filter'=>CHtml::activeTextField($model, 'firstname', array('placeholder'=>'First Name')),
            'value' => 'Visitor::model()->findByPk($data->visitor)->first_name',
            'header' => 'First Name',
            'htmlOptions'=>array('width'=>'120px'),
        ),
        array(
            'name' => 'lastname',
            'filter'=>CHtml::activeTextField($model, 'lastname', array('placeholder'=>'Last Name')),
            'value' => 'Visitor::model()->findByPk($data->visitor)->last_name',
            'header' => 'Last Name',
            'htmlOptions'=>array('width'=>'120px'),
        ),
        array(
            'name' => 'company',
            'filter'=>CHtml::activeTextField($model, 'company', array('placeholder'=>'Company')),
            'value' => 'getCompany($data->visitor)',
            'header' => 'Company',
            'cssClassExpression' => '( getCompany($data->visitor)== "Not Available" ? "errorNotAvailable" : "" ) ',
            'type' => 'raw',
            'htmlOptions'=>array('width'=>'120px'),
        ),
        array(
            'name' => 'contactnumber',
            'filter'=>CHtml::activeTextField($model, 'contactnumber', array('placeholder'=>'Contact Number')),
            'value' => 'Visitor::model()->findByPk($data->visitor)->contact_number',
            'header' => 'Contact Number',
            'htmlOptions'=>array('width'=>'120px'),
        ),
        array(
            'name' => 'contactemail',
            'filter'=>CHtml::activeTextField($model, 'contactemail', array('placeholder'=>'Contact Email')),
            'value' => 'Visitor::model()->findByPk($data->visitor)->email',
            'header' => 'Contact Email',
            'htmlOptions'=>array('width'=>'100px'),
        ),
        array(
            'name' => 'date_check_in',
            'filter'=>CHtml::activeTextField($model, 'date_check_in', array('placeholder'=>'Check In Date')),
            'type' => 'html',
            'htmlOptions'=>array('width'=>'90px'),
        //'value' => 'formatDate($data->date_in)',
        ),
        array(
            'name' => 'time_check_in',
            'filter'=>CHtml::activeTextField($model, 'time_check_in', array('placeholder'=>'Check In Time')),
            'type' => 'html',
            'value' => 'formatTime($data->time_check_in)',
            'htmlOptions'=>array('width'=>'90px'),
        ),
        array(
            'name' => 'date_check_out',
            'filter'=>CHtml::activeTextField($model, 'date_check_out', array('placeholder'=>'Check Out Date')),
            'type' => 'html',
            'htmlOptions'=>array('width'=>'90px'),
        //'value' => 'formatDate($data->date_out)',
        ),
    ),
));

function getVisitorFullName($id) {
    $visitor = Visitor::model()->findByPk($id);

    return $visitor->first_name . ' ' . $visitor->last_name;
}

function getCompany($id) {
    if (Visitor::model()->findByPk($id)->company == NULL) {
        return "Not Available";
    } else {
        return Company::model()->findByPk(Visitor::model()->findByPk($id)->company)->name;
    }
}

function formatTime($time) {
    if ($time == '' || $time == '00:00:00') {
        return "-";
    } else {
        return date('h:i A', strtotime($time));
    }
}


function changeStatusClass($visitStatus) {
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
