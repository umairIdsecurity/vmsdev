
<?php
/* @var $this UserController */
/* @var $model User */
$session = new CHttpSession;
//echo $session['workstation'];
?>

<h1>My Profile</h1>

<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */

if (isset($_GET['id'])) {
    $currentlyEditedUserId = $_GET['id'];
} else {
    $currentlyEditedUserId = '';
}
?>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
<div class="form" data-ng-app="PwordForm">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        'htmlOptions' => array("name" => "userform"),
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
    <table>
        <tr>
            <td style="width:200px;"><?php echo $form->labelEx($model, 'first_name'); ?></td>
            <td><?php echo $form->textField($model, 'first_name', array('size' => 50, 'maxlength' => 50)); ?></td>
            <td><?php echo $form->error($model, 'first_name'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'last_name'); ?></td>
            <td><?php echo $form->textField($model, 'last_name', array('size' => 50, 'maxlength' => 50)); ?></td>
            <td><?php echo $form->error($model, 'last_name'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'company'); ?></td>
            <td>
                <select id="User_company" name="User[company]" <?php
                echo " disabled";
                
                ?>>
                            <?php
                            $companyList = CHtml::listData(Company::model()->findAll(), 'id', 'name');
                            foreach ($companyList as $key => $value) {
                                ?>
                        <option <?php
                        if (  User::model()->getCompany($session['id']) == $key ) {
                            echo " selected ";
                        }
                        ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php
                        }
                        ?>
                </select>
            </td>
            <td><?php echo $form->error($model, 'company'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'email'); ?></td>
            <td><?php echo $form->textField($model, 'email', array('size' => 50, 'maxlength' => 50)); ?></td>
            <td><?php echo $form->error($model, 'email'); ?></td>
        </tr>
       
        <tr>
            <td><?php echo $form->labelEx($model, 'contact_number'); ?></td>
            <td><?php echo $form->textField($model, 'contact_number'); ?></td>
            <td><?php echo $form->error($model, 'contact_number'); ?></td>
        </tr>
    </table>
    <div class="buttonsAlignToRight">
    <button class="btn btn-success" id="submitBtn" <?php if ($session['role'] == Roles::ROLE_STAFFMEMBER){ echo "style='display:none;'"; } ?>><?php echo ($this->action->Id == 'create' ? 'Add' : 'Save') ?></button>
    <a class="btn btn-primary actionForward " id="resetPasswordBtn" onclick = "goToUpdatePassword(<?php echo $session['id'];?>)" style="font-weight:bold;font-size:12px;height:23.4px;">Reset Password</a>
    <div class="row buttons" style='display:none;'>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array('id' => 'submitForm',)); ?>
    </div>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->
<input type="hidden" id="currentAction" value="<?php echo $this->action->Id; ?>"/>
<input type="hidden" id="currentRole" value="<?php echo $session['role']; ?>"/>
<input type="hidden" id="userId" value="<?php echo $currentlyEditedUserId; ?>"/>
<input type="hidden" id="selectedUserId" value="<?php echo $session['id']; ?>"/>
<input type="hidden" id="sessionCompany" value="<?php echo $session['company']; ?>"/>
<script>

    $(document).ready(function() {
        var sessionRole = $("#currentRole").val(); //session role of currently logged in user
        var staffmember = 9;
        
        if (sessionRole == staffmember){
            document.getElementById('User_first_name').disabled = true;
            document.getElementById('User_last_name').disabled = true;
            document.getElementById('User_company').disabled = true;
            document.getElementById('User_email').disabled = true;
            document.getElementById('User_contact_number').disabled = true;
            document.getElementById('submitBtn').disabled = true;
        
        }
        
        $('form').bind('submit', function() {
            $(this).find('#User_company').removeAttr('disabled');
        });
    });
    function goToUpdatePassword(id){
        window.location ='index.php?r=password/update&id='+id;
    }

</script>