

<div style="text-align:center;" id="usercontent">
    <?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    ?>
    <div class="form">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'password-reset-form',
            'enableClientValidation' => true,
            'enableAjaxValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => false,
            ),
        ));
        ?>

        <table class="reset-password-area" style="border-collapse: none !important; width: 420px">
            <tr>
                <td><?php echo $form->labelEx($model, 'password'); ?></td>
                <td><?php echo $form->passwordField($model, 'password'); ?></td>

            </tr>
            <tr>
                <td ></td>
                <td colspan="2"><?php echo $form->error($model,'password'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'passwordConfirmation'); ?></td>
                <td><?php echo $form->passwordField($model, 'passwordConfirmation'); ?></td>

            </tr>
            <tr>
                <td ></td>
                <td colspan="2"><?php echo $form->error($model,'passwordConfirmation'); ?></td>
            </tr>

            <tr>
                <td></td>
                <td colspan="2">
                    <?php echo CHtml::submitButton('Set new password'); ?>
                </td>
            </tr>

        </table>

        <?php $this->endWidget()?>
    </div><!-- form -->
</div>
