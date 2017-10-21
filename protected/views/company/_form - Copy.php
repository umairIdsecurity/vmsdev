<?php
/* @var $this CompanyController */
/* @var $model Company */
/* @var $form CActiveForm */


$session = new CHttpSession;
$tenant = '';
$tenantAgent = '';
if (isset($_GET['tenant'])) {
    $tenant = $_GET['tenant'];
} elseif ($session['role'] != Roles::ROLE_SUPERADMIN) {
    $tenant = $session['tenant'];
}

if (isset($_GET['tenant_agent'])) {
    $tenantAgent = $_GET['tenant_agent'];
} elseif ($session['role'] != Roles::ROLE_SUPERADMIN) {
    $tenantAgent = $session['tenant_agent'];
}

$dataId = '';
if ($this->action->id == 'update') {
    $dataId = $_GET['id'];
}

    $companyList = CHtml::listData(Visitor::model()->findAllCompanyByTenant($session['tenant']), 'id', 'name');

    $companyList = array_unique($companyList);
    $listsCom = implode('", "', $companyList);
?>  
    

<style>
    div.form label {
        display: inline !important;
    }
    </style>
<div class="form" data-ng-app="PwordForm">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'company-form',
        'htmlOptions' => array("name" => "registerform","enctype" => "multipart/form-data"),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
//            'afterValidate' => 'js:function(form, data, hasError) {
//                if (!hasError) {
//                    if($("#currentAction").val() == "create"){
//                        if( $("#Company_password_requirement_1").is(":checked") == true && $(".pass_option").is(":checked")== false){                       
//                            $("#pass_error_").show();
//                            return false;
//                        }
//                        else if($(".pass_option").is(":checked")== true && $(".pass_option:checked").val()==1 && ($("#Company_user_password").val()== "" || $("#Company_user_repeatpassword").val()=="")){
//                            $("#pass_error_").show();
//                            $("#pass_error_").html("Type password or generate");
//                             return false;
//                        }
//                        else{
//                            checkCompanyNameUnique();
//                        }
//                    } else{
//                        checkCompanyNameUnique();
//                    }
//                } else {
//                    $(createCompanyForm()+".user_fields" ).show();
//                    $(createCompanyForm()+".password-border").show();
//                }
//            }'
        ),
    ));
    ?>
    <?php

    foreach (Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }

    if (isset($_GET['viewFrom'])) {
        $isViewedFromModal = $_GET['viewFrom'];
    } else {
        //echo $form->errorSummary($model);
    }
    ?>
    <!--<input type="hidden" id="user_role" name="user_role" value="<?php /*echo $session['role'];  */?>" />-->
    <?php if ($this->action->id != 'update') {
        ?>
        <input type="hidden" id="Company_tenant" name="Company[tenant]" value="<?php echo $tenant; ?>">
        <input type="hidden" id="Company_tenant_agent" name="Company[tenant_agent]" value="<?php echo $tenantAgent; ?>">

    <?php } else {
        ?>
        <input type="hidden" id="Company_tenant_" name="Company[tenant_]" value="<?php echo $model['tenant']; ?>">
        <input type="hidden" id="Company_tenant_agent_" name="Company[tenant_agent_]" value="<?php echo $model['tenant_agent']; ?>">

    <?php
    }
    ?>
    <table>
            <tr>
                <td>
                    <table>
                        <tr class="user_fields1">
                            <td style="width:160px;">&nbsp;</td>
                            <td style="width:240px;">
                                <?php
                                echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 150, 'placeholder' => 'Company Name', 'class' => 'ui-autocomplete-input company-autocomplete', 'autocomplete' => 'on'));
                                echo '<span class="required"> *</span><br>';
                                echo $form->error($model, 'name');
                                echo '<div id="Company_name_unique_em_" class="errorMessage" style="display: none">Company name has already been taken</div>';
                               ?>
                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td style="width:160px;">&nbsp;</td>
                            <td>
                                <a class="btn btn-default" href="#" role="button" id="addContact">+</a> Add Company Contact
                                <input type="hidden" id="is_user_field" name="is_user_field" value="<?php echo $session['is_field'];?>">
                            </td>
                        </tr>

                        <tr class="user_fields">
                            <td style="width:160px;">&nbsp;</td>
                            <td><?php echo $form->textField($model, 'user_first_name', array('size' => 50, 'maxlength' => 50, 'value'=> $userModel->first_name,'placeholder'=>'First Name')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'user_first_name'); ?>
                            </td>
                        </tr>

                        <tr class="user_fields">
                            <td style="width:160px;">&nbsp;</td>
                            <td><?php echo $form->textField($model, 'user_last_name', array('size' => 50, 'maxlength' => 50,'value'=> $userModel->last_name,'placeholder'=>'Last Name')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'user_last_name'); ?>
                            </td>
                        </tr>

                        <tr class="user_fields">
                            <td style="width:160px;">&nbsp;</td>
                            <td><?php echo $form->textField($model, 'user_email', array('size' => 50, 'maxlength' => 50,'value'=> $userModel->email,'placeholder'=>'Email')); ?>
                                <span class="required">*</span>
								
                                <?php
								if ($this->action->id == 'update')
								{
									echo "<br>" . $form->error($userModel, 'email'); 
								}
								else
								echo "<br>" . $form->error($model, 'email_address'); ?>
                                <div id="Company_user_email_unique_em_" class="errorMessage" style="display: none">User email has already been taken</div>
                            </td>
                        </tr>

                        <tr class="user_fields">
                            <td style="width:160px;">&nbsp;</td>
                            <td><?php echo $form->textField($model, 'user_contact_number', array('size' => 50, 'maxlength' => 50,'value'=> $userModel->contact_number,'placeholder'=>'Contact Number')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'user_contact_number'); ?>
                            </td>
                        </tr>

                        <tr class="user_fields">
                            <td style="width:160px;">&nbsp;</td>
                            <td><?php echo $form->fileField($model, 'user_authorised_file', array('size' => 50, 'maxlength' => 50)); ?>
                                <?php echo "<br>" . $form->error($model, 'user_authorised_file'); ?>
                            </td>
                        </tr>

                        <tr>
                            <td> &nbsp;</td>
                        <td>
                            <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array('id' => 'createBtn', 'style' => 'height:30px;', 'class' => 'complete')); ?>
                            <?php
                            if(Yii::app()->controller->action->id =="update") { ?>
                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#mergeCompanyContactModal">Merge Contacts</button>
                            <?php } ?>
                        </td>

                        </tr>
                    </table><!--Company Contact field-->
                   
                </td>
            </tr>
    </table>
<!-- Modal -->
<div class="modal fade" id="mergeCompanyContactModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Merge Company Contacts</h4>
            </div>
            <div class="modal-body">
                <input size="60" maxlength="150" placeholder="Company Name" class="ui-autocomplete-input company-autocomplete-merge" autocomplete="off" name="Company_name_merge" id="Company_name_merge" type="text">
                <div class="errorMessage" id="mergerCompanyContactForm" style="">Please complete Company Name</div>
                <input name="company_id" id="company_id" type="hidden" value="<?php echo $_GET['id']; ?>" >
            </div>
            <div class="modal-footer">
                <button class="btn neutral" id="btnCloseModalMergeCompanyContact" data-dismiss="modal" aria-hidden="true">Close</button>
                <button type="button" id="btnMergeCompanyContact" class="btn complete">Merge</button>
            </div>
        </div>

    </div>
</div>
    <!--Company Contact-->


    <div class="row buttons " style="<?php if (isset($_GET['viewFrom'])) { ?>
        margin-left:173px;
    <?php
    } else {
        echo "text-align: right;";
    }
    ?>">        
        <?php // echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array('id' => 'createBtn', 'style' => 'height:30px;', 'class' => 'complete')); ?>
        <?php if (isset($_GET['viewFrom'])) { ?>

        <?php
        } else {
        if ($session['role'] != Roles::ROLE_SUPERADMIN) {
            ?>
<!--            <button class="yiiBtn neutral" id="modalBtn" style="padding:1.5px 6px;margin-top:-4.1px;height:30.1px;" data-target="#viewLicense" data-toggle="modal">View License Details</button>-->
        <?php } else { ?>
<!--        <button class="yiiBtn actionForward" style="padding:2px 6px;margin-top:-4.1px;height:30.1px;" type='button' onclick="gotoLicensePage()">License Details</button>-->
        <?php
            }
        }
        ?>
    </div>
 <?php
    if (isset($contacts) && !empty($contacts)) { ?>
    <div class="page-header">
      <h1>Organisation Contacts</h1>
    </div>
 <?php  
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'contacts-grid',
            'dataProvider' => new CArrayDataProvider($contacts),
            'enableSorting' => false,
            'afterAjaxUpdate' => "
            function(id, data) {
                $('th > .asc').append('<div></div>');
                $('th > .desc').append('<div></div>');
            }",
            'columns' => array(

                array(
                    'name' => 'User',
                    'value' => '$data->getFullName()',
                ),
                array(
                    'name' => 'email',
                    'header' => 'Email',
                ),
                array(
                    'name' => 'contact_number',
                    'header' => 'Number',
                ),

                array(
                    'name' => 'Authorised File',
                    'value' => 'Company::downlaodFile($data->authorised_file)',
                ),
                array(
                    'header' => 'Actions',
                    'class' => 'CButtonColumn',
                    'template' => '{update}{delete}',
                    'buttons' => array(
                        'update' => array(//the name {reply} must be same
                            'label' => 'Edit', // text label of the button
                            'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                            'url' => 'Yii::app()->createUrl("company/update", array("id"=>$data->company, "cid"=>$data->id))',
                        ),
                        'delete' => array(//the name {reply} must be same
                            'label' => 'Delete', // text label of the button
                            'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                            'url' => 'Yii::app()->controller->createUrl("user/deleteCompanyContact",array("id"=>$data->id))',
                            'options' => array(// this is the 'html' array but we specify the 'ajax' element
                                //'style'=>'display: inline-block; font-size: 15px; text-align: center; width: 25%; margin-right: 10%',
                                'confirm' => "Are you sure you want to delete this item?",
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => "js:$(this).attr('href')", // ajax post will use 'url' specified above
                                    'success' => 'function(data){
											//alert(data);
											if (data == "true") {
											 $.fn.yiiGridView.update("contacts-grid");
												return false;
											 }
                                          }',
                                    'error'=>'function(xhr,textStatus,errorThrown){
									console.log(xhr.responseText);
									console.log(textStatus);
									console.log(errorThrown);
							}',
                                ),
                            ),

                        ),
                    ),
                ),
            ),
        ));
    }
    ?>

<?php $this->endWidget(); ?>
    

</div><!-- form -->
<input type="hidden" id="currentAction" value="<?php echo $this->action->id; ?>">
<input type="hidden" id="viewFrom" value="<?php
if (isset($_GET['viewFrom'])) {
    echo "1";
} else {
    echo "0";
}
?>"/>
<script>
$(document).ready(function() {

    <?php if(isset($_GET['cid'])) {  ?>
    $('#is_user_field').val('1');
    <?php } ?>

    $("#mergerCompanyContactForm").hide();

    $("#btnMergeCompanyContact").click(function(){

        if($("#Company_name_merge").val() == ""){
            $("#mergerCompanyContactForm").show();
        } else {
            $("#mergerCompanyContactForm").hide();
            var name = $('#Company_name_merge').val();
            var cid = $('#company_id').val();
            $.ajax({
                type: "POST",
                url: "<?php echo $this->createUrl('company/mergeCompanyContacts')?>",
                data: {name: name, cid: cid},
                success: function (data) {
                    //alert(data);
                    window.location = '<?php echo Yii::app()->baseUrl; ?>'+'/index.php?r=company/update&id='+data;
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log(xhr.responseText);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });
        }
    });
});

    $(function() {
        var availableTags = ["<?php echo $listsCom; ?>"];
        $(".company-autocomplete").autocomplete({
            source: availableTags,
            select: function(event, ui) {
                event.preventDefault();
                $(".company-autocomplete").val(ui.item.label);
                //$('#typePostForm').val('contact');
            }
        });
        $(".ui-front").css("z-index", 1051);
    });

$(function() {
    var availableTagsMerge = ["<?php echo $listsCom; ?>"];
    $(".company-autocomplete-merge").autocomplete({
        source: availableTagsMerge,
        select: function(event, ui) {
            event.preventDefault();
            $(".company-autocomplete-merge").val(ui.item.label);
            //$('#typePostForm').val('contact');
        }
    });
    $(".ui-front").css("z-index", 1051);
});

    var radiochooseval = "";
    function call_radio1(){
        radiochooseval = $('#radio1').val();
        $('#Company_password_option').val(radiochooseval);
    }
    function call_radio2(){
        radiochooseval = $("#radio2").val();
        $('#Company_password_option').val(radiochooseval);
    }
    function createCompanyForm() {
        return "#company-form ";
    }
    function checkCompanyNameUnique() {
	//alert("test");
        if($("#currentAction").val() == "update"){
            if($('#Company_name').val() == "<?php echo $model->name?>"){
                var name = "";
            } else{
                var name = $('#Company_name').val();
            }
        } else {
            var name = $('#Company_name').val();
        }
        if($("#currentAction").val() == "create"){
            var tenant = $('#Company_tenant').val();
        } else{
            var tenant = $('#Company_tenant_').val();
        }
        $.ajax({
            type : "POST",
            url: "<?php echo $this->createUrl('company/checkNameUnique')?>",
            data: {name:name, tenant:tenant},
            success: function(data){
                if(data == 0) {
                    $('#Company_name_unique_em_').show();
                    return false;
                } else {
                    if($("#currentAction").val() == "create"){
                        checkUserEmailUnique();
                    } else{
                        sendCreateCompanyForm();
                    }
                }
            },
			error: function(xhr,textStatus,errorThrown){
                console.log(xhr.responseText);
                console.log(textStatus);
                console.log(errorThrown);
			}
        });
    }

    function checkUserEmailUnique(){
        var email = $("#Company_user_email").val();
        var tenant = $('#Company_tenant').val();
        $.ajax({
            type : "POST",
            url: "<?php echo $this->createUrl('user/checkCompanyContactEmail')?>",
            data: {email:email, tenant:tenant},
            success: function(data){
                if(data == 1) {
                    $('#Company_user_email_unique_em_').show();
                    return false;
                } else {
                    $('#Company_user_email_unique_em_').hide();
                    sendCreateCompanyForm();
                }
            },
			error: function(xhr,textStatus,errorThrown){
                console.log(xhr.responseText);
                console.log(textStatus);
                console.log(errorThrown);
			}
        });
    }

    function sendCreateCompanyForm() {
		//alert("here");
        var formInfo = $(createCompanyForm()).serialize();
        if($("#currentAction").val() == "create"){
            var url = "<?php echo $this->createUrl('company/create')?>";
        } else{
            var url = "<?php echo $this->createUrl('company/update&id='.$model->id)?>";
        }
        $.ajax({
            type: "POST",
            url:url ,
            data: formInfo,
            success: function(data){
               var curentRole = '<?php echo Yii::app()->user->role?>';
                if( curentRole == '7' || curentRole == '8' || curentRole == '12' || curentRole == '14')
                     window.location = 'index.php?r=dashboard';
                 else
                    window.location = 'index.php?r=company/admin';
            },
			error: function(xhr,textStatus,errorThrown){
                console.log(xhr.responseText);
                console.log(textStatus);
                console.log(errorThrown);
			}
        });
    }

    function closeParent() {
        window.parent.dismissModal();
    }

    function gotoLicensePage() {
        window.location = 'index.php?r=licenseDetails/update&id=1';
    }

    function cancel() {
        $('#Company_user_repeatpassword').val('');
        $('#Company_user_password').val('');
        $(createCompanyForm()+"#random_password").val('');
        $(createCompanyForm()+"#close_generate").click();
    }

    function copy_password() {
        if ($('#random_password').val() == '') {
            $('#error_msg').show();
        } else {
            $('#Company_user_password').val($('#random_password').val());
            $('#Company_user_repeatpassword').val($('#random_password').val());
            $("#close_generate").click();
        }
    }

    function validatePassword() {
        if($("#Company_user_password").val() == ""){
            $("#Company_user_password_em_").html("Password should be specified");
            $("#Company_user_password_em_").show();
            return false;
        } else if($("#Company_user_repeatpassword").val() == "") {
            $("#Company_user_repeatpassword_em_").html("Please confirm a password");
            $("#Company_user_repeatpassword_em_").show();
            return false;
        } else {
            return true;
        }
    }

    function isPasswordMatch() {
        if($(createCompanyForm()+"#pass_option_1").is(":checked")){
            if($("#Company_user_password").val() == $("#Company_user_repeatpassword").val()){
                $("#Company_user_passwordmatch_em_").hide();
                return true;
            } else {
                $("#Company_user_passwordmatch_em_").html("Passwords are not matched");
                $("#Company_user_passwordmatch_em_").show();
                return false;
            }
        }
    }

    function generatepassword() {
        $("#random_password").val('');
        $('.pass_option[value=1]').prop('checked', true);
        $('#Company_password_option').val(1);

        var text = "";
        var possible = "abcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < 6; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        document.getElementById('random_password').value = text;
        $("#gen_pass").click();
    }

    $(document).ready(function() {
        $(createCompanyForm()+".pass_option").on("click",function(){
            $(createCompanyForm()+".user_requires_password #pass_error_").hide();
        });
        $("#Company_user_password").on("change",function(){
            isPasswordMatch();
           if($("#Company_user_password").val() == '') {
               $("#Company_user_password_em_").html("Password should be specified");
               $("#Company_user_password_em_").show();
           } else {
               $("#Company_user_password_em_").hide();
           }

        });

        $("#Company_user_repeatpassword").on("change",function(){
            isPasswordMatch();
           if($("#Company_user_repeatpassword").val() == '') {
               $("#Company_user_repeatpassword_em_").html("Please confirm a password");
               $("#Company_user_repeatpassword_em_").show();
           } else {
               $("Company_user_repeatpassword_em_").hide();
           }

        });

        var default_field = $("#is_user_field").attr('value');

        if(default_field == "") {
            $( ".user_fields" ).hide();
            $(createCompanyForm()+".password-border").hide();
        }
        else{
            $( ".user_fields" ).show();
            $(createCompanyForm()+".password-border").show();
        }

        $(createCompanyForm()+"#addContact").click(function(e) {
            e.preventDefault();

            var is_user_field = $("#is_user_field").attr('value');
            if(is_user_field==""){
                $('#is_user_field').val(1);
                $( createCompanyForm()+".user_fields" ).show();
                $(createCompanyForm()+".password-border").show();
            }
            else{
                $('#is_user_field').val("");
                $( createCompanyForm()+".user_fields" ).hide();
                $(createCompanyForm()+".password-border").hide();
            }

        });

        $(createCompanyForm()+'.password_requirement').click(function () {
            $(createCompanyForm()+".password-border #pass_error_").hide();
            if ($('#Company_password_requirement_1').is(':checked')) {
                $(createCompanyForm()+'.user_requires_password').css("display", "block");
                //CAVMS-1168
                //$(createCompanyForm()+'.pass_option').prop('checked', false);
                $('#Company_user_password').val('');
            }
            else {
                $(createCompanyForm()+'.user_requires_password').css("display", "none");
            }

        });

    });


</script>

<!-- <div class="modal hide fade" id="viewLicense" style="width:600px;">
    <div class="modal-header">
        <a data-dismiss="modal" class="close" id="dismissModal" >×</a>
        <br>
    </div>
    <div id="modalBody" style="padding:20px;">
        <?php
        echo LicenseDetails::model()->getLicenseDetails();
        ?>
    </div>

</div> -->
<div class="modal hide fade" id="viewLicense" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <a data-dismiss="modal" class="close" id="dismissModal">×</a>
        <br>
        </div>
      <div style="padding:20px;" id="modalBody">
        <?php
        echo LicenseDetails::model()->getLicenseDetails();
        ?>
      </div>
    </div>
  </div>
</div>
<div class="modal hide fade" id="generate_password" style="width: 410px">
    <div style="border:5px solid #BEBEBE; width:405px">
        <div class="modal-header"
             style=" border:none !important; height: 60px !important;padding: 0px !important;width: 405px !important;">
            <div style="background-color:#E8E8E8; padding-top:2px; width:405px; height:56px;">
                <a data-dismiss="modal" class="close" id="close_generate">×</a>

                <h1 style="color: #000;font-size: 15px;font-weight: bold;margin-left: 9px;padding-top: 0px !important;">
                    Autogenerated Password
                </h1>

            </div>

            <br>
        </div>
        <div id="modalBody_gen">

            <table>

                <div id="error_msg" style='font-size: 0.9em;color: #FF0000;padding-left: 11px; display:none'>Please
                    Generate Password
                </div>

                <tr>
                    <td colspan="2" style="padding-left:10px">Your randomly generated password is :</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-left:55px; padding-top:24px;"><input readonly type="text" placeholder="Random Password" value="" id="random_password"/>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" style="padding-left:10px; font:italic">Note:Please copy and save this password
                        somewhere safe.
                    </td>
                </tr>
                <tr>
                    <td style="padding-left: 11px;padding-top: 26px !important; width:50%"><input onclick="copy_password();" style="border-radius: 4px; height: 35px; " type="button" value="Use Password"/></td>
                    <td style="padding-right:10px;padding-top: 25px;"><input onclick="cancel();" style="border-radius: 4px; height: 35px;" type="button" value="Cancel"/></td>
                </tr>

            </table>


        </div>
        <a data-toggle="modal" data-target="#generate_password" id="gen_pass" style="display:none"
           class="btn btn-primary">Click me</a>
    </div>
</div>

