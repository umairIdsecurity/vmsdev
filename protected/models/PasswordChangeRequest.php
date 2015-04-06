<?php

require_once __DIR__ . '/../../vendor/mandrill/mandrill/src/Mandrill.php';

/**
 * This is the model class for table "password_change_request".
 *
 * @author Yuri Vodolazsky
 */
class PasswordChangeRequest extends CActiveRecord
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
        return 'password_change_request';
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
     * @param User $user
     * @return string
     */
    public function generateResetLink(User $user)
    {
        $generatedRequestsCount = $this->count($this->getAlreadyGeneratedUnexpiredUnusedCriteria($user));

        if ($generatedRequestsCount >= self::NUMBER_OF_ATTEMPTS) {
            return "You have exceeded the maximum number of password recovery attempts";
        }

        $now = new DateTime;

        $request = new self();
        $request->user_id = $user->id;
        $request->hash = $this->getHash($user);
        $request->created_at = $now->format('Y-m-d H:i:s');

        $result = $request->save();

        if (!$result) {
            return "Service is temporary unavailable, please try again later";
        }

        // TODO send email with hash link
        try {
            $mandrill = new Mandrill(Yii::app()->params['mandrillApiKey']);
            $message = array(
                'html' => "<p>Hash code <strong>$request->hash</strong></p>",
                'subject' => 'Resotore password',
                'from_email' => 'message.from_email@example.com',
                'from_name' => 'Example Name',
                'to' => array(
                    array(
                        'email' => 'vodolazky@gmail.com',
                        'type' => 'to'
                    )
                ),
            );
            $async = false;
            $ip_pool = 'Main Pool';
            $result = $mandrill->messages->send($message, $async, $ip_pool);
            print_r($result);
        } catch(Mandrill_Error $e) {
            // Mandrill errors are thrown as exceptions
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
            throw $e;
        }
    }

    /**
     * @param User $user
     * @return string
     */
    public function getHash(User $user)
    {
        return md5(time() . $user->id . $user->email . 'Some salt 9ht3ldjnhuy)jnt47thlJ&');
    }

    /**
     * @param User $user
     * @return CDbCriteria
     */
    public function getAlreadyGeneratedUnexpiredUnusedCriteria(User $user)
    {
        $date = $this->getStartOfExpiredPeriod();

        $criteria = new CDbCriteria();
        $criteria->condition = "user_id = :userId and is_used = :isUsed and created_at >= :createdAt";
        $criteria->params = array(
            'userId' => $user->id,
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

    public function markAsUsed()
    {
        $this->is_used = self::IS_USED_YES;
        $this->save(false, 'is_used');
    }
}
