<?php

class CustomController extends RestfulController {

    /**
     * Admin
     * Get Admin & Admin Logout
     * by rohan m.
     * * */
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
}

function pr($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}
