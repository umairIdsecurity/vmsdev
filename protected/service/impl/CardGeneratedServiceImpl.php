<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CardGeneratedServiceImpl
 *
 * @author Jeremiah
 */
class CardGeneratedServiceImpl implements CardGeneratedService {

    public function save($cardGenerated, $visit, $user) {

        if ($visit->card_type == CardType::MULTI_DAY_VISITOR) {
            $cardGenerated->date_expiration = $visit->date_out;
        }

        return true;
    }

    public function updateCard($cardGenerated, $visit, $user) {

    }
    
    

   

}
