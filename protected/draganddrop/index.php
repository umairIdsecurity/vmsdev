<?php
if (isset($_GET['id'])) {
    $companyId = $_GET['id'];
} else {
    $companyId = '';
}
?>
<div id="fileuploader" style="margin-bottom:5px;">Browse Computer </div> 
<input type="hidden" id="actionUpload" value="<?php echo $this->action->id; ?>"/> 
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
                    $("#Company_logo").val(data);
                }
            }
        });
    });
</script>


