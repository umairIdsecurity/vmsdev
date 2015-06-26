<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
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
    <table class="login-area" style="border-collapse: none !important;">
        <tr>
            <td align="center" class="form-group"><span class="add-on"><i class="b-account"></i></span><?php echo $form->textField($model,'username', array('placeholder' => 'Username or Email')); ?></td>

        </tr>
        <tr>
            <td colspan="2"><?php echo $form->error($model,'username'); ?></td>
        </tr>
        <tr>
            <td colspan="3" class="form-group"><span class="add-on"><i class="b-password"></i></span><?php echo $form->passwordField($model,'password', array('placeholder' => 'Password')); ?></td>
            
        </tr>
        
        <?php //echo $form->hiddenField($model,'timezone'); ?>
        
        <?php echo CHtml::hiddenField('timezone' , 'value', array('id' => 'LoginForm_timezone')); ?>
        
        <tr>
            <td colspan="2"><?php echo $form->error($model,'password'); ?></td>
        </tr>
        <tr class="wrapper-center login-form">
            <td colspan="2">
                <?php echo CHtml::submitButton('Login',array('class'=>'actionForward')); ?>
            </td>
        </tr>
        <tr class="wrapper-center">
            <td colspan="2">
                <a class="btn btn-link" href="<?=$this->createUrl('site/forgot')?>">Forgot password?</a>
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
