
<div id="cardDiv" 
     style="background: url('../images/cardprint-new.png') no-repeat center top;">
    <div style="position: relative; padding-top:180px;padding-left:30px;">
        <table class="" style="width:100%;margin-left:100px;" id="cardDetailsTable">
            <tr>
                <td><?php echo CardType::$CARD_TYPE_LIST[$model->card_type]; ?></td>
            </tr>
            <tr>
                <td><?php echo $visitorModel->first_name . ' ' . $visitorModel->last_name ?></td>
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
                        echo date('d/m/Y');
                    } else {
                        echo Yii::app()->dateFormatter->format("d/MM/y", strtotime($model->date_out));
                    }
                    ?></td>
            </tr>
        </table>


    </div>
</div>
<?php
$cardDetail = CardGenerated::model()->findAllByAttributes(array(
    'visitor_id' => $model->visitor
        ));
if (count($cardDetail) > 0 && $model->visit_status == VisitStatus::ACTIVE) {
    ?><input type="button" class="printCardBtn" value="Re-print Card" id="reprintCardBtn" onclick="regenerateCard()"/><?php
} else {
    ?>
    <input type="button" class="printCardBtn" value="Print Card" id="printCardBtn" onclick="generateCard()"/>

    <?php
}
?>
<script>
    $(document).ready(function() {
        if (<?php echo $model->visit_status; ?> == '1') { //1 is active
            document.getElementById('printCardBtn').disabled = false;

        } else {
            document.getElementById('printCardBtn').disabled = true;
            $("#printCardBtn").addClass("disabledButton");
        }

    });

    function generateCard() {
        //$("#generateCardModalBtn").click();
        //change modal url to pass visit id
        var url = 'index.php?r=cardgenerated/print&id=<?php echo $model->id; ?>';
        $("#generateCardModalBody #generateCardModalIframe").html('<iframe id="generateCardTableIframe" scrolling="no" onLoad="resizeThis();" width="100%" height="100%" style="max-height:400px !important;" frameborder="0" src="' + url + '"></iframe>');
    }

    function resizeThis() {
        var newheight;

        if (document.getElementById) {
            newheight = document.getElementById('generateCardTableIframe').contentWindow.document.body.scrollHeight;
        }
        document.getElementById('generateCardTableIframe').height = (newheight - 60) + "px";
    }
</script>

<input type="button" id="generateCardModalBtn" value="findhost" data-target="#generateCardModal" data-toggle="modal" style="display:none;"/>
<div class="modal hide fade" id="generateCardModal" style="width:340px; margin-left:-170px;">
    <div class="modal-header">
        <span style="color: #78B800;margin-left:-190px;font-weight:bold;">Card Preview</span>
        <a data-dismiss="modal" class="close" id="dismissModal" >×</a>
        <br>
    </div>

</div>

<div id="generateCardModalBody" style="padding:20px;">

    <div id="generateCardModalIframe" style="overflow-x: hidden !important; overflow-y: auto !important;"></div>
</div>
