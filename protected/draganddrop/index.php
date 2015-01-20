<?php
if ($this->Id == 'visitor') {
    $dataId = '';
} elseif (isset($_GET['id'])) {
    $dataId = $_GET['id'];
} else {
    $dataId = '';
}
?>
<div id="fileuploader" style="margin-bottom:5px;">Browse Computer </div> 
<br><br>
<input type="button" style="display:none;" id="cropImageBtn" value="Crop Image">

<input type="hidden" id="actionUpload" value="<?php echo $this->action->id; ?>"/> 
<input type="hidden" id="controllerId" value="<?php echo $this->id; ?>"/> 
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
                if ($("#controllerId").val() == 'visitor') {
                    var logo = document.getElementById('photoPreview');
                } else {
                    var logo = document.getElementById('companyLogo');
                    
                }
                var currentAction = $("#actionUpload").val();
                if (currentAction == 'update')
                {
                    logo.src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + data;
                    $(".companyLogoDiv").show();
                } else {
                    //id of photo
                    
                    if ($("#controllerId").val() == 'visitor') {
                        $("#Visitor_photo").val(data);
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
                                logo.src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                $(".photoDiv").show();
                            });

                        }
                    });
                }
            }
        });
    });
</script>


