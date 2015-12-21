<?php
/* @var $this VisitController */
/* @var $model Visit */
?>

<h1>Lost VICs Report</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'vic-total-visit-count',
    'dataProvider' => $model->search($criteria),
    'enableSorting' => true,
    //'ajaxUpdate'=>true,
    'hideHeader' => true,
    'filter' => $model,
    'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
    'columns' => array(
        array(
            'name' => 'visit_status',
            'filter' => false,
            'value' => 'CHtml::link(VisitStatus::$VISIT_STATUS_LIST[$data->visit_status],Yii::app()->createUrl("visit/detail",array("id"=>$data->id)),array("class" =>"statusLink"))',
            'type' => 'raw',
            'header' => 'Status',
            'filter'             => VisitStatus::$VISIT_STATUS_LIST,
            'cssClassExpression' => 'CHelper::changeStatusColor($data->visit_status)',
            'htmlOptions' => array('width' => '120px'),
        ),
        array('name' => 'cardnumber',
            'header' => 'Card No.',
            'filter' => CHtml::activeTextField($model, 'cardnumber', array('placeholder' => 'Card No.')),
            'value' => 'CardGenerated::model()->getCardCode($data->card)',
            'htmlOptions' => array('width' => '120px'),
        ),
        array(
            'name' => 'firstname',
            'filter' => CHtml::activeTextField($model, 'firstname', array('placeholder' => 'First Name')),
            'value' => '!empty($data->visitor0->first_name) ? $data->visitor0->first_name : ""',
            'header' => 'First Name',
            'htmlOptions' => array('width' => '120px'),
        ),
        array(
            'name' => 'lastname',
            'filter' => CHtml::activeTextField($model, 'lastname', array('placeholder' => 'Last Name')),
            'value' => '!empty($data->visitor0->last_name) ? $data->visitor0->last_name : ""',
            'header' => 'Last Name',
            'htmlOptions' => array('width' => '120px'),
        ),
        array(
            'name' => 'date_check_in',
            'htmlOptions' => array('width' => '150px'),
            'filter' => CHtml::activeTextField($model, 'date_check_in', array('placeholder' => 'Check In')),
        ),
        array(
            'name' => 'time_check_in',
            'type' => 'html',
            'value' => 'formatTime($data->time_check_in)',
            'filter' => CHtml::activeTextField($model, 'time_check_in', array('placeholder' => 'Time In')),
            'htmlOptions' => array('width' => '100px'),
        ),
        array(
            'name' => 'date_check_out',
            'htmlOptions' => array('width' => '150px'),
            'filter' => CHtml::activeTextField($model, 'date_check_out', array('placeholder' => 'Finish')),
        ),
        array(
            'name' => 'time_check_out',
            'type' => 'html',
            'value' => 'formatTime($data->time_check_out)',
            'filter' => CHtml::activeTextField($model, 'time_check_out', array('placeholder' => 'Time Out')),
            'htmlOptions' => array('width' => '110px'),
        ),
        array(
            'name' => 'police_report_number',
            'filter' => CHtml::activeTextField($model, 'police_report_number', array('placeholder' => 'Report No')),
            'htmlOptions' => array('width' => '110px'),
        ),
        array(
             
            'type' => 'raw',
            'value' => '!is_null($data->card_lost_declaration_file)?CHtml::link("Download", Yii::app()->request->baseUrl.$data->card_lost_declaration_file, array("class" =>"statusLink")):""',
            'htmlOptions' => array('width' => '60px'),
            
        ),
    ),
));

//because of cavms-1135
function formatTime($time) {
    if ($time == '' || $time == '00:00:00') {
        return "-";
    } else {
        return date('h:i A', strtotime($time));
    }
}

?>
