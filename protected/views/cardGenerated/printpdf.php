<?php
    $cardType = CardType::$CARD_TYPE_LIST[$model->card_type];
    $visitorName = $visitorModel->first_name . ' ' . $visitorModel->last_name;
    $tenant = User::model()->findByPk($visitorModel->tenant);
    $companyTenant = Company::model()->findByPk($tenant->company);
    $card = CardGenerated::model()->findByPk($model->card);
    $visitorName = wordwrap($visitorName, 13, "\n", true);

    $company = Company::model()->findByPk($tenant->company);
    $companyName = $company->name;
    $companyLogoId = $company->logo;
    $companyCode = $company->code;

    $cardCode = $card->card_number;

    $companyLogo = Yii::app()->getBaseUrl(true) . "/" . Photo::model()->returnCompanyPhotoRelativePath($tenant->company);
    
    $userPhoto = Yii::app()->getBaseUrl(true) . "/" . Photo::model()->returnVisitorPhotoRelativePath($model->visitor);

    $dateExpiry = date('d M y');
    if ($model->card_type != CardType::SAME_DAY_VISITOR) {
        $dateExpiry = date("d M y", strtotime($model->date_out));
    }
//die;
?>
<?php if ($type==1){?>
<table border="0">
    <tr>
        <td bgcolor="#FFFF00" width="210px">

            <table cellpadding="10" style=" border-radius:10px" width="204px" height="325px">
                <tr>
                    <td colspan="2">
                        <img border="1" width="129px" height="162px" src="<?php echo $userPhoto;?>" /> 
                    </td>


                </tr>
                <tr>
                    <td color="black" align="center" style="font-family: sans-serif;font-size: 73px;font-weight: bolder;" >V</td>
                    <td bgcolor="#FFFF00" align="left" style="font-family: sans-serif;font-size: 15px;"><b><?php echo $companyCode;?><br><?php echo $dateExpiry;?><br></b><?php echo $visitorName;?><br><?php echo $cardCode;?><br></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <img border="1" width="60px" height="40px" src="<?php echo $companyLogo;?>">
                    </td>
                </tr>
            </table>
        </td>
        <td padding="10" align="center" style="font-family:sans-serif;font-size:18px;font-weight:300;" width="250px">

            <table cellpadding="10" style=" border-radius:10px" width="204px" height="325px">
                <tr>
                    <td colspan="2"align="center" style="font-family:sans-serif;font-size:15px;font-weight:300;">
                        <div>&nbsp;&nbsp;&nbsp;</div>
                        A VIC holder is required to immediately leave a secure area if he/she is no longer supervised by an ASIC holder. [ATSR 3.09]
                        <br>
                        <br>
                        A person must not knowingly apply for a VIC for a period which will exceed a total of 28 days in a 12-month period. [ATSR 6.25
                        <br>
                        <br>
                        Albany Airport Services
                    </td>
                </tr>

            </table>
        </td>
    </tr>


</table>
<?php } else if ($type == 2){ ?>
<table border="0">
    <tr>
        <td bgcolor="#FFFF00" width="210px">

            <table cellpadding="10" style=" border-radius:10px" width="204px" height="325px">
                <tr>
                    <td colspan="2">
                        <img border="1" width="129px" height="162px" src="<?php echo $userPhoto;?>" /> 
                    </td>


                </tr>
                <tr>
                    <td color="black" align="center" style="font-family: sans-serif;font-size: 73px;font-weight: bolder;" >V</td>
                    <td bgcolor="#FFFF00" align="left" style="font-family: sans-serif;font-size: 15px;"><b><?php echo $companyCode;?><br><?php echo $dateExpiry;?><br></b><?php echo $visitorName;?><br><?php echo $cardCode;?><br></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <img border="1" width="60px" height="40px" src="<?php echo $companyLogo;?>">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td padding="10" align="center" style="font-family:sans-serif;font-size:15px;font-weight:300;" width="250px">

            <table cellpadding="10" style=" border-radius:10px" width="204px" height="325px">
                <tr>
                    <td colspan="2"align="center" style="font-family:sans-serif;font-size:15px;font-weight:300;">
                        <div>&nbsp;&nbsp;&nbsp;</div>
                        A VIC holder is required to immediately leave a secure area if he/she is no longer supervised by an ASIC holder. [ATSR 3.09]
                        <br>
                        <br>
                        A person must not knowingly apply for a VIC for a period which will exceed a total of 28 days in a 12-month period. [ATSR 6.25
                        <br>
                        <br>
                        Albany Airport Services
                    </td>
                </tr>

            </table>
        </td>
    </tr>


</table>
<?php }else if ($type == 3){?>
<table border="0">
    <tr>
        <td width="210px">

            <table cellpadding="10" style=" border-radius:10px" width="204px" height="325px">
                <tr>
                    <td colspan="2">
                        <img border="1" width="129px" height="162px" src="<?php echo $userPhoto;?>" /> 
                    </td>


                </tr>
                <tr>
                    <td color="black" align="center" style="font-family: sans-serif;font-size: 73px;font-weight: bolder;" >V</td>
                    <td align="left" style="font-family: sans-serif;font-size: 15px;"><b><?php echo $companyCode;?><br><?php echo $dateExpiry;?><br></b><?php echo $visitorName;?><br><?php echo $cardCode;?><br></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <img border="1" width="60px" height="40px" src="<?php echo $companyLogo;?>">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td padding="10" align="center" style="font-family:sans-serif;font-size:18px;font-weight:300;" width="250px">

            <table cellpadding="10" style=" border-radius:10px" width="204px" height="325px">
                <tr>
                    <td colspan="2"align="center" style="font-family:sans-serif;font-size:15px;font-weight:300;">
                        <div>&nbsp;&nbsp;&nbsp;</div>
                        A VIC holder is required to immediately leave a secure area if he/she is no longer supervised by an ASIC holder. [ATSR 3.09]
                        <br>
                        <br>
                        A person must not knowingly apply for a VIC for a period which will exceed a total of 28 days in a 12-month period. [ATSR 6.25
                        <br>
                        <br>
                        Albany Airport Services
                    </td>
                </tr>

            </table>
        </td>
    </tr>


</table>
<?php } ?>