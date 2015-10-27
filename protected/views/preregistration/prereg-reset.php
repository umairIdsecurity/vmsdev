
<div class="page-content" id="usercontent">
    
    <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'password-reset-form',
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
            <h1 class="text-primary title">RESET PASSWORD</h1>
        </div>

        <?php
            foreach(Yii::app()->user->getFlashes() as $key => $message) {
                echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
            }
        ?>


        <div class="form-group">
            <span class="glyphicon glyphicon-asterisk"></span>
            <?php //echo $form->labelEx($model, 'password'); ?>
            <?php echo $form->passwordField($model,'password',array('placeholder' => 'New Password','class'=>'form-control input-lg')); ?>
            <?php echo $form->error($model,'password'); ?>
        </div>

        <div class="form-group">
            <span class="glyphicon glyphicon-asterisk"></span>
            <?php //echo $form->labelEx($model, 'passwordConfirmation'); ?>
            <?php echo $form->passwordField($model,'passwordConfirmation',array('placeholder' => 'Confirm New Password','class'=>'form-control input-lg')); ?>
            <?php echo $form->error($model,'passwordConfirmation'); ?>
        </div>

        <?php echo CHtml::submitButton('Set New Password',array('class'=>'btn btn-primary btn-next')); ?>


    <?php $this->endWidget()?>
</div>
