<?php
/* @var $this PasswordController */
/* @var $model Password */

$session = new CHttpSession;

?>

<h1>Reset Password </h1>

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
<div class="form" data-ng-app="PwordForm">
 
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
        <td><input ng-model="user.passwords" type="password" name="Password[password]" data-ng-class="{'ng-invalid':passwordform['Password[repeatpassword]'].confirmPassword.$error.match}" />
        <span class="required">*</span><?php echo $form->error($model, 'password'); ?></td>
    </tr>
    <tr>
        <td style='width:150px;'>
            <div class="row">
                <label>Repeat New Password:</label> 
            </div>
        </td>
        <td><input ng-model="user.passwordConfirm" type="password" data-match="user.passwords" name="Password[repeatpassword]" />
            <span class="required">*</span><?php echo $form->error($model, 'repeatpassword'); ?></td>
    </tr>
    <tr><td colspan='3'><div style='font-size:10px;color:red;' data-ng-show="passwordform['Password[repeatpassword]'].$error.match">New Password does not match with Repeat New Password. </div></td></tr>
    </table>
       <div class="buttonsAlignToRight">
        <button id='updateBtn'>Save</button>
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
           window.location='index.php?r=user/profile&id=<?php echo $session['id'];?>' ;
        });
    });
</script>



