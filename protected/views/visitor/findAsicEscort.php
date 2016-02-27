<?php
if(Yii::app()->controller->id == 'visitor' && Yii::app()->controller->action->id == 'getAsicEscort'){
    Yii::app()->clientScript->scriptMap['jquery.js']=false;
}
?>
<style>
    .visit-selected-header input {
        display: none;
    }
    .AsicEscort-backBtn{
        background: rgba(0, 0, 0, 0) -moz-linear-gradient(center top , #cccccc, #999999) repeat scroll 0 0 !important;
        border: 1px solid #999999 !important;
        width: 80px!important;
        float: right;
        border-radius: 5px;
        color: #ffffff;
        cursor: pointer;
        font-size: 12px;
        font-weight: bold;
        padding: 3px 15px 5px;
    }
</style>
<?php
$this->widget('zii.widgets.grid.CGridView', array(

    'id' => 'asic-escort-visitor',
    'dataProvider' => $model->search($merge),
    'enableSorting' => false,
    'summaryText' => '',
    'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
    'columns' => array(
        array(
            'header' => '',
            'type' => 'raw',
            'value' => '$data->getVisitorProfileIcon()',
            'htmlOptions' => array('style'=>'width:5px; min-width: 0px !important;', 'class'=>'visit-selected'),
            'headerHtmlOptions' =>  array('style'=>'width:5px; min-width: 0px !important;', 'class'=>'visit-selected-header'),
        ),
        array(
            'name' => 'first_name',
            'filter' => false,
            'htmlOptions' => array('style'=>'width:7px !important; min-width: 0px !important;'),
            'headerHtmlOptions' =>  array('style'=>'width:7px !important; min-width: 0px !important;'),
        ),
        array(
            'name' => 'last_name',
            'filter' => false,
            'htmlOptions' => array('style'=>'width:7px; min-width: 0px !important;'),
            'headerHtmlOptions' =>  array('style'=>'width:7px; min-width: 0px !important;'),
        ),
        array(
            'name' => 'email',
            'filter' => false,
            'htmlOptions' => array('style'=>'width:7px; min-width: 0px !important;'),
            'headerHtmlOptions' =>  array('style'=>'width:7px; min-width: 0px !important;'),
        ),
        array(
            'header' => 'ASIC Type',
            'filter' => false,
            'value' => 'getVisitorType($data->id)',
            'htmlOptions' => array('style'=>'width:7px; min-width: 0px !important;'),
            'headerHtmlOptions' =>  array('style'=>'width:7px; min-width: 0px !important;'),
        ),
        array(
            'header' => 'Action',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right!important width:20px; min-width: 0px !important;', 'class' => 'findVisitorButtonColumn'),
            'headerHtmlOptions' =>  array('style'=>'width:20px; min-width: 0px !important;'),
            'value' => 'displaySelectVisitorButton($data)',
        ),
    )
));
?>
<input id="btnBackSearchAsicEscort" class="AsicEscort-backBtn neutral" type="button" onclick="javascript:backFillAsicEscort();return false;" value="Back" style="width: auto !important; height: auto !important;">
<?php
function displaySelectVisitorButton($visitorData) {
    return CHtml::link("Select", "javascript:void(0)", array(
            "id" => $visitorData["id"],
            "class" => "actionForward",
            "style" => "text-align:center!important",
            "onclick" => "selectEscort({$visitorData['id']})",
        )
    );
}

function getVisitorType($id)
{
    $visitor = Visitor::model()->findByPk($id);

    if ($visitor->profile_type == 'VIC') {
        return 'VIC';
    } elseif ($visitor->profile_type == 'ASIC' && $visitor->escort_flag == 1) {
        return 'ASIC Escort';
    } else {
        return 'ASIC Sponsor';
    }
}
?>
<script>
    function selectEscort(id) {
        $('.searchAsicEscortResult td a').removeClass('delete');
        $('.searchAsicEscortResult td a').html('Select');
        $('#' + id).addClass('delete');
        $('#' + id).html('ASIC Escort Selected');
        $('#selectedAsicEscort').val(id);
    }
    function backFillAsicEscort() {
        $('.searchAsicEscortResult').empty();
        $('#search-escort').val('');
        $('#selectedAsicEscort').val('');
        $('.searchAsicEscortResult').hide();
        $('.add-esic-escort').show();
    }
</script>
