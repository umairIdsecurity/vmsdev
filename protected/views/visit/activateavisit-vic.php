<?php 
$session = new CHttpSession;
?>

<style>
    .vic-active-visit {margin-top: 0px !important;padding-top: 5px;}
    .vic-col {padding-top: 5px;}
    .vic-col a{text-decoration: underline !important;}
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
            <input type="checkbox" value="1" name="VivHolderDecalarations" disabled="disabled" id="VivHolderDecalarations" class="vic-active-visit"/>
            <a href="#vicHolderModal" data-toggle="modal">VIC Holder Declarations</a>
        </td>
    </tr>
    <tr>
        <td class="vic-col">
            <input type="checkbox" value="1" name="AsicSponsorDecalarations" disabled="disabled" id="AsicSponsorDecalarations" class="vic-active-visit"/>
            <a href="#asicSponsorModal" data-toggle="modal">ASIC Sponsor Declarations</a>
        </td>
    </tr>

    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><strong style="color: #637280;">Verifications</strong></td>
    </tr>
    <tr>
        <td class="vic-col">
            <input type="checkbox" <?php echo $model->reason > 0 ? 'checked="checked"' : '';?> value="1" name="reasonActiveVisit" class="vic-active-visit"/>
            <a href="#">Visit Reason</a>
        </td>
    </tr>
    <tr>
        <td class="vic-col">
            <input type="checkbox"  value="1" name="identificationActiveVisit" class="vic-active-visit"/>
            <a href="#">Identification</a>
        </td>
    </tr>
    <tr>
        <td class="vic-col">
            <input type="checkbox" value="1" name="asicSponsorActiveVisit" class="vic-active-visit"/>
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
            if (strtotime($model->date_check_in)) {
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
                ),
                'options' => array(
                    'dateFormat' => 'dd-mm-yy',
                )
            ));
            ?>
        </td>
    </tr>

    <tr id="dateoutDiv" <?php echo $model->card_type == CardType::VIC_CARD_SAMEDATE ? 'style="display:none;"' : '' ?>>
        <td>Check Out Date
            <br><?php

            if (strtotime($model->date_check_out)) {
                $model->date_check_out = date('d-m-Y');
            }

            // Extended Card Type (EVIC) or Multiday
            if (in_array($model->card_type, array(CardType::VIC_CARD_EXTENDED, CardType::VIC_CARD_MULTIDAY))) {
                $model->date_check_out = date('d-m-Y', strtotime($model->date_check_in. ' + 28 days'));
            }

            // VIC_CARD_24HOURS
            if ($model->card_type == CardType::VIC_CARD_24HOURS) {
                $model->date_check_out = date('d-m-Y', strtotime($model->date_check_in. ' + 1 day'));
                $model->time_check_out = $model->time_check_in;
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

    <?php if($model->card_type == CardType::VIC_CARD_MANUAL) : ?>
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
        var minDate = '<?php echo $model->card_type == CardType::VIC_CARD_MANUAL ? "-3m" : "0"; ?>';

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
                    <?php if ($model->card_type == CardType::VIC_CARD_MANUAL) { // show Back Date Visit
                        echo '$("#activate-a-visit-form input.complete").val("Activate Visit");';
                    } else {
                        echo '$("#activate-a-visit-form input.complete").val("Preregister Visit");
                              $("#card_no_manual").hide();';
                    }
                    ?>

                    // update card date
                    var cardDate = $.datepicker.formatDate('dd M y', selectedDate);
                    $("#cardDetailsTable span.cardDateText").html(cardDate);

                } else {
                    $("#activate-a-visit-form input.complete").val("");

                    <?php if ($model->card_type == CardType::VIC_CARD_MANUAL) { // show Back Date Visit
                        echo '$("#activate-a-visit-form input.complete").val("Back Date Visit");';
                    } else {
                        echo '$("#activate-a-visit-form input.complete").val("Activate Visit");';
                    }
                    ?>

                    $('#card_no_manual').show();
                }

                <?php
                if (in_array($model->card_type, array(CardType::VIC_CARD_EXTENDED, CardType::VIC_CARD_MULTIDAY))) {
                    echo '  var checkoutDate = new Date(selectedDate);
                            checkoutDate.setDate(selectedDate.getDate() + 28);
                            $( "#dateoutDiv #Visit_date_check_out" ).datepicker( "setDate", checkoutDate);
                        ';
                }

                if ($model->card_type == CardType::VIC_CARD_24HOURS) {
                    echo '  var checkoutDate = new Date(selectedDate);
                    checkoutDate.setDate(selectedDate.getDate() + 1);
                    $( "#dateoutDiv #Visit_date_check_out" ).datepicker( "setDate", checkoutDate);
                ';
                }
                ?>
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
            disabled: <?php echo (in_array($model->card_type, array(CardType::VIC_CARD_EXTENDED, CardType::VIC_CARD_24HOURS, CardType::VIC_CARD_MULTIDAY))) ? "true" : "false"; ?>,
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

<!-- VIC Holder Declarations Modal -->
<div id="vicHolderModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="VicHolderDeclarations" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>VIC Holder Declarations</h3>
    </div>
    <div class="modal-body">
        <table>
            <tr>
                <td width="5%"><input type="checkbox" id="refusedAsicCbx"/></td>
                <td>The applicant declares they have not been refused or held an ASIC that was suspended or cancelled due to an adverse criminal record</td>
            </tr>
            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
            <tr>
                <td width="5%"><input type="checkbox" id="issuedVicCbx"/></td>
                <td>The applicant declares they have not been issued with a VIC for this airport for more than 28 days in the past 12 months.
                    (from <?php
                            if (isset($model->date_check_in)) {
                                echo $model->date_check_in;
                            } else {
                                echo date("d F Y");
                            }
                    ?>)
                </td>
            </tr>
        </table>
    </div>
    <div class="modal-footer">
        <a type="button" class="btn btn-primary" id="btnVicConfirm">Confirm</a>
    </div>
</div>

<!-- ASIC SPONSOR Declarations Modal -->
<div id="asicSponsorModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="AsicSponsorDeclarations" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>ASIC Sponsor Declarations</h3>
    </div>
    <div class="modal-body">
        <table>
            <tr>
                <td width="5%"><input type="checkbox" id="asicDecalarationCbx1"/></td>
                <td>I confirm that the VIC holders details are correct. I have read, understood and agree to ensure that the applicant will abide by the conditions applicatle to the use of the Visitor Identification Card.</td>
            </tr>
            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
            <tr>
                <td width="5%"><input type="checkbox" id="asicDecalarationCbx2"/></td>
                <td>I understand that it is an offence to escort/sponsor someone airside without a valid operational reason for them to require access.</td>
            </tr>
            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
            <tr>
                <td width="5%"><input type="checkbox" id="asicDecalarationCbx3"/></td>
                <td>I note that they mush be under my director supervision at all times whilst they are airside.</td>
            </tr>
            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
            <tr>
                <td width="5%"><input type="checkbox" id="asicDecalarationCbx4"/></td>
                <td>I request that a VIC b issued to the applicant for the areas and reason indicated in the section above.</td>
            </tr>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnAsicConfirm">Confirm</button>
    </div>
</div>
<button id="btnActivate" style="display: none;"></button>
<script type="text/javascript">
    function vicHolderDeclarationChange() {
        if ($("#refusedAsicCbx").is(':checked') && $('#issuedVicCbx').is(':checked')) {
            $('#VivHolderDecalarations').prop('checked', true);
        } else {
            $('#VivHolderDecalarations').prop('checked', false);
        }
        $('#vicHolderModal').modal('hide');

        return false;
    }

    function asicSponsorDeclarationChange() {
        if ($("#asicDecalarationCbx4").is(':checked') && $('#asicDecalarationCbx3').is(':checked') && $('#asicDecalarationCbx2').is(':checked') && $('#asicDecalarationCbx1').is(':checked')) {
            $('#AsicSponsorDecalarations').prop('checked', true);
        } else {
            $('#AsicSponsorDecalarations').prop('checked', false);
        }
        $('#asicSponsorModal').modal('hide');
        return false;
    }
</script>
