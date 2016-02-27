<?php
/* @var $this VisitController */
/* @var $model Visit */
?>

<h1>EVIC Deposits Record</h1>

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
            'name' => 'email',
            'filter' => CHtml::activeTextField($model, 'email', array('placeholder' => 'Email')),
            'value' => '$data->visitor0->email',
            'htmlOptions' => array('width' => '120px'),
        ),
         array(
            'name' => 'company',
            'filter' => CHtml::activeTextField($model, 'company', array('placeholder' => 'Company')),
            'value' => '$data->company0->name',
            'header' => 'Company',
            'htmlOptions' => array('width' => '140px'),
        ),
        array(
            'name' => 'date_check_in',
            'htmlOptions' => array('width' => '150px'),
            'filter' => CHtml::activeTextField($model, 'date_check_in', array('placeholder' => 'Check In')),
        ),
     
        array(
            'name' => 'date_check_out',
            'htmlOptions' => array('width' => '150px'),
            'filter' => CHtml::activeTextField($model, 'date_check_out', array('placeholder' => 'Check Out')),
        ),
           array(
            'name' => 'deposit_paid',
            'header' => 'Deposit Paid',
             'value' => '"Yes"',
               'filter' => 'Deposit Paid',
               
        ),
   
          array(
            'name' => 'card_option',
            'filter' => CHtml::activeTextField($model, 'card_option', array('placeholder' => 'Card Option')),
            'htmlOptions' => array('width' => '120px'),
            'value'=>'$data->visit_status ==  VisitStatus::EXPIRED ? "Not Returned": $data->card_option'  
        ),
        
          array(
            'name' => 'visit_status',
            'filter' => false,
            'value' => 'CHtml::link(VisitStatus::$VISIT_STATUS_LIST[$data->visit_status],Yii::app()->createUrl("visit/detail",array("id"=>$data->id)),array("class" =>"statusLink"))',
            'type' => 'raw',
            'header' => 'Status',
            'filter'             => VisitStatus::$VISIT_STATUS_LIST,
            'cssClassExpression' => 'CHelper::changeStatusColor($data->visit_status)',
            'htmlOptions' => array('width' => '110px'),
        ),
    ),
));
?>
