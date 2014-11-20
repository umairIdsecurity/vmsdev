<?php
/* @var $this VisitController */
/* @var $model Visit */
?>
<h1>Visitor Records</h1>
<br>
<?php
$session = new CHttpSession;

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'view-visitor-records',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' =>
    array(
        array(
            'filter' => false,
            'value' => 'CHtml::link("View",Yii::app()->createUrl("visit/detail",array("id"=>$data->id)),array("class" =>"statusLink black"))',
            'type' => 'raw',
            'header' => '',
        ),
        array(
            'name' => 'visit_status',
            'filter' => false,
            'value' => 'CHtml::link(VisitStatus::$VISIT_STATUS_LIST[$data->visit_status],Yii::app()->createUrl("visit/detail",array("id"=>$data->id)),array("class" =>"statusLink"))',
            'type' => 'raw',
            'header' => 'Status',
        ),
        array(
            'name' => 'visitor_type',
            'value' => 'VisitorType::$VISITOR_TYPE_LIST[$data->visitor_type]',
            'filter' => VisitorType::$VISITOR_TYPE_LIST,
        ),
        array(
            'name' => 'card',
            'header' => 'Card No.'
        ),
        array(
            'name' => 'firstname',
            'value' => 'Visitor::model()->findByPk($data->visitor)->first_name',
            'header' => 'First Name'
        ),
        array(
            'name' => 'lastname',
            'value' => 'Visitor::model()->findByPk($data->visitor)->last_name',
            'header' => 'Last Name'
        ),
        array(
            'name' => 'company',
            'value' => 'getCompany($data->visitor)',
            'header' => 'Company Name',
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
        'date_in',
        array(
            'name' => 'time_in',
            'type' => 'html',
            'value' => 'formatTime($data->time_in)',
        ),
        'date_out',
        array(
            'name' => 'time_out',
            'type' => 'html',
            'value' => 'formatTime($data->time_out)',
        ),
        'card0.date_expiration',
    ),
));

function getCompany($id) {
    if (Visitor::model()->findByPk($id)->company == NULL) {
        return "Not Available";
    } else {
        return Company::model()->findByPk(Visitor::model()->findByPk($id)->company)->name;
    }
}

function formatTime($time) {
    if ($time == '') {
        return "-";
    } else {
        return date('h:i A', strtotime($time));
    }
}
?>
