<?php
/* @var $this VisitController */
/* @var $model Visit */
?>

<h1>Evacuation Report</h1>
<div style="text-align:left;"><input type="button" class="greenBtn" value="Export to CSV" id="export"/></div>
<br>
<?php
$session = new CHttpSession;
$merge = new CDbCriteria;
$merge->addCondition('visit_status ="' . VisitStatus::ACTIVE . '"');

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'view-visitor-records',
    'dataProvider' => $model->search($merge),
    'filter' => $model,
    
    'columns' =>
    array(
        array(
            'name' => 'visit_status',
            'filter' => false,
            'value' => 'CHtml::link(VisitStatus::$VISIT_STATUS_LIST[$data->visit_status],Yii::app()->createUrl("visit/detail",array("id"=>$data->id)),array("class" =>"statusLink"))',
            'type' => 'raw',
            'header' => 'Status',
            'filter' => VisitStatus::$VISIT_STATUS_LIST,
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
        array(
            'name' => 'date_in',
            'type' => 'html',
            'value' => 'formatDate($data->date_in)',
        ),
        array(
            'name' => 'time_in',
            'type' => 'html',
            'value' => 'formatTime($data->time_in)',
        ),
        array(
            'name' => 'date_out',
            'type' => 'html',
            'value' => 'formatDate($data->date_out)',
        ),
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

function formatDate($date) {
    if ($date == '') {
        return "-";
    } else {
        return Yii::app()->dateFormatter->format("d/MM/y", strtotime($date));
    }
}
?>
<script>
    $(document).ready(function() {
        $('#export-button').on('click', function() {
            $.fn.yiiGridView.export();
        });
        $.fn.yiiGridView.export = function() {
            $.fn.yiiGridView.update('view-visitor-records', {
                success: function() {
                    $('#view-visitor-records').removeClass('grid-view-loading');
                    window.location = '". $this->createUrl('exportFile')  . "';
                },
                data: $('.search-form form').serialize() + '&export=true'
            });
        }
    });
</script>