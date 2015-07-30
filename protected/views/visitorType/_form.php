<?php
/* @var $this VisitorTypeController */
/* @var $model VisitorType */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'visitor-type-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        <table>
            <tr>
                <td>
                    <?php echo $form->labelEx($model,'name'); ?>
                </td>
                <td>
                    <?php echo $form->textField($model,'name',array('size'=>25,'maxlength'=>25)); ?>
                    <?php echo "<br>".$form->error($model,'name'); ?>
                </td>
            </tr>
            
             <tr>
                <td>
                    <?php echo $form->labelEx($model,'is_default_value'); ?>
                </td>
                <td>
                    <?php echo $form->checkBox($model,'is_default_value'); ?>
                    <?php echo "<br>".$form->error($model,'is_default_value'); ?>
                </td>
            </tr>

            <tr>
                <td style="vertical-align: top">
                    <label>Related Card Types</label>
                </td>
                <td style="vertical-align: top">
                    <table style="vertical-align: top" >
                    <?php
                        if(CHelper::avms_module_has_focus()) {
                            $card_list = CardType::$VIC_CARD_TYPES;
                        }else {
                            $card_list = CardType::$CORPORATE_CARD_TYPES;
                        }
                        //if($model->id >0)
                        $selected_type_list = VisitorType::model()->getActiveCardTypeIds($model->id);


                        if(!is_array($selected_type_list))
                            $selected_type_list= array();

                        echo CHtml::checkBoxList('card_types',$selected_type_list,$card_list,array(
                            'template'  => '<tr><td style="width: 15px">{input}</td><td>{label}</td></tr>',
                            'container' => 'tbody',
                            'separator' => '',
                        ));

                        $model->module = CHelper::get_module_focus();
                        echo $form->hiddenField($model,'module');

                    ?>
                    </table>
                </td>
            </tr>



        </table>



	<div class="row buttons buttonsAlignToRight">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array("class" => "complete")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->