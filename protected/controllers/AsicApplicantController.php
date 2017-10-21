<?php

class AsicApplicantController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('listApplicants','lodgedApplicants','deniedApplicants','isCompleted','makeIncompleted','approvedApplicants','delete','asicUpdate','asicAddressUpdate','asicAddressDelete','exportAuscheck','asicProcess','asicView'),
				'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION)',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
public function actionListApplicants()
{
	
	$model=new RegistrationAsic();
	 $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationAsic'])) {
		if(isset($_GET['RegistrationAsic']['date_of_birth']) && $_GET['RegistrationAsic']['date_of_birth']!='' )
		{
			$date=str_replace('/', '-',$_GET['RegistrationAsic']['date_of_birth']);
			$_GET['RegistrationAsic']['date_of_birth']=date('Y-m-d',strtotime($date));
		}
		if(isset($_GET['RegistrationAsic']['created_on']) && $_GET['RegistrationAsic']['created_on']!='' )
		{
			$date=str_replace('/', '-',$_GET['RegistrationAsic']['created_on']);
			$_GET['RegistrationAsic']['created_on']=date('Y-m-d',strtotime($date));
		}
		if(isset($_GET['RegistrationAsic']['company_id']) && $_GET['RegistrationAsic']['company_id']!='' )
		{
			
			$company=Company::model()->findByAttributes(array('name'=>$_GET['RegistrationAsic']['company_id']));
			
			$_GET['RegistrationAsic']['company_id']=$company->id;
		}
        $model->attributes = $_GET['RegistrationAsic'];
        }
    $this->render('listapplicants', array(
            'model' => $model, false, true));
}
public function actionLodgedApplicants()
{
	$tenant=Yii::app()->user->tenant;
	$model=new RegistrationAsic();
	$uploadFile=new ImportCsvForm;
	 $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationAsic'])) {
		if(isset($_GET['RegistrationAsic']['date_of_birth']) && $_GET['RegistrationAsic']['date_of_birth']!='' )
		{
			$date=str_replace('/', '-',$_GET['RegistrationAsic']['date_of_birth']);
			$_GET['RegistrationAsic']['date_of_birth']=date('Y-m-d',strtotime($date));
		}
		if(isset($_GET['RegistrationAsic']['created_on']) && $_GET['RegistrationAsic']['created_on']!='' )
		{
			$date=str_replace('/', '-',$_GET['RegistrationAsic']['created_on']);
			$_GET['RegistrationAsic']['created_on']=date('Y-m-d',strtotime($date));
		}
		if(isset($_GET['RegistrationAsic']['company_id']) && $_GET['RegistrationAsic']['company_id']!='' )
		{
			
			$company=Company::model()->findByAttributes(array('name'=>$_GET['RegistrationAsic']['company_id']));
			
			$_GET['RegistrationAsic']['company_id']=$company->id;
		}
        $model->attributes = $_GET['RegistrationAsic'];
        }
		if(isset($_POST['ImportCsvForm']))
		{
			//echo 'here';
			//Yii::app()->end();
			 $uploadFile->attributes=$_POST['ImportCsvForm'];
				
                if($uploadFile->validate())
                {   
					if(CUploadedFile::getInstance($uploadFile,'file')!='')
					$csvFile = CUploadedFile::getInstance($uploadFile,'file');  
					elseif (CUploadedFile::getInstance($uploadFile,'file1')!='')
					$csvFile=  CUploadedFile::getInstance($uploadFile,'file1');
					//Yii::app()->end();
                    $tempLoc = $csvFile->getTempName();
					$handle = fopen($tempLoc, "r");
					//print_r($csvFile->tempName);
					//Yii::app()->end();
                    //$handle = fopen($tempLoc, "r");
					$objPHPExcel = Yii::app()->excel;
					//$objReader = $objPHPExcel->readExcel2007();
					$objPHPExcel = PHPExcel_IOFactory::load($csvFile->tempName);
					$objWorksheet = $objPHPExcel->getActiveSheet()->getHighestRow();
                    $i = 0; 
					$duplicates = false;
					//$line=fgetcsv($handle,2000);
                   set_time_limit (0);
					
                    while( $i<$objWorksheet )
                    {  
						 $i = $i + 1;
                        if($i == 1) {
							//$i=0;
                           continue;
                        }
					
						//echo 
						//Yii::app()->end();
						if($i>1)
						{
							if($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, 1)->getValue()=='Client Reference')
							{
								$is_exist=$model->exists('id='.$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $i)->getValue().'');
								if($is_exist)
								{
									$model=$model->findByPk($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $i)->getValue());
									$model->is_logged=1;
								
									$model->save(false);	
									$airportName=new Company();
									$airport=$airportName->findByPk($model->tenant)->name;
									$contact=$airportName->findByPk($model->tenant)->office_number;
									 $templateParams = array(
										'email' => $model->email,
										'Airport'=>$airport,
										'contact'=>$contact,
										'name'=>  ucfirst($model->first_name) . ' ' . ucfirst($model->last_name),
										);
										$subject='ASIC Application Lodged '.ucfirst($model->first_name) . ' ' . ucfirst($model->last_name);
									$emailTransport = new EmailTransport();
									$emailTransport->sendLodged($templateParams, $model->email, $model->first_name . ' ' . $model->last_name,$subject);
								}
							}
							if($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, 1)->getValue()=='Decision')
							{
								
								$is_exist=$model->exists('id='.$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue().'');
							if($is_exist)
							{
								$model=$model->findByPk($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
								if($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $i)->getValue()=='Eligible')
								{
									$model->is_eligible=1;
									$visitor = Visitor::model()->find(" ( first_name = '{$model->first_name}' AND last_name = '{$model->last_name}' AND date_of_birth = '{$model->date_of_birth}' AND profile_type='VIC' AND tenant='{$tenant}' )");
										if($visitor)
										{	
											$visitor->visitor_card_status='3';
											$visitor->save(false);
											$this->closeAsicPendingAndReset($visitor);
										}
									$asicVisitor=Visitor::model()->find("first_name = '{$model->first_name}' AND last_name = '{$model->last_name}' AND profile_type='ASIC' AND tenant='{$tenant}'");
										if($asicVisitor && $model->application_type=='Renew')
										{
											$asicVisitor->visitor_card_status='3';
											$asicVisitor->profile_type='VIC';
											$asicVisitor->save(false);
										}
									
								}
								else if ($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $i)->getValue()!='Eligible')
								{
								$model->is_eligible=0;
								}
								
							
								$model->save(false);
									
							}
								
							}
						
						}
					}
					//Yii::app()->end();
					 $this->redirect(array("asicApplicant/lodgedApplicants"));
				}
			
		}
    $this->render('loggedapplicants', array(
            'model' => $model,'uploadFile'=>$uploadFile, false, true));
}
public function actionApprovedApplicants()
{
	 $session = new CHttpSession;
	$model=new RegistrationAsic();
	$uploadFile=new ImportCsvForm;
	$visitorModel=new Visitor();
	$asicinfo= new AsicInfo();
	 $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationAsic'])) {
		if(isset($_GET['RegistrationAsic']['date_of_birth']) && $_GET['RegistrationAsic']['date_of_birth']!='' )
		{
			$date=str_replace('/', '-',$_GET['RegistrationAsic']['date_of_birth']);
			$_GET['RegistrationAsic']['date_of_birth']=date('Y-m-d',strtotime($date));
		}
		if(isset($_GET['RegistrationAsic']['created_on']) && $_GET['RegistrationAsic']['created_on']!='' )
		{
			$date=str_replace('/', '-',$_GET['RegistrationAsic']['created_on']);
			$_GET['RegistrationAsic']['created_on']=date('Y-m-d',strtotime($date));
		}
		if(isset($_GET['RegistrationAsic']['company_id']) && $_GET['RegistrationAsic']['company_id']!='' )
		{
			
			$company=Company::model()->findByAttributes(array('name'=>$_GET['RegistrationAsic']['company_id']));
			
			$_GET['RegistrationAsic']['company_id']=$company->id;
		}
        $model->attributes = $_GET['RegistrationAsic'];
        }
		if(isset($_POST['ImportCsvForm']))
		{
			//echo 'here';
			//Yii::app()->end();
			 $uploadFile->attributes=$_POST['ImportCsvForm'];
				
                if($uploadFile->validate())
                {   
					$csvFile = CUploadedFile::getInstance($uploadFile,'file');  
					
                    $tempLoc = $csvFile->getTempName();
					$handle = fopen($tempLoc, "r");
					//print_r($csvFile->tempName);
					//Yii::app()->end();
                    //$handle = fopen($tempLoc, "r");
					$objPHPExcel = Yii::app()->excel;
					//$objReader = $objPHPExcel->readExcel2007();
					$objPHPExcel = PHPExcel_IOFactory::load($csvFile->tempName);
					$objWorksheet = $objPHPExcel->getActiveSheet()->getHighestRow();
                    $i = 0; 
					$duplicates = false;
					//$line=fgetcsv($handle,2000);
                   set_time_limit (0);
					
                    while( $i<$objWorksheet )
                    {  
						 $i = $i + 1;
                        if($i == 1) {
							//$i=0;
                           continue;
                        }
					
						//echo 
						//Yii::app()->end();
						if($i>1)
						{
						$is_exist=$model->exists('id='.$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue().'');
						if($is_exist)
						{
							$model=$model->findByPk($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $i)->getValue());
							if($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $i)->getValue()=='Approved')
							{
							$model->is_approved=1;
							if($model->save(false))
							{
									
							$tenant=Yii::app()->user->tenant;
							$visitor = Visitor::model()->find(" ( first_name = '{$model->first_name}' AND last_name = '{$model->last_name}' AND date_of_birth = '{$model->date_of_birth}' AND profile_type='VIC' AND tenant='{$tenant}' )");
								
							if($visitor)
								{
									$visitor->first_name=$model->first_name;
									$visitor->middle_name=$model->given_name2;
									$visitor->last_name=$model->last_name;
									$visitor->email=$model->email;
									if($model->photo!='')
										$visitor->photo=$model->photo;
									if($model->mobile_phone!='')
									$visitor->contact_number=$model->mobile_phone;
									else if ($model->work_phone!='')
									$visitor->contact_number=$model->work_phone;
									else
									$visitor->contact_number=$model->home_phone;	
									$visitor->date_of_birth=$model->date_of_birth;	
									$visitor->company=$model->company_id;
									$visitor->staff_id=$model->company_contact;
									$visitor->notes='From ASIC Application';
									$visitor->role='9';
									$visitor->visitor_status='1';
									$visitor->created_by=Yii::app()->user->id;
									$visitor->tenant=$model->tenant;
									$visitor->visitor_card_status='7';
									$asicexist=$asicinfo->exists("asic_applicant_id='".$model->id."'");
									if($asicexist)
									$asicinfo=$asicinfo->find("asic_applicant_id='".$model->id."'");
									if($asicinfo->card_number!='' || $asicinfo->card_number!=null)
									$visitor->asic_no=$asicinfo->card_number;	
									$visitor->visitor_workstation=$session['workstation'];
									$visitor->profile_type='VIC';
									$visitor->identification_type=$model->secondary_id;
									$visitor->identification_country_issued=$model->country_id2;
									$visitor->identification_document_no=$model->secondary_id_no;
									$visitor->identification_document_expiry=$model->secondary_id_expiry;
									$visitor->contact_unit=$model->unit;
									$visitor->contact_street_no=$model->street_number;
									$visitor->contact_street_name=$model->street_name;
									$visitor->contact_street_type=$model->street_type;
									$visitor->contact_suburb=$model->suburb;
									$visitor->contact_state=$model->state;
									$visitor->contact_country=$model->country;
									$visitor->contact_postcode=$model->postcode;
									$visitor->date_created=date('Y-m-d');
									$visitor->save(false);
								}
							else if (!$visitor)
							{
								$asicVisitor=Visitor::model()->find("first_name = '{$model->first_name}' AND last_name = '{$model->last_name}' AND profile_type='ASIC' AND tenant='{$tenant}'");
								if($asicVisitor)
								{
									$asicVisitor->first_name=$model->first_name;
									$asicVisitor->middle_name=$model->given_name2;
									$asicVisitor->last_name=$model->last_name;
									$asicVisitor->email=$model->email;
									if($model->photo!='')
										$asicVisitor->photo=$model->photo;
									if($model->mobile_phone!='')
									$asicVisitor->contact_number=$model->mobile_phone;
									else if ($model->work_phone!='')
									$asicVisitor->contact_number=$model->work_phone;
									else
									$asicVisitor->contact_number=$model->home_phone;	
									$asicVisitor->date_of_birth=$model->date_of_birth;	
									$asicVisitor->company=$model->company_id;
									$asicVisitor->staff_id=$model->company_contact;
									$asicVisitor->notes='From ASIC Application';
									$asicVisitor->role='9';
									$asicexist=$asicinfo->exists("asic_applicant_id='".$model->id."'");
									if($asicexist)
									$asicinfo=$asicinfo->find("asic_applicant_id='".$model->id."'");
									if($asicinfo->card_number!='' || $asicinfo->card_number!=null)
									$asicVisitor->asic_no=$asicinfo->card_number;	
									$asicVisitor->identification_type=$model->primary_id;
									$asicVisitor->identification_country_issued=$model->country_id1;
									$asicVisitor->identification_document_no=$model->primary_id_no;
									$asicVisitor->identification_document_expiry=$model->primary_id_expiry;
									$asicVisitor->contact_unit=$model->unit;
									$asicVisitor->contact_street_no=$model->street_number;
									$asicVisitor->contact_street_name=$model->street_name;
									$asicVisitor->contact_street_type=$model->street_type;
									$asicVisitor->contact_suburb=$model->suburb;
									$asicVisitor->contact_state=$model->state;
									$asicVisitor->contact_country=$model->country;
									$asicVisitor->contact_postcode=$model->postcode;
									$asicVisitor->save(false);
								}
								else{
									$visitorModel->first_name=$model->first_name;
									$visitorModel->middle_name=$model->given_name2;
									$visitorModel->last_name=$model->last_name;
									$visitorModel->email=$model->email;
									if($model->photo!='')
									$visitorModel->photo=$model->photo;
									if($model->mobile_phone!='')
									$visitorModel->contact_number=$model->mobile_phone;
									else if ($model->work_phone!='')
									$visitorModel->contact_number=$model->work_phone;
									else
									$visitorModel->contact_number=$model->home_phone;	
									$visitorModel->date_of_birth=$model->date_of_birth;	
									$visitorModel->company=$model->company_id;
									$visitorModel->staff_id=$model->company_contact;
									$visitorModel->notes='From ASIC Application';
									$visitorModel->role='9';
									$visitorModel->visitor_status='1';
									$visitorModel->created_by=Yii::app()->user->id;
									$visitorModel->tenant=$model->tenant;
									$visitorModel->visitor_card_status='7';
									$asicexist=$asicinfo->exists("asic_applicant_id='".$model->id."'");
									if($asicexist)
									$asicinfo=$asicinfo->find("asic_applicant_id='".$model->id."'");
									
									if($asicinfo->card_number!='' || $asicinfo->card_number!=null)
									$visitorModel->asic_no=$asicinfo->card_number;
									$visitorModel->visitor_workstation=$session['workstation'];
									$visitorModel->profile_type='VIC';
									$visitorModel->identification_type=$model->primary_id;
									$visitorModel->identification_country_issued=$model->country_id1;
									$visitorModel->identification_document_no=$model->primary_id_no;
									$visitorModel->identification_document_expiry=$model->primary_id_expiry;
									$visitorModel->contact_unit=$model->unit;
									$visitorModel->contact_street_no=$model->street_number;
									$visitorModel->contact_street_name=$model->street_name;
									$visitorModel->contact_street_type=$model->street_type;
									$visitorModel->contact_suburb=$model->suburb;
									$visitorModel->contact_state=$model->state;
									$visitorModel->contact_country=$model->country;
									$visitorModel->contact_postcode=$model->postcode;
									$visitorModel->date_created=date('Y-m-d');
									$visitorModel->save(false);
								}
									
							}
									$airportName=new Company();
									$airport=$airportName->findByPk($model->tenant)->name;
									$contact=$airportName->findByPk($model->tenant)->office_number;
									 $templateParams = array(
										'email' => $model->email,
										'Airport'=>$airport,
										'contact'=>$contact,
										'name'=>  ucfirst($model->first_name) . ' ' . ucfirst($model->last_name),
										);
										$subject='ASIC Application Approved '.ucfirst($model->first_name) . ' ' . ucfirst($model->last_name);
									$emailTransport = new EmailTransport();
									$emailTransport->sendApproved($templateParams, $model->email, $model->first_name . ' ' . $model->last_name,$subject);
							}
						}
							/*echo "<pre>";
							print_r($model->is_logged);
							echo "</pre>";
							Yii::app()->end();*/
						}
						}
					}
					
					//Yii::app()->end();
					 $this->redirect(array("asicApplicant/approvedApplicants"));
				}
			
		}
    $this->render('approvedapplicants', array(
            'model' => $model,'uploadFile'=>$uploadFile, false, true));
}
public function actionDeniedApplicants()
{
	
	$model=new RegistrationAsic();
	 $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationAsic'])) {
		if(isset($_GET['RegistrationAsic']['date_of_birth']) && $_GET['RegistrationAsic']['date_of_birth']!='' )
		{
			$date=str_replace('/', '-',$_GET['RegistrationAsic']['date_of_birth']);
			$_GET['RegistrationAsic']['date_of_birth']=date('Y-m-d',strtotime($date));
		}
		if(isset($_GET['RegistrationAsic']['created_on']) && $_GET['RegistrationAsic']['created_on']!='' )
		{
			$date=str_replace('/', '-',$_GET['RegistrationAsic']['created_on']);
			$_GET['RegistrationAsic']['created_on']=date('Y-m-d',strtotime($date));
		}
		if(isset($_GET['RegistrationAsic']['company_id']) && $_GET['RegistrationAsic']['company_id']!='' )
		{
			
			$company=Company::model()->findByAttributes(array('name'=>$_GET['RegistrationAsic']['company_id']));
			
			$_GET['RegistrationAsic']['company_id']=$company->id;
		}
        $model->attributes = $_GET['RegistrationAsic'];
        }
    $this->render('deniedapplicants', array(
            'model' => $model, false, true));
}

public function actionDelete($id)
{
 if(Yii::app()->request->isPostRequest)
{
	//echo $id;
	$addressHistory=new AsicAddressHistory();
	$immi=new Immigration();
	$asicinfo=new AsicInfo();
	$asic=new RegistrationAsic();
	$exist=$addressHistory->exists('asic_applicant_id='.$id.'');
	if($exist)
	$addressHistory->deleteAll("asic_applicant_id='".$id."'");
	$exist=$immi->exists('asic_applicant_id='.$id.'');
	if($exist)
	$immi->deleteAll("asic_applicant_id='".$id."'");	
	$exist=$asicinfo->exists("asic_applicant_id='".$id."'");
	if($exist)
	$asicinfo->deleteAll("asic_applicant_id='".$id."'");
	$asic->deleteAll("id='".$id."'");
	$exist=$asic->exists("id='".$id."'");
	if($exist)
	 echo "false";
	else
	echo "true";
}	
}
public function actionAsicUpdate($id) {   
                        
        $model= new RegistrationAsic();
		$model=$model->findByPk($id);
		$modelHistory= new AsicAddressHistory();
		$modelAsicInfo=new AsicInfo();
		$exist=$modelAsicInfo->exists('asic_applicant_id='.$id.'');
		if($exist)
		$modelAsicInfo=$modelAsicInfo->find('asic_applicant_id='.$id);
		$exist=$modelHistory->exists('asic_applicant_id='.$id.'');
		if($exist)
		$addHistory=$modelHistory->findAll('asic_applicant_id='.$id);
		else
		$addHistory='';
		if($model->company_id!='')
		$companyName=Company::model()->findByPk($model->company_id);
		else
		$companyName='Company not mentioned';
		if($model->company_contact!='')
		$companyContact=User::model()->findByPk($model->company_contact);
		else
		$companyContact='Contact not mentioned';
		$immiModel=new Immigration();	
		$exist=$immiModel->exists('asic_applicant_id='.$id.'');
		if($exist)
		$immiModel=$immiModel->find('asic_applicant_id='.$id);
	
        $session= new CHttpSession;
		if(Yii::app()->request->isAjaxRequest)
		{
			if(isset($_GET['idAdd']))
			{
				$modelHistory=$modelHistory->findByPk($_GET['idAdd']);
				echo CJSON::encode($modelHistory);
			}
			Yii::app()->end();
		}
		if(isset($_POST['RegistrationAsic']) && !isset($_POST['AsicInfo']) && !isset($_POST['Immigration']))
		{
			

			$upload_1=$model->upload_1;
			$upload_2=$model->upload_2;
			$upload_3=$model->upload_3;
			$upload_4=$model->upload_4;
			$name_change_file=$model->name_change_file;
			$model->attributes=$_POST['RegistrationAsic'];
			if(isset($_POST['RegistrationAsic']['date_of_birth']))
			$model->date_of_birth=date('Y-m-d',strtotime($_POST['RegistrationAsic']['date_of_birth']));
			if(isset($_POST['RegistrationAsic']['from_date']))
			$model->from_date=date('Y-m-d',strtotime($_POST['RegistrationAsic']['from_date']));
			if(isset($_POST['RegistrationAsic']['photo']) && $_POST['RegistrationAsic']['photo']!='')
			{
			$model->photo=$_POST['RegistrationAsic']['photo'];
			}
			
			if(isset($_FILES['RegistrationAsic']['name']['upload_1']) && $_FILES['RegistrationAsic']['name']['upload_1']!='')
			$model->upload_1=$_FILES['RegistrationAsic']['name']['upload_1'];
			else
			$model->upload_1=$upload_1;
			if(isset($_FILES['RegistrationAsic']['name']['upload_2']) && $_FILES['RegistrationAsic']['name']['upload_2']!='')
			$model->upload_2=$_FILES['RegistrationAsic']['name']['upload_2'];
			else
			$model->upload_2=$upload_2;
			if(isset($_FILES['RegistrationAsic']['name']['upload_3']) && $_FILES['RegistrationAsic']['name']['upload_3']!='')
			$model->upload_3=$_FILES['RegistrationAsic']['name']['upload_3'];
			else
			$model->upload_3=$upload_3;
			if(isset($_FILES['RegistrationAsic']['name']['upload_4']) && $_FILES['RegistrationAsic']['name']['upload_4']!='')
			$model->upload_4=$_FILES['RegistrationAsic']['name']['upload_4'];
			else
			$model->upload_4=$upload_4;
			if(isset($_FILES['RegistrationAsic']['name']['name_change_file']) && $_FILES['RegistrationAsic']['name']['name_change_file']!='')
			$model->name_change_file=$_FILES['RegistrationAsic']['name']['name_change_file'];
			else
			$model->name_change_file=$name_change_file;
			
			$target_dir= Yii::getPathOfAlias('webroot').'/uploads/files/asic_uploads/';
			if(isset($_FILES['RegistrationAsic']['name']['name_change_file']))
				{
				
				$model->name_change_file=$_FILES['RegistrationAsic']['name']['name_change_file'];
				$target_dir= Yii::getPathOfAlias('webroot').'/uploads/files/asic_uploads/';
				if($_FILES['RegistrationAsic']['name']['name_change_file']!='')
				{
					$file = $_FILES['RegistrationAsic']['name']['name_change_file'];
					$path = pathinfo($file);
					$filename = $path['filename'];
					$ext = $path['extension'];
					$temp_name = $_FILES['RegistrationAsic']['tmp_name']['name_change_file'];
					$path_filename_ext = $target_dir.$filename.".".$ext;
					if (file_exists($path_filename_ext)) {
						$path_filename_ext = $target_dir.$filename."_copy".".".$ext;
						move_uploaded_file($temp_name,$path_filename_ext);
						}
					else{
						move_uploaded_file($temp_name,$path_filename_ext); 
						}

				}
				}
				if(isset($_FILES['RegistrationAsic']['name']['upload_1']) && $_FILES['RegistrationAsic']['name']['upload_1']!='')
				{
					$file = $_FILES['RegistrationAsic']['name']['upload_1'];
					$path = pathinfo($file);
					$filename = $path['filename'];
					$ext = $path['extension'];
					$temp_name = $_FILES['RegistrationAsic']['tmp_name']['upload_1'];
					$path_filename_ext = $target_dir.$filename.".".$ext;
					if (file_exists($path_filename_ext)) {
						$path_filename_ext = $target_dir.$filename."_copy".".".$ext;
						move_uploaded_file($temp_name,$path_filename_ext);
						}
					else{
						move_uploaded_file($temp_name,$path_filename_ext); 
						}

				}
				if(isset($_FILES['RegistrationAsic']['name']['upload_2']) && $_FILES['RegistrationAsic']['name']['upload_2']!='')
				{
					$file = $_FILES['RegistrationAsic']['name']['upload_2'];
					$path = pathinfo($file);
					$filename = $path['filename'];
					$ext = $path['extension'];
					$temp_name = $_FILES['RegistrationAsic']['tmp_name']['upload_2'];
					$path_filename_ext = $target_dir.$filename.".".$ext;
					if (file_exists($path_filename_ext)) {
						$path_filename_ext = $target_dir.$filename."_copy".".".$ext;
						move_uploaded_file($temp_name,$path_filename_ext);
						}
					else{
						move_uploaded_file($temp_name,$path_filename_ext); 
						}

				}
				if(isset($_FILES['RegistrationAsic']['name']['upload_3']) && $_FILES['RegistrationAsic']['name']['upload_3']!='')
				{
					$file = $_FILES['RegistrationAsic']['name']['upload_3'];
					$path = pathinfo($file);
					$filename = $path['filename'];
					$ext = $path['extension'];
					$temp_name = $_FILES['RegistrationAsic']['tmp_name']['upload_3'];
					$path_filename_ext = $target_dir.$filename.".".$ext;
					if (file_exists($path_filename_ext)) {
						$path_filename_ext = $target_dir.$filename."_copy".".".$ext;
						move_uploaded_file($temp_name,$path_filename_ext);
						}
					else{
						move_uploaded_file($temp_name,$path_filename_ext); 
						}

				}
				if(isset($_FILES['RegistrationAsic']['name']['upload_4']) && $_FILES['RegistrationAsic']['name']['upload_4']!='')
				{
					$file = $_FILES['RegistrationAsic']['name']['upload_4'];
					$path = pathinfo($file);
					$filename = $path['filename'];
					$ext = $path['extension'];
					$temp_name = $_FILES['RegistrationAsic']['tmp_name']['upload_4'];
					$path_filename_ext = $target_dir.$filename.".".$ext;
					if (file_exists($path_filename_ext)) {
						$path_filename_ext = $target_dir.$filename."_copy".".".$ext;
						move_uploaded_file($temp_name,$path_filename_ext);
						}
					else{
						move_uploaded_file($temp_name,$path_filename_ext); 
						}
				}

				if($model->save())
			{
				Yii::app()->user->setFlash("updated", "Changes have been saved successfully");
			}
			
				
		}
       else if(isset($_POST['RegistrationAsic']) && isset($_POST['AsicInfo']) && isset($_POST['Immigration']))
		{
			$model->attributes=$_POST['RegistrationAsic'];
			$modelAsicInfo->attributes=$_POST['AsicInfo'];
			$immiModel->attributes=$_POST['Immigration'];
			if(isset($_POST['RegistrationAsic']['date_of_birth']))
			$model->date_of_birth=date('Y-m-d',strtotime($_POST['RegistrationAsic']['date_of_birth']));
			if(isset($_POST['RegistrationAsic']['from_date']))
			$model->from_date=date('Y-m-d',strtotime($_POST['RegistrationAsic']['from_date']));
			if(isset($_POST['AsicInfo']['bond_paid']) && $_POST['AsicInfo']['bond_paid']!='')
			{
				$modelAsicInfo->bond_paid=$_POST['AsicInfo']['bond_paid'];
			}

			if(isset($_POST['AsicInfo']['fee_paid']) && $_POST['AsicInfo']['fee_paid']!='')
			{
				$modelAsicInfo->fee_paid=$_POST['AsicInfo']['fee_paid'];
			}
			if(isset($_POST['AsicInfo']['card_number']) && $_POST['AsicInfo']['card_number']!='')
			{
				$modelAsicInfo->card_number=$_POST['AsicInfo']['card_number'];
			}
			$upload_1=$model->upload_1;
			$upload_2=$model->upload_2;
			$upload_3=$model->upload_3;
			$upload_4=$model->upload_4;
			$model->attributes=$_POST['RegistrationAsic'];
			if(isset($_POST['RegistrationAsic']['photo']) && $_POST['RegistrationAsic']['photo']!='')
			{
			$model->photo=$_POST['RegistrationAsic']['photo'];
			}
			if(isset($_FILES['RegistrationAsic']['name']['upload_1']) && $_FILES['RegistrationAsic']['name']['upload_1']!='')
			$model->upload_1=$_FILES['RegistrationAsic']['name']['upload_1'];
			else
			$model->upload_1=$upload_1;
			if(isset($_FILES['RegistrationAsic']['name']['upload_2']) && $_FILES['RegistrationAsic']['name']['upload_2']!='')
			$model->upload_2=$_FILES['RegistrationAsic']['name']['upload_2'];
			else
			$model->upload_2=$upload_2;
			if(isset($_FILES['RegistrationAsic']['name']['upload_3']) && $_FILES['RegistrationAsic']['name']['upload_3']!='')
			$model->upload_3=$_FILES['RegistrationAsic']['name']['upload_3'];
			else
			$model->upload_3=$upload_3;
			if(isset($_FILES['RegistrationAsic']['name']['upload_4']) && $_FILES['RegistrationAsic']['name']['upload_4']!='')
			$model->upload_4=$_FILES['RegistrationAsic']['name']['upload_4'];
			else
			$model->upload_4=$upload_4;
			
				$target_dir= Yii::getPathOfAlias('webroot').'/uploads/files/asic_uploads/';
				if(isset($_FILES['RegistrationAsic']['name']['upload_1']) && $_FILES['RegistrationAsic']['name']['upload_1']!='')
				{
					$file = $_FILES['RegistrationAsic']['name']['upload_1'];
					$path = pathinfo($file);
					$filename = $path['filename'];
					$ext = $path['extension'];
					$temp_name = $_FILES['RegistrationAsic']['tmp_name']['upload_1'];
					$path_filename_ext = $target_dir.$filename.".".$ext;
					if (file_exists($path_filename_ext)) {
						$path_filename_ext = $target_dir.$filename."_copy".".".$ext;
						move_uploaded_file($temp_name,$path_filename_ext);
						}
					else{
						move_uploaded_file($temp_name,$path_filename_ext); 
						}

				}
				if(isset($_FILES['RegistrationAsic']['name']['upload_2']) && $_FILES['RegistrationAsic']['name']['upload_2']!='')
				{
					$file = $_FILES['RegistrationAsic']['name']['upload_2'];
					$path = pathinfo($file);
					$filename = $path['filename'];
					$ext = $path['extension'];
					$temp_name = $_FILES['RegistrationAsic']['tmp_name']['upload_2'];
					$path_filename_ext = $target_dir.$filename.".".$ext;
					if (file_exists($path_filename_ext)) {
						$path_filename_ext = $target_dir.$filename."_copy".".".$ext;
						move_uploaded_file($temp_name,$path_filename_ext);
						}
					else{
						move_uploaded_file($temp_name,$path_filename_ext); 
						}

				}
				if(isset($_FILES['RegistrationAsic']['name']['upload_3']) && $_FILES['RegistrationAsic']['name']['upload_3']!='')
				{
					$file = $_FILES['RegistrationAsic']['name']['upload_3'];
					$path = pathinfo($file);
					$filename = $path['filename'];
					$ext = $path['extension'];
					$temp_name = $_FILES['RegistrationAsic']['tmp_name']['upload_3'];
					$path_filename_ext = $target_dir.$filename.".".$ext;
					if (file_exists($path_filename_ext)) {
						$path_filename_ext = $target_dir.$filename."_copy".".".$ext;
						move_uploaded_file($temp_name,$path_filename_ext);
						}
					else{
						move_uploaded_file($temp_name,$path_filename_ext); 
						}

				}
				if(isset($_FILES['RegistrationAsic']['name']['upload_4']) && $_FILES['RegistrationAsic']['name']['upload_4']!='')
				{
					$file = $_FILES['RegistrationAsic']['name']['upload_4'];
					$path = pathinfo($file);
					$filename = $path['filename'];
					$ext = $path['extension'];
					$temp_name = $_FILES['RegistrationAsic']['tmp_name']['upload_4'];
					$path_filename_ext = $target_dir.$filename.".".$ext;
					if (file_exists($path_filename_ext)) {
						$path_filename_ext = $target_dir.$filename."_copy".".".$ext;
						move_uploaded_file($temp_name,$path_filename_ext);
						}
					else{
						move_uploaded_file($temp_name,$path_filename_ext); 
						}

				}
		if($model->save() && $modelAsicInfo->save() && $immiModel->save())
			{
				Yii::app()->user->setFlash("updated", "Changes have been saved successfully");
			}		
	
		}
            $this->render('update', array(
                'model' => $model,'addHistory'=>$addHistory,'modelHistory'=>$modelHistory,'modelDetails'=>$modelAsicInfo,'companyName'=>$companyName,'companyContact'=>$companyContact,'immiModel'=>$immiModel
            ));
      
    }
	public function actionAsicView($id) {   
                        
        $model= new RegistrationAsic();
		$model=$model->findByPk($id);
		$modelHistory= new AsicAddressHistory();
		$modelAsicInfo=new AsicInfo();
		$exist=$modelAsicInfo->exists('asic_applicant_id='.$id.'');
		if($exist)
		$modelAsicInfo=$modelAsicInfo->find('asic_applicant_id='.$id);
		$exist=$modelHistory->exists('asic_applicant_id='.$id.'');
		if($exist)
		$addHistory=$modelHistory->findAll('asic_applicant_id='.$id);
		else
		$addHistory='';
		if($model->company_id!='')
		$companyName=Company::model()->findByPk($model->company_id);
		else
		$companyName='Company not mentioned';
		if($model->company_contact!='')
		$companyContact=User::model()->findByPk($model->company_contact);
		else
		$companyContact='Contact not mentioned';
		$immiModel=new Immigration();	
		$exist=$immiModel->exists('asic_applicant_id='.$id.'');
		if($exist)
		$immiModel=$immiModel->find('asic_applicant_id='.$id);
		//Yii::app()->end();
        $session= new CHttpSession;
		
            $this->render('viewAsic', array(
                'model' => $model,'addHistory'=>$addHistory,'modelHistory'=>$modelHistory,'modelDetails'=>$modelAsicInfo,'companyName'=>$companyName,'companyContact'=>$companyContact,'immiModel'=>$immiModel
            ));
      
    }
public function actionAsicAddressUpdate()
{
	if(Yii::app()->request->isAjaxRequest)
		{
			if(isset($_POST['id']) && $_POST['id']!='' && $_POST['id']!=0)
			{
				$Address=new AsicAddressHistory();
				$Update=$Address->findByPk($_POST['id']);
				$Update->attributes=$_POST['AsicAddressHistory'];
				$Update->from_date=date('Y-m-d', strtotime(str_replace('/', '-', $_POST['AsicAddressHistory_from_date_container'])));
				$Update->to_date=date('Y-m-d', strtotime(str_replace('/', '-', $_POST['AsicAddressHistory_to_date_container'])));
				$Update->country=Country::model()->findByPk($_POST['AsicAddressHistory']['country'])->name;
				//$UpdateAdress->=$_POST['AsicAddressHistory']['unit'];
				//print_r($_POST);
				
				if($Update->save())
				{
					Yii::app()->user->setFlash("success", "Address changes have been saved successfully");
					
				}
				else
					Yii::app()->user->setFlash("error","Server Error: Too much Load");
				
			foreach(Yii::app()->user->getFlashes() as $key => $message) 
			{
			echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
			}
			}
			else if(isset($_POST['id']) && $_POST['id']!='' && $_POST['id']==0 && isset($_POST['appId']) && $_POST['appId']!='')
			{
				$Address=new AsicAddressHistory();
				$Address->attributes=$_POST['AsicAddressHistory'];
				$Address->from_date=date('Y-m-d', strtotime(str_replace('/', '-', $_POST['AsicAddressHistory_from_date_container'])));
				$Address->to_date=date('Y-m-d', strtotime(str_replace('/', '-', $_POST['AsicAddressHistory_to_date_container'])));
				$Address->country=Country::model()->findByPk($_POST['AsicAddressHistory']['country'])->name;
				$Address->asic_applicant_id=$_POST['appId'];
				if($Address->save())
				{
					Yii::app()->user->setFlash("success", "Address have been saved successfully");
					
				}
				else
					Yii::app()->user->setFlash("error","Server Error: Too much Load");
						
			foreach(Yii::app()->user->getFlashes() as $key => $message) 
			{
			echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
			}
			echo $Address->id;
			}
			
			Yii::app()->end();
		}
}
public function actionAsicAddressDelete()
{
 if(Yii::app()->request->isPostRequest)
{
	//echo $id;
	$addressHistory=new AsicAddressHistory();
	if(isset($_POST['id']))
	{
	$exist=$addressHistory->exists('id='.$_POST['id'].'');
	if($exist)
	{
	$addressHistory->deleteByPk($_POST['id']);
	echo "false";
	}
	else
	echo "true";
	}
}	
}
public function actionExportAuscheck()
{
	//$objPHPExcel = Yii::app()->excel;
	$modelAsicApplicant=new RegistrationAsic();
	$modelImmiInfo=new Immigration();
	$modelAsicApplication=new AsicInfo();
	$modelAddressHistory=new AsicAddressHistory();
	$modelAsicApplicant=$modelAsicApplicant->findAll('tenant='.Yii::app()->user->tenant.' AND is_logged is null AND is_completed=1');
	$auscheckFile=Yii::getPathOfAlias('webroot').'/uploads/files/Excel_Upload_Template_(2007 format).xls';
	$objPHPExcel = Yii::app()->excel;
	$objPHPExcel = PHPExcel_IOFactory::load($auscheckFile);
	//$objReader = $objPHPExcel->readExcel2007();
	//$objPHPExcel = $objReader->load($auscheckFile);
	$i=4;
	foreach($modelAsicApplicant as $value)
	{
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$value->id);
		$objPHPExcel->getActiveSheet()->setCellValue('M'.$i,$value->last_name);
		$objPHPExcel->getActiveSheet()->setCellValue('N'.$i,$value->first_name);
		$objPHPExcel->getActiveSheet()->setCellValue('O'.$i,$value->given_name2);
		$objPHPExcel->getActiveSheet()->setCellValue('P'.$i,$value->given_name3);
		$objPHPExcel->getActiveSheet()->setCellValue('Q'.$i,date('d/m/Y',strtotime($value->date_of_birth)));
		if($value->gender=='male')
		{
		$objPHPExcel->getActiveSheet()->setCellValue('R'.$i,'M');
		}
		else
		$objPHPExcel->getActiveSheet()->setCellValue('R'.$i,'F');
	
		if($value->changed_last_name1!=NULL || $value->changed_last_name1!='')
		$objPHPExcel->getActiveSheet()->setCellValue('S'.$i,$value->changed_last_name1);
	
		if($value->changed_given_name1!=NULL || $value->changed_given_name1!='')
		$objPHPExcel->getActiveSheet()->setCellValue('T'.$i,$value->changed_given_name1);
	
		if($value->changed_given_name2!=NULL || $value->changed_given_name2!='')
		$objPHPExcel->getActiveSheet()->setCellValue('U'.$i,$value->changed_given_name2);
	
		if($value->changed_given_name3!=NULL || $value->changed_given_name3!='')
		$objPHPExcel->getActiveSheet()->setCellValue('V'.$i,$value->changed_given_name3);
	
		if($value->name_type1!=NULL || $value->name_type1!='')
		$objPHPExcel->getActiveSheet()->setCellValue('X'.$i,$value->name_type1);
	
		if($value->changed_last_name2!=NULL || $value->changed_last_name2!='')
		$objPHPExcel->getActiveSheet()->setCellValue('Y'.$i,$value->changed_last_name2);
	
		if($value->changed_given_name1_1!=NULL || $value->changed_given_name1_1!='')
		$objPHPExcel->getActiveSheet()->setCellValue('Z'.$i,$value->changed_given_name1_1);
	
		if($value->changed_given_name2_1!=NULL || $value->changed_given_name2_1!='')
		$objPHPExcel->getActiveSheet()->setCellValue('AA'.$i,$value->changed_given_name2_1);
	
		if($value->changed_given_name3_1!=NULL || $value->changed_given_name3_1!='')
		$objPHPExcel->getActiveSheet()->setCellValue('AB'.$i,$value->changed_given_name3_1);
	
		if($value->name_type2!=NULL || $value->name_type2!='')
		$objPHPExcel->getActiveSheet()->setCellValue('AD'.$i,$value->name_type2);
	
		$objPHPExcel->getActiveSheet()->setCellValue('AE'.$i,$value->birth_city);
		$objPHPExcel->getActiveSheet()->setCellValue('AF'.$i,$value->birth_state);
		$objPHPExcel->getActiveSheet()->setCellValue('AG'.$i,Country::model()->findByPk($value->birth_country)->code);
		$objPHPExcel->getActiveSheet()->setCellValue('AK'.$i,$value->unit);
		$objPHPExcel->getActiveSheet()->setCellValue('AL'.$i,$value->street_number);
		$objPHPExcel->getActiveSheet()->setCellValue('AM'.$i,$value->street_name);
		$objPHPExcel->getActiveSheet()->setCellValue('AN'.$i,$value->street_type);
		$objPHPExcel->getActiveSheet()->setCellValue('AO'.$i,$value->suburb);
		$objPHPExcel->getActiveSheet()->setCellValue('AP'.$i,$value->postcode);
		$objPHPExcel->getActiveSheet()->setCellValue('AQ'.$i,$value->city);
		$objPHPExcel->getActiveSheet()->setCellValue('AR'.$i,$value->state);
		$objPHPExcel->getActiveSheet()->setCellValue('AS'.$i,Country::model()->findByPk($value->country)->code);
		$objPHPExcel->getActiveSheet()->setCellValue('AT'.$i,date('d/m/Y',strtotime($value->from_date)));
		$objPHPExcel->getActiveSheet()->setCellValue('DE'.$i,$value->preferred_contact);
		$objPHPExcel->getActiveSheet()->setCellValue('DF'.$i,$value->home_phone);
		$objPHPExcel->getActiveSheet()->setCellValue('DG'.$i,$value->work_phone);
		$objPHPExcel->getActiveSheet()->setCellValue('DH'.$i,$value->mobile_phone);
		$objPHPExcel->getActiveSheet()->setCellValue('DI'.$i,$value->email);
		
		$objPHPExcel->getActiveSheet()->setCellValue('DJ'.$i,Company::model()->findByPk($value->company_id)->name);
		$objPHPExcel->getActiveSheet()->setCellValue('DK'.$i,Company::model()->findByPk($value->company_id)->unit);
		$objPHPExcel->getActiveSheet()->setCellValue('DL'.$i,Company::model()->findByPk($value->company_id)->street_number);
		$objPHPExcel->getActiveSheet()->setCellValue('DM'.$i,Company::model()->findByPk($value->company_id)->street_name);
		$objPHPExcel->getActiveSheet()->setCellValue('DN'.$i,Company::model()->findByPk($value->company_id)->street_type);
		$objPHPExcel->getActiveSheet()->setCellValue('DO'.$i,Company::model()->findByPk($value->company_id)->suburb);
		$objPHPExcel->getActiveSheet()->setCellValue('DP'.$i,Company::model()->findByPk($value->company_id)->post_code);
		$objPHPExcel->getActiveSheet()->setCellValue('DQ'.$i,Company::model()->findByPk($value->company_id)->city);
		$objPHPExcel->getActiveSheet()->setCellValue('DR'.$i,Company::model()->findByPk($value->company_id)->state);
		$objPHPExcel->getActiveSheet()->setCellValue('DS'.$i,Country::model()->findByPk(Company::model()->findByPk($value->company_id)->country)->code);
		$objPHPExcel->getActiveSheet()->setCellValue('DT'.$i,Company::model()->findByPk($value->company_id)->office_number);
		$objPHPExcel->getActiveSheet()->setCellValue('DU'.$i,Company::model()->findByPk($value->company_id)->website);
		//$objPHPExcel->getActiveSheet()->setCellValue('DV'.$i,User::model()->findByPk($value->company_contact)->first_name);
		$objPHPExcel->getActiveSheet()->setCellValue('DW'.$i,User::model()->findByPk($value->company_contact)->first_name);
		$objPHPExcel->getActiveSheet()->setCellValue('DX'.$i,User::model()->findByPk($value->company_contact)->last_name);
		$objPHPExcel->getActiveSheet()->setCellValue('DZ'.$i,User::model()->findByPk($value->company_contact)->email);
		$objPHPExcel->getActiveSheet()->setCellValue('BW'.$i,$value->application_type);
		
		/*if($value->tenant==3739)
		$objPHPExcel->getActiveSheet()->setCellValue('BM'.$i,'MCY');
		else*/
		$objPHPExcel->getActiveSheet()->setCellValue('BM'.$i,Company::model()->findByPk($value->tenant)->code);
		$objPHPExcel->getActiveSheet()->setCellValue('BN'.$i,$modelAsicApplication->find("asic_applicant_id='".$value->id."'")->card_number);
		$objPHPExcel->getActiveSheet()->setCellValue('BO'.$i,$value->first_name." ".$value->last_name);
		$objPHPExcel->getActiveSheet()->setCellValue('BP'.$i,'ASIC');
		
		if($modelAsicApplication->find("asic_applicant_id='".$value->id."'")->access=='1')
		$objPHPExcel->getActiveSheet()->setCellValue('BQ'.$i,'R');
		else
		$objPHPExcel->getActiveSheet()->setCellValue('BQ'.$i,'G');
		if($modelAsicApplication->find("asic_applicant_id='".$value->id."'")->asic_type==Yii::app()->user->tenant)
		{
			/*if(Yii::app()->user->tenant==3739)
			$objPHPExcel->getActiveSheet()->setCellValue('BR'.$i,'MCY');
			else*/
			$objPHPExcel->getActiveSheet()->setCellValue('BR'.$i,Company::model()->findByPk($value->tenant)->code);
		}
		else
		{
		 $objPHPExcel->getActiveSheet()->setCellValue('BR'.$i,'AUS');
		}
		
		$objPHPExcel->getActiveSheet()->setCellValue('BS'.$i,'FALSE');
		if($modelAsicApplication->find("asic_applicant_id='".$value->id."'")->previous_card!='' or $modelAsicApplication->find("asic_applicant_id='".$value->id."'")->previous_card!=null)
		$objPHPExcel->getActiveSheet()->setCellValue('BU'.$i,$modelAsicApplication->find("asic_applicant_id='".$value->id."'")->previous_card);
		if($modelAsicApplication->find("asic_applicant_id='".$value->id."'")->previous_issuing_body!='' or $modelAsicApplication->find("asic_applicant_id='".$value->id."'")->previous_issuing_body!=null)
		$objPHPExcel->getActiveSheet()->setCellValue('BV'.$i,$modelAsicApplication->find("asic_applicant_id='".$value->id."'")->previous_issuing_body);
		$objPHPExcel->getActiveSheet()->setCellValue('BX'.$i,'ASIC');
		
		if($value->citizenship==13 || $value->citizenship==171 )
		{
			$objPHPExcel->getActiveSheet()->setCellValue('EA'.$i,'TRUE');
			$objPHPExcel->getActiveSheet()->setCellValue('EK'.$i,Country::model()->findByPk($value->citizenship)->code);
			$objPHPExcel->getActiveSheet()->setCellValue('EL'.$i,'TRUE');
		}
		else
		{
			$objPHPExcel->getActiveSheet()->setCellValue('EA'.$i,'FALSE');
			$objPHPExcel->getActiveSheet()->setCellValue('EB'.$i,$modelImmiInfo->find("asic_applicant_id='".$value->id."'")->travel_id);
			$objPHPExcel->getActiveSheet()->setCellValue('EC'.$i,Country::model()->findByPk($value->citizenship)->code);
			$objPHPExcel->getActiveSheet()->setCellValue('ED'.$i,$modelImmiInfo->find("asic_applicant_id='".$value->id."'")->grant_number);
			$objPHPExcel->getActiveSheet()->setCellValue('EE'.$i,$modelImmiInfo->find("asic_applicant_id='".$value->id."'")->arrival);
			$objPHPExcel->getActiveSheet()->setCellValue('EF'.$i,$modelImmiInfo->find("asic_applicant_id='".$value->id."'")->arrival_date);
			$objPHPExcel->getActiveSheet()->setCellValue('EG'.$i,$modelImmiInfo->find("asic_applicant_id='".$value->id."'")->flight_number);
			$objPHPExcel->getActiveSheet()->setCellValue('EH'.$i,$modelImmiInfo->find("asic_applicant_id='".$value->id."'")->name_vessel);
			$objPHPExcel->getActiveSheet()->setCellValue('EI'.$i,$modelImmiInfo->find("asic_applicant_id='".$value->id."'")->parent_family_name);
			$objPHPExcel->getActiveSheet()->setCellValue('EJ'.$i,$modelImmiInfo->find("asic_applicant_id='".$value->id."'")->parent_given_name);
			$objPHPExcel->getActiveSheet()->setCellValue('EK'.$i,Country::model()->findByPk($value->citizenship)->code);
			$objPHPExcel->getActiveSheet()->setCellValue('EL'.$i,'TRUE');
		}
		
		if($value->is_postal!=1)
		{
		$objPHPExcel->getActiveSheet()->setCellValue('EN'.$i,$value->postal_unit);
		$objPHPExcel->getActiveSheet()->setCellValue('EO'.$i,$value->postal_street_number);
		$objPHPExcel->getActiveSheet()->setCellValue('EP'.$i,$value->postal_street_name);
		$objPHPExcel->getActiveSheet()->setCellValue('EQ'.$i,$value->postal_street_type);
		$objPHPExcel->getActiveSheet()->setCellValue('ER'.$i,$value->postal_suburb);
		$objPHPExcel->getActiveSheet()->setCellValue('ES'.$i,$value->postal_postcode);
		$objPHPExcel->getActiveSheet()->setCellValue('ET'.$i,$value->postal_city);
		$objPHPExcel->getActiveSheet()->setCellValue('EU'.$i,$value->postal_state);
		$objPHPExcel->getActiveSheet()->setCellValue('EV'.$i,Country::model()->findByPk($value->postal_country)->code);
		}
		
		$is_exist=$modelAddressHistory->exists('asic_applicant_id='.$value->id.'');
		//echo $is_exist;
		if($is_exist)
		{
			$address=$modelAddressHistory->findAll('asic_applicant_id='.$value->id);
			$count=count($address);
			
			for($x=0; $x<$count; $x++)
			{
				if($x==0)
				{
					$objPHPExcel->getActiveSheet()->setCellValue('AV'.$i,$address[$x]->unit);
					$objPHPExcel->getActiveSheet()->setCellValue('AW'.$i,$address[$x]->street_number);
					$objPHPExcel->getActiveSheet()->setCellValue('AX'.$i,$address[$x]->street_name);
					$objPHPExcel->getActiveSheet()->setCellValue('AY'.$i,$address[$x]->street_type);
					$objPHPExcel->getActiveSheet()->setCellValue('AZ'.$i,$address[$x]->suburb);
					$objPHPExcel->getActiveSheet()->setCellValue('BA'.$i,$address[$x]->postcode);
					$objPHPExcel->getActiveSheet()->setCellValue('BB'.$i,$address[$x]->city);
					$objPHPExcel->getActiveSheet()->setCellValue('BC'.$i,$address[$x]->state);
					$objPHPExcel->getActiveSheet()->setCellValue('BD'.$i,Country::model()->find("name='".$address[$x]->country."'")->code);
					$objPHPExcel->getActiveSheet()->setCellValue('BE'.$i,date('d/m/Y',strtotime($address[$x]->from_date)));
					$objPHPExcel->getActiveSheet()->setCellValue('BF'.$i,date('d/m/Y',strtotime($address[$x]->to_date)));	
				}
				else if($x==1)
				{
					$objPHPExcel->getActiveSheet()->setCellValue('BY'.$i,$address[$x]->unit);
					$objPHPExcel->getActiveSheet()->setCellValue('BZ'.$i,$address[$x]->street_number);
					$objPHPExcel->getActiveSheet()->setCellValue('CA'.$i,$address[$x]->street_name);
					$objPHPExcel->getActiveSheet()->setCellValue('CB'.$i,$address[$x]->street_type);
					$objPHPExcel->getActiveSheet()->setCellValue('CC'.$i,$address[$x]->suburb);
					$objPHPExcel->getActiveSheet()->setCellValue('CD'.$i,$address[$x]->postcode);
					$objPHPExcel->getActiveSheet()->setCellValue('CE'.$i,$address[$x]->city);
					$objPHPExcel->getActiveSheet()->setCellValue('CF'.$i,$address[$x]->state);
					$objPHPExcel->getActiveSheet()->setCellValue('CG'.$i,Country::model()->find("name='".$address[$x]->country."'")->code);
					$objPHPExcel->getActiveSheet()->setCellValue('CH'.$i,date('d/m/Y',strtotime($address[$x]->from_date)));
					$objPHPExcel->getActiveSheet()->setCellValue('CI'.$i,date('d/m/Y',strtotime($address[$x]->to_date)));
					
				}
				else if($x==2)
				{
					$objPHPExcel->getActiveSheet()->setCellValue('EZ'.$i,$address[$x]->unit);
					$objPHPExcel->getActiveSheet()->setCellValue('FA'.$i,$address[$x]->street_number);
					$objPHPExcel->getActiveSheet()->setCellValue('FB'.$i,$address[$x]->street_name);
					$objPHPExcel->getActiveSheet()->setCellValue('FC'.$i,$address[$x]->street_type);
					$objPHPExcel->getActiveSheet()->setCellValue('FD'.$i,$address[$x]->suburb);
					$objPHPExcel->getActiveSheet()->setCellValue('FE'.$i,$address[$x]->postcode);
					$objPHPExcel->getActiveSheet()->setCellValue('FF'.$i,$address[$x]->city);
					$objPHPExcel->getActiveSheet()->setCellValue('FG'.$i,$address[$x]->state);
					$objPHPExcel->getActiveSheet()->setCellValue('FH'.$i,Country::model()->find("name='".$address[$x]->country."'")->code);
					$objPHPExcel->getActiveSheet()->setCellValue('FI'.$i,date('d/m/Y',strtotime($address[$x]->from_date)));
					$objPHPExcel->getActiveSheet()->setCellValue('FJ'.$i,date('d/m/Y',strtotime($address[$x]->to_date)));
					
				}
				else if($x==3)
				{
					$objPHPExcel->getActiveSheet()->setCellValue('FK'.$i,$address[$x]->unit);
					$objPHPExcel->getActiveSheet()->setCellValue('FL'.$i,$address[$x]->street_number);
					$objPHPExcel->getActiveSheet()->setCellValue('FM'.$i,$address[$x]->street_name);
					$objPHPExcel->getActiveSheet()->setCellValue('FN'.$i,$address[$x]->street_type);
					$objPHPExcel->getActiveSheet()->setCellValue('FO'.$i,$address[$x]->suburb);
					$objPHPExcel->getActiveSheet()->setCellValue('FP'.$i,$address[$x]->postcode);
					$objPHPExcel->getActiveSheet()->setCellValue('FQ'.$i,$address[$x]->city);
					$objPHPExcel->getActiveSheet()->setCellValue('FR'.$i,$address[$x]->state);
					$objPHPExcel->getActiveSheet()->setCellValue('FS'.$i,Country::model()->find("name='".$address[$x]->country."'")->code);
					$objPHPExcel->getActiveSheet()->setCellValue('FT'.$i,date('d/m/Y',strtotime($address[$x]->from_date)));
					$objPHPExcel->getActiveSheet()->setCellValue('FU'.$i,date('d/m/Y',strtotime($address[$x]->to_date)));
					
				}
				else if($x==4)
				{
					$objPHPExcel->getActiveSheet()->setCellValue('FV'.$i,$address[$x]->unit);
					$objPHPExcel->getActiveSheet()->setCellValue('FW'.$i,$address[$x]->street_number);
					$objPHPExcel->getActiveSheet()->setCellValue('FX'.$i,$address[$x]->street_name);
					$objPHPExcel->getActiveSheet()->setCellValue('FY'.$i,$address[$x]->street_type);
					$objPHPExcel->getActiveSheet()->setCellValue('FZ'.$i,$address[$x]->suburb);
					$objPHPExcel->getActiveSheet()->setCellValue('GA'.$i,$address[$x]->postcode);
					$objPHPExcel->getActiveSheet()->setCellValue('GB'.$i,$address[$x]->city);
					$objPHPExcel->getActiveSheet()->setCellValue('GC'.$i,$address[$x]->state);
					$objPHPExcel->getActiveSheet()->setCellValue('GD'.$i,Country::model()->find("name='".$address[$x]->country."'")->code);
					$objPHPExcel->getActiveSheet()->setCellValue('GE'.$i,date('d/m/Y',strtotime($address[$x]->from_date)));
					$objPHPExcel->getActiveSheet()->setCellValue('GF'.$i,date('d/m/Y',strtotime($address[$x]->to_date)));
					
				}
				else if($x==5)
				{
					$objPHPExcel->getActiveSheet()->setCellValue('GG'.$i,$address[$x]->unit);
					$objPHPExcel->getActiveSheet()->setCellValue('GH'.$i,$address[$x]->street_number);
					$objPHPExcel->getActiveSheet()->setCellValue('GI'.$i,$address[$x]->street_name);
					$objPHPExcel->getActiveSheet()->setCellValue('GJ'.$i,$address[$x]->street_type);
					$objPHPExcel->getActiveSheet()->setCellValue('GK'.$i,$address[$x]->suburb);
					$objPHPExcel->getActiveSheet()->setCellValue('GL'.$i,$address[$x]->postcode);
					$objPHPExcel->getActiveSheet()->setCellValue('GM'.$i,$address[$x]->city);
					$objPHPExcel->getActiveSheet()->setCellValue('GN'.$i,$address[$x]->state);
					$objPHPExcel->getActiveSheet()->setCellValue('GO'.$i,Country::model()->find("name='".$address[$x]->country."'")->code);
					$objPHPExcel->getActiveSheet()->setCellValue('GP'.$i,date('d/m/Y',strtotime($address[$x]->from_date)));
					$objPHPExcel->getActiveSheet()->setCellValue('GQ'.$i,date('d/m/Y',strtotime($address[$x]->to_date)));
					
				}
				else if($x==6)
				{
					$objPHPExcel->getActiveSheet()->setCellValue('GR'.$i,$address[$x]->unit);
					$objPHPExcel->getActiveSheet()->setCellValue('GS'.$i,$address[$x]->street_number);
					$objPHPExcel->getActiveSheet()->setCellValue('GT'.$i,$address[$x]->street_name);
					$objPHPExcel->getActiveSheet()->setCellValue('GU'.$i,$address[$x]->street_type);
					$objPHPExcel->getActiveSheet()->setCellValue('GV'.$i,$address[$x]->suburb);
					$objPHPExcel->getActiveSheet()->setCellValue('GW'.$i,$address[$x]->postcode);
					$objPHPExcel->getActiveSheet()->setCellValue('GX'.$i,$address[$x]->city);
					$objPHPExcel->getActiveSheet()->setCellValue('GY'.$i,$address[$x]->state);
					$objPHPExcel->getActiveSheet()->setCellValue('GZ'.$i,Country::model()->find("name='".$address[$x]->country."'")->code);
					$objPHPExcel->getActiveSheet()->setCellValue('HA'.$i,date('d/m/Y',strtotime($address[$x]->from_date)));
					$objPHPExcel->getActiveSheet()->setCellValue('HB'.$i,date('d/m/Y',strtotime($address[$x]->to_date)));
					
				}
				else if($x==7)
				{
					$objPHPExcel->getActiveSheet()->setCellValue('HC'.$i,$address[$x]->unit);
					$objPHPExcel->getActiveSheet()->setCellValue('HD'.$i,$address[$x]->street_number);
					$objPHPExcel->getActiveSheet()->setCellValue('HE'.$i,$address[$x]->street_name);
					$objPHPExcel->getActiveSheet()->setCellValue('HF'.$i,$address[$x]->street_type);
					$objPHPExcel->getActiveSheet()->setCellValue('HG'.$i,$address[$x]->suburb);
					$objPHPExcel->getActiveSheet()->setCellValue('HH'.$i,$address[$x]->postcode);
					$objPHPExcel->getActiveSheet()->setCellValue('HI'.$i,$address[$x]->city);
					$objPHPExcel->getActiveSheet()->setCellValue('HJ'.$i,$address[$x]->state);
					$objPHPExcel->getActiveSheet()->setCellValue('HK'.$i,Country::model()->find("name='".$address[$x]->country."'")->code);
					$objPHPExcel->getActiveSheet()->setCellValue('HL'.$i,date('d/m/Y',strtotime($address[$x]->from_date)));
					$objPHPExcel->getActiveSheet()->setCellValue('HM'.$i,date('d/m/Y',strtotime($address[$x]->to_date)));
					
				}
				else if($x==8)
				{
					$objPHPExcel->getActiveSheet()->setCellValue('HN'.$i,$address[$x]->unit);
					$objPHPExcel->getActiveSheet()->setCellValue('HO'.$i,$address[$x]->street_number);
					$objPHPExcel->getActiveSheet()->setCellValue('HP'.$i,$address[$x]->street_name);
					$objPHPExcel->getActiveSheet()->setCellValue('HQ'.$i,$address[$x]->street_type);
					$objPHPExcel->getActiveSheet()->setCellValue('HR'.$i,$address[$x]->suburb);
					$objPHPExcel->getActiveSheet()->setCellValue('HS'.$i,$address[$x]->postcode);
					$objPHPExcel->getActiveSheet()->setCellValue('HT'.$i,$address[$x]->city);
					$objPHPExcel->getActiveSheet()->setCellValue('HU'.$i,$address[$x]->state);
					$objPHPExcel->getActiveSheet()->setCellValue('HV'.$i,Country::model()->find("name='".$address[$x]->country."'")->code);
					$objPHPExcel->getActiveSheet()->setCellValue('HW'.$i,date('d/m/Y',strtotime($address[$x]->from_date)));
					$objPHPExcel->getActiveSheet()->setCellValue('HX'.$i,date('d/m/Y',strtotime($address[$x]->to_date)));
					
				}
				else if($x==9)
				{
					$objPHPExcel->getActiveSheet()->setCellValue('HY'.$i,$address[$x]->unit);
					$objPHPExcel->getActiveSheet()->setCellValue('HZ'.$i,$address[$x]->street_number);
					$objPHPExcel->getActiveSheet()->setCellValue('IA'.$i,$address[$x]->street_name);
					$objPHPExcel->getActiveSheet()->setCellValue('IB'.$i,$address[$x]->street_type);
					$objPHPExcel->getActiveSheet()->setCellValue('IC'.$i,$address[$x]->suburb);
					$objPHPExcel->getActiveSheet()->setCellValue('ID'.$i,$address[$x]->postcode);
					$objPHPExcel->getActiveSheet()->setCellValue('IE'.$i,$address[$x]->city);
					$objPHPExcel->getActiveSheet()->setCellValue('IF'.$i,$address[$x]->state);
					$objPHPExcel->getActiveSheet()->setCellValue('IG'.$i,Country::model()->find("name='".$address[$x]->country."'")->code);
					$objPHPExcel->getActiveSheet()->setCellValue('IH'.$i,date('d/m/Y',strtotime($address[$x]->from_date)));
					$objPHPExcel->getActiveSheet()->setCellValue('II'.$i,date('d/m/Y',strtotime($address[$x]->to_date)));
					
				}
			}
		
		}
		
		
		$i++;
	}
	//Yii::app()->end();
	$newauscheckFile=Yii::getPathOfAlias('webroot').'/uploads/files//'.date('d-m-Y').'_auscheck_Template'.Yii::app()->user->tenant.'.xls';
	 //ARCHIVE excel2007 dir 
	 //CELL -> this line crash
	//$temp = $val->getvalue(); //returns the value in the cell
	//print_r($temp);
	$objPHPExcel->saveExcel2007($objPHPExcel,$newauscheckFile);
	$this->downloadFile($newauscheckFile);
	//Yii::app()->end();
}
public function downloadFile($fullpath){
  if(!empty($fullpath)){ 
      header("Content-type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"); //for pdf file
      //header('Content-Type:text/plain; charset=ISO-8859-15');
      //if you want to read text file using text/plain header 
      header('Content-Disposition: attachment; filename="'.basename($fullpath).'"'); 
      header('Content-Length: ' . filesize($fullpath));
      readfile($fullpath);
	  unlink($fullpath);
      $this->redirect(array('asicApplicant/listApplicants'));
  }
}
	 protected function closeAsicPendingAndReset( $visitor ) {
        $update = array();
        $update["visit_status"] = VisitStatus::CLOSED;
        $update["visit_closed_date"] = date("Y-m-d H:i:s");
		//echo 'here';
		//Yii::app()->end();
        /**
         * Get all EVIC Auto Closed Visits now
         */
        $criteria = new CDbCriteria();
        $criteria->addCondition("visitor = ".$visitor->id);
        //$criteria->addCondition("visit_status = ".VisitStatus::AUTOCLOSED);
        //$criteria->addCondition("card_type = ".CardType::VIC_CARD_EXTENDED);
                
        $visits = Visit::model()->findAll($criteria);
        foreach( $visits as $v ) {
            if( is_null( $v["parent_id"]) ) {
                $update["reset_id"] = 1;
                
                Visit::model()->updateByPk($v["id"], $update);
            }
        }
         return;               
    }
	public function actionAsicProcess()
{
	$this->render('process');
}
		public function actionIsCompleted(){
	if(isset($_POST))
	{
		$model=new RegistrationAsic();
		$update = array();
        $update["is_completed"] = 1;
		if($model->updateByPk($_POST['id'], $update))
		echo "completed";	
		 
		
	}
	}
	public function actionMakeIncompleted(){
	if(isset($_POST))
	{
		$model=new RegistrationAsic();
		$update = array();
        $update["is_completed"] = 0;
		if($model->updateByPk($_POST['id'], $update))
		echo "incompleted";	
		 
		
	}
	}
}
