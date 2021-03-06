<?php
$session = new CHttpSession;
$session['count'] = 1;
//date_default_timezone_set('Asia/Manila'); remove hard code
//$tenant = User::model()->findByPk($visitorModel->tenant);
$photoForm = $this->beginWidget('CActiveForm', [
    'id' => 'update-photo-form',
    'action' => Yii::app()->createUrl('/visitor/update&id=' . $model->visitor . '&view=1'),
    'htmlOptions' => ["name" => "update-visitor-form"],
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => [
        'validateOnSubmit' => true,
        'afterValidate' => 'js:function(form, data, hasError){
            sendPhoto();
        }'
    ],
]);
?>
<input type="text" value="<?php echo $visitorModel->photo; ?>" name="Visitor[photo]" id="Visitor_photo" class="photo_visitor_id">
<?php echo "<br>" . $photoForm->error($visitorModel, 'photo'); ?>
<input type="submit" id="submitBtnPhoto">
<?php $this->endWidget(); ?>

<div class="cardPhotoPreview" style="height:0px; margin-left: 15px;">
    <?php if ($visitorModel->photo != '') {
                $data = Photo::model()->returnVisitorPhotoRelativePath($model->visitor);
                $my_image = '';
                if(!empty($data['db_image'])){
                    $my_image = "data:image;base64," . $data['db_image'];
                }else{
                    $my_image = $data['relative_path'];
                }
        ?>
 
        <img id="photoPreview2" src="<?php echo $my_image; ?>" class="photo_visitor">
    <?php } else { ?>
        <img id="photoPreview2" src="" style="display:none; " class="photo_visitor">
    <?php } ?>
        
</div>
<?php
$vstr = Visitor::model()->findByPk($model->visitor);

?>

<?php
    $bgcolor = "";
    if($model->card_type > CardType::CONTRACTOR_VISITOR) {
        $bgcolor = CardGenerated::VIC_CARD_COLOR;
        $this->renderPartial("_card_detail",['bgcolor' => $bgcolor,'model' => $model,'visitorModel' => $visitorModel]);
    } else {
        $bgcolor = CardGenerated::CORPORATE_CARD_COLOR;
        $this->renderPartial("_card-corporate",['bgcolor' => $bgcolor,'model' => $model,'visitorModel' => $visitorModel]);
    }
?>

<div id="Visitor_photo_em"  style="display: none; margin-left: -20%; color:red;"><p>Please upload a profile image.</p></div>

<?php require_once(Yii::app()->basePath . '/draganddrop/index.php'); ?>


<?php if ($visitorModel->photo != '') : ?>
<input type="button" class="btn editImageBtn actionForward" id="editImageBtn" style="margin-bottom: 2px!important;" value="Edit Photo" onclick = "document.getElementById('light').style.display = 'block';
                document.getElementById('fade').style.display = 'block'"/>
<?php endif; ?>

<div style="display:<?php echo $session['role'] == Roles::ROLE_STAFFMEMBER ? 'none' : 'block'; ?>">
    <?php $cardDetail = CardGenerated::model()->findAllByAttributes(array('visitor_id' => $model->visitor)); ?>
</div>
<div style="clear: both;"></div>

<div class="dropdown" style="margin-left: 21px; text-align: left;">
<?php if (in_array($model->card_type, [CardType::SAME_DAY_VISITOR, CardType::MULTI_DAY_VISITOR, CardType::CONTRACTOR_VISITOR, cardType::MANUAL_VISITOR, CardType::VIC_CARD_SAMEDATE, CardType::VIC_CARD_24HOURS, CardType::VIC_CARD_EXTENDED, CardType::VIC_CARD_MULTIDAY]) && $model->visit_status ==VisitStatus::ACTIVE): ?>

    <button class="btn btn-info printCardBtn dropdown-toggle actionForward" style="width:205px !important; margin-top: 4px; margin-right: 0px; margin-left: 0px !important;" type="button" id="menu1" data-toggle="dropdown">Print Card
        <span class="caret pull-right"></span></button>
    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
	<?php if($model->card_type != CardType::VIC_CARD_24HOURS) :?>
        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo yii::app()->createAbsoluteUrl('cardGenerated/pdfprint', array('id' => $model->id, 'type' => 1)) ?>">Print On Standard Printer</a></li>
        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo yii::app()->createAbsoluteUrl('cardGenerated/pdfprint', array('id' => $model->id, 'type' => 2)) ?>">Print On Card Printer</a></li>
		<?php endif;?>
        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo yii::app()->createAbsoluteUrl('cardGenerated/pdfprint', array('id' => $model->id, 'type' => 3)) ?>">Bleed Through Label</a></li>
    </ul>
<?php elseif (in_array($model->card_type, [CardType::VIC_CARD_EXTENDED, CardType::VIC_CARD_24HOURS]) && $model->visit_status == VisitStatus::AUTOCLOSED): ?>
    <button class="btn btn-info printCardBtn dropdown-toggle actionForward" style="width:205px !important; margin-top: 4px; margin-right: 0px; margin-left: 0px !important;" type="button" id="menu1" data-toggle="dropdown">Print Card
        <span class="caret pull-right"></span></button>
        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
            <li role="presentation">
                <a role="menuitem" tabindex="-1" href="<?php echo yii::app()->createAbsoluteUrl('cardGenerated/pdfprint', array('id' => $model->id, 'type' => 2)) ?>">Reprint Card</a>
            </li>
        </ul>
<?php else: ?>
    <button class="btn btn-info printCardBtn dropdown-toggle actionForward" disabled="disabled" style="width:205px !important; margin-top: 4px; margin-right: 0px; margin-left: 0px !important;" type="button" id="menu1" data-toggle="dropdown">Print Card<span class="caret pull-right"></span>
    </button>
<?php endif; ?>
</div>
<?php if ($model->visit_status != VisitStatus::SAVED): ?>
<div style="margin-top: 10px;margin-right: 69px;">
<?php
    $totalCompanyVisit = $visitCount['allVisitsByVisitor'];
    $remainingDays = max(0,(28-$totalCompanyVisit))
?>
    Total Visits : <?php echo $totalCompanyVisit; ?>
  <?php
        /**
         * EVIC only, ASIC_Pending(during Auto-closed), Show reset option if this is not the first time.
         * The Auto Closed script actually reset it first time.
         */
  if($visitorModel->visitor_card_status == Visitor::VIC_ASIC_PENDING && $totalCompanyVisit >= 28 &&
                $model->card_type == CardType::VIC_CARD_EXTENDED && !is_null($model->parent_id)):   
    ?>
    <span class="glyphicon glyphicons-refresh" style="margin-left:8px" onclick="resetVisitCount('<?php echo $model->id; ?>');"> </span>
    <?php endif;?>

    </br>
    <!-- Total Visits to All Companies: <?php // echo $visitCount['allVisitsByVisitor'];           ?> -->
    <?php  if ($model->card_type > 4) { ?>
        Remaining Days: <?php echo $remainingDays; ?>
    <?php  } ?>
</div>
<input type="hidden" id="dummycardvalue" value="<?php echo $model->card; ?>"/>
<input type="hidden" id="remaining_day" value="<?php echo $remainingDays; ?>">
<?php endif; ?>

<?php
    $detailForm = $this->beginWidget('EActiveForm', array(
        'id'          => 'update-visitor-detail-form',
        'htmlOptions' => array('name' => 'update-visitor-detail-form'),
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'readOnly'  => in_array($model->visit_status,[VisitStatus::CLOSED,VisitStatus::AUTOCLOSED]),
        'clientOptions'          => array(
            'validateOnSubmit' => false,
            'afterValidate'    => 'js:function(form, data, hasError){
                return afterValidate(form, data, hasError);
            }'
        )
    ));
?>
    <div style="margin: 10px 0px 0px 19px; text-align: left;">
    <?php
        //if ($asic) {
            if($visitorModel->profile_type ==  Visitor::PROFILE_TYPE_VIC) {
                $profileType = Visitor::PROFILE_TYPE_VIC;

            } elseif($visitorModel->profile_type ==  Visitor::PROFILE_TYPE_ASIC) {
                $profileType = Visitor::PROFILE_TYPE_ASIC;
            }
            elseif($visitorModel->profile_type ==  Visitor::PROFILE_TYPE_CORPORATE) {
                $profileType = Visitor::PROFILE_TYPE_CORPORATE;
            }
            //because of CAVMS- 1180
            $statuses = '';
            if((Yii::app()->user->role == Roles::ROLE_AIRPORT_OPERATOR)||(Yii::app()->user->role == Roles::ROLE_AGENT_AIRPORT_OPERATOR)){
                $statuses = Visitor::$VISITOR_CARD_TYPE_LIST_OPERATOR[$profileType]; 
            }else{ 
                $statuses = Visitor::$VISITOR_CARD_TYPE_LIST[$profileType]; 
            }

            if( count(Visitor::$VISITOR_CARD_TYPE_LIST[$profileType]) )
            echo $detailForm->dropDownList($visitorModel, 'visitor_card_status',$statuses, ['empty' => 'Select Card Status']);
                echo "<br />";
        //}

        $workstationList = CHtml::listData(Utils::populateWorkstation(), 'id', 'name');
        if (!empty($workstationList)) {
            foreach ($workstationList as $key => $item) {
                $workstationResults[$key] = 'Workstation: ' . $item;
            }
        } else {
            $workstationResults = [];
        }
        echo $detailForm->dropDownList($model, 'workstation', $workstationResults, ['empty' => 'Select Workstation']);
        echo "<span class='required'> *</span>";
        // echo $detailForm->error($model, 'workstation');
        echo '<div id="Visit_workstation_em_" class="errorMessage" style="display: none">Please select a workstation</div>';

        // if ($asic) {
            //$visitor_types = VisitorType::model()->returnVisitorTypes();
           // if(is_array($visitor_types)) {
               $visitor_types = VisitorType::model()->getCardTypeVisitorTypes($model->card_type);
               if($visitor_types) {
                    echo $detailForm->dropDownList($model, 'visitor_type', CHtml::listData($visitor_types, 'id', 'name'), array("empty"=>"Select Visitor Type"));
                    echo "<span class='required'>*</span>";
               }
                //echo $detailForm->error($model, 'visitor_type');
                echo '<div id="Visit_visitor_type_em_" class="errorMessage" style="display: none">Please select a Visitor type</div>';
            //}
            
            $condition = $model->card_type > 4 ? "module='AVMS'": "module='CVMS'";
			$re=VisitReason::model()->findAll($condition);
            $reasons = CHtml::listData(VisitReason::model()->findAll($condition), 'id', 'reason');
            if(($model->visit_reason != NULL)&&($model->visit_reason != ""))
            {
               //have to remember this because have to fix other reason 
                echo $detailForm->dropDownList($model, 'reason', $reasons, array('options' =>  array($model->reason=>array('selected'=>true)) ));
            }
            else
            {
                echo $detailForm->dropDownList($model, 'reason', $reasons, array("empty"=>"Select Visit Reason"), array('options' => array($model->reason=>array('selected'=>true)) ));
            }
            
            echo "<br />";
        //}
          ?> 
         <div style="display:none;" id="visit_reason_dropdown_error" class="errorMessage">Please Select Visit Reason</div>
        <?php
        $cardTypeOptions = [];
        if ($model->visit_status == VisitStatus::AUTOCLOSED) {
            $cardTypeOptions['disabled'] = 'disabled';
        }
        
        //$cardTypes = CHtml::listData(CardType::model()->findAll(), 'id', 'name');
        $cardTypes = array();
        if(isset($session['workstation']) && $session['workstation'] != ""){
            $workstationCards = Yii::app()->db->createCommand()
                    ->select("c.id,c.name") 
                    ->from("card_type c")
                    ->join("workstation_card_type wc","c.id=wc.card_type")
                    ->join("workstation w","w.id=wc.workstation")
                    ->where("w.id=".$session['workstation'])
                    ->queryAll();
            $cardTypes = CHtml::listData($workstationCards, 'id', 'name');
        }else{
            $cardTypes = CHtml::listData(CardType::model()->findAll(), 'id', 'name');
        }

        $cardTypeResults = array();
        if(!empty($cardTypes))
        {
            foreach ($cardTypes as $key => $item) 
            {
                $cardList = ($model->card_type > CardType::CONTRACTOR_VISITOR) ? CardType::$VIC_CARD_TYPE_LIST : CardType::$CORPORATE_CARD_TYPE_LIST;
                if($item == 'Multiday Visitor'){$item="MultiDay";}
                if($item == 'Same Day Visitor'){$item="Same Day";}
                if (in_array($key, $cardList)) 
                {
                    $cardTypeResults[$key] = 'Card Type: ' . $item;
                }
            }
        }
        else{
            $cardTypeResults[] = "No assigned Card Types";
        }    
        echo $detailForm->dropDownList($model, 'card_type', $cardTypeResults, $cardTypeOptions);
        echo '<br />';

    ?>
        <input type="hidden" name="updateVisitorDetailForm">
        <?php echo $detailForm->submitButton("Update",['name'=>"updateVisitorDetailForm", 'id'=>"updateVisitorDetailForm",'class'=>"greenBtn btnUpdateVisitorDetailForm actionForward"]) ?>
<!--        <button type="submit" name="updateVisitorDetailForm" id="updateVisitorDetailForm" class="greenBtn btnUpdateVisitorDetailForm actionForward">Update</button>-->
    </div>
<?php $this->endWidget(); ?>

<script>

 $(document).ready(function() {
		var visitStatus="<?php echo $model->visit_status; ?>"
		//alert("<?php echo VisitStatus::CLOSED; ?>");
        var cardType = "<?php echo $model->card_type; ?>";
        var dateIn =  $("#Visit_date_check_in_container");
        var dateOut =  $("#Visit_date_check_out_container");
        var boundControl =  dateIn?dateOut:dateIn;

        if((cardType == '<?php echo CardType::VIC_CARD_MULTIDAY; ?>') && (visitStatus!="<?php echo VisitStatus::ACTIVE; ?>" && visitStatus!="<?php echo VisitStatus::EXPIRED; ?>" && visitStatus!="<?php echo VisitStatus::CLOSED; ?>" ))
		{
			//alert(visitStatus);
        if(dateOut){
			var inn=dateIn.val().split("/");
			var out=dateOut.val().split("/");
			var selectedDate=new Date(out[2],out[1]-1, out[0]);
			var firstDate=new Date(inn[2],inn[1]-1, inn[0]);
			var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
			var diffDays = Math.round(Math.abs((firstDate.getTime() - selectedDate.getTime())/(oneDay)));
				if(cardType == '<?php echo CardType::VIC_CARD_MULTIDAY; ?>' && diffDays>3 && $("#Visitor_photo").val()=="" )
				{
					
					$("#registerNewVisit").prop("disabled",true);
					$("#Visitor_photo_em").show();
				}
				else
				{
					$("#registerNewVisit").prop("disabled",false);
					$("#Visitor_photo_em").hide();
				}
            dateOut.change(function(){
                var dateFormat = dateIn.datepicker('option','dateFormat');
                var dateOut =  $("#dateoutDiv #Visit_date_check_out_container");
                selectedDate = dateOut.datepicker('getDate');
                var cardDate = $.datepicker.formatDate('dd M y', selectedDate);
				firstDate = dateIn.datepicker('getDate');
				diffDays = Math.round(Math.abs((firstDate.getTime() - selectedDate.getTime())/(oneDay)));
				if(cardType == '<?php echo CardType::VIC_CARD_MULTIDAY; ?>' && diffDays>2 && $("#Visitor_photo").val()=="" )
				{
					//alert(diffDays);
					$("#registerNewVisit").prop("disabled",true);
					$("#Visitor_photo_em").show();
				}
				else
				{
					//alert('here');
					$("#registerNewVisit").prop("disabled",false);
					$("#Visitor_photo_em").hide();
				}
            });

        }
		$("#submitBtnPhoto").click(function(){
			if($("#Visitor_photo").val()!='')
			{
				//alert('here');
					$("#registerNewVisit").prop("disabled",false);
					$("#Visitor_photo_em").hide();
			}
		});
		}

    });




    $(document).ready(function () {
        $('#Visit_workstation').on('change',function(){
            var workstation = $('#Visit_workstation').val();
            if(!workstation || workstation == "") {
                $('#Visit_workstation_em_').show();
            } else {
                $('#Visit_workstation_em_').hide();
            }
        })
        $('#Visit_visitor_type').on('change',function(){
            var visitortype = $('#Visit_visitor_type').val();
            if(!visitortype || visitortype == "") {
                $('#Visit_visitor_type_em_').show();
            } else {
                $('#Visit_visitor_type_em_').hide();
            }
        })
        function checkWorkstation() {
            var workstation = $('#Visit_workstation').val();
            if(!workstation || workstation == "") {
                $('#Visit_workstation_em_').show();
                return false;
            } else {
                return true;
            }
        }
        function checkVisitorType(){
            return true;// no need to make it mandatory
            
            var visitortype = $('#Visit_visitor_type').val();
            if(!visitortype || visitortype == "") {
                $('#Visit_visitor_type_em_').show();
                return false;
            }else {
                return true;
            }
        }
         function checkCardStatus(){
             var currentCardStatus = "<?php echo $visitorModel->visitor_card_status; ?>";
             var currentVisitStatus = "<?php echo $model->visit_status ; ?>";
             if(currentVisitStatus == "<?php echo VisitStatus::ACTIVE; ?>") {
                 if ($('#Visitor_visitor_card_status').val() == '<?php echo Visitor::VIC_ASIC_PENDING?>') {
                     alert('Please close the active visits before changing the status to ASIC Pending.');
                     return false;
                 } else {
                     return true;
                 }
             } else {
                 return true;
             }
         }
        $('.btnUpdateVisitorDetailForm').on('click', function (e) {
            var checkWorkStation1 = checkWorkstation();
            var checkVisitorType1 = checkVisitorType();
            if(checkVisitorType1 == true && checkWorkStation1 == true) {
                var checkCardStatus1 = checkCardStatus();
                if(checkCardStatus1 == true){
                    $('#update-visitor-detail-form').submit();
                }else {
                    return false;
                }
            } else {
                return false;
            }
        });

        var currentCardStatus = $('#Visitor_visitor_card_status').val();
        if (currentCardStatus == 6) {
            $('#Visitor_visitor_card_status').attr("disabled", true);
        }
        <?php if ($asic) { ?>
            // remove Denied card status
            $("#visitor_card_status option[value='5']").remove();
        <?php } ?>

        if (<?php echo $model->visit_status; ?> == '1' && $("#dummycardvalue").val() == '' && '<?php echo $model->card; ?>' != '') { //1 is active
            $('#printCardBtn').disabled = false;

        }
        else if ('<?php echo $model->card; ?>' != '') {
            if (<?php echo $model->visit_status; ?> != '1') {
                $('#printCardBtn').disabled = true;
                $("#printCardBtn").addClass("disabledButton");
            }
        }
        if($('#photoCropPreview').imgAreaSelect) {
            $('#photoCropPreview').imgAreaSelect({
                handles: true,
                onSelectEnd: function (img, selection) {
                    $("#cropPhotoBtn").show();
                    $("#x1").val(selection.x1);
                    $("#x2").val(selection.x2);
                    $("#y1").val(selection.y1);
                    $("#y2").val(selection.y2);
                    $("#width").val(selection.width);
                    $("#height").val(selection.height);
                }
            });
        }
        $("#cropPhotoBtn").click(function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: "<?php echo Yii::app()->createUrl('visitor/AjaxCrop'); ?>",
                data: {
                    x1: $("#x1").val(),
                    x2: $("#x2").val(),
                    y1: $("#y1").val(),
                    y2: $("#y2").val(),
                    width: $("#width").val(),
                    height: $("#height").val(),
                    imageUrl: $('#photoCropPreview').attr('src').substring(1, $('#photoCropPreview').attr('src').length),
                    photoId: $('#Visitor_photo').val()
                },
                dataType: 'json',
                success: function (r) {
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo Yii::app()->createUrl('photo/GetPathOfCompanyLogo&id='); ?>" + $('#Visitor_photo').val(),
                        dataType: 'json',
                        success: function (r) {

                            $.each(r.data, function (index, value) {

                                /*document.getElementById('photoPreview2').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                document.getElementById('photoCropPreview').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;*/

                                //showing image from DB as saved in DB -- image is not present in folder

                                document.getElementById('photoPreview2').src = "data:image;base64,"+ value.db_image;
                                document.getElementById('photoCropPreview').src = "data:image;base64,"+ value.db_image;


                            });
                        }
                    });

                    $("#closeCropPhoto").click();
                    var ias = $('#photoCropPreview').imgAreaSelect({instance: true});
                    ias.cancelSelection();
                }
            });
        });

        $("#closeCropPhoto").click(function() {
            var ias = $('#photoCropPreview').imgAreaSelect({instance: true});
            ias.cancelSelection();
        });

        /*$(document).on('click', '.btnUpdateVisitorDetailForm', function(e) {
            e.preventDefault();
            var currentCardStatus = "<?php echo $visitorModel->visitor_card_status; ?>";
            var currentVisitStatus = "<?php echo $model->visit_status ; ?>"
            if(currentVisitStatus == "<?php echo VisitStatus::ACTIVE; ?>") {
                if (currentCardStatus == 2 && $('#Visitor_visitor_card_status').val() == 3) {
                    alert('Please close the active visits before changing the status to ASIC Pending.');
                    return false;
                }
            }
            var t = checkVistorCardStatusOfHost(<?php echo $model->host; ?>);
            (t == true) ? $('#workstationForm').submit() : alert('Exception r718 - Vistor Information');
        });*/
    });

    function uploadImage() {
        $("#image").click();
        return false;
    }

    function generateCard() {
        //change modal url to pass visit id
        var url = 'index.php?r=cardGenerated/print&id=<?php echo $model->id; ?>';
        window.open(url, '_blank');
    }

    function regenerateCard() {
        //change modal url to pass visit id
        var url = 'index.php?r=cardGenerated/reprint&id=<?php echo $model->id; ?>';
        window.open(url, '_blank');
    }

    function sendPhoto() {

        var form = $("#update-photo-form").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array('/visitor/update&id=' . $visitorModel->id . '&view=1')); ?>",
            data: form,
            success: function (data) {
                $("#photoPreview2").show();
            }
        });

    }

    $(document).ready(function () {
        //blink("#printCardBtn", -1, 1000);
    });
    function blink(elem, times, speed) {
        if (times > 0 || times < 0) {
            if ($(elem).hasClass("blink"))
                $(elem).removeClass("blink");
            else
                $(elem).addClass("blink");
        }

        clearTimeout(function () {
            blink(elem, times, speed);
        });

        if (times > 0 || times < 0) {
            setTimeout(function () {
                blink(elem, times, speed);
            }, speed);
            times -= .5;
        }
    }

    function populateVisitWorkstation(value) {
        $("#Visit_workstation").val(value.value);
    }
    /**
    * Reset EVIC visit count when it is 28

     * @param {type} visit_id
     * @returns {undefined}     */
    function resetVisitCount(visit_id) {
          $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("/visit/visitResetById&id=")); ?>"+visit_id,
            success: function (data) {
                 location.reload();
            }
        });
    }
</script>
<!--POP UP FOR CROP PHOTO -->
<?php
        $data = Photo::model()->returnVisitorPhotoRelativePath($model->visitor);
        $my_image = '';
        if(!empty($data['db_image'])){
            $my_image = "data:image;base64," . $data['db_image'];
        }else{
            $my_image = $data['relative_path'];
        }

 ?>

<div id="light" class="white_content">
    <img id="photoCropPreview" width="500px" height="500px" src="<?php echo $my_image; ?>">

</div>
<div id="fade" class="black_overlay">
    <div style="text-align:right;">
        <input type="button" class="btn btn-success" id="cropPhotoBtn" value="Crop" style="">
        <input type="button" id="closeCropPhoto" onclick="document.getElementById('light').style.display = 'none';
                document.getElementById('fade').style.display = 'none'" value="x" class="btn btn-danger">
    </div>
</div>

<input type="hidden" id="x1"/>
<input type="hidden" id="x2"/>
<input type="hidden" id="y1"/>
<input type="hidden" id="y2"/>
<input type="hidden" id="width"/>
<input type="hidden" id="height"/>

<input type="hidden" id="visitorOriginalValue" value="<?php echo $visitorModel->photo; ?>"/>

<style type="text/css">
#photoPreview2 {
    height: 206px !important;
    width: 152px !important;
}
</style>