<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 7/11/15
 * Time: 3:21 PM
 */

?>

<?php
$session = new CHttpSession;

if(!empty($session['imgName'])){
    $preImg = '/uploads/visitor/'.$session['imgName'];
}
else{
    $preImg = Yii::app()->theme->baseUrl.'/images/user.png';
}

?>
<div class="page-content">
    <h1 class="text-primary title">PHOTO</h1>
    <div class="bg-gray-lighter form-info">Please upload a photo or take a head and shoulders picture with no glasses or hat, on a white background.</div>

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id' => 'upload-form',
        'enableClientValidation'=>false,
        'htmlOptions' =>
            array(
                'enctype' => 'multipart/form-data',
                'class' => 'form-upload-img',
            ),

    )); ?>

    <div class="text-center image-user">
        <img src="<?=$preImg ?>" alt="image user" id="preview">
    </div>

    <div class="form-group">
        <div class="custom-file-button">
            <?php echo $form->fileField($model,'image'); ?>
            <?php echo $form->error($model,'image'); ?>
        </div>
    </div>

    <h3 class="title text-center">UPLOAD/ TAKE PHOTO</h3>



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

     $("#UploadForm_image").change(function(){
        readURL(this);
     });

</script>