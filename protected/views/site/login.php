<style type="text/css">
.form-in .inputSize{
    width:100%;
    max-width: 500px;
    padding:0;
}
.form-in .inputSize input{
    height: 47px;
width: 100%;
box-sizing: border-box;
}
.form-in .inputSize .login-form input[type="submit"]{
    background: #428bca;
    border-color: #357ebd;
    color: #ffffff;
    border-radius: 4px;font-size: 14px;line-height: 1.42857;padding: 6px 12px;
    height: auto;
    width: auto;
}

.forgotLink
{
    padding:0;
}
.forgotLink:hover{
    color: #F93 !important;
    text-decoration: none !important;
    background-color: transparent !important;
}
</style>
<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$session = new CHttpSession();

$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/script-timezone.js');

$this->pageTitle=Yii::app()->name . ' - Login';

?>
<div style="text-align:center;" id="usercontent">
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
<div class="form form-in" >
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>


    <table class="login-area inputSize" style="border-collapse: unset !important;">
        <tr>
            <td align="center" class="form-group"><span style="color:#428bca;font-size:27px">LOGIN</span></td>
        </tr>

        <tr>
            <td align="center" class="form-group">&nbsp;</td>
        </tr>

        <tr>
            <td align="center" class="form-group"><span class="add-on"><i class="b-account"></i></span><?php echo $form->textField($model,'username', array('placeholder' => 'Username or Email')); ?></td>

        </tr>
        <tr>
            <td colspan="2"><?php echo $form->error($model,'username'); ?></td>
        </tr>
        <tr>
            <td colspan="3" class="form-group" ><span class="add-on"><i class="b-password"></i></span><?php echo $form->passwordField($model,'password', array('placeholder' => 'Password','style'=>'height: 47px')); ?></td>
        </tr>
        <tr>
            <td colspan="2"><?php echo $form->error($model,'password'); ?></td>
        </tr>

        <?php
            if(!isset($session['tenant'])) {
        ?>
                <tr>
                    <td colspan="3" class="form-group"><span class="add-on"><i class="b-tenant"></i></span>
                        <?php
                                $previousSelectedTenantId = $value = (string)Yii::app()->request->cookies['tenant_selection'];
                                echo $form->dropDownList($model, 'tenant', CHtml::listData(Company::model()->findAtLeast1Tenant(), 'id', 'name'), array('empty' =>'Select Airport', 'style' => 'height: 47px; ','options'=>array($previousSelectedTenantId=>array('selected'=>true))));
                        ?>

                    </td>
                </tr>
        <?php
            } else {
        ?>

            <?php echo $form->hiddenField($model, 'tenant') ?>
        
        <?php
            } 
        ?>

        <?php //echo $form->hiddenField($model,'timezone'); ?>
        
        <?php echo CHtml::hiddenField('timezone' , 'value', array('id' => 'LoginForm_timezone')); ?>
        
        <tr class="login-form">
            <td colspan="2">
                <?php echo CHtml::submitButton('Login',array('class'=>'actionForward')); ?>
            </td>
        </tr>
        <tr class="">
            <td colspan="2">
                <a class="forgotLink" style="padding:0" class="btn btn-link" href="<?=$this->createUrl('site/forgot')?>">Forgot password?</a>
            </td>
        </tr>
        
    </table>
	

<?php $this->endWidget(); ?>
</div><!-- form -->
</div>

<script type="text/javascript">
  $(document).ready(function(){
    var tz = jstz.determine(); // Determines the time zone of the browser client
    var timezone = tz.name();
    $("#LoginForm_timezone").val(timezone);
  });
</script>
