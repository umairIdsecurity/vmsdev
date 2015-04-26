

<?php
if ($this->Id == 'visitor') {
    $dataId = '';
} elseif (isset($_GET['id'])) {
    $dataId = $_GET['id'];
} else {
    $dataId = '';
}
?>

    <style>
        .ajax-upload-dragdrop3 {
            float:left !important;
            margin-left: 25px !important;
            margin-top: 10px;
            background: url('<?php echo Yii::app()->controller->assetsBase; ?>/images/portrait_box.png') no-repeat center top;
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

        .editImageBtn{
            margin-left: -103px !important;
            color:white;
            font-weight:bold;
            text-shadow: 0 0 !important;
            font-size:12px !important;
            height:24px;
            width:131px !important;
        }
		#cropImageBtn3 {
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
		#photoPreview3 {
  height: 154px;
  width: 113px;
}
    </style>
    

<div id="fileuploader3" style="margin-bottom:5px;"><?php
   
        echo "Upload Photo";
  
    ?> </div> 
<br><br>
<input type="button"  style="display:none;" id="cropImageBtn3" class="btn actionForward editImageBtn" value="Edit Photo" onclick = "document.getElementById('light3').style.display = 'block';
        document.getElementById('fade3').style.display = 'block'">

<input type="hidden" id="actionUpload3" value="<?php echo $this->action->id; ?>"/> 
<input type="hidden" id="controllerId3" value="<?php echo $this->id; ?>"/> 
<input type="hidden" id="viewFrom3" value="<?php
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

        $("#fileuploader3").uploadFile({
            url: "<?php echo Yii::app()->createUrl('site/upload&id=user&companyId=' . $dataId . '&actionId=' . $this->action->id); ?>",
            allowedTypes: "png,jpg,jpeg",
            fileName: "myfile2",
			dragDropContainerClass: "ajax-upload-dragdrop3",
            // maxFileCount: 1,
            maxFileSize: 2100000,
            showDone: false,
            showStatusAfterSuccess: false,
            onSuccess: function(files, data, xhr)
            {
               
                    var logo = document.getElementById('photoPreview3');
                

                var currentAction = $("#actionUpload3").val();
               
                   
                        $("#Host_photo3").val(data);
                 
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('photo/GetPathOfCompanyLogo&id='); ?>' + data,
                        dataType: 'json',
                        data: data,
                        success: function(r) {

                            $.each(r.data, function(index, value) {
                               
                                    $(".ajax-upload-dragdrop3").css("background", "url(<?php echo Yii::app()->request->baseUrl."/"; ?>" + value.relative_path + ") no-repeat center top");
                                    $(".ajax-upload-dragdrop3").css({
                                        "background-size": "137px 190px"
                                    });
                                    logo.src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                               

                               
                                    document.getElementById('photoCropPreview3').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                
                              
                                    $("#cropImageBtn3").show();
                                
                            });
                            if ($("#viewFrom3").val() == '1') {
                                window.parent.document.getElementById('companyModalIframe').style.height = "1015px";
                            }
                        }
                    });
               
            }
        });
        if ($("#actionUpload3").val() == 'detail') {
            $(".uploadnotetext").html('');
        }
        if ($("#actionUpload3").val() == 'detail') {
            $(".ajax-upload-dragdrop3 span").hide();
            $('.ajax-upload-dragdrop3').css({"border": "none"});
            $('.ajax-upload-dragdrop3').css({"padding": "0"});
        }
    });
</script>
