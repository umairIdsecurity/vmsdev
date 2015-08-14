<?php
$session = new CHttpSession;

$sameday = CardType::model()->findByPk(CardType::SAME_DAY_VISITOR);
$multiday = CardType::model()->findByPk(CardType::MULTI_DAY_VISITOR);

$workstation_id = $session['workstation'];

if (!isset($workstation_id)) {
    $user = User::model()->findByPK(Yii::app()->user->id);

    if ($user->role == Roles::ROLE_AGENT_ADMIN) {
        $workstations = Workstation::model()->findAllByAttributes(array('tenant' => $user->tenant, 'tenant_agent' => $user->tenant_agent, 'is_deleted' => 0));
    } else {
        $workstations = Workstation::model()->findAllByAttributes(array('is_deleted' => 0));
    }

    if (!$workstations) {
        $this->redirect(Yii::app()->createUrl('workstation/create'));
    } else {
        $session['workstation'] = $workstations[0]->id;
        $workstation_id = $workstations[0]->id;
    }
}

$cardTypeWorkstationModel = WorkstationCardType::model()->findAllByAttributes(array('workstation'=>$workstation_id));

if (!$cardTypeWorkstationModel) {
    $this->redirect(Yii::app()->createUrl('workstation/admin'));
}
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
            <div id="card_type" class="errorMessage" style="text-transform: none;display:none">Please Select Card Type</div>
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
            e.preventDefault();
            var card_type_value = $("#selectCardDiv").find("input[name=selectCardType]:checked").val();

            if (!card_type_value) {
                $('#card_type').css('display',"block");
                e.stopImmediatePropagation();
                return false;
            }

            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('VisitorType/getFromCardType&cardtype='); ?>' + card_type_value,
                dataType: 'json',
                data: card_type_value,
                success: function (r) {
                    if(r) {
                        var opt = '<option value ="">Select Visitor Type</option>';
                        var isDefault;
                        $.each(r, function (index, value) {
                            
                            isDefault = "";
                            if( value.is_default_value )
                                isDefault = "selected";
                            opt += '<option value="' + value.id + '" '+ isDefault +'>Visitor Type: ' + value.name + '</option>';
                        });
                        $('#Visitor_visitor_type').html(opt);
                    }
                }
            });
            // For reason
             $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('visitReason/getCardTypeReason&cardtype='); ?>' + card_type_value,
                dataType: 'json',
                data: card_type_value,
                success: function (r) {
                    if(r) {
                        var opt = '<option value ="">Select Visit Reason</option>';
                        $.each(r, function (index, value) {
                            opt += '<option value="' + value.id + '">Visit Reason: ' + value.reason + '</option>';
                        });
                        $('#Visit_reason').html(opt);
                    }
                }
            });
            
            var dateoutDiv = $("#dateoutDiv");
            if (card_type_value == SAMEDAY_TYPE ) {
                var curdateLogVisit = $("#curdateLogVisit");
                $("#proposedDateOut").val(curdateLogVisit.val());
                $("#Visit_date_out").val(curdateLogVisit.val());
                dateoutDiv.hide();
                $(".ui-datepicker-trigger").hide();
            } else if (card_type_value == MULTIDAY_TYPE ) {
                $("#proposedDateOut").val("");
                $("#Visit_date_out").val("");
                dateoutDiv.show();
                $(".ui-datepicker-trigger").show();
            }




            $("#cardtype").val(card_type_value);
            $("#Visit_card_type").val(card_type_value);
            dateoutDiv.val('2014-12-11');
        });
    });

</script>