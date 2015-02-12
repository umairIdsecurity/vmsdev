<?php
if ($this->Id == 'visitor') {
    $dataId = '';
} elseif (isset($_GET['id'])) {
    $dataId = $_GET['id'];
} else {
    $dataId = '';
}
?>
<?php
if ($this->action->id == 'addvisitor') {
    ?>
    <style>
        .ajax-upload-dragdrop {
            float:left !important;
            margin-left:0px !important;
        }
        .ajax-file-upload{
            margin-top:80px !important;
            position:absolute !important;
            margin-left: -53px !important;
        }

        .editImageBtn{
            margin-bottom: -61px !important;
            margin-left: -102px !important;
        }
        .imageDimensions{
            display:none !important;
        }
    </style>
    <?php
} elseif ($this->action->id == 'customisation') {
    ?>
    <style>
        .ajax-upload-dragdrop {
            float:left !important;
            margin-left:0px !important;
        }
        .ajax-file-upload{
            margin-top:80px !important;
            position:absolute !important;
            margin-left: -53px !important;
        }

        .editImageBtn{
            margin-bottom: -61px !important;
            margin-left: -102px !important;
        }
    </style>
<?php } elseif ($this->action->id == 'create') { ?>
    <style>
        .ajax-upload-dragdrop {
            //margin-right:-75px !important;
            float:none !important;
        }
        .ajax-file-upload{
            margin-top:80px !important;
            position:absolute !important;
            margin-left: -53px !important;
        }

        .editImageBtn{
            margin-top: -10px !important;
            margin-left:7px !important;
        }
    </style>
<?php } elseif ($this->action->id == 'update') { ?>
    <style>
        .ajax-upload-dragdrop {
            float:none !important;
        }
        .ajax-file-upload{
            margin-top:80px !important;
            position:absolute !important;
            margin-left: -53px !important;
        }
        .editImageBtn{
            margin-left: 6px;
            margin-top: -9px;
        }
    </style>
<?php } ?>


<div id="fileuploader" style="margin-bottom:5px;"><?php
if ($this->action->id == 'detail') {
    echo "Upload Photo";
} else {
    echo "Browse Computer";
}
?> </div> 
<br><br>
<input type="button"  style="display:none;" id="cropImageBtn" class="editImageBtn" value="Edit Image" onclick = "document.getElementById('light').style.display = 'block';
        document.getElementById('fade').style.display = 'block'">

<input type="hidden" id="actionUpload" value="<?php echo $this->action->id; ?>"/> 
<input type="hidden" id="controllerId" value="<?php echo $this->id; ?>"/> 
<input type="hidden" id="viewFrom" value="<?php if (isset($_GET['viewFrom'])) {
    echo "1";
} else {
    echo "0";
}
?>"/> 
<div id="status1"></div>
<script>
    $(document).ready(function()
    {

        $("a.active").parents('li').css("property", "value");

        $("#fileuploader").uploadFile({
            url: "<?php echo Yii::app()->createUrl('site/upload&id=' . $this->id . '&companyId=' . $dataId . '&actionId=' . $this->action->id); ?>",
            allowedTypes: "png,gif,jpg,jpeg",
            fileName: "myfile",
            // maxFileCount: 1,
            maxFileSize: 2100000,
            showDone: false,
            showStatusAfterSuccess: false,
            onSuccess: function(files, data, xhr)
            {
                if ($("#controllerId").val() == 'visitor' || $("#controllerId").val() == 'visit' || $("#controllerId").val() == 'companyLafPreferences') {
                    var logo = document.getElementById('photoPreview');
                } else {
                    var logo = document.getElementById('companyLogo');
                }
                var currentAction = $("#actionUpload").val();
                if (currentAction == 'update' && $("#controllerId").val() != 'visitor')
                {
                    logo.src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + data;
                    $(".companyLogoDiv").show();
                } else {
                    //id of photo

                    if ($("#controllerId").val() == 'visitor' || $("#controllerId").val() == 'visit') {
                        $("#Visitor_photo").val(data);
                    } else if ($("#controllerId").val() == 'companyLafPreferences')
                    {
                        $("#CompanyLafPreferences_logo").val(data);
                    }

                    else {
                        $("#Company_logo").val(data);
                    }

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('photo/GetPathOfCompanyLogo&id='); ?>' + data,
                        dataType: 'json',
                        data: data,
                        success: function(r) {

                            $.each(r.data, function(index, value) {
                                logo.src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                $(".photoDiv").show();
                                if ($("#controllerId").val() != 'companyLafPreferences' && $("#controllerId").val() != 'company') {
                                    document.getElementById('photoCropPreview').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                }
                                if ($("#controllerId").val() == 'visit') {
                                    $("#submitBtnPhoto").click();
                                    $("#cropImageBtn").show();
                                } else if ($("#controllerId").val() == 'visitor') {
                                    $("#cropImageBtn").show();
                                }
                            });
                            if ($("#viewFrom").val() == '1') {
                                window.parent.document.getElementById('companyModalIframe').style.height= "1015px";
                            }
                        }
                    });
                }
            }
        });
        if ($("#actionUpload").val() == 'detail') {
            $(".ajax-upload-dragdrop span").hide();
            $('.ajax-upload-dragdrop').css({"border": "none"});
            $('.ajax-upload-dragdrop').css({"padding": "0"});
        }
    });
</script>


