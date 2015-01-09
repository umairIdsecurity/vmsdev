<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Jeremiah
 */
interface CardGeneratedService {
    //put your code here
    public function save($cardGenerated,$visit, $user);
    public function updateCard($cardGenerated,$visit, $user);
  
}
