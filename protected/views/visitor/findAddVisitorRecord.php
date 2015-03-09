<?php
$session = new CHttpSession;
?>
<br>
<div role="tabpanel">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#addvisitor" aria-controls="profile" role="tab" data-toggle="tab">Add Visitor Profile</a></li>
        <li role="presentation" ><a href="#searchvisitor" aria-controls="home" role="tab" data-toggle="tab">Search Visitor Profile</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">

        <div role="tabpanel" class="tab-pane active" id="addvisitor">
            <div id="findAddVisitorRecordDiv" class="findAddVisitorRecordDiv form">

                <div data-ng-app="PwordForm">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'register-form',
                        'htmlOptions' => array("name" => "registerform"),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'afterValidate' => 'js:function(form, data, hasError){
                                $("#selectedVisitorInSearchTable").val("");
                                $("#register-host-form").show();
                                $("#searchHostDiv").show();
                                $("#currentHostDetailsDiv").hide();
                                $(".host-AddBtn").hide();
                                if (!hasError){
                                var vehicleValue = $("#Visitor_vehicle").val();
                                if(vehicleValue.length < 6 && vehicleValue != ""){
                                    $("#Visitor_vehicle_em_").show();
                                    $("#Visitor_vehicle_em_").html("Vehicle should have a min. of 6 characters");
                                }else if ($("#workstation").val() == ""){
                                    $(".errorMessageWorkstation").show();
                                    $(".visitorReason").hide();
                                }
                                else if ($("#Visit_reason").val() == "" || ($("#Visit_reason").val() == "Other" &&  $("#VisitReason_reason").val() == "")) {                                  
                                    $(".visitorReason").show();
                                    $(".errorMessageWorkstation").hide();
                                } else if ($("#Visit_reason").val() == "Other" &&  $("#VisitReason_reason").val() != "")
                                { 
                                    checkReasonIfUnique();
                                    $(".errorMessageWorkstation").hide();
                                } else if($("#cardtype").val() != 1 && $("#Visitor_photo").val() == ""){
                                    $("#photoErrorMessage").show();
                                }
                                else {
                                    $(".errorMessageWorkstation").hide();
                                    $(".visitorReason").hide();
                                    $("#photoErrorMessage").hide();
                                    checkEmailIfUnique();
                                    }
                                }
                                }'
                        ),
                    ));
                    ?>
                    <?php echo $form->errorSummary($model); ?>
                    <input type="hidden" id="emailIsUnique" value="0"/>
                    <div class="visitor-title">Add Visitor Profile</div>
                    <div >
                        <table  id="addvisitor-table" data-ng-app="PwordForm">
                            <tr> 

                                <td rowspan="7"  style="width:300px;"><?php echo $form->labelEx($model, 'Add Photo'); ?><br>

                                    <input type="hidden" id="Visitor_photo" name="Visitor[photo]">
                                    <div class="photoDiv" style='margin-left:47px;margin-bottom:5px;height:174px;width:133px;'>
                                        <img id='photoPreview' src="<?php echo Yii::app()->controller->assetsBase; ?>/images/portrait_box.png" style='display:block;height:174px;width:133px;'/>
                                    </div>
                                    <?php require_once(Yii::app()->basePath . '/draganddrop/index.php'); ?>
                                    <div id="photoErrorMessage" class="errorMessage" style="display:none;">Please upload a photo.</div>
                                </td>
                                <td id="visitorTenantRow" <?php
                                if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                                    echo " class='hidden' ";
                                }
                                ?>><?php echo $form->labelEx($model, 'tenant'); ?><br>

                                    <select id="Visitor_tenant" onchange="populateTenantAgentAndCompanyField()" name="Visitor[tenant]"  >
                                        <option value='' selected>Please select a tenant</option>
                                        <?php
                                        $allTenantCompanyNames = User::model()->findAllCompanyTenant();
                                        foreach ($allTenantCompanyNames as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value['tenant']; ?>"
                                            <?php
                                            if ($session['role'] != Roles::ROLE_SUPERADMIN && $session['tenant'] == $value['tenant']) {
                                                echo " selected ";
                                            }
                                            ?>

                                                    ><?php echo $value['name']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                    </select><?php echo "<br>" . $form->error($model, 'tenant'); ?>
                                </td>
                                <td id="workstationRow" <?php
                                if ($session['role'] == Roles::ROLE_OPERATOR || $session['role'] == Roles::ROLE_AGENT_OPERATOR) {
                                    echo " class='hidden' ";
                                }
                                ?>><label>Workstation</label><span class="required">*</span><br>

                                    <select id="workstation" onchange="populateVisitWorkstation(this)">
                                        <?php
                                        if ($session['role'] == Roles::ROLE_OPERATOR || $session['role'] == Roles::ROLE_AGENT_OPERATOR) {
                                            echo '';
                                        } else {
                                            echo '<option value="">Please select a workstation</option>';
                                        }
                                        ?>

                                        <?php
                                        $workstationList = populateWorkstation();
                                        foreach ($workstationList as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <div style="display:none;" class="errorMessage errorMessageWorkstation" >Please select a workstation</div>

                                </td>
                            </tr>
                            <tr>
                                <td id="visitorTenantAgentRow" <?php
                                if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                                    echo " class='hidden' ";
                                }
                                ?>><?php echo $form->labelEx($model, 'tenant_agent'); ?><br>

                                    <select id="Visitor_tenant_agent" name="Visitor[tenant_agent]" onchange="populateCompanyWithSameTenantAndTenantAgent()" >
                                        <?php
                                        echo "<option value='' selected>Please select a tenant agent</option>";
                                        if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                                            echo "<option value='" . $session['tenant_agent'] . "' selected>TenantAgent</option>";
                                        }
                                        ?>
                                    </select><?php echo "<br>" . $form->error($model, 'tenant_agent'); ?>
                                </td>
                                <td>
                                    <?php echo $form->labelEx($model, 'visitor_type'); ?><br>
                                    <?php
                                    echo $form->dropDownList($model, 'visitor_type', VisitorType::model()->returnVisitorTypes(), array(
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
                            </tr>
                            <tr>
                                <td id="visitorCompanyRow">

                                    <?php echo $form->labelEx($model, 'company'); ?><br>
                                    <select id="Visitor_company" name="Visitor[company]" >
                                        <option value=''>Please select a company</option>
                                    </select>
                                    <a onclick="addCompany()" id="addCompanyLink" style="text-decoration: none;<?php
                                    if ($session['role'] != Roles::ROLE_STAFFMEMBER) {
                                        //    echo "display:none";
                                    }
                                    ?>">Add New Company</a>
                                       <?php echo "<br>" . $form->error($model, 'company'); ?>
                                </td>
                                <td>
                                    <?php echo $form->labelEx($model, 'position'); ?><br>
                                    <?php echo $form->textField($model, 'position', array('size' => 50, 'maxlength' => 50)); ?>
                                    <?php echo "<br>" . $form->error($model, 'position'); ?>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <?php echo $form->labelEx($model, 'email'); ?><br>
                                    <?php echo $form->textField($model, 'email', array('size' => 50, 'maxlength' => 50)); ?>
                                    <?php echo "<br>" . $form->error($model, 'email'); ?>
                                    <div style="" id="Visitor_email_em_" class="errorMessage errorMessageEmail" >A profile already exists for this email address.</div>
                                </td>
                                <td><label for="Visitor_vehicle">Vehicle Registration Number</label><br>
                                    <input type="text"  id="Visitor_vehicle" name="Visitor[vehicle]" maxlength="6" size="6">  
                                    <?php echo "<br>" . $form->error($model, 'vehicle'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo $form->labelEx($model, 'contact_number'); ?><br>
                                    <?php echo $form->textField($model, 'contact_number', array('size' => 50, 'maxlength' => 50)); ?>
                                    <?php echo "<br>" . $form->error($model, 'contact_number'); ?>
                                </td>
                                <td>
                                    <label for="Visit_reason">Reason</label><br>

                                    <select id="Visit_reason" name="Visitor[reason]" onchange="ifSelectedIsOtherShowAddReasonDiv(this)">
                                        <option value='' selected>Please select a reason</option>
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
                                    <div class="errorMessage visitorReason" >Please select a reason</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="Visitor_password">Password <span class="required">*</span></label><br>
                                    <input ng-model="user.passwords" data-ng-class="{
                                                'ng-invalid':registerform['Visitor[repeatpassword]'].$error.match}" type="password" id="Visitor_password" name="Visitor[password]">			
                                           <?php echo "<br>" . $form->error($model, 'password'); ?>
                                </td>
                                <td>
                                    <label for="Visitor_repeatpassword">Repeat Password <span class="required">*</span></label><br>
                                    <input ng-model="user.passwordConfirm" type="password" id="Visitor_repeatpassword" data-match="user.passwords" name="Visitor[repeatpassword]"/>			
                                    <div style='font-size:0.9em;color:red;position: absolute;' data-ng-show="registerform['Visitor[repeatpassword]'].$error.match">New Password does not match with Repeat <br> New Password. </div>
                                    <?php echo "<br>" . $form->error($model, 'repeatpassword'); ?>
                                </td>
                            </tr>


                        </table>

                    </div>
                    <div class="register-a-visitor-buttons-div" style="padding-top:50px;">
                        <input type="button" class="neutral visitor-backBtn btnBackTab2" id="btnBackTab2" value="Back"/>
                        <input type="button" id="clicktabB" value="Save and Continue" style="display:none;"/>

                        <input type="submit" value="Save and Continue" name="yt0" id="submitFormVisitor" class="actionForward"/>
                    </div>

                    <?php $this->endWidget(); ?>
                </div>
                <?php
                if (isset($_SERVER['HTTP_USER_AGENT'])) {
                    $agent = $_SERVER['HTTP_USER_AGENT'];
                }
                if (strlen(strstr($agent, 'Firefox')) > 0) {
                    if ($session['role'] == Roles::ROLE_SUPERADMIN) {
                        $class = "moveFromAlignmentA";
                    } else {
                        $class = "moveFromAlignmentB";
                    }
                } else {
                    if ($session['role'] == Roles::ROLE_SUPERADMIN) {
                        $class = "moveFromAlignmentAB";
                    } else {
                        $class = "moveFromAlignmentBB";
                    }
                }

                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'register-reason-form',
                    'action' => Yii::app()->createUrl('/visitReason/create&register=1'),
                    'htmlOptions' => array("name" => "register-reason-form", "class" => $class),
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
                <label>Add Reason</label><br>
                <textarea id="VisitReason_reason" name="VisitReason[reason]" rows="1" maxlength="128" style="text-transform: capitalize;"></textarea> 
                <div class="errorMessage" id="visitReasonErrorMessage" style="display:none;">Please select a reason</div>


                <?php $this->endWidget(); ?>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="searchvisitor">
            <div <?php
            if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                echo "style='display:none;'";
            }
            ?>>
                <table>
                    <tr>
                        <td style='width:250px;'><label>Tenant <span class="required">*</span></label></td>
                        <td><label>Tenant Agent </label></td>
                    </tr>
                    <tr>
                        <td>
                            <select id="search_visitor_tenant" onchange="populateTenantAgentAndCompanyField('search')" >
                                <option value='' selected>Please select a tenant</option>
                                <?php
                                $allTenantCompanyNames = User::model()->findAllCompanyTenant();
                                foreach ($allTenantCompanyNames as $key => $value) {
                                    ?>
                                    <option value="<?php echo $value['tenant']; ?>"
                                    <?php
                                    if ($session['role'] != Roles::ROLE_SUPERADMIN && $session['tenant'] == $value['tenant']) {
                                        echo " selected ";
                                    }
                                    ?>><?php echo $value['name']; ?></option>
                                            <?php
                                        }
                                        ?>
                            </select>
                        </td>
                        <td> 
                            <select id="search_visitor_tenant_agent" onchange="populateAgentAdminWorkstations('search')">
                                <?php
                                echo "<option value='' selected>Please select a tenant agent</option>";
                                if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                                    echo "<option value='" . $session['tenant_agent'] . "' selected>TenantAgent</option>";
                                }
                                ?>
                            </select>
                        </td>
                </table>
            </div>
            <div>
                <label><b>Search Name:</b></label> 
                <input type="text" id="search-visitor" name="search-visitor" class="search-text"/> 
                <button class="visitor-findBtn" onclick="findVisitorRecord()" id="visitor-findBtn" style="display:none;" data-target="#findVisitorRecordModal" data-toggle="modal">Find Record</button>
                <button class="visitor-findBtn neutral" id="dummy-visitor-findBtn" style="padding:8px;">Find Record</button>
                <div class="errorMessage" id="searchTextErrorMessage" style="display:none;"></div>
            </div>


            <div id="searchVisitorTableDiv">
                <h4>Search Results for : <span id='search'></span></h4>
                <div id="visitor_fields_for_Search">
                    <label for="Visitor_visitor_type_search">Visitor Type</label>
                    <?php
                    echo CHtml::dropDownList('Visitor_visitor_type_search', 'visitor_type', VisitorType::model()->returnVisitorTypes(), array(
                        'onchange' => 'showHideHostPatientName(this)',
                    ));
                    ?>
                    <?php echo "<br>" . CHtml::error($model, 'visitor_type'); ?>


                    <div id="workstationRowSearch" <?php
                    if ($session['role'] == Roles::ROLE_OPERATOR || $session['role'] == Roles::ROLE_AGENT_OPERATOR) {
                        echo " class='hidden' ";
                    }
                    ?>><label>Workstation<span class="required" style="display:inline;">*</span></label>

                        <select id="workstation_search" onchange="populateVisitWorkstation(this)">
                            <?php
                            if ($session['role'] == Roles::ROLE_OPERATOR || $session['role'] == Roles::ROLE_AGENT_OPERATOR) {
                                echo '';
                            } else {
                                echo '<option value="">Please select a workstation</option>';
                            }
                            ?>

                            <?php
                            $workstationList = populateWorkstation();
                            foreach ($workstationList as $key => $value) {
                                ?>
                                <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div style="display:none;" class="errorMessage errorMessageWorkstationSearch" >Please select a workstation</div>
                    </div>
                    <label for="Visit_reason_search">Reason</label>

                    <select id="Visit_reason_search" name="Visitor[reason]" onchange="ifSelectedIsOtherShowAddReasonDivSearch(this)">
                        <option value='' selected>Please select a reason</option>
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
                    <div class="errorMessage visitorReason" id="search-visitor-reason-error">Please select a reason</div>
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
                <textarea id="VisitReason_reason_search" maxlength="128" name="VisitReason[reason]"></textarea> 
                <div class="errorMessage" id="visitReasonErrorMessageSearch" style="display:none;">Please select a reason</div>


                <?php $this->endWidget(); ?>

                <div id="searchVisitorTable"></div>

            </div>
            <div class="register-a-visitor-buttons-div">
                <input type="button" class="neutral visitor-backBtn btnBackTab2" id="btnBackTab2" value="Back"/>
                <input type="button" id="clicktabB1"  value="Save and Continue" class="actionForward"/>
            </div>
            <input type="text" id="selectedVisitorInSearchTable" value="0"></input>
        </div>
    </div>

</div>


<script>
    $(document).ready(function() {
        $('#photoCropPreview').imgAreaSelect({
            handles: true,
            onSelectEnd: function(img, selection) {
                $("#cropPhotoBtn").show();
                $("#x1").val(selection.x1);
                $("#x2").val(selection.x2);
                $("#y1").val(selection.y1);
                $("#y2").val(selection.y2);
                $("#width").val(selection.width);
                $("#height").val(selection.height);
            }
        });

        $("#cropPhotoBtn").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('visitor/AjaxCrop'); ?>',
                data: {
                    x1: $("#x1").val(),
                    x2: $("#x2").val(),
                    y1: $("#y1").val(),
                    y2: $("#y2").val(),
                    width: $("#width").val(),
                    height: $("#height").val(),
                    imageUrl: $('#photoCropPreview').attr('src').substring(1, $('#photoCropPreview').attr('src').length),
                    photoId: $('#Visitor_photo').val()
                },
                dataType: 'json',
                success: function(r) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('photo/GetPathOfCompanyLogo&id='); ?>' + $('#Visitor_photo').val(),
                        dataType: 'json',
                        success: function(r) {

                            $.each(r.data, function(index, value) {
                                document.getElementById('photoPreview').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                document.getElementById('photoCropPreview').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                            });
                        }
                    });

                    $("#closeCropPhoto").click();
                    var ias = $('#photoCropPreview').imgAreaSelect({instance: true});
                    ias.cancelSelection();
                }
            });
        });

        $("#dummy-visitor-findBtn").click(function(e) {
            e.preventDefault();
            $("#Visit_reason_search").val("");
            $("#register-reason-form-search").hide();
            $("#register-reason-form").hide();

            var searchText = $("#search-visitor").val();
            if ($("#search_visitor_tenant").val() == '') {
                $("#searchTextErrorMessage").show();
                $("#searchTextErrorMessage").html("Please select a tenant");
            } else if (searchText != '') {
                $("#searchTextErrorMessage").hide();
                $("#visitor-findBtn").click();
                $("#visitor_fields_for_Search").show();
                //if tenant only search tenant 
                if ($("#currentRoleOfLoggedInUser").val() != 5 && $("#search_visitor_tenant_agent").val() == '') {
                    $('#workstation_search option[value!=""]').remove();

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('user/getTenantWorkstation&id='); ?>' + $("#search_visitor_tenant").val(),
                        dataType: 'json',
                        data: $("#search_visitor_tenant").val(),
                        success: function(r) {
                            $('#workstation_search option[value!=""]').remove();

                            $.each(r.data, function(index, value) {
                                $('#workstation_search').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });

                        }
                    });
                } else if ($("#currentRoleOfLoggedInUser").val() != 5 && $("#search_visitor_tenant_agent").val() != '') {
                    populateAgentAdminWorkstations('search');
                }
            }
            else {
                $("#searchTextErrorMessage").show();
                $("#searchTextErrorMessage").html("Please enter a name");
            }
        });


    });

    function findVisitorRecord() {
        $("#visitor_fields_for_Search").hide();
        $("#selectedVisitorInSearchTable").val("");
        $("#searchVisitorTableDiv h4").html("Search Results for : " + $("#search-visitor").val());
        $("#searchVisitorTableDiv").show();
        //  $("#register-form").hide();
        //append searched text in modal
        var searchText = $("#search-visitor").val();

        //change modal url to pass user searched text
        var url = 'index.php?r=visitor/findvisitor&id=' + searchText + '&tenant=' + $("#search_visitor_tenant").val() + '&tenant_agent=' + $("#search_visitor_tenant_agent").val();
        $("#searchVisitorTable").html('<iframe id="findVisitorTableIframe" onLoad="autoResize();" width="100%" height="100%" frameborder="0" scrolling="no" src="' + url + '"></iframe>');
    }
    function populateVisitWorkstation(value) {

        $("#Visit_workstation").val(value.value);
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
                var textToFind;
                if ($("#Visit_reason_search").val() == 'Other' && $("#selectedVisitorInSearchTable").val() != 0) {
                    textToFind = $("#VisitReason_reason_search").val();
                } else
                {
                    textToFind = $("#VisitReason_reason").val();
                }
                textToFind = textToFind.toLowerCase().replace(/^[\u00C0-\u1FFF\u2C00-\uD7FF\w]|\s[\u00C0-\u1FFF\u2C00-\uD7FF\w]/g, function(letter) {
                    return letter.toUpperCase();
                });

                $.each(r.data, function(index, value, f) {
                    $('#Visit_reason').append('<option value="' + value.id + '">' + value.name + '</option>');
                    $('#Visit_reason_search').append('<option value="' + value.id + '">' + value.name + '</option>');


                    var a = r.data;
                    if (index == a.length - 1)
                    {
                        var dd = document.getElementById('Visit_reason');
                        for (var i = 0; i < dd.options.length; i++) {
                            if (dd.options[i].text === textToFind) {
                                dd.selectedIndex = i;
                                break;
                            }
                        }
                    }

                });

                $("#Visit_reason_search").val($("#Visit_reason").val());
                $("#register-reason-form").hide();
                $("#Visit_reason").show();

                /*if visitor is not from search pass formvisitor
                 * else if visitor is from search donot pass visitor 
                 * ---if not from search determine right away if host is from search or not 
                 * if from search set patient adn host visit field to hostid
                 * else if not from search pass patient form if patient, host form if corporate
                 * */
                $("#visitReasonFormField").val($("#Visit_reason_search").val());
                if ($("#selectedVisitorInSearchTable").val() == '0') { //if visitor is not from search
                    sendVisitorForm();
                } else if ($("#selectedVisitorInSearchTable").val() != '0') { //if visitor is from search
                    if ($("#selectedHostInSearchTable").val() != 0) { //if host is from search
                        $("#visitReasonFormField").val($("#Visit_reason_search").val());
                        $("#Visit_patient").val($("#hostId").val());
                        $("#Visit_host").val($("#hostId").val());
                        populateVisitFormFields();
                    } else {
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

        } else {
            $("#register-reason-form").hide();
        }

        $("#Visit_reason").val(reason.value);
        $("#Visit_reason_search").val(reason.value);
    }

    function ifSelectedIsOtherShowAddReasonDivSearch(reason) {
        $("#VisitReason_reason_search").val("");
        if (reason.value == 'Other') {
            $("#register-reason-form-search").show();

        } else {
            $("#register-reason-form-search").hide();
        }

        $("#Visit_reason").val(reason.value);
        $("#Visit_reason_search").val(reason.value);
    }

    function sendVisitorForm() {
        var form = $("#register-form").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("visitor/create&view=1")); ?>",
            data: form,
            success: function(data) {

                if ($("#selectedHostInSearchTable").val() != 0) { //if host is from search
                    $("#visitReasonFormField").val($("#Visit_reason").val());
                    $("#Visit_patient").val($("#hostId").val());
                    $("#Visit_host").val($("#hostId").val());


                    // if visitor is not from search;
                    if ($("#selectedVisitorInSearchTable").val() == 0) {
                        //alert("visitor is not from search host from search");

                        // $.when(getLastVisitorId()).done(populateVisitFormFields());
                        getLastVisitorId(function(data) {
                            populateVisitFormFields(); // Do what you want with the data returned
                        });
                    }
                } else {

                    getLastVisitorId(function(data) {
                        if ($("#Visitor_visitor_type").val() == 1) { //if patient
                            sendPatientForm();
                        } else {
                            sendHostForm();
                        }
                    });

                }
            },
        });
    }

    function sendReasonForm() {
        var reasonForm;
        if ($("#Visit_reason").val() == 'Other' || $("#Visit_reason_search").val() == 'Other')
        {
            if ($("#selectedVisitorInSearchTable").val() != '0') {
                reasonForm = $("#register-reason-form-search").serialize();
            } else {
                reasonForm = $("#register-reason-form").serialize();
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

    function addCompany() {
        var url;
        if ($("#Visitor_tenant").val() == '') {
            $("#Visitor_company_em_").html("Please select a tenant");
            $("#Visitor_company_em_").show();
        } else {
            if ($("#currentRoleOfLoggedInUser").val() == '<?php echo Roles::ROLE_SUPERADMIN; ?>') {
                /* if role is superadmin tenant is required. Pass selected tenant and tenant agent of user to company. */
                url = '<?php echo Yii::app()->createUrl('company/create&viewFrom=1&tenant='); ?>' + $("#Visitor_tenant").val() + '&tenant_agent=' + $("#Visitor_tenant_agent").val();
            } else {
                url = '<?php echo Yii::app()->createUrl('company/create&viewFrom=1'); ?>';
            }

            $("#modalBody").html('<iframe id="companyModalIframe" width="100%" height="80%" frameborder="0" scrolling="no" src="' + url + '"></iframe>');
            $("#modalBtn").click();
        }
    }

    function dismissModal(id) {
        $("#dismissModal").click();
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('company/GetCompanyList&lastId='); ?>',
            dataType: 'json',
            success: function(r) {
                $('#Visitor_company option[value!=""]').remove();

                $.each(r.data, function(index, value) {
                    $('#Visitor_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                    $("#Visitor_company").val(value.id);
                });
            }
        });
    }

    function populateAgentAdminWorkstations(isSearch) {
        isSearch = (typeof isSearch === "undefined") ? "defaultValue" : isSearch;
        var tenant;
        var tenant_agent;


        if (isSearch == 'search') {
            $("#searchVisitorTableDiv").hide();
            $("#selectedVisitorInSearchTable").val("");
            tenant = $("#search_visitor_tenant").val();
            tenant_agent = $("#search_visitor_tenant_agent").val();

            $('#workstation_search option[value!=""]').remove();
        } else {
            tenant = $("#Visitor_tenant").val();
            tenant_agent = $("#Visitor_tenant_agent").val();
            $('#workstation option[value!=""]').remove();
        }



        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('user/getTenantAgentWorkstation&id='); ?>' + tenant_agent + '&tenant=' + tenant,
            dataType: 'json',
            data: tenant_agent,
            success: function(r) {

                $.each(r.data, function(index, value) {
                    if (isSearch == 'search') {
                        $('#workstation_search').append('<option value="' + value.id + '">' + value.name + '</option>');
                    } else {
                        $('#workstation').append('<option value="' + value.id + '">' + value.name + '</option>');
                    }

                });
            }
        });
    }
</script>

<input type="text" id="visitorId" placeholder="visitor id"/>
<?php

function populateWorkstation() {
    $session = new CHttpSession;

    switch ($session['role']) {
        case Roles::ROLE_SUPERADMIN:
            $workstationList = Workstation::model()->findAll();
            break;

        case Roles::ROLE_OPERATOR:
        case Roles::ROLE_AGENT_OPERATOR:
            $Criteria = new CDbCriteria();
            $Criteria->condition = "id ='" . $session['workstation'] . "'";
            $workstationList = Workstation::model()->findAll($Criteria);
            break;

        case Roles::ROLE_STAFFMEMBER:
            if ($session['tenant'] == NULL) {
                $tenantsearchby = "IS NULL";
            } else {
                $tenantsearchby = "='" . $session['tenant'] . "'";
            }

            if ($session['tenant_agent'] == NULL) {
                //$tenantagentsearchby = "and tenant_agent IS NULL";
                $tenantagentsearchby = "";
            } else {
                $tenantagentsearchby = "and tenant_agent ='" . $session['tenant_agent'] . "'";
            }
            $Criteria = new CDbCriteria();
            $Criteria->condition = "tenant $tenantsearchby  $tenantagentsearchby";
            $workstationList = Workstation::model()->findAll($Criteria);
            break;

        case Roles::ROLE_ADMIN:
            $Criteria = new CDbCriteria();
            $Criteria->condition = "tenant ='" . $session['tenant'] . "'";
            $workstationList = Workstation::model()->findAll($Criteria);
            break;

        case Roles::ROLE_AGENT_ADMIN:
            $Criteria = new CDbCriteria();
            $Criteria->condition = "tenant ='" . $session['tenant'] . "' and tenant_agent ='" . $session['tenant_agent'] . "'";
            $workstationList = Workstation::model()->findAll($Criteria);
            break;
    }

    return $workstationList;
}
?>
<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'Click me',
    'type' => 'primary',
    'htmlOptions' => array(
        'data-toggle' => 'modal',
        'data-target' => '#addCompanyModal',
        'id' => 'modalBtn',
        'style' => 'display:none',
    ),
));
?>
<div class="modal hide fade" id="addCompanyModal" style="width:600px;">
    <div class="modal-header">
        <a data-dismiss="modal" class="close" id="dismissModal" >×</a>
        <br>
    </div>
    <div id="modalBody"></div>

</div>


<!-- PHOTO CROP-->
<div id="light" class="white_content">
    <div style="text-align:right;">
        <input type="button" class="btn btn-success" id="cropPhotoBtn" value="Crop" style="">
        <input type="button" id="closeCropPhoto" onclick="document.getElementById('light').style.display = 'none';
                document.getElementById('fade').style.display = 'none'" value="x" class="btn btn-danger">
    </div>
    <br>
    <img id="photoCropPreview" src="">

</div>
<div id="fade" class="black_overlay"></div>

<input type="hidden" id="x1"/>
<input type="hidden" id="x2"/>
<input type="hidden" id="y1"/>
<input type="hidden" id="y2"/>
<input type="hidden" id="width"/>
<input type="hidden" id="height"/>



