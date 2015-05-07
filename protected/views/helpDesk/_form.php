
<?php
/* @var $this FaqsController */
/* @var $model Faqs */
/* @var $form CActiveForm */
$session = new CHttpSession;
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'helpdesks-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
    <table>
    
            <tr>
                <td><?php echo $form->labelEx($model, 'helpdesk_group_id'); ?></td>
                <td><select  name="HelpDesk[helpdesk_group_id]" style="width:500px;">
                        <option disabled value='' selected>Please select a Help Desk group</option>
                        <?php
                        $helpdeskGroup = HelpDeskGroup::model()->getAllHelpDeskGroup();
                        foreach ($helpdeskGroup as $key => $value) {
                            ?>
                            <option <?php  if ($model['helpdesk_group_id'] == $value['id']) echo "selected"; ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                <?php
                            }
                            ?>

                    </select></td>
                <td><?php echo $form->error($model, 'helpdesk_group_id'); ?></td>
            </tr>
            
      
        <tr>
            <td ><?php echo $form->labelEx($model, 'question'); ?></td>
            <td><?php echo $form->textField($model, 'question', array('style' => 'width:487px;')); ?></td>
            <td><?php echo $form->error($model, 'question'); ?></td>
        </tr>
        <tr>
            <td style="vertical-align:top"><?php echo $form->labelEx($model, 'answer'); ?></td>
            <td style="vertical-align:top"><?php echo $form->textArea($model, 'answer',  array('rows'=>6,'style' => 'width:487px;'));  ?></td>
            <td style="vertical-align:top"><?php echo $form->error($model, 'answer'); ?></td>
        </tr>
        <tr>
            <td ><?php echo $form->labelEx($model, 'order_by'); ?></td>
            <td><?php echo $form->textField($model, 'order_by', array('style' => 'width:70px;','size'=>5,'maxlength'=>5)); ?></td>
            <td></td>
        </tr>
        <input type="hidden" id="helpdesk_created_by" name="HelpDesk[created_by]" value="<?php echo $session['id']; ?>">
    </table>


    <div class="row buttons buttonsAlignToRight">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->


