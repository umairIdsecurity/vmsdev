<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/8/15
 * Time: 6:00 PM
 */

?>
<div class="page-content">

    

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'prereg-login-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions'=>array(
            'class'=>"form-create-login"
        )
    )); ?>

        <div class="form-group">
            <h1 class="text-primary title">LOGIN</h1>
        </div>

        <?php
            foreach(Yii::app()->user->getFlashes() as $key => $message) {
                echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
            }
        ?>

        <div class="form-group">
            <span class="glyphicon glyphicon-user"></span>

            <?php echo $form->textField($model,'username',
                array(
                    'placeholder' => 'Username or Email',
                    'class'=>'form-control input-lg',
                    'data-validate-input'
                )); ?>

            <?php echo $form->error($model,'username'); ?>
        </div>

        <div class="form-group">
            <span class="glyphicon glyphicon-asterisk"></span>

            <?php echo $form->passwordField($model,'password',
                array(
                    'placeholder' => 'Password',
                    'class'=>'form-control input-lg',
                    'data-validate-input'
                )); ?>
            <?php echo $form->error($model,'password'); ?>
        </div>

    <?php echo CHtml::submitButton('Login',array('class'=>'btn btn-primary btn-next')); ?>
    <a class="btn btn-link" href="<?php echo Yii::app()->createUrl('preregistration/forgot'); ?>">Forgot password?</a>
    <?php $this->endWidget(); ?>
</div>
