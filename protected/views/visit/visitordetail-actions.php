<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/script-visitordetail-actions-cssmenu.js');
$session = new CHttpSession;
?><br>
<div id='actionsCssMenu'>
    <?php if ($model->visit_status == VisitStatus::CLOSED) {?>
    <ul>
        <li>
    <a style="text-decoration: none; color:red !important;">Visit Status: Closed</a>
        </li>
    </ul>
    <?php } ?>
    <ul>
        <?php if ($model->visit_status == VisitStatus::ACTIVE && $session['role'] != Roles::ROLE_STAFFMEMBER) { ?>
            <li class='has-sub' id="closevisitLi"><a href="#"><span class="icons close-visit actionsLabel">Close Visit</span></a>
                <ul>
                    <li>
                        <table id="actionsVisitDetails">
                            <tr>
                                <td></td>
                                <td >

                                    <div id="closeVisitDiv">
                                        <?php
                                        $closeVisitForm = $this->beginWidget('CActiveForm', array(
                                            'id' => 'close-visit-form',
                                            'htmlOptions' => array("name" => "close-visit-form"),
                                            'enableAjaxValidation' => false,
                                            'enableClientValidation' => true,
                                            'clientOptions' => array(
                                                'validateOnSubmit' => true,
                                                'afterValidate' => 'js:function(form, data, hasError){
                                                if (!hasError){
                                                    sendCloseVisit("close-visit-form");
                                                }
                                                }'
                                            ),
                                        ));
                                        ?>
                                        <table class="detailsTable" style="font-size:12px;" id="logvisitTable">
                                            <tr>
                                                <td>Date Out</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input name="Visit[visit_status]" id="Visit_visit_status" type="text" value="<?php echo VisitStatus::CLOSED; ?>" style="display:none;">
                                                    <input name="Visit[time_out]" id="Visit_time_out" class="timeout" type="text" style="display:none;">
                                                    <input type="text" value="<?php echo date("Y-m-d"); ?>" id='Visit_date_out' name="Visit[date_out]" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Time Out</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select class="time visit_time_in_hours" id='Visit_time_in_hours' disabled style="width:70px;">
                                                        <?php for ($i = 1; $i <= 24; $i++): ?>
                                                            <option value="<?= $i; ?>"><?= date("H", strtotime("$i:00")); ?></option>
                                                        <?php endfor; ?>
                                                    </select> :
                                                    <select class='time visit_time_in_minutes'  id='Visit_time_in_minutes' disabled style="width:70px;">
                                                        <?php for ($i = 1; $i <= 60; $i++): ?>
                                                            <option value="<?= $i; ?>"><?php
                                                                if ($i > 0 && $i < 10) {
                                                                    echo '0' . $i;
                                                                } else {
                                                                    echo $i;
                                                                };
                                                                ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                        <?php echo $closeVisitForm->error($model, 'date_in'); ?>
                                        <input type='submit' value='Close'/>
                                        <?php $this->endWidget(); ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </li>
                </ul>

            </li>
        <?php }  else if ($model->visit_status == VisitStatus::PREREGISTERED && $session['role'] != Roles::ROLE_STAFFMEMBER){ ?>
            <li class='has-sub' id="preregisterLi"><a href="#"><span class="icons pre-visits actionsLabel">Preregister a Visit</span></a>
                <ul>
                    <li>

                        <table id="actionsVisitDetails">
                            <tr>
                                <td></td>
                                <td >

                                    <div id="logVisitDiv">
                                        <?php
                                        $this->renderPartial('preregisteravisit', array('model' => $model,
                                            'visitorModel' => $visitorModel,
                                            'hostModel' => $hostModel,
                                            'reasonModel' => $reasonModel,
                                        ));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </li>
                </ul>
            </li>
            <li class='has-sub' id="activateLi"><a href="#"><span class="icons pre-visits actionsLabel">Log a Visit</span></a>
                <ul>
                    <li>
                        <?php
                        $logform = $this->beginWidget('CActiveForm', array(
                            'id' => 'activate-a-visit-form',
                            'htmlOptions' => array("name" => "activate-a-visit-form"),
                            'enableAjaxValidation' => false,
                            'enableClientValidation' => true,
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                                'afterValidate' => 'js:function(form, data, hasError){
                                if (!hasError){
                                    
                                    sendActivateVisitForm("activate-a-visit-form");
                                }
                                }'
                            ),
                        ));
                        ?>
                        <table id="actionsVisitDetails">
                            <tr>
                                <td></td>
                                <td >

                                    <div id="logVisitDiv">
                                        <?php
                                        $this->renderPartial('activateavisit', array('model' => $model,
                                            'visitorModel' => $visitorModel,
                                            'hostModel' => $hostModel,
                                            'reasonModel' => $reasonModel,
                                        ));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <?php echo $logform->error($model, 'date_in'); ?>
                        <input type='submit' value='Activate'/>
                        <?php $this->endWidget(); ?>
                    </li>
                </ul>
            </li>

        <?php } ?>
    </ul>
</div>

<script>
    $(document).ready(function() {

        $("#logvisitLi a").click();
        $("#preregisterLi a").click();
        $("#activateLi a").click();

        $('#activate-a-visit-form').bind('submit', function() {
            $(this).find('#Visit_date_in').removeAttr('disabled');
        });
         display_ct();
       
    });
    
    function display_c() {
        var refresh = 1000; // Refresh rate in milli seconds
        mytime = setTimeout('display_ct()', refresh)
    }

    function display_ct() {

        var x = new Date();
        var currenttime = x.getHours() + ":" + x.getMinutes() + ":" + x.getSeconds();

        $(".visit_time_in_hours").val(x.getHours());
        $(".visit_time_in_minutes").val(x.getMinutes());
        $("#Visit_time_out").val(currenttime);
        tt = display_c();
    }



</script>
