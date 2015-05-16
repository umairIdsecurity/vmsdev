<?php
	
	class PropertyFileReader 
	{
		
		// Global		
		function getProperty($propertyName)
		{
			$ini_array = parse_ini_file("tests/config/application.properties");
			$propertyValue =  $ini_array[$propertyName];
			return $propertyValue; 
		}

		function getPageElement($pageElement)
		{
			$ini_array = parse_ini_file("tests/ref/locator.properties");
			$pageValue =  $ini_array[$pageElement];
			return $pageValue;
		}
	}

?>
