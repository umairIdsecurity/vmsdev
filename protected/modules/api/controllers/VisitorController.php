<?php

class VisitorController extends RestfulController {

    /**
     * Visitor
     * Signup visitor,Get Visitor & Update Visitor
     * by rohan m.
     * * */
    public function actionIndex() {
        try {
            // get AccessTokens
            $access_token = $this->getAccessToken() ;
            if(!$access_token) {
                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'HTTP_X_VMS_TOKEN', 'errorDescription' => 'HTTP_X_VMS_TOKEN is invalid.')));
                return false;
            }

            // do response
            if (Yii::app()->request->isPostRequest) {
                if( $access_token->USER_TYPE == self::ADMIN_USER ) {
                    $data = file_get_contents("php://input");
                    $data = CJSON::decode($data);
                    $companyID = $this->getCompany($data['company']);
                    $this->validateData($data);
                    $visitor = new Visitor();
                    $visitorService = new VisitorServiceImpl();
                    $visitor->first_name = $data['firstName'];
                    $visitor->last_name = $data['lastName'];
                    $visitor->email = $this->validateEmail($data['email']);
                    $visitor->visitor_type = $data['visitorType'];
                    $visitor->company = $companyID;
                    $visitor->password = CPasswordHelper::hashPassword($data['password']);
                    $visitor->created_by = $access_token->USER_ID;
                    $visitor->photo = NULL;

                    if ($visitor->save(false)) {
                        $result = array();
                        $result = $this->populatevisitor($visitor);

                        $this->sendResponse(200, CJSON::encode($result));
                    }
                }
                else {
                    $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'NOT_PERMISSION', 'errorDescription' => 'Not permission create visitor')));
                }
            } elseif (yii::app()->request->isPutRequest) {
                // $visitor_token_user = $this->checkAuthVisitor();
                $data = file_get_contents("php://input");
                $data = CJSON::decode($data);
                $visitor = Visitor::model()->findByAttributes(array('email' => $data['email']));
                $companyID = $this->getCompany($data['company']);
                $this->validateData($data);
                if ($visitor) {
                    $visitor->first_name = $data['firstName'];
                    $visitor->last_name = $data['lastName'];
                    $visitor->visitor_type = $data['visitorType'];
                    $visitor->company = $companyID;
                    $visitor->password = $data['password'];
                    //$visitor->photo = NULL;
                    if ($visitor->save(false)) {
                        $result = $this->populatevisitor($visitor);
                        $this->sendResponse(200, CJSON::encode($result));
                    }
                    die;
                } else {
                    $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'VISITOR_NOT_FOUND', 'errorDescription' => 'visitor is not found ')));
                }
            } else {
                $email = $_GET['email'];
                $visitor = Visitor::model()->findByAttributes(array('email' => $email));
                if ($visitor) {
                    $result = $this->populatevisitor($visitor);
                    $this->sendResponse(200, CJSON::encode($result));
                } else {
                    $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'VISITOR_NOT_FOUND', 'errorDescription' => 'visitor is not found ')));
                }
            }
        } catch (Exception $ex) {
            $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER_ERROR', 'errorDescription' => 'something went wrong')));
        }
    }

    public function actionLogout() {
        try {
            $access_token = $this->getAccessToken() ;
            if(!$access_token) {
                $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'VISITOR_NOT_FOUND', 'errorDescription' => 'Access Token Admin not match')));
            }
            if (Yii::app()->request->getParam('email') ) {
                $email = Yii::app()->request->getParam('email');
                $visitor = Visitor::model()->findByAttributes(array('email' => $email));
                if ($visitor) {
                    $access_token->delete();
                    $this->sendResponse(204);
                } else {
                    $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'VISITOR_NOT_FOUND', 'errorDescription' => 'Requested Admin not found')));
                }
            } else {
                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_PARAMETER', 'errorDescription' => 'GET parameter required for action')));
            }
        } catch (Exception $ex) {
            $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER_ERROR', 'errorDescription' => 'something went wrong')));
        }
    }

    public function actionRequestPassword() {
        try {
            $token_user = $this->checkAuth();
            if (Yii::app()->request->getParam('email')) {
                $email = Yii::app()->request->getParam('email');
                $visitor = Visitor::model()->findByAttributes(array('email' => $email));
                if ($visitor) {
                   /* $visitor->reset_token = $token = md5(uniqid(mt_rand(), true));*/
                    $new_pass = uniqid(mt_rand(), true);
                    $visitor->password = $new_pass;
                    $visitor->repeatpassword = $new_pass;
                    if ($visitor->save()) {
                        $this->sendResponse(200);
                    }
                }else{
                    $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'VISITOR_NOT_FOUND', 'errorDescription' => 'Requested Visitor not found')));
                }

            } else {
                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_PARAMETER', 'errorDescription' => 'GET parameter required for action')));
            }
        } catch (Exception $ex) {

            $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER_ERROR', 'errorDescription' => 'something went wrong')));
        }
    }

    public function actionResetPassword() {
        try {
            $token_user = $this->checkAuth();
            if (Yii::app()->request->getParam('email')) {
                $email = Yii::app()->request->getParam('email');
            }else{
                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_PARAMETER', 'errorDescription' => 'GET parameter required for action')));
            }
            if(yii::app()->request->isPutRequest){
                $data = file_get_contents("php://input");
                $data = CJSON::decode($data);
                $visitor = Visitor::model()->findByAttributes(array('email' => $email));
                if ($visitor) {
                    /*if($visitor->reset_token != NULL) {*/
                        $visitor->password = $data['password'];
                        $visitor->repeatpassword = $data['password'];
                        /*$visitor->contact_postcode = 0;
                        $visitor->reset_token = NULL;*/
                        if ($visitor->save()) {
                            $this->sendResponse(200);
                        }else{
                            $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'UNAUTHORISED', 'errorDescription' => 'unauthorized request')));
                        }
                   /* }else{
                        $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'UNAUTHORISED', 'errorDescription' => 'unauthorized request')));
                    }*/
                }else{
                    $this->sendResponse(404, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'VISITOR_NOT_FOUND', 'errorDescription' => 'Requested Visitor not found')));
                }

            } else {
                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_PARAMETER', 'errorDescription' => 'GET parameter required for action')));
            }
        } catch (Exception $ex) {

            $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER_ERROR', 'errorDescription' => 'something went wrong')));
        }


    }

    public function validateEmail($email) {
        $visitor = Visitor::model()->findByAttributes(array('email' => $email));
        if ($visitor) {
            $this->sendResponse(400, CJSON::encode(array('responseCode' => 400, 'errorCode' => 'VISITOR_EMAIL_ALREADY_EXIST', 'errorDescription' => 'email already exist')));
        } else {
            return $email;
        }
    }

    public function validateData($data) {
        if (!isset($data['firstName']) || empty($data['firstName'])) {
            $this->sendResponse(400, CJSON::encode(array('responseCode' => 400, 'errorCode' => 'VISITOR_FIRST_NAME_MISSING', 'errorDescription' => 'first name should not be blank')));
        } elseif (!isset($data['lastName']) || empty($data['lastName'])) {
            $this->sendResponse(400, CJSON::encode(array('responseCode' => 400, 'errorCode' => 'VISITOR_LAST_NAME_MISSING', 'errorDescription' => 'last name should not be blank')));
        } elseif (!isset($data['email']) || empty($data['email'])) {
            $this->sendResponse(400, CJSON::encode(array('responseCode' => 400, 'errorCode' => 'VISITOR_EMAIL_MISSING', 'errorDescription' => 'email should not be blank')));
        } elseif (!isset($data['password']) || empty($data['password'])) {
            $this->sendResponse(400, CJSON::encode(array('responseCode' => 400, 'errorCode' => 'VISITOR_PASSWORD_MISSING', 'errorDescription' => 'password should not be blank')));
        } elseif (!isset($data['visitorType']) || empty($data['visitorType'])) {
            $this->sendResponse(400, CJSON::encode(array('responseCode' => 400, 'errorCode' => 'VISITOR_TYPE_MISSING', 'errorDescription' => 'visitor type should not be blank')));
        }
    }

    private function populatevisitor($visitor) {
        $result = array();
        $result['visitorID'] = $visitor->id;
        $result['firstName'] = $visitor->first_name;
        $result['lastName'] = $visitor->last_name;
        $result['email'] = $visitor->email;
        $result['companyID'] = $visitor->company;
        $result['photo'] = $visitor->photo;
        $result['contactNumber'] = $visitor->contact_number;
        $result['dateOfBirth'] = $visitor->date_of_birth;
        $result['department'] = $visitor->department;
        $result['staffId'] = $visitor->staff_id;
        $result['notes'] = $visitor->notes;
        $result['visitorType'] = $visitor->visitor_type;
        $result['vehicle'] = $visitor->vehicle;
        $result['createdBy'] = $visitor->created_by;
        $result['tenant'] = $visitor->tenant;
        $result['tenantAgent'] = $visitor->tenant_agent;
        $result['visitorCardStatus'] = $visitor->visitor_card_status;
        $result['visitorWorkstation'] = $visitor->visitor_workstation;
        if ($visitor->company != NULL && is_numeric($visitor->company)) {
            $company = Company::model()->findByPk($visitor->company);
            if ($company) {
                $result['company'] = array('companyName' => $company->name);
            }
        }


        return $result;
    }

    private function getCompany($name) {

        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(name)', strtolower($name), true);
        $company = Company::model()->find($criteria);
        if ($company) {
            return $company->id;
        } else {
            return NULL;
        }
    }

}
