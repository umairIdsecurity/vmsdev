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
            array('image','file',
                'types'=>'jpg, gif, png, jpeg',
                'maxSize'=>1024 * 1024 * 2,
                'tooLarge'=>'File has to be smaller than 50MB'
            )

        );


    }


}