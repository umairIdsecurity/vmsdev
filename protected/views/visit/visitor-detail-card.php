<?php
$session = new CHttpSession;

?>
<div id="cardDiv" 
     style="background: url('../images/cardprint-new.png') no-repeat center top;">
    <div style="position: relative; padding-top:180px;padding-left:30px;">
        <table class="" style="width:100%;margin-left:100px;" id="cardDetailsTable">
            <tr>
                <td><?php echo CardType::$CARD_TYPE_LIST[$model->card_type]; ?></td>
            </tr>
            <tr>
                <td><?php echo $visitorModel->first_name . ' ' . $visitorModel->last_name; ?></td>
            </tr>
            <tr>
                <td><?php
                    if ($visitorModel->company != '') {
                        echo Company::model()->findByPk($visitorModel->company)->name;
                    } else {
                        echo "Not Available";
                    }
                    ?></td>
            </tr>
            <tr>
                <td><?php
                    if ($model->card_type == CardType::SAME_DAY_VISITOR) {
                        
                        if($model->date_out ==''){
                            echo date('d/m/Y');
                        } else {
                            echo Yii::app()->dateFormatter->format("d/MM/y", strtotime($model->date_out));
                        }
                    } else {
                        echo Yii::app()->dateFormatter->format("d/MM/y", strtotime($model->date_out));
                    }
                    ?></td>
            </tr>
        </table>


    </div>
</div>
<div
    <?php 
    if($session['role'] == Roles::ROLE_STAFFMEMBER){
        echo "style='display:none'";
    }
    ?>
    >
<?php

    $cardDetail = CardGenerated::model()->findAllByAttributes(array(
        'visitor_id' => $model->visitor
    ));
    if ($model->card != NULL && $model->visit_status == VisitStatus::ACTIVE) {
        ?><input type="button" class="printCardBtn" value="Re-print Card" id="reprintCardBtn" onclick="regenerateCard()"/><?php
    } else {
        ?>
        <input type="button" class="printCardBtn" value="Print Card" id="printCardBtn" onclick="generateCard()"/>
        <?php
    }

?>
</div>
<input type="hidden" id="dummycardvalue" value="<?php echo $model->card; ?>"/>
<script>
    $(document).ready(function() {
        if (<?php echo $model->visit_status; ?> == '1' && $("#dummycardvalue").val() == '' ) { //1 is active
            document.getElementById('printCardBtn').disabled = false;

        } else if(<?php echo $model->visit_status; ?> != '1' )  {
            document.getElementById('printCardBtn').disabled = true;
            $("#printCardBtn").addClass("disabledButton");
        }

    });

    function generateCard() {
        //$("#generateCardModalBtn").click();
        //change modal url to pass visit id
        var url = 'index.php?r=cardGenerated/print&id=<?php echo $model->id; ?>';
        window.open(url, '_blank');
        window.location = "index.php?r=visit/detail&id=<?php echo $_GET['id']; ?>";
    }

    function regenerateCard() {
        //$("#generateCardModalBtn").click();
        //change modal url to pass visit id
        var url = 'index.php?r=cardGenerated/reprint&id=<?php echo $model->id; ?>';
        window.open(url, '_blank');
    }


</script>

