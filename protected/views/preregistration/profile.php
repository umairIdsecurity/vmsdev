<?php
$session = new CHttpSession;
$countryList = CHtml::listData(Country::model()->findAll(), 'id', 'name');
?>

<style>
    
    .required{
        color: red;
        margin-left: 315px;
        margin-top: -23px;
        position: absolute;
    }

    #addCompanyLink {
        width: 124px;
        height: 23px;
        padding-right: 0px;
        margin-right: 0px;
        padding-bottom: 0px;
        display: block;
    }

    .form-label {
        display: block;
        width: 200px;
        float: left;
        margin-left: 15px;
    }

    .ajax-upload-dragdrop {
        float:left !important;
        margin-top: -30px;
        background: url('<?php echo Yii::app()->controller->assetsBase; ?>/images/portrait_box.png') no-repeat center top;
        background-size:137px;
        height: 104px;
        width: 120px !important;
        padding: 87px 5px 12px 72px;
        margin-left: 20px !important;
        border:none;
    }

    .uploadnotetext {
        margin-top: 110px;
        margin-left: -80px;

    }

    #content h1 {
        color: #2f96b4;
        font-size: 18px;
        font-weight: bold;
        margin-left: 50px;
    }

</style>

   

<div class="page-content">
    
    <h1 class="text-primary title">Visitor Profile</h1>
    
    <?php
        foreach(Yii::app()->user->getFlashes() as $key => $message) {
            echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
        }
    ?>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id'                     => 'profile-form',
        'htmlOptions'            => array("name" => "profileform"),
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'clientOptions'          => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>


    <div>

        <table id="addvisitor-table">
            <tr>
                <td>
                    <table style="width:300px;float:left">
                        <tr>
                            <td id="uploadRow" rowspan="7" style='width:300px;padding-top:10px;'>
                                <table>
                                    <input type="hidden" id="Visitor_photo" name="Visitor[photo]" value="<?php echo $model['photo']; ?>">
                                    
                                    <div class="photoDiv" style="">
                                        <?php   
                                                if ($model['photo'] != NULL) 
                                                {
                                                    $data = Photo::model()->returnVisitorPhotoRelativePath($model->id);
                                                    $my_image = '';
                                                    if(!empty($data['db_image']))
                                                    {
                                                        $my_image = "data:image;base64," . $data['db_image'];
                                                    }
                                                    else
                                                    {
                                                        $my_image = $data['relative_path'];
                                                    }
                                                 ?>
                                                    <center><img id='photoPreview' src = "<?php echo $my_image ?>" style='display:block;height:174px;width:133px;'/></center>
                                        <?php 
                                                }
                                                elseif($model['photo'] == NULL)
                                                {
                                        ?>
                                                    <center><img id='photoPreview' src="<?php echo Yii::app()->controller->assetsBase; ?>/images/portrait_box.png" style='display:block;height:174px;width:133px;'/></center>
                                        <?php
                                                }
                                        ?>

                                        <br>       
                                        <center><input type="file" name="fileInput" id="fileInputId" /></center>

                                        <br>   
                                        <center><input type="button" id="uploadPhotoBtn" value="Upload Photo" class='btn btn-primary bt-login'></center>

                                        <br>   
                                        <center><p id="photoError" style="color:red;display:none;">Please browse a photo first.</p></center>

                                    </div>

                                    </td>
                                    </tr>
                                </table>
                                <table style="margin-top:70px;width:300px;">
                                    <tr>
                                        <td>
                                            <?php

                                                $account=Yii::app()->user->getState('account');
                                                $types = '';
                                                if($account == 'CORPORATE'){
                                                    $types = VisitorType::model()->findAll('t.is_deleted = 0 and module = :m', array(':m' => "CVMS"));
                                                }else{
                                                    $types = VisitorType::model()->findAll('t.is_deleted = 0 and module = :m', array(':m' => "AVMS"));
                                                }

                                                $list = array();
                                                foreach ($types as $key => $type) {
                                                    $list[$type['id']]=$type['name'];
                                                }
                                                
                                                echo $form->dropDownList($model,'visitor_type',$list,array('class' => 'form-control','empty' => 'Select Visitor Type', 'style' => '')); 
                                            ?>
                                            <span class="required">*</span>
                                            <?php echo "<br>" . $form->error($model, 'visitor_type'); ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table style="float:left;width:300px;margin-left:55px">
                        <tr>
                            <td>
                                <?php echo $form->textField($model, 'first_name', array('class' => 'form-control', 'maxlength' => 15, 'placeholder' => 'First Name')); ?>
                                <span class="required">*</span>
                                <?php echo $form->error($model, 'first_name'); ?>
                            </td>
                        </tr>
                        
                        <tr><td>&nbsp;</td></tr>
                        
                        <tr>
                            <td>
                                <?php echo $form->textField($model, 'middle_name', array('class' => 'form-control input-xs', 'maxlength' => 50, 'placeholder' => 'Middle Name')); ?>
                            </td>
                        </tr>

                        <tr><td>&nbsp;</td></tr>
                        
                        <tr>
                            <td>
                                <?php echo $form->textField($model, 'last_name', array('class' => 'form-control input-xs', 'maxlength' => 15, 'placeholder' => 'Last Name')); ?>
                                <span class="required">*</span>
                                <?php echo $form->error($model, 'last_name'); ?>
                            </td>
                        </tr>

                        <tr><td>&nbsp;</td></tr>
                        
                        <tr>
                            <td class="">
                                <span>Date of Birth</span> <br/>
                                <?php
                                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'model'       => $model,
                                        'attribute'   => 'date_of_birth',
                                        'options'     => array(
                                            'dateFormat' => 'dd-mm-yy',
                                            'changeMonth' => true,
                                            'changeYear' => true
                                        ),
                                        'htmlOptions' => array(
                                            
                                            'maxlength'   => '10',
                                            'placeholder' => 'Date of birth',
                                            /*'style'       => 'width: 80px;',*/
                                            'class' => 'form-control input-xs'
                                        ),
                                    ));
                                    ?>
                                <span class="required">*</span>

                                <?php echo $form->error($model, 'date_of_birth'); ?>
                            </td>
                        </tr>

                        <tr><td>&nbsp;</td></tr>
                        
                        <tr>
                            <td width="37%">
                                <?php echo $form->textField($model, 'email', array('class' => 'form-control input-xs', 'maxlength' => 50, 'placeholder' => 'Email Address')); ?>
                                <span class="required">*</span>
                                <?php echo $form->error($model, 'email', array('style' => 'text-transform:none;')); ?>
                                <!-- <div style="" class="errorMessageEmail">A profile already exists for this email address.</div> -->
                            </td>
                        </tr>
                        
                        <tr><td>&nbsp;</td></tr>
                        
                        <tr>
                            <td>
                                <?php echo $form->textField($model, 'contact_number', array('class' => 'form-control input-xs', 'maxlength' => 50, 'placeholder' => 'Mobile Number')); ?>
                                <span class="required">*</span>
                                <?php echo $form->error($model, 'contact_number'); ?>
                            </td>
                        </tr>

                        <tr><td>&nbsp;</td></tr>
                        

                        <tr>
                            <td>
                                <?php echo $form->textField($model, 'contact_unit', array('class' => 'form-control', 'maxlength' => 50, 'placeholder' => 'Unit', 'style' => 'width: 120px;')); ?>
                                <?php echo $form->textField($model, 'contact_street_no', array('class' => 'form-control', 'maxlength' => 50, 'placeholder' => 'Street No.', 'style' => 'width:175px;margin-top:-34px;margin-left:125px')); ?>
                                <span class="required">*</span>
                                <?php //echo $form->error($model, 'contact_unit'); ?>
                                <?php echo $form->error($model, 'contact_street_no',array('style' => 'margin-left:125px')); ?>
                            </td>
                        </tr>

                        <tr><td>&nbsp;</td></tr>
                        
                        <tr>
                            <td>
                                <?php echo $form->textField($model, 'contact_street_name', array('class' => 'form-control input-xs', 'maxlength' => 50, 'placeholder' => 'Street Name', 'style' => 'width: 175px;')); ?>
                                <?php echo $form->dropDownList($model, 'contact_street_type', Visitor::$STREET_TYPES, array('class' => 'form-control input-xs','empty' => 'Type', 'style' => 'width:120px;margin-top:-34px;margin-left:180px')); ?>
                                <span class="required">*</span>
                                <?php echo $form->error($model, 'contact_street_name'); ?>
                                <?php echo $form->error($model, 'contact_street_type'); ?>
                            </td>
                        </tr>

                        <tr><td>&nbsp;</td></tr>
                        
                        <tr>
                            <td>
                                <?php echo $form->textField($model, 'contact_suburb', array('class' => 'form-control input-xs', 'maxlength' => 50, 'placeholder' => 'Suburb')); ?>
                                <span class="required">*</span> <?php echo $form->error($model, 'contact_suburb'); ?>
                            </td>
                        </tr>

                        <tr><td>&nbsp;</td></tr>
                        
                        <tr>
                            <td>
                                <i id="cstate">
                                    <?php
                                    if(Yii::app()->controller->action->id == 'profile' && $model->contact_country == Visitor::AUSTRALIA_ID ) {
                                        echo $form->dropDownList($model, 'contact_state', Visitor::$AUSTRALIAN_STATES, array('class' => 'form-control input-xs','empty' => 'State', 'style' => 'width: 180px;'));
                                    } else {
                                        echo $form->textField($model, 'contact_state', array('class' => 'form-control input-xs', 'maxlength' => 50, 'placeholder' => 'State', 'style' => 'width:180px;'));
                                    } ?>
                                </i>
                                <select id="state_copy" style="display: none" class="form-control input-xs">
                                    <?php
                                    if(isset(Visitor::$AUSTRALIAN_STATES) && is_array(Visitor::$AUSTRALIAN_STATES)){
                                        foreach (Visitor::$AUSTRALIAN_STATES as $key=>$value):
                                            echo "<option name='$key'>$value</option>";
                                        endforeach;
                                    }
                                    ?>
                                </select>
                                <?php echo $form->textField($model, 'contact_postcode', array('class' => 'form-control input-xs', 'maxlength' => 50, 'placeholder' => 'Postcode', 'style' => 'width:115px;margin-top:-34px;margin-left:185px')); ?>
                                <span class="required">*</span>
                                <?php echo $form->error($model, 'contact_state'); ?>
                                <?php echo $form->error($model, 'contact_postcode'); ?>
                            </td>
                        </tr>

                        <tr><td>&nbsp;</td></tr>

                        <tr>
                            <td>
                                <?php
                                echo $form->dropDownList($model, 'contact_country', $countryList, array('class' => 'form-control input-xs','prompt' => 'Country', 'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                                ?><span class="required">*</span>
                                <?php echo $form->error($model, 'contact_country'); ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <div style="margin-bottom: 5px;" id="visitorStaffRow"></div>
                            </td>
                        </tr>
                    </table>


                    <table style="float:left;width:300px;margin-left:55px">
                            <tr>
                                <td>
                                    <?php echo $form->dropDownList($model, 'identification_type', Visitor::$IDENTIFICATION_TYPE_LIST, array('class' => 'form-control input-xs','prompt' => 'Identification Type'));
                                    ?><span class="required primary-identification-require">*</span>
                                    <?php echo $form->error($model, 'identification_type'); ?>
                                </td>
                            </tr>

                            <tr><td>&nbsp;</td></tr>

                            <tr>
                                <td>
                                    <?php
                                    echo $form->dropDownList($model, 'identification_country_issued', $countryList, array('class' => 'form-control input-xs','empty' => 'Country of Issue', 'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                                    ?><span class="required primary-identification-require">*</span>
                                    <?php echo $form->error($model, 'identification_country_issued'); ?>
                                </td>
                            </tr>

                            <tr><td>&nbsp;</td></tr>

                            <tr>
                                <td>
                                    <?php echo $form->textField($model, 'identification_document_no', array('class' => 'form-control input-xs', 'maxlength' => 50, 'placeholder' => 'Document No.', 'style' => 'width:175px;')); ?>

                                    <?php
                                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'model'       => $model,
                                        'attribute'   => 'identification_document_expiry',
                                        'options'     => array(
                                            'dateFormat' => 'dd-mm-yy',
                                            'changeMonth' => true,
                                            'changeYear' => true
                                        ),
                                        'htmlOptions' => array(
                                            'size'        => '0',
                                            'maxlength'   => '10',
                                            'placeholder' => 'Expiry',
                                            'style'       => 'width:120px;margin-top:-34px;margin-left:180px',
                                            'class' => 'form-control input-xs',
                                        ),
                                    ));
                                    ?><span class="required primary-identification-require">*</span>
                                    <?php echo $form->error($model, 'identification_document_no'); ?>
                                    <?php echo $form->error($model, 'identification_document_expiry'); ?>
                                </td>
                            </tr>

                            <tr><td>&nbsp;</td></tr>

                            <tr>
                                <td id="">
                                    <div style="margin-bottom: 5px;">
                                        <?php echo $form->textField($companyModel, 'name', array('class' => 'form-control input-xs','maxlength' => 50, 'placeholder' => 'Company Name', 'style' => '')); ?>
                                        <span class="required">*</span>
                                        <?php echo $form->error($companyModel, 'name', array("style" => "margin-top:0px")); ?>
                                    </div>
                                </td>
                            </tr>

                            <tr><td>&nbsp;</td></tr>

                            <tr>    
                                <td id="">
                                    <div style="margin-bottom: 5px;">
                                        <?php echo $form->textField($companyModel, 'contact', array('class' => 'form-control input-xs','maxlength' => 50, 'placeholder' => 'Company Contact Name', 'style' => '')); ?>
                                        <span class="required">*</span>
                                        <?php echo $form->error($companyModel, 'contact', array("style" => "margin-top:0px")); ?>
                                    </div>
                                </td>
                            </tr>

                            <tr><td>&nbsp;</td></tr>  

                            <tr>
                                <td id="">
                                    <div style="margin-bottom: 5px;">
                                        <?php echo $form->textField($companyModel, 'email_address', array('class' => 'form-control input-xs','maxlength' => 50, 'placeholder' => 'Email address', 'style' => '')); ?>
                                        <span class="required">*</span>
                                        <?php echo $form->error($companyModel, 'email_address', array("style" => "margin-top:0px")); ?>
                                    </div>
                                </td>
                            </tr>    

                            <tr><td>&nbsp;</td></tr>

                            <tr>    
                                <td id="">
                                    <div style="margin-bottom: 5px;">
                                        <?php echo $form->textField($companyModel, 'mobile_number', array('class' => 'form-control input-xs','maxlength' => 50, 'placeholder' => 'Contact Number', 'style' => '')); ?>
                                        <span class="required">*</span>
                                        <?php echo $form->error($companyModel, 'mobile_number', array("style" => "margin-top:0px")); ?>
                                    </div>
                                </td>
                            </tr> 
                                
                            
                        </table>

                        <div style="float:right;"><input type="submit" value="Save" name="yt0" id="submitFormVisitor" class="btn btn-primary bt-login" style="margin-top: 15px;"/></div>
                </td>
            </tr>
        </table>
       
        <!-- <input type="hidden" name="Visitor[visitor_status]" value="<?php //echo VisitorStatus::VISITOR_STATUS_SAVE; ?>" style='display:none;' /> -->

    </div>
    <?php $this->endWidget(); ?>
</div>

<input type="hidden" id="currentAction" value="<?php echo $this->action->id; ?>">
<input type="hidden" id="currentRoleOfLoggedInUser" value="<?php echo $session['role']; ?>">
<input type="hidden" id="currentlyEditedVisitorId" value="<?php if (isset($_GET['id'])) { echo $_GET['id']; } ?>">


<script type="text/javascript">

    $(document).ready(function() {

        $("#uploadPhotoBtn").click(function(event){
            
            var file_data = $("#fileInputId")[0].files[0];

            if(file_data == undefined){
                $("#photoError").show();
            }
            else
            {
                $("#photoError").hide();

                var form_data = new FormData();                  
                form_data.append("fileInput", file_data);
                $.ajax({
                    type: 'POST',
                    url: "<?php echo Yii::app()->createUrl('preregistration/uploadProfilePhoto');?>",
                    data: form_data,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        var data = JSON.parse(result);
                        //console.log(data);
                        $("#photoPreview").attr('src','');
                        $("#photoPreview").attr('src', "data:image;base64,"+data.db_image);
                        $("#Visitor_photo").val(data.photoId);
                        $("#fileInputId").val("");

                        $("#photoError").empty();
                        $("#photoError").append("Photo uploaded successfully.").css("color","green").show();
                        
                        $("#photoError").delay(3000).fadeOut(0,function() {
                            $("#photoError").empty();
                            $("#photoError").append("Please browse a photo first.").css("color","red");
                        });

                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }
           
            
            
            

        });





    });

</script>