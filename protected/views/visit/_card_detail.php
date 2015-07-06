<?php
$tenant = User::model()->findByPk($visitorModel->created_by);
if ($tenant) {
    $company = Company::model()->findByPk($tenant->company);
    if ($company) {
        $companyName = $company->name;
        $companyLogoId = $company->logo;
        $companyCode = $company->code;
    } else {
        $companyName = "N/A";
        $companyLogoId = "N/A";
        $companyCode = "N/A";
    }

    $companyLogo =  Photo::model()->returnCompanyPhotoRelativePath($tenant->company);
    $userPhoto =  Photo::model()->returnVisitorPhotoRelativePath($model->visitor);
} else {
    throw new CHttpException(404, 'Company not found for this User.');
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
        <div style=" text-align:center; line-height:20px; margin:10px 0 0 5px; color:#000;">
            <p style="font-size:25px; font-weight:bold; margin:0 0 10px 0;"><?= $companyCode ?></p>
            <strong style="font-size: 40px; text-align: left; width: 100%; float: left; margin-bottom: 3px; margin-left: 5px; line-height: 32px; margin-top: 3px;"><small style="font-size: 60px;float: left; margin-right: 10px; margin-top: -1px;"><?= ($model->card_type == CardType::CONTRACTOR_VISITOR)?"C":"V"?></small> 
            <?php
                if ($model->card_type == CardType::VIC_CARD_24HOURS) {
                    echo date('dMy', strtotime($model->date_check_in . '+ 1 DAY'));
                } else {
                    echo date('dMy', strtotime($model->date_check_in));
                }
            ?>
            </strong>
            <p style="font-size:25px; font-weight:bold; line-height:20.9px; margin:0 0 3px 0;"><?php echo ($visitorModel->first_name != "")?$visitorModel->first_name:"N/A"; ?><br>
                <?php echo ($visitorModel->last_name != "")?$visitorModel->last_name:"N/A"; ?><br>
                <?php echo ($cardCode== "")?"N/A":$cardCode; ?></p>
        </div>
        <div class="box-card-logo">
            <div style="width:134px; overflow: hidden;  min-height:34px; max-height: 34px;   margin-left: -85px; margin-top:2px; display:inline-block;">
                <img border="1" style="height:34px !important;width:100%;" src="<?= $companyLogo; ?>">
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
        width:100px;
        height:150px;
        margin-left:15px;
        margin-top:13px;
    }
    .box-card-logo {
        background:#fff;
        border-radius:0 0 20px 20px;
        width:256px;
        height:50.7px;
        position: absolute;
        bottom: 0px;
        left: 0px;
    }
    #photoPreview {
        height: 133px;
        width: 100px;
    }
    .ajax-file-upload{
        margin-left: -228px !important;
        margin-top: 6px !important;
    }
    .editImageBtn{
        margin-top: 34px !important;
    }
</style>