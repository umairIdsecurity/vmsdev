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
            'header' => 'Company',
            'filter' => false,
            'value' => 'isset($data->getCompany()->name) ? $data->getCompany()->name : "NO COMPANY"',
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
<input id="btnBackSearchAsicEscort" class="AsicEscort-backBtn " type="button" onclick="javascript:backFillAsicEscort();return false;" value="Back">
<?php
function displaySelectVisitorButton($visitorData) {
    return CHtml::link("Select", "javascript:void(0)", array(
            "id" => $visitorData["id"],
            "style" => "text-align:center!important",
            "onclick" => "selectEscort({$visitorData['id']})",
        )
    );
}
?>
<script>
    function selectEscort(id) {
        $('.searchAsicEscortResult a').removeClass('delete');
        $('.searchAsicEscortResult a').html('Select');
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
