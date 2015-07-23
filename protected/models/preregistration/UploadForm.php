<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 7/22/15
 * Time: 4:29 PM
 */

class UploadForm extends CFormModel
{
    public $image;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            // name, email, subject and body are required
            //array('image', 'required'),
        );
    }


}