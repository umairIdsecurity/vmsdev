
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
                                    <td><?php echo returnAsicName($q['host']); ?></td>
                                    <td><?php echo $q['visit_prereg_status']; ?></td>
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

