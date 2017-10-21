<?php

$usernameHash = hash('adler32', Yii::app()->user->name);
$controllerId = $_GET['id'];
switch ($controllerId) {
    case 'company':
    case 'companyLafPreferences':
        //$folderKey = '/company_logo/';
        $folderKey = '/visitor/';
        break;
    case 'profile':
        //$folderKey = '/profile/';
        $folderKey = '/visitor/';
        break;
    case 'visitor':
    case 'visit':
	case 'user':
        $folderKey = '/visitor/';
        break;
    default:
        $folderKey = '/visitor/';
        break;
}
$output_dir = Yii::getPathOfAlias('webroot') . "/uploads" . $folderKey;
if (!file_exists($output_dir)) {
    mkdir($output_dir, 0777, true);
}
$action = $_GET['actionId'];

if (isset($_FILES["myfile"])) {
    //$ret = array();
    
    $error = $_FILES["myfile"]["error"];
    if (!is_array($_FILES["myfile"]["name"])) { //single file
        $fileName = $_FILES["myfile"]["name"];
        $uniqueFileName = $usernameHash . '-' . time() . ".jpg";
        $path = "uploads" . $folderKey . $uniqueFileName;

        //temporay uploaded -- will be deleted after saving in DB
        move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . $uniqueFileName);

        //save image in db as diretced by Geoff
        $uploadedFile = $output_dir.$uniqueFileName;
        $file=file_get_contents($uploadedFile);
        $image= base64_encode($file);
		
        $connection = Yii::app()->db;
        $command = $connection->createCommand('INSERT INTO photo '
                . "(filename, unique_filename, relative_path, db_image) VALUES ('" . $fileName . "','" . $uniqueFileName . "','" . $path . "','" . $image . "')");
        $command->query();
        //update company
        if ($action == 'update' && ($controllerId == 'visitor' || $controllerId == 'user') || ($controllerId=='induction') ) {
            $ret = Yii::app()->db->lastInsertID;
        } elseif ($action == 'update') {
            $update = $connection->createCommand("update company set logo=" . Yii::app()->db->lastInsertID . " where id=" . $_GET['companyId'] . "");
            $update->query();
            $ret = $path;
        } else if ($action == 'create' || $action == 'addvisitor' || $action == 'detail' || $action == 'customisation' || $action=='asicUpdate' || $action=='addInductee') {
            $ret = Yii::app()->db->lastInsertID;
        }

        //delete uploaded file from folder as inserted in DB -- directed by Geoff
        if (file_exists($uploadedFile)) {
            unlink($uploadedFile);
        }

    }
    echo $ret;
    //echo json_encode($ret);
}


if (isset($_FILES["myfile2"])) {
    //$ret = array();

    $error = $_FILES["myfile2"]["error"];
    if (!is_array($_FILES["myfile2"]["name"])) { //single file
        $fileName = $_FILES["myfile2"]["name"];
        $uniqueFileName = $usernameHash . '-' . time() . ".jpg";
        $path = "uploads" . $folderKey . $uniqueFileName;

        //temporay uploaded -- will be deleted after saving in DB
        move_uploaded_file($_FILES["myfile2"]["tmp_name"], $output_dir . $uniqueFileName);
        
        //save in database
        
        //save image in db as diretced by Geoff
        $uploadedFile = $output_dir.$uniqueFileName;
        $file=file_get_contents($uploadedFile);
        $image = base64_encode($file);
        
        $connection = Yii::app()->db;
        $command = $connection->createCommand('INSERT INTO photo '
            . "(filename, unique_filename, relative_path,  db_image) VALUES ('" . $fileName . "','" . $uniqueFileName . "','" . $path . "','" . $image . "')");
        $command->query();
        
        $ret = Yii::app()->db->lastInsertID;

        //delete uploaded file from folder as inserted in DB -- directed by Geoff
        if (file_exists($uploadedFile)) {
            unlink($uploadedFile);
        }
       
    }
    echo $ret;
    //echo json_encode($ret);
}
?> 