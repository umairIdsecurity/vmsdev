<?php

//=======================================================================================
// File Name    : AGSuiteAll.php
// ClassName    : AGSuite
// Summary      : Contains All Selenium automation scripts for all Modules.
//=======================================================================================
// History      :   Company            Date            Action
//                  IntelliSqa                         Initial Version
//
//========================================================================================
// Remarks      :   Tests - Contains All Selenium automation scripts for all Modules.
//========================================================================================


require_once 'TestScripts/SuperAdminLogin.php';

class AGSuiteAll extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        $suite = new AGSuiteAll();				
		$suite->addTestSuite('SuperAdminLogin');
		return $suite;

    }
}
?> 
