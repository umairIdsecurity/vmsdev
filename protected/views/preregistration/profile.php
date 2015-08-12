<?php

$session = new CHttpSession;

/*$dataId = '';

if ($this->action->id == 'update') {
    $dataId = $_GET['id'];
}*/

$countryList = CHtml::listData(Country::model()->findAll(), 'id', 'name');
// set default country is Australia = 13

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
                                    <input type="hidden" id="Visitor_photo" name="Visitor[photo]"
                                           value="<?php echo $model['photo']; ?>">
                                    
                                    <?php if ($model['photo'] != NULL)
                                     {
                                        $data = Photo::model()->returnVisitorPhotoRelativePath($model->id);
                                        $my_image = '';
                                        if(!empty($data['db_image'])){
                                            $my_image = "url(data:image;base64," . $data['db_image'] . ")";
                                        }else{
                                            $my_image = "url(" .$data['relative_path'] . ")";
                                        }
                                        
                                     ?>
                                        <style>
                                            .ajax-upload-dragdrop {
                                                background: <?php echo $my_image ?> no-repeat center top !important;
                                                background-size: 137px 190px !important;
                                            }
                                        </style>
                                    <?php 
                                     }
                                    ?>

                                    <br>
                                    
                                    <?php //require_once(Yii::app()->basePath . '/draganddrop/index.php'); ?>
                                    

                                    <div class="photoDiv" style="">
                                        <?php   
                                                if (/*$dataId != '' &&*/$model['photo'] != NULL) 
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
                                                    <img id='photoPreview'
                                                         src = "<?php echo $my_image ?>"
                                                         style='display:block;height:174px;width:133px;'/>
                                        <?php 
                                                }
                                                elseif($model['photo'] == NULL)
                                                {
                                        ?>
                                                    <img id='photoPreview'
                                                        src="<?php echo Yii::app()->controller->assetsBase; ?>/images/portrait_box.png"
                                                        style='display:block;height:174px;width:133px;'/>
                                        <?php
                                                }
                                        ?>




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
                                        <?php echo $form->textField($companyModel, 'trading_name', array('class' => 'form-control input-xs','maxlength' => 50, 'placeholder' => 'Trading Name', 'style' => '')); ?>
                                        <span class="required">*</span>
                                        <?php echo $form->error($companyModel, 'trading_name', array("style" => "margin-top:0px")); ?>
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
                                        <?php echo $form->textField($companyModel, 'contact', array('class' => 'form-control input-xs','maxlength' => 50, 'placeholder' => 'Contact Number', 'style' => '')); ?>
                                        <span class="required">*</span>
                                        <?php echo $form->error($companyModel, 'contact', array("style" => "margin-top:0px")); ?>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <div style="float:right;"><input type="submit" value="Save" name="yt0" id="submitFormVisitor" class="complete" style="margin-top: 15px;"/></div>
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


<script>

/*    $(document).ready(function () {

       $(".workstationRow").show();
        getWorkstation();

        $('#Visitor_identification_document_expiry').datepicker({
            minDate: '0',
            maxDate: '+2y +2m',
            changeYear: true,
            changeMonth: true
        });

        $('#photoCropPreview').imgAreaSelect({
            handles: true,
            onSelectEnd: function (img, selection) {
                $("#cropPhotoBtn").show();
                $("#x1").val(selection.x1);
                $("#x2").val(selection.x2);
                $("#y1").val(selection.y1);
                $("#y2").val(selection.y2);
                $("#width").val(selection.width);
                $("#height").val(selection.height);
            }
        });

        $("#cropPhotoBtn").click(function (e) {
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
                    //imageUrl: $('#photoPreview').attr('src').substring(1, $('#photoPreview').attr('src').length),
                    photoId: $('#Visitor_photo').val()
                },
                dataType: 'json',
                success: function (r) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('photo/GetPathOfCompanyLogo&id='); ?>' + $('#Visitor_photo').val(),
                        dataType: 'json',
                        success: function (r) {
                            $.each(r.data, function (index, value) {
                                /*document.getElementById('photoPreview').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                document.getElementById('photoCropPreview').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                $(".ajax-upload-dragdrop").css("background", "url(" + value.relative_path + ") no-repeat center top");
                                $(".ajax-upload-dragdrop").css({"background-size": "132px 152px"});*/

                                //showing image from DB as saved in DB -- image is not present in folder
                                /*var my_db_image = "url(data:image;base64,"+ value.db_image + ")";

                                document.getElementById('photoPreview').src = "data:image;base64,"+ value.db_image;
                                document.getElementById('photoCropPreview').src = "data:image;base64,"+ value.db_image;
                                $(".ajax-upload-dragdrop").css("background", my_db_image + " no-repeat center top");
                                $(".ajax-upload-dragdrop").css({"background-size": "132px 152px" });
                            
                                
                            });


                            $("#closeCropPhoto").click();
                            var ias = $('#photoCropPreview').imgAreaSelect({instance: true});
                            ias.cancelSelection();
                        }
                    });
                }
            });

            $("#closeCropPhoto").click(function() {
                var ias = $('#photoCropPreview').imgAreaSelect({instance: true});
                ias.cancelSelection();
            });
        });
    });*/
</script>



<?php

$this->widget('bootstrap.widgets.TbButton', array(
    'label'       => 'Click me',
    'type'        => 'primary',
    'htmlOptions' => array(
        'data-toggle' => 'modal',
        'data-target' => '#addCompanyModal',
        'id'          => 'modalBtn',
        'style'       => 'display:none',
    ),
));

?>

<div class="modal hide fade" id="addCompanyModal" style="width:600px;">
    <div class="modal-header">
        <a data-dismiss="modal" class="close" id="dismissModal">×</a>
        <br>
    </div>
    <div id="modalBody">
    </div>

</div>
<!-- PHOTO CROP-->
<div id="light" class="white_content">
    <?php if ($this->action->id == 'addvisitor') { ?>
        <img id="photoCropPreview" src="">
    <?php } elseif ($this->action->id == 'update') {
                $data = Photo::model()->returnVisitorPhotoRelativePath($model->id);
                $my_image = '';
                if(!empty($data['db_image'])){
                    $my_image = "data:image;base64," . $data['db_image'];
                }else{
                    $my_image = $data['relative_path'];
                }
     ?>

        <img id="photoCropPreview"
            src = "<?php echo $my_image ?>" >
    <?php } ?>
</div>

<div id="fade" class="black_overlay"></div>
<div id="crop_button">
    <input type="button" class="btn btn-success" id="cropPhotoBtn" value="Crop" style="">
    <input type="button" id="closeCropPhoto" onclick="document.getElementById('light').style.display = 'none';
                document.getElementById('fade').style.display = 'none';
                document.getElementById('crop_button').style.display = 'none'" value="x" class="btn btn-danger">
</div>
<input type="hidden" id="x1"/>
<input type="hidden" id="x2"/>
<input type="hidden" id="y1"/>
<input type="hidden" id="y2"/>
<input type="hidden" id="width"/>
<input type="hidden" id="height"/>