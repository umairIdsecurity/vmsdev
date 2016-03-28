<?php
$session = new CHttpSession;

$identification_document_expiry = date('Y-m-d', strtotime($visitorModel->identification_document_expiry));
$asicEscort = new AddAsicEscort();

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
    <?php 
    
    if (in_array($model->card_type, [CardType::VIC_CARD_EXTENDED]) && $model->visit_status == VisitStatus::AUTOCLOSED): ?>
    <tr><td><div class="label label-warning" style=" width: 220px;word-wrap: break-word;white-space: pre;
                 "> Another visit can not be activated <br> until this EVIC expires. Please reprint <br> this EVIC if continuing visit.</div></td></tr>
    <?php elseif(in_array($model->card_type, [CardType::VIC_CARD_24HOURS]) && $model->visit_status == VisitStatus::AUTOCLOSED): ?>
    <tr><td><div class="label label-warning" style=" width: 220px;word-wrap: break-word;white-space: pre;">Another visit can not be activated<br> until this card expires.</div></td></tr>
    <?php endif; ?>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <?php if (!in_array($model->visit_status, [VisitStatus::AUTOCLOSED,VisitStatus::CLOSED])): ?>
    <tr>
        <td class="vic-col">
            <input type="checkbox" value="1" name="VicHolderDecalarations" disabled="disabled" id="VicHolderDecalarations" class="vic-active-visit vic-active-declarations"/>
            <a href="#vicHolderModal" data-toggle="modal">VIC Holder Declarations</a>
        </td>
    </tr>
    <tr>
        <td class="vic-col">
            <input type="checkbox" value="1" name="AsicSponsorDecalarations" disabled="disabled" id="AsicSponsorDecalarations" class="vic-active-visit vic-active-declarations"/>
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
            <input type="checkbox" <?php echo ($model->reason > 0 || $model->visit_reason != NULL) ? 'checked="checked"' : '';?> value="1" name="reasonActiveVisit" id="reasonActiveVisit" class="vic-active-visit vic-active-verification"/>
            <a href="javascript:void(0)" style="text-decoration: none !important;">Visit Reason</a> <br>
            <div style="display:none; margin-top: 4px" id="visit_reason_checkbox_error" class="errorMessage">Please tick Visit Reason</div>
        </td>
    </tr>
    <tr>
        <td class="vic-col">
            <input type="checkbox" disabled value="1" name="identificationActiveVisit" class="vic-active-visit vic-active-verification"/>
            <a href="#identificationModal" data-toggle="modal" id="identificationActiveVisitLink" style="text-decoration: underline !important;">Identification</a>
        </td>
    </tr>
    <tr>
        <!-- introduced because of CAVMS-1039 -->
        <?php if($model->visit_status == VisitStatus::PREREGISTERED): ?>
            <td class="vic-col">
                <input type="checkbox" value="1" name="asicSponsorActiveVisit" class="vic-active-visit vic-active-verification" id="asicSponsorActiveVisitLink"/>
                <a href="#" style="text-decoration: none !important;">ASIC Sponsor/Escort</a>
            </td>
        <?php else: ?>
            <td class="vic-col">
                <input type="checkbox" <?php echo $model->getAsicSponsor() ? 'checked="checked" disabled="disabled"' : '';?> value="1" name="asicSponsorActiveVisit" class="vic-active-visit vic-active-verification" id="asicSponsorActiveVisitLink"/>
                <a href="#" style="text-decoration: none !important;">ASIC Sponsor/Escort</a>
            </td>
        <?php endif; ?>
    </tr>
    
    <?php endif; ?>
    <tr>
        <td>&nbsp;</td>
    </tr>

    <tr>
        <td>Check In Time</td>
    </tr>
    <tr>
        <td>
            <?php echo $logform->timeField($model,'time_check_in',[]) ?>
        </td>
    </tr>

    <tr>
        <td>Check In Date</td>
    </tr>
    <tr>
        <td>
            <input name="Visit[visit_status]" id="Visit_visit_status" type="text" value="1" style="display:none;">
            <?php echo $logform->dateField($model,'date_check_in',[]); ?>
        </td>
    </tr>

    <tr id="dateoutDiv" <?php echo $model->card_type == CardType::VIC_CARD_SAMEDATE ? 'style="display:none;"' : '' ?>>
        <td>Check Out Date
            <br>
            <?php echo $logform->dateField($model,'date_check_out',[]); ?>
            <?php echo $logform->dateRangeManager($model,'date_check_in','date_check_out',$model->getDateRangeOptions()); ?>
            <br>
            <span id="checkout_date_warning" style="display: none;" class="label label-warning"></span>
        </td>
    </tr>

    <?php if($model->card_type == CardType::VIC_CARD_MANUAL && $model->visit_status!=VisitStatus::CLOSED) : ?>
    <tr>
        <td>
            <div id="card_no_manual">
                Pre Issued Card No.
                <br>
                <input name="pre_issued_card_no" id="pre_issued_card_no" class="" type="text" placeholder="Enter Card No."
                    <?php if($logform->readOnly){echo "disabled='disabled'";} ?>
                >

                <span class="required">*</span>
                <div style="display: none" id="card_number_required" class="errorMessage">Please enter a Card Number</div>
            </div>
        </td>
    </tr>
    <?php endif; ?>

</table>
<script>

    $(document).ready(function() {


        var dateIn =  $("#dateoutDiv #Visit_date_check_in_container");
        var dateOut =  $("#dateoutDiv #Visit_date_check_out_container");
        var boundControl =  dateIn?dateOut:dateIn;

        if(boundControl){

            boundControl.change(function(){

                var dateIn =  $("#dateoutDiv #Visit_date_check_in_container");
                var dateOut =  $("#dateoutDiv #Visit_date_check_out_container");
                var boundControl =  dateIn?dateOut:dateIn;
                var selectedDate = boundControl.datepicker('getDate');
                var cardDate = $.datepicker.formatDate('dd M y', selectedDate);

                $("#cardDateText").html(cardDate);
                $("#cardDetailsTable span.cardDateText").html(cardDate);
                $('#CardGenerated_date_expiration').val(selectedDate);

            });

        }

        //var cardType = "<?php echo $model->card_type; ?>";



        // set the 

        // Expected: Today's date should not be to select for Auto Closed visits for 24 hour & EVIC.
//        if( $("#visitStatus").val() == 6) {
//           switch(cardType) {
//               case "6": // 24 Hour VIC
//                    minDate = 1;
//                    break;
//                case "7": // Evic
//                    minDate = 1;
//                    break;
//                default:
//                    minDate = 0;
//                    break;
//            }
//        }


//        dateCheckInPicker.datepicker('option', {
//            minDate: minDate,
//            dateFormat: "dd/mm/yy",
//            onClose: function (selectedDate) {
//
//                console.log('updated check in date picker');
//
//                var currentDate = d.getDate() + '-0' + (d.getMonth() + 1) + '-' + d.getFullYear();
//                var checkInSelectedDate = $("#Visit_date_check_in_container").datepicker('getDate');
//
//                switch (cardType) {
//                    case "<?php //echo CardType::VIC_CARD_EXTENDED; ?>//":
//                    case "<?php //echo CardType::VIC_CARD_MULTIDAY; ?>//":
//                        var checkOutDate = new Date(checkInSelectedDate);
//                        checkOutDate.setDate(checkOutDate.getDate() + <?php //echo $visitCount['remainingDays'];?>//);
//                        $("#dateoutDiv #Visit_date_check_out_container").datepicker("option", "minDate", checkInSelectedDate);
//                        $("#dateoutDiv #Visit_date_check_out_container").datepicker("option", "maxDate", checkOutDate);
//                        $("#dateoutDiv #Visit_date_check_out_container").datepicker("setDate", checkOutDate);
//                        break;
//                    case "<?php //echo CardType::VIC_CARD_MANUAL; ?>//":
//                        $("#dateoutDiv #Visit_date_check_out_container").datepicker("setDate", checkInSelectedDate);
//                        break;
//                    case "<?php //echo CardType::VIC_CARD_24HOURS; ?>//":
//                        var checkOutDate = new Date(checkInSelectedDate);
//                        checkOutDate.setDate(checkOutDate.getDate() + 1);
//                        $("#dateoutDiv #Visit_date_check_out_container").datepicker("setDate", checkOutDate);
//                        $("#registerNewVisit").removeAttr("disabled");
//                        /* Can be preregistered */
//                        break;
//                    default:
//                        $("#dateoutDiv #Visit_date_check_out_container").datepicker("option", "minDate", checkInSelectedDate);
//                        $("#dateoutDiv #Visit_date_check_out_container").datepicker("setDate", checkInSelectedDate);
//                        break;
//                }
//
//                $('#CardGenerated_date_expiration').val($("#dateoutDiv #Visit_date_check_out_container").datepicker("getDate"));
//
//                var currentDate2 = new Date();
//                var sD = selectedDate.split("-");
//                var dSelected = new Date(sD[2] + '-' + sD[1] + '-' + sD[0]);
//                if (dSelected >= currentDate2) {
//                    if (sD[2] == d.getFullYear() && sD[1] == (d.getMonth() + 1) && sD[0] == d.getDate()) {
//                        updateTextVisitButton("Activate Visit", "registerNewVisit", "active");
//                        // Preregistered visits can be activated if someone selects todays date to activate
//                        $("#registerNewVisit").removeAttr("disabled");
//                    } else {
//                        updateTextVisitButton("Preregister Visit", "preregisterNewVisit", "preregister");
//                        var status = "<?php //echo $model->visit_status; ?>//";
//
//                    }
//                    // update card date
//                    var cardDate = $.datepicker.formatDate('dd M y', checkInSelectedDate);
//                    $("#cardDetailsTable span.cardDateText").html(cardDate);
//
//                } else {
//
//                    if (cardType == '<?php //echo CardType::VIC_CARD_MANUAL; ?>//' && (dSelected.getDate() < currentDate2.getDate() || dSelected.getMonth() < currentDate2.getMonth() )) {
//                        updateTextVisitButton("Back Date Visit", "backDateVisit", "backdate");
//                    } else {
//                        updateTextVisitButton("Activate Visit", "registerNewVisit", "active");
//                        $("#registerNewVisit").removeAttr("disabled");
//                    }
//                    $('#card_no_manual').show();
//                }
//            }
//        });



//        if(!dateCheckOutPicker.datepicker('option','dateFormat')){
//            dateCheckOutPicker.datepicker();
//        }
        var dateCheckOutPicker = $("#dateoutDiv #Visit_date_check_out_container");
        $('#CardGenerated_date_expiration').val(dateCheckOutPicker.datepicker( "getDate"));

//        dateCheckOutPicker.datepicker('option', {
//            dateFormat: "dd/mm/yy",
//            minDate: minDate,
//            maxDate: <?php //echo $visitCount['remainingDays'];?>//,
//            disabled: <?php //echo in_array($model->card_type, [CardType::VIC_CARD_24HOURS, CardType::VIC_CARD_MANUAL]) ? "true" : "false"; ?>//,
//            onClose: function (selectedDate) {
//                var day = selectedDate.substring(0, 2);
//                var month = selectedDate.substring(3, 5);
//                var year = selectedDate.substring(6, 10);
//                var newDate = new Date(year, month - 1, day);
//                var cardDate = $.datepicker.formatDate('dd M y', newDate);
//                $("#cardDetailsTable span.cardDateText").html(cardDate);
//                $('#CardGenerated_date_expiration').val(selectedDate);
//            }
//        });


        // Enable Today button to select and auto enter Todays date
        var _gotoToday = jQuery.datepicker._gotoToday;
        jQuery.datepicker._gotoToday = function(a){
            var target = jQuery(a);
            var inst = this._getInst(target[0]);
            _gotoToday.call(this, a);
            jQuery.datepicker._selectDate(a, jQuery.datepicker._formatDate(inst,inst.selectedDay, inst.selectedMonth, inst.selectedYear));
        };

    });

    function updateTextVisitButton(buttonText, id, vall) {
     $("#registerNewVisit").text(buttonText).val(vall);
    }


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
                <td><label for="refusedAsicCbx">The applicant declares they have not been refused or held an ASIC that was suspended or cancelled due to an adverse criminal record</label></td>
            </tr>
            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
            <tr>
                <td width="5%"><input type="checkbox" id="issuedVicCbx"/></td>
                <td><label for="issuedVicCbx">The applicant declares they have not been issued with a VIC for this airport for more than 28 days in the past 12 months.
<!--                    (from <?php
//                            if (isset($model->date_check_in)) {
//                                echo $model->date_check_in;
//                            } else {
//                                echo date("d F Y");
//                            }
                    ?>)-->
                </label></td>
            </tr>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" onClick="vicCheck(true)" class="btn btn-primary complete" id="btnVicConfirm" style="width: auto !important; height: auto !important;">Confirm</button>
    </div>
</div>

<!-- ASIC SPONSOR Declarations Modal -->
<div id="asicSponsorModal" class="modal hide fade" role="dialog" aria-labelledby="AsicSponsorDeclarations" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>ASIC Sponsor Declarations</h3>
    </div>
    <div class="modal-body">
        <table>
            <tr>
                <td width="5%"><input type="checkbox" id="asicDecalarationCbx1"/></td>
                <td><label for="asicDecalarationCbx1">I confirm that the VIC holders details are correct. I have read, understood and agree to ensure that the applicant will abide by the conditions applicable to the use of the Visitor Identification Card.</label></td>
            </tr>
            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
            <tr>
                <td width="5%"><input type="checkbox" id="asicDecalarationCbx2"/></td>
                <td><label for="asicDecalarationCbx2">I understand that it is an offence to escort/sponsor someone airside without a valid operational reason for them to require access.</label></td>
            </tr>
            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
            <tr>
                <td width="5%"><input type="checkbox" id="asicDecalarationCbx3"/></td>
                <td><label for="asicDecalarationCbx3">I request that a VIC be issued to the applicant for the areas and reason indicated.</label></td>
            </tr>

            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
            <tr>
                <td></td>
                <td><strong>Verify today’s ASIC Escort - Please select one of the following options</strong>
                    <hr style="border-color: black;"></td>
            </tr>
            <tr>
                <td width="5%"><input type="radio" id="asicDecalarationRbtn1" name="asicDecalarationRbtn" onclick="asicEscortDefault()"/></td>
                <td><label for="asicDecalarationRbtn1">I <strong><?= $asic->first_name." ".$asic->last_name ?></strong> note that they must be under my direct supervision at all times whilst they are airside.</label></td>
            </tr>
            <tr><td>Or</td><td>&nbsp;</td></tr>
            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
            <tr>
                <td width="5%"><input type="radio" id="asicEscortRbtn" name="asicDecalarationRbtn" onclick="asicEscort()"/></td>
                <td><label for="asicEscortRbtn">Another ASIC holder will be supervising on this visit. Please add or search for another ASIC Escort.</label></td>
            </tr>

            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
            <tr class="asic-escort hidden">
                <td></td>
                <td>
                    <input type="text" id="search-escort" style="width:293px" name="search-host"
                           placeholder="Search ASIC Sponsors by name, email or ASIC no." class="search-text"/>
                    <button type="button" class="btn btn-primary neutral" id="findEscortBtn" style="margin-bottom: 14px!important;width: auto !important; height: auto !important;" onclick="" id="escort-findBtn">Search ASIC Escort</button>
                    <div id="divMsg" style="display:none;">
                        <img id="findEscortBtn" src="<?php echo Yii::app()->controller->assetsBase; ?>/images/loading.gif" alt="Please wait.." />
                    </div>
                    <div class="errorMessage" id="searchEscortErrorMessage" style=" display:none;">Search cannot be blank</div>
                    <div class="searchAsicEscortResult"></div>
                    <div class="add-esic-escort">
                        <?php $this->renderPartial('_add_asic_escort',array('model' => $asicEscort, 'session' => $session,)) ?>
                    </div>
                    <input type="hidden" id="selectedAsicEscort"/>
                </td>
            </tr>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary complete" id="btnAsicConfirm" style="width: auto !important; height: auto !important;">Confirm</button>
    </div>
</div>


<button id="btnActivate" style="display: none;"></button>
<script type="text/javascript">
    function vicHolderDeclarationChange() {
        if ($("#refusedAsicCbx").is(':checked') && $('#issuedVicCbx').is(':checked')) {
            $('#VicHolderDecalarations').prop('checked', true);
        } else {
            $('#VicHolderDecalarations').prop('checked', false);
        }
        $('#vicHolderModal').modal('hide');
    }

    function asicSponsorDeclarationChange(asicCheck) {
        if(asicCheck == true) {
            $('#searchEscortErrorMessage').hide();
            $('#AsicSponsorDecalarations').prop('checked', true);
            $('#asicSponsorActiveVisitLink').prop('checked', true);
            $('#asicSponsorModal').modal('hide');
        } else{
            $('#AsicSponsorDecalarations').prop('checked', false);
            $('#asicSponsorActiveVisitLink').prop('checked', false);
        }
    }

    function vicCheck(validate) {
        var checknum = $('#vicHolderModal').find('input[type="checkbox"]').filter(':checked');
        if (checknum.length == 2) {
            vicHolderDeclarationChange();
            return true;
        } else {
            if (validate == true) {
                alert('Please select all the declarations.');
            }
            return false;
        }
    }

    function asicCheck(validate) {
        var checknum = $('#asicSponsorModal')
            .find('input[type="checkbox"]')
            .filter(':checked');
        if (checknum.length == 3) {
            if($('#asicEscortRbtn').is(':checked')){
                var checkAsicEscortType = validateAsicEscort();
                if(checkAsicEscortType == true) {
                    asicSponsorDeclarationChange(true);
                    return true;
                } else {
                    alert('Please input correct ASIC Escort profile.');
                    asicSponsorDeclarationChange(false);
                    return false;
                }
            } else if ($('#asicDecalarationRbtn1').is(':checked')) {
                asicSponsorDeclarationChange(true);
                return true;
            } else {
                alert('Please select all the declarations.');
                asicSponsorDeclarationChange(false);
                return false;
            }
        } else {
            alert('Please select all the declarations.');
            asicSponsorDeclarationChange(false);
            return false;
        }
    }

    function asicEscort() {
        $('.asic-escort').removeClass('hidden');

    }
    function asicEscortDefault() {
        $('.asic-escort').addClass('hidden');

    }

    function checkEscortEmailUnique () {
        if(validateAsicEscort() == true ) {
            var email = $('#AddAsicEscort_email').val();
            $.ajax({
                type: "POST",
                url: "<?php echo CHtml::normalizeUrl(array("visitor/checkAsicEscort")); ?>",
                data: {emailEscort: email},
                success: function(data) {
                    if(data == 'existed') {
                        $('#AddAsicEscort_email_unique_em_').show();
                        asicSponsorDeclarationChange(false);
                        return;
                    } else {
                        $('#AddAsicEscort_email_unique_em_').hide();
                        if(asicCheck() == true ) {
                            confirmed = true;
                            $('#identificationModal').modal('show');
                        } else {
                            asicSponsorDeclarationChange(false);
                        }
                    }
                }
            });
        }
    }

    function validateAsicEscort() {
        var noError = true;
        if ($('#asicEscortRbtn').is(':checked') == true) {
            if ($('.add-esic-escort').css('display') == 'block') {
                if($('#AddAsicEscort_company').val() == "") {
                    $('#AddAsicEscort_company_em_').html('Please Select a Company');
                    $('#AddAsicEscort_company_em_').show();
                    noError = false;
                }
                $('.asic-escort-field .errorMessage ').each(function () {
                    if ($(this).css('display') == 'block') {
                        noError = false;
                    }
                });
                $('.asic-escort-field input').each(function () {
                    if ($(this).val() == '') {
                        var error = '#' + $(this).attr('id') + '_em_';
                        var placeholder = $(this).attr('placeholder');
                        if(placeholder == 'ASIC No' ||placeholder == 'Expiry' ||placeholder == 'Email Address') {
                            $(error).html('Please enter an ' + placeholder);
                        } else {
                            $(error).html('Please enter a ' + placeholder );
                        }

                        $(error).show();
                        noError = false;
                    }
                });
            } else if ($('.searchAsicEscortResult').css('display') == 'block' && $('#selectedAsicEscort').val() == '') {
                noError = false;
            }
        }
        if(noError == false) {
            asicSponsorDeclarationChange(false);
        }
        return noError;
    }

    function isExpired() {
        var dt = new Date();
        var dd = dt.getDate();
        var mm = dt.getMonth()+1; //January is 0!
        var yyyy = dt.getFullYear();
        var document_expiry_date = Date.parse("<?php echo $identification_document_expiry; ?>");
        var today = Date.parse(yyyy+'-'+mm+'-'+dd);
        return document_expiry_date <= today;
    }

    function activeVisit() 
    {
        var photoReview = $('#photoPreview').attr('src');
        var isDefault = photoReview.search('images/companylogohere1.png');
        var VisitorPhotoID =  $("#Visitor_photo").val(); 
        // Stop active visit if image is not uploaded
        //24Hours Visit Image is also not necessary because of https://ids-jira.atlassian.net/browse/CAVMS-1036
        if  (
                ((photoReview == '' || isDefault > 0) && VisitorPhotoID == "") &&
                $("#Visit_card_type").val() != <?php echo CardType::SAME_DAY_VISITOR; ?> &&
                $("#Visit_card_type").val() != <?php echo CardType::MANUAL_VISITOR; ?> &&
                $("#Visit_card_type").val() != <?php echo CardType::VIC_CARD_24HOURS; ?> &&
                $("#Visit_card_type").val() != <?php echo CardType::VIC_CARD_SAMEDATE; ?> &&
                $("#Visit_card_type").val() != <?php echo CardType::VIC_CARD_MANUAL; ?>
            ) 
        {  
            <?php if ($model->card_type > CardType::CONTRACTOR_VISITOR ) : ?>
                <?php if(!in_array($model->card_type, [CardType::VIC_CARD_24HOURS, CardType::VIC_CARD_SAMEDATE, CardType::VIC_CARD_MANUAL])) : ?>
                    $("#Visitor_photo_em").attr('style', 'margin-right:84px ; margin-bottom:0px; margin-top:0px ;');
                    $("#editImageBtn.editImageBtn").attr('style', 'margin-top:-5px !important; margin-right:84px ; margin-bottom:0px;');
                    $("#cropImageBtn.editImageBtn").attr('style', 'margin-top:-5px !important; margin-right:84px ; margin-bottom:0px;');
                <?php endif; ?>
            <?php else : ?>
                <?php if(!in_array($model->card_type, [CardType::SAME_DAY_VISITOR, CardType::MANUAL_VISITOR])) : ?>
                    $("#Visitor_photo_em").attr('style', 'margin-bottom: -17px; margin-right: 0px; margin-top: 13px;');
                    $("#cropImageBtn.editImageBtn").attr('style', 'margin-bottom: 0; margin-right: 0 !important; margin-top: 0 !important;');
                <?php endif; ?>
            <?php endif; ?>
            return false;
        }

        var status = "<?php echo $model->visit_status; ?>";
        if (status == "<?php echo VisitStatus::SAVED; ?>" || status == "<?php echo VisitStatus::PREREGISTERED; ?>") {
            checkIfActiveVisitConflictsWithAnotherVisit();
        } else {
            checkIfActiveVisitConflictsWithAnotherVisit('new');
        }
    }

    $(document).ready(function(){
        $('#asicDecalarationRbtn1').on('click',function(){
            $(this).prop('checked',true);
            $('#asicEscortRbtn').prop('checked',false);
        });
        $('#asicEscortRbtn').on('click',function(){
            $(this).prop('checked',true);
            $('#asicDecalarationRbtn1').prop('checked',false);
        });
        $('#findEscortBtn').on('click', function(){
            if($('#search-escort').val() == ''){
                $('#searchEscortErrorMessage').show();
                return;
            } else {
                $('#searchEscortErrorMessage').hide();
                $('.searchAsicEscortResult').show();
                $(this).hide();
                $('#divMsg').show();
                $('.add-esic-escort').hide();
                var searchInfo = $('#search-escort').val();
                var searchAsicEscortResult = $('.searchAsicEscortResult').empty();
                $.ajax({
                    type: "GET",
                    url: "<?php echo CHtml::normalizeUrl(array('visitor/getAsicEscort')); ?>",
                    data: {"searchInfo":searchInfo},
                    success: function(data) {
                        console.log(data);
                        /*if (data.indexOf("Visitor Management System  - Login") > -1) {
                            window.location = "<?php echo Yii::app()->createUrl('site/login');?>";
                        }*/
                        searchAsicEscortResult.append(data);
                        $('#findEscortBtn' ).show();
                        $('#divMsg').hide();
                    }
                }).fail(function() {
                    alert("Something went wrong. Please, try again.");
                    /*window.location = "<?php echo Yii::app()->createUrl('site/login');?>";*/
                });
            }
        });

        $('#btnAsicConfirm').on('click',function(){
            if ($('#asicEscortRbtn').is(':checked')) {
                checkEscortEmailUnique();
            } else {
                $("#asicSponsorModal").modal('hide');
                $('#AsicSponsorDecalarations').prop('checked', true);
                // if (asicCheck()) {
                //     if (!$('input[name="identificationActiveVisit"]').is(':checked')) {
                //         $('#identificationModal').modal('show');
                //     } else if ($('#VicHolderDecalarations').is(':checked')) {
                //         activeVisit();
                //         return false;
                //     }
                // } else {
                //     return false;
                // }
            }
        });

        $('#AddAsicEscort_email').on('change',function(){
            $('#AddAsicEscort_email_unique_em_').hide();
        });
        $('#addCompanyLink').on('click',function(){
            $('#asicSponsorModal').modal('hide');
        });

        $('#btnCloseModalAddCompanyContact').on('click',function(){
            $("#asicSponsorModal").modal("show");
        });
    });
    
    /**
    * Checkbox: Visit Reason
    * A visit reason must be selected before checking this checkbox
     */
   $("#reasonActiveVisit").change(function() {
        if( $(this).is(":checked") ) {
            if($("#Visit_reason").val() == "") {
                alert("Please Select a Visit Reason First");
                $("#visit_reason_dropdown_error").show();
                $(this).prop("checked", false);
                $("#Visit_reason").focus();
                return false;
            } else {
                $("#visit_reason_dropdown_error").hide();
            }
        }
     });
     
</script>
