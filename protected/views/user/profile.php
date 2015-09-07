
<?php
/* @var $this UserController */
/* @var $model User */
$session = new CHttpSession;
//echo $session['workstation'];
?>
<style type="text/css">
    #modalBody_gen {padding-top: 10px !important;height: 204px !important;}
    #addCompanyLink {
        display: block;
        height: 23px;
        margin-right: 0;
        padding-bottom: 0;
        padding-right: 0;
        width: 124px;
    }
    .uploadnotetext{margin-left: -80px;margin-top: 79px;}
    .required{ padding-left:10px;}

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
    .ajax-file-upload{
        margin-left: -100px !important;
        margin-top: 128px !important;
        position:absolute !important;
        font-size: 12px !important;
        padding-bottom:3px;
        height:17px;
    }

    .editImageBtn{
        margin-left: -103px !important;
        color:white;
        font-weight:bold;
        text-shadow: 0 0 !important;
        font-size:12px !important;
        height:24px;
        width:131px !important;
    }
    .imageDimensions{
        display:none !important;
    }
    #cropImageBtn{
        float: left;
        margin-left: -54px !important;
        margin-top: 218px;
        position: absolute;
    }
    .required { padding-left:10px; }
    #content h1 { color: #E07D22;font-size: 18px;font-weight: bold;margin-left:75px; }
</style>

<h1>My Profile</h1>

<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */

if (isset($_GET['id'])) {
    $currentlyEditedUserId = $_GET['id'];
} else {
    $currentlyEditedUserId = '';
}
?>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
<div class="form" data-ng-app="PwordForm">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        'htmlOptions' => array("name" => "userform" ,'style'=>'float:left;'),
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
      echo $form->hiddenField($model,'tenant'); 
    ?>
    <?php echo $form->errorSummary($model); ?>

    <table style="width:300px;float:left;">
        <tr>

            <td style="width:300px;">
                <!-- <label for="Visitor_Add_Photo" style="margin-left:27px;">Add  Photo</label><br>-->
                <?php echo $form->hiddenField($model,'photo',array('id'=>'Host_photo')); ?>
                <!-- <input type="hidden" id="Host_photo" name="User[photo]">-->
                <div class="photoDiv" style='display:none;'>
                    <img id='photoPreview2' src="<?php echo Yii::app()->controller->assetsBase; ?>/images/portrait_box.png" style='display:none;'/>
                </div>
                
                <?php  $this->renderPartial('application.draganddrop.profile',array('model'=>$model)); ?>

                <div id="photoErrorMessage" class="errorMessage" style="display:none;  margin-top: 200px;margin-left: 71px !important;position: absolute;">Please upload a photo.</div>
            </td>
        </tr>

        <tr><td>&nbsp;</td></tr>
    </table>
    <table style="width: 500px; float: left;" >
        <tr>
            <td>
            <p class="note">Fields with <span class="required">*</span> are required.</p>
            </td>
        </tr>
        <tr>
            <td><?php echo $form->textField($model, 'first_name',
                    array('size' => 50, 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('first_name')));?>
                <?php echo $model->isRequired('first_name');?>
            </td>
            <td><?php echo $form->error($model, 'first_name'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->textField($model, 'last_name',
                    array('size' => 50, 'maxlength' => 50,'placeholder' => $model->getAttributeLabel('last_name'))); ?>
                <?php echo $model->isRequired('last_name');  ?>
            </td>
            <td><?php echo $form->error($model, 'last_name'); ?></td>
        </tr>
        <tr>
            <td>
                <?php echo $form->dropDownList(
                    $model,
                    'role',
                    User::$USER_ROLE_LIST,
                    array('disabled' => 'disabled')
                ); ?>
                <?php echo $model->isRequired('company'); ?>
            </td>
            <td><?php echo $form->error($model, 'company'); ?></td>
        </tr>
        <tr>
            <td>
                <?php echo $form->dropDownList($model, 'company',
                    $companyList = CHtml::listData(Company::model()->findAllCompany(), 'id', 'name')
                   ,array('disabled'=>'disabled')); ?>
                <?php echo $model->isRequired('company');  ?>
            </td>
            <td><?php echo $form->error($model, 'company'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->textField($model, 'email',
                    array('size' => 50, 'maxlength' => 50,'placeholder' => $model->getAttributeLabel('email'))
                ); ?>
                <?php echo $model->isRequired('email');  ?></td>
            <td><?php echo $form->error($model, 'email',array('style' => 'text-transform:none;')); ?></td>
        </tr>
       
        <tr>
            <td><?php echo $form->textField($model, 'contact_number'
                    ,array('placeholder' => $model->getAttributeLabel('contact_number'))
                ); ?>
                <?php echo $model->isRequired('contact_number');  ?></td>
            <td><?php echo $form->error($model, 'contact_number'); ?></td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="buttons" style="margin-top: 20px;">
                    <button class="btn btn-success" id="submitBtn" <?php if ($session['role'] == Roles::ROLE_STAFFMEMBER){ echo "style='display:none;'"; } ?>><?php echo ($this->action->Id == 'create' ? 'Add' : 'Save') ?></button>
                    <a class="btn btn-primary actionForward " id="resetPasswordBtn" onclick = "goToUpdatePassword(<?php echo $session['id'];?>)" style="font-weight:bold;font-size:12px;height:23.4px;">Reset Password</a>
                    <div class="row buttons" style='display:none;'>
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array('id' => 'submitForm',)); ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<input type="hidden" id="currentAction" value="<?php echo $this->action->Id; ?>"/>
<input type="hidden" id="currentRole" value="<?php echo $session['role']; ?>"/>
<input type="hidden" id="userId" value="<?php echo $currentlyEditedUserId; ?>"/>
<input type="hidden" id="selectedUserId" value="<?php echo $session['id']; ?>"/>
<input type="hidden" id="sessionCompany" value="<?php echo $session['company']; ?>"/>
<script>

    $(document).ready(function() {
        var sessionRole = $("#currentRole").val(); //session role of currently logged in user
        var staffmember = 9;
        
        if (sessionRole == staffmember){
            document.getElementById('User_first_name').disabled = true;
            document.getElementById('User_last_name').disabled = true;
            document.getElementById('User_company').disabled = true;
            document.getElementById('User_email').disabled = true;
            document.getElementById('User_contact_number').disabled = true;
            document.getElementById('submitBtn').disabled = true;
        
        }
        
        $('form').bind('submit', function() {
            $(this).find('#User_company').removeAttr('disabled');
        });
    });
    function goToUpdatePassword(id){
        window.location ='index.php?r=password/update&id='+id;
    }

</script>