<?php
/* @var $this VisitorController */
/* @var $model Visitor */
$session = new CHttpSession;
?>

<h1>Register a Visitor</h1>
<dl class="tabs three-up">
    <dt id="selectCardA" style="display:none;border-top-left-radius: 5px ! important;">Select Card Type</dt>
    <dd class="active" id="selectCard" style="border-top-left-radius: 5px ! important;">
        <a href="#step1" id="selectCardB" style="border-top-left-radius: 5px ! important;">Select Card Type</a>
    </dd>
    <dt id="findVisitorA">Find or Add New Visitor Record</dt>
    <dd style="display:none;" id="findVisitor"><a href="#step2" id="findVisitorB">Find or Add New Visitor Record</a></dd>

    <dt id="findHostA" style="border-top-right-radius: 5px ! important;">Find or Add Host</dt>
    <dd style="display:none;border-top-right-radius: 5px ! important;" id="findHost">
        <a href="#step3" id="findHostB" style="border-top-right-radius: 5px ! important;">Find or Add Host</a>
    </dd>
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
</ul>

<input type="text" id="currentRoleOfLoggedInUser" value="<?php echo $session['role']; ?>">
<input type="text" id="currentCompanyOfLoggedInUser" value="<?php echo User::model()->getCompany($session['id']); ?>">
<script>
    $(document).ready(function() {
        document.getElementById('Visitor_company').disabled = true;

        if ($("#currentRoleOfLoggedInUser").val() != 5) { //not superadmin
            $("#Visitor_company").val($("#currentCompanyOfLoggedInUser").val());
            $("#Visitor_tenant").val('<?php echo $session['tenant']; ?>');
            $("#User_tenant").val('<?php echo $session['tenant']; ?>');
            $("#Visitor_tenant_agent").val('<?php echo $session['tenant_agent']; ?>');
            $("#User_tenant_agent").val('<?php echo $session['tenant_agent']; ?>');

            $("#Visitor_visitor_type").val(2);
            $("#Visitor_visitor_type_search").val(2);
            $('#Visitor_visitor_type option[value!="2"]').remove();
            $('#Visitor_visitor_type_search option[value!="2"]').remove();
            document.getElementById('Visitor_company').disabled = false;
            /*check if current logged in role is staff member
             * if staff member check if tenant agent admin is null
             * if null populate company by tenant
             * else if not null populate company by tenant and tenant agent
             */
            $("#register-host-patient-form").hide();
            $("#register-host-form").hide();
            $("#searchHostDiv").show();
            $("#currentHostDetailsDiv").show();
            
            $('#Visitor_company option[value!=""]').remove();
            if ($("#currentRoleOfLoggedInUser").val() != 5) { //not superadmin
                if ($("#Visitor_tenant_agent").val() == '') {
                    getCompanyWithSameTenant($("#Visitor_tenant").val());
                } else {
                    getCompanyWithSameTenantAndTenantAgent($("#Visitor_tenant").val(), $("#Visitor_tenant_agent").val());
                }
            }
        }

        $('#Visitor_visitor_type').on('change', function(e) {
            $('#Visitor_company option[value!=""]').remove();
            $('#Visitor_tenant_agent option[value!=""]').remove();
            $('#Visitor_tenant').val("");
            if ($(this).val() == "2") { //if corporate type
                $("#register-host-patient-form").hide();
                $("#register-host-form").show();
                document.getElementById('Visitor_company').disabled = false;

            } else { //if patient type
                $("#register-host-patient-form").show();
                $("#register-host-form").hide();
                document.getElementById('Visitor_company').disabled = true;
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
            }
            else {
                $("#searchTextErrorMessage").hide();
                $("#search-visitor-reason-error").hide();
                checkReasonIfUnique();
                //showHideTabs('findHostB', 'findHostA', 'findHost', 'findVisitorA', 'findVisitor', 'selectCardA', 'selectCard');
            }
        });

        $("#clicktabB2").click(function(e) {
            e.preventDefault();

            //checks if host is from search and verifys that a user has been selected
            if (($("#selectedHostInSearchTable").val() == '' && $("#search-host").val() != '') || $("#selectedHostInSearchTable").val() == '') {
                $("#searchTextHostErrorMessage").html("Please select a host.");
                $("#searchTextHostErrorMessage").show();
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
                });
                $('#findVisitorTableIframe').contents().find('.findVisitorButtonColumn a').removeClass('delete');
                $('#findVisitorTableIframe').contents().find('.findVisitorButtonColumn a').html('Select Visitor');
                $('#findVisitorTableIframe').contents().find('#' + id).addClass('delete');
                $('#findVisitorTableIframe').contents().find('#' + id).html('Selected Visitor');
            }
        });

        $("#visitor_fields_for_Search").show();
        $("#selectedVisitorInSearchTable").val(id);
        $("#visitorId").val(id);
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
                    $('#findHostTableIframe').contents().find('#' + id).html('Selected Host');
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
    }

    function checkEmailIfUnique() {
        var email = $("#Visitor_email").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/checkEmailIfUnique&id='); ?>' + email,
            dataType: 'json',
            data: email,
            success: function(r) {

                if (r == 1) {
                    $(".errorMessageEmail").show();
                    $("#emailIsUnique").val("0");
                } else {
                    $(".errorMessageEmail").hide();
                    $("#emailIsUnique").val("1");
                    $("#clicktabB").click();
                }
            }
        });
    }

    function checkHostEmailIfUnique() {
        var email = $("#User_email").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('user/checkEmailIfUnique&id='); ?>' + email.trim(),
            dataType: 'json',
            data: email,
            success: function(r) {

                if (r == 1) {
                    $("#hostEmailIsUnique").val("0");
                    $(".errorMessageEmail1").show();
                } else {
                    $(".errorMessageEmail1").hide();
                    $("#hostEmailIsUnique").val("1");
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
        } else {
            $("#register-host-patient-form").hide();
            $("#register-host-form").show();
            $("#searchHostDiv").show();
        }

        $("#Visitor_visitor_type").val(visitor_type.value);
        $("#Visitor_visitor_type_search").val(visitor_type.value);
        $("#Visit_visitor_type").val(visitor_type.value);
    }

    function getLastVisitorId() {
        var id = $("#Visitor_email").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetIdOfUser&id='); ?>' + id,
            dataType: 'json',
            data: id,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    $("#visitorId").val(value.id);
                    $("#Visit_visitor").val(value.id);
                });
                return true;
            }
        });
        return true;
    }

    function getLastHostId() {
        var id = $("#User_email").val();
        $.ajax({
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
        });
    }

    function getLastPatientId() {
        var id = $("#Patient_name").val();
        $.ajax({
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
        });
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

                if (r == 1) {
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

</script>