<?php

class WorkstationController extends RestfulController {

    /**
     * Workstation
     * Get CardType
     * by rohan m.
     * * */
    public function actionIndex() {
        try {
            $token_user = $this->checkAuth();
            if (Yii::app()->request->getParam('id')) {
                $id = Yii::app()->request->getParam('id');
                $criteria = new CDbCriteria();
                $criteria->addCondition('module=1');
                $validcards = CardType::model()->findAll($criteria);
                $cardType = array();
                foreach($validcards as $cards){
                    array_push($cardType, $cards->id);
                }
                $criteria = new CDbCriteria();
                $criteria->addCondition("workstation=".$id);
                $criteria->addInCondition('card_type',$cardType);

                $workstation  = WorkstationCardType::model()->findAll($criteria);
                if ($workstation) {
                    $result = $this->populateCardType($workstation);
                    $this->sendResponse(200, CJSON::encode($result));
                }else{
                    $this->sendResponse(401, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'WORKSTATION_NOT_FOUND', 'errorDescription' => 'workstation not found')));
                }
            } else {
                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'UNAUTHORIZED', 'errorDescription' => 'wrong param for request')));
            }
        } catch (Exception $ex) {
            $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER_ERROR', 'errorDescription' => 'something went wrong')));
        }
    }

    private function populateCardType($workstation) {
        $result = array();
        $i = 0;
        foreach ($workstation as $ws){
            $result[$i]['name'] = $ws->cardType->name  ;
            $result[$i]['CardIconImage'] =  ($ws->cardType->card_icon_type)?Yii::app()->request->hostInfo . yii::app()->baseUrl . '/' .$ws->cardType->card_icon_type : "N/A" ;
            $result[$i]['CardBackGroundImage'] = ($ws->cardType->card_background_image_path)?Yii::app()->request->hostInfo . yii::app()->baseUrl . '/' .$ws->cardType->card_background_image_path : "N/A" ;
            $i++;
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
