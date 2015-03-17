
<table class="detailsTable" style="font-size:12px;margin-top:15px;" id="logvisitTable">
    <tr>
        <td>Check In Date</td>
    </tr>
    <tr>
        <td>
            <input name="Visit[visit_status]" id="Visit_visit_status" type="text" value="1" style="display:none;">
            <input name="Visit[time_check_in]" id="Visit_time_check_in" class="activatevisittimein" type="text" style="display:none;">
            <input type="text" value="<?php echo date("d-m-Y"); ?>" id='Visit_date_check_in' name="Visit[date_check_in]" disabled>
            <?php if ($model->card_type == CardType::SAME_DAY_VISITOR) { ?>
                <input type="text" style="display:none;" value="<?php
                echo date("d-m-Y");
                ?>" id='Visit_date_out' 
                       name="Visit[date_out]" >
                   <?php } ?>
        </td>
    </tr>

    <tr>
        <td>Check In Time</td>
    </tr>
    <tr>
        <td>
            <select class="time visit_time_in_hours" id='Visit_time_in_hours' disabled style="width:70px;">
<?php for ($i = 1; $i <= 24; $i++): ?>
                    <option value="<?= $i; ?>"><?= date("H", strtotime("$i:00")); ?></option>
                <?php endfor; ?>
            </select> :
            <select class='time visit_time_in_minutes'  id='Visit_time_in_minutes' disabled style="width:70px;">
<?php for ($i = 1; $i <= 60; $i++): ?>
                    <option value="<?= $i; ?>"><?php
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
<?php if ($model->date_out == '' && $model->card_type == CardType::MULTI_DAY_VISITOR) {
    ?>
        <tr id="dateoutDiv">
            <td>Proposed Check Out Date
                <br><?php
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
            'dateFormat' => 'dd-mm-yy',
        )
    ));
    ?>
                <span style="color:red;display:none;" id="preregisterdateoutError">Date Out cannot be blank.</span>
            </td>
        </tr>
<?php } ?>
</table>
<script>
    $(document).ready(function() {
        refreshTimeIn();
        $("#dateoutDiv #Visit_date_out").datepicker({
            changeMonth: true,
            changeYear: true,
            showOn: "button",
            buttonImage: "<?php echo Yii::app()->controller->assetsBase; ?>/images/calendar.png",
            buttonImageOnly: true,
            minDate: "+1",
            dateFormat: "dd-mm-yy",
            onClose: function(selectedDate) {
                $("#dateoutDiv #Visit_date_out").val($("#Visit_date_out").val());
                // $('.ui-datepicker-trigger[title="Select Proposed Check Out Date"]').hide();
            }
        });
    });

    function refreshToCurrentTime() {
        var refresh = 1000; // Refresh rate in milli seconds
        mytime = setTimeout('refreshTimeIn()', refresh)
    }

    function refreshTimeIn() {

        var x = new Date();
        var currenttime = x.getHours() + ":" + x.getMinutes() + ":" + x.getSeconds();

        $(".visit_time_in_hours").val(x.getHours());
        $(".visit_time_in_minutes").val(x.getMinutes());
        $(".activatevisittimein").val(currenttime);
        tt = refreshToCurrentTime();
    }

</script>