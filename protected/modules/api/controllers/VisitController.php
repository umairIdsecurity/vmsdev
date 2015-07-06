<?php

class VisitController extends RestfulController {

    /**
     * Visit
     * Create Visit,Upload Picture for visit & Get Visit
     * by rohan m.
     * * */
    public function actionIndex() {
        try {
            $access_token = $this->getAccessToken();
            if(!$access_token) {
                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'HTTP_X_VMS_TOKEN', 'errorDescription' => 'HTTP_X_VMS_TOKEN is invalid.')));
                return false;
            }

            if (Yii::app()->request->isPostRequest) {
                $data = file_get_contents("php://input");
                $data = CJSON::decode($data);

                //check Visitor ID
                $visitor = Visitor::model()->findByPk($data['visitorID']);
                if(!$visitor) {
                    $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'NO_VISIT_FOUND', 'errorDescription' => 'Visitor found for this visit')));
                    return false;
                }

                $visit = new Visit();
                $visit->scenario = 'api';
                $visit->host = $data['hostID'];
                $visit->visitor_type = isset($data['visitorType']) ? $data['visitorType'] : NULL;
                $visit->visitor = $data['visitorID'];
                $visit->card_type = isset($data['visitCardType']) ? $data['visitCardType']:1;
                $visit->visit_status = isset($data['visitorStatus']) ? $data['visitorStatus']:5;
                $visit->date_check_in = isset($data['startTime']) ? date('d-m-Y', strtotime($data['startTime'])) : NULL;
                $visit->time_check_in = isset($data['startTime']) ? date('H:i:s', strtotime($data['startTime'])) : NULL;
                $visit->date_check_out = isset($data['expectedEndTime']) ? date('d-m-Y', strtotime($data['expectedEndTime'])) : NULL;
                $visit->time_check_out = isset($data['expectedEndTime']) ? date('H:i:s', strtotime($data['expectedEndTime'])) : NULL;
                $visit->reason = isset($data['visitReason']) ? $data['visitReason'] : 1;
                $visit->workstation = isset($data['workstation']) ? $data['workstation'] : NULL;
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
                $host = Visitor::model()->findByPk($data['hostID']);
                if($host) {
                    if ($visit) {
                        if ($data['visitorType'] == Visitor::PROFILE_TYPE_CORPORATE || $data['visitorType'] == Visitor::PROFILE_TYPE_VIC || $data['visitorType'] == Visitor::PROFILE_TYPE_ASIC) {
                            $this->validateDate($data);
                            $visit->host = $data['hostID'];
                            $visit->visit_status = 1;
                            $visit->visitor_type = $data['visitorType'];
                            $visit->visitor = $data['visitorID'];
                            $visit->date_check_in = date('d-m-Y', strtotime($data['startTime']));
                            $visit->time_check_in = date('H:i:s', strtotime($data['startTime']));
                            $visit->date_check_out = date('d-m-Y', strtotime($data['expectedEndTime']));
                            $visit->time_check_out = date('H:i:s', strtotime($data['expectedEndTime']));
                            if (!empty($data['checkOutTime'])) {
                                $visit->date_check_out = date('d-m-Y', strtotime($data['checkOutTime']));
                                $visit->time_check_out = date('H:i:s', strtotime($data['checkOutTime']));
                            }
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
                        }else{
                            $this->sendResponse(400, CJSON::encode(array('responseCode' => 400, 'errorCode' => 'VISITOR_TYPE_INVALID', 'errorDescription' => 'Requsted visitor type is invalid')));
                        }
                    } else {
                        $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'VISIT_NOT_FOUND', 'errorDescription' => 'Requested visit not found')));
                    }
                } else{
                    $this->sendResponse(400, CJSON::encode(array('responseCode' => 400, 'errorCode' => 'HOST_NOT_FOUND', 'errorDescription' => 'Requested host not found')));
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

                if(!$visitorid ) {
                    $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_REQUEST', 'errorDescription' => 'invalid request visit required')));
                }


                if (Yii::app()->request->isPostRequest) {
                    // post file

                    if (!isset($_FILES['file']['name'])) {
                        $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_REQUEST', 'errorDescription' => 'File not available')));
                    }

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
                }
                else {
                    // get file
                    $visitor = Visitor::model()->findByPk($visitorid);
                    if($visitor->photo) {
                        $result = ["image"=>Yii::app()->getBaseUrl(true)."/".Photo::model()->findByPk($visitor->photo)->relative_path];
                        $this->sendResponse(200, CJSON::encode($result));
                    }
                    else {
                        $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_REQUEST', 'errorDescription' => 'File not available')));
                    }
                }
            } else {
                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_REQUEST', 'errorDescription' => 'invalid request visit required')));
            }
        } catch (Exception $ex) {
            $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER_ERROR', 'errorDescription' => 'something went wrong')));
        }
    }

    public function actionCheckout() {
        try {
            $access_token = $this->getAccessToken() ;
            if(!$access_token) {
                $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'VISITOR_NOT_FOUND', 'errorDescription' => 'Access Token not match')));
            }
            if (Yii::app()->request->getParam('visitID') ) {
                $visitID = Yii::app()->request->getParam('visitID');
                $visit = Visit::model()->findByPk($visitID);
                if ($visit) {
                    $visit->date_check_out = date('Y-m-d');
                    $visit->time_check_out = date('H:i:s');
                    if($visit->save()) {
                        $this->sendResponse(204, CJSON::encode(['responseCode' => 204]));
                    } else {
                        $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'VISIT_NOT_CHECKOUT', 'errorDescription' => 'Visit cant not checkout')));
                    }
                } else {
                    $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'VISIT_NOT_FOUND', 'errorDescription' => 'Requested visit not found')));
                }
            } else {
                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_PARAMETER', 'errorDescription' => 'GET parameter required for action')));
            }
        } catch (Exception $ex) {
            $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER_ERROR', 'errorDescription' => 'something went wrong')));
        }
    }

    public function validateDate($data){
        if (!isset($data['startTime']) || empty($data['startTime'])) {
            $this->sendResponse(400, CJSON::encode(array('responseCode' => 400, 'errorCode' => 'START_TIME_INVALID', 'errorDescription' => 'Start Time invalid')));
        }
        if (!isset($data['expectedEndTime']) || empty($data['expectedEndTime'])) {
            $this->sendResponse(400, CJSON::encode(array('responseCode' => 400, 'errorCode' => 'END_TIME_INVALID', 'errorDescription' => 'End Time invalid')));
        }
        if (!isset($data['checkOutTime']) || empty($data['checkOutTime'])) {
            $this->sendResponse(400, CJSON::encode(array('responseCode' => 400, 'errorCode' => 'CHECKOUT_TIME_INVALID', 'errorDescription' => 'Check out time invalid')));
        }
        if (isset($data['startTime']) || isset($data['expectedEndTime'])) {
            if (strtotime(date('d-m-Y H:i:s', strtotime($data['startTime']))) > strtotime(date('d-m-Y H:i:s', strtotime($data['expectedEndTime']))))
            $this->sendResponse(400, CJSON::encode(array('responseCode' => 400, 'errorCode' => 'START_TIME_AFTER_END_TIME', 'errorDescription' => 'Start time after end time')));
        }
        if (isset($data['startTime']) || isset($data['checkOutTime'])) {
            if (strtotime(date('d-m-Y H:i:s', strtotime($data['startTime']))) > strtotime(date('d-m-Y H:i:s', strtotime($data['checkOutTime']))))
                $this->sendResponse(400, CJSON::encode(array('responseCode' => 400, 'errorCode' => 'START_TIME_AFTER_CHECKOUT_TIME', 'errorDescription' => 'Start time after check out time')));
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
            $result[$i]['startTime'] = ($visit->date_check_in != NULL) ? date("Y-m-dTH:i:sZ", strtotime($visit->date_check_in . '' . $visit->time_check_in)) : "N/A";
            $result[$i]['expectedEndTime'] = ($visit->date_check_out != NULL) ? date("Y-m-dTH:i:sZ", strtotime($visit->date_check_out . '' . $visit->time_check_out)) : "N/A";
            $result[$i]['visitorPicture'] = !empty($visit->visitor0->photo) ? $visit->visitor0->photo : "N/A";
            if ($visit->visitor0) {
                if (isset($visit->visitor0->id) && ($visit->visitor0->id != null)) {
                    $visitorid = $visit->visitor0->id;
                } else {
                    $visitorid = "N/A";
                }
                if (isset($visit->visitor0->first_name) && ($visit->visitor0->first_name != null)) {
                    $firstname = $visit->visitor0->first_name;
                } else {
                    $firstname = "N/A";
                }
                if (isset($visit->visitor0->last_name) && ($visit->visitor0->last_name != null)) {
                    $lastname = $visit->visitor0->last_name;
                } else {
                    $lastname = "N/A";
                }
                if (isset($visit->visitor0->email) && ($visit->visitor0->email != null)) {
                    $email = $visit->visitor0->email;
                } else {
                    $email = "N/A";
                }
                if (isset($visit->visitor0->profile_type) && ($visit->visitor0->profile_type != null)) {
                    $profile_type = $visit->visitor0->profile_type;
                } else {
                    $profile_type = "N/A";
                }
                if (isset($visit->visitor0->company) && ($visit->visitor0->company != null)) {
                    $company = Company::model()->findByPk($visit->visitor0->company);
                    if ($company) {
                        $companyname = $company->name;
                    } else {
                        $companyname = "N/A";
                    }
                } else {
                    $companyname = "N/A";
                }
                $result[$i]['visitor'] = array(
                    'visitorID' => $visitorid,
                    'firstName' => $firstname,
                    'lastName' => $lastname,
                    'email' => $email,
                    'companyName' => $companyname,
                    'profileType' => $profile_type,
                );
            } else {
                $result[$i]['visitor'] = array();
            }

            $host = User::model()->with('com')->findByPk($visit->host);
            if ($host) {
                $result[$i]['host'] = array('hostID' => $visit->host, 'firstName' => $host->first_name, 'lastName' => $host->last_name, 'email' => $host->email, 'companyName' => ($host->com->name != null) ? $host->com->name : "N/A");
            } else {
                $result[$i]['host'] = array();
            }

            $i++;
        }
        return $result;
    }

}
