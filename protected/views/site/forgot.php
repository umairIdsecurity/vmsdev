

<div style="text-align:center;" id="usercontent">
    <?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    ?>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'forgot-form',
        'enableClientValidation' => true,
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => false,
        ),
    ));
    ?>

<!--    --><?php //echo $form->errorSummary($model); ?>


    <table class="login-area" style="border-collapse: none !important;">
        <tr>
            <td colspan="2">
                <p>Please enter your email for restore password:</p>
            </td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'email'); ?></td>
            <td><?php echo $form->textField($model, 'email'); ?></td>

        </tr>
        <tr>
            <td ></td>
            <td colspan="2"><?php echo $form->error($model,'email'); ?></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">
                <?php echo CHtml::submitButton('Restore'); ?>
            </td>
        </tr>

    </table>

    <?php $this->endWidget()?>
</div><!-- form -->
</div>