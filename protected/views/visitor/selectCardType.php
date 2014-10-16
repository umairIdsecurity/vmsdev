<input type="radio" value="<?php echo CardType::SAME_DAY_VISITOR; ?>" name="selectCardType" id="sameday" checked> Same Day Visitor</input>
<input type="radio" value="<?php echo CardType::MULTI_DAY_VISITOR; ?>" name="selectCardType" id="multiday"> Multi Day Visitor</input>
<br>
<br>
<button id="clicktabA">Continue</button>

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
        });

       
    });
</script>