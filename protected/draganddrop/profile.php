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
//echo '<pre>';
//var_dump($model->photo1);
//echo '</pre>';
if ($model->photo1) {
    $background = $model->photo1->relative_path;
} else {
    $background = Yii::app()->controller->assetsBase . "/images/portrait_box.png";
}
?>
<style>
    .ajax-upload-dragdrop2 {
        float:left !important;
        margin-left: 25px !important;
        margin-top: 10px;
        background: url('<?php echo $background ?>') no-repeat center top;
        background-size:137px;
        height: 150px;
        width: 120px !important;
        padding: 87px 5px 12px 90px;
        border:none;
        color: #DADCE3;
        text-align: center !important;

    }
    .ajax-file-upload{
        margin-left: -107px !important;
        margin-top: 170px !important;
        position:absolute !important;
        font-size: 12px !important;
        padding-bottom:3px;
        height:17px;
    }

    .no-smil .ajax-file-upload{
        margin-left: -49px !important;
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
    #cropImageBtn2 {
        float: left;
        margin-left: -174px !important;
        margin-top: 257px;
        position: absolute;
    }
    .imageDimensions{
        display:none !important;
    }
    #cropImageBtn{
        float: left;
        margin-left: -54px !important;
        margin-top: 257px;
        position: absolute;
    }
    .uploadnotetext{
        margin-top:102px;
        margin-left: -83px;
    }
    #photoPreview2 {
        height: 154px;
        width: 113px;
    }
</style>


<div id="fileuploader2" style="margin-bottom:5px;"><?php

    echo "Upload Photo";

    ?> </div>
<br><br>
<!--<input type="button"  style="display:none;" id="cropImageBtn2" class="btn actionForward editImageBtn" value="Edit Photo" onclick = "document.getElementById('light2').style.display = 'block';-->
<!--        document.getElementById('fade2').style.display = 'block'">-->

<input type="hidden" id="actionUpload2" value="<?php echo $this->action->id; ?>"/>
<input type="hidden" id="controllerId2" value="<?php echo $this->id; ?>"/>
<input type="hidden" id="viewFrom2" value="<?php
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

        $("#fileuploader2").uploadFile({
            url: "<?php echo Yii::app()->createUrl('site/upload&id=profile&companyId=' . $dataId . '&actionId=' . $this->action->id); ?>",
            allowedTypes: "png,jpg,jpeg",
            fileName: "myfile2",
            dragDropContainerClass: "ajax-upload-dragdrop2",
            // maxFileCount: 1,
            maxFileSize: 2100000,
            showDone: false,
            showStatusAfterSuccess: false,
            onSuccess: function(files, data, xhr)
            {

                var logo = document.getElementById('photoPreview2');


                var currentAction = $("#actionUpload2").val();


                $("#Host_photo").val(data);

                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl('photo/GetPathOfCompanyLogo&id='); ?>' + data,
                    dataType: 'json',
                    data: data,
                    success: function(r) {

                        $.each(r.data, function(index, value) {

                            $(".ajax-upload-dragdrop2").css("background", "url(<?php echo Yii::app()->request->baseUrl."/"; ?>" + value.relative_path + ") no-repeat center top");
                            $(".ajax-upload-dragdrop2").css({
                                "background-size": "126px 146px"
                            });
                            document.getElementById('photoCropPreview2').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                        });
                    }
                });

            }
        });
    });
</script>
