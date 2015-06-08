<?php

/* @var $this VisitController */
/* @var $model Visit */
?>

<h1>Corporate Total Visit Count</h1>

<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'corporate-total-visit-count',
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
            'value' => '$data->totalvisit ? $data->totalvisit : 0',
            'header' => 'Total Visits',
            'filter'=>CHtml::activeTextField($model, 'totalvisit', array('placeholder'=>'Total Visits', 'disabled' => 'disabled')),
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
            'value' => '"<a data-link=\'" . Yii::app()->createUrl("visit/resetVisitCount&id=" . $data->id) . "\' class=\'statusLink resetCount\' href=\'#\'>Reset</a>"',
        ),
        array(
            'type' => 'raw',
            'value' => '"<a data-id=\'$data->id\' data-link=\'" . Yii::app()->createUrl("visitor/getActiveVisit") . "\' class=\'statusLink listNegateVisit\' href=\'#\'>Negate</a>"',
        ),
        array(
            'type' => 'raw',
            'value' => '"<a class=\'statusLink\' href=\'" . Yii::app()->createUrl("visitor/update&id=" . $data->id) . "\'>View</a>"',
        ),
    ),
));

?>

<div class="modal fade fix-modal-ie" style="width: 920px; margin-left: -373px" id="activeVisitModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                <button type="button" id="btnNegate" class="btn btn-primary">Negate</button>
                <button type="button" id="btnCancel" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade fix-modal-ie-reset" id="resetModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form id="taskForm" class="form-horizontal">
                    <input type="hidden" id="linkReset"/>
                    <div class="form-group">
                        <label style="float: left" class="col-md-2">Reason : </label>
                        <div class="col-md-9">
                            <input style="width: 450px" type="text" id="reasonForReset" class="form-control input-sm" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnReset" class="btn btn-primary">Reset</button>
                <button type="button" id="btnCancel" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        //show list active event for negate

        $('.listNegateVisit').live('click', function(e){

            e.preventDefault();
            document.getElementById('negate_reason').style.display="none";
            var container = $('.listActive').empty();
            var linkGetActiveVisit = $(this).data('link');
            var id = $(this).data('id');
            $('#activeVisitModal #linkGetActiveVisit').val(linkGetActiveVisit);
            $('#activeVisitModal #visitorId').val(id);
            $.ajax({
                type: 'get',
                dataType: 'text',
                url: linkGetActiveVisit,
                data: {id: id},
                success: function(response) {
                    container.append(response);
                    $('#activeVisitModal').modal('show');
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
            if(ids.length == 0|| reason.length == 0) {
                $('#activeVisitModal').modal('hide');
                return;
            }
            $.ajax({
                type:'GET',
                dataType: 'text',
                url: linkNegate,
                data: {reason: reason, ids: ids},
                success: function(response) {
                    $.fn.yiiGridView.update('corporate-total-visit-count');
                    $('#reasonForNegate').val('');
                    document.getElementById('negate_reason').style.display="none";
                    $.ajax({
                        type: 'get',
                        dataType: 'text',
                        url: $('#activeVisitModal #linkGetActiveVisit').val(),
                        data: {id: $('#activeVisitModal #visitorId').val()},
                        success: function(response) {
                            container.append(response);
                            $('#activeVisitModal').modal('show');
                        }
                    });

                }
            });
        });

        //click on reset link, show modal for type reason
        $('.resetCount').live('click', function(e){
            e.preventDefault();
            var linkReset = $(this).data('link');
            $('#resetModal').modal('show');
            $('#resetModal #linkReset').val(linkReset);
            $('#reasonForReset').val("");

        });

        //reset total count of visitor
        $('#btnReset').on('click', function(e){
            e.preventDefault();
            $('#resetModal').modal('hide');
            var reason = $('#reasonForReset').val();
            $.ajax({
                type:'GET',
                url: $('#linkReset').val(),
                data: {reason: reason},
                success:function(response) {
                    $.fn.yiiGridView.update('corporate-total-visit-count');
                }
            });
            return false;
        });

    });
</script>