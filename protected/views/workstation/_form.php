
<?php
/* @var $this WorkstationsController */
/* @var $model Workstations */
/* @var $form CActiveForm */
$session = new CHttpSession;
?>

<div class="form" data-ng-app="PwordForm">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'workstations-form',
        'htmlOptions' => array("name" => "workstation"),
        'enableAjaxValidation' => false,
    ) );
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
    <table>
        <tr>
            <td>
                <table style="width: 540px;">
                    <?php if ($session['role'] == Roles::ROLE_SUPERADMIN) { ?>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'tenant'); ?></td>
                            
                            <td>
                                <select  onchange="getTenantAgent()"  id="Workstation_tenant" name="Workstation[tenant]">
                                    <option disabled value='' selected>Please select a tenant</option>
                                    <?php
                                    $tenantList = Company::model()->findAllTenants();
                                    foreach ($tenantList as $key => $value) {
                                        ?>
                                        <option <?php
                                if ($model['tenant'] == $value['id']) {
                                    echo " selected ";
                                }
                                        ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                            <?php
                                        }
                                        ?>

                                </select>
                            </td>



                            <td><?php echo $form->error($model, 'tenant'); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'tenant_agent'); ?></td>
                            <td><select id="Workstation_tenant_agent" name="Workstation[tenant_agent]">
                                    <option disabled value='' selected>Please select a tenant agent</option>
                                    <?php
                                    if ($this->action->Id != 'create') {

                                        $companyList = User::model()->findAllTenantAgent($model['tenant']);
                                        foreach ($companyList as $key => $value) {
                                            ?>


                                            <option <?php
                                if ($model['tenant_agent'] == $value['tenant_agent']) {
                                    echo " selected ";
                                }
                                            ?> value="<?php echo $value['tenant_agent']; ?>"><?php echo $value['name']; ?></option>
                                                <?php
                                            }
                                        }?>
                                </select></td>
                            <td><?php echo $form->error($model, 'tenant_agent'); ?></td>
                        </tr>
                    <?php } else { ?>
                        <input type="hidden" id="Workstation_tenant" name="Workstation[tenant]" value="<?php echo isset($session['company']) ? $session['company'] : $session['tenant']; ?>">
                        <?php if($session['role'] == Roles::ROLE_ADMIN) {?>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'tenant_agent'); ?></td>
                            <td><select id="Workstation_tenant_agent" name="Workstation[tenant_agent]">
                                    <?php
                                    if ($this->action->Id != 'create') {

                                        $companyList = User::model()->findAllTenantAgent($model['tenant']);
                                        foreach ($companyList as $key => $value) {
                                            ?>

                                            <option disabled value='' selected>Please select a tenant agent</option>
                                            <option <?php
                                            if ($model['tenant_agent'] == $value['tenant_agent']) {
                                                echo " selected ";
                                            }
                                            ?> value="<?php echo $value['tenant_agent']; ?>"><?php echo $value['name']; ?></option>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                        <option disabled value='' selected>Please select a tenant agent</option>
                                    <?php } ?>
                                </select></td>
                            <td><?php echo $form->error($model, 'tenant_agent'); ?></td>
                        </tr>
                        <?php } else {?>
                        <input type="hidden" id="Workstation_tenant_agent" name="Workstation[tenant_agent]" value="<?php echo $session['tenant_agent']; ?>">

                        <?php } ?>
                    <?php } ?>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'name'); ?></td>
                        <td><?php echo $form->textField($model, 'name', array('size' => 50, 'maxlength' => 50)); ?></td>
                        <td><?php echo $form->error($model, 'name'); ?></td>
                    </tr>
                    <tr>
                        <?php
                        $isTrue = $model->assign_kiosk?"true":"false";
                        ?>
                        <td><?php echo $form->labelEx($model, 'assign_kiosk'); ?></td>
                        <td colspan="2">
                            <?php echo $form->checkBox($model,'assign_kiosk', array("data-ng-init"=>"Workstation['assign_kiosk']=".$isTrue, "data-ng-model" => "Workstation['assign_kiosk']")  ); ?>
                        <td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'location'); ?></td>
                        <td><?php echo $form->textField($model, 'location', array('size' => 60, 'maxlength' => 100)); ?></td>
                        <td><?php echo $form->error($model, 'location'); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'contact_name'); ?></td>
                        <td><?php echo $form->textField($model, 'contact_name', array('size' => 50, 'maxlength' => 50)); ?></td>
                        <td><?php echo $form->error($model, 'contact_name'); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'contact_number'); ?></td>
                        <td><?php echo $form->textField($model, 'contact_number'); ?></td>
                        <td><?php echo $form->error($model, 'contact_number'); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'contact_email_address'); ?></td>
                        <td><?php echo $form->textField($model, 'contact_email_address', array('size' => 50, 'maxlength' => 50)); ?></td>
                        <td><?php echo $form->error($model, 'contact_email_address',array('style'=>'text-transform:none;')); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'timezone_id'); ?></td>
                        <td>
                            <select id="Workstation_timezone_id" name="Workstation[timezone_id]">
                                <?php
                                    $timezoneList = Timezone::model()->findAll();
                                    foreach ($timezoneList as $key => $value) {
                                        ?>
                                        <option <?php
                                        if ($model['timezone_id'] == $value['id']) {
                                            echo " selected ";
                                        } elseif($model['timezone_id'] == '' && $value['timezone_value'] == $_SESSION["timezone"]) {
                                            echo " selected ";
                                        }
                                        ?> value="<?php echo $value['id']; ?>"><?php echo $value['timezone_name']; ?></option>
                                        <?php
                                    }?>
                            </select>


                        </td>
                        <td><?php echo $form->error($model, 'timezone_id',array('style'=>'text-transform:none;')); ?></td>
                    </tr>

                    <input type="hidden" id="Workstation_created_by" name="Workstation[created_by]" value="<?php echo $session['id']; ?>">

                </table>
            </td>
            <td>
                <div class="password-border" data-ng-show="Workstation['assign_kiosk']">
                    <table class="no-margin-bottom">
                        <tr>
                            <td><strong>Password Options</strong></td>
                        </tr>

                        <tr>
                            <td>
                                <table
                                    style=" margin-top:18px !important; width:253px; border-left-style:none; border-top-style:none">
                                    <tr>
                                        <td id="pass_error_" style='font-size: 0.9em;color: #FF0000; display:none'>Select Atleast
                                            One option
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <input id="Workstation_password"
                                                   name="Workstation[password]"
                                                   ng-model="workstation.passwords"
                                                   data-ng-class="{'ng-invalid':userform['Workstation[repeatpassword]'].$error.match}"
                                                   placeholder="Password" type="password"
                                                   value="<?php echo $model->password; ?>"
                                                   >
                                            <span class="required">*</span>
                                            <?php echo "<br>" . $form->error($model, 'password'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input id="Workstation_repeat_password"
                                                   name="Workstation[repeatpassword]"
                                                   type="password"
                                                   ng-model="workstation.passwordConfirm"
                                                   data-match="workstation.passwords"
                                                   placeholder="Repeat Password" /> <span class="required">*</span>

                                            <div style='font-size: 0.9em;color: #FF0000;'
                                                 data-ng-show="workstationform['Workstation[repeatpassword]'].$error.match">New Password does not
                                                match with <br>Repeat New Password.
                                            </div>
                                            <?php echo "<br>" . $form->error($model, 'repeatpassword'); ?>
                                            <div style='font-size: 0.9em;color: #FF0000;'
                                                 data-ng-show="workstation['Workstation[repeatpassword]'].$error.match">New Password does not
                                                match with <br>Repeat New Password.
                                            </div>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td align="center">
                                            <div class="row buttons" style="margin-left:23.5px;">

                                                <?php $background = isset($companyLafPreferences) ? ("background:" . $companyLafPreferences->neutral_bg_color . ' !important;') : ''; ?>
                                                <input onclick="generatepassword();" class="complete btn btn-info"
                                                       style="<?php echo $background; ?>position: relative; width:178px; overflow: hidden; cursor: default;cursor:pointer;font-size:14px"
                                                       type="button" value="Autogenerate Password"/>

                                            </div>

                                        </td>
                                    </tr>

                                </table>
                            </td>
                        </tr>

                    </table>
                </div>
                <!-- password-border -->
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php
                if (empty($_GET['id']) && !Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'workstation/update'){
                    ?>
                    <table>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'card_type'); ?></td>

                            <td colspan="2">
                                <?php
                                $criteria = new CDbCriteria();
                                
                                $module = CHelper::get_allowed_module();
                                if( $module == "CVMS" || $module == "Both")
                                    $criteria->addInCondition("module", array(1));
                                if( $module == "AVMS" || $module == "Both" )
                                    $criteria->addInCondition("module", array(2));
                                
                                echo  $form->checkBoxList(
                                    $model,'card_type',
                                    CHtml::listData(
                                        CardType::model()->findAll($criteria),'id', 'name'),
                                    array('separator'=>' ',
                                        'labelOptions'=>array('style'=>'display:inline')
                                    )
                                );
                                ?>
                                <?php echo $form->error($model, 'card_type'); ?>
                            <td>
                        </tr>
                    </table>
                <?php
                }
                ?>

            </td>
        </tr>
    </table>


    <div class="row buttons buttonsAlignToRight">
        <?php
        $arrayRuleButton = null;
        if($model->password){
            $arrayRuleButton = array("class"=>"complete", "data-ng-disabled"=>"Workstation['assign_kiosk']? workstation['Workstation[repeatpassword]'].\$error.match : false");
        }
        else {
            $arrayRuleButton = array("class"=>"complete", "data-ng-disabled"=>"Workstation['assign_kiosk']? workstation['Workstation[repeatpassword]'].\$error.match || !workstation.passwordConfirm : false");
        }

        ?>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', $arrayRuleButton ); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

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
                    <td colspan="2" style="padding-left:55px; padding-top:24px;"><input readonly="readonly" type="text"
                                                                                        placeholder="Random Password"
                                                                                        value="" id="random_password"/>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" style="padding-left:10px; font:italic">Note: Please copy and save this password
                        somewhere safe.
                    </td>
                </tr>
                <tr>
                    <td style="padding-left: 11px;padding-top: 26px !important; width:50%"><input
                            onclick="copy_password();" style="border-radius: 4px; height: 35px; " type="button"
                            value="Use Password"/></td>
                    <td style="padding-right:10px;padding-top: 25px;"><input onclick="cancel();"
                                                                             style="border-radius: 4px; height: 35px;"
                                                                             type="button" value="Cancel"/></td>
                </tr>

            </table>


        </div>
        <a data-toggle="modal" data-target="#generate_password" id="gen_pass" style="display:none"
           class="btn btn-primary">Click me</a>
    </div>
</div>


<script>
    $(document).ready(function() {
        if('<?php echo $session['role']; ?>' == 1){
            getTenantAgent();
        }
        
    });
    function getTenantAgent() {
        var tenant = $("#Workstation_tenant").val();

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('user/GetTenantAgentAjax&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('#Workstation_tenant_agent option[value!=""]').remove();
                $.each(r.data, function(index, value) {
                    $('#Workstation_tenant_agent').append('<option value="' + value.tenant_agent + '">' + value.name + '</option>');

                });
            }
        });
    }
    function cancel() {
        $('#User_repeat_password').val('');
        $('#User_password').val('');
        $("#random_password").val('');
        $("#close_generate").click();
    }

    function copy_password() {
        if ($('#random_password').val() == '') {
            $('#error_msg').show();
        } else {

            $('#Workstation_password').val($('#random_password').val());
            $('#Workstation_repeat_password').val($('#random_password').val());
            $("#close_generate").click();

        }

    }


    function generatepassword() {

        $("#random_password").val('');
        $("#pass_option").prop("checked", true);

        var text = "";
        var possible = "abcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < 6; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        document.getElementById('random_password').value = text;


        $("#gen_pass").click();
    }
    function addCompany() {
        if ($("#User_tenant").val() == '' && $("#currentRole").val() != 5) {
            $("#User_company_em_").show();
            $("#User_company_em_").html('Please select a tenant');
        } else {
            var url = '<?php echo $this->createUrl('company/create&viewFrom=1') ?>';
            var sessionRole = $("#currentRole").val();
            var selectedRole = $("#User_role").val();
            var tenant = $("#User_tenant").val();
            var superadmin = 5;
            var agentadmin = 6;
            if (sessionRole == superadmin) {
                if (selectedRole == agentadmin) {
                    url = '<?php echo $this->createUrl('company/create&viewFrom=1&tenant=') ?>' + tenant;
                }
            }

            $("#modalBody").html('<iframe width="100%" id="companyModalIframe" height="98%" frameborder="0" scrolling="no" src="' + url + '" ></iframe>');
            $("#modalBtn").click();
        }
    }

    function dismissModal(id) {
        $("#dismissModal").click();
        if ($("#User_role").val() == "6") {
            populateCompanyofTenant($("#User_tenant").val(), id);
        } else if ($("#User_role" == 1 && $("#currentRole").val() == 5)) {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('company/GetCompanyList&lastId='); ?>',
                dataType: 'json',
                success: function (r) {
                    $('#User_company option[value!=""]').remove();
                    $('#User_company_base option[value!=""]').remove();

                    $.each(r.data, function (index, value) {
                        $('#User_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                        $('#User_company_base').append('<option value="' + value.id + '">' + value.name + '</option>');
                        document.getElementById('User_company').disabled = false;
                        $("#User_company").val(value.id);
                    });

                }
            });
        }
    }
</script>