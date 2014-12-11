<br>
<?php
$time_in = explode(":", '00:00:00');
if ($visitModel->time_in != '') {
    $time_in = explode(":", $visitModel->time_in);
}
?>
<table class="detailsTable" style="font-size:12px;" id="logvisitTable">
    <tr>
        <td>Date In</td>
    </tr>
    <tr>
        <td><input type="text" value="<?php echo date("d-m-Y"); ?>" id='Visit_date_inLog' readonly=""></td>
    </tr>

    <tr id="dateoutDiv">
        <td>Date Out
            <br><?php
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'htmlOptions' => array(
            'id' => 'proposedDateOut',
            'name' => 'proposedDateOut',
            'size' => '10', // textField size
            'maxlength' => '10', // textField maxlength
            'disabled' => 'disabled',
            // 'readonly' => 'readonly',
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
        <td>Time In</td>
    </tr>
    <tr>
        <td>
            <select class="time" name='Visit[time_in_hours]' id='Visit_time_in_hours' disabled style="width:70px;">
<?php for ($i = 1; $i <= 24; $i++): ?>
                    <option 
                    <?php
                    if ($time_in[0] == $i) {
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
                    if ($time_in[1] == $i) {
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
    <input type='button' value='Save and Continue' class='greenBtn' id='submitAllForms'/>
</div>
<script>
    $(document).ready(function() {
        $("#proposedDateOut").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '1800:2099',
            showOn: "button",
            minDate: 0,
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
            // alert($("#Visit_visitor_type").val());
            if ($("#proposedDateOut").val() == '') {
                $("#preregisterdateoutError").show();
            }
            else if ($("#Visit_visitor_type").val() == 1) { //if patient type
                $("#preregisterdateoutError").hide();
                sendReasonForm();
                // alert("patient");
            } else {
                $("#preregisterdateoutError").hide();
                /// alert('corporate');
                if (($("#selectedHostInSearchTable").val() != '' && $("#search-host").val() != '')) { //if host is from search
                    //  alert("host from search ");
                    if ($("#selectedVisitorInSearchTable").val() != '0') { // if visitor is from search

                        if ($("#VisitReason_reason_search").val() != 0 && $("#Visit_reason_search").val() == 'Other') {
                            sendReasonForm();
                            //alert("visitor from search with new reason");
                        } else {
                            populateVisitFormFields();
                            //  alert("visitor from search with exstng reason");
                        }
                        $("#searchTextHostErrorMessage").hide();
                    }
                    else {
                        $("#searchTextHostErrorMessage").hide();
                        sendReasonForm();
                        //  alert("visitor not search ");
                    }

                }

                else {
                    //if visitor is not from search sendvisitorform

                    if ($("#Visit_reason").val() == 'Other') {
                        sendReasonForm();
                    }
                    else if ($("#selectedVisitorInSearchTable").val() == 0) {
                        sendVisitorForm();
                        // alert("visitor not from search");
                    } else {
                        sendHostForm();
                        // alert("visitor from search")
                    }
                }
            }
        });
    });
</script>