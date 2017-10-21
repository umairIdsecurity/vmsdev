<?php

class InductionController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
 
	/**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('inducteeUpdate', 'delete', 'admin', 'pdfprint'),
                'expression' => 'UserGroup::isUserAMemberOfThisGroup(Yii::app()->user,UserGroup::USERGROUP_ADMINISTRATION)',
            ),
        );
    }
	/**
     * Returns the data model based on the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @return Country the loaded model
     * @throws CHttpException
     */
    public function actionAdmin() {
         
		$model = new Visitor('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Visitor']))
            $model->attributes = $_GET['Visitor'];
			
        $this->render('_admin', array(
            'model' => $model));
    }
	 
	/**
     * Returns the data model based on the POST variable.
     * Saving a new record of inductee into the table of Visitor
     * @return Visitor the loaded model 
	 */
	 public function actionAddInductee()
	{
		$model = new InductionRecords;
		$induction = new InductionTitle;
		$visitor = new Visitor;

		$company = new Company;

		$company->scenario = "adding_inductee";
		
		$this->performAjaxValidation($visitor); 
		if (isset($_POST['Visitor'])) {	
		

			$visitor->first_name = $_POST['Visitor']['first_name'];
			$visitor->middle_name = $_POST['Visitor']['middle_name'];
			$visitor->last_name = $_POST['Visitor']['last_name'];
			$visitor->email = $_POST['Visitor']['email'];
			$visitor->tenant = Yii::app()->user->tenant;
			$visitor->company = $_POST['Visitor']['company'];
			$visitor->staff_id = $_POST['Visitor']['staff_id'];
			$visitor->profile_type = "Inductee";
			$visitor->contact_number = $_POST['Visitor']['contact_number'];
			if(isset($_POST['Visitor']['photo']) && $_POST['Visitor']['photo']!='')
			$visitor->photo = $_POST['Visitor']['photo'];
			$dob = $_POST['Visitor']['date_of_birth'];
			$visitor->date_of_birth = date("Y-m-d", strtotime($dob));
			$visitor->contact_unit = $_POST['Visitor']['contact_unit'];
			$visitor->contact_street_no = $_POST['Visitor']['contact_street_no'];
			$visitor->contact_street_name = $_POST['Visitor']['contact_street_name'];
			$visitor->contact_street_type = $_POST['Visitor']['contact_street_type'];
			$visitor->contact_suburb = $_POST['Visitor']['contact_suburb'];
			$visitor->contact_state = $_POST['Visitor']['contact_state'];
			$visitor->contact_country = $_POST['Visitor']['contact_country'];
			$visitor->contact_postcode = $_POST['Visitor']['contact_postcode'];
			$visitor->identification_type = $_POST['Visitor']['identification_type'];
			$visitor->identification_document_no = $_POST['Visitor']['identification_document_no'];
			$id_expiry = $_POST['Visitor']['identification_document_expiry'];
			$visitor->identification_document_expiry = date("Y-m-d", strtotime($id_expiry));
			if($_POST['Visitor']['asic_no']!='')
			$visitor->asic_no = $_POST['Visitor']['asic_no'];
			if($_POST['Visitor']['asic_expiry']!='')
			{
				$asic_no_expiry = $_POST['Visitor']['asic_expiry'];
				$visitor->asic_expiry = date("Y-m-d", strtotime($asic_no_expiry));
			
			}
			$visitor->save(false);
			

			
				if (isset($_POST['InductionRecords']))
					{
					
					for ($i = 1; $i <= count($_POST['InductionRecords']); $i++)
						{
						if ($_POST['InductionRecords'][$i]['is_completed_induction'] == '1')
							{


							$newModel = new InductionRecords;
							$newModel->attributes = $_POST['InductionRecords'][$i];


							$newModel->is_required_induction = 1;
							$newModel->is_completed_induction = $_POST['InductionRecords'][$i]['is_completed_induction'];
							$newModel->visitor_id = $visitor->id;
							switch ($i) {
								case 1 :
									$newModel->induction_id = 1;
									if(isset($_POST['Icon']['as']) && $_POST['Icon']['as']==1)
									{
										$newModel->induction_flag=1;
									}
									else
									$newModel->induction_flag=0;
									break;
								case 2 :
									$newModel->induction_id = 2;
									if(isset($_POST['Icon']['as']) && $_POST['Icon']['as']==1)
									{
										$newModel->induction_flag=1;
									}
									else
									$newModel->induction_flag=0;
									break;
								case 3 :
									$newModel->induction_id = 3;
									if(isset($_POST['Icon']['as']) && $_POST['Icon']['as']==1)
									{
										$newModel->induction_flag=1;
									}
									else
									$newModel->induction_flag=0;
									break;
								case 4 :
									$newModel->induction_id = 4;
									if(isset($_POST['Icon']['as']) && $_POST['Icon']['as']==1)
									{
										$newModel->induction_flag=1;
									}
									else
									$newModel->induction_flag=0;
									break;
								case 5 :
									$newModel->induction_id = 5;
									if(isset($_POST['Icon']['ada']) && $_POST['Icon']['ada']==1)
									{
										$newModel->induction_flag=1;
									}
									else
									$newModel->induction_flag=0;
									break;
								case 6 :
									$newModel->induction_id = 6;
									if(isset($_POST['Icon']['dd']) && $_POST['Icon']['dd']==1)
									{
										$newModel->induction_flag=1;
									}
									else
									$newModel->induction_flag=0;
									break;
							}
				

							$var = $_POST['InductionRecords'][$i]['induction_expiry'];
							$var = str_replace("/", "-", $var);
							$newModel->induction_expiry = date("Y-m-d", strtotime($var));
							
							
							$newModel->save(false);
						}
					}
				
					
					$this->redirect(array('induction/admin'));
			//Yii::app()->end();

				}
				//else
					$this->redirect(array('induction/admin'));
			
		}

		$this->render('addinductee', array(
			'model' => $model,
			'induction' => $induction,
			'visitor' => $visitor,
			'company' => $company
		));
	}
	
	/**
	 * Returns the data model based on the POST variable.
     * Saving the updated record into the table of Visitor
     * @return Visitor the loaded modelReturns the 
	 */
	 
	 /*@param $id*/
	 public function actionInducteeUpdate($id)
    { 
		//$dateModel = new DateInductee(); 
        $visitor = $this->loadModel($id);
		$visitor->scenario = 'visitor_induction_update';
		$induction = new InductionTitle;
		$company = new Company;
       
		if(isset($_POST['Visitor'])){
			$visitor->first_name = $_POST['Visitor']['first_name'];
			$visitor->middle_name = $_POST['Visitor']['middle_name'];
			$visitor->last_name = $_POST['Visitor']['last_name'];
			$visitor->email = $_POST['Visitor']['email'];
			if(isset($_POST['Visitor']['photo']) && $_POST['Visitor']['photo']!='')
			$visitor->photo=$_POST['Visitor']['photo'];
			$visitor->tenant=Yii::app()->user->tenant;
			$visitor->company = $_POST['Visitor']['company'];
			
			if(empty($_POST['Visitor']['staff_id'])){
				$visitor->staff_id = NULL;
			} else {
				$visitor->staff_id = $_POST['Visitor']['staff_id'];
			}
			
			//$model->profile_type = "Inductee";
			$visitor->contact_number = $_POST['Visitor']['contact_number'];
			$dob = $_POST['Visitor']['date_of_birth'];
			$visitor->date_of_birth = date("Y-m-d", strtotime($dob));
			$visitor->contact_unit = $_POST['Visitor']['contact_unit'];
			$visitor->contact_street_no = $_POST['Visitor']['contact_street_no'];
			$visitor->contact_street_name = $_POST['Visitor']['contact_street_name'];
			$visitor->contact_street_type = $_POST['Visitor']['contact_street_type'];
			$visitor->contact_suburb = $_POST['Visitor']['contact_suburb'];
			$visitor->contact_state = $_POST['Visitor']['contact_state'];
			$visitor->contact_postcode = $_POST['Visitor']['contact_postcode'];
			$visitor->identification_type = $_POST['Visitor']['identification_type'];
			$visitor->identification_document_no = $_POST['Visitor']['identification_document_no'];
			$id_expiry = $_POST['Visitor']['identification_document_expiry'];
			$visitor->identification_document_expiry = date("Y-m-d", strtotime($id_expiry));
			if($_POST['Visitor']['asic_no']!='')
			$visitor->asic_no = $_POST['Visitor']['asic_no'];
			if($_POST['Visitor']['asic_expiry']!='')
			{
				$asic_no_expiry = $_POST['Visitor']['asic_expiry'];
				$visitor->asic_expiry = date("Y-m-d", strtotime($asic_no_expiry));
			
			}
			 
			if($visitor->save(false)) {}
        }
		
		$indRecords = new InductionRecords();
		$exist=$indRecords->exists("visitor_id=".$visitor->id);
		
		if($exist){
			$indRecords=$indRecords->findAll("visitor_id=".$visitor->id);
			for($i=0; $i<count($indRecords); $i++){
				switch($indRecords[$i]->induction_id) {
					case 1 : $airSide=$indRecords[$i];
						break;
					case 2 : $Orientation=$indRecords[$i];
						break;
					case 3 : $Security=$indRecords[$i];
						break;
					case 4 : $Safe=$indRecords[$i];
						break;
					case 5 : $Driving=$indRecords[$i];
						break;
					case 6 : $Drug=$indRecords[$i];
						break;
				}
			}
			
			if(empty($airSide)) {
				$airSide = new InductionRecords;
			}
			
			if(empty($Orientation)) {
				$Orientation = new InductionRecords;
			}
			
			if(empty($Security)) {
				$Security = new InductionRecords;
			}
			
			if(empty($Safe)) {
				$Safe = new InductionRecords;
			}
			
			if(empty($Driving)) {
				$Driving = new InductionRecords;
			}
			
			if(empty($Drug)) {
				$Drug = new InductionRecords;
			}
		} else {
			$airSide=new InductionRecords();
			$Orientation=new InductionRecords();
			$Security=new InductionRecords();
			$Safe=new InductionRecords();
			$Driving=new InductionRecords();
			$Drug=new InductionRecords();
		}
		
		if(isset($_POST['InductionRecords'])) {
			
			/*echo "<pre>";
			print_r($_POST['InductionRecords'][1]);
			//print_r(count($_POST['InductionRecords']));
			echo "</pre>";
			Yii::app()->end();*/ 
			
			for($i=1; $i<=count($_POST['InductionRecords']); $i++){
				switch($i) {
					case 1 : {
						/*echo "<pre>";
							print_r($_POST['InductionRecords'][1]['is_required_induction']); 
						echo "</pre>";
						Yii::app()->end();*/
						if($_POST['InductionRecords'][1]['is_completed_induction']=='1'){
							$airSide->is_required_induction = 1;
							$airSide->is_completed_induction = $_POST['InductionRecords'][1]['is_completed_induction'];
							$airSide->visitor_id = $id;
							$airSide->induction_id=1;
								if(isset($_POST['Icon']['as']) && $_POST['Icon']['as']==1)
									{
										$airSide->induction_flag=1;
									}
							$var = $_POST['InductionRecords'][1]['induction_expiry'];
							$airSide->induction_expiry = date("Y-m-d", strtotime($var));
							$airSide->save(false);
						}
						if($_POST['InductionRecords'][1]['is_completed_induction']=='0'){
							$airSide->is_required_induction = 0;
							$airSide->is_completed_induction = $_POST['InductionRecords'][1]['is_completed_induction'];
							$airSide->visitor_id = $id;
							$airSide->induction_id=1;
							//$var = $_POST['InductionRecords'][1]['induction_expiry'];
							//$airSide->induction_expiry = date("Y-m-d", strtotime($var));
							$airSide->induction_flag = 0;
							$airSide->save(false);
						}
						 
					}
						break;
					case 2 : {
						if($_POST['InductionRecords'][2]['is_completed_induction']=='1'){
							$Orientation->is_required_induction = 1;
							$Orientation->is_completed_induction = $_POST['InductionRecords'][2]['is_completed_induction'];
							$Orientation->visitor_id = $id;
							$Orientation->induction_id=2;
							$var2 = $_POST['InductionRecords'][2]['induction_expiry'];
							$Orientation->induction_expiry = date("Y-m-d", strtotime($var2));
								if(isset($_POST['Icon']['as']) && $_POST['Icon']['as']==1)
									{
										$Orientation->induction_flag=1;
									}
							$Orientation->save(false);
						}
						if($_POST['InductionRecords'][2]['is_completed_induction']=='0'){
							$Orientation->is_required_induction = 0;
							$Orientation->is_completed_induction = $_POST['InductionRecords'][2]['is_completed_induction'];
							$Orientation->visitor_id = $id;
							$Orientation->induction_id=2;
							//$var = $_POST['InductionRecords'][1]['induction_expiry'];
							//$airSide->induction_expiry = date("Y-m-d", strtotime($var));
							$Orientation->induction_flag = 0;
							$Orientation->save(false);
						}
					}
						break;
					case 3 : {
						if($_POST['InductionRecords'][3]['is_completed_induction']=='1'){
							$Security->is_required_induction = 1;
							$Security->is_completed_induction = $_POST['InductionRecords'][3]['is_completed_induction'];
							$Security->visitor_id = $id;
							$Security->induction_id=3;
							$var = $_POST['InductionRecords'][3]['induction_expiry'];
							$Security->induction_expiry = date("Y-m-d", strtotime($var));
								if(isset($_POST['Icon']['as']) && $_POST['Icon']['as']==1)
									{
										$Security->induction_flag=1;
									}
							$Security->save(false);
						}
						if($_POST['InductionRecords'][3]['is_completed_induction']=='0'){
							$Security->is_required_induction = 0;
							$Security->is_completed_induction = $_POST['InductionRecords'][3]['is_completed_induction'];
							$Security->visitor_id = $id;
							$Security->induction_id=3;
							//$var = $_POST['InductionRecords'][1]['induction_expiry'];
							//$airSide->induction_expiry = date("Y-m-d", strtotime($var));
							$Security->induction_flag = 0;
							$Security->save(false);
						}
					}
						break;
					case 4 : {
						if($_POST['InductionRecords'][4]['is_completed_induction']=='1'){
							$Safe->is_required_induction = 1;
							$Safe->is_completed_induction = $_POST['InductionRecords'][4]['is_completed_induction'];
							$Safe->visitor_id = $id;
							$Safe->induction_id=4;
							$var4 = $_POST['InductionRecords'][4]['induction_expiry'];
							$Safe->induction_expiry = date("Y-m-d", strtotime($var4));
								if(isset($_POST['Icon']['as']) && $_POST['Icon']['as']==1)
									{
										$Safe->induction_flag=1;
									}
							$Safe->save(false);
						}
						if($_POST['InductionRecords'][4]['is_completed_induction']=='0'){
							$Safe->is_required_induction = 0;
							$Safe->is_completed_induction = $_POST['InductionRecords'][4]['is_completed_induction'];
							$Safe->visitor_id = $id;
							$Safe->induction_id=4;
							//$var = $_POST['InductionRecords'][1]['induction_expiry'];
							//$airSide->induction_expiry = date("Y-m-d", strtotime($var));
							$Safe->induction_flag = 0;
							$Safe->save(false);
						}
					}
						break;
					case 5 : {
						if($_POST['InductionRecords'][5]['is_completed_induction']=='1'){
							$Driving->is_required_induction = 1;
							$Driving->is_completed_induction = $_POST['InductionRecords'][5]['is_completed_induction'];
							$Driving->visitor_id = $id;
							$Driving->induction_id=5;
							$var5 = $_POST['InductionRecords'][5]['induction_expiry'];
							$Driving->induction_expiry = date("Y-m-d", strtotime($var5));
								if(isset($_POST['Icon']['ada']) && $_POST['Icon']['ada']==1)
									{
										$Driving->induction_flag=1;
									}
							$Driving->save(false);
						}
						if($_POST['InductionRecords'][5]['is_completed_induction']=='0'){
							$Driving->is_required_induction = 0;
							$Driving->is_completed_induction = $_POST['InductionRecords'][5]['is_completed_induction'];
							$Driving->visitor_id = $id;
							$Driving->induction_id=5;
							//$var = $_POST['InductionRecords'][1]['induction_expiry'];
							//$airSide->induction_expiry = date("Y-m-d", strtotime($var));
							$Driving->induction_flag = 0;
							$Driving->save(false);
						}
					}
						break;
					case 6 : {
						if($_POST['InductionRecords'][6]['is_completed_induction']=='1'){
							$Drug->is_required_induction = 1;
							$Drug->is_completed_induction = $_POST['InductionRecords'][6]['is_completed_induction'];
							$Drug->visitor_id = $id;
							$Drug->induction_id=6;
							$var6 = $_POST['InductionRecords'][6]['induction_expiry'];
							$Drug->induction_expiry = date("Y-m-d", strtotime($var6));
							if(isset($_POST['Icon']['dd']) && $_POST['Icon']['dd']==1)
									{
										$Drug->induction_flag=1;
									}
							$Drug->save(false);
						}
						if($_POST['InductionRecords'][6]['is_completed_induction']=='0'){
							$Drug->is_required_induction = 0;
							$Drug->is_completed_induction = $_POST['InductionRecords'][6]['is_completed_induction'];
							$Drug->visitor_id = $id;
							$Drug->induction_id=6;
							//$var = $_POST['InductionRecords'][1]['induction_expiry'];
							//$airSide->induction_expiry = date("Y-m-d", strtotime($var));
							$Drug->induction_flag = 0;
							$Drug->save(false);
						}
					}
						break;
				}
			}
		}
		
		$this->render('update', array(           
			'airSide'     => $airSide,
			'Orientation' => $Orientation,
			'Security'    => $Security,
			'Safe'        => $Safe,
			'Driving'     => $Driving,
			'Drug'        => $Drug,
			'induction'   => $induction,
			'visitor'     => $visitor,
			'company'     => $company,			
        ));
	
	}
	/**
     * Deletes a particular model.
     * If profile type of model is inductee, then delete the model.
	 * If profile type of model is ASIC/VIC, then set indcutee_flag as 1.
     * @param integer $id the ID of the model to be deleted
     */
	 
    public function actionDelete($id){
        if(Yii::app()->request->isPostRequest)
        {
            $model = $this->loadModel($id);
            $model->induction_flag=1;
			$model->save(false);
		}
    }
	
	/**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Visitor the loaded model
     * @throws CHttpException
     */
	 
    public function loadModel($id)
    {
       $model = Visitor::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }	
	
	public function actionPdfprint($id) {
        
        if (!isset($_GET['type'])){
            throw new CHttpException(404,'Parameter missing');
        } else {
            $type=$_GET['type'];
        }
         
		
        
        #data of user of card
        $model = Visitor::model()->findByPk($id);
       // $a = $model->card;
        //$visitorModel = Visitor::model()->findByPk($model->visitor);
		
		$indRecords = new InductionRecords();
		$exist=$indRecords->exists("visitor_id=".$model->id);
		
		if($exist){
			$indRecords=$indRecords->findAll("visitor_id=".$model->id);
			for($i=0; $i<count($indRecords); $i++){
				switch($indRecords[$i]->induction_id) {
					case 1 : $airSide=$indRecords[$i];
						break;
					case 2 : $Orientation=$indRecords[$i];
						break;
					case 3 : $Security=$indRecords[$i];
						break;
					case 4 : $Safe=$indRecords[$i];
						break;
					case 5 : $Driving=$indRecords[$i];
						break;
					case 6 : $Drug=$indRecords[$i];
						break;
				}
			} 	 
		}
		
		$min = new DateTime('3000-12-12'); 
		
		if(!empty($airSide->induction_expiry)){
			if($min > $airSide->induction_expiry){
				$min = $airSide->induction_expiry;
			}
		}
	
		if(!empty($Orientation->induction_expiry)){
			if($min > $Orientation->induction_expiry){
				$min = $Orientation->induction_expiry;
			}
		}
		
		if(!empty($Security->induction_expiry)){
			if($min > $Security->induction_expiry){
				$min = $Security->induction_expiry;
			}
		}
		
		if(!empty($Safe->induction_expiry)){
			if($min > $Safe->induction_expiry){
				$min = $Safe->induction_expiry;
			}
		}
		if((!empty($airSide->induction_flag) && $airSide->induction_flag==1)||(!empty($Orientation->induction_flag) && $Orientation->induction_flag==1)||(!empty($Security->induction_flag) && $Security->induction_flag==1)||(!empty($Safe->induction_flag) && $Safe->induction_flag==1))
		{
			$airIcon=1;
		}
		else
		{
			$airIcon=0;
		}
		if(!empty($Driving->induction_expiry)){
			if($min > $Driving->induction_expiry){
				$min = $Driving->induction_expiry;
			}
		}
		if(!empty($Driving->induction_flag) && $Driving->induction_flag==1)
		{
			$driveIcon=1;
		}
		else
		{
			$driveIcon=0;
		}
		if(!empty($Drug->induction_expiry)){
			if($min > $Drug->induction_expiry){
				$min = $Drug->induction_expiry;
			}
		}
		if(!empty($Drug->induction_flag) && $Drug->induction_flag==1)
		{
			$drugIcon=1;
		}
		else
		{
			$drugIcon=0;
		}
        
		//needs photo of the visitor as stored in DB to be shown in printing the card
        $userPhotoModel = Photo::model()->findByPk($model->photo);
		

        //needs photo of the comapny as stored in DB to be shown in the footer while printing the card
       
        $company = Company::model()->findByPk($model->tenant);
        $companyPhotoModel =  Photo::model()->findByPk($company->logo);
        
        $data = array('min'=>$min, 'airIcon'=>$airIcon, 'driveIcon'=>$driveIcon, 'drugIcon'=>$drugIcon, 'model' => $model, 'type' => $type, 'userPhotoModel' => $userPhotoModel, 'companyPhotoModel' => $companyPhotoModel);


      
            $html2pdf = Yii::app()->ePdf->HTML2PDF('P', 'CARDPRINT', 'en',TRUE,'UTF-8',array(0,0,0,0));
     
            $html2pdf->WriteHTML($this->renderPartial('printpdf', $data, true));
	


       $html2pdf->Output();
      
    }
	protected function performAjaxValidation($model)
        {
                if(isset($_POST['ajax']))
                {
						/*echo "<pre>";
						print_r($model);
						echo "</pre>";*/
                        echo CActiveForm::validate($model);
                        Yii::app()->end();
                }
        }
}
