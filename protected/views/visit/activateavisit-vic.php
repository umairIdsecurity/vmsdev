<?php 
$session = new CHttpSession;
?>

<style>
    .vic-active-visit {
        margin-top: 0px !important;
        padding-top: 5px;
    }
    .vic-col {
        padding-top: 5px;;
    }
</style>

<table class="detailsTable" style="font-size:12px;margin-top:15px;" id="logvisitTable">
    <tr>
        <td><a style="text-decoration: none; ">Status: <span style="color:#<?php
                if ($model->visit_status == VisitStatus::CLOSED) {
                    echo "ff0000";
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
        <td class="vic-col">
            <input type="checkbox" value="1" name="VivHolderDecalarations" class="vic-active-visit"/>
            <a href="#vicHolderModal" data-toggle="modal">VIC Holder Declarations</a>
        </td>
    </tr>
    <tr>
        <td class="vic-col">
            <input type="checkbox" value="1" name="AsicSponsorDecalarations" class="vic-active-visit"/>
            <a href="#">ASIC Holder Declarations</a>
        </td>
    </tr>

    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="vic-col">
            <input type="radio" checked="checked" value="1" name="reasonActiveVisit" class="vic-active-visit"/>
            <a href="#">Reason</a>
        </td>
    </tr>
    <tr>
        <td class="vic-col">
            <input type="radio" checked="checked" value="1" name="identificationActiveVisit" class="vic-active-visit"/>
            <a href="#">Identification</a>
        </td>
    </tr>
    <tr>
        <td class="vic-col">
            <input type="radio" checked="checked" value="1" name="asicSponsorActiveVisit" class="vic-active-visit"/>
            <a href="#">ASIC Sponsor</a>
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

    <tr>
        <td>Check In Date</td>
    </tr>
    <tr>
        <td>
            <input name="Visit[visit_status]" id="Visit_visit_status" type="text" value="1" style="display:none;">
            <input name="Visit[time_check_in]" id="Visit_time_check_in" class="activatevisittimein" type="text" style="display:none;">
            <?php
            if (empty($model->date_check_in)) {
                $model->date_check_in = date('d-m-Y');
            }
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'date_check_in',
                'htmlOptions' => array(
                    'size' => '10', // textField size
                    'maxlength' => '10', // textField maxlength
                    // 'readonly' => 'readonly',
                    'placeholder' => 'dd-mm-yyyy',
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

            if (empty($model->date_check_out)) {
                $model->date_check_out = date('d-m-Y');
            }
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'date_check_out',
                'htmlOptions' => array(
                    'size' => '10', // textField size
                    'maxlength' => '10', // textField maxlength
                    //'disabled' => 'disabled',
                    // 'readonly' => 'readonly',
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
        var minDate = '<?php echo $model->card_type == CardType::MANUAL_VISITOR ? "-3m" : "0"; ?>';

        refreshTimeIn();

        $("#Visit_date_check_in").datepicker({
            changeMonth: true,
            changeYear: true,
            showOn: "button",
            buttonImage: "<?php echo Yii::app()->controller->assetsBase; ?>/images/calendar.png",
            buttonImageOnly: true,
            minDate: minDate,
            dateFormat: "dd-mm-yy",
            onClose: function (dateText) {
                var currentDate = new Date();
                var date = dateText.substring(0, 2);
                var month = dateText.substring(3, 5);
                var year = dateText.substring(6, 10);
                var selectedDate = new Date(year, month-1, date);

                $( "#dateoutDiv #Visit_date_check_out" ).datepicker( "option", "minDate", selectedDate);

                if (selectedDate >= currentDate) {
                    $("#activate-a-visit-form input.complete").val("Preregister Visit");
                    // update card date
                    var cardDate = $.datepicker.formatDate('dd M y', selectedDate);
                    $("#cardDetailsTable span.cardDateText").html(cardDate);

                    $('#card_no_manual').hide();
                } else {
                    $("#activate-a-visit-form input.complete").val("");

                    <?php if ($model->card_type == CardType::MANUAL_VISITOR) { // show Back Date Visit
                        echo '$("#activate-a-visit-form input.complete").val("Back Date Visit");';
                    } else {
                        echo '$("#activate-a-visit-form input.complete").val("Activate Visit");';
                    }
                    ?>

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

<!-- Modal -->
<div id="vicHolderModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="VicHolderDeclarations" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Declarations</h3>
    </div>
    <div class="modal-body">
        <table>
            <tr>
                <td width="5%"><input type="checkbox" value="1" name="refusedAsicCbx" class="vic-active-visit"/></td>
                <td>The applicant declares they have not been refused or held an ASIC that was suspended or cancelled due to an adverse criminal record</td>
            </tr>
            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
            <tr>
                <td width="5%"><input type="checkbox" value="1" name="issuedVicCbx" class="vic-active-visit"/></td>
                <td>The applicant declares they have not been issued with a VIC for this airport for more than 28 days in the past 12 months. (from 21st November 2011)</td>
            </tr>
        </table>
    </div>

    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button class="btn btn-primary">Save changes</button>
    </div>
</div>