<?php
$this->pageTitle=Yii::app()->name . ' - Contact Support';


$arrSubject = array(
	'Technical Support'	=>	'Technical Support',
	'Administration Support'	=>	'Administration Support',
);

$session = new ChttpSession;
$contact_persons = ContactPerson::model()->findAll("user_role = " . $session['role']);
$contact_reasons = array();
$contact_reason_names = array();
foreach ($contact_persons as $contact_person) {
    $reason = Reasons::model()->findByPk($contact_person->reason_id);
    if(isset($reason))
    {
        if(!in_array($reason->reason_name, $contact_reason_names))
            $contact_reasons[$contact_person->id] =  $reason->reason_name;
        array_push($contact_reason_names, $reason->reason_name);
    }  
}
?>

<h1>Contact Support</h1>

    <?php
        $tenant = '';
        if(Yii::app()->user->role == Roles::ROLE_ADMIN){
            $tenant = "tenant='".Yii::app()->user->tenant."'";
        } 
    ?>



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
            <td width="300"><?php
            echo $form->textField($model, 'name', array(
                'value'     =>  $userModel->first_name.' '.$userModel->last_name,
                'disabled'  =>  'disabled',
                'class'     =>  'disabled',
            ));
        ?></td>
            <td colspan="1" rowspan="4" style="vertical-align: top" >
                <div class="upload-file-support">
                    <h4>Attachments</h4>
                    <a href="<?php echo Yii::app()->createUrl("/uploadFile"); ?>" class="help-document-link">
                        <label for="attachFileSupport">
                            <span class="glyphicon glyphicons-folder-open"></span> 
                            <!--<a href="<?php /*echo Yii::app()->createUrl("support"); */?>">-->Help Documents<!--</a>-->
                        </label>
                    </a>
                   <!-- <input type="file" name="my_file[]"
                           id="attachFileSupport"
                           data-multifile
                           data-preview-template="#previewFilesTemplate"
                           data-preview-file=".preview-files-list"
                           data-validate-file=""
                           class="hidden"
                           multiple>-->
                    <div class="preview-files"><table class="preview-files-list" class="table"></table></div>
                    <table class="hidden">
                        <tbody id="previewFilesTemplate" >
                        <tr class="item" data-item-id="{0}">
                            <td width="200">
                                <span>{0}</span>
                            </td>
                            <td width="50" class="delete-image-upload">x</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
        <tr>
            <td><?php //echo $form->labelEx($model, 'subject'); ?></td>
            <td><?php //echo $form->dropDownList($model, 'subject', $arrSubject); ?></td>
        </tr>
        
        <tr>
            <td><?php echo $form->labelEx($model, 'reason'); ?></td>
            <td>
                <?php 
                $reasonsAll = CHtml::listData(Reasons::model()->findAll("tenant = ".Yii::app()->user->tenant), 'id', 'reason_name');
                echo $form->dropDownList(
                            $model,
                            'reason',
                             $reasonsAll,
                              array(
                                'prompt'=>'Select a Reason',
                                'ajax' => array(
                                'type'=>'POST', 
                                'url'=>Yii::app()->createUrl('reasons/loadContactPersons'),  
                                'update'=>'#ContactForm_contact_person_name', //or 'success' => 'function(data){...handle the data in the way you want...}',
                              'data'=>array('id'=>'js:this.value'),
                              )) 
                    );?>
            
            </td>
        </tr>
        
        <tr>
            <td><?php echo $form->labelEx($model,'contact_person_name'); ?></td>
            <td><?php echo $form->dropDownList(
                            $model,
                            'contact_person_name',
                             array(),
                                    array('empty'=>'Select Contact Person')
                    );?>
            </td>
        </tr>
        
        
        
        
        <tr>
            <td><?php echo $form->labelEx($model, 'message'); ?></td>
            <td  colspan="2"><textarea id="ContactForm_message" name="ContactForm[message]" cols="50" rows="8" style="width:700px;"></textarea></td>
            
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

<script>

    var formatStr = function(str) {
        var theString = str;
        for (var i = 1; i < arguments.length; i++) {
            var regEx = new RegExp("\\{" + (i - 1) + "\\}", "gm");
            theString = theString.replace(regEx, arguments[i]);
        }
        return theString;
    };

    var numberWithCommas = function(x, commas) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, commas);
    };
 

    /*jQuery(function() {
        'use strict';
        var $multifile = $('[data-multifile]');
        if($multifile.length) {

            $(document).on('click', '.delete-image-upload', function(){
                $(this).parent().empty();
            });

            $multifile.on('change', function() {
                var strTemplate = $($(this).data('previewTemplate')).html();
                var files = this.files;
                var $previewFiles = $($(this).data('previewFile'));
                var $viewModal = $($(this).data('viewModal') );
                $previewFiles.empty();
                if( strTemplate && $previewFiles.length ) {
                    for (var i = 0, len = files.length; i < len; i++) {
                        var strItem = formatStr(strTemplate, files[i]["name"], numberWithCommas(files[i]["size"], '.') );
                        // console.log ('strItem', files[i]);
                        $previewFiles.append(strItem);
                    }
                    if($viewModal.length ) {
                        $viewModal.modal('show');
                    }
                }
            });
        }
    });*/
</script>
    <style type="text/css">
        .upload-file-support {
            background-color: #EEEEEE;
            border: 1px solid #DDDDDD;
            padding: 0 10px;
            width: 392px;
            border-radius: 4px;
        }
        .upload-file-support h4 {
            font-size: 14px;
        }
        .upload-file-support .glyphicons-folder-open {
            padding-right: 10px;
        }
        .delete-image-upload {
            cursor: pointer;
        }
    </style>
<?php endif;
