<?php
$session = new CHttpSession;
//print_r($model);
//Yii::app()->end();
?>
<div class="modal hide fade" id="addCompanyContactModal" style="width: 700px;">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'add-company-contact-form',
        'htmlOptions' => array('style'=>'margin: 0px;'),
        'enableAjaxValidation'=>false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form, data, hasError){
                if (!hasError){ // no errors
                    sendCompanyContactForm();
                } else { // has error
                    return false;
                }
            }'
        ),

    )); ?>

    <div class="modal-header">
        <a data-dismiss="modal" class="close" id="dismissModal" >×</a>
        <h3 id="myModalLabel">Add Company </h3>
    </div>
    <div id="addCompanyContactModalBody" class="modal-body form">
        <p class="note">Fields with <span class="required"></span> are required.</p>
        <input type="hidden" value="<?php echo $tenant;?>" name="CompanyTenant"/>
        <input type="hidden" name="CompanySelectedId" value="" id="CompanySelectedId"/>
        <input type="hidden" name="typePostForm" value="company" id="typePostForm"/>
        <table>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td style="width:60px;" ><?php echo $form->labelEx($model,'companyName'); ?></td>
                            <td>
                                <?php echo $form->textField($model, 'companyName', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Company Name', 'class' => 'ui-autocomplete-input company-autocomplete', 'autocomplete' => 'on')); ?>
                                <?php echo "<br>" . $form->error($model, 'companyName'); ?>
                            </td>
                        </tr>

                        <tr class="hidden">
                            <td ><?php echo $form->labelEx($model,'companyType'); ?></td>
                            <td>
                                <?php echo $form->dropDownList($model, 'companyType', CHtml::listData(CompanyType::model()->findAll(), 'id', 'name'), array('prompt' => 'Select a company type', 'placeholder' => 'Company Type', 'disabled' => 'disabled', 'options' => array('3' => array('selected' => true)))); ?>
                                <?php echo "<br>" . $form->error($model, 'companyType');?>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="" rowspan="" headers="">
                                <a style="margin-left: 25px;" class="btn btn-default" href="javascript:void(0)" role="button" id="showCompanyContactFields">+</a>
                            </td>
                            <td style="width:200px; padding-left: 9px;">
                                Add Company Contact
                            </td>

                        </tr>
						<tr>
						<td	style=" padding-top: 20px; width:200px">
							<?php echo $form->checkBox($model,'asiccheck', array("style"=>'margin-left: 25px;')). " ". $form->labelEx($model,'asiccheck', array("style"=>'display: inline; font-style: italic;'));;?><br>
							<span id="errorcheck" style="color: red; font-style: italic; font-size: 13px;"></span>
							
						</td>
						
						
						</tr>
						
                        <tr class="company_contact_field hidden">
                            <td ><?php echo $form->labelEx($model,'firstName'); ?></td>
                            <td>
                                <?php echo $form->textField($model, 'firstName', array('size' => 50, 'maxlength' => 50,'placeholder'=>'First Name')); ?>
                                <?php echo "<br>" . $form->error($model, 'firstName'); ?>
                            </td>
                        </tr>
                        <tr class="company_contact_field hidden">
                            <td ><?php echo $form->labelEx($model,'lastName'); ?></td>
                            <td>
                                <?php echo $form->textField($model, 'lastName', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Last Name')); ?>
                                <?php echo "<br>" . $form->error($model, 'lastName'); ?>
                            </td>
                        </tr>

                        <tr class="company_contact_field hidden">
                            <td ><?php echo $form->labelEx($model,'email'); ?></td>
                            <td>
                                <?php echo $form->textField($model, 'email', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Email')); ?>
                                <?php echo "<br>" . $form->error($model, 'email'); ?>
                            </td>
                        </tr>

                        <tr class="company_contact_field hidden">
                            <td><?php echo $form->labelEx($model,'mobile'); ?></td>
                            <td>
                                <?php echo $form->textField($model, 'mobile', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Mobile Number')); ?>
                                <?php echo "<br>" . $form->error($model, 'mobile'); ?>
                            </td>
                        </tr>
                    </table> 
                </td>
            </tr>
        </table>


    </div>
    <div class="modal-footer">
        <button class="btn neutral" id="btnCloseModalAddCompanyContact" data-dismiss="modal" aria-hidden="true">Close</button>
        <button type="button" id="btnAddCompanyContact" class="btn complete">Save</button>
        <button type="submit" id="btnAddCompanyContactConfirm" class="hidden"></button>
    </div>
<?php $this->endWidget(); ?>
</div>

<?php
    $companyList = CHtml::listData(Visitor::model()->findAllCompanyByTenant($session['tenant']), 'id', 'name');
    $companyList = array_unique($companyList);
    $listsCom = implode('", "', $companyList);
?>

<script>
 $(document).ready(function () {
		 $("#AddCompanyContactForm_asiccheck").click(function(){
		
		if($('#AddCompanyContactForm_asiccheck')[0].checked ==true)
		{
			var fname=$("#register-host-form input[name='User[first_name]']").val();
			var lname=$("#register-host-form input[name='User[last_name]']").val();
			var email=$("#register-host-form input[name='User[email]']").val();
			var contact=$("#register-host-form input[name='User[contact_number]']").val();
			
			if(fname && lname && email && contact)
			{
			
			$('#AddCompanyContactForm_firstName').val(fname);
			$('#AddCompanyContactForm_lastName').val(lname);
			$('#AddCompanyContactForm_email').val(email);
			$('#AddCompanyContactForm_mobile').val(contact);
			$('#errorcheck').hide();
			$('#AddCompanyContactForm_asiccheck').change(function () {
			$("tr.company_contact_field").toggleClass("hidden");
			$("#add-company-contact-form .password-border").toggleClass("hidden");
			});
			}
			else
			{
				$('#errorcheck').html("Please fill the Asic details first")
				$('#AddCompanyContactForm_asiccheck')[0].checked =false;
			}
			
				
			//console.log(name);
		}
    });
 });
  $('.close').click(function(event){
 $('#errorcheck').hide();
 });
    function addCompanyContactForm(){
         
        return "#add-company-contact-form ";
    }
    $(function() {
        $(document).on('click', '#showCompanyContactFields', function(e) {
           $("tr.company_contact_field").toggleClass("hidden");
		   $('#errorcheck').hide();
			$("#AddCompanyContactForm_asiccheck").hide();
			$('#AddCompanyContactForm_firstName').val("");
			$('#AddCompanyContactForm_lastName').val("");
			$('#AddCompanyContactForm_email').val("");
			$('#AddCompanyContactForm_mobile').val("");
			$("label[for='AddCompanyContactForm_asiccheck']").hide();
            $("#add-company-contact-form .password-border").toggleClass("hidden");

        });

        $(document).on('click', '#btnAddCompanyContact', function(e) {
            e.preventDefault();	
            //$(addCompanyContactForm() + "tr.company_contact_field").removeClass('hidden');
			 $("tr.company_contact_field").removeClass('hidden');
            //$(addCompanyContactForm() + '.password-border').removeClass('hidden');
            var inputs = $(addCompanyContactForm())
                .not('input[type="hidden"]')
                .find('input[type="text"]');
            var flag = true;

            $.each(inputs, function(i, input) {
                if (input == '') {
                    flag = false;
                    return;
                }
            });

            if (flag == true) {
                $('#btnAddCompanyContactConfirm').click();
            }
        });
    });

    $(function() {
        var availableTags = ["<?php echo $listsCom; ?>"];
        $(".company-autocomplete").autocomplete({
            source: availableTags,
            select: function(event, ui) {
                event.preventDefault();
                $(".company-autocomplete").val(ui.item.label);
                $('#typePostForm').val('contact');
            }
        });
        $(".ui-front").css("z-index", 1051);
    });

    $(document).ready(function(){
        $("#AddCompanyContactForm_companyName").keypress(function(){
            $('#typePostForm').val('company');
        })
    });
function sendCompanyContactForm() 
    {
        var currentController = "<?php echo Yii::app()->controller->id; ?>";
        var currentAction = "<?php echo Yii::app()->controller->action->id; ?>";
		
        if($("#AddCompanyContactForm_companyType").attr("disabled") == "disabled" && $("#AddCompanyContactForm_companyType").val() != ""){
			if($('#AddCompanyContactForm_companyName').prop('disabled'))
		{
			$('#AddCompanyContactForm_companyName').prop({
        'disabled': false,
        'readonly': true
    });
		}
            var formInfo = $("#add-company-contact-form").serialize()+ "&AddCompanyContactForm%5BcompanyType%5D=" + $("#AddCompanyContactForm_companyType").val()+ $("#CompanySelectedId").val();
			//alert(JSON.stringify(formInfo));
			//die();
        } else {
            var formInfo = $("#add-company-contact-form").serialize();
        }
        $.ajax({
            type: "POST",
            url: "<?php echo $this->createUrl('company/addCompanyContact') ?>",
            dataType: "json",
            data: formInfo,
            success: function(data) 
            {
				//alert(data);
				
               $("#addCompanyContactModal").modal("hide");
                if (data.type == "contact") 
                {
                    //$("#visitorStaffRow").html(data.contactDropDown);
                     $("#Visitor_staff_id").append(data.contactDropDown).val(data.id);
                     $('#Visitor_staff_id').trigger('change');
					 //alert("contact");
                } 
                else 
                {
                    //update company dropdown:
                    if(currentController == "visit" && currentAction == "detail") {
						//alert("visit");
                         $("#AddAsicEscort_company").prepend($("<option>", {value:data.id, text: data.name}));
                      //  $("#AddAsicEscort_company").select2("val", data.id); // deprecated
                         $("#AddAsicEscort_company").val(data.id);
                         $("#asicSponsorModal").modal("show");
                         $('#asicSponsorModal').trigger('change');
                    } else if (currentController == "visitor"){
						//var Obj=JSON.parse(data);
						//alert(data.id);
                         $("#Visitor_company").prepend($("<option>", {value:data.id, text: data.name}));
                        // $("#Visitor_company").select2("val", data.id);
                         $("#Visitor_company").val(data.id);
                         $('#Visitor_company').trigger('change');
                         
                        $("#User_company").prepend($("<option>", {value:data.id, text: data.name}));
                        //$("#User_company").select2("val", data.id);
                        $("#User_company").val(data.id);
                        $('#User_company').trigger('change');
                    }
                }
                return false;
          
            },
			error: function(xhr,textStatus,errorThrown){
                console.log(xhr.responseText);
                console.log(textStatus);
                console.log(errorThrown);
			}
        }).fail(function( jqXHR, textStatus, errorThrown ) {
			console.warn(jqXHR.responseText);
			console.log(textStatus);
			console.log(errorThrown);
			$("#AddCompanyContactForm_companyName_em_").empty();
            $("#AddCompanyContactForm_companyName_em_").text("This company already exists. Please close and ‘select a company’ in drop down search");
            $("#AddCompanyContactForm_companyName_em_").show();
        });
    }
	 

</script>