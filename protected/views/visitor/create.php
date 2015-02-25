<?php
/* @var $this VisitorController */
/* @var $model Visitor */
$session = new CHttpSession;
?>
<input type="text" id="getcurrentUrl" value="<?php
if ((isset($_GET['p']) && !isset($_GET['action'])) || !isset($_GET['action'])) {
    if (isset($_GET['p'])) {
        echo $_GET['p']; //check if preregister page
    } else {
        echo "1";
    }
} else {
    echo "";
}
?>" style="display:none;">
<h1><?php
    if (isset($_GET['action'])) {
        if($_GET['action'] == 'register'){
            echo "Register";
            $session['previousVisitAction'] = 'Register';
        } else {
            echo "Preregister";
            $session['previousVisitAction'] = 'Preregister';
        }
        
    }
    ?> a Visit</h1>

<dl class="tabs <?php if (!isset($_GET['action'])) { ?> four-up <?php
} else {
    echo 'three-up';
}
?>">
    <dt id="selectCardA" style="display:none;" class="borderTopLeftRadius">Select Card Type</dt>
    <dd class="active borderTopLeftRadius" id="selectCard" >
        <a href="#step1" id="selectCardB" class="borderTopLeftRadius">Select Card Type</a>
    </dd>
    <dt id="findVisitorA">Find or Add New Visitor Record</dt>
    <dd style="display:none;" id="findVisitor"><a href="#step2" id="findVisitorB">Find or Add New Visitor Record</a></dd>

    <dt id="findHostA" <?php if (isset($_GET['action'])) {
    ?> 
            class="borderTopLeftRadius" 
        <?php } ?>>Find or Add Host</dt>

    <dd style="display:none;" <?php
    if (isset($_GET['action'])) {
        echo "class='borderTopRightRadius'";
    }
    ?>" id="findHost">
        <a href="#step3" id="findHostB" <?php if (isset($_GET['action'])) { ?> class="borderTopRightRadius" <?php } ?>>Find or Add Host</a>
    </dd>
    <?php if (!isset($_GET['action'])) { ?>
        <dt id = "logVisitA" class="borderTopRightRadius">Log Visit</dt>
        <dd style = "display:none;" id="logVisit" class="borderTopRightRadius">
            <a href = "#step4" id = "logVisitB" class="borderTopRightRadius">Log Visit</a>
        </dd>
    <?php }
    ?>
</dl>


<ul class="tabs-content">
    <li class="active" id="stepTab">
        <?php $this->renderPartial('selectCardType', array('model' => $model)); ?>

        <input type="hidden" id="cardtype"/>
    </li>
    <li id="step2Tab">
        <?php $this->renderPartial('findAddVisitorRecord', array('model' => $model, 'reasonModel' => $reasonModel)); ?>
    </li>
    <li id="step3Tab">
        <?php $this->renderPartial('findAddHostRecord', array('userModel' => $userModel, 'patientModel' => $patientModel)); ?>
        <?php $this->renderPartial('visitForm', array('visitModel' => $visitModel)); ?>
    </li>
    <li id="step4Tab">
        <?php $this->renderPartial('logvisit', array('visitModel' => $visitModel)); ?>
    </li>
</ul>
<input type="text" style="display:none;" id="createUrlForEmailUnique" value="<?php echo Yii::app()->createUrl('user/checkEmailIfUnique&id='); ?>"/>

<input type="text" id="currentRoleOfLoggedInUser" value="<?php echo $session['role']; ?>">
<input type="text" id="currentCompanyOfLoggedInUser" value="<?php echo User::model()->getCompany($session['id']); ?>">
<script>

    $(document).ready(function() {
        display_ct();
        $("#register-host-patient-form").hide();
        $("#register-host-form").show();
        $("#searchHostDiv").show();
        // document.getElementById('Visitor_company').disabled = true;
        if ($("#currentRoleOfLoggedInUser").val() == 9) { //if staffmember logged in user
            $("#Visit_visitor_type").val(2);
            $("#Visitor_company").val($("#currentCompanyOfLoggedInUser").val());
            $("#Visitor_visitor_type").val(2);
            $("#Visitor_visitor_type_search").val(2);
            //  $('#Visitor_visitor_type option[value!="2"]').remove();
            //$('#Visitor_visitor_type_search option[value!="2"]').remove();
            document.getElementById('Visitor_company').disabled = false;
            $("#register-host-patient-form").hide();
            $("#register-host-form").hide();
            $("#searchHostDiv").show();
            $("#currentHostDetailsDiv").show();
        }

        if ($("#currentRoleOfLoggedInUser").val() != 5) { //not superadmin

            $("#Visitor_tenant").val('<?php echo $session['tenant']; ?>');
            $("#User_tenant").val('<?php echo $session['tenant']; ?>');
            $("#Visitor_tenant_agent").val('<?php echo $session['tenant_agent']; ?>');
            $("#User_tenant_agent").val('<?php echo $session['tenant_agent']; ?>');

            /*check if current logged in role is staff member
             * if staff member check if tenant agent admin is null
             * if null populate company by tenant
             * else if not null populate company by tenant and tenant agent
             */

            $('#Visitor_company option[value!=""]').remove();
            if ($("#currentRoleOfLoggedInUser").val() != 5) { //not superadmin
                if ($("#Visitor_tenant_agent").val() == '') {
                    getCompanyWithSameTenant($("#Visitor_tenant").val());
                } else {
                    getCompanyWithSameTenantAndTenantAgent($("#Visitor_tenant").val(), $("#Visitor_tenant_agent").val());
                }

                if ($("#User_tenant_agent").val() == '') {
                    getHostCompanyWithSameTenant($("#User_tenant").val());
                } else {
                    getHostCompanyWithSameTenantAndTenantAgent($("#User_tenant").val(), $("#User_tenant_agent").val());
                }
            }
        }

        $('#Visitor_visitor_type').on('change', function(e) {
            if ($("#currentRoleOfLoggedInUser").val() == 5) {
                $('#Visitor_company option[value!=""]').remove();
                $('#Visitor_tenant_agent option[value!=""]').remove();
                $('#Visitor_tenant').val("");
            }

            if ($(this).val() == "1") {
                $("#register-host-patient-form").show();
                $("#register-host-form").hide();
                document.getElementById('Visitor_company').disabled = true;
            } else {
                $("#register-host-patient-form").hide();
                $("#register-host-form").show();
                document.getElementById('Visitor_company').disabled = false;
            }

        });
        $("#clicktabA").click(function(e) {
            e.preventDefault();
            showHideTabs('findVisitorB', 'findVisitorA', 'findVisitor', 'selectCardA', 'selectCard', 'findHostA', 'findHost');
        });

        $("#clicktabB").click(function(e) {
            e.preventDefault();
            $(".visitorReason").hide();
            if ($("#Visitor_visitor_type").val() == 1 || $("#Visitor_visitor_type_search").val() == 1) {
                $("#findHostA").html("Add Patient Details");
                $("#findHostB").html("Add Patient Details");
            } else {
                $("#findHostA").html("Find or Add Host");
                $("#findHostB").html("Find or Add Host");
            }
            showHideTabs('findHostB', 'findHostA', 'findHost', 'findVisitorA', 'findVisitor', 'selectCardA', 'selectCard');

        });

        $("#clicktabB1").click(function(e) {
            e.preventDefault();
            $("#register-reason-form").hide();
            var visit_reason = $("#Visit_reason_search").val();

            if (($("#selectedVisitorInSearchTable").val() == '' && $("#search-visitor").val() != '') || $("#selectedVisitorInSearchTable").val() == '') {
                $("#searchTextErrorMessage").html("Please select a visitor.");
                $("#searchTextErrorMessage").show();
            }
            else if (visit_reason == '' || visit_reason == 'undefined' || (visit_reason == 'Other' && $("#VisitReason_reason_search").val() == ''))
            {
                $("#search-visitor-reason-error").show();
            } else if ($("#workstation_search").val() == '') {

                $(".errorMessageWorkstationSearch").show();
            }
            else {
                $(".errorMessageWorkstationSearch").hide();
                $("#searchTextErrorMessage").hide();
                $("#search-visitor-reason-error").hide();
                checkReasonIfUnique();
                //showHideTabs('findHostB', 'findHostA', 'findHost', 'findVisitorA', 'findVisitor', 'selectCardA', 'selectCard');
            }
        });

        $("#clicktabB2").click(function(e) {
            e.preventDefault();
            //var currentURL = location.href.split("=");
            var currentURL = $("#getcurrentUrl").val();

            $("#Visit_visitor_type").val($("#Visitor_visitor_type").val());
            //checks if host is from search and verifys that a user has been selected
            if (($("#selectedHostInSearchTable").val() == '' && $("#search-host").val() != '') || $("#selectedHostInSearchTable").val() == '') {
                $("#searchTextHostErrorMessage").html("Please select a host.");
                $("#searchTextHostErrorMessage").show();
                //alert("host from search");
            } else if (currentURL != "") {
                showHideTabs("logVisitB", "logVisitA", "logVisit", "findHostA", "findHost", "findVisitorA", "findVisitor");
                // alert("preregister");
            } else if ($("#selectedVisitorInSearchTable").val() != '0') { // if visitor is from search

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
        });

        $("#clicktabC").click(function(e) {
            e.preventDefault();
            if ($("#selectedVisitorInSearchTable").val() != '0') { // if visitor is from search
                $("#submitFormUser").click();
                $("#submitFormUser").show();
                $("#clicktabC").hide();
            } else
            {
                $("#clicktabB").hide();
                $("#submitFormVisitor").click();
                $("#submitFormVisitor").show();
            }
        });

        $("#dummy-submitFormPatientName").click(function(e) {
            e.preventDefault();
            if ($("#selectedVisitorInSearchTable").val() != '0') { //if visitor is from search
                $("#submitFormPatientName").click();
                $("#submitFormPatientName").show();
                $("#dummy-submitFormPatientName").hide();
            }
            else
            {
                $("#clicktabB").hide();
                $("#submitFormVisitor").click();
                $("#submitFormVisitor").show();
            }
        });

        $(".btnBackTab2").click(function(e) {
            e.preventDefault();
            showHideTabs('selectCardB', 'selectCardA', 'selectCard', 'findVisitorA', 'findVisitor', 'findHostA', 'findHost');
            hidePreviousPage('step2Tab', 'stepTab');
        });
        $(".btnBackTab3").click(function(e) {
            e.preventDefault();
            showHideTabs('findVisitorB', 'findVisitorA', 'findVisitor', 'selectCardA', 'selectCard', 'findHostA', 'findHost');
            hidePreviousPage('step3Tab', 'stepTab2');
        });
        $(".btnBackTab4").click(function(e) {
            e.preventDefault();
            showHideTabs('findHostB', 'findHostA', 'findHost', 'selectCardA', 'selectCard', 'logVisitA', 'logVisit');
            hidePreviousPage('step4Tab', 'stepTab3');
        });
        function showHideTabs(showThisId, hideThisId, showThisRow, hideOtherA, showOtherRowA, hideOtherB, showOtherRowB) {
            $("#" + showThisId).click(); // findvisitorB dt
            $("#" + showThisId).show(); //findvisitorB dt
            $("#" + showThisRow).show(); //findVisitor dd
            $("#" + hideThisId).hide(); //findvisitor a dt

            $("#" + hideOtherA).show(); //selectcardtype dd
            $("#" + showOtherRowA).hide(); //selectcardtype dd

            $("#" + hideOtherB).show(); //selectcardtype dd
            $("#" + showOtherRowB).hide(); //selectcardtype dd
        }

        function hidePreviousPage(hideThisLiId, showThisLiId) {
            $("#" + hideThisLiId).hide();
            $("#" + showThisLiId).show();
        }
    }
    );

    function closeAndPopulateField(id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/getVisitorDetails&id='); ?>' + id,
            dataType: 'json',
            data: id,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    $("#searchVisitorTableDiv h4").html("Selected Visitor Record : " + value.first_name + ' ' + value.last_name);
                    checkIfVisitorHasACurrentSavedVisit(value.id);
                });
                $('#findVisitorTableIframe').contents().find('.findVisitorButtonColumn a').removeClass('delete');
                $('#findVisitorTableIframe').contents().find('.findVisitorButtonColumn a').html('Select Visitor');
                $('#findVisitorTableIframe').contents().find('#' + id).addClass('delete');
                $('#findVisitorTableIframe').contents().find('#' + id).html('Selected Visitor');
                $('#findVisitorTableIframe').contents().find('.findVisitorButtonColumn .linkToVisitorDetailPage').html('Visitor has an active visit');

            }
        });

        $("#visitor_fields_for_Search").show();
        $("#selectedVisitorInSearchTable").val(id);
        $("#visitorId").val(id);
        $("#Visit_visitor").val(id);

    }

    function checkIfVisitorHasACurrentSavedVisit(visitorId)
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visit/isVisitorHasCurrentSavedVisit&id='); ?>' + visitorId,
            dataType: 'json',
            data: visitorId,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    if (value.isTaken == 1) {
                        preloadVisit(visitorId);
                    }

                });
            }
        });
    }

    function preloadVisit(visitorId) {
    $("#isPreloaded").val("1");
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visit/getVisitDetailsOfVisitor&id='); ?>' + visitorId,
            dataType: 'json',
            data: visitorId,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    $("#preloadVisitId").val(value.id);
                    $("#workstation_search").val(value.workstation);
                    $("#Visit_reason_search").val(value.reason);
                    $("#Visitor_visitor_type_search").val(value.visitor_type);
                    $("#Visit_host").val(value.host);
                    $("#Visit_reason").val(value.reason);
                    $("#Visit_workstation").val(value.workstation);
                    if (value.visitor_type != 1) {
                        $("#register-host-patient-form").hide();
                        $("#register-host-form").hide();
                        $("#searchHostDiv").show();
                        $("#currentHostDetailsDiv").show();
                        $("#host-AddBtn").show();
                        preloadHostDetails(value.host);
                    }
                });
            }
        });
    }

    function preloadHostDetails(hostId) {

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visit/getVisitDetailsOfHost&id='); ?>' + hostId,
            dataType: 'json',
            data: hostId,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    $("#staffmember-host-form #User_first_name").val(value.first_name);
                    $("#staffmember-host-form #User_last_name").val(value.last_name);
                    $("#staffmember-host-form #User_department").val(value.department);
                    $("#staffmember-host-form #User_staff_id").val(value.staff_id);
                    $("#staffmember-host-form #User_email").val(value.email);
                    $("#staffmember-host-form #User_contact_number").val(value.contact_number);
                    //alert(value.email);
                });
                
              //  alert($("#staffmember-host-form #User_email").val());
            }
        });
    }

    function populateFieldHost(id) {
        if ($("#Visitor_visitor_type").val() != 1) {

            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('visitor/getHostDetails&id='); ?>' + id,
                dataType: 'json',
                data: id,
                success: function(r) {
                    $.each(r.data, function(index, value) {
                        $("#searchHostTableDiv h4").html("Selected Host Record : " + value.first_name + " " + value.last_name);

                    });

                    $('#findHostTableIframe').contents().find('.findHostButtonColumn a').removeClass('delete');
                    $('#findHostTableIframe').contents().find('.findHostButtonColumn a').html('Select Host');
                    $('#findHostTableIframe').contents().find('#' + id).addClass('delete');
                    $('#findHostTableIframe').contents().find('#' + id).html('Host Selected');
                }
            });
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('visitor/GetPatientDetails&id='); ?>' + id,
                dataType: 'json',
                data: id,
                success: function(r) {
                    $.each(r.data, function(index, value) {
                        $("#searchHostTableDiv h4").html("Selected Patient Record : " + value.name);

                    });
                }
            });
        }
        $("#selectedHostInSearchTable").val(id);
        $("#hostId").val(id);
        $("#Visit_host").val(id);
    }

    function checkEmailIfUnique() {
        var email = $("#Visitor_email").val();

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/checkEmailIfUnique&id='); ?>' + email,
            dataType: 'json',
            data: email,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    if (value.isTaken == 1) {
                        $(".errorMessageEmail").show();
                        $("#emailIsUnique").val("0");
                    } else {
                        $(".errorMessageEmail").hide();
                        $("#emailIsUnique").val("1");
                        $("#clicktabB").click();
                    }
                });

            }
        });
    }

    function checkHostEmailIfUnique() {
        var email = $("#User_email").val();
        var tenant;
        if ($("#currentRoleOfLoggedInUser").val() == 5) { //check if superadmin
            tenant = $("#User_tenant").val();
        } else {
            tenant = '<?php echo $session['tenant']; ?>';
        }
        var url = $("#createUrlForEmailUnique").val() + email.trim() + '&tenant=' + tenant;
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: email,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    if (value.isTaken == 1) {
                        $("#hostEmailIsUnique").val("0");
                        $(".errorMessageEmail1").show();
                    } else {
                        $(".errorMessageEmail1").hide();
                        $("#hostEmailIsUnique").val("1");
                        //var currentURL = location.href.split("=");
                        var currentURL = $("#getcurrentUrl").val();
                        if (currentURL == "") {
//                    //if visitor is not from search sendvisitorform
                            if ($("#Visit_reason").val() == 'Other') {
                                sendReasonForm();
                            }
                            else if ($("#selectedVisitorInSearchTable").val() == 0) {
                                sendVisitorForm();
                            } else {
                                sendHostForm();
                            }
                        } else {
                            showHideTabs("logVisitB", "logVisitA", "logVisit", "findHostA", "findHost", "findVisitorA", "findVisitor");
                        }
                    }
                });

            }
        });
    }

    function populateTenantAgentAndCompanyField()
    {
        $('#Visitor_company option[value!=""]').remove();
        $('#Visitor_tenant_agent option[value!=""]').remove();
        var visitor_type = $("#Visitor_visitor_type").val();
        var tenant = $("#Visitor_tenant").val();
        if (visitor_type == "1") {
            getTenantAgentWithSameTenant(tenant, '');
            document.getElementById('Visitor_company').disabled = true;
        } else {
            getTenantAgentWithSameTenant(tenant);
            getCompanyWithSameTenant(tenant);
        }
    }

    function populateHostTenantAgentAndCompanyField()
    {
        $('#User_company option[value!=""]').remove();
        $('#User_tenant_agent option[value!=""]').remove();
        var tenant = $("#User_tenant").val();

        getHostTenantAgentWithSameTenant(tenant);
        getHostCompanyWithSameTenant(tenant);

    }

    function getTenantAgentWithSameTenant(tenant, selected) {
        $('#Visitor_tenant_agent').empty();
        $('#Visitor_tenant_agent').append('<option value="">Select Tenant Agent</option>');
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetTenantAgentWithSameTenant&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    $('#Visitor_tenant_agent').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                $("#Visitor_tenant_agent").val(selected);
            }
        });
    }

    function getHostTenantAgentWithSameTenant(tenant) {
        $('#User_tenant_agent').empty();
        $('#User_tenant_agent').append('<option value="">Select Tenant Agent</option>');
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetTenantAgentWithSameTenant&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    $('#User_tenant_agent').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }

    function getCompanyWithSameTenant(tenant) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetCompanyWithSameTenant&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('#Visitor_company option[value=""]').remove();
                $.each(r.data, function(index, value) {
                    $('#Visitor_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }

    function getHostCompanyWithSameTenant(tenant) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('company/GetCompanyWithSameTenant&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('#User_company option[value=""]').remove();
                $.each(r.data, function(index, value) {
                    $('#User_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }

    function populateCompanyWithSameTenantAndTenantAgent() {
        $('#Visitor_company option[value!=""]').remove();
        getCompanyWithSameTenantAndTenantAgent($("#Visitor_tenant").val(), $("#Visitor_tenant_agent").val());
    }

    function populateHostCompanyWithSameTenantAndTenantAgent() {
        $('#User_company option[value!=""]').remove();
        getHostCompanyWithSameTenantAndTenantAgent($("#User_tenant").val(), $("#User_tenant_agent").val());
    }

    function getCompanyWithSameTenantAndTenantAgent(tenant, tenant_agent) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetCompanyWithSameTenantAndTenantAgent&id='); ?>' + tenant + '&tenantagent=' + tenant_agent,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('#Visitor_company option[value=""]').remove();
                $.each(r.data, function(index, value) {
                    $('#Visitor_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }

    function getHostCompanyWithSameTenantAndTenantAgent(tenant, tenant_agent) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetCompanyWithSameTenantAndTenantAgent&id='); ?>' + tenant + '&tenantagent=' + tenant_agent,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('#User_company option[value=""]').remove();
                $.each(r.data, function(index, value) {
                    $('#User_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }

    function showHideHostPatientName(visitor_type) {
        if (visitor_type.value == 1) { //if patient 
            $("#register-host-patient-form").show();
            $("#register-host-form").hide();
            $("#searchHostDiv").hide();
            $("#addCompanyLink").hide();
        } else {
            $("#register-host-patient-form").hide();
            $("#register-host-form").show();
            $("#searchHostDiv").show();
            $("#addCompanyLink").show();
        }

        $("#Visitor_visitor_type").val(visitor_type.value);
        $("#Visitor_visitor_type_search").val(visitor_type.value);
        $("#Visit_visitor_type").val(visitor_type.value);
    }

    function getLastVisitorId(callback) {
        var id = $("#Visitor_email").val();

        var ajaxcall = $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetIdOfUser&id='); ?>' + id,
            dataType: 'json',
            data: id,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    $("#visitorId").val(value.id);
                    $("#Visit_visitor").val(value.id);
                });
            }
        }).done(callback).complete(function() {
            //alert("complete");
        });

        //ajaxcall.complete(function(){ alert("second complete"); });

    }

    function getLastHostId(callback) {
        var id = $("#User_email").val();
        return $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('user/GetIdOfUser&id='); ?>' + id.trim(),
            dataType: 'json',
            data: id,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    $("#hostId").val(value.id);
                    $("#Visit_host").val(value.id);
                });
            }
        }).done(callback);
    }

    function getLastPatientId(callback) {
        var id = $("#Patient_name").val();
        return $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('patient/GetIdOfUser&id='); ?>' + id.trim(),
            dataType: 'json',
            data: id,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    $("#hostId").val(value.id);
                    $("#Visit_patient").val(value.id);

                });


            }
        }).done(callback);
    }

    function checkReasonIfUnique() {
        if ($("#VisitReason_reason_search").val() != '') {
            var visitReason = $("#VisitReason_reason_search").val();
        } else
        {
            var visitReason = $("#VisitReason_reason").val();
        }

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitReason/checkReasonIfUnique&id='); ?>' + visitReason.trim(),
            dataType: 'json',
            data: visitReason,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    if (value.isTaken == 1) {
                        if ($("#VisitReason_reason_search").val() != '') {
                            $("#visitReasonErrorMessageSearch").show();
                            $("#visitReasonErrorMessageSearch").html("Reason is already registered.");
                        } else {
                            $("#visitReasonErrorMessage").show();
                            $("#visitReasonErrorMessage").html("Reason is already registered.");
                        }
                    } else {
                        $("#visitReasonErrorMessageSearch").hide();
                        $("#visitReasonErrorMessage").hide();
                        $(".visitorReason").hide();
                        if ($("#selectedVisitorInSearchTable").val() == '0')
                        {
                            checkEmailIfUnique();
                        } else {
                            if ($("#Visitor_visitor_type").val() == 1 || $("#Visitor_visitor_type_search").val() == 1) {
                                $("#findHostA").html("Add Patient Details");
                                $("#findHostB").html("Add Patient Details");
                            } else {
                                $("#findHostA").html("Find or Add Host");
                                $("#findHostB").html("Find or Add Host");
                            }
                            showHideTabs('findHostB', 'findHostA', 'findHost', 'findVisitorA', 'findVisitor', 'selectCardA', 'selectCard');
                        }
                    }
                });

            }
        });
    }

    function showHideTabs(showThisId, hideThisId, showThisRow, hideOtherA, showOtherRowA, hideOtherB, showOtherRowB) {
        $("#" + showThisId).click(); // findvisitorB dt
        $("#" + showThisId).show(); //findvisitorB dt
        $("#" + showThisRow).show(); //findVisitor dd
        $("#" + hideThisId).hide(); //findvisitor a dt

        $("#" + hideOtherA).show(); //selectcardtype dd
        $("#" + showOtherRowA).hide(); //selectcardtype dd

        $("#" + hideOtherB).show(); //selectcardtype dd
        $("#" + showOtherRowB).hide(); //selectcardtype dd
    }

    function display_c() {
        var refresh = 1000; // Refresh rate in milli seconds
        mytime = setTimeout('display_ct()', refresh)
    }

    function display_ct() {

        var x = new Date();
        var currenttime = x.getHours() + ":" + x.getMinutes() + ":" + x.getSeconds();

        $("#Visit_time_inLog").val(currenttime);
        $("#Visit_time_in").val(currenttime);
        $("#Visit_time_in_hours").val(x.getHours());
        $("#Visit_time_in_minutes").val(x.getMinutes());
        tt = display_c();
    }

</script>
