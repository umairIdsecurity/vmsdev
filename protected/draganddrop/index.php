

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
if ($this->action->id == 'addvisitor' || ($this->action->id == 'update' && $this->id == 'visitor')) {
    ?>
    <style>
        .ajax-upload-dragdrop {
            float:left !important;
            margin-left: 64px !important;
            margin-top: -30px;
            background: url('<?php echo Yii::app()->controller->assetsBase; ?>/images/portrait_box.png') no-repeat center top;
            background-size:137px;
            height: 150px;
            width: 120px !important;
        }
        .ajax-file-upload{
            margin-left: -66px !important;
            margin-top: 220px !important;
            position:absolute !important;
            font-size: 12px !important;
            padding-bottom:3px;
            height:17px;
        }

        .editImageBtn{
            margin-left: -103px !important;
            color:white;
            font-weight:bold;
            text-shadow: 0 0 !important;
            font-size:12px !important;
            height:24px;
            width:131px !important;
        }
        .imageDimensions{
            display:none !important;
        }
        #cropImageBtn{
            float: left;
            margin-left: -17px !important;
            margin-top: 210px;
            position: absolute;
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
            font-size: 12px !important;
            padding-bottom:3px;
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
            font-size: 12px !important;
            padding-bottom:5px;
        }


        .editImageBtn{
            margin-top: -10px !important;
            margin-left:6px !important;
            color:white;
            font-weight:bold;
            text-shadow: 0 0 !important;
            font-size:12px !important;
            height:23px;
            width:131px !important;
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
            font-size: 12px !important;
            padding-bottom:3px;
        }
        .editImageBtn{
            margin-left: 6px;
            margin-top: -9px;
        }
    </style>
<?php } elseif ($this->action->id == 'detail') { ?>
    <style>
        .ajax-file-upload{
            font-size: 12px !important;
            margin-left: -181px;
            width: 182.9px;
            padding-bottom:3px;
            height: 17px;
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
<input type="button"  style="display:none;" id="cropImageBtn" class="btn actionForward editImageBtn" value="Edit Photo" onclick = "document.getElementById('light').style.display = 'block';
        document.getElementById('fade').style.display = 'block'">

<input type="hidden" id="actionUpload" value="<?php echo $this->action->id; ?>"/> 
<input type="hidden" id="controllerId" value="<?php echo $this->id; ?>"/> 
<input type="hidden" id="viewFrom" value="<?php
if (isset($_GET['viewFrom'])) {
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
            allowedTypes: "png,jpg,jpeg",
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
                    } else {
                        $("#Company_logo").val(data);
                    }

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('photo/GetPathOfCompanyLogo&id='); ?>' + data,
                        dataType: 'json',
                        data: data,
                        success: function(r) {

                            $.each(r.data, function(index, value) {
                                if ($("#actionUpload").val() == 'addvisitor') {
                                    $(".ajax-upload-dragdrop").css("background", "url(<?php echo Yii::app()->request->baseUrl; ?>" + value.relative_path + ") no-repeat");
                                    $(".ajax-upload-dragdrop").css({
                                        "background-size": "100% 100%"
                                    });
                                } else {
                                    logo.src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                    $(".photoDiv").show();
                                }

                                if ($("#controllerId").val() != 'companyLafPreferences' && $("#controllerId").val() != 'company') {
                                    document.getElementById('photoCropPreview').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                }
                                if ($("#controllerId").val() == 'visit') {
                                    $("#submitBtnPhoto").click();
                                    if ($("#visitorOriginalValue").val() == '') {
                                        $("#cropImageBtn").show();
                                    }

                                } else if ($("#controllerId").val() == 'visitor') {
                                    $("#cropImageBtn").show();
                                }
                            });
                            if ($("#viewFrom").val() == '1') {
                                window.parent.document.getElementById('companyModalIframe').style.height = "1015px";
                            }
                        }
                    });
                }
            }
        });
        if ($("#actionUpload").val() == 'addvisitor') {
            $(".uploadnotetext").html('');
        }
        if ($("#actionUpload").val() == 'detail') {
            $(".ajax-upload-dragdrop span").hide();
            $('.ajax-upload-dragdrop').css({"border": "none"});
            $('.ajax-upload-dragdrop').css({"padding": "0"});
        }
    });
</script>
