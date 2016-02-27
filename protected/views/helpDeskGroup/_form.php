<?php
/* @var $this HelpDeskGroupController */
/* @var $model HelpDeskGroup */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'helpdesk-group-form',
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
                <td><?php echo $form->labelEx($model,'name'); ?></td>
                <td><?php echo $form->textField($model,'name',array('size'=>25,'maxlength'=>25)); ?><?php echo "<br>".$form->error($model,'name'); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model,'order_by'); ?></td>
                <td><?php echo $form->textField($model,'order_by',array('size'=>5,'maxlength'=>5)); ?></td>
            </tr>
			<tr>
                <td>
                    <?php echo $form->labelEx($model,'is_default_value'); ?>
                </td>
                <td>
                    <?php echo $form->checkBox($model,'is_default_value'); ?>
                </td>
            </tr>

            <tr>
                <td style="vertical-align: top">
                    <label>Related User Roles</label>
                </td>
                <td style="vertical-align: top">
                    <table style="vertical-align: top" >
                    <?php
                        if(CHelper::get_allowed_module() == "Both") {
                            $role_list = HelpdeskGroupUserRole::$AVMS_ROLES;
                            echo '<tr><td colspan="2"><h6>AVMS Module</h6></td></tr>';
                            $selected_role_list = HelpDeskGroup::model()->getActiveRoleIds($model->id);

                        	if(!is_array($selected_role_list))
                        		$selected_role_list= array();

	                        echo CHtml::checkBoxList('roles',$selected_role_list,$role_list,array(
	                            'template'  => '<tr><td style="width: 15px">{input}</td><td>{label}</td></tr>',
	                            'container' => 'tbody',
	                            'separator' => '',
	                        ));

	                        echo '<tr><td colspan="2"><h6>AVMS Web Preregistration</h6></td></tr>';
	                        $preregistration_list = HelpdeskGroupUserRole::$AVMS_WEB_PREREGISTRATION_ROLES;
	                        $selected_preregistration_list = HelpDeskGroup::model()->getActiveWebPreregistrations($model->id);

                        	if(!is_array($selected_preregistration_list))
                        		$selected_preregistration_list= array();
	                        echo CHtml::checkBoxList('preregistrations',$selected_preregistration_list,$preregistration_list,array(
	                            'template'  => '<tr><td style="width: 15px">{input}</td><td>{label}</td></tr>',
	                            'container' => 'tbody',
	                            'separator' => '',
	                        ));

	                        $crole_list = HelpdeskGroupUserRole::$CVMS_ROLES;
                            echo '<tr><td colspan="2"><h6>CVMS Module</h6></td></tr>';
                            $selected_crole_list = HelpDeskGroup::model()->getActiveRoleIds($model->id);

                        	if(!is_array($selected_crole_list))
                        		$selected_crole_list= array();

	                        echo CHtml::checkBoxList('roles',$selected_crole_list,$crole_list,array(
	                            'template'  => '<tr><td style="width: 15px">{input}</td><td>{label}</td></tr>',
	                            'container' => 'tbody',
	                            'separator' => '',
	                        ));

                        }
                        else if(CHelper::get_allowed_module() == "AVMS") {
                            $role_list = HelpdeskGroupUserRole::$AVMS_ROLES;
                            echo '<tr><td colspan="2"><h6>AVMS Module</h6></td></tr>';
                            $selected_role_list = HelpDeskGroup::model()->getActiveRoleIds($model->id);

                        	if(!is_array($selected_role_list))
                        		$selected_role_list= array();

	                        echo CHtml::checkBoxList('roles',$selected_role_list,$role_list,array(
	                            'template'  => '<tr><td style="width: 15px">{input}</td><td>{label}</td></tr>',
	                            'container' => 'tbody',
	                            'separator' => '',
	                        ));

	                        echo '<tr><td colspan="2"><h6>AVMS Web Preregistration</h6></td></tr>';
	                        $preregistration_list = HelpdeskGroupUserRole::$AVMS_WEB_PREREGISTRATION_ROLES;
	                        $selected_preregistration_list = HelpDeskGroup::model()->getActiveWebPreregistrations($model->id);

                        	if(!is_array($selected_preregistration_list))
                        		$selected_preregistration_list= array();
	                        echo CHtml::checkBoxList('preregistrations',$selected_preregistration_list,$preregistration_list,array(
	                            'template'  => '<tr><td style="width: 15px">{input}</td><td>{label}</td></tr>',
	                            'container' => 'tbody',
	                            'separator' => '',
	                        ));

                        }
                        else {
                            $role_list = HelpdeskGroupUserRole::$CVMS_ROLES;
                            echo '<tr><td colspan="2"><h6>CVMS Module</h6></td></tr>';
                            $selected_role_list = HelpDeskGroup::model()->getActiveRoleIds($model->id);

                        	if(!is_array($selected_role_list))
                        		$selected_role_list= array();

	                        echo CHtml::checkBoxList('roles',$selected_role_list,$role_list,array(
	                            'template'  => '<tr><td style="width: 15px">{input}</td><td>{label}</td></tr>',
	                            'container' => 'tbody',
	                            'separator' => '',
	                        ));
                        }
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