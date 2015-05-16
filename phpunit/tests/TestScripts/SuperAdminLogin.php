<?php
require_once 'tests/util/IntelliSqaFramework.php';
class SuperAdminLogin extends IntelliSqaFramework
{
  public function setUp()
	{
		parent::setUp();		
	}
	
	public function tearDown()
	{
		parent::tearDown();
	}
	
  public function testSuperAdminLogin()
	{
		$propertyFileReader  = new PropertyFileReader();
		
		$this->windowMaximize();
		$this->open("");
		
		//Call LoginUsers function with valid credential
		parent::LoginUsers();	
		
		//Call Add Company function
		parent::addCompany();
		
		//Call Add User function
		parent::AddUser();
		
		//Call Add Administration function
		parent::addinAdministrationCompany();
		
		//Call Add Visitor features
		parent::Addvisitor();
		
		
	}
}
?>