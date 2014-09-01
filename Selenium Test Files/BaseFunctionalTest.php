<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * This base functional test is an 
 *
 * @author jeremiah
 */
class BaseFunctionalTest extends WebTestCase {
    protected function setUp() {
        parent::setUp();
    }
    
   
    public function __destruct() {
        parent::__destruct();
    }

    function login($username = NULL,$password = NULL){
        $this->open("http://localhost/vms");
        $this->click("link=Login");
        $this->waitForPageToLoad("30000");
        $this->type("id=LoginForm_username", $username);
        $this->type("id=LoginForm_password", $password);
        $this->click("name=yt0");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        
    }
   
}
