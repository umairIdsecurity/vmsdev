<?php
    $cards = CardType::model()->findAll();
    $btn = array();
    $i=1;
    foreach($cards as $card){
        $btn[$i] = ($card->back_text == NULL )?"":"btn-primary";
        $i++;
    } 

?>
<tr class='odd'><td width='180px'>Edit Card's Back Text</td><td><input value='edit'  class='edit_card_back <?php echo $btn[1]?>' type='button' name='Same Day Visitor' id='edit_1'><input value='edit'  class='edit_card_back <?php echo $btn[2]?>' type='button' name='Multiday Visitor' id='edit_2'><input value='edit'  class='edit_card_back <?php echo $btn[3]?>' type='button' name='Manual' id='edit_3'><input value='edit'  class='edit_card_back <?php echo $btn[4]?>' type='button' name='Contractor' id='edit_4'></td><td><input value='edit'  class='edit_card_back <?php echo $btn[5]?>' type='button' name='Same Day' id='edit_5'><input value='edit'  class='edit_card_back <?php echo $btn[6]?>' type='button' name='24 Hour' id='edit_6'><input value='edit'  class='edit_card_back <?php echo $btn[7]?>' type='button' name='Extended' id='edit_7'><input value='edit'  class='edit_card_back <?php echo $btn[8]?>' type='button' name='Multi Day' id='edit_8'></td><td class='button-column'></td></tr>