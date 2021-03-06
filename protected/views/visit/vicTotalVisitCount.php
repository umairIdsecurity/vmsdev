<style>
    .header-form {
        min-width: 70px !important;
    }
</style>
<?php

/* @var $this VisitController */
/* @var $model Visit */
?>

<h1>VIC Total Visit Count</h1>
<?php echo CHtml::button('Export to CSV', array('id' => 'export-button', 'class' => 'greenBtn complete'));?>
</br>


<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'vic-total-visit-count',
    'dataProvider' => $model->search($merge),
    'enableSorting' => false,
    //'ajaxUpdate'=>true,
    'hideHeader'=>true,
    'filter' => $model,
    'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
    'columns' => array(
        array(
            'name' => 'id',
            'filter'=>CHtml::activeTextField($model, 'id', array('placeholder'=>'Visitor ID')),
        ),
        array(
            'name' => 'company0.code',
            'header' => 'Company Code',
            'filter'=>CHtml::activeTextField($model, 'companycode', array('placeholder'=>'Company Code')),
        ),
        array(
            'name' => 'totalcount',
            'value' => '$data->totalVisit ? $data->totalVisit : 0',
            'header' => 'Total Visits',
            'filter'=>CHtml::activeTextField($model, 'totalVisit', array('placeholder'=>'Total Visits', 'disabled' => 'disabled')),
        ),
        array(
            'name' => 'first_name',
            'filter'=>CHtml::activeTextField($model, 'first_name', array('placeholder'=>'First Name')),
        ),
        array(
            'name' => 'last_name',
            'filter'=>CHtml::activeTextField($model, 'last_name', array('placeholder'=>'Last Name')),
        ),
        array(
            'name' => 'company0.name',
            'header' => 'Company Name',
            'filter'=>CHtml::activeTextField($model, 'company', array('placeholder'=>'Company Name')),
        ),
        array(
            'type' => 'raw',
            'value' => '$data->totalVisit ? "<a data-link=\'" . Yii::app()->createUrl("visit/resetVisitCount&id=" . $data->id) . "\' class=\'statusLink resetCount\' href=\'#\'>Reset</a>" : "Reset"',
            //'value' => '"<a data-link=\'" . Yii::app()->createUrl("visit/resetVisitCount&id=" . $data->id) . "\' class=\'statusLink resetCount\' href=\'#\'>Reset</a>"',
        ),
        array(
            'type' => 'raw',
            //'value' => '"<a data-id=\'$data->id\' data-link=\'" . Yii::app()->createUrl("visitor/getActiveVisit") . "\' class=\'statusLink listNegateVisit\' href=\'#\'>Negate</a>"',
            'value' => '$data->totalVisit ? "<a data-id=\'$data->id\' data-link=\'" . Yii::app()->createUrl("visitor/getActiveVisit") . "\' class=\'statusLink listNegateVisit\' href=\'#\'>Negate</a>" : "Negate"',
            
        ),
        array(
            'type' => 'raw',
            'value' => '"<a class=\'statusLink\' href=\'" . Yii::app()->createUrl("visitor/update&id=" . $data->id) . "\'>View</a>"',
        ),
    ),
));

?>

<div class="modal fade fix-modal-ie hidden" style="width: 920px; margin-left: -373px" id="activeVisitModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header listActive">
            </div>
            <div class="modal-body" id="negate_reason">
                <form id="negateForm" class="form-horizontal">
                    <input type="hidden" id="linkGetActiveVisit"/>
                    <input type="hidden" id="visitorId"/>
                    <div class="form-group" >

                        <label style="float: left" class="col-md-2">Reason : </label>
                        <div class="col-md-9">
                            <input style="width: 800px" type="text" id="reasonForNegate" class="form-control input-sm" />
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer" id="negate_footer">
                <button type="button" id="btnNegate" class="btn btn-primary complete">Negate</button>
                <button type="button" id="btnCancel" class="btn btn-default neutral" data-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade fix-modal-ie-reset hidden" id="resetModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form id="taskForm" class="form-horizontal">
                    <input type="hidden" id="linkReset"/>
                    <div class="form-group">
                        <label style="float: left" class="col-md-2">ASIC Application Lodgement Date : </label>
                        <?php
                        $this->widget('EDatePicker', array(
                            'name' => 'datePicker',
                            'id' => 'lodgementDatePicker',
                        ));
                        ?>
                        <br>
                        <br>
                        <label style="float: left" class="col-md-2">Notes : </label>
                        <div class="col-md-9">
                            <input style="width: 450px" type="text" id="reasonForReset" class="form-control input-sm" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnReset" class="btn btn-primary actionForward">Reset</button>
                <button type="button" id="btnCancel" class="btn btn-default neutral" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        //show list active event for negate

        $('#content').on('click', '.listNegateVisit', function(e){

            e.preventDefault();
            document.getElementById('negate_reason').style.display="none";
            var container = $('.listActive').empty();
            var linkGetActiveVisit = $(this).data('link');
			//alert(linkGetActiveVisit);
			
            var id = $(this).data('id');
            $('#activeVisitModal #linkGetActiveVisit').val(linkGetActiveVisit);
            $('#activeVisitModal #visitorId').val(id);
            $.ajax({
                type: 'get',
                dataType: 'text',
                url: linkGetActiveVisit,
                data: {id: id},
                success: function(response) {
                    if (response.indexOf('Visitor Management System  - Login') > -1) {
                        window.location = "<?php echo Yii::app()->createUrl('site/login');?>";
                    }
                    container.append(response);
                    $('#activeVisitModal').removeClass('hidden');
                    $('#activeVisitModal').modal('show');
                },
				error: function(xhr,textStatus,errorThrown){
                alert(xhr.responseText);
                console.log(textStatus);
                console.log(errorThrown);
            }
            });
			
        });

        //click on Negate button in negate modal
        $('#btnNegate').on('click', function(e) {
            var ids = [];
            $(".visit-selected input[type=checkbox]").each(function () {
                if ($(this).is(':checked')){
                    ids.push($(this).val());
                }
            });
            var reason = $('#reasonForNegate').val();
            var linkNegate = '<?php echo Yii::app()->createUrl("visit/negate"); ?>';
            var container = $('.listActive').empty();
            if(ids.length == 0) {
                $('#activeVisitModal').modal('hide');
                return;
            }
            $.ajax({
                type:'GET',
                dataType: 'text',
                url: linkNegate,
                data: {reason: reason, ids: ids},
                success: function(response) {
                    $('#activeVisitModal').modal('hide');
                    $.fn.yiiGridView.update('vic-total-visit-count');
                    $('#reasonForNegate').val('');
                    document.getElementById('negate_reason').style.display="none";
                    $.ajax({
                        type: 'get',
                        dataType: 'text',
                        url: $('#activeVisitModal #linkGetActiveVisit').val(),
                        data: {id: $('#activeVisitModal #visitorId').val()},
                        success: function(response) {
                            container.append(response);
                            // $('#activeVisitModal').modal('hide');
                        },
				error: function(xhr,textStatus,errorThrown){
                console.log(xhr.responseText);
                console.log(textStatus);
                console.log(errorThrown);
            }
                    });

                }
            });
        });

        //click on reset link, show modal for type reason
        $('#content').on('click', '.resetCount', function(e){
            e.preventDefault();
            var linkReset = $(this).data('link');
            $('#resetModal').removeClass('hidden');
            $('#resetModal').modal('show');
            $('#resetModal #linkReset').val(linkReset);
            $('#reasonForReset').val("");

        });

        //reset total count of visitor
        $('#btnReset').on('click', function(e){
            e.preventDefault();
			//alert($('#linkReset').val());
			
            $('#resetModal').modal('hide');
            var reason = $('#reasonForReset').val();
            var lodgementDate = $('#lodgementDatePicker').val();
            $.ajax({
                type:'GET',
                url: $('#linkReset').val(),
                data: {reason: reason, lodgementDate: lodgementDate },
                success:function(data) {
                    if(! data || data == '') {
                        $.fn.yiiGridView.update('vic-total-visit-count');
                    } else {
                        alert(data);
                        //commented because of the 
                        //comment "When I reset visit 
                        //count for active visit then system is logging me 
                        //out of the application." in https://ids-jira.atlassian.net/browse/CAVMS-137
                        //Why such statement was written, previously?
                        //window.location = '<?php echo Yii::app()->createUrl('site/login');?>';
                    }
                },
				error: function(xhr,textStatus,errorThrown){
                console.log(xhr.responseText);
                console.log(textStatus);
                console.log(errorThrown);
            }
            });
            return false;
			
        });

    });
	 $(document).ready(function() {
        if ($("#totalRecordsCount").val() == 0) {
            $('#export-button').removeClass('greenBtn');
            $('#export-button').addClass('btn DeleteBtn actionForward');
            $("#export-button").attr('disabled', true);
        }

        $('#export-button').on('click', function() {
            $.fn.yiiGridView.export();
        });
        $.fn.yiiGridView.export = function() {
            $.fn.yiiGridView.update('vic-total-visit-count', {
                success: function() {
                    $('vic-total-visit-count').removeClass('grid-view-loading');
                    window.location = '<?php echo $this->createUrl('exportFileVicTotalCount');?>';
                },
                data: $('vic-total-visit-count').serialize() + '&export=true'
            });
        }

    });
</script>