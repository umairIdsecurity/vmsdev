<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
if (isset($_GET['role']))
{$userRole = $_GET['role'];}
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
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
                <td><?php echo $form->labelEx($model,'first_name'); ?></td>
                <td><?php echo $form->textField($model,'first_name',array('size'=>50,'maxlength'=>50)); ?></td>
                <td><?php echo $form->error($model,'first_name'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model,'last_name'); ?></td>
                <td><?php echo $form->textField($model,'last_name',array('size'=>50,'maxlength'=>50)); ?></td>
                <td><?php echo $form->error($model,'last_name'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model,'email'); ?></td>
                <td><?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?></td>
                <td><?php echo $form->error($model,'email'); ?></td>
            </tr>
            <?php if ($this->action->id =='create'){?>
            <tr>
                <td><label for="User_password">Password</label></td>
                <td>
                    <input type="password" id="User_password" value = '<?php echo $model->password; ?>' name="User[password]">			
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td><?php echo $form->labelEx($model,'contact_number'); ?></td>
                <td><?php echo $form->textField($model,'contact_number'); ?></td>
                <td><?php echo $form->error($model,'contact_number'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model,'date_of_birth'); ?></td>
                <td><?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'date_of_birth',
                        'htmlOptions' => array(
                            'size' => '10',         // textField size
                            'maxlength' => '10',    // textField maxlength
                          
                        ),
                    ));
                    ?></td>
                <td><?php echo $form->error($model,'date_of_birth'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model,'company'); ?></td>
                <td><?php echo $form->textField($model,'company'); ?></td>
                <td><?php echo $form->error($model,'company'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model,'department'); ?></td>
                <td><?php echo $form->textField($model,'department',array('size'=>50,'maxlength'=>50)); ?></td>
                <td><?php echo $form->error($model,'department'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model,'position'); ?></td>
                <td><?php echo $form->textField($model,'position',array('size'=>50,'maxlength'=>50)); ?></td>
                <td><?php echo $form->error($model,'position'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model,'staff_id'); ?></td>
                <td><?php echo $form->textField($model,'staff_id',array('size'=>50,'maxlength'=>50)); ?></td>
                <td><?php echo $form->error($model,'staff_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model,'notes'); ?></td>
                <td><?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?></td>
                <td><?php echo $form->error($model,'notes'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model,'role'); ?></td>
                <td><select <?php if ($this->action->Id!='update') {echo "disabled";} ?> id="User_role" name="User[role]">
                <?php 
                    foreach (User::$USER_ROLE_LIST as $key=>$value){
                        ?>
                            <option value="<?php echo $key; ?>" <?php 
                                if(isset($_GET['role']))
                                { 
                                    if ($userRole == $key){echo "selected ";}
                                }?> >
                                    <?php echo $value; ?></option>
                        <?php 
                    }
                ?>
                
            </select></td>
                <td><?php echo $form->error($model,'role'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model,'user_type'); ?></td>
                <td><?php echo $form->dropDownList($model, 'user_type', User::$USER_TYPE_LIST); ?></td>
                <td><?php echo $form->error($model,'user_type'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model,'user_status'); ?></td>
                <td><?php echo $form->dropDownList($model, 'user_status', User::$USER_STATUS_LIST); ?></td>
                <td><?php echo $form->error($model,'user_status'); ?></td>
            </tr>
        </table>
	
        

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    
    $(document).ready(function() {
       $("#User_password").val('');
        $('form').bind('submit', function() {
        $(this).find('#User_role').removeAttr('disabled');
        }); 
         
    })
</script>