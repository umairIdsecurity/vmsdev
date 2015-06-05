<?php

class VisitController extends RestfulController {

    /**
     * Visit
     * Create Visit,Upload Picture for visit & Get Visit
     * by rohan m.
     * * */
    public function actionIndex() {
        try {
            $token_user = $this->checkAuth();
            if (Yii::app()->request->isPostRequest) {
                $data = file_get_contents("php://input");
                $data = CJSON::decode($data);
                $visit = new Visit();
                $visit->scenario = 'api';
                $visit->host = $data['hostID'];
                $visit->visitor_type = isset($data['visitorType'])?$data['visitorType']:NULL;
                $visit->visitor = $data['visitorID'];
                $visit->visit_status = 1;
                $visit->date_check_in = isset($data['startTime'])?date('d-m-Y', strtotime($data['startTime'])):NULL;
                $visit->time_check_in = isset($data['startTime'])?date('H:i:s', strtotime($data['startTime'])):NULL;
                $visit->date_check_out = isset($data['expectedEndTime'])?date('d-m-Y', strtotime($data['expectedEndTime'])):NULL;
                $visit->time_check_out = isset($data['expectedEndTime'])?date('H:i:s', strtotime($data['expectedEndTime'])):NULL;
                $visit->reason = isset($data['visitReason'])?$data['visitReason']:NULL;
                $visit->workstation = isset($data['workstation'])?$data['workstation']:NULL;
                if ($visit->validate()) {
                    $visit->save();
                    $visit = Visit::model()->with('visitor0')->findByPk($visit->id);
                    $result = $this->populateVisits(array($visit));
                    $this->sendResponse(200, CJSON::encode($result));
                } else {
                    $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_DATA', 'errorDescription' => 'Requsted data are invalid')));
                }
            } elseif (yii::app()->request->getParam('email') || yii::app()->request->getParam('VICNumber')) {
                if (yii::app()->request->getParam('email')) {
                    $email = Yii::app()->request->getParam('email');
                    $visitor = Visitor::model()->findByAttributes(array('email' => $email));
                    if ($visitor) {
                        $visits = Visit::model()->with('visitor0')->findAllByAttributes(array('visitor' => $visitor->id));
                        if ($visits) {
                            $result = $this->populateVisits($visits);
                            $this->sendResponse(200, CJSON::encode($result));
                        } else {
                            $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'NO_VISIT_FOUND', 'errorDescription' => 'not visit found for this visitor')));
                        }
                    } else {
                        $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_EMAIL', 'errorDescription' => 'Requsted email is not found in visitor')));
                    }
                } else {
                    $vic_number = yii::app()->request->getParam('VICNumber');
                    $visits = Visit::model()->with('visitor0')->findAllByAttributes(array('card' => $vic_number));
                    if ($visits) {
                        $result = $this->populateVisits($visits);
                        $this->sendResponse(200, CJSON::encode($result));
                    } else {
                        $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'NO_VISIT_FOUND', 'errorDescription' => 'not visit found for this visitor')));
                    }
                }
            } elseif (yii::app()->request->isPutRequest) {
                $data = file_get_contents("php://input");
                $data = CJSON::decode($data);
                $visit = Visit::model()->findByPk($data['visitID']);
                $visit->host = $data['hostID'];
                $visit->visit_status = 1;
                $visit->visitor_type = $data['visitorType'];
                $visit->visitor = $data['visitorID'];
                $visit->date_check_in = date('d-m-Y', strtotime($data['startTime']));
                $visit->time_check_in = date('H:i:s', strtotime($data['startTime']));
                $visit->date_check_out = date('d-m-Y', strtotime($data['expectedEndTime']));
                $visit->time_check_out = date('H:i:s', strtotime($data['expectedEndTime']));
                $visit->reason = $data['visitReason'];
                $visit->workstation = $data['workstation'];
                if ($visit->validate()) {
                    $visit->save();
                    $visit = Visit::model()->with('visitor0')->findByPk($visit->id);
                    $result = $this->populateVisits(array($visit));
                    $this->sendResponse(200, CJSON::encode($result));
                } else {
                    $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_DATA', 'errorDescription' => 'Requsted data are invalid')));
                }
            } elseif (yii::app()->request->getParam('visit')) {
                $visit = Visit::model()->findByPk(yii::app()->request->getParam('visit'));
                $visit->date_check_out = date('d-m-Y');
                $visit->time_check_out = date('H:i:s');
                $visit->visit_status = NULL;
                $visit->save(false);
                $this->sendResponse(204);
            }
        } catch (Exception $ex) {
            $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER_ERROR', 'errorDescription' => 'something went wrong')));
        }
    }

    public function actionfile() {
        try {
            if (yii::app()->request->getParam('visit')) {
                $visitorid = Visit::model()->findByPk(yii::app()->request->getParam('visit'))->visitor;
                if (!isset($_FILES['file']['name'])) {
                    $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_REQUEST', 'errorDescription' => 'File not available')));
                }
                if ($visitorid) {
                    $usernameHash = hash('adler32', "KIOSK");
                    $path_parts = pathinfo($_FILES["file"]["name"]);
                    $filename = $_FILES['file']['name'];
                    $extension = $path_parts['extension'];
                    $uniqueFileName = $usernameHash . '-' . time() . "." . $extension;
                    $path = "uploads/visitor/" . $uniqueFileName;
                    $output_dir = Yii::getPathOfAlias('webroot') . "/uploads/visitor/";
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $output_dir . $uniqueFileName)) {
                        $photo = new Photo();
                        $photo->filename = $filename;
                        $photo->unique_filename = $uniqueFileName;
                        $photo->relative_path = $path;
                        if ($photo->validate()) {
                            $photo->save(false);
                            $visitor = Visitor::model()->findByPk($visitorid);
                            $visitor->photo = $photo->id;
                            $visitor->save(false);
                            $result = array('title' => $photo->unique_filename);
                            $this->sendResponse(200, CJSON::encode($result));
                        } else {
                            $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER', 'errorDescription' => 'something went wrong')));
                        }
                    } else {
                        $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_REQUEST', 'errorDescription' => 'invalid request visit required')));
                    }
                } else {
                    $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'NO_VISITOR_FOUND', 'errorDescription' => 'no visitor found')));
                }
            } else {
                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_REQUEST', 'errorDescription' => 'invalid request visit required')));
            }
        } catch (Exception $ex) {
            $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER_ERROR', 'errorDescription' => 'something went wrong')));
        }
    }

    private function populateVisits($visits) {
        $result = array();
        $i = 0;
        foreach ($visits as $visit) {
            $result[$i]['visitID'] = $visit->id;
            $result[$i]['visitorID'] = $visit->visitor;
            $result[$i]['hostID'] = $visit->host;
            $result[$i]['visitorType'] = $visit->visitor_type;
            $result[$i]['startTime'] = ($visit->date_check_in==NULL)?date("Y-m-d H:i:s", strtotime($visit->date_check_in . '' . $visit->time_check_in)):"N/A";
            $result[$i]['expectedEndTime'] = ($visit->date_check_out==NULL) ? date("Y-m-d H:i:s", strtotime($visit->date_check_out . '' . $visit->time_check_out)) : "N/A";
            $result[$i]['visitorPicture'] = !empty($visit->visitor0->photo)?$visit->visitor0->photo:"N/A";
            if($visit->visitor0){
                $result[$i]['visitor'] = array('visitorID' => $visit->visitor0->id, 'firstName' => $visit->visitor0->first_name, 'lastName' => $visit->visitor0->last_name, 'email' => $visit->visitor0->email, 'companyName' => Company::model()->findByPk($visit->visitor0->company)->name);
            }else{
                $result[$i]['visitor'] = array();
            }
            
            $host = User::model()->with('com')->findByPk($visit->host);
            if($host){
                $result[$i]['host'] = array('hostID' => $visit->host, 'firstName' => $host->first_name, 'lastName' => $host->last_name, 'email' => $host->email, 'companyName' => ($host->com->name != null)?$host->com->name:"N/A");
            }else{
                $result[$i]['host'] = array();
            }
            
            $i++;
        }
        return $result;
    }

}
