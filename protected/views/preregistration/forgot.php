

<div class="page-content">

        <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'forgot-form',
                'enableClientValidation' => true,
                'enableAjaxValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => false,
                ),
                'htmlOptions'=>array(
                    'class'=>"form-create-login"
                )
            ));
        ?>


        <div class="form-group">
            <h1 class="text-primary title">Reset Password</h1>
        </div>

        <?php
            foreach(Yii::app()->user->getFlashes() as $key => $message) {
                echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
            }
        ?>

        <div class="form-group">
            <span class="glyphicon glyphicon-user"></span>

            <?php echo $form->textField($model,'email',
                array(
                    'placeholder' => 'Username or Email',
                    'class'=>'form-control input-lg',
                    'data-validate-input'
                )); ?>

            <?php echo $form->error($model,'email'); ?>
        </div>

        
        <?php echo CHtml::submitButton('Reset',array('class'=>'btn btn-primary btn-next')); ?>
        <a class="btn btn-link" href="<?php echo Yii::app()->createUrl('preregistration/login'); ?>">Back</a>
    

        <!-- <table class="forgot-password-area" style="border-collapse: none !important; width: 450px">
            <tr>
                <td colspan="2">
                    <p>Please enter your email to reset password</p>
                </td>
            </tr>
            <tr>
                <td><?php //echo $form->labelEx($model, 'email'); ?></td>
                <td><?php //echo $form->textField($model, 'email'); ?></td>

            </tr>
            <tr>
                <td ></td>
                <td colspan="2"><?php //echo $form->error($model,'email'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">
                    <?php //echo CHtml::submitButton('Reset'); ?>   
                    <?php //echo CHtml::submitButton('Back',array("submit"=>array('preregistration/login'))); ?>
                </td>
            </tr>

        </table> -->

        <?php $this->endWidget(); ?>
   

</div>