<?php

// CDbCommand
Yii::import('ext.exportcsv.ECSVExport');


//// Active Records

$csv = new ECSVExport(Visit::model()->exportVisitorRecords());
$headers = array(
    'card' => 'Card',
    'first_name' => 'First Name',
    'last_name' => 'Last Name',
    'visitStatus' =>'Visit Status',
    'visitorStatus' =>'Visitor Status',
    'email' =>'Email Address',
    'contact_number' =>'Contact Number',
    'visitorType' =>'Visitor Type',
    'date_in' =>'Date of Visit',
    'time_in' =>'Time in',
    'CompanyName' =>'Company Name',
    );

$csv->setHeaders($headers);

$exclude = array('id', '');
$csv->setExclude($exclude);
$content = $csv->toCSV();
$date = date('d-m-Y');
Yii::app()->getRequest()->sendFile("visitorrecords" . $date . ".csv", $content, "text/csv", false);
exit();
