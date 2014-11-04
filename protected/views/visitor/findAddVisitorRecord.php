<?php
$session = new CHttpSession;
?>
<div id="findAddVisitorRecordDiv" class="findAddVisitorRecordDiv form">
    <div>
        <label><b>Search Name:</b></label> 
        <input type="text" id="search-visitor" name="search-visitor" class="search-text"/> 
        <button class="visitor-findBtn" onclick="findVisitorRecord()" id="visitor-findBtn" style="display:none;" data-target="#findVisitorRecordModal" data-toggle="modal">Find Record</button>
        <button class="visitor-findBtn" id="dummy-visitor-findBtn">Find Record</button>
        <div class="errorMessage" id="searchTextErrorMessage" style="display:none;"></div>
    </div>

    <div id="searchVisitorTableDiv">
        <h4>Search Results for : <span id='search'></span></h4>
        <div id="visitor_fields_for_Search">
            <label for="Visitor_visitor_type_search">Visitor Type</label><br>
            <?php
            echo CHtml::dropDownList('Visitor_visitor_type_search', 'visitor_type', VisitorType::$VISITOR_TYPE_LIST, array(
                'onchange' => 'showHideHostPatientName(this)',
            ));
            ?>
            <?php echo "<br>" . CHtml::error($model, 'visitor_type'); ?>

            <label for="Visit_reason_search">Reason</label><br>

            <select id="Visit_reason_search" name="Visitor[reason]" onchange="ifSelectedIsOtherShowAddReasonDivSearch(this)">
                <option value='' selected>Select Reason</option>
                <?php
                $reason = VisitReason::model()->findAllReason();
                foreach ($reason as $key => $value) {
                    ?>
                    <option value="<?php echo $value->id; ?>"><?php echo $value->reason; ?></option>
                    <?php
                }
                ?>
                <option value="Other">Other</option>
            </select>
            <div class="errorMessage visitorReason" id="search-visitor-reason-error">Reason cannot be blank.</div>
        </div>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'register-reason-form-search',
            'action' => Yii::app()->createUrl('/visitReason/create&register=1'),
            'htmlOptions' => array("name" => "register-reason-form"),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'afterValidate' => 'js:function(form, data, hasError){
                                if (!hasError){                               
                           }
                        }'
            ),
        ));
        ?>
        <textarea id="VisitReason_reason_search" name="VisitReason[reason]"></textarea> 
        <div class="errorMessage" id="visitReasonErrorMessageSearch" style="display:none;">Reason cannot be blank.</div>


        <?php $this->endWidget(); ?>

        <div id="searchVisitorTable"></div>
        <div class="register-a-visitor-buttons-div">
            <input type="button" class="visitor-backBtn btnBackTab2" id="btnBackTab2" value="Back"/>
            <input type="button" id="clicktabB1"  value="Save and Continue"/>
        </div>
    </div>
    <input type="text" id="selectedVisitorInSearchTable" value="0"></input>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'register-form',
        'htmlOptions' => array("name" => "register-form"),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form, data, hasError){
                                if (!hasError){
                                if ($("#Visit_reason").val() == "" || ($("#Visit_reason").val() == "Other" &&  $("#VisitReason_reason").val() == "")) {                                  
                                    $(".visitorReason").show();
                                } else if ($("#Visit_reason").val() == "Other" &&  $("#VisitReason_reason").val() != "")
                                { 
                                    checkReasonIfUnique();
                                } else {
                                    $(".visitorReason").hide();
                                    checkEmailIfUnique();
                                    }
                                }
                                }'
        ),
    ));
    ?>
    <?php echo $form->errorSummary($model); ?>
    <input type="hidden" id="emailIsUnique" value="0"/>
    <div class="visitor-title">Add New Visitor Record</div>
    <div>
        <table  id="addvisitor-table">
            <tr>
                <td>
                    <?php echo $form->labelEx($model, 'visitor_type'); ?><br>
                    <?php
                    echo $form->dropDownList($model, 'visitor_type', VisitorType::$VISITOR_TYPE_LIST, array(
                        'onchange' => 'showHideHostPatientName(this)',
                    ));
                    ?>
                    <?php echo "<br>" . $form->error($model, 'visitor_type'); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->labelEx($model, 'first_name'); ?><br>
                    <?php echo $form->textField($model, 'first_name', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($model, 'first_name'); ?>
                </td>
                <td>
                    <?php echo $form->labelEx($model, 'last_name'); ?><br>
                    <?php echo $form->textField($model, 'last_name', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($model, 'last_name'); ?>
                </td>
                <td id="visitorCompanyRow">


                    <?php
                    if ($session['role'] == Roles::ROLE_STAFFMEMBER) {
                        ?>
                        <?php echo $form->labelEx($model, 'company'); ?><br>
                        <select id="Visitor_company" name="Visitor[company]" >
                            <option value='<?php echo $session['company']; ?>'><?php echo Company::model()->findByPk($session['company'])->name; ?></option>
                        </select>    
                        <?php echo "<br>" . $form->error($model, 'company'); ?>
                        <?php
                    } else {
                        ?>
                        <?php echo $form->labelEx($model, 'company'); ?><br>
                        <select id="Visitor_company" name="Visitor[company]" >
                            <option value=''>Select Company</option>
                        </select>    
                        <?php echo "<br>" . $form->error($model, 'company'); ?>
                        <?php
                    }
                    ?>


                </td>
            </tr>

            <tr>
                <td>
                    <?php echo $form->labelEx($model, 'position'); ?><br>
                    <?php echo $form->textField($model, 'position', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($model, 'position'); ?>
                </td>
                <td>
                    <?php echo $form->labelEx($model, 'contact_number'); ?><br>
                    <?php echo $form->textField($model, 'contact_number', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($model, 'contact_number'); ?>
                </td>
                <td>
                    <?php echo $form->labelEx($model, 'email'); ?><br>
                    <?php echo $form->textField($model, 'email', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($model, 'email'); ?>
                    <div style="" id="Visitor_email_em_" class="errorMessage errorMessageEmail" >Email Address has already been taken.</div>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="Visit_reason">Reason</label><br>

                    <select id="Visit_reason" name="Visitor[reason]" onchange="ifSelectedIsOtherShowAddReasonDiv(this)">
                        <option value='' selected>Select Reason</option>
                        <option value="Other">Other</option>
                        <?php
                        $reason = VisitReason::model()->findAllReason();
                        foreach ($reason as $key => $value) {
                            ?>
                            <option value="<?php echo $value->id; ?>"><?php echo $value->reason; ?></option>
                            <?php
                        }
                        ?>

                    </select>
                    <div class="errorMessage visitorReason" >Reason cannot be blank.</div>
                </td>
                <td id="visitorTenantRow"><?php echo $form->labelEx($model, 'tenant'); ?><br>

                    <?php
                    if ($session['role'] == Roles::ROLE_STAFFMEMBER) {
                        ?>
                        <input type='text' name='Visitor["tenant"]' value='<?php echo $session['tenant']; ?>'/>
                        <?php
                    } else {
                        ?>
                        <select id="Visitor_tenant" onchange="populateTenantAgentAndCompanyField()" name="Visitor[tenant]"  >
                            <option value='' selected>Select Admin</option>
                            <?php
                            $allAdminNames = User::model()->findAllAdmin();
                            foreach ($allAdminNames as $key => $value) {
                                ?>
                                <option value="<?php echo $value->tenant; ?>"><?php echo $value->first_name . " " . $value->last_name; ?></option>
                                <?php
                            }
                            ?>
                        </select><?php echo "<br>" . $form->error($model, 'tenant'); ?>

                        <?php
                    }
                    ?>
                </td>
                <td id="visitorTenantAgentRow"><?php echo $form->labelEx($model, 'tenant_agent'); ?><br>
                    <?php
                    if ($session['role'] == Roles::ROLE_STAFFMEMBER) {
                        ?>
                        <input type='text' name='Visitor["tenant_agent"]' value='<?php echo $session['tenant_agent']; ?>'/>
                        <?php
                    } else {
                        ?>
                        <select id="Visitor_tenant_agent" name="Visitor[tenant_agent]" onchange="populateCompanyWithSameTenantAndTenantAgent()" >
                            <?php
                            echo "<option value='' selected>Select Tenant Agent</option>";
                            ?>
                        </select><?php echo "<br>" . $form->error($model, 'tenant_agent'); ?>
                        <?php }
                    ?>

                </td>
            </tr>

        </table>

    </div>
    <div class="register-a-visitor-buttons-div">
        <input type="button" class="visitor-backBtn btnBackTab2" id="btnBackTab2" value="Back"/>
        <input type="button" id="clicktabB" value="Save and Continue" style="display:none;"/>

        <input type="submit" value="Save and Continue" name="yt0" id="submitFormVisitor" />
    </div>
    <?php $this->endWidget(); ?>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'register-reason-form',
        'action' => Yii::app()->createUrl('/visitReason/create&register=1'),
        'htmlOptions' => array("name" => "register-reason-form"),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form, data, hasError){
                                if (!hasError){                               
                           }
                        }'
        ),
    ));
    ?>
    <textarea id="VisitReason_reason" name="VisitReason[reason]" ></textarea> 
    <div class="errorMessage" id="visitReasonErrorMessage" style="display:none;">Reason cannot be blank.</div>


    <?php $this->endWidget(); ?>
</div>

<script>
    $(document).ready(function() {
        $("#dummy-visitor-findBtn").click(function(e) {
            e.preventDefault();
            $("#Visit_reason_search").val("");
            $("#register-reason-form-search").hide();
            $("#register-reason-form").hide();

            var searchText = $("#search-visitor").val();
            if (searchText != '') {
                $("#searchTextErrorMessage").hide();
                $("#visitor-findBtn").click();
            } else {
                $("#searchTextErrorMessage").show();
                $("#searchTextErrorMessage").html("Search Name cannot be blank.");
            }
        });
    });

    function findVisitorRecord() {
        $("#visitor_fields_for_Search").hide();
        $("#selectedVisitorInSearchTable").val("");
        $("#searchVisitorTableDiv h4").html("Search Results for : " + $("#search-visitor").val());
        $("#searchVisitorTableDiv").show();
        $("#register-form").hide();
        //append searched text in modal
        var searchText = $("#search-visitor").val();

        //change modal url to pass user searched text
        var url = 'index.php?r=visitor/findvisitor&id=' + searchText;
        $("#searchVisitorTable").html('<iframe id="findVisitorTableIframe" onLoad="autoResize();" width="100%" height="100%" frameborder="0" scrolling="no" src="' + url + '"></iframe>');
    }

    function autoResize() {
        var newheight;

        if (document.getElementById) {
            newheight = document.getElementById('findVisitorTableIframe').contentWindow.document.body.scrollHeight;
        }
        document.getElementById('findVisitorTableIframe').height = (newheight - 60) + "px";
    }

    function addReasonInDropdown() {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitReason/GetAllReason'); ?>',
            dataType: 'json',
            success: function(r) {
                $('#Visit_reason option[value!="Other"]').remove();
                $('#Visit_reason_search option[value!="Other"]').remove();

                $.each(r.data, function(index, value) {
                    $('#Visit_reason').append('<option value="' + value.id + '">' + value.name + '</option>');
                    $('#Visit_reason_search').append('<option value="' + value.id + '">' + value.name + '</option>');

                    if ($("#Visit_reason_search").val() == 'Other' && $("#selectedVisitorInSearchTable").val() != 0) {
                        var textToFind = $("#VisitReason_reason_search").val();
                    } else
                    {
                        var textToFind = $("#VisitReason_reason").val();
                    }

                    var dd = document.getElementById('Visit_reason');
                    for (var i = 0; i < dd.options.length; i++) {
                        if (dd.options[i].text === textToFind) {
                            dd.selectedIndex = i;
                            break;
                        }
                    }
                    $("#Visit_reason_search").val($("#Visit_reason").val());
                    $("#register-reason-form").hide();
                    $("#Visit_reason").show();
                });
                /*if visitor is not from search pass formvisitor
                 * else if visitor is from search donot pass visitor 
                 * ---if not from search determine right away if host is from search or not 
                 * if from search set patient adn host visit field to hostid
                 * else if not from search pass patient form if patient, host form if corporate
                 * */
                $("#visitReasonFormField").val($("#Visit_reason_search").val());
                if ($("#selectedVisitorInSearchTable").val() == '0') { //if visitor is not from search
                    sendVisitorForm();
                    //  alert("visitor is not from search");
                } else if ($("#selectedVisitorInSearchTable").val() != '0') { //if visitor is from search
                    //  alert("visitor from search");
                    if ($("#selectedHostInSearchTable").val() != 0) { //if host is from search
                        $("#visitReasonFormField").val($("#Visit_reason_search").val());
                        $("#Visit_patient").val($("#hostId").val());
                        $("#Visit_host").val($("#hostId").val());
                        //  alert("host from search");
                        populateVisitFormFields();
                    } else {
                        //  alert("add host");
                        if ($("#Visitor_visitor_type").val() == 1) { //if patient
                            sendPatientForm();
                        } else {
                            sendHostForm();
                        }
                    }
                }
            }
        });
    }

    function ifSelectedIsOtherShowAddReasonDiv(reason) {
        if (reason.value == 'Other') {
            $("#register-reason-form").show();
            //  $("#Visit_reason").hide();

        } else {
            $("#register-reason-form").hide();
            // $("#Visit_reason").show();
        }

        $("#Visit_reason").val(reason.value);
        $("#Visit_reason_search").val(reason.value);
    }

    function ifSelectedIsOtherShowAddReasonDivSearch(reason) {
        $("#VisitReason_reason_search").val("");
        if (reason.value == 'Other') {
            $("#register-reason-form-search").show();
            //  $("#Visit_reason").hide();

        } else {
            $("#register-reason-form-search").hide();
            // $("#Visit_reason").show();
        }

        $("#Visit_reason").val(reason.value);
        $("#Visit_reason_search").val(reason.value);
    }

    function sendVisitorForm() {

        var form = $("#register-form").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("visitor/create")); ?>",
            data: form,
            success: function(data) {

                if ($("#selectedHostInSearchTable").val() != 0) { //if host is from search
                    $("#visitReasonFormField").val($("#Visit_reason").val());
                    $("#Visit_patient").val($("#hostId").val());
                    $("#Visit_host").val($("#hostId").val());


                    // if visitor is not from search;
                    if ($("#selectedVisitorInSearchTable").val() == 0) {
                        $.when(getLastVisitorId()).then(populateVisitFormFields());
                    }
                } else {
                    getLastVisitorId();

                    if ($("#Visitor_visitor_type").val() == 1) { //if patient
                        sendPatientForm();
                    } else {
                        sendHostForm();
                    }
                }
            },
        });
    }



    function sendReasonForm() {
        if ($("#Visit_reason").val() == 'Other' || $("#Visit_reason_search").val() == 'Other')
        {
            if ($("#selectedVisitorInSearchTable").val() != '0') {
                var reasonForm = $("#register-reason-form-search").serialize();
                // alert("searchreason");
            } else {
                var reasonForm = $("#register-reason-form").serialize();
                //    alert("add visitor reason");
            }

            $.ajax({
                type: "POST",
                url: "<?php echo CHtml::normalizeUrl(array("visitReason/create&register=1")); ?>",
                data: reasonForm,
                success: function(data) {
                    addReasonInDropdown();
                },
            });
        }
        else {
            sendVisitorForm();
        }
    }
</script>

<input type="text" id="visitorId" placeholder="visitor id"/>