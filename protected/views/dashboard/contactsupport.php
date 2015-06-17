<?php
$this->pageTitle=Yii::app()->name . ' - Contact Support';


$arrSubject = array(
	'Technical Support'	=>	'Technical Support',
	'Administration Support'	=>	'Administration Support',
);
?>

<h1>Contact Support</h1>

<?php if(Yii::app()->user->hasFlash('contact')): ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('contact'); ?>
    </div>

<?php else: ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm'); ?>
    <?php echo $form->errorSummary($model); ?>
    
    <table>
        <tr>
            <td><label>From: </label></td>
            <td><?php
            echo $form->textField($model, 'name', array(
                'value'     =>  $userModel->first_name.' '.$userModel->last_name,
                'disabled'  =>  'disabled',
                'class'     =>  'disabled',
            ));
        ?></td>
            
        </tr>
        <tr>
            <td><?php //echo $form->labelEx($model, 'subject'); ?></td>
            <td><?php //echo $form->dropDownList($model, 'subject', $arrSubject); ?></td>
        </tr>
        
        
        <tr>
            <td><?php echo $form->labelEx($model,'role_id'); ?></td>
            <td><?php echo $form->dropDownList(
                            $model,
                            'role_id',
                            CHtml::listData(Roles::model()->findAll(),
                                    'id',
                                    'nameFuncForNotifiLabels')
                    );?>
            </td>
	</tr>
        
        <tr>
            <td><?php echo $form->labelEx($model, 'reason'); ?></td>
            <td>
                <?php echo $form->dropDownList(
                            $model,
                            'reason',
                            CHtml::listData(Reasons::model()->findAll(),
                                    'nameFuncForReasons',
                                    'nameFuncForReasons'),
                                    array('empty'=>'Select a reason')
                    );?>
            
            </td>
        </tr>
        
        
        <tr>
            <td><?php echo $form->labelEx($model, 'message'); ?></td>
            <td><textarea id="ContactForm_message" name="ContactForm[message]" cols="50" rows="8" style="width:700px;"></textarea></td>
            
        </tr>
    </table>

    <div class="row">
        <?php
            echo $form->textField($model, 'email', array(
                'value'     =>  $userModel->email,
                'disabled'  =>  'disabled',
                'class'     =>  'hidden',
            ));
        ?>
    </div>


    <?php /*if(CCaptcha::checkRequirements()): ?>
    <div class="row">
        <?php echo $form->labelEx($model, 'verifyCode'); ?>
        <div>
        <?php $this->widget('CCaptcha'); ?>
        <?php echo $form->textField($model, 'verifyCode'); ?>
        </div>
        <div class="hint">Please enter the letters as they are shown in the image above.
        <br/>Letters are not case-sensitive.</div>
    </div>
    <?php endif; */?>

    <div class="row submit buttonsAlignToRight">
        <?php echo CHtml::submitButton('Send', array('class'=>'tobutton complete')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif;
