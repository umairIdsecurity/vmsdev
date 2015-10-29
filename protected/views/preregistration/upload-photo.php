<?php
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

    <div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div>

    <span class="text-size">Please upload a photo head and shoulders picture with no glasses or hat, on a white background. A Photo is not required if your visit is less than 24 hours.</span>
    
    <div class="row"><div class="col-sm-12">&nbsp;</div></div>

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
        <div class="col-sm-4">&nbsp;</div>
        <div class="col-sm-4">
            <div class="image-user">
                <img src="<?= $preImg ?>" alt="image user" id="preview" width="220" height="253">
                <br><br>
                <div class="custom-file-button" style="width: 220px">
                    <?php echo $form->fileField($model,'image'); ?>
                </div>
                <h4 class="subheading-size" style="text-align:center;width: 220px">UPLOAD / EDIT PHOTO </h4>
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

</script>