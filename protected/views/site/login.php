<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';

?>
<div style="text-align:center;" id="usercontent">
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
<div class="form" >
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

    <table class="login-area" style="border-collapse: none !important;">
        <tr>

            <td align="center"><?php echo $form->textField($model,'username', array('style'=>'float: right;vertical-align: middle;', 'placeholder' => 'Username or Email')); ?></td>

        </tr>
        <tr>
            <td colspan="2"><?php echo $form->error($model,'username'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->passwordField($model,'password', array('style'=>'float: right;vertical-align: middle;','placeholder' => 'Password')); ?></td>
            
        </tr>
        <tr>
            <td colspan="2"><?php echo $form->error($model,'password'); ?></td>
        </tr>
        <tr >
            <td colspan="2">
                <?php echo CHtml::submitButton('Login',array('class'=>'actionForward')); ?>
                <a class="btn btn-link" href="<?=$this->createUrl('site/forgot')?>">Forgot password?</a>
            </td>
        </tr>
        
    </table>
	

<?php $this->endWidget(); ?>
</div><!-- form -->
</div>