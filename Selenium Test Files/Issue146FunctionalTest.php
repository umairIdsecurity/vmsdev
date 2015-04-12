<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue146FunctionalTest
 * @author WangFu
 */
class Issue146FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
		$this->setBrowser("chrome");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
		$this->Scenario4();
		$this->Scenario5();
    }
	
	/* Scenario 1 – Log in as admin  then go to Administration Tab
      Expected Behavior:
	  show Manage company on left Sidebar.

     */

    function Scenario1() {
        $username = 'Admin@perthairport.com.au';
        $this->login($username, '12345');
        $this->click("id=Manage_company");
        $this->select("id=user", "label=admin_menu");
		$this->open("http://dev.identitysecurity.info/index.php?r=user/admin");
		if ($session['role'] == Roles::ROLE_ADMIN) {
			$this->type("id=comany", "create");
			$this->type("id=CompanyLafPreferences", "customisation");
		}
        
    }

    /* Scenario 2 – Log in as admin  then go to Administration Tab
      Expected Behavior:
	  Remove company code area.

     */

    function Scenario2() {
        $username = 'Admin@perthairport.com.au';
        $this->login($username, '12345');
        $this->click("id=Manage_company");
        $this->select("id=add_company", "label=Add company");
		$this->open("http://dev.identitysecurity.info/index.php?r=company/admin");
		$this->form("id=company_form");
		if ($session['role'] != Roles::ROLE_ADMIN) {
			$this->type("id=comany", "code");
		}
        
    }
	
	/* Scenario 3 – Log in as admin  then go to Administration Tab
      Expected Behavior:
	  After adding company it shows Company code required.

     */

    function Scenario3() {
        $username = 'Admin@perthairport.com.au';
        $this->login($username, '12345');
        $this->click("id=Manage_company");
        $this->select("id=add_company", "label=Add company");
		$this->open("http://dev.identitysecurity.info/index.php?r=company/admin");
		$this->model("id=company");
		if($this->userRole == 1){
			return array(
	            array('name', 'required'),
	            array('code', 'length', 'min' => 3, 'max' => 3, 'tooShort' => 'Code is too short (Should be in 3 characters)'),
	            array('email_address', 'email'),
	            array('website', 'url'),
	            array('office_number, mobile_number, created_by_user, created_by_visitor', 'numerical', 'integerOnly' => true),
	            array('name, trading_name, billing_address', 'length', 'max' => 150),
	            array('email_address, website', 'length', 'max' => 50),
	            array('contact', 'length', 'max' => 100),
	            array('tenant', 'length', 'max' => 100),
	            array('logo,is_deleted,company_laf_preferences', 'safe'),
	            array('tenant, tenant_agent,logo,card_count', 'default', 'setOnEmpty' => true, 'value' => null),
	            array('id,isTenant,card_count, name,code,company_laf_preferences, trading_name, logo,tenant, contact, billing_address, email_address, office_number, mobile_number, website, created_by_user, created_by_visitor', 'safe', 'on' => 'search'),
	        );
		}
		
		$this->controller("id=company", "action=accessRules");
		$this->type("id=actions", "array='admin', 'adminAjax', 'delete'");
		$this->type("id=UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION");
        
    }
	
	/* Scenario 4 – Log in as admin  then go to Administration Tab
      Expected Behavior:
	  After Edditing company it shows "You are not authorized to perform this action.".

     */

    function Scenario4() {
        $username = 'Admin@perthairport.com.au';
        $this->login($username, '12345');
        $this->click("id=Manage_company");
        $this->select("id=Edit_company", "label=Edit company");
		$this->open("http://dev.identitysecurity.info/index.php?r=company/update&id=31");
		
		$this->controller("id=company", "action=accessRules");
		$this->type("id=actions", "update");
		$this->type("id=UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION");
        
    }
	
	/* Scenario 5 – Log in as admin  then go to Administration Tab
      Expected Behavior:
	  After Edditing company and click save button it shows company code required.

     */

    function Scenario5() {
        $username = 'Admin@perthairport.com.au';
        $this->login($username, '12345');
        $this->click("id=Manage_company");
        $this->select("id=Edit_company", "label=Edit company");
		$this->open("http://dev.identitysecurity.info/index.php?r=company/update&id=31");
		
		$this->controller("id=company", "action=update");
		if (isset($_POST['user_role'])) {
			$this->model->userRole = $_POST['user_role'] ;
		}
        
    }
    
}

?>