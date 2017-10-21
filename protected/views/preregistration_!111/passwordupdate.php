<?php
/* @var $this PasswordController */
/* @var $model Password */

$session = new CHttpSession;

?>



<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
<div class="form" data-ng-app="PwordForm">
     <div id="menu">
        <div class="row items" style="background-color:#fff;">
            <div class="col-sm-4 col-xs-6 text-center" style="background-color: #eeeeee; height:40px;border-right: 1px solid #fff;"><a href="<?php echo Yii::app()->createUrl('preregistration/dashboard'); ?>"><span class="glyphicon glyphicon-home"></span></a></div>
            <div class="col-sm-4 col-xs-6 text-center" style="background-color: #eeeeee; height:40px;"><a href="<?php echo Yii::app()->createUrl('preregistration/profile?id=' . $session['id']); ?>">My Profile</a></div>
        </div>
    </div>
	<h1>Reset Password </h1>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'password-form',
    'htmlOptions' => array("name"=>"passwordform"),
    'enableAjaxValidation'=>false,
)); ?>
    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model);?>
   
    <input name="Password[passwordindb]" id="Password_passwordindb" type="hidden" value='<?php echo $model->password; ?>'>
    <table>    
      
    <tr>
        <td>
            <div class="row">
        <label>New Password:</label>
            </div>
        </td>
        <td><input ng-model="registration.password" type="password" name="Password[password]" data-ng-class="{'ng-invalid':passwordform['Password[repeatpassword]'].confirmPassword.$error.match}" />
        <span class="required">*</span><?php echo $form->error($model, 'password'); ?></td>
    </tr>
    <tr>
        <td style='width:150px;'>
            <div class="row">
                <label>Repeat New Password:</label> 
            </div>
        </td>
        <td><input ng-model="registration.password_repeat" type="password" data-match="registration.password" name="Password[password_repeat]" />
            <span class="required">*</span><?php echo $form->error($model, 'password_repeat'); ?></td>
    </tr>
    <!--<tr><td colspan='3'><div style='font-size:10px;color:red;' data-ng-show="passwordform['Password[repeatpassword]'].$error.match">New Password does not match with Repeat New Password. </div></td></tr>-->
    </table>
       <div class="buttonsAlignToRight">
        <button id='updateBtn' class="btn btn-primary">Save</button>
        <button id='cancelBtn' class="btn btn-primary">Cancel</button>
    </div>
    <div class="row buttons " style='display:none;'>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array('class'=>'tobutton btn','id'=>'save')); ?>
    </div>
    
<?php $this->endWidget();?>
</div><!-- form -->

<script> 
    $(document).ready(function() {
        
        $("#Password_currentpassword").val('');
        
        $("#updateBtn").click(function(e) {
            $("#save").click(); 
        });
  
        $("#cancelBtn").click(function (e){
           e.preventDefault();
           window.location='/index.php/preregistration/profile?id=<?php echo $session['id'];?>' ;
        });
    });
</script>



