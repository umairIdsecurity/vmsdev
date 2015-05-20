<?php

class VisitorController extends RestfulController {

    /**
     * Visitor
     * Signup visitor,Get Visitor & Update Visitor
     * by rohan m.
     * * */
    public function actionIndex() {
        try {
            $token_user = $this->checkAuth();
            if (Yii::app()->request->isPostRequest) {
                $data = file_get_contents("php://input");
                $data = CJSON::decode($data);
                $this->validateData($data);
                $visitor = new Visitor();
                $visitorService = new VisitorServiceImpl();
                $visitor->first_name = $data['firstName'];
                $visitor->last_name = $data['lastName'];
                $visitor->email = $this->validateEmail($data['email']);
                $visitor->visitor_type = $data['visitorType'];
                $visitor->company = $data['company'];
                $visitor->password = CPasswordHelper::hashPassword($data['password']);
                $visitor->photo = NULL;

                if ($visitor->save(false)) {
                    $result = array();
                    $company = Company::model()->findByPk($visitor->company);
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
                    $result['visitor_type'] = $visitor->visitor_type;
                    $result['vehicle'] = $visitor->vehicle;
                    $result['createdBy'] = $visitor->created_by;
                    $result['tenant'] = $visitor->tenant;
                    $result['tenantAgent'] = $visitor->tenant_agent;
                    $result['visitorCardStatus'] = $visitor->visitor_card_status;
                    $result['visitorWorkstation'] = $visitor->visitor_workstation;
                    $result['company'] = array('companyName' => ($company)?$company->name:"N/A");

                    $this->sendResponse(200, CJSON::encode($result));
                }
            } elseif (yii::app()->request->isPutRequest) {
                $data = file_get_contents("php://input");
                $data = CJSON::decode($data);
                $visitor = Visitor::model()->findByAttributes(array('email' => $data['email']));
                $this->validateData($data);
                if ($visitor) {
                    $visitor->first_name = $data['firstName'];
                    $visitor->last_name = $data['lastName'];
                    $visitor->visitor_type = $data['visitorType'];
                    $visitor->company = $data['company'];
                    $visitor->password = CPasswordHelper::hashPassword($data['password']);
                    $visitor->photo = NULL;
                    if ($visitor->save(false)) {
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
                        $result['visitor_type'] = $visitor->visitor_type;
                        $result['vehicle'] = $visitor->vehicle;
                        $result['createdBy'] = $visitor->created_by;
                        $result['tenant'] = $visitor->tenant;
                        $result['tenantAgent'] = $visitor->tenant_agent;
                        $result['visitorCardStatus'] = $visitor->visitor_card_status;
                        $result['visitorWorkstation'] = $visitor->visitor_workstation;
                        $result['company'] = array('companyName' => Company::model()->findByPk($visitor->company)->name);
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
                    $result['visitor_type'] = $visitor->visitor_type;
                    $result['vehicle'] = $visitor->vehicle;
                    $result['createdBy'] = $visitor->created_by;
                    $result['tenant'] = $visitor->tenant;
                    $result['tenantAgent'] = $visitor->tenant_agent;
                    $result['visitorCardStatus'] = $visitor->visitor_card_status;
                    $result['visitorWorkstation'] = $visitor->visitor_workstation;
                    $result['company'] = array('companyName' => Company::model()->findByPk($visitor->company)->name);

                    $this->sendResponse(200, CJSON::encode($result));
                }


                die;
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

}
