<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/script-visitordetail.js');
$session = new CHttpSession;
?>
<div id='visitorInformationCssMenu'>
    <ul>
        <li class='has-sub'><a href="#"><span>Personal Details</span></a>
            <ul>
                <li>
                    <table id="personalDetailsTable" class="detailsTable">
                        <tr>
                            <td width="100px;">First Name:</td>
                            <td><?php echo $model->first_name; ?></td>
                        </tr>
                        <tr>
                            <td>Last Name:</td>
                            <td><?php echo $model->last_name; ?></td>
                        </tr>
                    </table>
                </li>
            </ul>
        </li>
        <li class='has-sub'><a href="#"><span>Contact Details</span></a>
            <ul>
                <li>
                    <?php
                    $visitorForm = $this->beginWidget('CActiveForm', array(
                        'id' => 'update-visitor-form',
                        'htmlOptions' => array("name" => "update-visitor-form"),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'afterValidate' => 'js:function(form, data, hasError){
                                if (!hasError){
                                    checkEmailIfUnique();
                                }
                                }'
                        ),
                    ));
                    ?>
                    <table id="contactDetailsTable" class="detailsTable">
                        <tr>
                            <td width="100px;">Email:</td>
                            <td><input type="text" value="<?php echo $model->email; ?>" name="Visitor[email]" id="Visitor_email"></td>
                        </tr>
                        <tr>
                            <td>Mobile:</td>
                            <td><?php echo $model->contact_number; ?></td>
                        </tr>
                    </table>
                    <?php $this->endWidget(); ?>
                </li>
            </ul>
        </li>
    </ul>
</div>
