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
            array('image', 'file',
                'maxSize'=>1024 * 1024 * 2, // 2 MB
                'types'=>'jpg, gif, png',
                'allowEmpty'=>false,
            )

        );


    }


}