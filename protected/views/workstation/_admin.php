
<?php
/* @var $this WorkstationController */
/* @var $model Workstation */
?>
<style>
    .edit_card_back {
        margin: 0 8px !important;
        text-transform: capitalize;    
    }
</style>
<h1>Workstations</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'workstation-grid',
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    //'hideHeader'=>true,
    //'filter' => $model,
    'ajaxUpdate' => false,
    'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
    'columns' => array(
        array(
            'name' => 'name',
            'header' => 'Workstation',
            'htmlOptions' => array('width' => '180px'),
        ),
        array(
            'name' => 'moduleCorporate',
            'header' => '',
            'type' => 'raw',
            'value' => '$data->getCorporateCardType($data->id)',
            /* 'htmlOptions'=>array('width'=>'300px' , 'height'=>'119px'), */
            'headerHtmlOptions' => array('class' => 'header-corporate')
        ),
        array(
            'name' => 'moduleVic',
            'type' => 'raw',
            'header' => '',
            'value' => '$data->getCorporateVic($data->id)',
            /* 'htmlOptions'=>array('width'=>'400px' , 'height'=>'119px'), */
            'headerHtmlOptions' => array('class' => 'header-vic')
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
<div class="modal fade" id="form_modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">	
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <?php echo CHtml::beginForm((CController::createAbsoluteUrl("cardType/edit")), 'post'); ?>
            <div class="modal-body">


                <div class="form-group">
                    <?php echo CHtml::label("Back-Card", 'text'); ?>
                    <?php echo CHtml::textArea('back-card','',array( 'rows'=>"9", 'cols'=>"500",'style'=>"width:500px;")); ?>
                    <?php echo CHtml::hiddenField('card_id'); ?>   
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        <?php echo CHtml::endForm(); ?>
    </div>
</div>
</div>

<script>

    $(document).ready(function () {
        generateRow();
        $(".edit_card_back").click(function () {
            var button_id = ($(this).attr('id'));
            var modal_name = $('#' + button_id).attr('name');
            var card_id = button_id.split('_');
            getEditText(card_id[1]);
            $("#myModalLabel").html(modal_name);
            $("#card_id").val(card_id[1]);
            $('#form_modal_edit').modal('show');
        });
    });

    function generateRow() {
        var row = "<?php echo $this->renderPartial('_extra_row', array(), true); ?>";
        $(".items tr:first").after(row);
    }
    function getEditText(cardid) {
       
        $.ajax({
            url: '<?php echo CController::createAbsoluteUrl('cardtype/backtext')?>',
            data: "cardid="+cardid,
            success: function (data) {
                $('#back-card').val(data);
            },
            type: 'POST'
        });
    }

</script>
