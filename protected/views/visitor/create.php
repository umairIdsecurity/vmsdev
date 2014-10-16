<?php
/* @var $this VisitorController */
/* @var $model Visitor */
?>

<h1>Register a Visitor</h1>
<dl class="tabs three-up">
    <dt id="selectCardA" style="display:none;">Select Card Type</dt>
    <dd class="active" id="selectCard"><a href="#step1" id="selectCardB">Select Card Type</a></dd>
    <dt id="findVisitorA">Find or Add New Visitor Record</dt>
    <dd style="display:none;" id="findVisitor"><a href="#step2" id="findVisitorB">Find or Add New Visitor Record</a></dd>
    <dt id="findHostA">Find or Add Host</dt>
    <dd style="display:none;" id="findHost"><a href="#step3" id="findHostB">Find or Add Host</a></dd>
</dl>


<ul class="tabs-content">
    <li class="active" id="stepTab">
        <?php $this->renderPartial('selectCardType', array('model' => $model)); ?>
        <input type="hidden" id="cardtype"/>
    </li>
    <li id="step2Tab">
        <?php $this->renderPartial('findAddVisitorRecord', array('model' => $model)); ?>
    </li>
    <li id="step3Tab">This is simple tab 3's content. It's, you know...okay. <button id="clicktabC">click me </button></li>
</ul>


<script>
    $(document).ready(function() {
        $("#clicktabA").click(function(e) {
            e.preventDefault();
            showHideTabs('findVisitorB', 'findVisitorA', 'findVisitor', 'selectCardA', 'selectCard', 'findHostA', 'findHost');
        });

        $("#clicktabB").click(function(e) {
            e.preventDefault();
            showHideTabs('findHostB', 'findHostA', 'findHost', 'findVisitorA', 'findVisitor', 'selectCardA', 'selectCard');
        });

        $("#clicktabC").click(function(e) {
            e.preventDefault();

            showHideTabs('selectCardB', 'selectCardA', 'selectCard', 'findVisitorA', 'findVisitor', 'findHostA', 'findHost');
        });

        $("#btnBackTab2").click(function(e) {
            e.preventDefault();
            showHideTabs('selectCardB', 'selectCardA', 'selectCard', 'findVisitorA', 'findVisitor', 'findHostA', 'findHost');
            hidePreviousPage('step2Tab', 'stepTab');
        });


        function showHideTabs(showThisId, hideThisId, showThisRow, hideOtherA, showOtherRowA, hideOtherB, showOtherRowB) {
            $("#" + showThisId).click();// findvisitorB dt
            $("#" + showThisId).show(); //findvisitorB dt
            $("#" + showThisRow).show(); //findVisitor dd
            $("#" + hideThisId).hide(); //findvisitor a dt

            $("#" + hideOtherA).show(); //selectcardtype dd
            $("#" + showOtherRowA).hide(); //selectcardtype dd

            $("#" + hideOtherB).show(); //selectcardtype dd
            $("#" + showOtherRowB).hide(); //selectcardtype dd
        }

        function hidePreviousPage(hideThisLiId, showThisLiId) {
            $("#" + hideThisLiId).hide();
            $("#" + showThisLiId).show();
        }
    });

    function closeAndPopulateField(id) {
        $("#dismissModal").click();
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/getVisitorDetails&id='); ?>' + id,
            dataType: 'json',
            data: id,
            success: function(r) {
                $('#User_company option[value!=""]').remove();

                $.each(r.data, function(index, value) {
                    $("#Visitor_first_name").val(value.first_name);
                    $("#Visitor_last_name").val(value.first_name);
                  
                });

            }
        });
    }
</script>