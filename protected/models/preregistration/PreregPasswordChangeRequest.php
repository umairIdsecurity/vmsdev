<?php

/**
 * This is the model class for table "visitor_password_change_request".
 *
 * @author Yuri Vodolazsky
 */
class PreregPasswordChangeRequest extends CActiveRecord
{
    const IS_USED_YES = 'YES';
    const IS_USED_NO = 'NO';

    const ALLOWED_GENERATION_INTERVAL = 24; // in hours
    const NUMBER_OF_ATTEMPTS = 3; // during allowed generation interval

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'visitor_password_change_request';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PasswordChangeRequest the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Generate reset password record
     *
     * @param visitor $visitor
     * @return string
     * @throws Exception
     * @throws Mandrill_Error
     */
    public function generateResetLink(Visitor $visitor)
    {
        $generatedRequestsCount = $this->count($this->getAlreadyGeneratedUnexpiredUnusedCriteria($visitor));

        if ($generatedRequestsCount >= self::NUMBER_OF_ATTEMPTS) {
            return "You have exceeded the maximum number of password recovery attempts";
        }

        $now = new DateTime;

        $request = new self();
        $request->visitor_id = $visitor->id;
        $request->hash = $this->getHash($visitor);
        $request->created_at = $now->format('Y-m-d H:i:s');

        $result = $request->save();

        if (!$result) {
            return "Service is temporary unavailable, please try again later";
        }

        $templateParams = array(
            'email' => $visitor->email,
            'resetLink' => Yii::app()->getBaseUrl(true) . '/index.php?r=site/reset/hash/' . $request->hash,
        );

        $emailTransport = new EmailTransport();
        $emailTransport->sendResetPasswordEmail(
            $templateParams, $visitor->email, $visitor->first_name . ' ' . $visitor->last_name
        );
    }

    /**
     * @param visitor $visitor
     * @return string
     */
    public function getHash(Visitor $visitor)
    {
        return md5(time() . $visitor->id . $visitor->email . 'Some salt 9ht3ldjnhuy)jnt47thlJ&');
    }

    /**
     * @param visitor $visitor
     * @return CDbCriteria
     */
    public function getAlreadyGeneratedUnexpiredUnusedCriteria(Visitor $visitor)
    {
        $date = $this->getStartOfExpiredPeriod();

        $criteria = new CDbCriteria();
        $criteria->condition = "visitor_id = :visitorId and is_used = :isUsed and created_at >= :createdAt";
        $criteria->params = array(
            'visitorId' => $visitor->id,
            'isUsed' => self::IS_USED_NO,
            'createdAt' => $date,
        );

        return $criteria;
    }

    /**
     * Rest password by hash generated early
     *
     * @return string
     */
    public function checkPasswordRequestByHash()
    {
        if ($this->isExpired()) {
            return "Your reset password link is already expired. Please generate it again.";
        }

        if ($this->isUsed()) {
            return "Your reset password link is already used. Please generate it again.";
        }
    }

    public function isExpired()
    {
        $expiredDate = $this->getStartOfExpiredPeriod(false);
        $requestDate = DateTime::createFromFormat('Y-m-d H:i:s', $this->created_at);

        return $expiredDate > $requestDate;
    }

    public function isUsed()
    {
        return $this->is_used == self::IS_USED_YES;
    }

    /**
     * @param bool $asString
     * @return string
     */
    public function getStartOfExpiredPeriod($asString = true)
    {
        $date = new DateTime();
        $date->modify('- ' . self::ALLOWED_GENERATION_INTERVAL . 'hours');
        return $asString ? $date->format('Y-m-d H:i:s') : $date;
    }

    public function markAsUsed(Visitor $visitor)
    {
        $this->is_used = self::IS_USED_YES;
        $this->save(false, 'is_used');

        $templateParams = array(
            'email' => $visitor->email,
        );

        $emailTransport = new EmailTransport();
        $emailTransport->sendResetPasswordConfirmationEmail(
            $templateParams, $visitor->email, $visitor->first_name . ' ' . $visitor->last_name
        );
    }

    public function behaviors()
    {
        return array(

            'AuditTrailBehaviors'=>
                'application.components.behaviors.AuditTrailBehaviors',
        );
    }

}
