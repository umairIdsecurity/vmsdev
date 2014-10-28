<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/script-visitordetail.js');
$session = new CHttpSession;
?>
<div id='visitorInformationCssMenu'>
    <ul>
        <li class='has-sub'><a href="#"><span>Personal Details</span></a>
            <ul>
                <li>
                    <table id="personalDetailsTable" class="detailsTable">
                        <tr>
                            <td width="100px;">First Name:</td>
                            <td><?php echo $visitorModel->first_name; ?></td>
                        </tr>
                        <tr>
                            <td>Last Name:</td>
                            <td><?php echo $visitorModel->last_name; ?></td>
                        </tr>
                    </table>
                </li>
            </ul>
        </li>
        <li class='has-sub'><a href="#"><span>Contact Details</span></a>
            <ul>
                <li>
                    <?php
                    $visitorForm = $this->beginWidget('CActiveForm', array(
                        'id' => 'update-visitor-form',
                        'action' => Yii::app()->createUrl('/visitor/update&id=' . $model->visitor . '&view=1'),
                        'htmlOptions' => array("name" => "update-visitor-form"),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'afterValidate' => 'js:function(form, data, hasError){
                                if (!hasError){
                                    checkEmailIfUnique();
                                }
                                }'
                        ),
                    ));
                    ?>
                    <input type="hidden" id="emailIsUnique" value="0"/>
                    <table id="contactDetailsTable" class="detailsTable">
                        <tr>
                            <td width="100px;">Email:</td>
                            <td><?php echo $visitorForm->textField($visitorModel, 'email', array('size' => 50, 'maxlength' => 50)); ?>
                                <?php echo "<br>" . $visitorForm->error($visitorModel, 'email'); ?>
                                <div style="" id="Visitor_email_em_" class="errorMessage errorMessageEmail" >Email Address has already been taken.</div>
                            </td>
                        </tr>
                        <tr>
                            <td>Mobile:</td>
                            <td><input type="text" value="<?php echo $visitorModel->contact_number; ?>" name="Visitor[contact_number]" id="Visitor_contact_number"></td>
                        </tr>
                        <tr><td><input type="submit" value="Update" name="yt0" id="submitContactDetailForm" /></td></tr>
                    </table>
                    <?php $this->endWidget(); ?>
                </li>
            </ul>
        </li>
        <li class='has-sub'><a href="#"><span>Visitor Type</span></a>
            <ul>
                <li>
                    <?php
                    $visitForm = $this->beginWidget('CActiveForm', array(
                        'id' => 'update-visit-form',
                        'htmlOptions' => array("name" => "update-visit-form"),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'afterValidate' => 'js:function(form, data, hasError){
                                if (!hasError){
                                    //checkEmailIfUnique();
                                }
                                }'
                        ),
                    ));
                    ?>
                    <table id="visitorTypeTable" class="detailsTable">
                        <tr>
                            <td width="200px;"><?php echo $visitForm->labelEx($model, 'visitor_type'); ?></td>
                            <td><?php
                                echo $visitForm->dropDownList($model, 'visitor_type', VisitorType::$VISITOR_TYPE_LIST, array(
                                    'onchange' => 'showHideHostPatientName(this)',
                                ));
                                ?>
                                <?php echo "<br>" . $visitForm->error($model, 'visitor_type'); ?></td>
                        </tr>
                    </table>
                    <?php $this->endWidget(); ?>
                </li>
            </ul>
        </li>
        <li class='has-sub'><a href="#"><span>Reason</span></a>
            <ul>
                <li>
                    <?php
                    $reasonForm = $this->beginWidget('CActiveForm', array(
                        'id' => 'update-reason-form',
                        'action' => Yii::app()->createUrl('/visit/update&id=' . $model->reason),
                        'htmlOptions' => array("name" => "update-reason-form"),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'afterValidate' => 'js:function(form, data, hasError){
                                if (!hasError){
                                    if($("#Visit_reason").val() == "" || $("#Visit_reason").val() == "Other" ){
                                        $("#visitReason").show();
                                        
                                    }else 
                                    {
                                        $("#visitReason").hide();
                                        sendUpdateReasonForm();
                                    }
                                }
                                }'
                        ),
                    ));
                    ?>
                    <table id="reasonTable" class="detailsTable">
                        <tr>
                            <td width="100px;"><label for="Visit_reason">Reason</label></td>
                            <td>
                                <select id="Visit_reason" name="Visit[reason]" onchange="ifSelectedIsOtherShowAddReasonDiv(this)">
                                    <option value='' selected>Select Reason</option>
                                    <option value="Other">Other</option>
                                    <?php
                                    $reason = VisitReason::model()->findAllReason();
                                    foreach ($reason as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value->id; ?>" <?php
                                        if ($model->reason == $value->id) {
                                            echo " selected ";
                                        }
                                        ?>><?php echo $value->reason; ?></option>
                                                <?php
                                            }
                                            ?>

                                </select><br>
                                <?php echo $reasonForm->error($model, 'reason'); ?>
                                <div class="errorMessage visitorReason" id="visitReason">Reason cannot be blank.</div>
                            </td>
                        </tr>
                        <tr><td><input type="submit" value="Update" name="yt0" id="submitReasonForm" /></td></tr>
                    </table>
                    <?php $this->endWidget(); ?>
                    <?php
                    $addReasonForm = $this->beginWidget('CActiveForm', array(
                        'id' => 'add-reason-form',
                        'action' => Yii::app()->createUrl('/visitReason/create&register=1'),
                        'htmlOptions' => array("name" => "add-reason-form"),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'afterValidate' => 'js:function(form, data, hasError){
                                if (!hasError){
                                    checkReasonIfUnique();
                                }
                                }'
                        ),
                    ));
                    ?>
                    <table id="addreasonTable" class="detailsTable">
                        <tr>
                            <td width="100px;"><label for="VisitReason_reason">Reason</label></td>
                            <td><textarea id="VisitReason_reason" name="VisitReason[reason]" style="width:200px !important;text-transform: capitalize;" cols="80" rows="3"><?php
                                    echo $reasonModel->reason;
                                    ?></textarea> <?php echo $addReasonForm->error($reasonModel, 'reason'); ?>
                                <div class="errorMessage visitorReason" id="visitReasonErrorMessage">Reason cannot be blank.</div>
                            </td>
                        </tr>
                        <tr><td><input type="submit" value="Add" name="yt0" id="submitAddReasonForm" /></td></tr>
                    </table>
                    <?php $this->endWidget(); ?>
                </li>
            </ul>
        </li>
        <li class='has-sub'><a href="#"><span>Host Details</span></a>
            <ul>
                <li>
                    <?php
                    $hostForm = $this->beginWidget('CActiveForm', array(
                        'id' => 'update-host-form',
                        'action' => Yii::app()->createUrl('/user/update&id=' . $model->host),
                        'htmlOptions' => array("name" => "register-host-form"),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'afterValidate' => 'js:function(form,data,hasError){
                        if(!hasError){
                                checkHostEmailIfUnique();
                                }
                        }'
                        ),
                    ));
                    ?>
                    <input type="text" id="hostEmailIsUnique" value="0"/>
                    <table id="hostTable" class="detailsTable">
                        <tr>
                            <td width="100px;"><?php echo $hostForm->labelEx($hostModel, 'first_name'); ?></td>
                            <td>
                                <?php echo $hostForm->textField($hostModel, 'first_name', array('size' => 50, 'maxlength' => 50)); ?>
                                <?php echo "<br>" . $hostForm->error($hostModel, 'first_name'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="100px;"><?php echo $hostForm->labelEx($hostModel, 'last_name'); ?></td>
                            <td>
                                <?php echo $hostForm->textField($hostModel, 'last_name', array('size' => 50, 'maxlength' => 50)); ?>
                                <?php echo "<br>" . $hostForm->error($hostModel, 'last_name'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="100px;"><?php echo $hostForm->labelEx($hostModel, 'department'); ?></td>
                            <td>
                                <?php echo $hostForm->textField($hostModel, 'department', array('size' => 50, 'maxlength' => 50)); ?>
                                <?php echo "<br>" . $hostForm->error($hostModel, 'department'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="100px;"><?php echo $hostForm->labelEx($hostModel, 'staff_id'); ?></td>
                            <td>
                                <?php echo $hostForm->textField($hostModel, 'staff_id', array('size' => 50, 'maxlength' => 50)); ?>
                                <?php echo "<br>" . $hostForm->error($hostModel, 'staff_id'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="100px;"><?php echo $hostForm->labelEx($hostModel, 'email'); ?></td>
                            <td>
                                <?php echo $hostForm->textField($hostModel, 'email'); ?>
                                <?php echo "<br>" . $hostForm->error($hostModel, 'email'); ?>
                                <div style="" id="User_email_em_" class="errorMessage errorMessageEmail1" >Email Address has already been taken.</div>
                            </td>
                        </tr>
                        <tr>
                            <td width="100px;">Mobile:</td>
                            <td>
                                <?php echo $hostForm->textField($hostModel, 'contact_number'); ?>
                                <?php echo "<br>" . $hostForm->error($hostModel, 'contact_number'); ?>
                            </td>
                        </tr>
                        <tr><td><input type="submit" value="Update" name="yt0" id="submitReasonForm" /></td></tr>
                    </table>
                    <?php $this->endWidget(); ?>
                </li>
            </ul>
        </li>
    </ul>
</div>
