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
</div>