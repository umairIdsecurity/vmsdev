<style>
    .visit-selected-header input {
        display: none;
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
            'htmlOptions' => array('style'=>'width:10px; min-width: 0px !important;'),
            'headerHtmlOptions' =>  array('style'=>'width:10px; min-width: 0px !important;'),
        ),
        array(
            'name' => 'last_name',
            'filter' => false,
            'htmlOptions' => array('style'=>'width:10px; min-width: 0px !important;'),
            'headerHtmlOptions' =>  array('style'=>'width:10px; min-width: 0px !important;'),
        ),
        array(
            'header' => 'Company',
            'filter' => false,
            'value' => 'isset($data->getCompany()->name) ? $data->getCompany()->name : "NO COMPANY"',
            'htmlOptions' => array('style'=>'width:10px; min-width: 0px !important;'),
            'headerHtmlOptions' =>  array('style'=>'width:10px; min-width: 0px !important;'),
        ),
        array(
            'header' => 'Action',
            'name' => 'Select',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center width:10px; min-width: 0px !important;', 'class' => 'findVisitorButtonColumn'),
            'headerHtmlOptions' =>  array('style'=>'width:10px; min-width: 0px !important;'),
            'value' => 'displaySelectVisitorButton($data)',
        ),
    )
));

function displaySelectVisitorButton($visitorData) {
    return CHtml::link("Select", "javascript:void(0)", array(
            "id" => $visitorData["id"],
            "onclick" => "selectEscort({$visitorData['id']})",
        )
    );
}
?>
<script>
    function selectEscort(id) {
        console.log(id);
    }
</script>
