<?php
$this->pageTitle=Yii::app()->name . ' - Contact Support';


$arrSubject = array(
	'Technical Support'	=>	'Technical Support',
	'Administration Support'	=>	'Administration Support',
);
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
            <td colspan="1" rowspan="3" style="vertical-align: top" >
                <input type="file" name="my_file[]"
                       data-multifile
                       data-preview-template="#previewFilesTemplate"
                       data-preview-file=".preview-files-list"
                       data-validate-file=""
                       multiple>
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
            </td>
        </tr>
        <tr>
            <td><?php //echo $form->labelEx($model, 'subject'); ?></td>
            <td><?php //echo $form->dropDownList($model, 'subject', $arrSubject); ?></td>
        </tr>
        
        
        <tr>
            <td><?php echo $form->labelEx($model,'contact_person_name'); ?></td>
            <td><?php echo $form->dropDownList(
                            $model,
                            'contact_person_name',
                            CHtml::listData(ContactPerson::model()->findAll($tenant),
                                    'id',
                                    'contact_person_name'),
                                    array('empty'=>'Select a person')
                    );?>
            </td>
	</tr>
        
        <tr>
            <td><?php echo $form->labelEx($model, 'reason'); ?></td>
            <td>
                <?php echo $form->dropDownList(
                            $model,
                            'reason',
                            CHtml::listData(Reasons::model()->findAll($tenant),
                                    'nameFuncForReasons',
                                    'nameFuncForReasons'),
                                    array('empty'=>'Select a reason')
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

<!-- Modal Upload file Contact-->
<!--<div class="modal fade" id="attachmentFileContact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Files Attached</h4>
            </div>
            <div class="modal-body">
                <div class="preview-files"><table class="preview-files-list" class="table"></table></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>-->


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

    jQuery(function() {
        'use strict';
        var $multifile = $('[data-multifile]');
        if($multifile.length) {

            $(document).on('click', '.delete-image-upload', function(){
                console.log($(this).parent().index());
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
                        console.log ('strItem', files[i]);
                        $previewFiles.append(strItem);
                    }
                    if($viewModal.length ) {
                        $viewModal.modal('show');
                    }
                }
            });
        }
    });
</script>
    <style type="text/css">
    </style>
<?php endif;
