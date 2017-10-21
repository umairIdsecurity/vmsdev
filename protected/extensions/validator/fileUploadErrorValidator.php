<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of fileUploadErrorValidator
 *
 * @author jmariani
 */
class fileUploadErrorValidator extends CValidator {

  public function clientValidateAttribute($object, $attribute) {
    switch($attribute)
	{
		case 'upload_1':
		return '
		if($("#RegistrationAsic_upload_1").val()!="") {
			        var fsize = $("#RegistrationAsic_upload_1")[0].files[0].size;
					var ftype = $("#RegistrationAsic_upload_1")[0].files[0].type;
					if(fsize>5242880)
					{
					messages.push(' . CJSON::encode("File Size More Than 5MB ").');
					}
					if((ftype!="image/jpeg" && ftype!="application/pdf" && ftype!="image/png" && ftype!="application/msword" && ftype!="application/vnd.openxmlformats-officedocument.wordprocessingml.document"))
					{
						messages.push(' . CJSON::encode("File type is not supported").');
					}
					
					}';
					
			
			break;
			case 'upload_2':
		return '
		if($("#RegistrationAsic_upload_2").val()!="") {
			        var fsize = $("#RegistrationAsic_upload_2")[0].files[0].size;
					var ftype = $("#RegistrationAsic_upload_2")[0].files[0].type;
					if(fsize>5242880)
					{
					messages.push(' . CJSON::encode("File Size More Than 5MB ").');
					}
					if((ftype!="image/jpeg" && ftype!="application/pdf" && ftype!="image/png" && ftype!="application/msword" && ftype!="application/vnd.openxmlformats-officedocument.wordprocessingml.document"))
					{
						messages.push(' . CJSON::encode("File type is not supported").');
					}
					
					}';
					
			
			break;
			case 'upload_2_1':
		return '
		if($("#RegistrationAsic_upload_2_1").val()!="") {
			        var fsize = $("#RegistrationAsic_upload_2_1")[0].files[0].size;
					var ftype = $("#RegistrationAsic_upload_2_1")[0].files[0].type;
					if(fsize>5242880)
					{
					messages.push(' .CJSON::encode("File Size More Than 5MB ").');
					}
					if((ftype!="image/jpeg" && ftype!="application/pdf" && ftype!="image/png" && ftype!="application/msword" && ftype!="application/vnd.openxmlformats-officedocument.wordprocessingml.document"))
					{
						
						messages.push(' . CJSON::encode("File type is not supported").');
					}
					
					}';
					
			
			break;
			case 'upload_3':
		return '
		if($("#RegistrationAsic_upload_3").val()!="") {
			        var fsize = $("#RegistrationAsic_upload_3")[0].files[0].size;
					var ftype = $("#RegistrationAsic_upload_3")[0].files[0].type;
					if(fsize>5242880)
					{
					messages.push(' . CJSON::encode("File Size More Than 5MB ").');
					}
					if((ftype!="image/jpeg" && ftype!="application/pdf" && ftype!="image/png" && ftype!="application/msword" && ftype!="application/vnd.openxmlformats-officedocument.wordprocessingml.document"))
					{
						messages.push(' . CJSON::encode("File type is not supported").');
					}
					
					}';
					
			
			break;
	}
  }

  /**
   * Validates the attribute of the object.
   * If there is any error, the error message is added to the object.
   * @param CModel $object the object being validated
   * @param string $attribute the attribute being validated
   */
  protected function validateAttribute($object, $attribute) {
    
  }

}

?>
