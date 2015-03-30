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
        ),
        //'date_in',
        array(
            'name' => 'cardnumber',
            'header' => 'Card No.',
            'value'=>  'CardGenerated::model()->getCardCode($data->card)',
        ),
        array(
            'name' => 'firstname',
            'value' => 'Visitor::model()->findByPk($data->visitor)->first_name',
            'header' => 'First Name',
        ),
        array(
            'name' => 'lastname',
            'value' => 'Visitor::model()->findByPk($data->visitor)->last_name',
            'header' => 'Last Name'
        ),
        array(
            'name' => 'company',
            'value' => 'getCompany($data->visitor)',
            'header' => 'Company',
            'cssClassExpression' => '( getCompany($data->visitor)== "Not Available" ? "errorNotAvailable" : "" ) ',
            'type' => 'raw'
        ),
        array(
            'name' => 'contactnumber',
            'value' => 'Visitor::model()->findByPk($data->visitor)->contact_number',
            'header' => 'Contact Number'
        ),
        array(
            'name' => 'contactemail',
            'value' => 'Visitor::model()->findByPk($data->visitor)->email',
            'header' => 'Contact Email'
        ),
        array(
            'name' => 'date_check_in',
            'type' => 'html',
        //'value' => 'formatDate($data->date_in)',
        ),
        array(
            'name' => 'time_check_in',
            'type' => 'html',
            'value' => 'formatTime($data->time_check_in)',
        ),
        array(
            'name' => 'date_check_out',
            'type' => 'html',
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
