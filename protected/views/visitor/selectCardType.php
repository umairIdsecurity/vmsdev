<?php
$session = new CHttpSession;
$sameday = CardType::model()->findByPk(CardType::SAME_DAY_VISITOR);
$multiday = CardType::model()->findByPk(CardType::MULTI_DAY_VISITOR);

$workstation_id = $session['workstation'];
$cardTypeWorkstationModel = WorkstationCardType::model()->findAllByAttributes(
    array('workstation'=>$workstation_id)
);

?>

<div id="selectCardDiv">
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

</div>
<br>
<br>
<div class="register-a-visitor-buttons-div">
<button id="clicktabA" class="actionForward">Continue</button>
</div>
<input type="text" style="display:none;" id="curdateLogVisit" value="<?php echo date('d-m-Y'); ?>"/>
<script>
    $(document).ready(function() {
        var SAMEDAY_TYPE = <?php echo CardType::SAME_DAY_VISITOR ?>;
        var MULTIDAY_TYPE = <?php echo CardType::MULTI_DAY_VISITOR ?>;

        $("#clicktabA").click(function(e) {
            e.preventDefault;
            var card_type_value = $("#selectCardDiv input[name=selectCardType]:checked").val();

            if (card_type_value == SAMEDAY_TYPE ) {
                $("#proposedDateOut").val($("#curdateLogVisit").val());
                $("#Visit_date_out").val($("#curdateLogVisit").val());
                $("#dateoutDiv").hide();
                $(".ui-datepicker-trigger").hide();
            } else if (card_type_value == MULTIDAY_TYPE ) {
                $("#proposedDateOut").val("");
                $("#Visit_date_out").val("");
                $("#dateoutDiv").show();
                $(".ui-datepicker-trigger").show();
            }

            /*if (document.getElementById('sameday').checked) {
                card_type_value = document.getElementById('sameday').value;
                $("#proposedDateOut").val($("#curdateLogVisit").val());
                $("#Visit_date_out").val($("#curdateLogVisit").val());
                $("#dateoutDiv").hide();
                $(".ui-datepicker-trigger").hide();
                
            } else {
                card_type_value = document.getElementById('multiday').value;
                 $("#proposedDateOut").val("");
                 $("#Visit_date_out").val("");
                  $("#dateoutDiv").show();
                 $(".ui-datepicker-trigger").show();
            }*/
            $("#cardtype").val(card_type_value);
            $("#Visit_card_type").val(card_type_value);
            $("#dateoutDiv").val('2014-12-11');

        });

    });
</script>