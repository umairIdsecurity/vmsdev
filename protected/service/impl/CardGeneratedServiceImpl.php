<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CardGeneratedServiceImpl
 *
 * @author Jeremiah
 */
class CardGeneratedServiceImpl implements CardGeneratedService {

    public function save($cardGenerated, $visit, $sessionTenant, $sessionTenantAgent, $sessionId) {

        if ($visit->card_type == CardType::MULTI_DAY_VISITOR) {
            $cardGenerated->date_expiration = $visit->date_out;
        }

        if (!($cardGenerated->save(false))) {
            return false;
        }

        Visit::model()->updateByPk($visit->id, array(
            'card' => $cardGenerated->id,
        ));
        $visitorModel = Visitor::model()->findByPk($visit->visitor);

        $usernameHash = hash('adler32', $visitorModel->email);
        $unique_fileName = 'card' . $usernameHash . '-' . time() . ".png";
        $path = "uploads/card_generated/" . $unique_fileName;
        Yii::app()->params['photo_unique_filename'] = $unique_fileName;

        $photo = new Photo;
        $photo->filename = $unique_fileName;
        $photo->unique_filename = $unique_fileName;
        $photo->relative_path = $path;
        $photo->save();


        return true;
    }

    public function updateCard($cardGenerated, $visit, $sessionTenant, $sessionTenantAgent, $sessionId) {

        if ($visit->card_type == CardType::MULTI_DAY_VISITOR) {
            $cardGenerated->date_expiration = $visit->date_out;
        }

        if ($visit->card != NULL) {
            CardGenerated::model()->updateByPk($visit->card, array(
                'card_status' => CardStatus::CANCELLED,
                'date_cancelled' => date('Y-m-d'),
            ));
        }

        if (!($cardGenerated->save(false))) {
            return false;
        }

        Visit::model()->updateByPk($visit->id, array(
            'card' => $cardGenerated->id,
        ));
        $visitorModel = Visitor::model()->findByPk($visit->visitor);

        $usernameHash = hash('adler32', $visitorModel->email);
        $unique_fileName = 'card' . $usernameHash . '-' . time() . ".png";
        $path = "uploads/card_generated/" . $unique_fileName;
        Yii::app()->params['photo_unique_filename'] = $unique_fileName;
        $photo = new Photo;
        $photo->filename = $unique_fileName;
        $photo->unique_filename = $unique_fileName;
        $photo->relative_path = $path;
        $photo->save();

        return true;
    }

    public function saveCardImage($visit) {

        $photo = Photo::model()->findByAttributes(array('unique_filename' => Yii::app()->params['photo_unique_filename']));

        CardGenerated::model()->updateByPk($visit->card, array(
            'card_image_generated_filename' => $photo->id,
        ));
    }

}
