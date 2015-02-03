<br>
<?php
$timeIn = explode(":", '00:00:00');
if ($visitModel->time_in != '') {
    $timeIn = explode(":", $visitModel->time_in);
}
?>
<table class="detailsTable" style="font-size:12px;" id="logvisitTable">
    <tr>
        <td>Date Check In</td>
    </tr>
    <tr>
        <td><input type="text" value="<?php echo date("d-m-Y"); ?>" id='Visit_date_inLog' readonly=""></td>
    </tr>

    <tr id="dateoutDiv">
        <td>Proposed Date Out
            <br><?php
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'htmlOptions' => array(
            'id' => 'proposedDateOut',
            'name' => 'proposedDateOut',
            'size' => '10', // textField size
            'maxlength' => '10', // textField maxlength
            'disabled' => 'disabled',
            'placeholder' => 'dd-mm-yyyy',
        ),
        'options' => array(
            'dateFormat' => 'dd-mm-yy',
        )
    ));
    ?>
            <span style="color:red;display:none;" id="preregisterdateoutError">Date Out cannot be blank.</span>
        </td>
    </tr>

    <tr>
        <td>Time Check In</td>
    </tr>
    <tr>
        <td>
            <select class="time" name='Visit[time_in_hours]' id='Visit_time_in_hours' disabled style="width:70px;">
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
            <select class='time' name='Visit[time_in_minutes]' id='Visit_time_in_minutes' disabled style="width:70px;">
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
<div class="register-a-visitor-buttons-div">
    <input type="button" class="visitor-backBtn btnBackTab4" value="Back"/>
    <input type='button' value='Save and Continue' class='greenBtn complete' id='submitAllForms'/>
</div>
<script>
    $(document).ready(function() {
        $("#proposedDateOut").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '1800:2099',
            showOn: "button",
            minDate: "+1",
            buttonImage: "<?php echo Yii::app()->request->baseUrl; ?>/images/calendar.png",
            buttonImageOnly: true,
            buttonText: "Select Proposed Date Out",
            dateFormat: "dd-mm-yy",
            onClose: function(selectedDate) {
                $("#Visit_date_out").val($("#proposedDateOut").val());

            }

        });

        $("#submitAllForms").click(function(e) {
            e.preventDefault();
            if ($("#proposedDateOut").val() == '') {
                $("#preregisterdateoutError").show();
            }
            else if ($("#Visit_visitor_type").val() == 1) { //if patient type
                $("#preregisterdateoutError").hide();
                sendReasonForm();
            } else {
                $("#preregisterdateoutError").hide();
                if (($("#selectedHostInSearchTable").val() != '' && $("#search-host").val() != '')) { //if host is from search
                    
                    if ($("#selectedVisitorInSearchTable").val() != '0') { // if visitor is from search

                        if ($("#VisitReason_reason_search").val() != 0 && $("#Visit_reason_search").val() == 'Other') {
                            sendReasonForm();
                        } else {
                            populateVisitFormFields();
                        }
                        $("#searchTextHostErrorMessage").hide();
                    }
                    else {
                        $("#searchTextHostErrorMessage").hide();
                        sendReasonForm();
                    }
                }

                else {
                    //if visitor is not from search sendvisitorform

                    if ($("#Visit_reason").val() == 'Other') {
                        sendReasonForm();
                    }
                    else if ($("#selectedVisitorInSearchTable").val() == 0) {
                        sendVisitorForm();
                    } else {
                        sendHostForm();
                    }
                }
            }
        });
    });
</script>