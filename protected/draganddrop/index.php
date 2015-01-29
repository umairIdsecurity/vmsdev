<?php
if (isset($_GET['id'])) {
    $companyId = $_GET['id'];
} else {
    $companyId = '';
}
?>
<div id="fileuploader" style="margin-bottom:5px;">Browse Computer </div> 
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
            url: "<?php echo Yii::app()->createUrl('site/upload&id=' . $this->id . '&companyId=' . $companyId . '&actionId=' . $this->action->id); ?>",
            allowedTypes: "png,gif,jpg,jpeg",
            fileName: "myfile",
            // maxFileCount: 1,
            maxFileSize: 2100000,
            showDone: false,
            showStatusAfterSuccess: false,
            onSuccess: function(files, data, xhr)
            {
                var logo = document.getElementById('companyLogo');
                var currentAction = $("#actionUpload").val();
                if (currentAction == 'update')
                {
                    logo.src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + data;
                    $(".companyLogoDiv").show();
                } else {
                    //id of photo
                    $("#Company_logo").val(data);
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('photo/GetPathOfCompanyLogo&id='); ?>' + data,
                        dataType: 'json',
                        data: data,
                        success: function(r) {

                            $.each(r.data, function(index, value) {
                                logo.src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                $(".companyLogoDiv").show();
                            });
                            if ($("#viewFrom").val() == '1') {
                                window.parent.document.getElementById('companyModalIframe').style.height= "715px"; 
                            }
                        }
                    });
                }
            }
        });
    });
</script>


