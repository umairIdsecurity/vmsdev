<?php
/* @var $this PasswordController */
/* @var $model Password */

$this->breadcrumbs=array(
	'Passwords'=>array('index'),
	'Update',
);


?>

<h1>Reset Password </h1>
<?php if(Yii::app()->user->hasFlash('update')): ?>
<div class="flash-success">
<?php echo Yii::app()->user->getFlash('update'); ?>
</div>
<?php endif; ?>

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
<div class="form" data-ng-app="myApp">
 
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'password-form',
    'htmlOptions' => array("name"=>"passwordform"),
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
)); ?>
    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model);?>
   
    <input name="Password[passwordindb]" id="Password_passwordindb" type="hidden" value='<?php echo $model->password; ?>'>
    <table>    
        <tr>
            <td>
                <div class="row">
                    <b>Current Password:</b> 
                </div>
            </td>
            <td>
                <input type='password' name="Password[currentpassword]" id="Password_currentpassword" type="text" maxlength="150" >
                <span class="required">*</span><?php echo $form->error($model, 'password'); ?>
            </td>
        </tr>
    <tr>
        <td>
            <div class="row">
        <b>New Password:</b> 
            </div>
        </td>
        <td><input ng-model="user.passwords" type="password" name="Password[password]" data-ng-class="{'ng-invalid':passwordform.confirmPassword.$error.match}" />
            <span class="required">*</span><br></td>
    </tr>
    <tr>
           <td style='width:150px;'>
    <div class="row">
        <b>Repeat New Password:</b> </div>
            </td>
            <td><input ng-model="user.passwordConfirm" type="password" data-match="user.passwords" name="confirmPassword" />
            <span class="required">*</span></td>
    </tr>
    <tr><td colspan='3'><div style='font-size:10px;color:red;' data-ng-show="passwordform.confirmPassword.$error.match">New Password does not match with Repeat New Password. </div></td></tr>
    </table>
       <div >
        <button id='updateBtn'>Update</button>
        <button id='cancelBtn'>Cancel</button>
    </div>
    <div class="row buttons" style='display:none;'>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array('class'=>'tobutton','id'=>'save')); ?>
    </div>
    
<?php $this->endWidget();?>
</div><!-- form -->

<script>
    $(document).ready(function() {
        
        $("#Password_currentpassword").val('');
        $("#updateBtn").click(function(e) {
        
        $("#updateBtn").click(function(e) {
            
            e.preventDefault();
            var currentPassword = $("#Password_currentpassword").val();
            var newPassword = $("#Password_password").val();
            var repeatPassword = $("#Password_repeatpassword").val();
            if (newPassword !='' && repeatPassword !='' && currentPassword !='' ){
                     $("#save").click();
            } 
        });
    });
        $("#cancelBtn").click(function (e){
           e.preventDefault();
           window.location='index.php?r=user/admin' ;
        });
    });
</script>



