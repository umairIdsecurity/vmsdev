<?php
$session = new CHttpSession;
$sameday = CardType::model()->findByPk(CardType::SAME_DAY_VISITOR);
$multiday = CardType::model()->findByPk(CardType::MULTI_DAY_VISITOR);

$workstation_id = $session['workstation'];

if (!isset($workstation_id)) {
    $user = User::model()->findByPK(Yii::app()->user->id);
    $workstations = Workstation::model()->findAllByAttributes(array('tenant' => $user->tenant, 'tenant_agent' => $user->tenant_agent));
    if (isset($workstations[0])) { ?>
        <div class="form">
            <table class="selectworkstation-area" style="padding:12px;">
                <tr>
                    <td style="font-size:12px;font-weight: bold;text-align: center">Please select your workstation</td>
                </tr>
                <tr>
                    <td style="text-align: center">
                        <select style='font-size:12px;' name='userWorkstation' id='userWorkstation'>
                            <?php foreach ($workstations as $workstation) { ?>
                                <option value='<?php echo $workstation->id; ?>'><?php echo $workstation->name; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
            </table>
        </div><!-- form -->
    <?php
        $workstation_id = $workstations[0]->id;
    }
}

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
<div class="register-a-visitor-buttons-div" style="text-align: right;">
<button id="clicktabA" class="actionForward">Continue</button>
</div>
<input type="text" style="display:none;" id="curdateLogVisit" value="<?php echo date('d-m-Y'); ?>"/>
<script>
    $(document).ready(function() {

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

            $("#cardtype").val(card_type_value);
            $("#Visit_card_type").val(card_type_value);
            $("#dateoutDiv").val('2014-12-11');
        });

        $(document).on("change", "#userWorkstation", function(e) {
            e.preventDefault;
            var selected = $(this).val();

            $.ajax({
                url: '<?php echo Yii::app()->createUrl('cardType/selectWorkstation'); ?>',
                type: "POST",
                data: { workstation: selected },
                dataType: "json",
                beforeSend: function() {
                    $("#selectCardDiv").html("Loading card types...");
                },
                success: function(res) {
                    if (res.html) {
                        $("#selectCardDiv").html(res.html);
                    }
                }
            });
        });

    });

</script>