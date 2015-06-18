<?php
$tenant = User::model()->findByPk($visitorModel->tenant);
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
    <div style="float:left; width:256px; border:1px solid #000; height:410px; border-radius:20px; background:<?= $bgcolor ?>;">
        <div style="width:150px; height:205px; background:#fff; margin-left:15px; margin-top:13px; border:1px solid #000;"></div>
        <div style=" text-align:center; line-height:20px; margin:10px 0 0 5px; color:#000;">
            <p style="font-size:25px; font-weight:bold; margin:0 0 10px 0;"><?= $companyCode ?></p>
            <strong style="font-size: 40px; text-align: left; width: 100%; float: left; margin-bottom: 3px; margin-left: 5px; line-height: 32px; margin-top: 3px;"><small style="font-size: 60px;float: left; margin-right: 10px; margin-top: -1px;"><?= ($model->card_type == CardType::CONTRACTOR_VISITOR)?"C":"V"?></small> 22JUL12</strong>
            <p style="font-size:25px; font-weight:bold; line-height:20.9px; margin:0 0 3px 0;"><?php echo ($visitorModel->first_name != "")?$visitorModel->first_name:"N/A"; ?><br>
                <?php echo ($visitorModel->last_name != "")?$visitorModel->last_name:"N/A"; ?><br>
                <?php echo ($cardCode== "")?"N/A":$cardCode; ?></p>
        </div>
        <div style="background:#fff; border-radius:0 0 20px 20px; width:256px; height:48.7px;">
            <div style="background:#6fb99e; width:69px;  height:35px;   margin-left: -139px; margin-top:2px; border:1px solid #000; display:inline-block;">
                <img border="1" style="height:30x; width:100%;" src="<?= $companyLogo; ?>">
            </div>
        </div>
    </div>
    <!--Box 2-->
</div>
<style>
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