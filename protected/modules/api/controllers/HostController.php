<?php

class HostController extends RestfulController {

    /**
     * Host
     * Get Host & Search Host
     * by rohan m.
     * * */
    public function actionIndex() {
        try {
            $token_user = $this->checkAuth();
            if (Yii::app()->request->getParam('email')) {
                $email = Yii::app()->request->getParam('email');
                $host = User::model()->with('com')->findByAttributes(array('email' => $email));
                if ($host) {
                    $result = $this->populateHost(array($host));
                    $this->sendResponse(200, CJSON::encode($result));
                } else {
                    $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'HOST_DOES_NOT_EXIST', 'errorDescription' => 'Requested Host not found')));
                }
            } else {
                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_PARAMETER', 'errorDescription' => 'GET parameter required for action')));
            }
        } catch (Exception $ex) {
            $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER_ERROR', 'errorDescription' => 'Something went wrong')));
        }
    }

    public function actionSearch() {

        try {
            $token_user = $this->checkAuth();
            if (Yii::app()->request->getParam('query')) {
                $query = explode(" ", Yii::app()->request->getParam('query'));

                $criteria = new CDbCriteria();



                foreach ($query as $q):
                    $criteria->addSearchCondition("email", $q, TRUE, "OR", "LIKE");
                    $criteria->addSearchCondition("first_name", $q, TRUE, "OR", "LIKE");
                    $criteria->addSearchCondition("last_name", $q, TRUE, "OR", "LIKE");
                endforeach;
                $criteria->addCondition("role = 9","AND");

                $hosts = User::model()->with('com')->findAll($criteria);
                if ($hosts) {
                    $result = $this->populateHost($hosts);
                    echo "<pre>";
                    die(print_r($result));
                    $this->sendResponse(200, CJSON::encode($result));
                } else {
                    $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'HOST_NOT_FOUND', 'errorDescription' => 'No host for requseted query')));
                }
            } else {
                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_PARAMETER', 'errorDescription' => 'GET parameter required for action')));
            }
        } catch (Exception $ex) {
            $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER_ERROR', 'errorDescription' => 'Something went wrong')));
        }
    }

    private function populateHost($hosts) {
        $result = array();
        $i = 0;
        foreach ($hosts as $host) {
            $result[$i]['hostID'] = $host->id;
            $result[$i]['firstName'] = $host->first_name;
            $result[$i]['lastName'] = $host->last_name;
            $result[$i]['email'] = $host->email;
            $result[$i]['phone'] = $host->contact_number;
            $result[$i]['companyName'] = ($host->com->name) ? $host->com->name : "N/A";
            $result[$i]['companyLogoURL'] = ($host->com->ph) ? Yii::app()->request->hostInfo . yii::app()->baseUrl . '/' . $host->com->ph->relative_path : "N/A";
            $result[$i]['companyTagLine'] = ($host->com->trading_name) ? $host->com->trading_name : "N/A";
            $result[$i]['VICPickupLoctaion'] = "N/A";
            $i++;
        }
        return $result;
    }

}
