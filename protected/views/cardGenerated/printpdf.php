<?php
if (array_key_exists($model->card_type, CardType::$CARD_TYPE_LIST)) {
    $cardType = !empty($model->card_type) ? CardType::$CARD_TYPE_LIST[$model->card_type] : NULL;
}

$visitorName = ($visitorModel->first_name) ? $visitorModel->first_name : "" . ' ' . ($visitorModel->last_name) ? $visitorModel->last_name : "";
if (strlen($visitorModel->first_name . ' ' . $visitorModel->last_name) > 32) {
    $first_name = explode(' ', $visitorModel->first_name);
    $last_name = explode(' ', $visitorModel->last_name);
    $visitorName = $first_name[0] . ' ' . $last_name[0];
} else {
    $visitorName = $visitorModel->first_name . ' ' . $visitorModel->last_name;
}

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
        $companyCode = "";
    }

    $companyLogo = Yii::app()->getBaseUrl(true) . "/" . Photo::model()->returnCompanyPhotoRelativePath($tenant->company);
    $userPhoto = Yii::app()->getBaseUrl(true) . "/" . Photo::model()->returnVisitorPhotoRelativePath($model->visitor);
} else {
    throw new CHttpException(404, 'Company not found for this User.');
}
$card = CardGenerated::model()->findByPk($model->card);
if ($card) {
    $cardCode = $card->card_number;
} else {
    $cardCode = '';
    //throw new CHttpException(404, 'Card Number not found for this User.');
}
$visitorName = wordwrap($visitorName, 13, "\n", true);

$dateExpiry = date('d M y');
if ($model->card_type != CardType::SAME_DAY_VISITOR) {
    $dateExpiry = date("d M y", strtotime($model->date_out));
}

if ($model->date_check_out != null) {
    $dateExpiry = date("d M y", strtotime($model->date_check_out));
}

if ($model->time_check_out && $model->card_type == CardType::VIC_CARD_24HOURS && $model->visit_status == VisitStatus::ACTIVE) {
    $dateExpiry.="<br>" . substr($model->time_check_out, 0, -3);
}

if ($visitorModel->profile_type === 'CORPORATE') {
    $bgcolor = CardGenerated::CORPORATE_CARD_COLOR;
} elseif ($visitorModel->profile_type === "VIC") {
    $bgcolor = CardGenerated::VIC_CARD_COLOR;
} elseif ($visitorModel->profile_type === "ASIC") {
    $bgcolor = CardGenerated::ASIC_CARD_COLOR;
}
$backText = NULL;
if ($model->card_type != CardType::VIC_CARD_MANUAL) {
    $cardtext = CardType::model()->findByPk($model->card_type);
    if ($cardtext->back_text != NULL) {
        $backText = $cardtext->back_text;
    } else {
        $backText = NULL;
    }
}

//die;
?>
<?php if ($type == 1) { ?>
    <table border="1">
        <tr>
            <td <?php echo $bgcolor; ?> width="215px">

                <table cellpadding="10" style=" border-radius:10px" width="204px" height="325px">
                    <tr>
                        <td colspan="2">
                            <img border="0" width="129px" height="162px" src="<?php echo $userPhoto; ?>" /> 
                        </td>


                    </tr>
                    <tr>
                        <td color="black" align="center" style="font-family: sans-serif;font-size: 73px;font-weight: bolder;" ><?php echo($model->card_type == CardType::CONTRACTOR_VISITOR) ? 'C' : 'V'; ?></td>
                        <td <?php echo $bgcolor; ?> align="center" style="font-family: sans-serif;font-size: 15px;"><b><?php echo $companyCode; ?><br><?php echo $dateExpiry; ?><br></b><?php echo $visitorName; ?><br><?php echo $cardCode; ?><br></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <img border="0" width="60px" height="40px" src="<?php echo $companyLogo; ?>">
                        </td>
                    </tr>
                </table>
            </td>
            <?php if (($model->card_type != CardType::VIC_CARD_MANUAL) || ($backText != NULL)): ?>
                <td padding="10" align="center" style="font-family:sans-serif;font-size:18px;font-weight:300;" width="215px">

                    <table cellpadding="10" style=" border-radius:10px" width="204px" height="325px">
                        <tr>
                            <td colspan="2"align="center" style="font-family:sans-serif;font-size:15px;font-weight:300;">
                                <div>&nbsp;&nbsp;&nbsp;</div>
                                <?php echo $backText; ?>
                            </td>
                        </tr>

                    </table>
                </td>
            <?php endif; ?>
        </tr>


    </table>
<?php } else if ($type == 2) { ?>
    <table border="0">
        <tr>
            <td <?php echo $bgcolor; ?> width="210px">

                <table cellpadding="10" style=" border-radius:10px" width="204px" height="325px">
                    <tr>
                        <td colspan="2">
                            <img border="1" width="129px" height="162px" src="<?php echo $userPhoto; ?>" /> 
                        </td>


                    </tr>
                    <tr>
                        <td color="black" align="center" style="font-family: sans-serif;font-size: 73px;font-weight: bolder;" ><?php echo($model->card_type == 4) ? 'C' : 'V'; ?></td>
                        <td <?php echo $bgcolor; ?> align="left" style="font-family: sans-serif;font-size: 15px;"><b><?php echo $companyCode; ?><br><?php echo $dateExpiry; ?><br></b><?php echo $visitorName; ?><br><?php echo $cardCode; ?><br></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <img border="0" width="60px" height="40px" src="<?php echo $companyLogo; ?>">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php if (($model->card_type != CardType::VIC_CARD_MANUAL) || ($backText != NULL)): ?>
            <tr>
                <td padding="10" align="center" style="font-family:sans-serif;font-size:15px;font-weight:300;" width="250px">

                    <table cellpadding="10" style=" border-radius:10px" width="204px" height="325px">
                        <tr>
                            <td colspan="2"align="center" style="font-family:sans-serif;font-size:15px;font-weight:300;">
                                <div>&nbsp;&nbsp;&nbsp;</div>
                                <?php echo $backText; ?>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        <?php endif; ?>

    </table>
<?php } else if ($type == 3) { ?>
    <table border="0">
        <tr>
            <td width="210px">

                <table cellpadding="10" style=" border-radius:10px" width="204px" height="325px">
                    <tr>
                        <td colspan="2">
                            <img border="0" width="129px" height="162px" src="<?php echo $userPhoto; ?>" /> 
                        </td>


                    </tr>
                    <tr>
                        <td color="black" align="center" style="font-family: sans-serif;font-size: 73px;font-weight: bolder;" ><?php echo($model->card_type == 4) ? 'C' : 'V'; ?></td>
                        <td align="left" style="font-family: sans-serif;font-size: 15px;"><b><?php echo $companyCode; ?><br><?php echo $dateExpiry; ?><br></b><?php echo $visitorName; ?><br><?php echo $cardCode; ?><br></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <img border="0" width="60px" height="40px" src="<?php echo $companyLogo; ?>">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php if (($model->card_type != CardType::VIC_CARD_MANUAL) || ($backText != NULL)): ?>
            <tr>
                <td padding="10" align="center" style="font-family:sans-serif;font-size:18px;font-weight:300;" width="250px">

                    <table cellpadding="10" style=" border-radius:10px" width="204px" height="325px">
                        <tr>
                            <td colspan="2"align="center" style="font-family:sans-serif;font-size:15px;font-weight:300;">
                                <div>&nbsp;&nbsp;&nbsp;</div>
                                <?php echo $backText; ?>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        <?php endif; ?>

    </table>
<?php } ?>