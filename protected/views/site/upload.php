<?php

$usernameHash =  hash('adler32',Yii::app()->user->name);
$controllerId = $_GET['id'];
switch ($controllerId) {
    case 'company':
        $folderKey = '/company_logo/';
        break;
    case 'profile':
        $folderKey = '/profile/';
        break;
    default:
        $folderKey = '';
        break;
}
$output_dir = Yii::getPathOfAlias('webroot')."/uploads". $folderKey;
$action = $_GET['actionId'];

if (isset($_FILES["myfile"])) {
    //$ret = array();

    $error = $_FILES["myfile"]["error"];
    if (!is_array($_FILES["myfile"]["name"])) { //single file
        $fileName = $_FILES["myfile"]["name"];
        $unique_fileName = $usernameHash.'-'.time() . ".jpg";
        $path = "uploads" . $folderKey . $unique_fileName;
        move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . $unique_fileName);
        //save in database
        $connection = Yii::app()->db;
        $command = $connection->createCommand('INSERT INTO `photo` '
                . '(`filename`, `unique_filename`, `relative_path`) VALUES ("' . $fileName . '","' . $unique_fileName . '","' . $path . '" )');
        $command->query();
        //update company
        if ($action == 'update') {
            $update = $connection->createCommand('update company set logo="' . Yii::app()->db->lastInsertID . '" where id="' . $_GET['companyId'] . '"');
            $update->query();
            $ret = $path;
        } else if ($action == 'create') {
            $ret = Yii::app()->db->lastInsertID;
        }
        
    }
//	else  //Multiple files, file[]
//	{
//	  $fileCount = count($_FILES["myfile"]["name"]);
//	  for($i=0; $i < $fileCount; $i++)
//	  {
//	  	$fileName = $_FILES["myfile"]["name"][$i];
//		move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
//	  	$ret[]= $fileName;
//	  }
//	
//	}
    echo $ret;
    //echo json_encode($ret);
}
?> 