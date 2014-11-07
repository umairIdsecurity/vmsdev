<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/script-visitordetail-actions-cssmenu.js');
$session = new CHttpSession;
?><br>
<div id='actionsCssMenu'>

    <ul>
        <?php if ($model->date_check_in != '') { ?>
            <li class='has-sub' id="logvisitLi"><a href="#"><span class="icons log-current actionsLabel">Log Visit</span></a>
                <ul>
                    <li>
                        <table id="actionsVisitDetails">
                            <tr>
                                <td></td>
                                <td >

                                    <div id="logVisitDiv">
                                        <?php
                                        $this->renderPartial('logvisit', array('model' => $model,
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
        <?php } else { ?>
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
        <?php } ?>
    </ul>
</div>

<script>
    $(document).ready(function() {

        $("#logvisitLi a").click();
        $("#preregisterLi a").click();

    });

</script>