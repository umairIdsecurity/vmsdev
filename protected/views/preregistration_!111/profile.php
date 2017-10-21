<?php
$session = new CHttpSession;
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
    
    <div id="menu">
        <div class="row items" style="background-color:#fff;">
            <div class="col-sm-4 col-xs-6 text-center" style="background-color: #eeeeee; height:40px;border-right: 1px solid #fff;"><a href="<?php echo Yii::app()->createUrl('preregistration/dashboard'); ?>"><span class="glyphicon glyphicon-home"></span></a></div>
            <div class="col-sm-4 col-xs-6 text-center" style="background-color: #eeeeee; height:40px;"><a href="<?php echo Yii::app()->createUrl('preregistration/profile?id=' . $session['id']); ?>">My Profile</a></div>
        </div>
    </div>

    <br><br>
    
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


    <div class="row">
        <div class="col-sm-4 col-xs-12">
            <table>
                <input type="hidden" id="Visitor_photo" name="Registration[photo]" value="<?php echo $model['photo']; ?>">
                
                <div class="photoDiv" style="">
                    <?php
                        //**********************************************************************************
                        $data = Photo::model()->returnVisitorPhotoRelativePath($model->id);
                        $my_image = '';

                        if(!empty($data['db_image']))
                        {
                            $my_image = "data:image;base64," . $data['db_image'];
                        }
                        else
                        {
                            $my_image = Yii::app()->controller->assetsBase.'/images/portrait_box.png';
                        }

                        $this->widget('ext.NavaJcrop.ImageJcrop', array(
                            'config' => array(
                                'title'=>$model->photo,
                                'image'=>$my_image,//required, all field below are not required.
                                'id'=>'nava-Jcrop',
                                //'unique'=>true,
                                //'resultStyle'=>'position: relative; left: 50%; margin-left: -67px;',
                                'buttons'=>array(
                                    'cancel'=>array(
                                        'name'=>'Cancel',
                                        'class'=>'button-crop',
                                        'style'=>'margin-left: 5px;',
                                    ),
                                    'edit'=>array(
                                        'name'=>'Edit',
                                        'class'=>'button-crop',
                                        'style'=>'margin-left: 5px;',
                                    ),
                                    'crop'=>array(
                                        'name'=>'Crop',
                                        'class'=>'button-crop',
                                        'style'=>'margin-left: 5px;',
                                    )
                                ),
                                'options'=>array(
                                    'imageWidth'=>133,
                                    'imageHeight'=>174,
                                    'resultStyle'=>'position: fixed;top: 50px;max-width:1200px;max-height:1200px;z-index: 9999;',
                                    'resultMaxWidth'=>500,
                                    'resultMinWidth'=>500,
                                ),
                                'callBack'=> array(
                                    'success'=>"function(obj,res){doSomething(obj,res);}",
                                    'error'=>"function(){alert('error');}",
                                )
                            )
                        ));
                        //**********************************************************************************
                    ?>


                    <br>       
                    
                        <div class="">
                             &nbsp; <b>Drag &amp; Drop File</b>
                            <!-- <br>
                            <span style="font-size:10px;">Max Size: 2MB ;File Ext. : jpeg/png<br>
                                <span class="imageDimensions">Dimensions: 180px(Width) x 60px(Height)</span>
                            </span> -->
                        </div>
                    


                    <!-- <br>       
                    <center><input type="file" name="fileInput" id="fileInputId" /></center>

                    <br>   
                    <center><input type="button" id="uploadPhotoBtn" value="Upload Photo" class='btn btn-primary bt-login'></center>

                    <br>   
                    <center><p id="photoError" style="color:red;display:none;">Please browse a photo first.</p></center> -->

                </div>

                </td>
                </tr>
            </table>
        </div>


        <div class="col-sm-4 col-xs-5">
            <table style="">
                <tr>
                    <td id="uploadRow" rowspan="7" style=''>

                    </td>
                </tr>
            </table>

            <table style="">
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
                        <?php echo $form->textField($model, 'last_name', array('class' => 'form-control input-xs', 'maxlength' => 15, 'placeholder' => 'Last Name')); ?>
                        <span class="required">*</span>
                        <?php echo $form->error($model, 'last_name'); ?>
                    </td>
                </tr>

                <tr><td>&nbsp;</td></tr>
                
                <?php $role = Roles::model()->findByPk($model->role) ?>
                <!--<tr>
                    <td>
                        <input type="text" class="form-control input-xs" disabled="true" placeholder="User Role" value="<?= $role->name ?>"
                        <?php //echo $form->textField($model, 'role', array('class' => 'form-control input-xs', 'maxlength' => 50, 'placeholder' => 'User Role', 'disabled' => 'true')); ?>
                    </td>
                </tr>

                <tr><td>&nbsp;</td></tr>-->

                <?php if(isset($companyModel)): ?>
                   <!-- <tr>
                        <td id="">
                            <div style="margin-bottom: 5px;">
                                <?php //echo $form->textField($companyModel, 'name', array('class' => 'form-control input-xs','maxlength' => 50, 'placeholder' => 'Company Name', 'style' => '')); ?>
                                <span class="required">*</span>
                                <?php //echo $form->error($companyModel, 'name', array("style" => "margin-top:0px")); ?>
                            </div>
                        </td>
                    </tr>-->
                <?php else: ?>
                    <!--<tr>
                        <td id="">
                            <div style="margin-bottom: 5px;">
                                <?php//echo $form->dropDownList($model, 'company', CHtml::listData(Company::model()->findAll('is_deleted=0'),'id', 'name'), array('prompt' => 'Select Company' , 'class'=>'form-control input-sm')); ?>
                                <span class="required">*</span>
                                <?php //echo $form->error($model,'company'); ?>
                            </div>
                        </td>
                    </tr>-->
                <?php endif; ?>

               <!--<tr><td>&nbsp;</td></tr>-->
                
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
                        <?php echo $form->textField($model, 'contact_number', array('class' => 'form-control input-xs', 'maxlength' => 50, 'placeholder' => 'Contact Number')); ?>
                        <span class="required">*</span>
                        <?php echo $form->error($model, 'contact_number'); ?>
                    </td>
                </tr>

                <?php if($model->profile_type == "VIC"): ?>
				<tr><td>&nbsp;</td></tr>
				 <tr>
                                <td>
                                    <?php echo $form->dropDownList($model, 'identification_type', Visitor::$IDENTIFICATION_TYPE_LIST, array('prompt' => 'Select Identification Type','class' => 'form-control input-xs'));
                                    ?><span class="required primary-identification-require">*</span>
                                    <?php echo "<br>" . $form->error($model, 'identification_type'); ?>
                                </td>
                  </tr>
                
                <tr>
                    <td>
                        <?php echo $form->textField($model, 'identification_document_no', array('class' => 'form-control input-xs', 'maxlength' => 50, 'placeholder' => 'Document No.',)); ?>
						<span class="required">*</span>
						 <?php echo $form->error($model, 'identification_document_no'); ?>
				   </td>
				</tr>
				 <tr><td>&nbsp;</td></tr>
				<tr>
					<td>
                        <?php
                            $this->widget('EDatePicker', array(
                                'model'       => $model,
                                'attribute'   => 'identification_document_expiry',
                                'mode'        => 'expiry',
								'htmlOptions' => array(
                                        'style'    => 'width:280px;height: 32px;')
                            ));
                        ?>
                        <span class="required">*</span>
                       
                        <?php echo $form->error($model, 'identification_document_expiry'); ?>
                    </td>
                </tr>
                <?php endif; ?>

                <?php if($model->profile_type == "ASIC"): ?>
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td>
                        <?php echo $form->textField($model, 'asic_no', array('class' => 'form-control input-xs', 'maxlength' => 50, 'placeholder' => 'Asic No.', 'style' => 'width:175px;')); ?>
						<span class="required">*</span>
						<?php echo $form->error($model, 'asic_no'); ?>
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td>
                        <?php
                            $this->widget('EDatePicker', array(
                                'model'       => $model,
                                'attribute'   => 'asic_expiry',
                                'mode'        => 'asic_expiry',
								'htmlOptions' => array(
                                        'style'    => 'width:280px;height: 32px;')
                            ));
                        ?>
                        <span class="required">*</span>
                        
                        <?php echo $form->error($model, 'asic_expiry'); ?>
                    </td>
                </tr>
                <?php endif; ?>
				

                <?php if($model->profile_type == "VIC"): ?>
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td class="">
                        <!-- <span>Date of Birth</span> <br/> -->
                        <?php
                            $this->widget('EDatePicker', array(
                                'model'       => $model,
                                'attribute'   => 'date_of_birth',
                                'mode'        => 'date_of_birth',
								'htmlOptions' => array(
                                        'style'    => 'width:280px;height: 32px;')
                            ));
                            ?>
                        <span class="required">*</span>

                        <?php echo $form->error($model, 'date_of_birth'); ?>
                    </td>
                </tr>
                <?php endif; ?>

                
                <tr><td>&nbsp;</td></tr>


               <!-- <tr>    
                    <td>
                        <span>Reset Password</span>
                    </td>
                </tr> 

                <tr><td>&nbsp;</td></tr>
                
                <tr>    
                    <td id="">
                        <div style="margin-bottom: 5px;">
                            <?php echo $form->passwordField($model,'old_password', array('class' => 'form-control input-xs','maxlength' => 50, 'placeholder' => 'Old Password', 'style' => '')); ?>
                                
                            <span style="color:red;margin-top:0px"><?php echo $old_passwordErr; ?></span>
                            <?php echo $form->error($model,'old_password', array("style" => "margin-top:0px")); ?>
                        </div>
                    </td>
                </tr> 

                    <tr><td>&nbsp;</td></tr>

                    <tr>    
                        <td id="">
                            <div style="margin-bottom: 5px;">
                                <?php echo $form->passwordField($model,'new_password', array('class' => 'form-control input-xs','maxlength' => 50, 'placeholder' => 'New Password', 'style' => '')); ?>
                                
                                <span style="color:red;margin-top:0px"><?php echo $new_passwordErr; ?></span>
                                <?php echo $form->error($model,'new_password', array("style" => "margin-top:0px")); ?>
                            </div>
                        </td>
                    </tr> 

                    <tr><td>&nbsp;</td></tr>

                    <tr>    
                        <td id="">
                            <div style="margin-bottom: 5px;">
                                <?php echo $form->passwordField($model,'repeat_password', array('class' => 'form-control input-xs','maxlength' => 50, 'placeholder' => 'Repeat New Password', 'style' => '')); ?>
                                
                                <span style="color:red;margin-top:0px"><?php echo $repeat_passwordErr; ?></span>
                                <?php echo $form->error($model,'repeat_password', array("style" => "margin-top:0px")); ?>
                            </div>
                        </td>
                    </tr>  -->

                <tr>
                    <td>
                        <div>
						<input type="submit" value="Save" name="yt0" id="submitFormVisitor" class="btn btn-primary bt-login" style="margin-top: 15px;"/>
						 <a class="btn btn-primary actionForward " id="resetPasswordBtn" onclick = "goToUpdatePassword(<?php echo $session['id'];?>)" style="margin-top: 15px;">Reset Password</a>
						</div>
                    </td>
                </tr> 

            </table>
        </div>
    </div>        
    <!-- <input type="hidden" name="Visitor[visitor_status]" value="<?php //echo VisitorStatus::VISITOR_STATUS_SAVE; ?>" style='display:none;' /> -->
    <?php $this->endWidget(); ?>
</div>

<input type="hidden" id="currentAction" value="<?php echo $this->action->id; ?>">
<input type="hidden" id="currentRoleOfLoggedInUser" value="<?php echo $session['role']; ?>">
<input type="hidden" id="currentlyEditedVisitorId" value="<?php if (isset($_GET['id'])) { echo $_GET['id']; } ?>">


<script type="text/javascript">

        function doSomething(obj,res){ //the 'obj' is IMG tag, 'res' is base64image
            $.ajax({
                cache: false,
                type: 'post',
                url: "<?php echo Yii::app()->createUrl('preregistration/uploadProfilePhoto');?>",
                data: 'image='+res,
                success: function(){
                    obj.attr('src',res);
                }
            });
        }

/*    $(document).ready(function() {

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
    });*/
	function goToUpdatePassword(id){
        window.location ='/index.php/preregistration/update?id='+id;
    }

</script>