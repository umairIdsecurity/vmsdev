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
interface CompanyService {
    //put your code here
    public function save($company, $sessionTenant, $sessionRole, $currentAction);
}
