<?php

require_once 'StringTokenizer.php';

class TestDataReader
	{
		function getTestData($param, $pathData)
		{
			$ini_array = parse_ini_file($pathData);
			$propertyValue =  $ini_array[$param];
			return $propertyValue;
		}
		
		function setData($Data,$column)
		{
			$testDataReader  = new TestDataReader();
			$counter=0;
			$testDataItem = $testDataReader->getTestData($Data, $column);
			$st = new StringTokenizer($testDataItem, ",");
			while ($st->hasMoreTokens()) 
			{
				 $token = $st->nextToken();
				 if($counter==$column)
				 return $token;
				 $counter++;
			}	 
		}
	}
?>
