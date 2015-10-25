<?php 
$session = new CHttpSession;
?>


<table class="detailsTable" style="font-size:12px;margin-top:15px;" id="logvisitTable">
    <tr>
        <td><a style="text-decoration: none; ">Status: <span style="color:#<?php
                if ($model->visit_status == VisitStatus::CLOSED) {
                    echo "333333";
                } else if ($model->visit_status == VisitStatus::ACTIVE) {
                    echo "9BD62C";
                } else if ($model->visit_status == VisitStatus::PREREGISTERED) {
                    echo "FFA500";
                } else if ($model->visit_status == VisitStatus::SAVED) {
                    echo "637280";
                }
                ?> !important; font-weight:bold"><?php echo VisitStatus::$VISIT_STATUS_LIST[$model->visit_status]; ?></span></a>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>

    <tr>
        <td>Check In Time</td>
    </tr>
    <tr>
        <td>
            
            <?php
                $hours = '';
                $minutes = '';
                if(!empty($model->time_check_in) && !is_null($model->time_check_in)) 
                {   
                    $hours = date("H",strtotime($model->time_check_in));
                    $minutes = date("i",strtotime($model->time_check_in));
                }
            ?>
            <!-- <select class="time visit_time_in_hours" id='Visit_time_in_hours' disabled style="width:70px;"> -->
            <select disabled style="width:70px;">
                
                <?php //for ($i = 1; $i <= 24; $i++): ?>

                    <!-- <option value="<?php //echo $i; ?>"><?php //echo date("H", strtotime("$i:00")); ?></option> -->
                    <option value="<?php echo $hours;//echo $i; ?>" ><?php echo $hours;//echo date("H", strtotime("$i:00")); ?></option>

                <?php //endfor; ?>

            </select> :
            <!-- <select class='time visit_time_in_minutes'  id='Visit_time_in_minutes' disabled style="width:70px;"> -->
            <select disabled style="width:70px;">
                <?php //for ($i = 1; $i <= 60; $i++): ?>
                    <option value="<?php echo $minutes;//echo $i; ?>"><?php
                        echo $minutes;
                       /* if ($i > 0 && $i < 10) {
                            echo '0' . $i;
                        } else {
                            echo $i;
                        };*/
                        ?></option>
                <?php //endfor; ?>
            </select>

        </td>
    </tr>

    <tr>
        <td>Check In Date</td>
    </tr>
    <tr>
        <td>
            <input name="Visit[visit_status]" id="Visit_visit_status" type="text" value="1" style="display:none;">
            <input name="Visit[time_check_in]" id="Visit_time_check_in" class="activatevisittimein" type="text" style="display:none;">
            <?php
            if (!strtotime($model->date_check_in) || in_array($model->visit_status, [VisitStatus::SAVED, VisitStatus::CLOSED ]) ) {
                $model->date_check_in = date('d-m-Y');
            }
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'date_check_in',
                'htmlOptions' => array(
                    'size' => '10', // textField size
                    'maxlength' => '10', // textField maxlength
                    'readonly' => 'readonly',
                    'placeholder' => 'dd-mm-yyyy',
                    //'disabled' => 'disabled'
                ),
                'options' => array(
                    'dateFormat' => 'dd-mm-yy',
                )
            ));
            ?>
            <?php /*if ($model->card_type == CardType::SAME_DAY_VISITOR) { */?><!--
                <input type="text" style="display:none;" value="<?php
/*                echo date("d-m-Y");
                */?>" id='Visit_date_out'
                       name="Visit[date_out]" >
                   --><?php /*} */?>
        </td>
    </tr>


    <tr id="dateoutDiv">
        <td>Check Out Date
            <br><?php

            if (!strtotime($model->date_check_out) || in_array($model->visit_status, [VisitStatus::SAVED, VisitStatus::CLOSED ]) ) {
                $model->date_check_out = date('d-m-Y');
            }
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'date_check_out',
                'htmlOptions' => array(
                    'size' => '10', // textField size
                    'maxlength' => '10', // textField maxlength
                    //'disabled' => 'disabled',
                    'readonly' => 'readonly',
                    'placeholder' => 'dd-mm-yyyy',
                ),
                'options' => array(
                   'dateFormat' => 'dd-mm-yy',
                )
            ));
            ?>
        </td>
    </tr>

    <?php if($model->card_type == CardType::MANUAL_VISITOR) : ?>
    <tr>
        <td>
            <div id="card_no_manual">
                Pre Issued Card No.
                <br>
                <input name="pre_issued_card_no" id="pre_issued_card_no" class="" type="text" placeholder="Enter Card No." >
                <span class="required">*</span>
                <div style="display: none" id="card_number_required" class="errorMessage">Please enter a Card Number</div>
            </div>
        </td>
    </tr>
    <?php endif; ?>

</table>
<script>
    $(document).ready(function() {
        // for Card Type Manual
        var d        = new Date();
        var cardType = "<?php echo $model->card_type; ?>";
        var minDate  = '<?php echo $model->card_type == CardType::MANUAL_VISITOR ? "-3m" : "0"; ?>';

        refreshTimeIn();

        $("#Visit_date_check_in").datepicker({
            changeMonth: true,
            changeYear: true,
            showOn: "button",
            buttonImage: "<?php echo Yii::app()->controller->assetsBase; ?>/images/calendar.png",
            buttonImageOnly: true,
            minDate: minDate,
            dateFormat: "dd-mm-yy",
            onClose: function (selectedDate) {
                var currentDate  = d.getDate() + '-0' + (d.getMonth() + 1) + '-' + d.getFullYear();
                var checkInSelectedDate = $("#Visit_date_check_in").datepicker('getDate');

                $( "#dateoutDiv #Visit_date_check_out" ).datepicker( "option", "minDate", selectedDate);

                //update text of visit button
                 function updateTextVisitButton(text, id, val) {
                    $("#registerNewVisit").text(text).val(val);
                }

                if (selectedDate >= currentDate) {
                    if (cardType == <?php echo CardType::MANUAL_VISITOR; ?> || selectedDate == currentDate) {
                        updateTextVisitButton("Activate Visit", "registerNewVisit", "active");
                    } else {
                        updateTextVisitButton("Preregister Visit", "preregisterNewVisit", "preregister");
                    }
                    // update card date
                    var cardDate = $.datepicker.formatDate('dd M y', checkInSelectedDate);
                    $("#cardDetailsTable span.cardDateText").html(cardDate);
                    $("#card_no_manual").hide();
                    
                    /*updateTextVisitButton("Preregister Visit", "preregisterNewVisit");
                    // update card date
                    var cardDate = $.datepicker.formatDate('dd M y', selectedDate);
                    $("#cardDetailsTable span.cardDateText").html(cardDate);

                    $('#card_no_manual').hide();*/
                } else {
                    if (cardType == <?php echo CardType::MANUAL_VISITOR; ?>) {
                        updateTextVisitButton("Back Date Visit", "backDateVisit", "backdate");
                    } else {
                        updateTextVisitButton("Activate Visit", "registerNewVisit", "active");
                    }
                    $('#card_no_manual').show();
                }
            }
        });

        $("#dateoutDiv #Visit_date_check_out").datepicker({
            changeMonth: true,
            changeYear: true,
            showOn: "button",
            buttonImage: "<?php echo Yii::app()->controller->assetsBase; ?>/images/calendar.png",
            buttonImageOnly: true,
            minDate: minDate,
            dateFormat: "dd-mm-yy",
            onClose: function (date) {
                var day = date.substring(0, 2);
                var month = date.substring(3, 5);
                var year = date.substring(6, 10);
                var newDate = new Date(year, month-1, day);

                var cardDate = $.datepicker.formatDate('dd M y', newDate);
                $("#cardDetailsTable span.cardDateText").html(cardDate);
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

