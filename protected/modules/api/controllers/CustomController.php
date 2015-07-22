<?php

class CustomController extends RestfulController {

    /**
     * @Function: for retrieving the workstation list
	 *
	 * @param: NA   	 
	 * @return: NA
     */
    public function actionWorkstations() {
        try {
            $token_user = $this->checkAuth();
            if (Yii::app()->request->isPostRequest) {
				$data = file_get_contents("php://input");
                $data = CJSON::decode($data);
				
                $admin = User::model()->with('com')->findByAttributes(array('email' => $data['email']));
				
				if($admin){
					$Criteria = new CDbCriteria();
					$Criteria->condition = "tenant = " . $admin->company . " AND is_deleted = 0";				
					$row = Workstation::model()->findAll($Criteria);
					
					if ($row) {
						foreach ($row as $key => $value) {
							$aArray[] = array(
								'id' => $value['id'],
								'name' => $value['name'],
							);
						}
					} else {
						$aArray[] = array(
							'id' => '',
							'name' => '-No Workstation Found-',
						);					
					}
									
					if (!empty($aArray)) {
						$this->sendResponse(200, CJSON::encode($aArray));
					} else {
						$this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'WORK_STATION_NOT_FOUND', 'errorDescription' => 'Workstation not found for this Admin')));
					}
					
				}else {
					$this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'ADMIN_DOES_NOT_EXIST', 'errorDescription' => 'Requested Admin not found')));
				}				
				
            } else {
                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_PARAMETER', 'errorDescription' => 'POST  parameter required for action')));
            }
        } catch (Exception $ex) {
            $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER_ERROR', 'errorDescription' => 'Something went wrong')));
        }
    }
	
	/**
     * @Function: for retrieving the card types list
	 *
	 * @param: NA   	 
	 * @return: NA
     */
	public function actionCardtype() {
        try {
            $token_user = $this->checkAuth();
            if (Yii::app()->request->isPostRequest) {
				
				$data = file_get_contents("php://input");
                $data = CJSON::decode($data);
				
				$Criteria = new CDbCriteria();
				$Criteria->condition = "workstation = '" . $data['workstation'] ."'";	
				$row = WorkstationCardType::model()->with('cardType')->findAll($Criteria);
				
				if ($row) {
					foreach ($row as $key => $value) {
						$aArray[] = array(
							'id' => $row[$key]['cardType']['id'],
							'name' => $row[$key]['cardType']['name'],
						);
					}
				} else {
					$aArray[] = array(
						'id' => '',
						'name' => '-No Card Type Found-',
					);					
				}
								
				if (!empty($aArray)) {
					$this->sendResponse(200, CJSON::encode($aArray));
				} else {
					$this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'WORK_STATION_NOT_FOUND', 'errorDescription' => 'Workstation not found for this Admin')));
				}
				
				
			}else {
                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_PARAMETER', 'errorDescription' => 'POST  parameter required for action')));
            }
		} catch (Exception $ex) {
            $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER_ERROR', 'errorDescription' => 'Something went wrong')));
        }
	}
	
	/**
     * @Function: for registering the kiosk workstation
	 *
	 * @param: NA   	 
	 * @return: NA
     */
	public function actionRegisterkiosk() {
        try {
            $token_user = $this->checkAuth();
            if (Yii::app()->request->isPostRequest) {
				
				$data = file_get_contents("php://input");
                $data = CJSON::decode($data);
				
				# get User info
				$user = User::model()->with('com')->findByAttributes(array('email' => $data['email']));
				
				# Check if kiosk exist for that workstation and for that user
				$Criteria = new CDbCriteria();
				/*$Criteria->condition = "name = '" . strtolower($data['kiosk']). "' AND workstation = " . $data['workstation'] . " AND created_by = " . $user->id . " AND is_deleted = 0";*/
				$Criteria->condition = "name = '" . strtolower($data['kiosk']). "' AND workstation = " . $data['workstation'] . " AND is_deleted = 0";
				$kiosk = Kiosk::model()->findAll($Criteria);
				
				if(empty($kiosk)){
					$kiosk = new Kiosk();
					$kiosk->name = strtolower($data['kiosk']);
					$kiosk->workstation = $data['workstation'];
					$kiosk->module = 'CVMS';
					$kiosk->tenant = $user->tenant;
					$kiosk->created_by = $user->id;
					$kiosk->is_deleted = 0;
					$kiosk->enabled = 1;
					$kiosk->atoken = password_hash($data['kiosk'].time().rand(1000, 9999), PASSWORD_BCRYPT);
					echo "pp";exit;
					/*
					if ($kiosk->validate()) {
						$kiosk->save();    
						$result = array('status'=>'new', 'ktoken'=>$kiosk->atoken);
						$this->sendResponse(201, CJSON::encode($result));
					} else {
						$this->sendResponse(401, CJSON::encode($kiosk->getErrors()));
					}
					*/
				}else{
					$result = array('status'=>'continue', 'ktoken'=>$kiosk[0]->atoken);
					$this->sendResponse(201, CJSON::encode($result));
				}
				
			} else {
                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_PARAMETER', 'errorDescription' => 'POST  parameter required for action')));
            }
		} catch (Exception $ex) {
            $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER_ERROR', 'errorDescription' => 'Something went wrong')));
        }
	}
	 
}

function pr($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}
