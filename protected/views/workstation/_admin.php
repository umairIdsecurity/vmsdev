
<?php
/* @var $this WorkstationController */
/* @var $model Workstation */
?>
<style>
    .corporate {
        margin: 0 2px !important;
        text-transform: capitalize;    
    }
    .vc {
        margin: 0 2px !important;
        text-transform: capitalize;    
    }
</style>
<?php if(Yii::app()->user->hasFlash('error')):?>
    <div class="alert alert-danger" style="margin-top: 10px;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Warning!</strong> <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>
<h1>Workstations</h1>

<?php
$module = CHelper::get_allowed_module();


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
            'htmlOptions' => array('width' => '180px', 'class' => 'ws-padding'),
        ),

        array(
            'name' => 'moduleCorporate',
            'header' => '',
            'type' => 'raw',
            'value' => '$data->getCorporateCardType($data->id)',
            // 'htmlOptions'=>array('width'=>'300px' , 'height'=>'119px'), 
            'headerHtmlOptions' => array('class' => 'header-corporate'),
            'visible'=> ( $module == "CVMS" || $module == "Both"),
        ),
        array(
            'name' => 'moduleVic',
            'type' => 'raw',
            'header' => '',
            'value' => '$data->getCorporateVic($data->id)',
            // 'htmlOptions'=>array('width'=>'400px' , 'height'=>'119px'), 
            'headerHtmlOptions' => array('class' => 'header-vic'),
            'visible'=> ( $module == "AVMS" || $module == "Both"),
        ),
        Yii::app()->user->role == Roles::ROLE_SUPERADMIN?
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
        ):array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'template' => '{update}',
            'buttons' => array(
                'update' => array(//the name {reply} must be same
                    'label' => 'Edit', // text label of the button
                    'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                ),
            ),
        ),
    ),
));

function isWorkstationExists($workstationId) {
    return UserWorkstations::model()->exists("workstation=" . $workstationId . "");
}

function isVisitExistsInClosedVisits($workstationId) {
    return Visit::model()->exists("workstation=" . $workstationId . "");
}

$ajaxUrlCardType = Yii::app()->createUrl('workstation/ajaxWorkstationCardtype');

$ajaxUrlTenantDefaultCardType = Yii::app()->createUrl('company/ajaxTenantDefaultCardtype');

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


Yii::app()->clientScript->registerScript('select_pre_card_type_vic', "
    $('.pre_card_type_vic').click( function(){
        var card_type_id = $(this).attr('value');
        var data = {card_type_id: card_type_id};
        $.ajax({
            type: 'POST',
            url: '$ajaxUrlTenantDefaultCardType',
            data: data,
            success: function (data) {
                    
            }
        });

    });
");

$tenant = Company::model()->findByPK(Yii::app()->user->tenant); 

?>


<table>
    <tr>
        <td style="width:658px;">Select Preregistration Default Card Type</td>
        <td style="">
            <input type="radio" id="pre_Same_Day" name="pre_card_type" class="pre_card_type_vic" value="<?php echo CardType::VIC_CARD_SAMEDATE; ?>" <?php echo ($tenant->tenant_default_card_type == CardType::VIC_CARD_SAMEDATE) ? "checked": "";  ?> />
        </td>
        <td style="">
            <input type="radio" id="pre_24_Hour" name="pre_card_type" class="pre_card_type_vic" value="<?php echo CardType::VIC_CARD_24HOURS; ?>" <?php echo ($tenant->tenant_default_card_type == CardType::VIC_CARD_24HOURS) ? "checked": "";  ?> />
        </td>
        <td style="">    
            <input type="radio" id="pre_Extended" name="pre_card_type" class="pre_card_type_vic" value="<?php echo CardType::VIC_CARD_EXTENDED; ?>" <?php echo ($tenant->tenant_default_card_type == CardType::VIC_CARD_EXTENDED) ? "checked": "";  ?> />
        </td>
        <td style="">   
            <input type="radio" id="pre_Multi_Day" name="pre_card_type" class="pre_card_type_vic" value="<?php echo CardType::VIC_CARD_MULTIDAY; ?>" <?php echo ($tenant->tenant_default_card_type == CardType::VIC_CARD_MULTIDAY) ? "checked": "";  ?> />
        </td>
        <td style="">  
            <input type="radio" id="pre_Manual" name="pre_card_type" class="pre_card_type_vic" value="<?php echo CardType::VIC_CARD_MANUAL; ?>" <?php echo ($tenant->tenant_default_card_type == CardType::VIC_CARD_MANUAL) ? "checked": "";  ?> />
        </td>
    </tr>
</table>

<div class="modal fade" id="form_modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none">
    <div class="modal-dialog">
        <div class="modal-content">	
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="mdlttl">Modal title</h4>
            </div>
            <?php echo CHtml::beginForm((CController::createAbsoluteUrl("cardType/edit")), 'post'); ?>
            <div class="modal-body">
                <div class="form-group">
                    <?php echo CHtml::textArea('back-card', '', array('rows' => "9", 'cols' => "500", 'style' => "width:500px;")); ?>
                    <?php echo CHtml::hiddenField('card_id'); ?>
                </div>
                <div style="  width: 100%;text-align: right;;color: #446FB6;" id="counter"></div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default neutral" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary complete">Save changes</button>
        </div>
        <?php echo CHtml::endForm(); ?>
    </div>
</div>
</div>

<script type="text/javascript">

    $(document).ready(function () {
        generateRow();
        $(".edit_card_back").click(function () {
            var button_id = ($(this).attr('id'));
            var modal_name = $('#' + button_id).attr('name');
            var card_id = button_id.split('_');
            getEditText(card_id[1]);
            modal_name = modal_name + "-Back of Card";
            $("#mdlttl").html(modal_name);
            $("#card_id").val(card_id[1]);
            $('#form_modal_edit').modal('show');
        });

        $(".delete").click(function(e) {
            e.preventDefault();

            var selected = $(this);

            $.ajax({
                url: $(selected).attr("href"),
                data: { type: "check" },
                type: 'POST',
                dataType: "json",
                success: function (data) {
                    if (data.visit > 0) {
                    	alert("This workstation has preregistered or active visits. Please close or cancel the visits before deleting workstation.");
                    } else {
                    	var ret = confirm("Are you sure you want to delete this item?");
                    }
                    if (ret) {
                    	$.ajax({
                            url: $(selected).attr("href"),
                            data: { type: "delete" },
                            type: 'POST',
                            dataType: "json",
                            success: function (data) {
                                if (data.status == 1) {
                                	window.location.reload();
                                }
                            }
                        });
                    }
                }
            });

            return false;
        });

    });

    function generateRow() {
        var row = "<?php echo $this->renderPartial('_extra_row', array(), true); ?>";
        $(".items tr:first").after(row);
    }
    function getEditText(cardid) {

        $.ajax({
            url: '<?php echo CController::createAbsoluteUrl('cardType/backtext') ?>',
            data: "cardid=" + cardid,
            success: function (data) {
                $('#back-card').val(data);
            },
            type: 'POST'
        });
    }
    $("#back-card").MaxLength(
            {
                MaxLength: 400,
                CharacterCountControl: $('#counter')
            });

</script>
