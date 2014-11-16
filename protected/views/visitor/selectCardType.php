<?php
$sameday = CardType::model()->findByPk(CardType::SAME_DAY_VISITOR);
$multiday = CardType::model()->findByPk(CardType::MULTI_DAY_VISITOR);
?>

<div id="selectCardDiv">
    <table class="selectCardTypeTable">
        <tr>
            <td>
                <label for="sameday" id="labelforsameday">
                    <img src="<?php echo Yii::app()->request->baseUrl . '/' . $sameday->card_icon_type; ?>"/>
                </label>
            </td>
            <td>
                <label for="multiday" id="labelformultiday">
                    <img src="<?php echo Yii::app()->request->baseUrl . '/' . $multiday->card_icon_type; ?>"/>
                </label>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;">
                <input type="radio" value="<?php echo CardType::SAME_DAY_VISITOR; ?>" name="selectCardType" id="sameday" checked />
            </td>
            <td style="text-align:center;">
                <input type="radio" value="<?php echo CardType::MULTI_DAY_VISITOR; ?>" name="selectCardType" id="multiday" />    
            </td>
        </tr>

    </table>

</div>
<br>
<br>
<div class="register-a-visitor-buttons-div">
<button id="clicktabA">Continue</button>
</div>
<script>
    $(document).ready(function() {
        $("#clicktabA").click(function(e) {
            e.preventDefault;
            var card_type_value;
            if (document.getElementById('sameday').checked) {
                card_type_value = document.getElementById('sameday').value;
            } else {
                card_type_value = document.getElementById('multiday').value;
            }
            $("#cardtype").val(card_type_value);
            $("#Visit_card_type").val(card_type_value);
            
        });

    });
</script>