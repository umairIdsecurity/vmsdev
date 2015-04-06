<?php

/**
 * This is the model class for table "password_change_request".
 *
 */
class PasswordChangeRequest extends CActiveRecord
{
    const IS_SENT_YES = 'YES';
    const IS_SENT_NO = 'NO';

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

    public function generateResetLink(User $user)
    {
        $date = new DateTime();
        $date->modify('- ' . self::ALLOWED_GENERATION_INTERVAL . 'hours');
        $date = $date->format('Y-m-d H:i:s');

        $criteria = new CDbCriteria();
        $criteria->condition = "user_id = :userId and is_used = :isUsed and created_at >= :createdAt";
        $criteria->params = array(
            'userId' => $user->id,
            'isUsed' => self::IS_SENT_NO,
            'createdAt' => $date,
        );

        $requests = $this->findAll($criteria);

        if (count($requests) >= self::NUMBER_OF_ATTEMPTS) {
            return "You have exceeded the maximum number of password recovery attempts";
        }

        $now = new DateTime;

        $request = new self();
        $request->user_id = $user->id;
        $request->hash = md5($date . $user->id . $user->email . 'Some salt 9ht3ldjnhuy)jnt47thlJ&');
        $request->created_at = $now->format('Y-m-d H:i:s');

        $result = $request->save();

        if (!$result) {
            return "Service is temporary unavailable, please try again later";
        }

        // TODO send email with hash link
    }
}
