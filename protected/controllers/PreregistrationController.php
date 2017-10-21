<?php

class PreregistrationController extends Controller
{
	public $layout = '';
	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete , ajaxAsicSearch', // we only allow deletion via POST request
		);
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() {
		 $session = new CHttpSession;
		return array(
			array('allow',
				'actions' => array('entryPoint','appType','asicOnlinePrivacyPolicy','asicFee','conditionOfUse','asicType','personalAsicOnline','immiInfo','identificationAsicOnline','asicOperationalNeed','paymentAppointment','uploadPhotoAsicOnline','uploadProfilePhoto','forgot','reset','index','privacyPolicy' , 'declaration' , 'Login' ,'registration','personalDetails', 'visitReason' , 'addAsic' , 'asicPass', 'error' , 'uploadPhoto','ajaxAsicSearch','ajaxVICHolderSearch', 'visitDetails' ,'success','checkEmailIfUnique','findAllCompanyContactsByCompany','findAllCompanyFromWorkstation','checkUserProfile','asicPrivacyPolicy','compAdminPrivacyPolicy','asicRegistration','companyAdminRegistration','createAsicNotificationRequestedVerifications','addCompany','addCompanyContact','asicSubmit','saved','asicSuccess','stop','scan'),
				'users' => array('*'),
			),
			array('allow',
				'actions'=>array('details','logout','dashboard'),
				'users' => array('@'),
				//'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION)',
			),
			array(
                'allow',
                'actions' => array('assignAsicholder','update','vicholderDeclined','declineVicholder','verifyVicholder','profile','visitHistory','helpdesk','notifications','verifications','verificationDeclarations','verifyDeclarations'),
                //'expression' => '(Yii::app()->user->id == ($_GET["id"]))',
                'users' => array('@')
            ),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	public function actionIndex()
	{

		$session = new CHttpSession;
		$session['stepTitle'] = 'AIRPORT VISITOR REGISTRATION';
		$session['step1Subtitle'] = "<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration'></a>";
		
		unset($session['requsetForVerificationEmail']);


		if((isset(Yii::app()->user->tenant)&& Yii::app()->user->tenant!=NULL)){
			$session['tenant'] = Yii::app()->user->tenant;
			$session['AsicprivacyPolicy'] = 'checked';
			$session['step1Subtitle']='ASIC Application';
			$this->redirect(array('preregistration/asicOnlinePrivacyPolicy'));
			
		} 
		if(Yii::app()->request->getParam('tenant')!='')
		{
			$checkTenant= Company::model()->findByPK(Yii::app()->request->getParam('tenant'));
			if(Yii::app()->request->getParam('em')!='')
			{
				$session['em']=Yii::app()->request->getParam('em');
				$session['AsicprivacyPolicy'] = 'checked';
			}

			if($checkTenant)
			{
				$session['tenant']=Yii::app()->request->getParam('tenant');
				$session['step1Subtitle']='ASIC Application';
				$this->redirect(array('preregistration/asicOnlinePrivacyPolicy'));
			}
			//Yii::app()->end();
		}
		
		else {
			unset($session['tenant']);
		}

		$model = new TenantSelection();
		

		if(isset($_POST['TenantSelection']))
		{
			$model->attributes=$_POST['TenantSelection'];
			if($model->validate())
			{
				$session['tenant'] = $model->tenant;
				$session['pre-page'] = 2;
				//$this->redirect(array('preregistration/entryPoint'));
				$this->redirect(array('preregistration/appType'));
			}
		}
		$this->render('index',array('model'=>$model));
	}
	public function actionScan()
	{
		$this->render('scan');
		 //$this->redirect('http://192.168.1.6/uploads/UTS/scan.php');
		//require '192.168.1.6/uploads/UTS/scan.php';
	}
	public function actionAppType(){
		$session = new CHttpSession;
		$session['stepTitle'] = 'AIRPORT VISITOR REGISTRATION';
		$session['step1Subtitle'] = "<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration'></a>";
		if(isset($session['step2Subtitle']))
		{
			unset($session['step2Subtitle']);
		}
		$model = new AppType();

		if(isset($_POST['AppType']))
		{
		 if($_POST['AppType']['apptype']=='2')
		 {
			 $this->redirect(array('preregistration/entryPoint'));
		 }
		 elseif($_POST['AppType']['apptype']=='1')
		 {
			 $this->redirect(array('preregistration/asicOnlinePrivacyPolicy'));
		 }
		}
		$this->render('application-selection',array('model'=>$model));
	}
	public function actionAsicOnlinePrivacyPolicy()
	{
		$session = new CHttpSession;
		$session['stepTitle'] = 'ASIC APPLICATION REQUIREMENTS';
		$session['step2Subtitle'] = "&nbsp;&nbsp;>&nbsp;&nbsp;"."<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration/asicOnlinePrivacyPolicy'>ASIC Application Requirements</a>";

		$this->render('asic-online-privacy-policy');
	}
	public function actionAsicFee()
	{
		$session = new CHttpSession;
		$session['stepTitle'] = 'ASIC ONLINE APPLICATION FEES';
		$session['step3Subtitle'] = "&nbsp;&nbsp;>&nbsp;&nbsp;"."<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration/asicFee'>Application Fees & Charges</a>";
		if(!isset($session['AsicprivacyPolicy']) && $session['AsicprivacyPolicy'] == ""){$session['AsicprivacyPolicy'] = 'checked';}
		
		if((isset(Yii::app()->user->id) && !empty(Yii::app()->user->id)) || (isset($session['em']) && $session['em']!=''))  
		{
			if(isset(Yii::app()->user->id) && !empty(Yii::app()->user->id))
			$email=Registration::model()->findByPk(Yii::app()->user->id)->email;
			else if (isset($session['em']) && $session['em']!='')
			$email=$session['em'];	
			$check=new RegistrationAsic();
			$existmode=$check->exists("( email = '{$email}' AND is_saved=1)");
			if($existmode)
			{
				
			$mode=$check->find("( email = '{$email}' AND is_saved=1)");
			
			if($mode->is_saved==1)
			{
				$asicinfo=new AsicInfo();
				if($mode->application_type=='New')
				{
					$session['Asictype']=1;
					
					$exist=$asicinfo->exists('asic_applicant_id='.$mode->id.'');
					//Yii::app()->end();
					if($exist)
					{
					 $info=$asicinfo->find('asic_applicant_id='.$mode->id);
					 if($mode->acc_name!='')
					 $session['Accname']=$mode->acc_name;
					 if($mode->acc_bsb!='')
					 $session['Bsb']=$mode->acc_bsb;
				     if($mode->acc_number!='')
					 $session['Accno']=$mode->acc_number;
					if($info->paid_by!='' && $info->paid_by=='Company')
					 $session['paidby']=1;
				    if($info->paid_by!='' && $info->paid_by=='Cardholder')
					 $session['paidby']=2;
					}
					
					
				}
				if($mode->application_type=='Renew')
				{
					$session['Asictype']=2;
					$exist=$asicinfo->exists('asic_applicant_id='.$mode->id.'');
					if($exist)
					{
					 $info=$asicinfo->find('asic_applicant_id='.$mode->id);
					 if($mode->acc_name!='')
					 $session['Accname']=$mode->acc_name;
					 if($mode->acc_bsb!='')
					 $session['Bsb']=$mode->acc_bsb;
				     if($mode->acc_number!='')
					 $session['Accno']=$mode->acc_number;
					if($info->fee!='' && $info->fee==333)
					 $session['BondPaid']=2;
				    if($info->fee!='' && $info->fee==283)
					 $session['BondPaid']=1;
				     if($info->paid_by!='' && $info->paid_by=='Company')
					 $session['paidby']=1;
				    if($info->paid_by!='' && $info->paid_by=='Cardholder')
					 $session['paidby']=2;
					}
					
				}
				if($mode->application_type=='Replacement')
				{
					$session['Asictype']=3;
					$exist=$asicinfo->exists('asic_applicant_id='.$mode->id.'');
					if($exist)
					{
					 $info=$asicinfo->find('asic_applicant_id='.$mode->id);
					 if($mode->acc_name!='')
					 $session['Accname']=$mode->acc_name;
					 if($mode->acc_bsb!='')
					 $session['Bsb']=$mode->acc_bsb;
				     if($mode->acc_number!='')
					 $session['Accno']=$mode->acc_number;
					if($info->fee!='' && $info->fee==154)
					 $session['BondPaid']=2;
				    if($info->fee!='' && $info->fee==104)
					 $session['BondPaid']=1;
				     if($info->paid_by!='' && $info->paid_by=='Company')
					 $session['paidby']=1;
				    if($info->paid_by!='' && $info->paid_by=='Cardholder')
					 $session['paidby']=2;
					}
				}
			}
			
		}
			
	}
		$model=new AsicType();
		
		//Yii::app()->end();
		if(isset($_POST['AsicType']))
		{
			
			$session['Asictype']=$_POST['AsicType']['radiobutton'];
			
			if(isset($_POST['AsicType']['renewal']))
			{
			$session['BondPaid']=$_POST['AsicType']['renewal'];
			}
			else
			{
			$session['BondPaid']='';	
			}
			$session['Accname']=$_POST['AsicType']['accname'];
			$session['Bsb']=$_POST['AsicType']['bsb'];
			$session['Accno']=$_POST['AsicType']['accno'];
			$session['paidby']=$_POST['AsicType']['radiobutton2'];

			
			 $this->redirect(array('preregistration/conditionOfUse'));
		}
		$this->render('asic-fee',array('model'=>$model));
	}
	public function actionConditionOfUse()
	{
		$session = new CHttpSession;
		$session['stepTitle'] = 'CONDITIONS OF USE';
		$session['step4Subtitle'] = "&nbsp;&nbsp;>&nbsp;&nbsp;"."<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration/conditionOfUse'>Conditions</a>";
		if((isset(Yii::app()->user->id) && !empty(Yii::app()->user->id)) || (isset($session['em']) && $session['em']!=''))
		{
			
			if(isset(Yii::app()->user->id) && !empty(Yii::app()->user->id))
			$email=Registration::model()->findByPk(Yii::app()->user->id)->email;
			else if (isset($session['em']) && $session['em']!='')
			$email=$session['em'];	
			$check=new RegistrationAsic();
			$existmode=$check->exists("( email = '{$email}' AND is_saved=1)");
			if($existmode)
			{
				
			$mode=$check->find("( email = '{$email}' AND is_saved=1)");
				if($mode->condition_of_use==1 && $mode->aus_check==1)
				{
				$session['Crime1']=2;
				$session['Crime2']=2;
				$session['Crime3']=2;
				$session['Crime4']=2;
				$session['use1']=1;
				$session['use2']=1;
				$session['use3']=1;
				}
			}
		}
		$model=new CriminalCheck();
		if(isset($_POST['CriminalCheck']))
		{
			
			$session['Crime1']=$_POST['CriminalCheck']['radiobutton1'];
			$session['Crime2']=$_POST['CriminalCheck']['radiobutton2'];
			$session['Crime3']=$_POST['CriminalCheck']['radiobutton3'];
			$session['Crime4']=$_POST['CriminalCheck']['radiobutton4'];
			$session['use1']=$_POST['CriminalCheck']['check1'];
			$session['use2']=$_POST['CriminalCheck']['check2'];
			$session['use3']=$_POST['CriminalCheck']['check3'];
			if($session['Crime1']==1||$session['Crime2']==1||$session['Crime3']==1||$session['Crime4']==1)
			{
				$this->redirect(array('preregistration/Stop'));
			}
			
			$this->redirect(array('preregistration/asicType'));
		}
		$this->render('condition-use',array('model'=>$model));
	}
	public function actionAsicType(){
		$session = new CHttpSession;
		$session['stepTitle'] = 'ASIC INFORMATION';
		$session['step5Subtitle'] = "&nbsp;&nbsp;>&nbsp;&nbsp;"."<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration/asicType'>Asic Info </a>";
		if(!isset($session['conditions']) && $session['conditions'] == ""){$session['conditions'] = 'checked';}
		$model = new AsicInfo();
		if((isset(Yii::app()->user->id) && !empty(Yii::app()->user->id)) || (isset($session['em']) && $session['em']!=''))
		{
			
			if(isset(Yii::app()->user->id) && !empty(Yii::app()->user->id))
			$email=Registration::model()->findByPk(Yii::app()->user->id)->email;
			else if (isset($session['em']) && $session['em']!='')
			$email=$session['em'];	
			$check=new RegistrationAsic();
			$existmode=$check->exists("( email = '{$email}' AND is_saved=1)");
			if($existmode)
			{
				
			$mode=$check->find("( email = '{$email}' AND is_saved=1)");
			$exist=$model->exists('asic_applicant_id='.$mode->id.'');
					if($exist)
					{
					 $model=$model->find('asic_applicant_id='.$mode->id);
					// print_r($model);
					 //Yii::app()->end();
					}
			}
		}
		
		if(isset($session['AsicInfo-details']))
			{
				$model=$session['AsicInfo-details'];
				
				
			}
		//print_r($_POST);
		if(isset($_POST['AsicInfo']))
		{
			
			$model->attributes=$_POST['AsicInfo'];
				
				$session['AsicInfo-details']=$model;
				
			$this->redirect(array('preregistration/personalAsicOnline'));
		}
		//if(isset($session['Asictype']))
	    //$this->render('asic-type',array('model'=>$model,'asicType'=>$session['Asictype']));
		//else
		$this->render('asic-type',array('model'=>$model));	
	}
	public function actionPersonalAsicOnline()
	{
		$session = new CHttpSession;
		$session['stepTitle'] = 'PERSONAL INFORMATION';
		$session['step5Subtitle'] = "&nbsp;&nbsp;>&nbsp;&nbsp;"."<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration/personalDetails'>Personal Information</a>";
		unset($session['vic_model']);
		
		
			$model = new RegistrationAsic();	
			$addHistory= new AsicAddressHistory();
			
			$error_message = '';
			if((isset(Yii::app()->user->id) && !empty(Yii::app()->user->id)) || (isset($session['em']) && $session['em']!=''))
		{
			
			if(isset(Yii::app()->user->id) && !empty(Yii::app()->user->id))
			$email=Registration::model()->findByPk(Yii::app()->user->id)->email;
			else if (isset($session['em']) && $session['em']!='')
			$email=$session['em'];	
			$check=new RegistrationAsic();
			$existmode=$check->exists("( email = '{$email}' AND is_saved=1)");
				if($existmode)
				{
				
				$model=$check->find("( email = '{$email}' AND is_saved=1)");
				}
				$historycheck=$addHistory->exists('asic_applicant_id='.$model->id.'');
				if($historycheck)
				{
					$history=$addHistory->findAll('asic_applicant_id='.$model->id);
					
					foreach($history as $value)
					{
						if($value->unit==null)
						$unit[]='';
						else
						$unit[]=$value->unit;
						$stno[]=$value->street_number;
						$stnm[]=$value->street_name;
						$sttype[]=$value->street_type;
						$sub[]=$value->suburb;
						$city[]=$value->city;
						$pstcd[]=$value->postcode;
						$state[]=$value->state;
						$cntry[]=$value->country;
						$frm[]=date('d-m-Y',strtotime($value->from_date));
						$to[]=date('d-m-Y',strtotime($value->to_date));
					}
					if(!isset($session['AddHistory']))
					{
					$session['AddHistory']=array(
						'unit'=>$unit,
						'stno'=>$stno,
						'stnm'=>$stnm,
						'sttype'=>$sttype,
						'sub'=>$sub,
						'city'=>$city,
						'pstcd'=>$pstcd,
						'state'=>$state,
						'cntry'=>$cntry,
						'frm'=>$frm,
						'to'=>$to,
						);
					}
				}
				
			}
		
			if(isset($session['asicapplicant-details']))
			{
				$model=$session['asicapplicant-details'];
				
				
			}
			//----------------------------------------------------------------------------Save and Exit-----------------------------------------------------------------------------//
			if(isset($_POST['save']))
			{
				$model->setScenario('save');
				
				$model->attributes=$_POST['RegistrationAsic'];
				
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
					
					$modelInfo = new AsicInfo();
					$modelInfo=$session['AsicInfo-details'];
					if($session['Asictype']==1)
					{
						$modelInfo->fee=333;
						if(isset($session['paidby']) && $session['paidby']==1)
						$modelInfo->paid_by='Company';
						else
						$modelInfo->paid_by='Cardholder';
							if(isset($session['Accname']) && $session['Accname']!='' && isset($session['Bsb']) && $session['Bsb']!='' && isset($session['Accno']) && $session['Accno']!='')
							{
							$model->acc_name=$session['Accname'];
							$model->acc_bsb=$session['Bsb'];
							$model->acc_number=$session['Accno'];
							
							}
							if($session['Crime1']==2 && $session['Crime2']==2 && $session['Crime3']==2 && $session['Crime4']==2 && $session['use1']==1 && $session['use2']==1 && $session['use3']==1)
							{
							$model->condition_of_use=1;
							$model->aus_check=1;
							$model->tenant=$session['tenant'];
							}
							
							$model->date_of_birth=date('Y-m-d',strtotime($_POST['RegistrationAsic']['date_of_birth']));
							$model->application_type='New';
							/*echo "<pre>";
							print_r($model->date_of_birth);
							echo "</pre>";
							Yii::app()->end();*/
					}
					if($session['Asictype']==2)
					{
						if($session['BondPaid']==1)
						{
							$modelInfo->fee=283;
						}
						else
						$modelInfo->fee=333;
						
						if(isset($session['paidby']) && $session['paidby']==1)
						$modelInfo->paid_by='Company';
						else
						$modelInfo->paid_by='Cardholder';
					if(isset($session['Accname']) && $session['Accname']!='' && isset($session['Bsb']) && $session['Bsb']!='' && isset($session['Accno']) && $session['Accno']!='')
							{
							$model->acc_name=$session['Accname'];
							$model->acc_bsb=$session['Bsb'];
							$model->acc_number=$session['Accno'];
							
							}
							if($session['Crime1']==2 && $session['Crime2']==2 && $session['Crime3']==2 && $session['Crime4']==2 && $session['use1']==1 && $session['use2']==1 && $session['use3']==1)
							{
							$model->condition_of_use=1;
							$model->aus_check=1;
							$model->tenant=$session['tenant'];
							}
							$model->date_of_birth=date('Y-m-d',strtotime($_POST['RegistrationAsic']['date_of_birth']));
							$model->application_type='Renew';
					}
					if($session['Asictype']==3)
					{
						
						if($session['BondPaid']==1)
						{
							$modelInfo->fee=104;
						}
						else
						$modelInfo->fee=154;
					
						if(isset($session['paidby']) && $session['paidby']==1)
						$modelInfo->paid_by='Company';
						else
						$modelInfo->paid_by='Cardholder';
							if(isset($session['Accname']) && $session['Accname']!='' && isset($session['Bsb']) && $session['Bsb']!='' && isset($session['Accno']) && $session['Accno']!='')
							{
							$model->acc_name=$session['Accname'];
							$model->acc_bsb=$session['Bsb'];
							$model->acc_number=$session['Accno'];
							
							}
							if($session['Crime1']==2 && $session['Crime2']==2 && $session['Crime3']==2 && $session['Crime4']==2 && $session['use1']==1 && $session['use2']==1 && $session['use3']==1)
							{
							$model->condition_of_use=1;
							$model->aus_check=1;
							$model->tenant=$session['tenant'];
							}
						$model->date_of_birth=date('Y-m-d',strtotime($_POST['RegistrationAsic']['date_of_birth']));
						$model->application_type='Replacement';
						
					}
					
					if(isset($_POST['unit']) && isset($_POST['stno']) && isset($_POST['stnm']) && isset($_POST['sttype']) && isset($_POST['sub']) && isset($_POST['pstcd']) && isset($_POST['state']) && isset($_POST['cntry']) && isset($_POST['frm']) && isset($_POST['to']) )
					{
						$session['AddHistory']=array(
						'unit'=>$_POST['unit'],
						'stno'=>$_POST['stno'],
						'stnm'=>$_POST['stnm'],
						'sttype'=>$_POST['sttype'],
						'sub'=>$_POST['sub'],
						'city'=>$_POST['city'],
						'pstcd'=>$_POST['pstcd'],
						'state'=>$_POST['state'],
						'cntry'=>$_POST['cntry'],
						'frm'=>$_POST['frm'],
						'to'=>$_POST['to'],
						);
						
						
					}
					$model->is_saved=1;
					if(isset($_POST['RegistrationAsic']['from_date']))
					$model->from_date=date('Y-m-d',strtotime($_POST['RegistrationAsic']['from_date']));
					if($model->save())
					{
						if(isset($session['AddHistory']))
						{
						$asic_address=new AsicAddressHistory();
							$x=count($session['AddHistory']['unit']);
								for($i=0;$i<$x;$i++)
								{
									if(!$asic_address->exists("( asic_applicant_id = '{$model->id}' AND street_name='{$session['AddHistory']['stnm'][$i]}' AND street_number='{$session['AddHistory']['stno'][$i]}')"))
										{
									$asic_address->asic_applicant_id=$model->id;
									$asic_address->unit=$session['AddHistory']['unit'][$i];
									$asic_address->street_number=$session['AddHistory']['stno'][$i];
									$asic_address->street_name=$session['AddHistory']['stnm'][$i];
									$asic_address->street_type=$session['AddHistory']['sttype'][$i];
									$asic_address->suburb=$session['AddHistory']['sub'][$i];
									$asic_address->city=$session['AddHistory']['city'][$i];
									$asic_address->postcode=$session['AddHistory']['pstcd'][$i];
									$asic_address->state=$session['AddHistory']['state'][$i];
									$asic_address->country=$session['AddHistory']['cntry'][$i];
									$asic_address->from_date=date('Y-m-d',strtotime($session['AddHistory']['frm'][$i]));
									$asic_address->to_date=date('Y-m-d',strtotime($session['AddHistory']['to'][$i]));
									$asic_address->created_at=date('Y-m-d');
									$asic_address->isNewRecord = true;
									$asic_address->setPrimaryKey(NULL);
									$asic_address->save();	
										}
									
									
								}
						}
						$modelInfo->asic_applicant_id=$model->id;
						if($modelInfo->save(false))
						{
							Yii::app()->session->clear();
							$this->redirect(array('preregistration/saved'));
						}
					}
					
					
				
			}
			
		//-----------------------------------------------------------------------------------End Save and Exit--------------------------------------------------------------//		
			
			if(isset($_POST['RegistrationAsic']) && !isset($_POST['save']))
			{
				$model->setScenario('');
				$model->attributes=$_POST['RegistrationAsic'];
				
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
				$session['asicapplicant-details']=$model;
				if(!$model->validate())
				{
					print_r($model->getErrors());
					
					Yii::app()->end();
				}
				else
				{ 
					
					if(isset($_POST['unit']) && isset($_POST['stno']) && isset($_POST['stnm']) && isset($_POST['sttype']) && isset($_POST['sub']) && isset($_POST['pstcd']) && isset($_POST['state']) && isset($_POST['cntry']) && isset($_POST['frm']) && isset($_POST['to']) )
					$session['AddHistory']=array(
					'unit'=>$_POST['unit'],
					'stno'=>$_POST['stno'],
					'stnm'=>$_POST['stnm'],
					'sttype'=>$_POST['sttype'],
					'sub'=>$_POST['sub'],
					'city'=>$_POST['city'],
					'pstcd'=>$_POST['pstcd'],
					'state'=>$_POST['state'],
					'cntry'=>$_POST['cntry'],
					'frm'=>$_POST['frm'],
					'to'=>$_POST['to'],
					);
					
					
					$this->redirect(array('preregistration/immiInfo'));
				}
			}
		
		//print_r($model->getErrors());
					//Yii::app()->end();
		//if(!isset($_POST['save']))
		$this->render('asic-personal-info' , array('model' => $model,'addHistory'=>$addHistory,'error_message' => $error_message));
	}
	
	
	public function actionImmiInfo()
	{
		$session = new CHttpSession;
		$session['stepTitle'] = 'IMMIGRATION INFORMATION';
		$session['step7Subtitle'] = "&nbsp;&nbsp;>&nbsp;&nbsp;"."<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration/immiInfo'>Immigration Information</a>";
		
			$model = new Immigration();	
			//$model->scenario = 'preregistration';
			$error_message = '';
		//echo "here";
		if((isset(Yii::app()->user->id) && !empty(Yii::app()->user->id)) || (isset($session['em']) && $session['em']!=''))
		{
			
			if(isset(Yii::app()->user->id) && !empty(Yii::app()->user->id))
			$email=Registration::model()->findByPk(Yii::app()->user->id)->email;
			else if (isset($session['em']) && $session['em']!='')
			$email=$session['em'];	
			$check=new RegistrationAsic();
			$existmode=$check->exists("( email = '{$email}' AND is_saved=1)");
			if($existmode)
			{
				
			$mode=$check->find("( email = '{$email}' AND is_saved=1)");
			$exist=$model->exists('asic_applicant_id='.$mode->id.'');
					if($exist)
					{
					 $model=$model->find('asic_applicant_id='.$mode->id);
					}
			}
		}
		if(isset($session['asicapplicant-details']))
			{
				//$modelAsic=new RegistrationAsic();
				$modelAsic=$session['asicapplicant-details'];
				
				
			}
			if(isset($session['immi-details']))
			{
				//$modelAsic=new RegistrationAsic();
				$model=$session['immi-details'];
				
				
			}
			
			//----------------------------------------------------------------------------Save and Exit-----------------------------------------------------------------------------//
			if(isset($_POST['save']))
			{
				$model->setScenario('save');
				$modelAsic=$session['asicapplicant-details'];
				$model->attributes=$_POST['Immigration'];
					
					$modelInfo = new AsicInfo();
					$modelInfo=$session['AsicInfo-details'];
					if($session['Asictype']==1)
					{
						$modelInfo->fee=333;
						if(isset($session['paidby']) && $session['paidby']==1)
						$modelInfo->paid_by='Company';
						else
						$modelInfo->paid_by='Cardholder';
							if(isset($session['Accname']) && $session['Accname']!='' && isset($session['Bsb']) && $session['Bsb']!='' && isset($session['Accno']) && $session['Accno']!='')
							{
							$modelAsic->acc_name=$session['Accname'];
							$modelAsic->acc_bsb=$session['Bsb'];
							$modelAsic->acc_number=$session['Accno'];
							
							}
							if($session['Crime1']==2 && $session['Crime2']==2 && $session['Crime3']==2 && $session['Crime4']==2 && $session['use1']==1 && $session['use2']==1 && $session['use3']==1)
							{
							$modelAsic->condition_of_use=1;
							$modelAsic->aus_check=1;
							$modelAsic->tenant=$session['tenant'];
							}
							
							$modelAsic->date_of_birth=date('Y-m-d',strtotime($session['asicapplicant-details']->date_of_birth));
							$modelAsic->application_type='New';
							/*echo "<pre>";
							print_r($model->date_of_birth);
							echo "</pre>";
							Yii::app()->end();*/
					}
					if($session['Asictype']==2)
					{
						if($session['BondPaid']==1)
						{
							$modelInfo->fee=283;
						}
						else
						$modelInfo->fee=333;
						
						if(isset($session['paidby']) && $session['paidby']==1)
						$modelInfo->paid_by='Company';
						else
						$modelInfo->paid_by='Cardholder';
					if(isset($session['Accname']) && $session['Accname']!='' && isset($session['Bsb']) && $session['Bsb']!='' && isset($session['Accno']) && $session['Accno']!='')
							{
							$modelAsic->acc_name=$session['Accname'];
							$modelAsic->acc_bsb=$session['Bsb'];
							$modelAsic->acc_number=$session['Accno'];
							
							}
							if($session['Crime1']==2 && $session['Crime2']==2 && $session['Crime3']==2 && $session['Crime4']==2 && $session['use1']==1 && $session['use2']==1 && $session['use3']==1)
							{
							$modelAsic->condition_of_use=1;
							$modelAsic->aus_check=1;
							$modelAsic->tenant=$session['tenant'];
							}
							$modelAsic->date_of_birth=date('Y-m-d',strtotime($session['asicapplicant-details']->date_of_birth));
							$modelAsic->application_type='Renew';
					}
					if($session['Asictype']==3)
					{
						
						if($session['BondPaid']==1)
						{
							$modelInfo->fee=104;
						}
						else
						$modelInfo->fee=154;
					
						if(isset($session['paidby']) && $session['paidby']==1)
						$modelInfo->paid_by='Company';
						else
						$modelInfo->paid_by='Cardholder';
							if(isset($session['Accname']) && $session['Accname']!='' && isset($session['Bsb']) && $session['Bsb']!='' && isset($session['Accno']) && $session['Accno']!='')
							{
							$modelAsic->acc_name=$session['Accname'];
							$modelAsic->acc_bsb=$session['Bsb'];
							$modelAsic->acc_number=$session['Accno'];
							
							}
							if($session['Crime1']==2 && $session['Crime2']==2 && $session['Crime3']==2 && $session['Crime4']==2 && $session['use1']==1 && $session['use2']==1 && $session['use3']==1)
							{
							$modelAsic->condition_of_use=1;
							$modelAsic->aus_check=1;
							$modelAsic->tenant=$session['tenant'];
							}
						$modelAsic->date_of_birth=date('Y-m-d',strtotime($session['asicapplicant-details']->date_of_birth));
						$modelAsic->application_type='Replacement';
						
					}
					
					
					$modelAsic->is_saved=1;
					if($session['asicapplicant-details']->from_date!='')
					$modelAsic->from_date=date('Y-m-d',strtotime($session['asicapplicant-details']->from_date));
					if($modelAsic->save(false))
					{
						if(isset($session['AddHistory']))
						{
						$asic_address=new AsicAddressHistory();
							$x=count($session['AddHistory']['unit']);
								for($i=0;$i<$x;$i++)
								{
									if(!$asic_address->exists("( asic_applicant_id = '{$modelAsic->id}' AND street_name='{$session['AddHistory']['stnm'][$i]}' AND street_number='{$session['AddHistory']['stno'][$i]}')"))
										{
									$asic_address->asic_applicant_id=$modelAsic->id;
									$asic_address->unit=$session['AddHistory']['unit'][$i];
									$asic_address->street_number=$session['AddHistory']['stno'][$i];
									$asic_address->street_name=$session['AddHistory']['stnm'][$i];
									$asic_address->street_type=$session['AddHistory']['sttype'][$i];
									$asic_address->suburb=$session['AddHistory']['sub'][$i];
									$asic_address->city=$session['AddHistory']['city'][$i];
									$asic_address->postcode=$session['AddHistory']['pstcd'][$i];
									$asic_address->state=$session['AddHistory']['state'][$i];
									$asic_address->country=$session['AddHistory']['cntry'][$i];
									$asic_address->from_date=date('Y-m-d',strtotime($session['AddHistory']['frm'][$i]));
									$asic_address->to_date=date('Y-m-d',strtotime($session['AddHistory']['to'][$i]));
									$asic_address->created_at=date('Y-m-d');
									$asic_address->isNewRecord = true;
									$asic_address->setPrimaryKey(NULL);
									$asic_address->save();	
										}
									
									
								}
						}
						if(isset($_POST['Immigration']['arrival_date']))
						$model->arrival_date=date('Y-m-d',strtotime($_POST['Immigration']['arrival_date']));
						$modelInfo->asic_applicant_id=$modelAsic->id;
						$model->asic_applicant_id=$modelAsic->id;
						if($modelInfo->save(false) && $model->save())
						{
							Yii::app()->session->clear();
							$this->redirect(array('preregistration/saved'));
						}
					}
					
					
				
			}
			//-----------------------------------------------------------------------------------------Save & Exit End----------------------------------------------
		if(isset($_POST['Immigration']) && !isset($_POST['save']))
		{
			$model->attributes=$_POST['Immigration'];
			$session['immi-details']=$model;
			
			$this->redirect(array('preregistration/identificationAsicOnline'));
		}
		//$preModel = new PreregLogin();
		$this->render('immigration-info' , array('model' => $model,'modelAsic' => $modelAsic,'error_message' => $error_message));
	}
	public function actionIdentificationAsicOnline()
	{
		$session = new CHttpSession;
		$session['stepTitle'] = 'IDENTIFICATION VERIFICATION';
		$session['step8Subtitle'] = "&nbsp;&nbsp;>&nbsp;&nbsp;"."<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration/identificationAsicOnline'>Identification Verification</a>";
		unset($session['vic_model']);
		//echo "here";
		//Yii::app()->end();
			$model = new RegistrationAsic();	
			//$model->scenario = 'preregistration';
		if((isset(Yii::app()->user->id) && !empty(Yii::app()->user->id)) || (isset($session['em']) && $session['em']!=''))
		{
			
			if(isset(Yii::app()->user->id) && !empty(Yii::app()->user->id))
			$email=Registration::model()->findByPk(Yii::app()->user->id)->email;
			else if (isset($session['em']) && $session['em']!='')
			$email=$session['em'];	
			$check=new RegistrationAsic();
			$existmode=$check->exists("( email = '{$email}' AND is_saved=1)");
			if($existmode)
			{
				
			$model=$check->find("( email = '{$email}' AND is_saved=1)");
			
			}
		}
			
			$error_message = '';
		//----------------------------------------------------------------------------Save and Exit-----------------------------------------------------------------------------//
			if(isset($_POST['save']))
			{
				$model->setScenario('save');
				$model=$session['asicapplicant-details'];
				$modelImmi=$session['immi-details'];
				if( $model->upload_1!='')
				$up1=$model->upload_1;
				if( $model->upload_2!='')
				$up2=$model->upload_2;
				if( $model->upload_3!='')
				$up3=$model->upload_3;
				if( $model->upload_4!='')
				$up4=$model->upload_4;
				$model->attributes=$_POST['RegistrationAsic'];
				
				if($_FILES['RegistrationAsic']['name']['upload_1']!='')
				$model->upload_1=$_FILES['RegistrationAsic']['name']['upload_1'];
				elseif(isset($up1) && $up1!='')
				{
					$model->upload_1=$up1;
				}
				if($_FILES['RegistrationAsic']['name']['upload_2']!='')
				$model->upload_2=$_FILES['RegistrationAsic']['name']['upload_2'];
				elseif(isset($up2) && $up2!='')
				{
					$model->upload_2=$up2;
				}
				if($_FILES['RegistrationAsic']['name']['upload_3']!='')
				$model->upload_3=$_FILES['RegistrationAsic']['name']['upload_3'];
				elseif(isset($up3) && $up3!='')
				{
					$model->upload_3=$up3;
				}
				if($_FILES['RegistrationAsic']['name']['upload_4']!='')
				$model->upload_4=$_FILES['RegistrationAsic']['name']['upload_4'];
				elseif(isset($up4) && $up4!='')
				{
					$model->upload_4=$up4;
				}
				$target_dir= Yii::getPathOfAlias('webroot').'/uploads/files/asic_uploads/';
				if($_FILES['RegistrationAsic']['name']['upload_1']!='')
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
				if($_FILES['RegistrationAsic']['name']['upload_2']!='')
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
				if($_FILES['RegistrationAsic']['name']['upload_3']!='')
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
				if($_FILES['RegistrationAsic']['name']['upload_4']!='')
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
				if($_POST['RegistrationAsic']['check2']==1)
				{
					$session['checked']=1;
				}
				else
				{
					$session['checked']=0;
				}
				
					
					$modelInfo = new AsicInfo();
					$modelInfo=$session['AsicInfo-details'];
					if($session['Asictype']==1)
					{
						$modelInfo->fee=333;
						if(isset($session['paidby']) && $session['paidby']==1)
						$modelInfo->paid_by='Company';
						else
						$modelInfo->paid_by='Cardholder';
							if(isset($session['Accname']) && $session['Accname']!='' && isset($session['Bsb']) && $session['Bsb']!='' && isset($session['Accno']) && $session['Accno']!='')
							{
							$model->acc_name=$session['Accname'];
							$model->acc_bsb=$session['Bsb'];
							$model->acc_number=$session['Accno'];
							
							}
							if($session['Crime1']==2 && $session['Crime2']==2 && $session['Crime3']==2 && $session['Crime4']==2 && $session['use1']==1 && $session['use2']==1 && $session['use3']==1)
							{
							$model->condition_of_use=1;
							$model->aus_check=1;
							$model->tenant=$session['tenant'];
							}
							
							$model->date_of_birth=date('Y-m-d',strtotime($session['asicapplicant-details']->date_of_birth));
							$model->application_type='New';
							/*echo "<pre>";
							print_r($model->date_of_birth);
							echo "</pre>";
							Yii::app()->end();*/
					}
					if($session['Asictype']==2)
					{
						if($session['BondPaid']==1)
						{
							$modelInfo->fee=283;
						}
						else
						$modelInfo->fee=333;
						
						if(isset($session['paidby']) && $session['paidby']==1)
						$modelInfo->paid_by='Company';
						else
						$modelInfo->paid_by='Cardholder';
					if(isset($session['Accname']) && $session['Accname']!='' && isset($session['Bsb']) && $session['Bsb']!='' && isset($session['Accno']) && $session['Accno']!='')
							{
							$model->acc_name=$session['Accname'];
							$model->acc_bsb=$session['Bsb'];
							$model->acc_number=$session['Accno'];
							
							}
							if($session['Crime1']==2 && $session['Crime2']==2 && $session['Crime3']==2 && $session['Crime4']==2 && $session['use1']==1 && $session['use2']==1 && $session['use3']==1)
							{
							$model->condition_of_use=1;
							$model->aus_check=1;
							$model->tenant=$session['tenant'];
							}
							$model->date_of_birth=date('Y-m-d',strtotime($session['asicapplicant-details']->date_of_birth));
							$model->application_type='Renew';
					}
					if($session['Asictype']==3)
					{
						
						if($session['BondPaid']==1)
						{
							$modelInfo->fee=104;
						}
						else
						$modelInfo->fee=154;
					
						if(isset($session['paidby']) && $session['paidby']==1)
						$modelInfo->paid_by='Company';
						else
						$modelInfo->paid_by='Cardholder';
							if(isset($session['Accname']) && $session['Accname']!='' && isset($session['Bsb']) && $session['Bsb']!='' && isset($session['Accno']) && $session['Accno']!='')
							{
							$model->acc_name=$session['Accname'];
							$model->acc_bsb=$session['Bsb'];
							$model->acc_number=$session['Accno'];
							
							}
							if($session['Crime1']==2 && $session['Crime2']==2 && $session['Crime3']==2 && $session['Crime4']==2 && $session['use1']==1 && $session['use2']==1 && $session['use3']==1)
							{
							$model->condition_of_use=1;
							$model->aus_check=1;
							$model->tenant=$session['tenant'];
							}
						$model->date_of_birth=date('Y-m-d',strtotime($session['asicapplicant-details']->date_of_birth));
						$model->application_type='Replacement';
						
					}
					
					
							$model->is_saved=1;
							if($session['asicapplicant-details']->from_date!='')
							$model->from_date=date('Y-m-d',strtotime($session['asicapplicant-details']->from_date));
							if(isset($_POST['RegistrationAsic']['primary_id_expiry']) && $_POST['RegistrationAsic']['primary_id_expiry']!='')
							$model->primary_id_expiry=date('Y-m-d',strtotime($_POST['RegistrationAsic']['primary_id_expiry']));
							if(isset($_POST['RegistrationAsic']['secondary_id_expiry']) && $_POST['RegistrationAsic']['secondary_id_expiry']!='')
							$model->secondary_id_expiry=date('Y-m-d',strtotime($_POST['RegistrationAsic']['secondary_id_expiry']));
							if(isset($_POST['RegistrationAsic']['tertiary_id1_expiry']) && $_POST['RegistrationAsic']['tertiary_id1_expiry']!='')
							$model->tertiary_id1_expiry=date('Y-m-d',strtotime($_POST['RegistrationAsic']['tertiary_id1_expiry']));
							if(isset($_POST['RegistrationAsic']['tertiary_id2_expiry']) && $_POST['RegistrationAsic']['tertiary_id2_expiry']!='')
							$model->tertiary_id2_expiry=date('Y-m-d',strtotime($_POST['RegistrationAsic']['tertiary_id2_expiry']));
						
					if($model->save())
					{
						if(isset($session['AddHistory']))
						{
						$asic_address=new AsicAddressHistory();
							$x=count($session['AddHistory']['unit']);
								for($i=0;$i<$x;$i++)
								{
									if(!$asic_address->exists("( asic_applicant_id = '{$model->id}' AND street_name='{$session['AddHistory']['stnm'][$i]}' AND street_number='{$session['AddHistory']['stno'][$i]}')"))
										{
									$asic_address->asic_applicant_id=$model->id;
									$asic_address->unit=$session['AddHistory']['unit'][$i];
									$asic_address->street_number=$session['AddHistory']['stno'][$i];
									$asic_address->street_name=$session['AddHistory']['stnm'][$i];
									$asic_address->street_type=$session['AddHistory']['sttype'][$i];
									$asic_address->suburb=$session['AddHistory']['sub'][$i];
									$asic_address->city=$session['AddHistory']['city'][$i];
									$asic_address->postcode=$session['AddHistory']['pstcd'][$i];
									$asic_address->state=$session['AddHistory']['state'][$i];
									$asic_address->country=$session['AddHistory']['cntry'][$i];
									$asic_address->from_date=date('Y-m-d',strtotime($session['AddHistory']['frm'][$i]));
									$asic_address->to_date=date('Y-m-d',strtotime($session['AddHistory']['to'][$i]));
									$asic_address->created_at=date('Y-m-d');
									$asic_address->isNewRecord = true;
									$asic_address->setPrimaryKey(NULL);
									$asic_address->save();	
										}
									
									
								}
						}
						$modelInfo->asic_applicant_id=$model->id;
						$modelImmi->asic_applicant_id=$model->id;
						if($modelInfo->save(false) && $modelImmi->save(false))
						{
							Yii::app()->session->clear();
							$this->redirect(array('preregistration/saved'));
						}
					}
					
					
				
			}
		if(isset($_POST['RegistrationAsic']) && !isset($_POST['save']))
			{
				
				$model->attributes=$_POST['RegistrationAsic'];
				$model->upload_1=$_FILES['RegistrationAsic']['name']['upload_1'];
				$model->upload_2=$_FILES['RegistrationAsic']['name']['upload_2'];
				$model->upload_3=$_FILES['RegistrationAsic']['name']['upload_3'];
				$model->upload_4=$_FILES['RegistrationAsic']['name']['upload_4'];
				$target_dir= Yii::getPathOfAlias('webroot').'/uploads/files/asic_uploads/';
				if($_FILES['RegistrationAsic']['name']['upload_1']!='')
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
				if($_FILES['RegistrationAsic']['name']['upload_2']!='')
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
				if($_FILES['RegistrationAsic']['name']['upload_3']!='')
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
				if($_FILES['RegistrationAsic']['name']['upload_4']!='')
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
				if($_POST['RegistrationAsic']['check2']==1)
				{
					$session['checked']=1;
				}
				else
				{
					$session['checked']=0;
				}
				$session['identification_Details']=$model;
				
				$this->redirect(array('preregistration/asicOperationalNeed'));
			}
		if(isset($session['identification_Details']))
			{
				//$modelAsic=new RegistrationAsic();
				$model=$session['identification_Details'];
				
				
			}	
		//echo "here";
		$preModel = new PreregLogin();
		$this->render('identificationAsic' , array('model' => $model,'preModel' => $preModel,'error_message' => $error_message));
	}
	public function actionAsicOperationalNeed()
	{
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$session = new CHttpSession;
		$session['stepTitle'] = 'OPERATIONAL NEED';
		$session['step9Subtitle'] = "&nbsp;&nbsp;>&nbsp;&nbsp;"."<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration/asicOperationalNeed'>Operational Need</a>";
		unset($session['vic_model']);
		//echo "here";
		//Yii::app()->end();
		
			$model = new AsicOnCompany();	
			$fileModel = new RegistrationAsic();
			//$model->scenario = 'preregistration';
			$error_message = '';
		//echo "here";
		
		if(isset($_POST['AsicOnCompany']))
		{
				
			if(isset($_FILES['AsicOnCompany']['name']['authorised_file']))
				{
				
				$session['authFile']=$_FILES['AsicOnCompany']['name']['authorised_file'];
				$target_dir= Yii::getPathOfAlias('webroot').'/uploads/files/asic_uploads/';
				if($_FILES['AsicOnCompany']['name']['authorised_file']!='')
				{
					$file = $_FILES['AsicOnCompany']['name']['authorised_file'];
					$path = pathinfo($file);
					$filename = $path['filename'];
					$ext = $path['extension'];
					$temp_name = $_FILES['AsicOnCompany']['tmp_name']['authorised_file'];
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
				if(isset($_FILES['RegistrationAsic']['name']['op_need_document']))
				{
				
				$session['opFile']=$_FILES['RegistrationAsic']['name']['op_need_document'];
				$target_dir= Yii::getPathOfAlias('webroot').'/uploads/files/asic_uploads/';
				if($_FILES['RegistrationAsic']['name']['op_need_document']!='')
				{
					$file = $_FILES['RegistrationAsic']['name']['op_need_document'];
					$path = pathinfo($file);
					$filename = $path['filename'];
					$ext = $path['extension'];
					$temp_name = $_FILES['RegistrationAsic']['tmp_name']['op_need_document'];
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
			$model->attributes=$_POST['AsicOnCompany'];
			unset($session['Company_Details']);
			$session['Company_Details']=$model;
				
			$this->redirect(array('preregistration/paymentAppointment'));
		}
		if(isset($session['Company_Details']))
			{
				//$modelAsic=new RegistrationAsic();
				$model=$session['Company_Details'];
				
				
			}	
		$preModel = new PreregLogin();
		$this->render('op-need' , array('model' => $model,'preModel' => $preModel,'fileModel'=>$fileModel,'error_message' => $error_message));
		
		
	}
	 public function actionAddCompany()
    {
            $session = new CHttpSession;
            $company = new AsicOnCompany();
            //$company->scenario = 'preregistration';
       
            if (isset($_POST['AsicOnCompany'])) 
            {
                
                    $formInfo = $_POST['AsicOnCompany'];
                    $company->tenant = empty($session['tenant']) ? NULL : $session['tenant'];


                    $company->attributes=$formInfo;

                    $company->name = $formInfo['name'];
                    $company->trading_name = $formInfo['name'];
                    $company->contact = $formInfo['user_first_name'] . ' ' . $formInfo['user_last_name'];
                    $company->email_address = $formInfo['user_email'];
                    $company->mobile_number = $formInfo['user_contact_number'];
                    $company->office_number = $formInfo['office_number'];
					if($formInfo['website']!='')
					{
						$company->website=$formInfo['website'];
					}
                    $company->company_type = 3;

                    if ($company->tenant_agent == '') {$company->tenant_agent = NULL;}
                    if ($company->code == '') {$company->code = strtoupper(substr($company->name, 0, 3));}

                    if($company->validate())
                    {
                        if ($company->save()) 
                        {
                            //integrity constraint violation fix.
                            //From preregisteration set attribute from session as it was set in session 
                            //for USER because Yii:app()->user->id in preregistration has Visitor Id and not USER id.
                            //If wrong handled then it will throws Integrity Constraint Violation as foreign key 
                            //of created_by in user refers to User table and not visitor table 
                            $command = Yii::app()->db->createCommand();
                            $result=$command->insert('user',array(
                                                        //'id'=>it is autoincrement,
                                                        'company'=>$company->id,
                                                        'first_name'=>$formInfo['user_first_name'],
                                                        'last_name'=>$formInfo['user_last_name'],
                                                        'email'=>$formInfo['user_email'],
                                                        'contact_number'=>$formInfo['user_contact_number'],
                                                        'timezone_id'=>1,
                                                        'photo'=>NULL,
                                                        'tenant'=> (isset($company->tenant) && $company->tenant != "") ? $company->tenant : NULL,
                                                        'user_type'=>2,
                                                        'user_status'=>1,
                                                        'role'=>10,
                                                        'created_by'=> $company->created_by_user,//empty($session['created_by']) ? NULL : $session['created_by'],
                                                    ));
                            if ($result)
                            {
                                $Criteria = new CDbCriteria();
                                $Criteria->condition = "company = ".$company->id." and is_deleted = 0";
                                $contacts = User::model()->findAll($Criteria);

                                $dropDown = "<option selected='selected' value='" . $company->id . "' >" . $company->name . "</option>"; // seriously why is this here?
                                $ret = array("compId" =>  $company->id, "compName" => $company->name, "contacts"=>$contacts, "dropDown" => $dropDown);
                                echo CJSON::encode($ret);
                                Yii::app()->end();
                            }
                            else
                            {
                                $data = array('decision'=>0);
                                echo CJSON::encode($data);
                                Yii::app()->end();
                            }
                        }
                        else
                        {
                            //$msg = print_r($company->getErrors(),1);
                            //throw new CHttpException(400,'Not saved because: '.$msg );
                            //echo "0";
                            $errors = $company->errors;
                            $data = array('errors'=>$errors,'decision'=>0 );
                            echo CJSON::encode($data);
                            Yii::app()->end();
                        }    
                    }
                    else
                    {
                        $errors = $company->errors;
                        $data = array('errors'=>$errors,'decision'=>0 );
                        echo CJSON::encode($data);
                        Yii::app()->end();
                       
            }
            }
    }
	public function actionAddCompanyContact()
    {
        $session = new CHttpSession;
        $company = new AsicOnCompany();
    

       

        if (isset($_POST['AsicOnCompany'])) 
        {
            $formInfo = $_POST['AsicOnCompany'];

            $company->attributes=$formInfo;
			
            if($company->validate())
            {
                $command = Yii::app()->db->createCommand();
                $result=$command->insert('user',array(
                                    //'id'=>it is autoincrement,
                                    'company'=>$formInfo['name'],
                                    'first_name'=>$formInfo['user_first_name'],
                                    'last_name'=>$formInfo['user_last_name'],
                                    'email'=>$formInfo['user_email'],
                                    'contact_number'=>$formInfo['user_contact_number'],
                                    'timezone_id'=>1,
                                    'photo'=>NULL,
                                    'tenant'=> empty($session['tenant']) ? NULL : $session['tenant'],
                                    'user_type'=>2,
                                    'user_status'=>1,
                                    'role'=>10,
                                    'created_by'=> empty($session['created_by']) ? NULL : $session['created_by'],
                                ));
                if ($result)
                {
                    $last_id = Yii::app()->db->getLastInsertID();
                    $user = User::model()->findByPk($last_id);
                     $Criteria = new CDbCriteria();
					//$Criteria->select="*,CONCAT(first_name,' ',last_name) as name";
					$Criteria->condition = "company = ".$formInfo['name']." and is_deleted = 0";
					$Userlist = User::model()->findAll($Criteria);
                    $contactCompany = Company::model()->findByPk($formInfo['name'],"is_deleted = 0");

                    $dropDown = "<option selected='selected' value='" . $user->id . "'>" .$user->first_name." ".$user->last_name."</option>"; // seriously why is this here?
                    $ret = array("contactCompany"=>$contactCompany, "dropDown" => $dropDown);
					$session['contactData']=CHtml::listData($Userlist, 'id', function($Userlist){return "{$Userlist->first_name} {$Userlist->last_name}";});
                    echo CJSON::encode($ret);
                    Yii::app()->end();
                }
                else
                {
                    $data = array('decision'=>0);
                    echo CJSON::encode($data);
                    Yii::app()->end();
                }
            }
            else
            {
                $errors = $company->errors;
                $data = array('errors'=>$errors,'decision'=>0 );
                echo CJSON::encode($data);
                Yii::app()->end();
            }
        }
    }
	public function actionPaymentAppointment()
	{
		$session = new CHttpSession;
		$session['stepTitle'] = 'Appointment';
		$session['step10Subtitle'] = "&nbsp;&nbsp;>&nbsp;&nbsp;"."<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration/paymentAppointment'>Appointment</a>";
		$sessionVisit = $session['visit_model'];
		$model = new RegistrationAsic();
		$model->detachBehavior('DateTimeZoneAndFormatBehavior');
		if(isset($_POST['RegistrationAsic']))
		{
			$session['appt1']=$_POST['RegistrationAsic']['appointment_1'];
			$session['appt2']=$_POST['RegistrationAsic']['appointment_2'];
			$this->redirect(array('preregistration/asicSubmit'));
		}
		//echo "here";
		$preModel = new PreregLogin();
		$this->render('payment-appointment' , array('model' => $model));
		
		
	}
	//Asic Submit Part Starts Here ------------------------------------------------------------------------------------------------------------------
	public function actionAsicSubmit()
	{
		$session = new CHttpSession;
		$session['stepTitle'] = 'SUBMIT APPLICATION';
		$session['step10Subtitle'] = "&nbsp;&nbsp;>&nbsp;&nbsp;"."<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration/paymentAppointment'>Submit Application</a>";
		$model = new AsicSubmit();
		//print_r($_POST);
		if(isset($_POST['AsicSubmit']))
		{
			
			$asic_application=new AsicInfo();
			$asic_applicant= new RegistrationAsic();
			$asic_address=new AsicAddressHistory();
			$asic_immi = new Immigration();	
			$asic_company= new AsicOnCompany();
			if(isset($session['AsicprivacyPolicy']))
			{
				
				
				if(isset($session['Asictype']))
				{
					//New--------------------------------------------------------------------------------------------------------------------------
					if($session['Asictype']==1)
					{
						
						
						$asic_application->fee=333;
						if(isset($session['paidby']) && $session['paidby']==1)
						$asic_application->paid_by='Company';
						else
						$asic_application->paid_by='Cardholder';
						if(isset($session['AsicInfo-details']))
						{
							$asic_application->previous_card=$session['AsicInfo-details']->previous_card;
							$asic_application->previous_issuing_body=$session['AsicInfo-details']->previous_issuing_body;
							if($session['AsicInfo-details']->previous_expiry!='')
							$asic_application->previous_expiry=date('Y-m-d',strtotime($session['AsicInfo-details']->previous_expiry));
							$asic_application->created_at=date('Y-m-d');
							$asic_application->asic_type=$session['AsicInfo-details']->asic_type;
							$asic_application->access=$session['AsicInfo-details']->access;
							$asic_application->other_info=$session['AsicInfo-details']->other_info;
							$asic_application->frequency_red=$session['AsicInfo-details']->frequency_red;
							$asic_application->frequency_grey=$session['AsicInfo-details']->frequency_grey;
							$asic_application->security_detail=$session['AsicInfo-details']->security_detail;
							$asic_application->door_detail=$session['AsicInfo-details']->door_detail;
						}
						if(isset($session['asicapplicant-details']))
						{
							$asic_applicant=$session['asicapplicant-details'];
							
							$asic_applicant->date_of_birth=date('Y-m-d',strtotime($session['asicapplicant-details']->date_of_birth));
							
							$asic_applicant->from_date=date('Y-m-d',strtotime($session['asicapplicant-details']->from_date));
							
							$asic_applicant->created_on=date('Y-m-d');
							$asic_applicant->application_type='New';
							if(isset($session['Accname']) && $session['Accname']!='' && isset($session['Bsb']) && $session['Bsb']!='' && isset($session['Accno']) && $session['Accno']!='')
							{
							$asic_applicant->acc_name=$session['Accname'];
							$asic_applicant->acc_bsb=$session['Bsb'];
							$asic_applicant->acc_number=$session['Accno'];
							
							}
							if($session['Crime1']==2 && $session['Crime2']==2 && $session['Crime3']==2 && $session['Crime4']==2 && $session['use1']==1 && $session['use2']==1 && $session['use3']==1)
							{
							$asic_applicant->condition_of_use=1;
							$asic_applicant->aus_check=1;
							$asic_applicant->tenant=$session['tenant'];
							}
						}
						if(isset($session['immi-details']))
						{
							$asic_immi=$session['immi-details'];
							if($session['immi-details']->arrival_date!='')
							$asic_immi->arrival_date=date('Y-m-d',strtotime($session['immi-details']->arrival_date));
						}
						if(isset($session['identification_Details']))
						{
							$asic_applicant->primary_id=$session['identification_Details']->primary_id;
							$asic_applicant->secondary_id=$session['identification_Details']->secondary_id;
							$asic_applicant->tertiary_id1=$session['identification_Details']->tertiary_id1;
							$asic_applicant->tertiary_id2=$session['identification_Details']->tertiary_id2;
							$asic_applicant->secondary_id_no=$session['identification_Details']->secondary_id_no;
							$asic_applicant->tertiary_id1_no=$session['identification_Details']->tertiary_id1_no;
							$asic_applicant->tertiary_id2_no=$session['identification_Details']->tertiary_id2_no;
							$asic_applicant->primary_id_no=$session['identification_Details']->primary_id_no;
							$asic_applicant->country_id1=$session['identification_Details']->country_id1;
							$asic_applicant->country_id2=$session['identification_Details']->country_id2;
							$asic_applicant->country_id3=$session['identification_Details']->country_id3;
							$asic_applicant->country_id4=$session['identification_Details']->country_id4;
							$asic_applicant->upload_1=$session['identification_Details']->upload_1;
							$asic_applicant->upload_2=$session['identification_Details']->upload_2;
							$asic_applicant->upload_4=$session['identification_Details']->upload_4;
							$asic_applicant->upload_3=$session['identification_Details']->upload_3;
							//$asic_applicant->name_change_file=$session['asicapplicant-details'];
							if($session['identification_Details']->primary_id_expiry!='')
							$asic_applicant->primary_id_expiry=date('Y-m-d',strtotime($session['identification_Details']->primary_id_expiry));
							if($session['identification_Details']->secondary_id_expiry!='')
							$asic_applicant->secondary_id_expiry=date('Y-m-d',strtotime($session['identification_Details']->secondary_id_expiry));
							if($session['identification_Details']->tertiary_id1_expiry!='')
							$asic_applicant->tertiary_id1_expiry=date('Y-m-d',strtotime($session['identification_Details']->tertiary_id1_expiry));
							if($session['identification_Details']->tertiary_id2_expiry!='')
							$asic_applicant->tertiary_id2_expiry=date('Y-m-d',strtotime($session['identification_Details']->tertiary_id2_expiry));
						}
						if(isset($session['Company_Details']))
						{
							$asic_company=$session['Company_Details'];
							
							//$asic_company->save(false);
							if(isset($session['opFile']) && $session['opFile']!='')
							$asic_applicant->op_need_document=$session['opFile'];
							if(isset($session['authFile']) && $session['authFile']!='')
							User::model()->updateByPk($asic_company->contact, array('authorised_file' => $session['authFile']));
							$asic_applicant->company_contact=$asic_company->contact;
							$asic_applicant->company_id=$asic_company->name;
							$asic_applicant->employment_status=$asic_company->company_radio;
							$company_asic_update = Company::model()->findByPk($asic_company->name);
							$company_asic_update->office_number=$asic_company->office_number;
							$company_asic_update->unit=$asic_company->unit;
							$company_asic_update->street_name=$asic_company->street_name;
							$company_asic_update->street_number=$asic_company->street_number;
							$company_asic_update->street_type=$asic_company->street_type;
							$company_asic_update->post_code=$asic_company->post_code;
							$company_asic_update->suburb=$asic_company->suburb;
							$company_asic_update->city=$asic_company->city;
							$company_asic_update->state=$asic_company->state;
							$company_asic_update->country=$asic_company->country;
							
							$company_asic_update->save(false);
						}
						if(isset($session['appt1']) && isset($session['appt2']))
						{
							$asic_applicant->appointment_1=date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $session['appt1'])));
							$asic_applicant->appointment_2=date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $session['appt2'])));
						}
						$asic_applicant->is_saved=0;
						if($asic_applicant->save())
						{
							if(isset($session['AddHistory']))
							{
								$x=count($session['AddHistory']['unit']);
								for($i=0;$i<$x;$i++)
								{
								if(!$asic_address->exists("( asic_applicant_id = '{$asic_applicant->id}' AND street_name='{$session['AddHistory']['stnm'][$i]}' AND street_number='{$session['AddHistory']['stno'][$i]}')"))
									{
									$asic_address->asic_applicant_id=$asic_applicant->id;
									$asic_address->unit=$session['AddHistory']['unit'][$i];
									$asic_address->street_number=$session['AddHistory']['stno'][$i];
									$asic_address->street_name=$session['AddHistory']['stnm'][$i];
									$asic_address->street_type=$session['AddHistory']['sttype'][$i];
									$asic_address->suburb=$session['AddHistory']['sub'][$i];
									$asic_address->city=$session['AddHistory']['city'][$i];
									$asic_address->postcode=$session['AddHistory']['pstcd'][$i];
									$asic_address->state=$session['AddHistory']['state'][$i];
									$asic_address->country=$session['AddHistory']['cntry'][$i];
									$asic_address->from_date=date('Y-m-d',strtotime($session['AddHistory']['frm'][$i]));
									$asic_address->to_date=date('Y-m-d',strtotime($session['AddHistory']['to'][$i]));
									$asic_address->created_at=date('Y-m-d');
									$asic_address->isNewRecord = true;
									$asic_address->setPrimaryKey(NULL);
									$asic_address->save();
									}
									
									
									
										
								}
								$asic_application->asic_applicant_id=$asic_applicant->id;
										if($asic_application->save())
										{
											$asic_immi->asic_applicant_id=$asic_applicant->id;
											$asic_immi->save();
										}
							}
							else
							{
								$asic_application->asic_applicant_id=$asic_applicant->id;
										if($asic_application->save())
										{
											$asic_immi->asic_applicant_id=$asic_applicant->id;
											$asic_immi->save();
										}
							}
								
						}
						
					}
					//Renewal--------------------------------------------------------------------------------------------
					if($session['Asictype']==2)
					{
						
						
						if($session['BondPaid']==1)
						{
							$asic_application->fee=283;
						}
						else
						$asic_application->fee=333;
						
						if(isset($session['paidby']) && $session['paidby']==1)
						$asic_application->paid_by='Company';
						else
						$asic_application->paid_by='Cardholder';
						
						if(isset($session['AsicInfo-details']))
						{
							$asic_application->previous_card=$session['AsicInfo-details']->previous_card;
							$asic_application->previous_issuing_body=$session['AsicInfo-details']->previous_issuing_body;
							if($session['AsicInfo-details']->previous_expiry!='')
							$asic_application->previous_expiry=date('Y-m-d',strtotime($session['AsicInfo-details']->previous_expiry));
							$asic_application->created_at=date('Y-m-d');
							$asic_application->asic_type=$session['AsicInfo-details']->asic_type;
							$asic_application->access=$session['AsicInfo-details']->access;
							$asic_application->other_info=$session['AsicInfo-details']->other_info;
							$asic_application->frequency_red=$session['AsicInfo-details']->frequency_red;
							$asic_application->frequency_grey=$session['AsicInfo-details']->frequency_grey;
							$asic_application->security_detail=$session['AsicInfo-details']->security_detail;
							$asic_application->door_detail=$session['AsicInfo-details']->door_detail;
						}
						
						if(isset($session['asicapplicant-details']))
						{
							$asic_applicant=$session['asicapplicant-details'];
							
							$asic_applicant->date_of_birth=date('Y-m-d',strtotime($session['asicapplicant-details']->date_of_birth));
							
							$asic_applicant->from_date=date('Y-m-d',strtotime($session['asicapplicant-details']->from_date));
							
							$asic_applicant->created_on=date('Y-m-d');
							$asic_applicant->application_type='Renew';
							if(isset($session['Accname']) && $session['Accname']!='' && isset($session['Bsb']) && $session['Bsb']!='' && isset($session['Accno']) && $session['Accno']!='')
							{
							$asic_applicant->acc_name=$session['Accname'];
							$asic_applicant->acc_bsb=$session['Bsb'];
							$asic_applicant->acc_number=$session['Accno'];
							}
							if($session['Crime1']==2 && $session['Crime2']==2 && $session['Crime3']==2 && $session['Crime4']==2 && $session['use1']==1 && $session['use2']==1 && $session['use3']==1)
							{
							$asic_applicant->condition_of_use=1;
							$asic_applicant->aus_check=1;
							$asic_applicant->tenant=$session['tenant'];
							}
						}
						
						if(isset($session['immi-details']))
						{
							$asic_immi=$session['immi-details'];
							if($session['immi-details']->arrival_date!='')
							$asic_immi->arrival_date=date('Y-m-d',strtotime($session['immi-details']->arrival_date));
						}
						if(isset($session['identification_Details']))
						{
							$asic_applicant->primary_id=$session['identification_Details']->primary_id;
							$asic_applicant->secondary_id=$session['identification_Details']->secondary_id;
							$asic_applicant->tertiary_id1=$session['identification_Details']->tertiary_id1;
							$asic_applicant->tertiary_id2=$session['identification_Details']->tertiary_id2;
							$asic_applicant->secondary_id_no=$session['identification_Details']->secondary_id_no;
							$asic_applicant->tertiary_id1_no=$session['identification_Details']->tertiary_id1_no;
							$asic_applicant->tertiary_id2_no=$session['identification_Details']->tertiary_id2_no;
							$asic_applicant->primary_id_no=$session['identification_Details']->primary_id_no;
							$asic_applicant->country_id1=$session['identification_Details']->country_id1;
							$asic_applicant->country_id2=$session['identification_Details']->country_id2;
							$asic_applicant->country_id3=$session['identification_Details']->country_id3;
							$asic_applicant->country_id4=$session['identification_Details']->country_id4;
							$asic_applicant->upload_1=$session['identification_Details']->upload_1;
							$asic_applicant->upload_2=$session['identification_Details']->upload_2;
							$asic_applicant->upload_4=$session['identification_Details']->upload_4;
							$asic_applicant->upload_3=$session['identification_Details']->upload_3;
							//$asic_applicant->name_change_file=$session['asicapplicant-details'];
							$asic_applicant->primary_id_expiry=date('Y-m-d',strtotime($session['identification_Details']->primary_id_expiry));
							if($session['identification_Details']->secondary_id_expiry!='')
							$asic_applicant->secondary_id_expiry=date('Y-m-d',strtotime($session['identification_Details']->secondary_id_expiry));
							if($session['identification_Details']->tertiary_id1_expiry!='')
							$asic_applicant->tertiary_id1_expiry=date('Y-m-d',strtotime($session['identification_Details']->tertiary_id1_expiry));
							if($session['identification_Details']->tertiary_id2_expiry!='')
							$asic_applicant->tertiary_id2_expiry=date('Y-m-d',strtotime($session['identification_Details']->tertiary_id2_expiry));
						}
						if(isset($session['Company_Details']))
						{
							$asic_company=$session['Company_Details'];
							if(isset($session['opFile']) && $session['opFile']!='')
							$asic_applicant->op_need_document=$session['opFile'];
							if(isset($session['authFile']) && $session['authFile']!='')
							User::model()->updateByPk($asic_company->contact, array('authorised_file' => $session['authFile']));
							$asic_applicant->company_contact=$asic_company->contact;
							$asic_applicant->company_id=$asic_company->name;
							$asic_applicant->employment_status=$asic_company->company_radio;
							$company_asic_update = Company::model()->findByPk($asic_company->name);
							$company_asic_update->office_number=$asic_company->office_number;
							$company_asic_update->unit=$asic_company->unit;
							$company_asic_update->street_name=$asic_company->street_name;
							$company_asic_update->street_number=$asic_company->street_number;
							$company_asic_update->street_type=$asic_company->street_type;
							$company_asic_update->post_code=$asic_company->post_code;
							$company_asic_update->suburb=$asic_company->suburb;
							$company_asic_update->city=$asic_company->city;
							$company_asic_update->state=$asic_company->state;
							$company_asic_update->country=$asic_company->country;
							
							$company_asic_update->save(false);
						}
						if(isset($session['appt1']) && isset($session['appt2']))
						{
							$asic_applicant->appointment_1=date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $session['appt1'])));
							$asic_applicant->appointment_2=date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $session['appt2'])));
							
						}
						$asic_applicant->isNewRecord = true;
						//$asic_applicant->save();
						//print_r($asic_applicant->getErrors());
						$asic_applicant->is_saved=0;
						if($asic_applicant->save())
						{
							if(isset($session['AddHistory']))
							{
								$x=count($session['AddHistory']['unit']);
								
								for($i=0;$i<$x;$i++)
								{
									if(!$asic_address->exists("( asic_applicant_id = '{$asic_applicant->id}' AND street_name='{$session['AddHistory']['stnm'][$i]}' AND street_number='{$session['AddHistory']['stno'][$i]}')"))
									{
									$asic_address->asic_applicant_id=$asic_applicant->id;
									$asic_address->unit=$session['AddHistory']['unit'][$i];
									$asic_address->street_number=$session['AddHistory']['stno'][$i];
									$asic_address->street_name=$session['AddHistory']['stnm'][$i];
									$asic_address->street_type=$session['AddHistory']['sttype'][$i];
									$asic_address->suburb=$session['AddHistory']['sub'][$i];
									$asic_address->city=$session['AddHistory']['city'][$i];
									$asic_address->postcode=$session['AddHistory']['pstcd'][$i];
									$asic_address->state=$session['AddHistory']['state'][$i];
									$asic_address->country=$session['AddHistory']['cntry'][$i];
									$asic_address->from_date=date('Y-m-d',strtotime($session['AddHistory']['frm'][$i]));
									$asic_address->to_date=date('Y-m-d',strtotime($session['AddHistory']['to'][$i]));
									$asic_address->created_at=date('Y-m-d');
									$asic_address->isNewRecord = true;
									$asic_address->setPrimaryKey(NULL);
									$asic_address->save();
									}
									
										
										
									
								}
										$asic_application->asic_applicant_id=$asic_applicant->id;
										if($asic_application->save())
										{
											$asic_immi->asic_applicant_id=$asic_applicant->id;
											$asic_immi->save();
										}
							}
							else
							{
								$asic_application->asic_applicant_id=$asic_applicant->id;
										if($asic_application->save())
										{
											$asic_immi->asic_applicant_id=$asic_applicant->id;
											$asic_immi->save();
										}
							}
						}
					}
					//Replacement-------------------------------------------------------------------------
					if($session['Asictype']==3)
					{
						
						if($session['BondPaid']==1)
						{
							$asic_application->fee=104;
						}
						else
						$asic_application->fee=154;
					
						if(isset($session['paidby']) && $session['paidby']==1)
						$asic_application->paid_by='Company';
						else
						$asic_application->paid_by='Cardholder';
						
						if(isset($session['AsicInfo-details']))
						{
							$asic_application->previous_card=$session['AsicInfo-details']->previous_card;
							$asic_application->previous_issuing_body=$session['AsicInfo-details']->previous_issuing_body;
							if($session['AsicInfo-details']->previous_expiry!='')
							$asic_application->previous_expiry=date('Y-m-d',strtotime($session['AsicInfo-details']->previous_expiry));
							$asic_application->created_at=date('Y-m-d');
							$asic_application->asic_type=$session['AsicInfo-details']->asic_type;
							$asic_application->access=$session['AsicInfo-details']->access;
							$asic_application->other_info=$session['AsicInfo-details']->other_info;
							$asic_application->frequency_red=$session['AsicInfo-details']->frequency_red;
							$asic_application->frequency_grey=$session['AsicInfo-details']->frequency_grey;
							$asic_application->security_detail=$session['AsicInfo-details']->security_detail;
							$asic_application->door_detail=$session['AsicInfo-details']->door_detail;
						}
						if(isset($session['asicapplicant-details']))
						{
							$asic_applicant=$session['asicapplicant-details'];
							
							$asic_applicant->date_of_birth=date('Y-m-d',strtotime($session['asicapplicant-details']->date_of_birth));
							
							$asic_applicant->from_date=date('Y-m-d',strtotime($session['asicapplicant-details']->from_date));
							//echo "<pre>";
							//print_r($_POST);
							//echo "</pre>";
							//Yii::app()->end();
							$asic_applicant->created_on=date('Y-m-d');
							$asic_applicant->application_type='Replacement';
							if(isset($session['Accname']) && $session['Accname']!='' && isset($session['Bsb']) && $session['Bsb']!='' && isset($session['Accno']) && $session['Accno']!='')
							{
							$asic_applicant->acc_name=$session['Accname'];
							$asic_applicant->acc_bsb=$session['Bsb'];
							$asic_applicant->acc_number=$session['Accno'];
							}
							if($session['Crime1']==2 && $session['Crime2']==2 && $session['Crime3']==2 && $session['Crime4']==2 && $session['use1']==1 && $session['use2']==1 && $session['use3']==1)
							{
							$asic_applicant->condition_of_use=1;
							$asic_applicant->aus_check=1;
							$asic_applicant->tenant=$session['tenant'];
							}
						}
						if(isset($session['immi-details']))
						{
							$asic_immi=$session['immi-details'];
							if($session['immi-details']->arrival_date!='')
							$asic_immi->arrival_date=date('Y-m-d',strtotime($session['immi-details']->arrival_date));
						}
						if(isset($session['identification_Details']))
						{
							$asic_applicant->primary_id=$session['identification_Details']->primary_id;
							$asic_applicant->secondary_id=$session['identification_Details']->secondary_id;
							$asic_applicant->tertiary_id1=$session['identification_Details']->tertiary_id1;
							$asic_applicant->tertiary_id2=$session['identification_Details']->tertiary_id2;
							$asic_applicant->secondary_id_no=$session['identification_Details']->secondary_id_no;
							$asic_applicant->tertiary_id1_no=$session['identification_Details']->tertiary_id1_no;
							$asic_applicant->tertiary_id2_no=$session['identification_Details']->tertiary_id2_no;
							$asic_applicant->primary_id_no=$session['identification_Details']->primary_id_no;
							$asic_applicant->country_id1=$session['identification_Details']->country_id1;
							$asic_applicant->country_id2=$session['identification_Details']->country_id2;
							$asic_applicant->country_id3=$session['identification_Details']->country_id3;
							$asic_applicant->country_id4=$session['identification_Details']->country_id4;
							$asic_applicant->upload_1=$session['identification_Details']->upload_1;
							$asic_applicant->upload_2=$session['identification_Details']->upload_2;
							$asic_applicant->upload_4=$session['identification_Details']->upload_4;
							$asic_applicant->upload_3=$session['identification_Details']->upload_3;
							//$asic_applicant->name_change_file=$session['asicapplicant-details'];
							$asic_applicant->primary_id_expiry=date('Y-m-d',strtotime($session['identification_Details']->primary_id_expiry));
							if($session['identification_Details']->secondary_id_expiry!='')
							$asic_applicant->secondary_id_expiry=date('Y-m-d',strtotime($session['identification_Details']->secondary_id_expiry));
							if($session['identification_Details']->tertiary_id1_expiry!='')
							$asic_applicant->tertiary_id1_expiry=date('Y-m-d',strtotime($session['identification_Details']->tertiary_id1_expiry));
							if($session['identification_Details']->tertiary_id2_expiry!='')
							$asic_applicant->tertiary_id2_expiry=date('Y-m-d',strtotime($session['identification_Details']->tertiary_id2_expiry));
						}
						if(isset($session['Company_Details']))
						{
							$asic_company=$session['Company_Details'];
							if(isset($session['opFile']) && $session['opFile']!='')
							$asic_applicant->op_need_document=$session['opFile'];
							if(isset($session['authFile']) && $session['authFile']!='')
							User::model()->updateByPk($asic_company->contact, array('authorised_file' => $session['authFile']));
							$asic_applicant->company_contact=$asic_company->contact;
							$asic_applicant->company_id=$asic_company->name;
							$asic_applicant->employment_status=$asic_company->company_radio;
							$company_asic_update = Company::model()->findByPk($asic_company->name);
							$company_asic_update->office_number=$asic_company->office_number;
							$company_asic_update->unit=$asic_company->unit;
							$company_asic_update->street_name=$asic_company->street_name;
							$company_asic_update->street_number=$asic_company->street_number;
							$company_asic_update->street_type=$asic_company->street_type;
							$company_asic_update->post_code=$asic_company->post_code;
							$company_asic_update->suburb=$asic_company->suburb;
							$company_asic_update->city=$asic_company->city;
							$company_asic_update->state=$asic_company->state;
							$company_asic_update->country=$asic_company->country;
							
							$company_asic_update->save(false);
						}
						if(isset($session['appt1']) && isset($session['appt2']))
						{
							$asic_applicant->appointment_1=date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $session['appt1'])));
							$asic_applicant->appointment_2=date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $session['appt2'])));
						}
						$asic_applicant->is_saved=0;
						if($asic_applicant->save())
						{
							if(isset($session['AddHistory']))
							{
								$x=count($session['AddHistory']['unit']);
								for($i=0;$i<$x;$i++)
								{
									if(!$asic_address->exists("( asic_applicant_id = '{$asic_applicant->id}' AND street_name='{$session['AddHistory']['stnm'][$i]}' AND street_number='{$session['AddHistory']['stno'][$i]}')"))
									{
									$asic_address->asic_applicant_id=$asic_applicant->id;
									$asic_address->unit=$session['AddHistory']['unit'][$i];
									$asic_address->street_number=$session['AddHistory']['stno'][$i];
									$asic_address->street_name=$session['AddHistory']['stnm'][$i];
									$asic_address->street_type=$session['AddHistory']['sttype'][$i];
									$asic_address->suburb=$session['AddHistory']['sub'][$i];
									$asic_address->city=$session['AddHistory']['city'][$i];
									$asic_address->postcode=$session['AddHistory']['pstcd'][$i];
									$asic_address->state=$session['AddHistory']['state'][$i];
									$asic_address->country=$session['AddHistory']['cntry'][$i];
									$asic_address->from_date=date('Y-m-d',strtotime($session['AddHistory']['frm'][$i]));
									$asic_address->to_date=date('Y-m-d',strtotime($session['AddHistory']['to'][$i]));
									$asic_address->created_at=date('Y-m-d');
									$asic_address->isNewRecord = true;
									$asic_address->setPrimaryKey(NULL);
									$asic_address->save();
									}
									
								}
								$asic_application->asic_applicant_id=$asic_applicant->id;
										if($asic_application->save())
										{
											$asic_immi->asic_applicant_id=$asic_applicant->id;
											$asic_immi->save();
										}
							}
							else
							{
								$asic_application->asic_applicant_id=$asic_applicant->id;
										if($asic_application->save())
										{
											$asic_immi->asic_applicant_id=$asic_applicant->id;
											$asic_immi->save();
										}
							}
						}
					}
				}
			
			
			
			
				
			}
			Yii::app()->session->clear();
			$airportName=new Company();
			$airport=$airportName->findByPk($asic_applicant->tenant)->name;
			$contact=$airportName->findByPk($asic_applicant->tenant)->office_number;
			$issuing=new user();
			$issuing=$issuing->findAll('tenant='.$asic_applicant->tenant.' AND company='.$asic_applicant->tenant.' AND role=11 AND is_deleted=0');
			$emailTransport = new EmailTransport();
			foreach($issuing as $data)
			{
				$templateParams = array(
				'email' => $data->email,
				'issname'=>ucfirst($data->first_name) . ' ' . ucfirst($data->last_name),
				'datetime'=>$asic_applicant->appointment_1,
				'datetime1'=>$asic_applicant->appointment_2,
				'number'=>$asic_applicant->mobile_phone,
				'emailid'=>$asic_applicant->email,
				'name'=>  ucfirst($asic_applicant->first_name) . ' ' . ucfirst($asic_applicant->last_name),
				);
				$subject=ucfirst($asic_applicant->first_name) . ' ' . ucfirst($asic_applicant->last_name).'has requested an ASIC Induction Appointment';
				$emailTransport->sendAppointment($templateParams, $data->email, $data->first_name . ' ' . $data->last_name,$subject);
			}
			$attachment = file_get_contents(Yii::getPathOfAlias('webroot').'/uploads/Employers_Certification3739.pdf');
			$attachment_encoded = base64_encode($attachment); 
			
			 $templateParams = array(
            'email' => $asic_applicant->email,
			'Airport'=>$airport,
			'contact'=>$contact,
			'name'=>  ucfirst($asic_applicant->first_name) . ' ' . ucfirst($asic_applicant->last_name),
			);
			$attachments =array(
								'content' => $attachment_encoded,
								'type' => "application/pdf",
								'name' => 'file.pdf'
								);
			$subject='Application Submitted '.ucfirst($asic_applicant->first_name) . ' ' . ucfirst($asic_applicant->last_name);
			//TODO: Change to YiiMail
			
			$emailTransport->sendSubmitted($templateParams, $asic_applicant->email, $asic_applicant->first_name . ' ' . $asic_applicant->last_name,$subject,$attachments);
			
			$this->redirect(array('preregistration/asicSuccess'));
		}
		$this->render('asic-submit',array('model'=>$model) );
	}//Asic Submit Part Ends Here ------------------------------------------------------------------------------------------------------------------
	public function actionEntryPoint(){

		$session = new CHttpSession;
		$session['stepTitle'] = 'PREREGISTRATION FOR VISITOR IDENTIFICATION CARD (VIC)';
		$session['step1Subtitle'] = "<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration'>Preregister for a VIC</a>";

		unset($session['requestForVerificationEmail']);

		$model = '';
		if(isset($session['workstation']) && $session['workstation'] != ''){
			$model = $session['workstation_model'];
		}
		else{
			$model = new EntryPoint();
		}

		if(isset($_POST['EntryPoint']))
		{
			$model->attributes=$_POST['EntryPoint'];
			if($model->validate())
			{
				$workstation = Workstation::model()->findByPk($model->entrypoint);
				$session['workstation_model'] = $model;
				//these will be used to ensure that nothing will left in the flow
				$session['workstation'] = $workstation->id;
				$session['created_by'] = $workstation->created_by;
				$session['tenant'] = $workstation->tenant;
				$session['pre-page'] = 3;
				$this->redirect(array('preregistration/privacyPolicy'));
			}                     
		}
		$this->render('workstation-selection',array('model'=>$model));
	} 
	
	public function actionPrivacyPolicy()
	{
		$session = new CHttpSession;
		if(!isset($session['workstation']) || empty($session['workstation']) || is_null($session['workstation'])){
			$this->redirect(array('preregistration/entryPoint'));
		}
		$session['stepTitle'] = 'VIC REQUIREMENTS';
		$session['step2Subtitle'] = "&nbsp;&nbsp;>&nbsp;&nbsp;"."<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration/privacyPolicy'>Requirements</a>";

		$this->render('privacy-policy');
	}

	public function actionDeclaration()
	{
		$session = new CHttpSession;
		if(!isset($session['workstation']) || empty($session['workstation']) || is_null($session['workstation'])){
			$this->redirect(array('preregistration/index'));
		}
		if(!isset($session['privacyPolicy']) && $session['privacyPolicy'] == ""){$session['privacyPolicy'] = 'checked';}

		$session['stepTitle'] = 'DECLARATIONS';
		$session['step3Subtitle'] = "&nbsp;&nbsp;>&nbsp;&nbsp;"."<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration/declaration'>Declarations</a>";
		
		$this->render('declaration');
	}

	public function actionPersonalDetails()
	{
		$session = new CHttpSession;
		if(!isset($session['workstation']) || empty($session['workstation']) || is_null($session['workstation'])){
			$this->redirect(array('preregistration/index'));
		}
		if(!isset($session['declarationCheck1']) && $session['declarationCheck1'] == ""){$session['declarationCheck1'] = 'checked';}
		if(!isset($session['declarationCheck2']) && $session['declarationCheck2'] == ""){$session['declarationCheck2'] = 'checked';}

		$session['stepTitle'] = 'PERSONAL INFORMATION';
		$session['step4Subtitle'] = "&nbsp;&nbsp;>&nbsp;&nbsp;"."<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration/personalDetails'>Personal Information</a>";
		unset($session['vic_model']);
		$model = '';
		if(isset(Yii::app()->user->id) && !empty(Yii::app()->user->id)){
			if(isset($session['visitor_model']) && $session['visitor_model'] != ''){
				$model = $session['visitor_model'];
			}else{
				
				$model = Registration::model()->findByPk(Yii::app()->user->id);
				
			}
		}
		elseif(isset($session['visitor_model']) && $session['visitor_model'] != ''){
			$model = $session['visitor_model'];
			echo "<pre>";
			print_r($session['visitor_model']);
			echo '</pre>';
			Yii::app()->end();
		}
		else{
			$model = new Registration();	
		}
		if(!isset($session['workstation']) || empty($session['workstation']) || is_null($session['workstation'])){
			$this->redirect(array('preregistration/index'));
		}
		$model->scenario = 'preregistration';
		$error_message = '';
		if (isset($_POST['Registration']))
		{
			if(isset($_POST['Registration']['selected_asic_id']) && !empty($_POST['Registration']['selected_asic_id'])){
				$vic = Registration::model()->findByPk($_POST['Registration']['selected_asic_id']);
				$session['vic_model'] = $vic;
				$this->redirect(array('preregistration/visitReason'));
			}	
			$model->attributes = $_POST['Registration'];
			if($model->tenant == null || $model->tenant == ""){$model->tenant = $session['tenant'];}
			if($model->created_by == null || $model->created_by == ""){$model->created_by =  $session['created_by'];}
			if($model->visitor_workstation == null || $model->visitor_workstation == ""){$model->visitor_workstation = $session['workstation'];}
			$model->identification_country_issued = $_POST['Registration']['identification_country_issued'];
			
			if (!empty($_POST['Registration']['contact_state']))
			{
				$session['visitor_model'] = $model;
				/*echo '<pre>';
				print_r($model);
				echo '</pre>';
				Yii::app()->end();*/
				$this->redirect(array('preregistration/visitReason'));
            } 
            else {
            	$model->contact_country = Visitor::AUSTRALIA_ID;
                $error_message = "Please select state";
            }
		}
		$preModel = new PreregLogin();
		$this->render('confirm-details' , array('model' => $model,'preModel' => $preModel,'error_message' => $error_message));
	}

	public function actionVisitReason()
	{
		$session = new CHttpSession;
		if(!isset($session['workstation']) || empty($session['workstation']) || is_null($session['workstation'])){
			$this->redirect(array('preregistration/index'));
		}
		$session['stepTitle'] = 'REASON FOR VISIT';
		$session['step5Subtitle'] = "&nbsp;&nbsp;>&nbsp;&nbsp;"."<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration/visitReason'>Reason for Visit</a>";
		$model = '';$companyModel = '';
		if(isset($session['visit_model']) && $session['visit_model'] != ''){
			$model = $session['visit_model'];
		}
		else{
			$model = new Visit();
		}
		if(isset($session['company_model']) && $session['company_model'] != ''){
			$companyModel = $session['company_model'];
		}
		else{
			$companyModel = new Company();
		}
		$companyModel->scenario = 'preregistration';
		$model->scenario = 'preregistration';
		if (isset($_POST['Visit'])) 
		{
			$model->attributes    = $_POST['Visit'];
			$companyModel->attributes    = $_POST['Company'];
			if($_POST['Visit']['other_reason'] != ""){
				$model->visit_reason  = $_POST['Visit']['other_reason'];
			}

			//set tenant based default card type otherwise VIC_24_hours card type for preregistration
			$tenant = (isset($session['tenant'])&& $session['tenant']!="") ? Company::model()->findByPk($session['tenant']) : "";
			$model->card_type = (($tenant != "") && ($tenant->tenant_default_card_type != "")) ? $tenant->tenant_default_card_type : CardType::VIC_CARD_24HOURS; 
			
			$model->created_by = $session['created_by'];
			$model->workstation  = $session['workstation'];
			$model->tenant = $session['tenant'];
			$model->visit_status  = 2; //default visit status is 2=PREREGISTER
			$model->company =  $_POST['Company']['name'];
			if($model->validate())
			{
				$session['visit_model'] = $model;
				$session['company_model'] = $companyModel;
				$session['company_id'] =  $_POST['Company']['name'];
				$this->redirect(array('preregistration/addAsic'));
			}
		}
		$this->render(
			'visit-reason',
			array(
				'model'=>$model ,
				'companyModel' => $companyModel
			)
		);
	}

	public function actionAddAsic(){
		$session = new CHttpSession;
		if(!isset($session['workstation']) || empty($session['workstation']) || is_null($session['workstation'])){
			$this->redirect(array('preregistration/index'));
		}

		if(isset(Yii::app()->user->id,$session['account_type']) &&($session['account_type'] != "") && ($session['account_type'] == "ASIC")){
			$model = Registration::model()->findByPk(Yii::app()->user->id,"profile_type=:param",array(":param"=>"ASIC"));
		}else{
			$model = new Registration();
		}
		if(!isset($session['workstation']) || empty($session['workstation']) || is_null($session['workstation'])){
			$this->redirect(array('preregistration/index'));
		}
		$session['stepTitle'] = 'ASIC SPONSOR';
		$session['step6Subtitle'] = "&nbsp;&nbsp;>&nbsp;&nbsp;"."<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration/addAsic'>ASIC Sponsor</a>";
		unset($session['is_listed']);unset($session['requsetForVerificationEmail']);
		$model->scenario = 'preregistrationAsic';
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'add-asic-form') {
			$model->first_name=$_POST['Registration']['first_name'];
			$model->last_name=$_POST['Registration']['last_name'];
			$model->date_of_birth=date('Y-m-d',strtotime($_POST['Registration']['date_of_birth']));
			if($model->date_of_birth=='1970-01-01')
				unset($model->date_of_birth);
			else
			$model->date_of_birth=date('Y-m-d',strtotime($_POST['Registration']['date_of_birth']));	
			//echo "<pre>";
			//print_r($model->date_of_birth);
			//echo "</pre>";
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if (isset($_POST['Registration'])) 
		{
			$model->attributes = $_POST['Registration'];
			if(!empty($model->selected_asic_id))
			{
				$asicModel = Registration::model()->findByPk($model->selected_asic_id);
				$session['host'] = $asicModel->id;
				//***************** Send Email on Request ASIC SPONSOR VERIFICATION *************
				if(isset($_POST['Registration']['is_asic_verification']) && $_POST['Registration']['is_asic_verification'] == 1)
				{
					$session['requsetForVerificationEmail'] = "yes";
				}else{
					$session['is_listed'] = 0;
				}
				//*******************************************************************************
			}
			else{
				if( !empty($model->email) && !empty($model->contact_number) ){
					$model->profile_type = 'ASIC';
					$model->key_string = hash('ripemd160', uniqid());
					$model->tenant = $session['tenant'];
					$model->visitor_workstation = $session['workstation'];
					if($session['created_by']!="")
					$model->created_by = $session['created_by'];
					else
					$model->created_by=null;
					$model->role = 9; //Staff Member/Intranet
					$model->visitor_card_status = 6; //6: Asic Issued
					$model->date_created=date('Y-m-d');
					$model->company=$_POST['Company']['name'];
					
					if ($model->save(false)) 
					{
						$session['host'] = $model->id;
						//***************** Send Email on Request ASIC SPONSOR VERIFICATION *************
						if(isset($_POST['Registration']['is_asic_verification']) && $_POST['Registration']['is_asic_verification'] == 1)
						{
							$session['requsetForVerificationEmail'] = "yes";
						}
						else{
							$session['is_listed'] = 0;
						}
						//*******************************************************************************
					}
					else{
						$msg = print_r($model->getErrors(),1);
						throw new CHttpException(400,'Data not saved in for asic because: '.$msg );
					}
				}
			}
			$this->redirect(array('preregistration/uploadPhoto'));
		}
		$companyModel = new Company();
		$companyModel->scenario = 'preregistrationAddComp';

		$this->render('asic-sponsor' , array('model'=>$model,'companyModel'=>$companyModel) );
	}


	public function actionUploadPhoto()
	{
		$session = new CHttpSession;
		unset(Yii::app()->session['imgName']);
		if(!isset($session['workstation']) || empty($session['workstation']) || is_null($session['workstation'])){
			$this->redirect(array('preregistration/index'));
		}
		$session['stepTitle'] = 'PHOTO';
		$session['step7Subtitle'] = "&nbsp;&nbsp;>&nbsp;&nbsp;"."<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration/uploadPhoto'>Photo</a>";
		
		$model = new UploadForm();
	
		if(Yii::app()->request->isAjaxRequest)
		{
			if(isset($_POST['imgBase64']))
			{
			$img = $_POST['imgBase64'];
			$img = str_replace('data:image/png;base64,', '', $img);
			$img = str_replace(' ', '+', $img);
			$fileData = base64_decode($img);
			//saving
			$ext='jpg';
			$newNameHash = hash('adler32', time());
			$newName =$newNameHash.'-' . time().'.'.$ext;
			$fileName = Yii::getPathOfAlias('webroot').'/uploads/visitor/'.$newName;
			$relativeImgSrc = 'uploads/visitor/'.$newName;
			file_put_contents($fileName, $fileData);
			$photoModel = new Photo();
					$photoModel->filename = $newName;
					$photoModel->unique_filename = $newName;
					$photoModel->relative_path = $relativeImgSrc;
			        $file=file_get_contents($fileName);
			        $image = base64_encode($file);
			        $photoModel->db_image = $image;
					if($photoModel->save())
					{
						
						if (file_exists($fileName)) {
				            unlink($fileName);
				        }
				        $session['photo'] = $photoModel->id;
						$session['imgName'] = $newName;
						//$this->redirect(array('preregistration/visitDetails'));
					}
					else
					die();
			}
			elseif (isset($_FILES))
			{
				//print_r($_FILES['name']['name']);
				//Yii::app()->end();
			//$model->attributes=$_POST['UploadForm'];
			$name  = $_FILES['name']['name'];
			if(!empty($name)){
				$ext  = pathinfo($name, PATHINFO_EXTENSION);
				$newNameHash = hash('adler32', time());
				$newName    = $newNameHash.'-' . time().'.'.$ext;
				//$model->image=CUploadedFile::getInstance($model,'image');
				$fullImgSource = Yii::getPathOfAlias('webroot').'/uploads/visitor/'.$newName;
				$relativeImgSrc = 'uploads/visitor/'.$newName;
				
				if(move_uploaded_file($_FILES['name']['tmp_name'],$fullImgSource)){
					$photoModel = new Photo();
					$photoModel->filename = $name;
					$photoModel->unique_filename = $newName;
					$photoModel->relative_path = $relativeImgSrc;
			        $file=file_get_contents($fullImgSource);
			        $image = base64_encode($file);
					
			        $photoModel->db_image = $image;
					
					//print_r($photoModel->db_image);
					//Yii::app()->end();
					//$data = 
					if($photoModel->save())
					{
						//print_r($photoModel->getErrors());
						//Yii::app()->end();
						if (file_exists($fullImgSource)) {
				            unlink($fullImgSource);
				        }
				        $session['photo'] = $photoModel->id;
						$session['imgName'] = $newName;
						//$this->redirect(array('preregistration/visitDetails'));
					}
				}
			}
			else{
				Yii::app()->end();
			}
			}
		}
		
		
		$this->render('upload-photo',array('model'=>$model) );
	}

	public function actionVisitDetails()
	{
		$session = new CHttpSession;
		if(!isset($session['workstation']) || empty($session['workstation']) || is_null($session['workstation'])){
			$this->redirect(array('preregistration/index'));
		}
		$session['stepTitle'] = 'LOG VISIT DETAILS';
		$session['step8Subtitle'] = "&nbsp;&nbsp;>&nbsp;&nbsp;"."<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration/visitDetails'>Log Visit Details</a>";
		$sessionVisitor = (isset($session['visitor_model']) && ($session['visitor_model'] != "")) ? $session['visitor_model'] : $session['vic_model'];
		$visitor='';
		if(isset(Yii::app()->user->id) && !empty(Yii::app()->user->id))
		{
			if(isset($session['vic_model']) && $session['vic_model'] != ''){
				$visitor = Registration::model()->findByPk($session['vic_model']->attributes['id']);
			}else{
				$visitor = Registration::model()->findByPk(Yii::app()->user->id);
			}
		}
		else{
			$visitor = new Registration();	
		}
		$sessionVisit = $session['visit_model'];
		$model = new Visit();
		$model->detachBehavior('DateTimeZoneAndFormatBehavior');
		if(isset($_POST['Visit']))
		{
			$model->attributes = $sessionVisit->attributes;
			$model->time_in = date("H:i:s", strtotime($_POST['Visit']['time_in_hours'].":".$_POST['Visit']['time_in_minutes']));
			$model->time_out = date("H:i:s", strtotime($_POST['Visit']['time_in_hours'].":".$_POST['Visit']['time_in_minutes']. " + 24 hour"));
			$model->time_check_in = date("H:i:s", strtotime($_POST['Visit']['time_in_hours'].":".$_POST['Visit']['time_in_minutes']));
			$model->time_check_out = date("H:i:s", strtotime($_POST['Visit']['time_in_hours'].":".$_POST['Visit']['time_in_minutes']. " + 24 hour"));
			$model->date_in = $_POST['Visit']['date_in'] == "" ? date("Y-m-d",strtotime("+1 day")) : date("Y-m-d", strtotime($_POST['Visit']['date_in']));
			$model->date_out = date("Y-m-d", strtotime($model->date_in." +1 day"));
			$model->date_check_in = $_POST['Visit']['date_in'] == "" ? date("Y-m-d",strtotime("+1 day")) : date("Y-m-d", strtotime($_POST['Visit']['date_in']));
			$model->date_check_out = date("Y-m-d", strtotime($model->date_check_in." +1 day"));
			$model->host = $session['host'];
			$model->company = $sessionVisit->attributes['company']; 

			if($sessionVisit->attributes['reason'] == 'Null'){
				$model->reason = NULL;
				$model->visit_reason = $sessionVisit->attributes['visit_reason'];
			}

			if(isset($session['is_listed']) && $session['is_listed'] == 0){
				$model->is_listed = $session['is_listed'];
			}

			$visitor->attributes=$sessionVisitor->attributes;

			if(!isset($session['vic_model']) || $session['vic_model'] == ''){
				if(isset($session['photo']) && $session['photo'] != ''){
					$visitor->photo=$session['photo'];
				}
			}
			
			if($visitor->company == null || $visitor->company == ""){
				$visitor->company = $sessionVisit->attributes['company'];
			}
			if($visitor->visitor_type == null || $visitor->visitor_type == ""){
				$visitor->visitor_type = $sessionVisit->attributes['visitor_type'];
			}
			$visitor->date_created=date("Y-m-d");
			$visitor->date_of_birth=$sessionVisitor->attributes['date_of_birth'];
			//echo "<pre>";
			//print_r($visitor);
			//echo '</pre>';
			//Yii::app()->end();
			if($visitor->save(false))
			{
				$model->visitor =  $visitor->id;
				$session['visitor_id'] = $visitor->id;

				if($visitor->profile_type == "VIC"){
					$this->createVicNotificationIdentificationExpiry();
				}
				elseif($visitor->profile_type == "ASIC"){
					$this->createAsicNotificationAsicExpiry();
				}
				
				if($model->save())
				{	
					unset($session['visitor_model']);unset($session['visit_model']);unset($session['vic_model']);
					if($session['account_type'] == 'VIC')
					{
						$this->createVicNotificationPreregisterVisit($model->date_check_in);
						$this->createVicNotification20and28Visits();
					}
					elseif ($session['account_type'] == 'CORPORATE') {
						$this->createCompAdminNotificationPreregisterVisit($session['company_id'],$model->date_check_in);
						$this->createCompAdminNotification20and28Visits($session['company_id']);
					}


					$asicModel = Registration::model()->findByPk($model->host);
					$asicId=$asicModel->id;
					$this->actionCreateAsicNotificationRequestedVerifications($asicId,$model->id);

					if(isset($session['requsetForVerificationEmail']) && $session['requsetForVerificationEmail'] == "yes")
					{
						$visitId = $model->id;
			    		$email = $asicModel->email;
			    		$loggedUserEmail = 'Admin@perthairport.com.au';
			    		$this->sendEmailToASIC($loggedUserEmail,$email,$visitId);
					}
					$this->unsetVariablesForGui();

					$session['date_of_visit'] = $model->date_check_in;
					$this->redirect(array('preregistration/success'));
				}
			}else{
				$msg = print_r($visitor->getErrors(),1);
				throw new CHttpException(400,'Error in visitor saving because: '.$msg );
			}
		}
		$this->render('visit-details' , array('model'=>$model) );
	}

	public function actionRegistration()
	{

		$session = new CHttpSession;
		$session['stepTitle'] = 'CREATE AIRPORT VISITOR LOGIN';
		unset($session['step1Subtitle']);unset($session['step2Subtitle']);unset($session['step3Subtitle']);unset($session['step4Subtitle']);unset($session['step5Subtitle']);
		unset($session['step6Subtitle']);unset($session['step7Subtitle']);unset($session['step8Subtitle']);

		$model = new CreateLogin();

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'preregistration-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['CreateLogin'])) 
		{
			$model->attributes = $_POST['CreateLogin'];
			$model->account_type='VIC';
			$session['account_type'] = "VIC"; $session['username'] = $model->username; $session['password'] = $model->password;

			if($model->account_type == "VIC")
			{	
				$userModel = '';
				if(isset($session['visitor_id']) && $session['visitor_id'] != "")
				{
					$userModel = Registration::model()->findByPk($session['visitor_id']);
				}
				else
				{
					$userModel = new Registration();
				}

				$userModel->email = $model->username;
				$userModel->password = $model->password;
				$userModel->first_name = $model->fname;
				$userModel->last_name = $model->lname;
				$userModel->date_of_birth = $model->dob;
				$userModel->tenant = $model->tenant;
				$userModel->profile_type = "VIC";
				$userModel->role = 10; //role is 10: Visitor/Kiosik
				$userModel->visitor_card_status = 2; //visitor card status is 2: VIC holder
				$userModel->date_created=date("Y-m-d H:i:s");
				
				if ($userModel->save(false)) 
				{
					//echo "<pre>";
					//print_r($userModel);
					//echo"</pre>";
					//Yii::app()->end();
					//**********************************************
					$loginModel = new PreregLogin();

					$loginModel->username = $userModel->email;
					$loginModel->password = $model->password;
						//echo $loginModel->password;
						//Yii::app()->end();
					if ($loginModel->validate() && $loginModel->login())
					{
						$this->redirect(array('preregistration/dashboard'));
					}
					else
					{
						$msg = print_r($loginModel->getErrors(),1);
						throw new CHttpException(400,'Not logged in because: '.$msg );
					}
					//***********************************************
				}
				else{
					$msg = print_r($model->getErrors(),1);
					throw new CHttpException(400,'Data not saved because: '.$msg );
				}

			}
			elseif ($model->account_type == "ASIC") 
			{
				$this->redirect(array('preregistration/asicPrivacyPolicy'));
			}
			else
			{
				$this->redirect(array('preregistration/compAdminPrivacyPolicy'));
			}
			$this->redirect(array('preregistration/personalDetails'));
		}
		$preModel = new PreregLogin();
		$this->render('registration', array('model' => $model,'preModel' => $preModel));
	}

	public function actionAsicRegistration()
	{
		$session = new CHttpSession;

		$session['stepTitle'] = 'ASIC SPONSOR DETAILS';

		$session['step3Subtitle'] = "&nbsp;&nbsp;>&nbsp;&nbsp;"."<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration/asicRegistration'>ASIC Sponsor Details</a>";
		
		unset($session['step4Subtitle']);unset($session['step5Subtitle']);
		unset($session['step6Subtitle']);unset($session['step7Subtitle']);unset($session['step8Subtitle']);

		$model = '';
		if(isset($session['visitor_id']) && $session['visitor_id'] != "")
		{
			$model = Registration::model()->findByPk($session['visitor_id']);
		}
		else
		{
			$model = new Registration();
		}

		$model->scenario = "preregistrationAsic";

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'add-asic-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['Registration'])) 
		{	
			$model->attributes = $_POST['Registration'];

			$model->email = $session['username'];
			$model->password = User::model()->hashPassword($session['password']);

			$model->asic_no = $_POST['Registration']['asic_no'];
			$model->asic_expiry = $_POST['Registration']['asic_expiry'];

			if(empty($model->company) || $model->company == "" || $model->company == null){
				$model->company = $_POST['Registration']['company'];
			}
			
			if(empty($model->visitor_workstation) || $model->visitor_workstation == "" || $model->visitor_workstation == null){
				$model->visitor_workstation = $_POST['Registration']['visitor_workstation'];
			}

			if(empty($model->tenant) || $model->tenant == "" || $model->tenant == null){
				$workstation = Workstation::model()->findByPk($_POST['Registration']['visitor_workstation']);
				$model->tenant = $workstation->tenant;
			}

			$model->profile_type = "ASIC";
			$model->role = 10; //role is 10: Visitor/Kiosik
			$model->visitor_card_status = 2; //visitor card status is 2: VIC holder

			if ($model->save(false)) 
			{
				//**********************************************
				$loginModel = new PreregLogin();

				$loginModel->username = $model->email;
				$loginModel->password = $session['password'];

				if ($loginModel->validate() && $loginModel->login())
				{
					$this->redirect(array('preregistration/dashboard'));
				}
				else
				{
					$msg = print_r($loginModel->getErrors(),1);
					throw new CHttpException(400,'Not redirected because: '.$msg );
				}
				//***********************************************
			}
			else
			{
				$msg = print_r($model->getErrors(),1);
				throw new CHttpException(400,'Data not saved because: '.$msg );
			}
		}

		$companyModel = new Company();
		$companyModel->scenario = 'preregistration';

		$this->render('asic-create-login' , array('model'=>$model,'companyModel'=>$companyModel) );

	}

	public function actionCompanyAdminRegistration()
	{
		$session = new CHttpSession;

		$session['stepTitle'] = 'COMPANY INFORMATION';
		$session['step3Subtitle'] = "&nbsp;&nbsp;>&nbsp;&nbsp;"."<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration/companyAdminRegistration'>Company Information</a>";
		unset($session['step4Subtitle']);unset($session['step5Subtitle']);
		unset($session['step6Subtitle']);unset($session['step7Subtitle']);unset($session['step8Subtitle']);

		$model = '';
		if(isset($session['visitor_id']) && $session['visitor_id'] != "")
		{
			$model = Registration::model()->findByPk($session['visitor_id']);
		}
		else
		{
			$model = new Registration();
		}

		$model->scenario = 'preregistrationCompanyAdmin';

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'add-companyAdmin-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['Registration'])) 
		{
			$model->attributes = $_POST['Registration'];
			
			$model->first_name = $_POST['Registration']['first_name'];
			$model->last_name = $_POST['Registration']['last_name'];
			$model->contact_number = $_POST['Registration']['contact_number'];
			$model->email = $session['username'];
			$model->password = User::model()->hashPassword($session['password']);
			

			if(empty($model->company) || $model->company == "" || $model->company == null){
				$model->company = $_POST['Registration']['company'];
			}
			
			if(empty($model->visitor_workstation) || $model->visitor_workstation == "" || $model->visitor_workstation == null){
				$model->visitor_workstation = $_POST['Registration']['visitor_workstation'];
			}

			if(empty($model->tenant) || $model->tenant == "" || $model->tenant == null){
				$workstation = Workstation::model()->findByPk($_POST['Registration']['visitor_workstation']);
				$model->tenant = $workstation->tenant;
			}

			$model->profile_type = "CORPORATE";
			$model->role = 10; //role is 10: Visitor/Kiosik
			$model->visitor_card_status = 2; //visitor card status is 2: VIC holder

			if ($model->save(false)) 
			{
				//**********************************************
				$company = new Company();
				$company->name = $_POST['Registration']['first_name'];
                $company->contact = $_POST['Registration']['first_name'] . ' ' . $_POST['Registration']['last_name'];
                $company->email_address = $_POST['Registration']['email'];
                $company->mobile_number = $_POST['Registration']['contact_number'];
                $company->office_number = $_POST['Registration']['contact_number'];                
                
                //$company->created_by_user = $session['created_by'];
                $company->tenant = $model->tenant;

               	$company->created_by_visitor  = $model->id;
                $company->company_type = 3;
                if ($company->tenant_agent == '') {$company->tenant_agent = NULL;}
                if ($company->code == '') {$company->code = strtoupper(substr($company->name, 0, 3));}
				//************6****************************************************************************************************************
                if ($company->save(false)) 
                {
                	//integrity constraint violation fix.
                    //From preregisteration set attribute from session as it was set in session 
                    //for USER because Yii:app()->user->id in preregistration has Visitor Id and not USER id.
                    //If wrong handled then it will throws Integrity Constraint Violation as foreign key 
                    //of created_by in user refers to User table and not visitor table 
                	$command = Yii::app()->db->createCommand();
					$result=$command->insert('user',array(
                    							//'id'=>it is autoincrement,
                                                'company'=>$company->id,
                                                'first_name'=>$_POST['Registration']['first_name'],
                                                'last_name'=>$_POST['Registration']['first_name'],
                                                'email'=>$_POST['Registration']['email'],
                                                'contact_number'=>$_POST['Registration']['contact_number'],
                                                'timezone_id'=>1,
                                                'photo'=>NULL,
                                                'tenant'=> $company->tenant,
                                                'user_type'=>1,
                                                'user_status'=>1,
                                                'role'=>9,
                                                //'created_by'=>$company->created_by_user
                                            ));
                }
				//****************************************************************************************************************************
				//**********************************************

				//**********************************************
				$loginModel = new PreregLogin();

				$loginModel->username = $model->email;
				$loginModel->password = $session['password'];

				if ($loginModel->validate() && $loginModel->login())
				{
					$this->redirect(array('preregistration/dashboard'));
				}
				else
				{
					$msg = print_r($loginModel->getErrors(),1);
					throw new CHttpException(400,'Not redirected because: '.$msg );
				}
				//***********************************************
			}
			else
			{
				$msg = print_r($model->getErrors(),1);
				throw new CHttpException(400,'Data not saved because: '.$msg );
			}
		}
		$companyModel = new Company();
		$companyModel->scenario = 'preregistration';
		$this->render('companyadmin-create-login' , array('model'=>$model,'companyModel'=>$companyModel) );
	}

	public function actionAjaxAsicSearch(){
		//changed on 24/10/2016
		if(isset($_POST['search_value']) && !empty($_POST['search_value'])){
			$searchValue = trim($_POST['search_value']);
			$purifier = new CHtmlPurifier();
			$searchValue = $purifier->purify($searchValue);
			$tenantId=$_POST['tenant'];

			if (filter_var($searchValue, FILTER_VALIDATE_EMAIL)) {
				$model =  Registration::model()->findAllByAttributes(
					array(
						'email'=>$searchValue,
						'profile_type'=>'ASIC',
					)
				);
				if(!empty($model)){
					/*foreach($model as $data){
						echo '<tr>
						<th scope="row">
							<input type="radio" name="selected_asic" class="selected_asic" value="'.$data->id.'">
						</th>
						<td>'.$data->first_name.'</td>
						<td>'.$data->last_name.'</td>
						<td>'.$data->visitorStatus->name.'</td>
					</tr>';
					}*/
					foreach($model as $data){
						$companyModel = Company::model()->findByPk($data->company);
						if(!empty($companyModel)){
							$companyName = $companyModel->name;
						}
						else{
							$companyName = '-';
						}
						$dataSet[] = array('<input type="radio" name="selected_asic" class="selected_asic" value='.$data->id.'>',$data->first_name,$data->last_name,$companyName);
					}
					echo json_encode($dataSet);
				}
				else{
					echo "No Record";
				}
			}
			else{

				$connection=Yii::app()->db;
				$sql="SELECT * FROM visitor WHERE
					  (first_name LIKE '%$searchValue%' OR last_name LIKE '%$searchValue%')
					  AND profile_type = 'ASIC' AND is_deleted=0 and tenant='$tenantId'";

				$command = $connection->createCommand($sql);

				$records = $command->queryAll();

				if(!empty($records)){
					foreach($records as $data){
						//$dataSet = array();
						$companyModel = Company::model()->findByPk($data['company']);
						if(!empty($companyModel)){
							$companyName = $companyModel->name;
						}
						else{
							$companyName = '-';
						}
						$dataSet[] = array('<input type="radio" name="selected_asic" class="selected_asic" value="'.$data['id'].'">',$data['first_name'],$data['last_name'],$companyName);
					}
					echo json_encode($dataSet);
				}
				else{
					echo "No Record";
				}
			}
		}
		else{
			throw new CHttpException(400,'Unable to solve the request');
		}
	}

	public function actionAjaxVICHolderSearch(){

		if(isset($_POST['search_value']) && !empty($_POST['search_value'])){

			$searchValue = trim($_POST['search_value']);
			$purifier = new CHtmlPurifier();
			$searchValue = $purifier->purify($searchValue);

			$connection=Yii::app()->db;

			$sql = "";
			if(Yii::app()->user->account_type == "ASIC"){
				$sql="SELECT * FROM visitor WHERE
					  (first_name LIKE '%$searchValue%' OR last_name LIKE '%$searchValue%' OR email LIKE '%$searchValue%')
					  AND profile_type = 'VIC' AND is_deleted=0";
			}
			elseif (Yii::app()->user->account_type == "CORPORATE") {
				$corporateVisitor = Registration::model()->findByPk(Yii::app()->user->id);
				$compId = $corporateVisitor->company;

				$sql="SELECT * FROM visitor WHERE
					  (first_name LIKE '%$searchValue%' OR last_name LIKE '%$searchValue%' OR email LIKE '%$searchValue%')
					  AND profile_type = 'VIC' AND is_deleted=0 AND company='$compId'";
			}
			$command = $connection->createCommand($sql);
			$records = $command->queryAll();
			if(!empty($records)){
				foreach($records as $data){
					//$dataSet = array();
					$companyModel = Company::model()->findByPk($data['company']);
					if(!empty($companyModel)){
						$companyName = $companyModel->name;
					}
					else{
						$companyName = '-';
					}
					$dataSet[] = array('<input type="radio" name="selected_asic" class="selected_asic" value="'.$data['id'].'">',$data['first_name'],$data['last_name'],$companyName);
				}
				echo json_encode($dataSet);
			}
			else{
				echo "No Record";
			}
		}
		else{
			throw new CHttpException(400,'Unable to solve the request');
		}
	}


	public function createCompAdminNotificationPreregisterVisit($company_id,$date_of_visit){
		//create Company Admin Notifications: 1. VIC Holder in your company has Preregistered a Visit
		$session = new CHttpSession;
		$cond = "company=".$company_id." and profile_type='CORPORATE'";
		$companyAdmins = Registration::model()->findAll($cond);
		if($companyAdmins){
	    	$notification = new Notification();
			$notification->created_by = null;
	        $notification->date_created = date("Y-m-d");
	        $notification->subject = 'VIC Holder in your company has Preregistered a Visit';
	        $notification->message = 'VIC Holder in your company has Preregistered a Visit ('.$date_of_visit.')';
	        $notification->notification_type = 'Company Notification';
	        $notification->role_id = 10;
	        if($notification->save()){
	        	foreach ($companyAdmins as $key => $companyAdmin) {
					$notify = new UserNotification;
		            $notify->user_id = $companyAdmin->id;
		            $notify->notification_id = $notification->id;
		            $notify->has_read = 0; //Not Yet
		            $notify->save();
				}
        	}
		}
	}

	public function createCompAdminNotification20and28Visits($company_id){
		//create Company Admin Notifications: 2. VIC Holder in your company has reached their 20 day visit count
		$session = new CHttpSession;
		$cond = "company=".$company_id." and profile_type='CORPORATE'";
		$companyAdmins = Registration::model()->findAll($cond);

		if($companyAdmins){
			foreach ($companyAdmins as $key => $companyAdmin) {
				$visits = Yii::app()->db->createCommand()
                    ->select("t.id") 
                    ->from("visit t")
                    ->join("visitor v","v.id = t.visitor")
                    ->join("company c","c.id = v.company")
                    ->join("visit_status vs","vs.id = t.visit_status")
                    ->where("(vs.name='Pre-registered' AND t.is_deleted = 0 AND v.is_deleted =0 AND v.id=".$session['visitor_id'].")")
                    ->queryAll();
				$visitCount = count($visits);

				if($visitCount == 20){
					//create Company Admin Notifications: 2. You have reached a Visit Count of 20 days
					$notification = Notification::model()->findByAttributes(array('subject'=>'VIC Holder in your company has reached their 20 day visit count'));
					if($notification){
						$notify = new UserNotification;
		                $notify->user_id = $companyAdmin->id;
		                $notify->notification_id = $notification->id;
		                $notify->has_read = 0; //Not Yet
		                $notify->save();
					}else{
						$notification = new Notification();
						$notification->created_by = null;
		                $notification->date_created = date("Y-m-d");
		                $notification->subject = 'VIC Holder in your company has reached their 20 day visit count';
		                $notification->message = 'VIC Holder in your company has reached their 20 day visit count';
		                $notification->notification_type = 'Company Notification';
		                $notification->role_id = 10;
		                if($notification->save()){
		                	$notify = new UserNotification;
		                    $notify->user_id = $companyAdmin->id;
		                    $notify->notification_id = $notification->id;
		                    $notify->has_read = 0; //Not Yet
		                    $notify->save();
		                }	
					}
				}

				if($visitCount == 28){
					//create Company Admin Notifications: 3. VIC Holder in your company has reached their 28 day limit
					$notification = Notification::model()->findByAttributes(array('subject'=>'VIC Holder in your company has reached their 28 day limit'));
					if($notification){
						$notify = new UserNotification;
		                $notify->user_id = $companyAdmin->id;
		                $notify->notification_id = $notification->id;
		                $notify->has_read = 0; //Not Yet
		                $notify->save();
					}else{
						$notification = new Notification();
						$notification->created_by = null;
		                $notification->date_created = date("Y-m-d");
		                $notification->subject = 'VIC Holder in your company has reached their 28 day limit';
		                $notification->message = 'VIC Holder in your company has reached their 28 day limit';
		                $notification->notification_type = 'Company Notification';
		                $notification->role_id = 10;
		                if($notification->save()){
		                	$notify = new UserNotification;
		                    $notify->user_id = $companyAdmin->id;
		                    $notify->notification_id = $notification->id;
		                    $notify->has_read = 0; //Not Yet
		                    $notify->save();
		                }	
					}
				}

			}
		}

	}

    public function createVicNotificationPreregisterVisit($date_of_visit) {
    	//create VIC Notifications: 1. You have Preregistered a Visit
    	$session = new CHttpSession;
    	$notification = new Notification();
		$notification->created_by = null;
        $notification->date_created = date("Y-m-d");
        $notification->subject = 'You have Preregistered a Visit';
        $notification->message = 'You have Preregistered a Visit ('.$date_of_visit.')';
        $notification->notification_type = 'VIC Holder Notification';
        $notification->role_id = 10;
        if($notification->save()){
        	$notify = new UserNotification;
            $notify->user_id = $session['visitor_id'];
            $notify->notification_id = $notification->id;
            $notify->has_read = 0; //Not Yet
            $notify->save();
        }
    }

    public function createVicNotification20and28Visits() {
    	$session = new CHttpSession;
        $visits = Yii::app()->db->createCommand()
                    ->select("t.id") 
                    ->from("visit t")
                    ->join("visitor v","v.id = t.visitor")
                    ->join("visit_status vs","vs.id = t.visit_status")
                    ->where("(vs.name='Pre-registered' AND t.is_deleted = 0 AND v.is_deleted =0 AND v.id=".$session['visitor_id'].")")
                    ->queryAll();
		$visitCount = count($visits);

		if($visitCount == 20){
			//create VIC Notifications: 2. You have reached a Visit Count of 20 days
			$notification = Notification::model()->findByAttributes(array('subject'=>'You have reached a Visit Count of 20 days'));
			if($notification){
				$notify = new UserNotification;
                $notify->user_id = $session['visitor_id'];
                $notify->notification_id = $notification->id;
                $notify->has_read = 0; //Not Yet
                $notify->save();
			}else{
				$notification = new Notification();
				$notification->created_by = null;
                $notification->date_created = date("Y-m-d");
                $notification->subject = 'You have reached a Visit Count of 20 days';
                $notification->message = 'You have reached a Visit Count of 20 days';
                $notification->notification_type = 'VIC Holder Notification';
                $notification->role_id = 10;
                if($notification->save()){
                	$notify = new UserNotification;
                    $notify->user_id = $session['visitor_id'];
                    $notify->notification_id = $notification->id;
                    $notify->has_read = 0; //Not Yet
                    $notify->save();
                }	
			}
		}

		if($visitCount == 28){
			//create VIC Notifications: 3. You have reached your 28 Day Visit Count Limit
			$notification = Notification::model()->findByAttributes(array('subject'=>'You have reached your 28 Day Visit Count Limit'));
			if($notification){
				$notify = new UserNotification;
                $notify->user_id = $session['visitor_id'];
                $notify->notification_id = $notification->id;
                $notify->has_read = 0; //Not Yet
                $notify->save();
			}else{
				$notification = new Notification();
				$notification->created_by = null;
                $notification->date_created = date("Y-m-d");
                $notification->subject = 'You have reached your 28 Day Visit Count Limit';
                $notification->message = 'You have reached your 28 Day Visit Count Limit';
                $notification->notification_type = 'VIC Holder Notification';
                $notification->role_id = 10;
                if($notification->save()){
                	$notify = new UserNotification;
                    $notify->user_id = $session['visitor_id'];
                    $notify->notification_id = $notification->id;
                    $notify->has_read = 0; //Not Yet
                    $notify->save();
                }	
			}
		}
    }

   	public function createVicNotificationVerifiedYourVisit($visit)
    {
    	//create VIC Notifications: 4. ASIC Sponsor has verified your visit
    	$host = Registration::model()->findByPk($visit->host);
		$notification = new Notification();
		$notification->created_by = null;
        $notification->date_created = date("Y-m-d");
        $notification->subject = 'ASIC Sponsor has verified your visit';
        $notification->message = 'ASIC Sponsor has verified your visit (ASIC Sponsor Name: '.$host->first_name.' '.$host->last_name.' Date: '.date("d-m-Y",strtotime($visit->date_check_in)).' Time: '.$visit->time_check_in.')';
        $notification->notification_type = 'VIC Holder Notification';
        $notification->role_id = 10;
        if($notification->save()){
        	$notify = new UserNotification;
            $notify->user_id = $visit->visitor;
            $notify->notification_id = $notification->id;
            $notify->has_read = 0; //Not Yet
            $notify->save();
        }
    }

    public function createVicNotificationDeclinedYourVisit($visit)
    {
    	//create VIC Notifications: 4. ASIC Sponsor has declined your visit
    	$host = Registration::model()->findByPk($visit->host);
		$notification = new Notification();
		$notification->created_by = null;
        $notification->date_created = date("Y-m-d");
        $notification->subject = 'ASIC Sponsor has rejected your visit';
        $notification->message = 'ASIC Sponsor has rejected your visit (ASIC Sponsor Name: '.$host->first_name.' '.$host->last_name.' Date: '.date("d-m-Y",strtotime($visit->date_check_in)).' Time: '.$visit->time_check_in.')';
        $notification->notification_type = 'VIC Holder Notification';
        $notification->role_id = 10;
        if($notification->save()){
        	$notify = new UserNotification;
            $notify->user_id = $visit->visitor;
            $notify->notification_id = $notification->id;
            $notify->has_read = 0; //Not Yet
            $notify->save();
        }
    }


    public function createVicNotificationIdentificationExpiry()
    {
    	$session = new CHttpSession;
    	$visitor = '';
    	if(isset(Yii::app()->user->id) && Yii::app()->user->id != ""){
    		$visitor = Registration::model()->findByPk(Yii::app()->user->id);
    	}else{
    		$visitor = Registration::model()->findByPk($session['visitor_id']);
    	}

    	$notifications = Yii::app()->db->createCommand()
                    ->select("*") 
                    ->from("notification n")
                    ->join("user_notification u","n.id = u.notification_id")
                    ->where("u.has_read = 0 AND u.user_id = " . $visitor->id)
                    ->order("u.notification_id DESC")
                    ->queryAll();

        if(!$notifications){
	    	if($visitor->identification_document_expiry != "" && $visitor->identification_document_expiry != null){
	    		$day_before = date( 'Y-m-d', strtotime($visitor->identification_document_expiry.' -8 days' ) );
				$today = date('Y-m-d');
				
				if ( strtotime($day_before) <= strtotime($today) ){
					//create VIC Notifications: 5. Your Identification is about to expiry please update
					$notification = Notification::model()->findByAttributes(array('subject'=>'Your Identification is about to expire'));
					if($notification){
						$notify = new UserNotification;
			            $notify->user_id = $session['visitor_id'] == "" ? Yii::app()->user->id : $session['visitor_id'];
			            $notify->notification_id = $notification->id;
			            $notify->has_read = 0; //Not Yet
			            $notify->save();
					}else{
						$notification = new Notification();
						$notification->created_by = null;
			            $notification->date_created = date("Y-m-d");
			            $notification->subject = 'Your Identification is about to expire';
			            $notification->message = 'Your Identification is about to expire (Please update your Profile)';
			            $notification->notification_type = 'VIC Holder Notification';
			            $notification->role_id = 10;
			            if($notification->save()){
			            	$notify = new UserNotification;
			                $notify->user_id = $session['visitor_id'] == "" ? Yii::app()->user->id : $session['visitor_id'];
			                $notify->notification_id = $notification->id;
			                $notify->has_read = 0; //Not Yet
			                $notify->save();
			            }	
					}
				}
	    	}
	    }
    }

    public function actionCreateAsicNotificationRequestedVerifications($asicId,$visitId)
    {
    	$emailFlag = ''; 
    	if(isset($_POST['sentEmail']))
    	{
    		$emailFlag = $_POST['sentEmail'];
    	}
    	
    	//create VIC Notifications: 1. VIC Holder has requested ASIC Sponsor verification
		$notification = Notification::model()->findByAttributes(array('subject'=>'VIC Holder has requested ASIC Sponsor verification'));
		if($notification){
			$notify = new UserNotification;
            $notify->user_id = $asicId;
            $notify->notification_id = $notification->id;
            $notify->has_read = 0; //Not Yet
            $notify->verify_visit_id = $visitId;
            $notify->save();
            if(($emailFlag != "") && ($emailFlag == "yes"))
	    	{
	    		$asicModel = Registration::model()->findByPk($asicId);
	    		$email = $asicModel->email;
	    		$loggedUserEmail = 'Admin@perthairport.com.au';
	    		$this->sendEmailToASIC($loggedUserEmail,$email,$visitId);
	    	}
		}else{
			$notification = new Notification();
			$notification->created_by = null;
            $notification->date_created = date("Y-m-d");
            $notification->subject = 'VIC Holder has requested ASIC Sponsor verification';
            $notification->message = 'VIC Holder has requested ASIC Sponsor verification';
            $notification->notification_type = 'ASIC Notification';
            $notification->role_id = 10;
            if($notification->save()){
            	$notify = new UserNotification;
                $notify->user_id = $asicId;
                $notify->notification_id = $notification->id;
                $notify->has_read = 0; //Not Yet
                $notify->verify_visit_id = $visitId;
                $notify->save();
                if(($emailFlag != "") && ($emailFlag == "yes"))
		    	{
		    		$asicModel = Registration::model()->findByPk($asicId);
		    		$email = $asicModel->email;
		    		$loggedUserEmail = 'Admin@perthairport.com.au';
	    			$this->sendEmailToASIC($loggedUserEmail,$email,$visitId);
		    	}
            }	
		}
    }

    public function createAsicNotificationAssignedVicHolder($visit)
    {
    	//create VIC Notifications: 2. ASIC Sponsor has assigned you a VIC holder Verification 
		$notification = Notification::model()->findByAttributes(array('subject'=>'ASIC Sponsor has assigned you a VIC holder Verification '));
		if($notification){
			//************** EMAIL SENDING *****************************
			$loggedUserEmail = Yii::app()->user->email;
			$asic = Registration::model()->findByPk($visit->host);
			$toEmail=$asic->email;
			$visitId = $visit->id;
			$this->sendEmailToASIC($loggedUserEmail,$toEmail,$visitId);
			//***********************************************************	
			$notify = new UserNotification;
            $notify->user_id = $visit->host;
            $notify->notification_id = $notification->id;
            $notify->has_read = 0; //Not Yet
            $notify->verify_visit_id = $visit->id;
            $notify->save();
		}else{
			$notification = new Notification();
			$notification->created_by = null;
            $notification->date_created = date("Y-m-d");
            $notification->subject = 'ASIC Sponsor has assigned you a VIC holder Verification';
            $notification->message = 'ASIC Sponsor has assigned you a VIC holder Verification';
            $notification->notification_type = 'ASIC Notification';
            $notification->role_id = 10;
            if($notification->save())
            {
            	//************** EMAIL SENDING *****************************
				$loggedUserEmail = Yii::app()->user->email;
				$asic = Registration::model()->findByPk($visit->host);
				$toEmail=$asic->email;
				$visitId = $visit->id;
				$this->sendEmailToASIC($loggedUserEmail,$toEmail,$visitId);
				//***********************************************************
            	$notify = new UserNotification;
                $notify->user_id = $visit->host;
                $notify->notification_id = $notification->id;
                $notify->has_read = 0; //Not Yet
                $notify->verify_visit_id = $visit->id;
                $notify->save();
            }	
		}
    }

    public function createAsicNotificationAsicExpiry()
    {
    	$session = new CHttpSession;
    	$visitor = '';
    	if(isset(Yii::app()->user->id) && Yii::app()->user->id != ""){
    		$visitor = Registration::model()->findByPk(Yii::app()->user->id);
    	}else{
    		$visitor = Registration::model()->findByPk($session['visitor_id']);
    	}

    	$notifications = Yii::app()->db->createCommand()
            ->select("*") 
            ->from("notification n")
            ->join("user_notification u","n.id = u.notification_id")
            ->where("u.has_read = 0 AND u.user_id = " . $visitor->id)
            ->order("u.notification_id DESC")
            ->queryAll();

        if(!$notifications){
        	if($visitor->asic_expiry != "" && $visitor->asic_expiry != null){
	    		$day_before = date( 'Y-m-d', strtotime($visitor->asic_expiry.' -8 days' ) );
				$today = date('Y-m-d');
				
				if ( strtotime($day_before) <= strtotime($today) ){
					//create VIC Notifications: 3. Your ASIC is about to Expire
					$notification = Notification::model()->findByAttributes(array('subject'=>'Your ASIC is about to Expire'));
					if($notification){
						$notify = new UserNotification;
			            $notify->user_id = $session['visitor_id'] == "" ? Yii::app()->user->id : $session['visitor_id'];
			            $notify->notification_id = $notification->id;
			            $notify->has_read = 0; //Not Yet
			            $notify->save();
					}else{
						$notification = new Notification();
						$notification->created_by = null;
			            $notification->date_created = date("Y-m-d");
			            $notification->subject = 'Your ASIC is about to Expire';
			            $notification->message = 'Your ASIC is about to Expire (Apply for an ASIC or Update your Profile)';
			            $notification->notification_type = 'ASIC Notification';
			            $notification->role_id = 10;
			            if($notification->save()){
			            	$notify = new UserNotification;
			                $notify->user_id = $session['visitor_id'] == "" ? Yii::app()->user->id : $session['visitor_id'];
			                $notify->notification_id = $notification->id;
			                $notify->has_read = 0; //Not Yet
			                $notify->save();
			            }	
					}
				}
	    	}
	    }	
    }

	public function actionSuccess()
	{	
		$session = new CHttpSession;
		$session['stepTitle'] = 'CREATE LOGIN';
		
		/*if(!isset($session['workstation']) || empty($session['workstation']) || is_null($session['workstation'])){
			$this->redirect(array('preregistration/index'));
		}*/

		//$model = Registration::model()->findByPk($session['visitor_id']);
		
		if(isset(Yii::app()->user->id) && !empty(Yii::app()->user->id)){//if they are logged in, redirect to visit history page
			$this->redirect(array('preregistration/visitHistory'));
		}
		//elseif(!isset($model->password) || ($model->password =="") || ($model->password == null)){//if he has not created a login, redirect to create login
			$this->render('success');
		//}
	}

	public function actionSaved()
	{	
		$session = new CHttpSession;
		$session['stepTitle'] = 'ASIC APPLICATION SAVED';
		
	
		
			$this->render('saved');
	
	}
	public function actionAsicSuccess()
	{	
		$session = new CHttpSession;
		$session['stepTitle'] = 'ASIC APPLICATION SUBMITTED SUCCESSFULLY';
		
	
		
			$this->render('asicsuccess');
	
	}
	public function actionStop()
	{	
		$session = new CHttpSession;
		$session['stepTitle'] = 'CANNOT CONTINUE WITH THE APPLICATION';
		
	
		
			$this->render('Astop');
	
	}
	public function actionAsicPass(){
		if(
			isset($_GET['id'], $_GET['email'], $_GET['k_str']) &&
			!empty($_GET['id']) && !empty($_GET['email']) && !empty($_GET['k_str'])
		){
			$model = Registration::model()->findByPk($_GET['id']);

			$model->scenario = 'asic-pass';
			if(!empty($model)){
				if( $model->key_string === $_GET['k_str'] || $model->key_string=null){
					$model->password = '';

					if (isset($_POST['Registration'])) {

						$model->attributes = $_POST['Registration'];
						$model->key_string = null;
						if($model->save()){
							$this->redirect(array('preregistration/login'));
						}
					}

					$this->render('asic-password', array('model' => $model));
				}
				else{
					throw new CHttpException(403,'Unable to solve the request');
				}
			}
			else{
				throw new CHttpException(403,'Unable to solve the request');
			}

		}
		else{
			throw new CHttpException(400,'Unable to solve the request');
		}
	}

	public function actionLogin(){

		Yii::app()->session->destroy();

		$model = new PreregLogin();

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'prereg-login-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['PreregLogin'])) {

			$model->attributes = $_POST['PreregLogin'];

			if ($model->validate() && $model->login()) {

				$session = new CHttpSession;

				if(Yii::app()->user->account_type == "VIC"){
					$this->createVicNotificationIdentificationExpiry();
				}
				elseif(Yii::app()->user->account_type == "ASIC") {
					$this->createAsicNotificationAsicExpiry();
				}

				$this->redirect(array('preregistration/dashboard'));
			}
		}
		$this->render('prereg-login', array('model' => $model));

	}

	//**************************************************************************************
	/**
     * Forgot password
    */
    public function actionForgot() {

        $model = new PreregPasswordForgot();

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'forgot-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['PreregPasswordForgot'])) {
            $model->attributes = $_POST['PreregPasswordForgot'];
            if ($model->validate() && $model->restore()) {
                Yii::app()->user->setFlash('success', "Please check your email for reset password instructions");
                $this->redirect(array('preregistration/login'));
            }
        }

        $this->render('forgot', array('model' => $model));
    }

    /**
     * Reset password
     */
    public function actionReset() {

        $model = new PreregPasswordResetForm();

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'password-reset-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        $hash = Yii::app()->request->getParam('hash');
		
        /** @var PreregPasswordChangeRequest $passwordRequest */
        $passwordRequest = PreregPasswordChangeRequest::model()->findByAttributes(array('hash' => $hash));
		
        if (!$passwordRequest) {
            Yii::app()->user->setFlash('error', "Reset password hash '$hash' not found. Looks like your reset password link is broken.");
        }
		 if ($error = $passwordRequest->checkPasswordRequestByHash()) {
            Yii::app()->user->setFlash('error', $error);
            $this->redirect(array('preregistration/forgot'));
        }

        if (isset($_POST['PreregPasswordResetForm'])) {
            $model->attributes = $_POST['PreregPasswordResetForm'];
            if ($model->validate()) {
                /** @var User $user */
                $visitor = Registration::model()->findByPk($passwordRequest->visitor_id);
                $visitor->changePassword($model->password);
                $passwordRequest->markAsUsed($visitor);
                Yii::app()->user->setFlash('success', "Your password has been changed successfully");
                $this->redirect(array('preregistration/login'));
            }
        }

        $this->render('prereg-reset', array('model' => $model));
    }


    public function actionProfile($id)
    {
    	$this->unsetVariablesForGui();

    	$session = new CHttpSession;

    	$model = $this->loadModel($id);
		
        $model->scenario = 'preregistrationPass';

    	$new_passwordErr='';$repeat_passwordErr='';$old_passwordErr = '';

    	$companyModel = Company::model()->findByPk($model->company);
		

    	$cond="";
    	/*if(isset($companyModel)){
			$cond=isset($_POST['Registration'],$_POST['Company']);
			//print_r($_POST);
			}*/
		//else{
			//print_r($_POST);
			$cond=isset($_POST['Registration']);
			//}

        if (isset($_POST['Registration'])) 
        {	
        	$model->attributes = $_POST['Registration'];
        	//if(isset($companyModel)){$companyModel->attributes = $_POST['Company'];}
			print_r('here');
           // if( $_POST['Registration']['old_password'] =="" && $_POST['Registration']['new_password'] =="" && $_POST['Registration']['repeat_password']=="")
            //{	print_r('here1');
            	//**********************************************************************************
            	//****************************************************************
					//this is because to pass the validation rules for visitor
		        	if(empty($model->visitor_card_status) || is_null($model->visitor_card_status)){
		        		$model->visitor_card_status = 1; //saved
		        	}
		            /*
					* This removes Integrity Constraint Issue
		            */
		            if(!empty($_POST['Registration']['visitor_type'])){
						$model->visitor_type = $_POST['Registration']['visitor_type'];             	
		            }else{
		            	$model->visitor_type = NULL;             	
		            }

		            /*
					* This removes Integrity Constraint Issue
		            */
		            if($model->photo == null){
						$model->photo = NULL;               	
		            }

		            /*if(isset($companyModel)){
		            	$companyModel->created_by_visitor = $model->id;
				    	//$companyModel->mobile_number = $_POST['Company']['mobile_number'];
				    	//$companyModel->tenant = Yii::app()->user->tenant;
					}*/


		            $model->password_saver = "";

		            /*if($model->validate())
		            {*/
		            	if($model->save(false))
				        {
				        	/*if(isset($companyModel))
				        	{	
				        		//if($companyModel->validate())
					        	//{
					        		if ($companyModel->save(false)) 
						            {
										Yii::app()->user->setFlash('success', "Profile Updated Successfully.");
									}
									else
									{
										Yii::app()->user->setFlash('error', "Something went wrong. Please, try again.");
										$msg = print_r($companyModel->getErrors(),1);
										throw new CHttpException(400,'Data not saved in company because: '.$msg );
									}
					        	//}
					        	else
					        	{
					        		Yii::app()->user->setFlash('error', "Something went wrong. Please, try again.");
									$msg = print_r($companyModel->getErrors(),1);
									throw new CHttpException(400,'Data not saved in company because: '.$msg );
					        	}*/

				        	//}else{
				        		Yii::app()->user->setFlash('success', "Profile Updated Successfully.");
				        	//}
				        }
				        else
				        {
				        	Yii::app()->user->setFlash('error', "Something went wrong. Please, try again.");
				        	$msg = print_r($model->getErrors(),1);
							throw new CHttpException(400,'Data not saved in visitor because: '.$msg );
				        }
		            /*}
		            else
		            {
		            	Yii::app()->user->setFlash('error', "Something went wrong. Please, try again.");
				        $msg = print_r($model->getErrors(),1);
						throw new CHttpException(400,'Data not saved in visitor because: '.$msg );
		            }*/
            	//**********************************************************************************
            //}
            /*else
            {
				print_r('here2');
            	//**********************************************************************************
            	if( ($model->old_password !="") && ($model->new_password=="" || $model->repeat_password=="") )
	            {
	            	if($model->new_password==""){$new_passwordErr = "Please enter new password";}else{$repeat_passwordErr = "Please enter repeat password";}	            
	            }
	            else
	            {

	            	if(crypt($model->old_password, $model->password) === $model->password) 
			        {
			        	//****************************************************************
						//this is because to pass the validation rules for visitor
			        	if(empty($model->visitor_card_status) || is_null($model->visitor_card_status)){
			        		$model->visitor_card_status = 1; //saved
			        	}

			        	
						// This removes Integrity Constraint Issue
			            
			            if($model->photo == null){
							$model->photo = NULL;               	
			            }

			        	//$model->password = User::model()->hashPassword($_POST['Visitor']['new_password']);
			        	$model->password = $_POST['Registration']['new_password'];


			        	if(isset($companyModel)){
			            	$companyModel->created_by_visitor = $model->id;
					    	//$companyModel->mobile_number = $_POST['Company']['mobile_number'];
					    	//$companyModel->tenant = Yii::app()->user->tenant;
						}
					   

			            $model->password_saver = "yes";

				        //if($model->validate())
			            //{
			            	if($model->save(false))
					        {
					        	//if($companyModel->validate())
					        	//{
					        		if ($companyModel->save(false)) 
						            {
										Yii::app()->user->setFlash('success', "Profile Updated Successfully.");
									}
									else
									{
										Yii::app()->user->setFlash('error', "Something went wrong. Please, try again.");
										$msg = print_r($companyModel->getErrors(),1);
										throw new CHttpException(400,'Data not saved in company because: '.$msg );
									}
					        	//}
					        	//else
					        	//{
					        		//Yii::app()->user->setFlash('error', "Something went wrong. Please, try again.");
									//$msg = print_r($companyModel->getErrors(),1);
									//throw new CHttpException(400,'Data not saved in company because: '.$msg );
					        	//}
					        }
					        else
					        {
					        	Yii::app()->user->setFlash('error', "Something went wrong. Please, try again.");
					        	$msg = print_r($model->getErrors(),1);
								throw new CHttpException(400,'Data not saved in visitor because: '.$msg );
					        }
			            //}
			            //else
			            //{
			            	//Yii::app()->user->setFlash('error', "Something went wrong. Please, try again.");
					        //$msg = print_r($model->getErrors(),1);
							//throw new CHttpException(400,'Data not saved in visitor because: '.$msg );
			            //}
						//****************************************************************
					} 
					else
					{
						$old_passwordErr = "Please enter correct old password";
					}
	            }
            	//**********************************************************************************
            }*/
        }
    	$companyModel = Company::model()->findByPk($model->company);
		
        $this->render('profile', array(
            'model' => $model,
            'companyModel' => $companyModel,
            'new_passwordErr' => $new_passwordErr,
            'repeat_passwordErr' => $repeat_passwordErr,
            'old_passwordErr' => $old_passwordErr,
        ));	
    }
	public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Password'])) {
			
            $model->attributes = $_POST['Password'];
			/*echo "<pre>";
			print_r($model->attributes);
			echo "</pre>";
			Yii::app()->end();*/
            $user = visitor::model()->findByPK($id);
            
           // if (User::model()->validatePassword($_POST['Password']['currentpassword'], $user->password)) {
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', 'Password successfully updated');
					  $templateParams = array(
								'email' => $user->email,
									);
	
				//TODO: Change to YiiMail
						$emailTransport = new EmailTransport();
						$emailTransport->sendResetPasswordConfirmationEmail(
						$templateParams, $user->email, $user->first_name . ' ' . $user->last_name
						);
                    $this->redirect(array('preregistration/profile', 'id' => $model->id));
                }
//            } else {
//                Yii::app()->user->setFlash('error', "Current password does not match password in your account. ");
//            }
        }

        $this->render('passwordupdate', array(
            'model' => $model,
        ));
    }
    /* notifications */
    public function actionNotifications()
    {
    	$this->unsetVariablesForGui();
    	Yii::app()->db->createCommand()->update("user_notification",array('has_read' => 1),"user_id = " . Yii::app()->user->id);
    	/*$notifications = Yii::app()->db->createCommand()
                    ->select("*") 
                    ->from("notification n")
                    ->join("user_notification u","n.id = u.notification_id")
                    ->where("u.user_id = " . Yii::app()->user->id)
                    ->order("u.notification_id DESC")
                    ->queryAll();*/

        $criteriaArray = array();
        $notifications = '';

        if(Yii::app()->user->account_type == "VIC")
        {
        	$criteriaArray = array('You have Preregistered a Visit','You have reached a Visit Count of 20 days','You have reached your 28 Day Visit Count Limit','ASIC Sponsor has verified your visit','ASIC Sponsor has rejected your visit','Your Identification is about to expire');
        	$notifications = $this->criteriaBasedNotifications($criteriaArray); 
    	}
    	elseif (Yii::app()->user->account_type == "ASIC") 
    	{
    		$criteriaArray = array('VIC Holder has requested ASIC Sponsor verification','ASIC Sponsor has assigned you a VIC holder Verification','Your ASIC is about to Expire');
        	$notifications = $this->criteriaBasedNotifications($criteriaArray); 
    	}
    	else
    	{
    		$criteriaArray = array('VIC Holder in your company has Preregistered a Visit','VIC Holder in your company has reached their 20 day visit count','VIC Holder in your company has reached their 28 day limit');
        	$notifications = $this->criteriaBasedNotifications($criteriaArray); 
    	}
    	$this->render('notifications',array('notifications' => $notifications ));	
    }

    public function criteriaBasedNotifications($criteriaArray)
    {
    	$notifications = array();
    	for($i=0; $i < sizeof($criteriaArray); $i++)
    	{
    		$notification = Yii::app()->db->createCommand()
                    ->select("*") 
                    ->from("notification n")
                    ->join("user_notification u","n.id = u.notification_id")
                    ->where("u.user_id = " . Yii::app()->user->id. " AND subject='".$criteriaArray[$i]."'")
                    ->order("u.notification_id DESC")
                    ->queryAll();
            array_push($notifications, $notification);        
    	}
    	return $notifications;
    }

    /* asic sponsor verifications */
    public function actionVerifications()
    {
    	$this->unsetVariablesForGui();
    	$per_page = 10;
    	$page = (isset($_GET['page']) ? $_GET['page'] : 1);  // define the variable to “LIMIT” the query
        $condition = "t.is_listed = 1 AND t.is_deleted = 0 AND v.is_deleted=0 AND t.host is not NULL AND t.host !=''"; 

        if(isset(Yii::app()->user->account_type) && Yii::app()->user->account_type == "ASIC"){
        	$condition .= " AND t.host=".Yii::app()->user->id;
        }else{
        	$condition .= " AND t.visitor=".Yii::app()->user->id;
        }
        $rawData = Yii::app()->db->createCommand()
                        ->select("t.id,t.date_check_in,t.host,v.first_name,v.last_name,t.visit_prereg_status") 
                        ->from("visit t")
                        ->join("visitor v","v.id = t.visitor")
                        ->where($condition)
                        ->queryAll();
        $item_count = count($rawData);
        $query1 = Yii::app()->db->createCommand()
                        ->select("t.id,t.date_check_in,t.host,v.first_name,v.last_name,t.visit_prereg_status") 
                        ->from("visit t")
                        ->join("visitor v","v.id = t.visitor")
                        ->where($condition)
                        ->order("t.id DESC")
                        ->limit($per_page,$page-1) // the trick is here!
                        ->queryAll();   

		// the pagination itself
        $pages = new CPagination($item_count);
        $pages->setPageSize($per_page);

		// render
        $this->render('visit-history-verifications',array(
            'query1'=>$query1,
            'item_count'=>$item_count,
            'page_size'=>$per_page,
            'pages'=>$pages,
        ));
    }

    public function actionVerifyVicholder($id)
    {
    	if( !isset(Yii::app()->user->account_type) || (Yii::app()->user->account_type != "ASIC") ){
			$this->redirect(array('preregistration/dashboard'));
		}

    	$this->unsetVariablesForGui();
    	$session = new CHttpSession;
    	$session['verify_visit_id'] = $id;

    	$visit = Visit::model()->findByPk($id);
    	$visitor = Registration::model()->findByPk($visit->visitor);
    	$company = Company::model()->findByPk($visitor->company);
    	$this->render('verify-vic-holder',array('visit'=>$visit,'visitor'=>$visitor,'company'=>$company));

    }	

    /* asic sponsor verifications */
    public function actionVerificationDeclarations()
    {
    	if( !isset(Yii::app()->user->account_type) || (Yii::app()->user->account_type != "ASIC") ){
			$this->redirect(array('preregistration/dashboard'));
		}
    	$this->unsetVariablesForGui();
		$this->render('verification-declarations');
    }

    public function actionVerifyDeclarations()
    {
    	if( !isset(Yii::app()->user->account_type) || (Yii::app()->user->account_type != "ASIC") ){
			$this->redirect(array('preregistration/dashboard'));
		}

    	$session = new CHttpSession;
		$visit = Visit::model()->findByPk($session['verify_visit_id']);

		$visit->visit_prereg_status = "Verified";
		$visit->asic_declaration = 1;
		$visit->asic_verification = 1;

		if($visit->save(false))
		{
			$this->createVicNotificationVerifiedYourVisit($visit);
			$this->redirect(array('preregistration/verifications'));
		}
    }


    public function actionDeclineVicholder()
    {
    	if( !isset(Yii::app()->user->account_type) || (Yii::app()->user->account_type != "ASIC") ){
			$this->redirect(array('preregistration/dashboard'));
		}
    	$this->render('decline-vic');
    }

    public function actionVicholderDeclined()
    {

    	if( !isset(Yii::app()->user->account_type) || (Yii::app()->user->account_type != "ASIC") ){
			$this->redirect(array('preregistration/dashboard'));
		}
    	$session = new CHttpSession;
    	$visit = Visit::model()->findByPk($session['verify_visit_id']);
		$visit->visit_prereg_status = "Rejected";
		$visit->asic_declaration = 0;
		$visit->asic_verification = 0;
		
		if($visit->save(false))
		{
			$this->createVicNotificationDeclinedYourVisit($visit);
			$this->redirect(array('preregistration/verifications'));
		}
    }

    public function actionAssignAsicholder()
    {
    	if( !isset(Yii::app()->user->account_type) || (Yii::app()->user->account_type != "ASIC") ){
			$this->redirect(array('preregistration/dashboard'));
		}

    	$this->unsetVariablesForGui();
    	$session = new CHttpSession;

		$model = new Registration();
		$model->scenario = 'preregistrationAsic';


		$companyModel = new Company();
		$companyModel->scenario = 'preregistration';
		

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'add-asic-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['Registration'])) 
		{
			$model->attributes = $_POST['Registration'];

			if(!empty($model->selected_asic_id))
			{
				$visit = Visit::model()->findByPk($session['verify_visit_id']);
				$visit->visit_prereg_status = "Reassigned";

				$visit->host = $model->selected_asic_id;

				if($visit->save(false))
				{
					$this->createAsicNotificationAssignedVicHolder($visit);
					$this->redirect(array('preregistration/verifications'));
				}
			}
			else
			{
				$visitor = Registration::model()->findByPk(Yii::app()->user->id);

				$model->profile_type = 'ASIC';
				$model->key_string = hash('ripemd160', uniqid());
				$model->tenant = $visitor->tenant;
				$model->visitor_workstation = $visitor->visitor_workstation; 
				$model->created_by = $visitor->created_by;
				$model->role = 9; //Staff Member/Intranet
				$model->visitor_card_status = 6; //Asic Issued

				if($model->save(false))
				{
					$visit = Visit::model()->findByPk($session['verify_visit_id']);
					$visit->visit_prereg_status = "Reassigned";
					
					$visit->host = $model->id;

					if($visit->save(false))
					{
						$this->createAsicNotificationAssignedVicHolder($visit);
						$this->redirect(array('preregistration/verifications'));
					}
				}
			}

		}
		
    	$this->render('reassign-asic',array('model'=>$model,'companyModel' => $companyModel));
    }

    /* Visitor Visits history */
    public function actionVisitHistory() {
    	$this->unsetVariablesForGui();
    	$per_page = 10;
    	$page = (isset($_GET['page']) ? $_GET['page'] : 1);  // define the variable to “LIMIT” the query
        $condition = "(t.is_deleted = 0 AND v.is_deleted =0 AND v.id=".Yii::app()->user->id.")";
        $rawData = Yii::app()->db->createCommand()
                        ->select("t.company,t.date_check_in,t.date_check_out,v.first_name,v.last_name,vs.name as status") 
                        ->from("visit t")
                        ->join("visitor v","v.id = t.visitor")
                        ->join("visit_status vs","vs.id = t.visit_status")
                        ->where($condition)
                        ->queryAll();
        $item_count = count($rawData);
		$query1 = Yii::app()->db->createCommand()
                        ->select("t.company,t.date_check_in,t.date_check_out,v.first_name,v.last_name,vs.name as status") 
                        ->from("visit t")
                        ->join("visitor v","v.id = t.visitor")
                        ->join("visit_status vs","vs.id = t.visit_status")
                        ->order("t.id DESC")
                        ->where($condition)
                        ->limit($per_page,$page-1) // the trick is here!
                        ->queryAll();   
        // the pagination itself
        $pages = new CPagination($item_count);
        $pages->setPageSize($per_page);
        // render
        $this->render('visit-history',array(
            'query1'=>$query1,
            'item_count'=>$item_count,
            'page_size'=>$per_page,
            'pages'=>$pages,
        ));
    }
    /* Help Desk history */
    public function actionHelpdesk() {
    	$this->unsetVariablesForGui();
    	$helpDeskGroupRecords = HelpDeskGroup::model()->getAllHelpDeskGroup();
        $session = new CHttpSession;
        $this->render('helpdesk', array(
            'helpDeskGroupRecords' => $helpDeskGroupRecords
        ));
    }

    public function loadModel($id)
    {
        $model = Registration::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }


    //**************************************************************************************
	public function actionDashboard(){
		$this->unsetVariablesForGui();
		$this->render('dashboard');
	}

	public function actionAsicPrivacyPolicy(){
		$session = new CHttpSession;
		$session['stepTitle'] = 'ASIC SPONSOR CREATE LOGIN';
		$session['step2Subtitle'] = "&nbsp;&nbsp;>&nbsp;&nbsp;"."<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration/asicPrivacyPolicy'>Privacy Policy</a>";
		unset($session['step3Subtitle']);unset($session['step4Subtitle']);unset($session['step5Subtitle']);
		unset($session['step6Subtitle']);unset($session['step7Subtitle']);unset($session['step8Subtitle']);
		$this->render('asic-privacy-policy');
	}

	public function actionCompAdminPrivacyPolicy(){
		$session = new CHttpSession;
		$session['stepTitle'] = 'COMPANY ADMINISTRATOR CREATE LOGIN';
		$session['step2Subtitle'] = "&nbsp;&nbsp;>&nbsp;&nbsp;"."<a style='text-decoration: underline;' href='".Yii::app()->getBaseUrl(true)."/index.php/preregistration/compAdminPrivacyPolicy'>Privacy Policy</a>";
		unset($session['step3Subtitle']);unset($session['step4Subtitle']);unset($session['step5Subtitle']);
		unset($session['step6Subtitle']);unset($session['step7Subtitle']);unset($session['step8Subtitle']);
		$this->render('compadmin-privacy-policy');
	}

	public function actionDetails(){
		echo "welcome";
		echo Yii::app()->user->id;
		print_r(Yii::app()->user);
	}

	public function actionLogout() {
		Yii::app()->user->logout();
		$this->redirect(array('preregistration/login'));
	}

	public function actionCheckEmailIfUnique() 
	{
		$email = '';
		if(isset($_POST['email'])){$email = $_POST['email'];}
		if(!empty($email))
		{
			if(Registration::model()->findByAttributes(array("email"=>$email)))
			{
				$aArray[] = array(
		        	'isTaken' => 1,
		        );
			} 
			else
			{
				$aArray[] = array(
		        	'isTaken' => 0,
		        );
			}

			$resultMessage['data'] = $aArray;
	        echo CJavaScript::jsonEncode($resultMessage);
	        Yii::app()->end();
		}
		else
		{
			$aArray[] = array(
	        	'isTaken' => 0,
	        );
	        $resultMessage['data'] = $aArray;
	        echo CJavaScript::jsonEncode($resultMessage);
	        Yii::app()->end();
		}
    }

    public function actionCheckUserProfile() 
	{
		$firstname = '';$lastname='';$dob='';
		if(isset($_POST['firstname'])){$firstname = $_POST['firstname'];}
		if(isset($_POST['lastname'])){$lastname = $_POST['lastname'];}
		if(isset($_POST['dob'])){$dob = $_POST['dob'];}

		if(!empty($firstname) && !empty($lastname) && !empty($dob))
		{
			if(Registration::model()->findByAttributes(array("first_name"=>$firstname,"last_name"=>$lastname,"date_of_birth"=>$dob)))
			{
			  	$aArray[] = array(
	                'isTaken' => 1,
	            );
			} 
			else
			{
				$aArray[] = array(
	                'isTaken' => 0,
	            );
			}

	        $resultMessage['data'] = $aArray;
	        echo CJavaScript::jsonEncode($resultMessage);
	        Yii::app()->end();
		}
		else
		{
			$aArray[] = array(
	                'isTaken' => 0,
	            );

	        $resultMessage['data'] = $aArray;
	        echo CJavaScript::jsonEncode($resultMessage);
	        Yii::app()->end();
		}
		
    }

    public function actionFindAllCompanyContactsByCompany() {
		$session = new CHttpSession;
    	if(isset($_POST['compId'])){$compId = $_POST['compId'];}
        $Criteria = new CDbCriteria();
		//$Criteria->select="*,CONCAT(first_name,' ',last_name) as name";
        $Criteria->condition = "company = ".$compId." and is_deleted = 0";
        $user = User::model()->findAll($Criteria);
        $officeno=AsicOnCompany:: model()->findByPk($compId)->office_number;
        $resultMessage['data'] = $user;
		$resultMessage['officeno']=$officeno;
		$session['contactData']=CHtml::listData($user, 'id', function($user){return "{$user->first_name} {$user->last_name}";});
	    echo CJavaScript::jsonEncode($resultMessage);
	    Yii::app()->end();
    }

    public function actionFindAllCompanyFromWorkstation()
    {
    	if(isset($_POST['workstationId'])){$workstationId = $_POST['workstationId'];}

        $worsktation = Workstation::model()->findByPk($workstationId);

        $Criteria = new CDbCriteria();
        $Criteria->condition = "tenant = ".$worsktation->tenant." and is_deleted = 0";
        $companies = Company::model()->findAll($Criteria);

        $resultMessage['data'] = $companies;
	    echo CJavaScript::jsonEncode($resultMessage);
	    Yii::app()->end();
    }

    public function actionUploadProfilePhoto() {
        //if (Yii::app()->request->isAjaxRequest) {
    		if(isset($_POST['image']))
    		{
		        $img = $_POST['image'];
	        	$newNameHash = hash('adler32', time());
				$newName    = $newNameHash.'-'. time();
	            $img = str_replace('data:image/png;base64,', '', $img);
	            $img = str_replace(' ', '+', $img);
	            $data = base64_decode($img);
	            $file = '/uploads/visitor/'.$newName.'.jpg';
	            $image_url = Yii::app()->request->hostInfo.'/'.Yii::app()->baseUrl.$file;

	            $src = Yii::getPathOfAlias('webroot').$file; 

	            file_put_contents($src,$data);

	            $file=file_get_contents($image_url);
			    $image = base64_encode($file);

		        $connection = Yii::app()->db;
		        $command = $connection->createCommand("INSERT INTO photo". "(filename, unique_filename, relative_path, db_image) VALUES ('NULL','".$newName."','NULL','" . $image . "')");
		        $command->query();

		        $lastId = Yii::app()->db->lastInsertID;

		        $update = $connection->createCommand("update visitor set photo=" . $lastId . " where id=" . Yii::app()->user->id);
		        $update->query();

		        $photoModel=Photo::model()->findByPk($lastId);

		        $ret = array("photoId" =>  $lastId, "db_image" => $photoModel->db_image);
		        
		        //delete uploaded file from folder as inserted in DB -- directed by Geoff
		        if (file_exists($src)) {
		            unlink($src);
		        }

                echo json_encode($ret);
		        
		    }
		    Yii::app()->end();

            /*if (isset($_FILES["fileInput"])) 
			{
				//*******************************************************************************
				$name  = $_FILES["fileInput"]["name"];
				if(!empty($name)){
					$ext  = pathinfo($name, PATHINFO_EXTENSION);
					$newNameHash = hash('adler32', time());
					$newName    = $newNameHash.'-' . time().'.'.$ext;
					$fullImgSource = Yii::getPathOfAlias('webroot').'/uploads/visitor/'.$newName;
					$relativeImgSrc = 'uploads/visitor/'.$newName;
			        $fileInputInstance=CUploadedFile::getInstanceByName('fileInput');
			        if($fileInputInstance->saveAs($fullImgSource))
			        {
			        	$file=file_get_contents($fullImgSource);
					    $image = base64_encode($file);

				        $connection = Yii::app()->db;
				        $command = $connection->createCommand("INSERT INTO photo". "(filename, unique_filename, relative_path, db_image) VALUES ('" . $name . "','" . $newName . "','" . $relativeImgSrc . "','" . $image . "')");
				        $command->query();

				        $lastId = Yii::app()->db->lastInsertID;

				        $update = $connection->createCommand("update visitor set photo=" . $lastId . " where id=" . Yii::app()->user->id);
				        $update->query();

				        $photoModel=Photo::model()->findByPk($lastId);

				        $ret = array("photoId" =>  $lastId, "db_image" => $photoModel->db_image);

	                    echo json_encode($ret);
				        //delete uploaded file from folder as inserted in DB -- directed by Geoff
				        if (file_exists($fullImgSource)) {
				            unlink($fullImgSource);
				        }
			        }
				}
				//*******************************************************************************
			}
			Yii::app()->end();*/
        //}
    }


    public function unsetVariablesForGui(){
    	$session = new CHttpSession;
    	unset($session['stepTitle']);
		unset($session['step1Subtitle']);unset($session['step2Subtitle']);unset($session['step3Subtitle']);
		unset($session['step4Subtitle']);unset($session['step5Subtitle']);unset($session['step6Subtitle']);
		unset($session['step7Subtitle']);unset($session['step8Subtitle']);unset($session['workstation']);
    }

    public function sendEmailToASIC($loggedUserEmail,$email,$visitId)
	{
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: ".$loggedUserEmail."\r\nReply-To: ".$loggedUserEmail;
		$to=$email;
		$subject="Request for verification of VIC profile";
		$body = "<html><body>Hi,<br><br>".
				"VIC Holder urgently requires your Verification of their visit.<br><br>".
				"Link of the VIC profile<br>".
				"<a href='" .Yii::app()->getBaseUrl(true)."/index.php/preregistration/verifyVicholder?id=".$visitId."'>".Yii::app()->getBaseUrl(true)."/index.php/preregistration/verifyVicholder?id=".$visitId."</a><br>";
		$body .="<br>"."Thanks,"."<br>Admin</body></html>";
		EmailTransport::mail($to, $subject, $body, $headers);
	}

}


