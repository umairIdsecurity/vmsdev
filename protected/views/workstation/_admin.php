
<?php
/* @var $this WorkstationController */
/* @var $model Workstation */
?>

<h1>Workstations</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'workstation-grid',
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    //'hideHeader'=>true,
    //'filter' => $model,
    'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
    'columns' => array(
        array(
            'name' => 'name',
            'header' => 'Workstation',
            'htmlOptions'=>array('width'=>'180px'),
        ),

        array(
            'name' => 'moduleCorporate',
            'header' => '',
            'type'=>'raw',
            'value' => '$data->getCorporateCardType($data->id)',
            /*'htmlOptions'=>array('width'=>'300px' , 'height'=>'119px'),*/
            'headerHtmlOptions' => array('class'=>'header-corporate')
        ),

        array(
            'name' => 'moduleVic',
            'type'=>'raw',
            'header' => '',
            'value' => '$data->getCorporateVic($data->id)',
            /*'htmlOptions'=>array('width'=>'400px' , 'height'=>'119px'),*/
            'headerHtmlOptions' => array('class'=>'header-vic')
        ),

        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}',
            'buttons' => array(
                'update' => array(//the name {reply} must be same
                    'label' => 'Edit', // text label of the button
                    'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                ),
                'delete' => array(//the name {reply} must be same
                    'label' => 'Delete', // text label of the button
                    'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                    'visible' => '(($data->id)!= 1)',

                ),
            ),
        ),
    ),
));

function isWorkstationExists($workstationId) {
    return UserWorkstations::model()->exists('workstation="' . $workstationId . '"');
}

function isVisitExistsInClosedVisits($workstationId) {
    return Visit::model()->exists('workstation="' . $workstationId . '"');
}

$ajaxUrlCardType = Yii::app()->createUrl('workstation/ajaxWorkstationCardtype');
Yii::app()->clientScript->registerScript('select_card_type_corporate', "

    $('.card_type_corporate').click( function(){

        var card_type_id = $(this).attr('value');
        var workstation_id = $(this).attr('data-workstation');

        var data = {card_type_id: card_type_id, workstation_id: workstation_id};

        $.ajax({
            type: 'POST',
            url: '$ajaxUrlCardType',
            data: data,
        })

    })
");


Yii::app()->clientScript->registerScript('select_card_type_vic', "

    $('.card_type_vic').click( function(){

        var card_type_id = $(this).attr('value');
        var workstation_id = $(this).attr('data-workstation');

        var data = {card_type_id: card_type_id, workstation_id: workstation_id};

        $.ajax({
            type: 'POST',
            url: '$ajaxUrlCardType',
            data: data,
        })

    })
");

?>
