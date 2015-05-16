<?php

require_once 'tests/AGSuiteAll.php';
require_once 'tests/util/PropertyFileReader.php';


class IntelliSqaFramework extends PHPUnit_Extensions_SeleniumTestCase	{
	private $propertyFileReader;
	
	public function setUp()
	{
       //Object initialization.
		  $propertyFileReader  = new PropertyFileReader();

		  //Getting browser and url details
		  $Browser = $propertyFileReader->getProperty("BROWSER");
		  $Url = $propertyFileReader->getProperty("URL");  
		  $this->setBrowser($Browser);
		  $this->setBrowserUrl($Url);  
	}

	public function tearDown()
	{
		$this->stop();        
	}
	
	public function LoginUsers()
	{
		//Object initialization.		
		$propertyFileReader  = new PropertyFileReader();		
		$userName = $propertyFileReader->getProperty("Email");
		$password = $propertyFileReader->getProperty("Password");		
		$dashboard = $propertyFileReader->getProperty("Dashboard");		
		
		$this->type("id=LoginForm_username", $userName);
		$this->type("id=LoginForm_password", $password);		
		$this->click("//.//form[@id='login-form']/table/tbody/tr[5]/td/input");				
		IntelliSqaFramework::waitTillLocatorFound($dashboard);			
	}	
	
	public function waitTillLocatorFound($locator)
		 { 
		  //Object initialization
		  $custom = new IntelliSqaFramework();
		  $propertyFileReader  = new PropertyFileReader();		  		  
		  $status = true;				 
		  $while_loop_start_time = time();  // Get current Unix timestamp
		  $while_loop_timeout = 250;   // Timeout in seconds
		  while($status = true)  { 
		 
		   if($this->isElementPresent($locator))  {
			$this->assertTrue($this->isElementPresent($locator));    
			$status = false;
			break;
		   }
		   else{
			usleep(60);
		   }
		   if(time()>=($while_loop_start_time + $while_loop_timeout))
		   {
			echo "Warning! $locator not found";
			exit;
		   }
		  }
		}	

		public function AddUser()
		{
		$now = date("His");
		$this->click("link=Administration");
		$this->waitForElementPresent("css=a.has-sub-sub > span");
		$this->click("css=a.has-sub-sub > span");
		sleep(5);
		IntelliSqaFramework::waitTillLocatorFound("id=User_first_name"); 		
		$this->type("id=User_first_name", "test");
		$this->type("id=User_last_name", "user");
		$this->type("id=User_email", "testervikash.$now@gmail.com");
		$this->type("id=User_contact_number", "9998877554");
		$this->waitForElementPresent("id=User_department");
		$this->type("id=User_department", "it");
		$this->type("id=User_position", "tester");
		$this->type("id=User_staff_id", "001");
		$this->select("id=fromMonth", "label=Mar");
		$this->select("id=fromDay", "label=17");
		$this->select("id=fromYear", "label=2010");
		$this->type("id=User_password", "12345");
		$this->type("id=User_repeat_password", "12345");
		$this->select("id=User_role", "label=Administrator");
		$this->select("id=User_company", "label=Rofftest");
		$this->click("name=User[password_option]");	
		IntelliSqaFramework::waitTillLocatorFound("id=submitForm"); 
		//$this->click("id=submitForm");
		//IntelliSqaFramework::waitTillLocatorFound("css=h1");
		//sleep(10);
		}
		
		public function addCompany()
		{
		$this->click("link=Administration");
		IntelliSqaFramework::waitTillLocatorFound("id=yt13");
		$this->click("id=yt13");
		IntelliSqaFramework::waitTillLocatorFound("css=a.addSubMenu.ajaxLinkLi > span");
		$this->click("css=a.addSubMenu.ajaxLinkLi > span");
		//$this->click("link=Dashboard");
		//$this->waitForElementPresent("css=a.addcompanymenu > span");
		//$this->waitForElementPresent("css=h1");
		//$this->click("css=a.addcompanymenu > span");
		IntelliSqaFramework::waitTillLocatorFound("id=Company_name");
		//$this->waitForElementPresent("id=Company_name");
		$this->type("id=Company_name", "Rofftest");
        $this->type("id=Company_code", "tes");
		$this->click("id=userDetails");
		$this->waitForElementPresent("id=Company_user_details");
		$this->type("id=Company_user_details", "Test Person");
		$this->type("id=Company_user_first_name", "testuser");
		$this->type("id=Company_user_last_name", "tester");
		$this->type("id=Company_user_email","test@test.com");
		$this->type("id=Company_user_contact_number", "9998877554");
		//$this->waitForElementPresent("id=createBtn");
        //$this->clickAndWait("id=createBtn");
        //sleep(3);
		}
		
		public function addinAdministrationCompany() 
		{
        $now = date("His");
		//$this->click("link=Administration");
		//IntelliSqaFramework::waitTillLocatorFound("css=li.submenu.addSubMenu > a > span");
		$this->click("css=li.submenu.addSubMenu > a > span");
		sleep(10);
		IntelliSqaFramework::waitTillLocatorFound("id=User_user_type");
		$this->select("id=User_user_type", "label=Internal");
		$this->type("id=User_first_name", "tester");
		$this->type("id=User_last_name", "tester1");
		$this->type("id=User_email", "testervikash.$now@gmail.com");
		$this->type("id=User_contact_number", "99988774455");
		$this->select("id=User_company", "label=Rofftest");
		$this->type("id=User_department", "Development");
		$this->type("id=User_position", "developer");
		$this->type("id=User_staff_id", "110");
		$this->select("id=fromMonth", "label=Jul");
		$this->select("id=fromDay", "label=20");
		$this->select("id=fromYear", "label=2010");
		$this->type("id=User_password", "12345");
		$this->type("id=User_repeat_password", "12345");
		$this->click("name=User[password_option]");	
		IntelliSqaFramework::waitTillLocatorFound("id=submitForm"); 
		//$this->click("id=submitForm");
		//IntelliSqaFramework::waitTillLocatorFound("css=h1");
		//sleep(10);
		}
		public function Addvisitor() 
		{
		//$this->click("link=Administration");
		IntelliSqaFramework::waitTillLocatorFound("link=Visitors"); 
		$now = date("His");
		$this->click("link=Visitors");
		sleep(10);
		IntelliSqaFramework::waitTillLocatorFound("//div[@id='cssmenu']/ul/li[4]/ul/li/a/span"); 
		$this->click("//div[@id='cssmenu']/ul/li[4]/ul/li/a/span");
		sleep(5);
		IntelliSqaFramework::waitTillLocatorFound("id=Visitor_tenant");		
		$this->select("id=Visitor_tenant", "label=Rofftest");
		$this->type("id=Visitor_first_name", "tester");
		$this->type("id=Visitor_last_name", "test");
		$this->type("id=Visitor_email", "teste@gmail.com");
		$this->type("id=Visitor_contact_number", "9998877554");
		$this->click("id=Visitor_password_requirement_0");
		//$this->click("id=submitFormVisitor");
		}
		}
?>
