<?php
$session = new CHttpSession;
$visitor = Registration::model()->findByPk($session['visitor_id']);
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
    <span>Please upload a photo head and shoulders picture with no glasses or hat, on a white background.</span>
    <br><br>
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



    <div class="image-user">
        <img src="<?= $preImg ?>" alt="image user" id="preview" width="220" height="253">
    </div>

    <div class="form-group">
        <div class="custom-file-button">
            <?php echo $form->fileField($model,'image'); ?>

        </div>
        <p class="title"><?php echo $form->error($model,'image'); ?></p>
    </div>


    <h3 class="title">UPLOAD/ TAKE PHOTO </h3>
    <p class="title text-danger">'Allowed Max size: 2.00 MB'</p>



    <div class="row next-prev-btns">
        <div class="col-md-1 col-sm-1 col-xs-1">
            <a href="<?=Yii::app()->createUrl("preregistration/addasic")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
        </div>

        <div class="col-md-offset-10 col-sm-offset-10 col-xs-offset-9 col-md-1 col-sm-1 col-xs-1">
            <?php
            echo CHtml::tag('button', array(
                'type'=>'submit',
                'class' => 'btn btn-primary btn-next'
            ), 'NEXT <span class="glyphicon glyphicon-chevron-right"></span> ');
            ?>

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