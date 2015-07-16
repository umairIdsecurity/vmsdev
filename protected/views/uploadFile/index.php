<div class="file-upload-content">
    <div class="left">
        <ul class="folder">
            <?php
            foreach ($menuFolder as $folde) {
                echo '<li ';
                if (isset($folder)) {
                    if ($folder->name == $folde['name']) echo 'class="active"';
                } else {
                    if ($folde['default'] == 1) echo 'class="active"';
                }
                echo '><a href="' . Yii::app()->createUrl("/uploadFile&f=" . $folde['name']) . '">' . (strlen($folde['name'])>17?substr($folde['name'], 0, 17).'...':$folde['name']) . ' <span>(' . $folde['number_file'] . ')</span></a></li>';
            }
            ?>
        </ul>

        <?php if (isset($allow_create_new_folder) && $allow_create_new_folder == 1) {?>
            <a href="#" class="add-folder" data-toggle="modal" data-target="#addNewFolderModal">+ New folder</a>
        <?php } ?>
    </div>
    <div class="right">
        <h2><?php if(isset($folder)) echo $folder->name; else echo 'Help Documents'; ?></h2>
        <div id="file_grid_error" class="errorMessage" style="text-transform: none;margin-top: 20px; height: 30px ;display:none">Couldn't delete files.</div>
        <form id="form-submit-files" method="post" class="upload-function" enctype="multipart/form-data">
            <label class="btn btn-default btn-upload" for="attachFilesUpload">Upload Files</label>
            <button class="btn btn-default btn-delete" id="btn_delete_file" disabled>Delete</button>
            <input type="file" name="file[]"
                   id="attachFilesUpload"
                   data-multifile
                   data-preview-template="#previewFilesTemplate"
                   data-preview-file=".preview-files-list"
                   data-validate-file=""
                   data-show-button=".btn-submit"
                   class="hidden"
                   multiple>
            <div class="preview-files">
                <table class="table preview-files-list"></table>
                <div class="btn-submit">
                    <input name="File[folder_id]" value="<?php echo $folder->id; ?>" type="hidden"/>
                    <input name="File[user_id]" value="<?php echo Yii::app()->user->id;  ?>" type="hidden"/>
                    <input id="btn-submit-files" type="button" value="Upload">
                </div>
            </div>
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

        </form>
        <form id="list_file" method="post">
            <input value="<?php echo Yii::app()->user->id; ?>" type="hidden" name="File[user_id]">
            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'file-grid',
                'dataProvider' => $dataProvider ,
                //'filter' => File::model(),
                'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
        editCell();
    }


    ",
                'htmlOptions' => array('class' => 'table'),
                'columns' => array(
                    array(
                        'header' => '<input type="checkbox" id="check_file_all" />',
                        'value'=>'CHtml::checkBox("File[id][".$data->id."]",null,array("value"=>$data->id,"id"=>"File[".$data->id."]"))',
                        'type' => 'raw',
                        'htmlOptions' => array('style'=>'width:20px !important;'),
                        'headerHtmlOptions' => array('style'=>'min-width:0px !important;'),
                    ),

                    array(
                        'name' => 'file',
                        //'value' => '"<span class=\"file-type file-" . $data->ext ."\">$data->file <span class="glyphicon glyphicon-pencil"></span></span>',
                        'value' => '"<span class=\'file-type file-" . $data->ext ."\'> <span> <a href=\'".$data->linkDownloadFile($data->id)."\'>$data->name</a> </span> <span id=\'pencil-".$data->id."\' class=\'glyphicon glyphicon-pencil\'></span></span>"',
                        'type' => 'raw',
                        'filter' => false
                    ),
                    array(
                        'name' => 'size',
                        'value' => '$data->displaySize($data->size)',
                        'filter' => false,
                        'htmlOptions' => array('style'=>'max-width:50px !important;'),
                        'headerHtmlOptions' => array('style'=>'max-width:50px !important;'),
                    ),
                    array(
                        'name' => 'uploaded',
                        'value' => '$data->calculate_time_span($data->uploaded)',
                        'filter' => false,
                    ),
                    array(
                        'header' => 'Uploaded by',
                        'name' => 'uploader',
                        'value' => '$data->getNameUser($data->uploader)',
                        'filter' => false,
                        'headerHtmlOptions' => array('style'=>'display:block'),
                    ),

                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{view}',
                        'buttons' => array(
                            'view' => array(//the name {reply} must be same
                                'label' => 'View', // text label of the button
                                'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                                'url' => 'Yii::app()->createUrl("uploadFile/view", array("id"=>$data->id))',
                                'options' => array('target' => '_new'),
                            ),
                            /*'delete' => array(//the name {reply} must be same
                                'label' => 'Delete', // text label of the button
                                'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                                'url' => 'Yii::app()->controller->createUrl("visitor/delete",array("id"=>$data->id))',
                                'options' => array(// this is the 'html' array but we specify the 'ajax' element
                                    'confirm' => "Are you sure you want to delete this item?",
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => "js:$(this).attr('href')", // ajax post will use 'url' specified above
                                        'success' => 'function(data){

                                                            if(data == "true"){
                                                                $.fn.yiiGridView.update("visitor-grid");
                                                                return false;
                                                            }else{
                                                                var urlAddress = this.url;
                                                                var urlAddressId = urlAddress.split("=");
                                                                var x;
                                                                if($("#visitorExists1"+  urlAddressId["2"]).val() == 1){
                                                                    alert("This record has an open visit and must be cancelled before deleting.");
                                                                    return false;
                                                                } else if($("#visitorExists2"+  urlAddressId["2"]).val() == 1){
                                                                    if (confirm("This Visitor Record has visit data recorded. Do you wish to delete this visitor record and its visit history?") == true) {
                                                                        $.ajax({
                                                                            type: "POST",
                                                                            url: "'. Yii::app()->createUrl('visit/deleteAllVisitWithSameVisitorId&id=') .'" +urlAddressId["2"] ,
                                                                            success: function(r) {
                                                                                $.fn.yiiGridView.update("visitor-grid");
                                                                                return false;
                                                                            }
                                                                        });
                                                                    }
                                                                    return false;
                                                                }


                                                            }
                                                        }',
                                    ),
                                ),

                            ),*/
                        ),
                    ),
                ),
            ));
            ?>
        </form>



        <!--<table class="table">

            <thead>
                <tr>
                    <th width="60">Select All</th>
                    <th>File</th>
                    <th>Size</th>
                    <th>Uploaded</th>
                    <th>Uploaded by</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <input type="checkbox" value="1" name="checkbox[]">
                    </td>
                    <td>
                        <span class="file-type file-pdf">Help document <span class="glyphicon glyphicon-pencil"></span></span>
                    </td>
                    <td>
                        <span class="file-size">123 KB</span>
                    </td>
                    <td>
                        <span class="file-size">Now</span>
                    </td>
                    <td>
                        <span class="file-size">Julie Stewart</span>
                    </td>
                    <td> <a href="#">View</a></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" value="1" name="checkbox[]">
                    </td>
                    <td>
                        <span class="file-type file-jpg">Help document <span class="glyphicon glyphicon-pencil"></span></span>
                    </td>
                    <td>
                        <span class="file-size">412.3 KB</span>
                    </td>
                    <td>
                        <span class="file-size">Now</span>
                    </td>
                    <td>
                        <span class="file-size">Julie Stewart</span>
                    </td>
                    <td> <a href="#">View</a></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" value="1" name="checkbox[]">
                    </td>
                    <td>
                        <span class="file-type file-jpeg">Identity Secu document <span class="glyphicon glyphicon-pencil"></span></span>
                    </td>
                    <td>
                        <span class="file-size">212.3 KB</span>
                    </td>
                    <td>
                        <span class="file-size">Now</span>
                    </td>
                    <td>
                        <span class="file-size">Julie Stewart</span>
                    </td>
                    <td> <a href="#">View</a></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" value="1" name="checkbox[]">
                    </td>
                    <td>
                        <span class="file-type file-pdf">Help document <span class="glyphicon glyphicon-pencil"></span></span>
                    </td>
                    <td>
                        <span class="file-size">123 KB</span>
                    </td>
                    <td>
                        <span class="file-size">Now</span>
                    </td>
                    <td>
                        <span class="file-size">Julie Stewart</span>
                    </td>
                    <td> <a href="#">View</a></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" value="1" name="checkbox[]">
                    </td>
                    <td>
                        <span class="file-type file-jpg">Help document <span class="glyphicon glyphicon-pencil"></span></span>
                    </td>
                    <td>
                        <span class="file-size">412.3 KB</span>
                    </td>
                    <td>
                        <span class="file-size">Now</span>
                    </td>
                    <td>
                        <span class="file-size">Julie Stewart</span>
                    </td>
                    <td> <a href="#">View</a></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" value="1" name="checkbox[]">
                    </td>
                    <td>
                        <span class="file-type file-png">Identity Secu document <span class="glyphicon glyphicon-pencil"></span></span>
                    </td>
                    <td>
                        <span class="file-size">212.3 KB</span>
                    </td>
                    <td>
                        <span class="file-size">Now</span>
                    </td>
                    <td>
                        <span class="file-size">Julie Stewart</span>
                    </td>
                    <td> <a href="#">View</a></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" value="1" name="checkbox[]">
                    </td>
                    <td>
                        <span class="file-type file-pdf">Help document <span class="glyphicon glyphicon-pencil"></span></span>
                    </td>
                    <td>
                        <span class="file-size">123 KB</span>
                    </td>
                    <td>
                        <span class="file-size">Now</span>
                    </td>
                    <td>
                        <span class="file-size">Julie Stewart</span>
                    </td>
                    <td> <a href="#">View</a></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" value="1" name="checkbox[]">
                    </td>
                    <td>
                        <span class="file-type file-jpg">Help document <span class="glyphicon glyphicon-pencil"></span></span>
                    </td>
                    <td>
                        <span class="file-size">412.3 KB</span>
                    </td>
                    <td>
                        <span class="file-size">Now</span>
                    </td>
                    <td>
                        <span class="file-size">Julie Stewart</span>
                    </td>
                    <td> <a href="#">View</a></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" value="1" name="checkbox[]">
                    </td>
                    <td>
                        <span class="file-type file-jpeg">Identity Secu document <span class="glyphicon glyphicon-pencil"></span></span>
                    </td>
                    <td>
                        <span class="file-size">212.3 KB</span>
                    </td>
                    <td>
                        <span class="file-size">Now</span>
                    </td>
                    <td>
                        <span class="file-size">Julie Stewart</span>
                    </td>
                    <td> <a href="#">View</a></td>
                </tr>
            </tbody>
        </table>-->
    </div>
    <div class="clearfix"></div>
</div>


<!-- Modal -->
<div class="modal fade" id="addNewFolderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">+ New folder</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="Folder_form">
                    <div class="form-group">
                        <div id="Folder_name" class="errorMessage" style="text-transform: none;margin-left: 159px;display:none">Please input name folder</div>
                        <input value="<?php echo Yii::app()->user->id; ?>" type="hidden" name="Folder[user_id]">
                        <label for="nameFolder" class="col-sm-2 control-label">Name Folder: </label> <input name="Folder[name]" type="text" class="form-control" id="nameFolder" placeholder="Type name folder...">

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary newfolder" id="btn-newfolder">Add</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        $('#btn-newfolder').click(function(){
            if(validateNameFolder($('#nameFolder').val())){
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl('uploadFile/create'); ?>',
                    //dataType: 'text',
                    data: $('#Folder_form').serialize(),
                    success: function (r) {
                        r = JSON.parse(r);
                        if(r.success != 1){
                            $('#Folder_name').html(r.error);
                            $('#Folder_name').fadeIn();
                        }else{
                            location.reload();
                        }
                    }
                });
            }
        });
        var defaultName = ['help documents', 'contracts', 'inbox', 'helpdocuments'];

        $('#nameFolder').keyup(function () {
            if (defaultName.indexOf($(this).val().toLowerCase()) >= 0) {
                $('#Folder_name').html('Name folder has exist. Please type other name.');
                $('#Folder_name').fadeIn();
            } else {
                $('#Folder_name').fadeOut();
            }
        });

        function validateNameFolder(name) {
            if (name.length <= 0) {
                $('#Folder_name').html('Please input name folder');
                $('#Folder_name').fadeIn();
                return false;
            }
            if (defaultName.indexOf(name) >= 0) {
                $('#Folder_name').html('Name folder has exist. Please type other name.');
                $('#Folder_name').fadeIn();
                return false;
            }
            $('#Folder_name').fadeOut();
            return true;
        }

        $('#check_file_all').bind('click', function (event) {

            var
                ref = this,
                refChecked = this.checked;
            $(this.form).find('input[type="checkbox"]').each(function (i, el) {
                if (this != ref) {
                    this.checked = refChecked;
                    if (this.checked)
                        $('#btn_delete_file').removeAttr("disabled");
                    else
                        $('#btn_delete_file').attr("disabled", true);
                }
            });

        });

        $("#list_file").find('input[type="checkbox"]').each(function (i, el) {
            if ($(this).attr('id') != 'check_file_all') {
                $(this).change(function () {
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

        $('#btn_delete_file').click(function (e) {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('uploadFile/delete'); ?>',
                //dataType: 'text',
                data: $('#list_file').serialize(),
                success: function (r) {
                    r = JSON.parse(r);
                    if (r.success != 1) {
                        $('#file_grid_error').html(r.error);
                        $('#file_grid_error').fadeIn();
                    } else {
                        window.location.reload();
                    }
                }
            });
            e.preventDefault();
        });

        //Call function can edit cell on table
        editCell();

        $('#btn-submit-files').click(function(e){
            var obj = $('#form-submit-files');
            /* ADD FILE TO PARAM AJAX */
            var formData = new FormData();
            $.each($(obj).find("input[type='file']"), function(i, tag) {
                $.each($(tag)[0].files, function(i, file) {
                    formData.append(tag.name, file);
                });
            });
            var params = $(obj).serializeArray();
            $.each(params, function (i, val) {
                formData.append(val.name, val.value);
            });

            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('uploadFile/uploadedFile'); ?>',
                processData: false,
                contentType: false,
                dataType: 'json',
                data: formData,
                success: function (r, textStatus, jqXHR) {

                    window.location.reload();
                    /*if (r.success != 1) {
                     $('#file_grid_error').html();
                     for(var i = 0; i < r.error.length; i ++){
                     $('#file_grid_error').append(r.error[i]);
                     }
                     $('#file_grid_error').fadeIn();
                     } else {
                     $('#file_grid_error').fadeOut();
                     $.fn.yiiGridView.update("file-grid");
                     }*/
                }
            });
        });
    });
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