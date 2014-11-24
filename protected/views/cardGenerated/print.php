<?php
$model = Visit::model()->findByPk($_GET['id']);
$visitorModel = Visitor::model()->findByPk($model->visitor);
?>

<div id="cardDiv" style="background:none;">
    <img src="<?php echo CardType::model()->findByPk($model->card_type)->card_background_image_path; ?>" alt="logo" > 

    <div style="position: absolute; padding-top:235px;padding-left:30px;">
        <table class="printCardTd" style="margin-left: 44px;
               margin-top:1500x;
               table-layout: fixed;
               width: 155px !important;
               z-index: 100;font-size:16px;font-weight:strong;" id="cardDetailsTable" >
            <tr>
                <td><b><?php echo CardType::$CARD_TYPE_LIST[$model->card_type]; ?></b></td>
            </tr>
            <tr>
                <td><b><?php echo $visitorModel->first_name . ' ' . $visitorModel->last_name ?></b></td>
            </tr>
            <tr>
                <td><b><?php
                        if ($visitorModel->company != '') {
                            echo Company::model()->findByPk($visitorModel->company)->name;
                        } else {
                            echo "Not Available";
                        }
                        ?></b></td>
            </tr>
            <tr>
                <td><b><?php
                        if ($model->card_type == CardType::SAME_DAY_VISITOR) {
                            echo date('d/m/Y');
                        } else {
                            echo Yii::app()->dateFormatter->format("d/MM/y", strtotime($model->date_out));
                        }
                        ?></b></td>
            </tr>
        </table>


    </div>
</div>