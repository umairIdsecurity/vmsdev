
<div class="page-content">
    
    <div id="menu">
        <div class="row items" style="background-color:#fff;">
            <div class="col-sm-4 col-xs-6 text-center" style="background-color: #eeeeee; height:40px;border-right: 1px solid #fff;"><a href="<?php echo Yii::app()->createUrl('preregistration/dashboard'); ?>"><span class="glyphicon glyphicon-home"></span></a></div>
            <div class="col-sm-4 col-xs-6 text-center" style="background-color: #eeeeee; height:40px;"><a href="<?php echo Yii::app()->createUrl('preregistration/verifications'); ?>" class="tableFont">ASIC Sponsor Verifications</a></div>
        </div>
    </div>

    <br><br>
    
    <div class="row">
        <div class="col-lg-8">

            <table class="table table-striped tableFont" border="0">
                <thead>
                    <tr class="active">
                        <td><b>Date in</b></td>
                        <td><b>VIC Holder Name</b></td>
                        <td><b>ASIC Sponsor Name</b></td>
                        <td><b>Status</b></td>

                        <?php if(Yii::app()->user->account_type == "VIC"): ?>
                            <td><b>Resend Verification</b></td>
                        <?php endif; ?>    

                    </tr>
                </thead>
                <tbody>

                    <?php 
                        if($query1){
                            foreach($query1 as $q){ ?>
                                <tr class="status-">
                                    <?php if(Yii::app()->user->account_type ==  "ASIC"): ?>
                                        <td><a href="<?php echo Yii::app()->createUrl('preregistration/verifyVicholder?id=' . $q['id']); ?>"><?php echo date("j-n-Y",strtotime($q['date_check_in'])); ?></a></td>
                                    <?php else: ?>
                                        <td><?php echo date("j-n-Y",strtotime($q['date_check_in'])); ?></td>
                                    <?php endif; ?>
                                        
                                    <td><?php echo $q["first_name"]." ".$q["last_name"]; ?></td>
                                
                                    <td><?php echo returnAsicName($q['host']) == "" ? "- - - -": returnAsicName($q['host']); ?></td>
                                    

                                    <td><?php echo $q['visit_prereg_status']; ?></td>

                                    <?php if(Yii::app()->user->account_type == "VIC")
                                        {
                                            $asicModel = Registration::model()->findByPk($q['host']);
                                            $asicId = $asicModel->id;
                                            $visitId = $q['id'];
                                     ?>
                                        <td>
                                            <?php 
                                                    if($q['visit_prereg_status'] == 'Verified'){ 
                                                        echo "<a id='resendNotifiPlaceholder$visitId' onclick='resendNotification($asicId,$visitId)' href='javascript:;' class='btn btn-primary btn-next' disabled>Resend</a>";
                                                    }
                                                    else{
                                                        echo "<a id='resendNotifiPlaceholder$visitId' onclick='resendNotification($asicId,$visitId)' href='javascript:;' class='btn btn-primary btn-next'>Resend</a>";
                                                    }
                                            ?>
                                        </td>
                                    <?php } ?> 

                                </tr>   
                    <?php 
                            }
                        }
                        else
                        {
                            echo "<tr><td>No Result found</td><td></td><td></td><td></td></tr>";
                        }
                     ?> 
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5">
                            <div class="text-center">
                                <nav>
                            <?php
                                $this->widget('CLinkPager', array(
                                            'currentPage'=>$pages->getCurrentPage(),
                                            'itemCount'=>$item_count,
                                            'pageSize'=>$page_size,
                                            'maxButtonCount'=>5,
                                            'nextPageLabel'=>'»',
                                            'prevPageLabel'=>'&laquo;',
                                            'header'=>'',
                                            'htmlOptions'=>array('class'=>'pagination'),
                                            'pages'=>$pages,
                                        ));
                            ?>
                                </nav>
                            </div>

                        </td>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>

</div>

<?php
    function returnAsicName($hostId){
        if($hostId){
            $rawData = Yii::app()->db->createCommand()
                ->select("v.first_name,v.last_name") 
                ->from("visitor v")
                ->where("v.is_deleted = 0 AND v.id=".$hostId)
                ->queryRow();
            $data =  $rawData["first_name"]." ".$rawData["last_name"];               
            return $data;  
        }
              
    }
?>

<script type="text/javascript">
    function resendNotification(asicId,visitId){
        if(asicId != "" && visitId != "")
        {
            $.ajax({
                type: 'POST',
                //url: '<?php echo Yii::app()->createUrl("preregistration/createAsicNotificationRequestedVerifications?asicId=' + asicId + '&visitId=' + visitId +'"); ?>',
                url: '<?php echo Yii::app()->getBaseUrl(true)."/index.php/preregistration/createAsicNotificationRequestedVerifications?asicId=' + asicId + '&visitId=' + visitId +'";?>',
                data: {},
                success: function (response) {
                    $("#resendNotifiPlaceholder"+visitId).attr("disabled","disabled").text("Sent");
                    setInterval(function(){ 
                        $("#resendNotifiPlaceholder"+visitId).removeAttr("disabled").text("Resend");
                    }, 5000);
                },
                error: function(error){
                    console.log(error);
                }
            });
        }
    }

</script>