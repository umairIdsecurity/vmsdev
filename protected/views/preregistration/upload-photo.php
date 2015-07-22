<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 7/11/15
 * Time: 3:21 PM
 */

?>

<div class="page-content">
    <h1 class="text-primary title">PHOTO</h1>
    <div class="bg-gray-lighter form-info">Please upload a photo or take a head and shoulders picture with no glasses or hat, on a white background.</div>
    <form class="form-upload-img" action=""
          enctype="multipart/form-data" method="post">
        <div class="text-center image-user">
            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/user.png" alt="image user">
        </div>
        <div class="form-group">
            <div class="custom-file-button"><input type="file" name="user-icon" /></div>
        </div>
        <h3 class="title text-center">UPLOAD/ TAKE PHOTO</h3>
    </form>

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
</div>