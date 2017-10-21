<?php

//namespace backend\models;
use yii\base\Model;

/**
 * This model represents one piece of Induction Record
 *
 * This model consists of model InductionTitle and model InductionRecord
 * @property piece_of_induction_record_id
 * @property piece_of_induction_name_id
 * @property piece_of_induction_name
 * @property piece_of_induction_required
 * @property piece_of_induction_completed
 * @property piece_of_induction_expiry
 */
class Induction extends CFormModel{
	public $piece_of_induction_record_id;
	public $piece_of_induction_name_id;
	public $piece_of_induction_name;
	public $piece_of_induction_required;
	public $piece_of_induction_completed;
	public $induction_expiry;
}
