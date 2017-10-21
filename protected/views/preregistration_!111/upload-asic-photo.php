<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->controller->assetsBase. '/js/JQuery.MultiFile.min.js');

$session = new CHttpSession;
//$visitor = Registration::model()->findByPk($session['visitor_id']);
$visitor = Registration::model()->findByPk(Yii::app()->user->id);
$preImg = '';
if(!empty($visitor->photo) && !is_null($visitor->photo)){
    $photoModel=Photo::model()->findByPk($visitor->photo);
    if(!empty($photoModel->db_image))
    {
        $preImg = "data:image;base64," . $photoModel->db_image;
    }
    else
    {
        $preImg = Yii::app()->theme->baseUrl.'/images/user.png';
    }
}
else{
    $preImg = Yii::app()->theme->baseUrl.'/images/user.png';
}

?>
<div class="page-content">


    

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id' => 'upload-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions' =>
            array(
                'enctype' => 'multipart/form-data',
                'class' => 'form-upload-img',
            ),

    )); ?>


    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <img src="<?= $preImg ?>" alt="image user" id="preview" width="120" height="153">
                <br><br>
                <div class ='btn btn-primary btn-next' style="width:100; height:50;">
					
                    <?php echo $form->fileField($model,'image', array('style'=>'opacity:0; width:80px; height:4px;')); ?>
					<span>Upload</span>
                </div>
				</br></br>
                <span class="text-primary subheading-size" style="text-align:center;">Please upload a photo head and shoulders picture with no glasses or hat, on a white background. </span>
            </div>
        </div>
        <div class="col-sm-4">&nbsp;</div>
    </div>
	    <div class="row" id='multiUpload'>
        <div class="col-sm-4">
		<h3 class="text-primary subheading-size">Identification Documents </h3>
           
			 <label class=" btn btn-default btn-upload complete" style="background-color:#428bca; color: white;" id="upload_multi_label">+ Upload Files</label>
            <div class="preview-files" style="display: block">
                <input multiple type="file" name="file[]" id="upload_multi" style="width: 0px;height: 0px;overflow: hidden" />
				
                <!--<table class="table preview-files-list"></table>-->

            </div>
            <div class="btn-submit" style="margin-top: 10px; margin-bottom: 5px; display: none">
               <input name="File[folder_id]" value="" type="hidden"/>
                <input name="File[user_id]" value="<?php echo Yii::app()->user->id;  ?>" type="hidden"/>
                <input id="btn-submit-files" type="button" value="Upload" class="actionForward">
            </div>    
           
        </div>
        <div class="col-sm-4">&nbsp;</div>
    </div>

    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>

    <div class="row">
        <div class="col-sm-12">
            <div class="">
                <div class="pull-left">
                    <a href="<?=Yii::app()->createUrl("preregistration/addAsic")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
                </div>
                <div class="pull-right">
                    <?php
                        echo CHtml::tag('button', array(
                            'type'=>'submit',
                            'class' => 'btn btn-primary btn-next'
                        ), 'NEXT <span class="glyphicon glyphicon-chevron-right"></span> ');
                    ?>
                </div>
            </div>
        </div>
    </div>  


    <?php $this->endWidget(); ?>
</div>

<script type="text/javascript">

    function readURL(input) {

        if (input.files && input.files[0]) {
         var reader = new FileReader();

         reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
         }

         reader.readAsDataURL(input.files[0]);
         }
     }

    $('#UploadForm_image').bind('change', function() {

        var f = this.files[0]

        if (f.size > 2000000 || f.fileSize > 2000000)
        {
            alert("Allowed file size exceeded. (Max. 2 MB)")

            this.value = null;
        }
        else{
            readURL(this);
        }

    });
	 $(document).ready(function(){
		
        $('#upload_multi').MultiFile({
            accept: 'jpg|png|pdf|xls|xlsx|doc|docx|txt|ppt|pptx|xml|jpeg',
            max_size: 10485760,
            afterFileRemove: function (element, value, master_element) {
                var count = $('#upload_multi_list > .MultiFile-label').length;
                if (count == 0) {
                    $('.btn-submit').fadeOut();
                }
            },
            onFileAppend: function (element, value, master_element) {
                $('#file_grid_error').html('');
                    $('#file_grid_error').fadeOut();
                $('.btn-submit').fadeIn();
				$('#btn-submit-files').show();
            }
			
        });

        $("#upload_multi_label").click(function () {
			//alert('umair');
            var countInput = 0,
                obj = $('#multiUpload'),
                lasNumberOfInputFile = [],max = 0;
				
				
            $.each(obj, function(i, tag) {
				var ob=$(obj).find("input[type='file']");
				//alert(ob);
                if ($(ob).attr('id') != 'upload_multi'){
                    lasNumberOfInputFile.push(parseInt(reverse($(ob).attr('id')).substring(0,1)));
               // alert("here");
				}
				
            });
            for (var i = 0; i < lasNumberOfInputFile.length; i++) {
                if (max < lasNumberOfInputFile[i]) max = lasNumberOfInputFile[i];
            }
			
            $.each(obj, function(i, tag) {
				var ob=$(obj).find("input[type='file']");
                if ($(ob).attr('id') == 'upload_multi' && max == 0){
                    $(ob).click();
					//alert("here2");
                }else {
                    if ($(ob).attr('id') == ('upload_multi_F' + (max))) {
                        //if($(this).length) {
                            $(ob).click();
							//alert("rabia");
                        //}
						
						
                    }
					//alert("abs");
                }

            });
        });
    });

    function reverse(s) {
        var i = s.length,
            o = '';
        while (i > 0) {
            o += s.substring(i - 1, i);
            i--;
        }
        return o;
    }

    function editCell(){
        $(".glyphicon.glyphicon-pencil").each(function(){
            $(this).click(function () {
                var text = $(this).prev("span").text();
                var id = $(this).attr('id').substring($(this).attr('id').indexOf('-')+1,$(this).attr('id').length);
                if($("#File-"+id).length>0){
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('uploadFile/updateFile'); ?>',
                        //dataType: 'text',
                        data: {id: id, file:$("#File-"+id).val()},
                        success: function (r) {
                            r = JSON.parse(r);
                            if (r.success != 1) {
                                $('#file_grid_error').html(r.error);
                                $("#File-"+id).css('border-color','red');
                                $('#file_grid_error').fadeIn();
                            } else {
                                $('#file_grid_error').fadeOut();
                                $.fn.yiiGridView.update("file-grid");
                            }

                            $("#list_file").find('input[type="checkbox"]').each(function (i, el) {
                                if ($(this).attr('id') != 'check_file_all') {
                                    $(this).live('change', function () {
                                        $('#check_file_all').prop('checked', false);
                                        var canDisable = true;
                                        $(this.form).find('input[type="checkbox"]').each(function (i, el) {
                                            if (this.checked)
                                                canDisable = false;
                                        });
                                        $('#btn_delete_file').attr("disabled", canDisable);
                                    });
                                }
                                if (!$(this).is(':checked')) {
                                    $('#btn_delete_file').attr("disabled", true);
                                }
                            });
                        }
                    });
                }else {
                    $(this).prev("span").hide();
                    $(this).before('<input id=\'File-' + id + '\' value="' + text + '" />');
                }
            });
        });
    }
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
                $(this).parent().empty();
            });

            $multifile.on('change', function() {
                var strTemplate = $($(this).data('previewTemplate')).html();
                var files = this.files;
                var $previewFiles = $($(this).data('previewFile'));
                var $viewModal = $($(this).data('viewModal') );
                var $showButton = $($(this).data('showButton') );

                $showButton.show();

                $previewFiles.empty();
                if( strTemplate && $previewFiles.length ) {
                    for (var i = 0, len = files.length; i < len; i++) {
                        var strItem = formatStr(strTemplate, files[i]["name"], numberWithCommas(files[i]["size"], '.') );

                        $previewFiles.append(strItem);
                    }
                }
            });
        }
    });
  
</script>