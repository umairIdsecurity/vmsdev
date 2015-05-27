<style>
    .visit-selected-header input {
        display: none;
    }
</style>

<?php
$this->widget('zii.widgets.grid.CGridView', array(

    'id' => 'active-visit',
    'dataProvider' => $dataProvider,
    'enableSorting' => false,
    'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
    'columns' => array(

        array(
            'header' => 'ID',
            'value' => '$data->id',
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 2,
            'htmlOptions' => array('style'=>'width:5px; min-width: 0px !important;', 'class'=>'visit-selected'),
            'headerHtmlOptions' =>  array('style'=>'width:5px; min-width: 0px !important;', 'class'=>'visit-selected-header'),
        ),
        array(
            'name' => 'card',
            'htmlOptions' => array('style'=>'width:10px; min-width: 0px !important;'),
            'headerHtmlOptions' =>  array('style'=>'width:10px; min-width: 0px !important;'),
        ),
        array(
            'name' => 'date_in',
            'htmlOptions' => array('style'=>'width:15px; min-width: 0px !important;'),
            'headerHtmlOptions' =>  array('style'=>'width:15px; min-width: 0px !important;'),
        ),
        array(
            'name' =>  'time_in_minutes',
            'htmlOptions' => array('style'=>'width:10px; min-width: 0px !important;'),
            'headerHtmlOptions' =>  array('style'=>'width:10px; min-width: 0px !important;'),
        ),
        array(
            'name' => 'host',
            'htmlOptions' => array('style'=>'width:10px; min-width: 0px !important;'),
            'headerHtmlOptions' =>  array('style'=>'width:10px; min-width: 0px !important;'),
        ),
        array(
            'name' => 'time_out',
            'htmlOptions' => array('style'=>'width:15px; min-width: 0px !important;'),
            'headerHtmlOptions' =>  array('style'=>'width:15px; min-width: 0px !important;'),
        ),
        array(
            'name' =>   'date_out',
            'htmlOptions' => array('style'=>'width:15px; min-width: 0px !important;'),
            'headerHtmlOptions' =>  array('style'=>'width:15px; min-width: 0px !important;'),
        ),
        array(
            'name' => 'visit_status',
            'htmlOptions' => array('style'=>'width:15px; min-width: 0px !important;'),
            'headerHtmlOptions' =>  array('style'=>'width:15px; min-width: 0px !important;'),
        ),

    )
));
?>
<script>
    $(document).ready(function() {
        $('.visit-selected').click(function(e) {
            document.getElementById('negate_reason').style.display="block";

        });

    });
</script>