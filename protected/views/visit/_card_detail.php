<?php
$tenant = Company::model()->findByPk($visitorModel->tenant);
if ($tenant) {
    //$company = Company::model()->findByPk($tenant->company);
    $company = $tenant;
    if ($company) {
        $companyName = $company->name;
        $companyLogoId = $company->logo;
        $companyCode = $company->code;
    } else {
        $companyName = "N/A";
        $companyLogoId = "N/A";
        $companyCode = "N/A";
    }

    // $companyLogo =  Photo::model()->returnCompanyPhotoRelativePath($tenant->company);
    $userPhoto =  Photo::model()->returnVisitorPhotoRelativePath($model->visitor);

    $id = @is_null($company->logo)?1:$company->logo;

    $photo = Photo::model()->findByPk($id);
    if( $id == 1  || !is_object($photo) || is_null($photo->db_image)){
        $companyLogo = Yii::app()->controller->assetsBase . '/images/companylogohere1.png';
    } else {
         $companyLogo = 'data:image/'.pathinfo($photo->filename, PATHINFO_EXTENSION).';base64,'.$photo->db_image;
    }

} else {
    throw new CHttpException(404, 'Company not found for this User..');
}
$card = CardGenerated::model()->findByPk($model->card);
if ($card) {
    $cardCode = $card->card_number;
} else {
    $cardCode = 'N/A';
    //throw new CHttpException(404, 'Card Number not found for this User.');
}
?>

<div style="width:100%; float:left;">
    <!--Box 1-->
    <div  class="box-card-style">
        <div class="box-image-style"></div>
        <div style=" text-align:center; line-height:20px; margin:10px 0 0 5px; color:#000;height: 128px; overflow: hidden;">
            <p style="font-size:22px; font-weight:bold; margin:0 0 5px 0;"><?= $companyCode ?></p>
            <strong style="font-size: 30px; text-align: left; width: 100%; float: left; /*margin-bottom: 3px;*/ margin-left: 10px; /*line-height: 32px;*/ margin-top: 3px;"><small style="font-size: 60px;float: left; margin-right: 7px; margin-top: -1px;"><?= ($model->card_type == CardType::CONTRACTOR_VISITOR)?"C":"V"?></small>
            <?php
                if ($model->card_type == CardType::VIC_CARD_24HOURS) {     
                        echo date('d M y', strtotime($model->date_check_in . '+ 1 DAY'));
                  } else {
                        echo date('d M y', strtotime($model->date_check_out));
                }
            ?>
            <br><span style="font-size:18px; margin-left:43px"> <?php if($model->card_type == CardType::VIC_CARD_24HOURS && $model->time_check_in != "00:00:00") echo substr($model->time_check_in, 0, 5); ?></span>
            </strong>
           <p style="font-size:20px; font-weight:bold; line-height:20.9px; margin:0 0 3px 0;"><?php echo ($visitorModel->first_name != "")?substr($visitorModel->first_name, 0, 20):"N/A"; ?><br>
                <?php echo ($visitorModel->last_name != "")?substr($visitorModel->last_name, 0, 20):"N/A"; ?><br>
                <?php echo ($cardCode== "")?"N/A":$cardCode; ?></p>
        </div>
        <div class="box-card-logo">
            <div style="text-align: left;margin-left: 18px;width:134px; overflow: hidden;  min-height:34px; max-height: 40px;margin-top:2px; display:block;">
                <img border="1" style="height:38px !important;width:auto;" src="<?= $companyLogo; ?>">
            </div>
        </div>
    </div>
    <!--Box 2-->
</div>
<style>
    .box-card-style {
        float:left;
        width:256px;
        border:1px solid #000;
        height:410px;
        border-radius:20px;
        background:<?= $bgcolor ?>;
        position: relative;
    }
    .box-image-style {
        width:150px;
        height:205px;
        background:#fff;
        margin-left:15px;
        margin-top:13px;
    }
    .box-card-logo {
        background:#fff;
        border-radius:0 0 20px 20px;
        width:256px;
        height:50px;
        position: absolute;
        bottom: 0px;
        left: 0px;
    }
    #photoPreview {
        height: 206px;
        width: 152px;
    }
    .ajax-file-upload{
        margin-left: -228px !important;
        margin-top: 6px !important;
    }
    .editImageBtn{
        margin-top: 34px !important;
    }
</style>
