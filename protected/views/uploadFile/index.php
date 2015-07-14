<div class="file-upload-content">
    <div class="left">
        <ul class="folder">
            <?php
            foreach ($menuFolder[0] as $folder) {
                echo '<li ';
                if (isset($f)) {
                    if ($f == $folder['name']) echo 'class="active"';
                } else {
                    if ($folder['default'] == 1) echo 'class="active"';
                }
                echo '><a href="' . Yii::app()->createUrl("/uploadfile&f=" . $folder['name']) . '">' . $folder['name'] . '<span>(' . $folder['number_file'] . ')</span></a></li>';
            }
            ?>
        </ul>

        <a href="#" class="add-folder" data-toggle="modal" data-target="#addNewFolderModal">+ New folder</a>
    </div>
    <div class="right">
        <h2><?php if(isset($f)) echo $f; else echo 'Help Documents'; ?></h2>
        <div class="upload-function">
            <button class="btn btn-default btn-upload">Upload Files</button>
            <button class="btn btn-default btn-delete">Delete</button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th  width="50px"></th>
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
        </table>
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
                //$('#Folder_name').fadeOut();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl('uploadfile/create'); ?>',
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
    });

</script>