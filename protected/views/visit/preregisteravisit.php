
<?php
$session = new CHttpSession;
$timeIn = explode(":", '00:00:00');
if ($model->time_in != '') {
    $timeIn = explode(":", $model->time_in);
}
$logform = $this->beginWidget('CActiveForm', array(
    'id' => 'update-log-visit-form',
    'htmlOptions' => array("name" => "update-log-visit-form"),
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'afterValidate' => 'js:function(form, data, hasError){
                                if (!hasError){
                                        $("#Visit_date_out").attr("disabled", true);
                                        $("#Visit_date_in").attr("disabled", true);
                                    if($("#Visit_date_in").val() == "" && $("#Visit_date_out").val() == ""){
                                        $("#preregisterdateinError").show();
                                        $("#preregisterdateoutError").show();
                                    }
                                    else if( $("#Visit_date_in").val() == "" ){
                                        $("#preregisterdateinError").show();
                                         $("#preregisterdateoutError").hide();
                                    } else if($("#Visit_date_out").val() == "" ) {
                                       $("#preregisterdateoutError").show();
                                       $("#preregisterdateinError").hide();
                                    } 
                                    else {
                                        $("#preregisterdateinError").hide();
                                        $("#preregisterdateoutError").hide();
                                        $("#Visit_date_out").attr("disabled", false);
                                        $("#Visit_date_in").attr("disabled", false);
                                        checkIfPreregisteredVisitConflictsWithAnotherVisit();
                                       // sendVisitForm("update-log-visit-form");
                                        
                                    }

                                }
                                }'
    ),
        ));
?>
<div class="flash-success success-update-preregister">Visit Successfully Updated.</div>
<input type='hidden' id='Visit_visit_status' name='Visit[visit_status]' value='<?php
echo VisitStatus::PREREGISTERED;
?>'>
<table class="detailsTable" style="font-size:12px;margin-top:15px;" id="logvisitTable">

    <tr>
        <td>Proposed Date In</td>
    </tr>
    <tr>

        <td><?php
$mindate = date("d-m-Y");
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'model' => $model,
    'attribute' => 'date_in',
    'htmlOptions' => array(
        'size' => '10', // textField size
        'maxlength' => '10', // textField maxlength
        'placeholder' => 'dd-mm-yyyy',
        'disabled' => 'disabled',
    ),
    'options' => array(
        'showButtonPanel' => false,
        'showOn' => 'both',
        'dateFormat' => 'dd-mm-yy',
        'minDate' => $mindate,
        'onClose' => 'js:function(selectedDate) { $("#Visit_date_in").datepicker("option", "minDate", selectedDate); }',
    )
));
?>
            <span style="color:red;display:none;" id="preregisterdateinError">Date In cannot be blank.</span>
        </td>
    </tr>
    <tr>
        <td>Proposed Date Out</td>
    </tr>
    <tr>
        <td><?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'date_out',
                'htmlOptions' => array(
                    'size' => '10', // textField size
                    'maxlength' => '10', // textField maxlength
                    'disabled' => 'disabled',
                    // 'readonly' => 'readonly',
                    'placeholder' => 'dd-mm-yyyy',
                ),
                'options' => array(
                    'buttonImage' => Yii::app()->request->baseUrl . '/images/Calendar.png',
                    'buttonImageOnly' => true,
                    'dateFormat' => 'dd-mm-yy',
                    'onClose' => 'js:function(selectedDate) { $("#Visit_date_out").datepicker("option", "maxDate", selectedDate); }',
                )
            ));
?>
            <span style="color:red;display:none;" id="preregisterdateoutError">Date Out cannot be blank.</span>
        </td>
    </tr>
    <tr>
        <td>Proposed Time In</td>
    </tr>
    <tr>
        <td>

            <select class="time" name='Visit[time_in_hours]' id='Visit_time_in_hours' >
<?php for ($i = 1; $i <= 24; $i++): ?>
                    <option 
                    <?php
                    if ($timeIn[0] == $i) {
                        echo " selected ";
                    }
                    ?>
                        value="<?= $i; ?>"><?= date("H", strtotime("$i:00")); ?></option>
                <?php endfor; ?>
            </select> :
            <select class='time' name='Visit[time_in_minutes]' id='Visit_time_in_minutes'>
<?php for ($i = 1; $i <= 60; $i++): ?>
                    <option 
                    <?php
                    if ($timeIn[1] == $i) {
                        echo " selected ";
                    }
                    ?>
                        value="<?= $i; ?>"><?php
                    if ($i > 0 && $i < 10) {
                        echo '0' . $i;
                    } else {
                        echo $i;
                    };
                    ?></option>
                        <?php endfor; ?>
            </select>
        </td>
    </tr>
</table>
<?php
echo $logform->error($model, 'date_in');
if ($model->visit_status == VisitStatus::CLOSED) {
    ?>
    <button id='preregisterNewVisit' class='greenBtn actionForward'>Confirm</button><br>
<?php } else { ?>
    <input type='submit' value='Confirm' class="complete" style="display:none;" id="confirmPreregisterSubmit"/>
    <button class="complete greenBtn" id="confirmPreregisterDummy"> Confirm</button>
    <button class="actionForward greenBtn" id="cancelPreregisteredVisitButton">Cancel</button>

<?php } ?>

<?php $this->endWidget(); ?>
<input type="text" value="<?php echo date('d-m-Y', time() + 86400); ?>" id="curDate" style="display:none;">
<input type="text" value="<?php
       echo date('d-m-Y', mktime(0, 0, 0, date('m'), date('d') + 2, date('Y')));
       ;
       ?>" id="curDateMultiDay" style="display:none;">
<input type='text' id='currentCardTypeValueOfEditedUser' value='<?php echo $model->card_type; ?>' style='display:none;'>
<input type='text' id='savedTimeIn' value='<?php echo $model->time_in; ?>' style='display:none;'>
<script>
    $(document).ready(function() {


        var currentTime = new Date();
        var dd = currentTime.getDate();
        var mm = currentTime.getMonth() + 1; //January is 0!
        var yyyy = currentTime.getFullYear();

        var currentDate = $("#curDate").val();

        if ($("#savedTimeIn").val() == '') {
            $("#Visit_time_in_hours").val(currentTime.getHours());
            $("#Visit_time_in_minutes").val(currentTime.getMinutes() + 30);
        }

        if ($("#currentCardTypeValueOfEditedUser").val() == 1) { //if card type is same visitor
            if('<?php echo $model->visit_status?>' == 3){
                $("#Visit_date_in").val(currentDate);
                $("#Visit_date_out").val(currentDate);
                $("#Visit_date_in").attr("disabled", true);
            }
            else if ('<?php echo $model->date_out; ?>' != '') {
                $("#Visit_date_out").val("<?php echo $model->date_out; ?>");
                $("#Visit_date_in").val("<?php echo $model->date_in; ?>");
            } else {
                $("#Visit_date_in").val(currentDate);
                $("#Visit_date_out").val(currentDate);
                $("#Visit_date_in").attr("disabled", true);
            }
        } else {
            $("#Visit_date_in").val(currentDate);
            $("#Visit_date_out").val($("#curDateMultiDay").val());
            $("#dateoutDiv #Visit_date_out").val($("#curDateMultiDay").val());
            if ('<?php echo $model->date_out; ?>' != '') {
                $("#Visit_date_out").val("<?php echo $model->date_out; ?>");
                $("#Visit_date_in").val("<?php echo $model->date_in; ?>");
            }
        }

        $('#cancelPreregisteredVisitButton').on('click', function(e) {
            e.preventDefault();
            sendCancelVisit();
        });
        
        $('#confirmPreregisterDummy').on('click', function(e) {
            e.preventDefault();
            $("#confirmPreregisterSubmit").click();
        });

        $('#Visit_date_in').on('change', function(e) {
            assignValuesForProposedDateOutDependingOnCardType();
        });

        function assignValuesForProposedDateOutDependingOnCardType() {
            if ($("#currentCardTypeValueOfEditedUser").val() == 1) { //if card type is same visitor
                $("#Visit_date_out").val($("#Visit_date_in").val());
            }
        }

        $("#Visit_date_in").datepicker({
            changeMonth: true,
            changeYear: true,
            showOn: "button",
            buttonImage: "<?php echo Yii::app()->request->baseUrl; ?>/images/calendar.png",
            buttonImageOnly: true,
            buttonText: "Select Proposed Date In",
            minDate: "+1",
            dateFormat: "dd-mm-yy",
            onClose: function(selectedDate, test) {


                if ($("#currentCardTypeValueOfEditedUser").val() == 1) { //same day
                    $("#Visit_date_out").datepicker("option", "minDate", selectedDate);
                    $('.ui-datepicker-trigger[title="Select Proposed Date Out"]').hide();
                } else {

                    var newDateString = ('0' + (parseInt(test.selectedDay) + 1)).slice(-2) + '-'
                            + ('0' + (test.selectedMonth + 1)).slice(-2) + '-'
                            + test.selectedYear;
                    $("#Visit_date_out").datepicker("option", "minDate", newDateString);
                }

            }
        });
        $("#Visit_date_out").datepicker({
            changeMonth: true,
            changeYear: true,
            showOn: "button",
            buttonImage: "<?php echo Yii::app()->request->baseUrl; ?>/images/calendar.png",
            buttonImageOnly: true,
            buttonText: "Select Proposed Date Out",
            dateFormat: "dd-mm-yy",
            onClose: function(selectedDate) {
                $("#Visit_date_in").datepicker("option", "maxDate", selectedDate);
            }
        });

        $('#update-log-visit-form').bind('submit', function() {
            $(this).find('#Visit_date_out').removeAttr('disabled');
            $(this).find('#Visit_date_in').removeAttr('disabled');
            $(this).find('#Visit_date_check_in').removeAttr('disabled');
            $(this).find('#Visit_date_check_out').removeAttr('disabled');
        });

    });
</script>
