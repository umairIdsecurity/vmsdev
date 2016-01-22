<?php
    $cards = CardType::model()->findAll();
    $btn = array();
    $i=1;
    foreach($cards as $card){
        $btn[$i] = ($card->back_text == NULL )?"complete":"btn-primary";
        $i++;
    } 
    $module = CHelper::get_allowed_module();
?>
<!-- because of https://ids-jira.atlassian.net/browse/CAVMS-104-->
<tr class='odd'>\
    <td width='180px' class='ws-padding'>Edit Card's Back Text</td>\
    <?php 
        if(( $module == "CVMS" || $module == "Both") ) 
        {
    ?>
        <td><input value='edit'  class='edit_card_back corporate <?php echo $btn[1]?> greenBtn' type='button' name='Corporate Same Day Visitor' id='edit_1'><input value='edit'  class='edit_card_back corporate <?php echo $btn[2]?> greenBtn' type='button' name='Corporate Multiday Visitor' id='edit_2'><input value='edit'  class='edit_card_back corporate <?php echo $btn[3]?> greenBtn' type='button' name='Corporate Manual' id='edit_3'><input value='edit'  class='edit_card_back corporate <?php echo $btn[4]?> greenBtn' type='button' name='Corporate Contractor' id='edit_4'></td>\
    
    <?php
        }
        if(( $module == "AVMS" || $module == "Both") ) 
        {
    ?>
        <td><input value='edit'  class='edit_card_back corporate <?php echo $btn[5]?> greenBtn' type='button' name='VIC Same Day' id='edit_5'><input value='edit'  class='edit_card_back vc <?php echo $btn[6]?> greenBtn' type='button' name='VIC 24 Hour' id='edit_6'><input value='edit'  class='edit_card_back vc <?php echo $btn[7]?> greenBtn' type='button' name='VIC Extended' id='edit_7'><input value='edit'  class='edit_card_back vc <?php echo $btn[8]?> greenBtn' type='button' name='VIC Multi Day' id='edit_8'></td>\
    <?php
        } 
    ?>
    <td class='button-column'></td></tr>