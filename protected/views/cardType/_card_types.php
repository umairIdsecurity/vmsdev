<table class="selectCardTypeTable">
    <tr>
        <?php
        foreach($cardTypeWorkstationModel as $cardType){
            $cardTypeModel = CardType::model()->findByPk($cardType->card_type);
            ?>
            <td>
                <label for="sameday" id="labelforsameday">
                    <?php
                    echo CHtml::image( Yii::app()->controller->assetsBase . "/". $cardTypeModel->card_background_image_path );
                    ?>
                </label>
            </td>
        <?php
        }
        ?>

    </tr>
    <tr>
        <?php
        foreach($cardTypeWorkstationModel as $cardType){

            ?>
            <td style="text-align:center;">
                <input type="radio" value="<?php echo $cardType->card_type ?>" name="selectCardType" />
            </td>
        <?php
        }
        ?>
    </tr>

</table>