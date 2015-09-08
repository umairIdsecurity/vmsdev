<?php
class Declarationverification extends CFormModel{

    public $declaration1;
    public $declaration2;
    public $declaration3;
    public $declaration4;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(

            array('declaration1,declaration2,declaration3,declaration4', 'compare', 'compareValue' => true,
              'message' => 'Mark all Declarations to proceed'),

        );
    }
}