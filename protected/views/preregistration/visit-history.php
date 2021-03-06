
<div class="page-content">
    
    <div id="menu">
        <div class="row items" style="background-color:#fff;">
            <div class="col-sm-4 col-xs-6 text-center" style="background-color: #eeeeee; height:40px;border-right: 1px solid #fff;"><a href="<?php echo Yii::app()->createUrl('preregistration/dashboard'); ?>"><span class="glyphicon glyphicon-home"></span></a></div>
            <div class="col-sm-4 col-xs-6 text-center" style="background-color: #eeeeee; height:40px;"><a href="<?php echo Yii::app()->createUrl('preregistration/visitHistory'); ?>">Visit History</a></div>
        </div>
    </div>

    <br><br>
    
    <div class="row">
        <div class="col-sm-8">
            <table class="table table-striped tableFont" border="0">
                <thead>
                    <tr class="active">
                        <td><b>Date in</b></td>
                        <td><b>Name</b></td>
                        <td><b>Company</b></td>
                        <td><b>Date out</b></td>
                        <td><b>Status</b></td>
                    </tr>
                </thead>
                <tbody>
                	<?php 
                        if($query1){
                            foreach($query1 as $q){ ?>
                    			<tr class="status-">
                    				<td><?php echo (($q['date_check_in'] == NULL) || ($q['date_check_in'] == "")) ?  "- - - -" : date("j-n-Y",strtotime($q['date_check_in'])); ?></td>
            		                <td><?php echo $q['first_name']." ".$q['last_name']; ?></td>
            		                <td><?php echo returnCompanyName($q['company']) == "" ? "- - - -": returnCompanyName($q['company']); ?></td>
            		                <td><?php echo (($q['date_check_out'] == NULL) || ($q['date_check_out'] == "")) ?  "- - - -" : date("j-n-Y",strtotime($q['date_check_out'])); ?></td>
                                    <td><?php echo $q['status'] == "Pre-registered" ? "Preregistered":$q['status']; ?></td>
                    			</tr>	
                	<?php 
                            }
                        }
                        else
                        {
                            echo "<tr><td>No Result found</td><td></td><td></td><td></td><td></td></tr>";
                        }
                     ?>  
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5">
                            <!-- <div class="summary"> Display 1-11 of 20 results</div>
                            <div class="text-center">
                                <nav>
                                    <ul class="pagination">
                                        <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                        <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                                    </ul>
                                </nav>
                            </div> -->
                            <!-- <div class="summary"> Display 1-<?php //echo $page_size ?> of <?php //echo $item_count ?> results</div> -->
                            <div class="text-center">
                            	<nav>
                            <?php
                            // the pagination widget with some options to mess
                            
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
    function returnCompanyName($compId){
        if($compId){
            $rawData = Yii::app()->db->createCommand()
                ->select("c.name") 
                ->from("company c")
                ->where("c.is_deleted = 0 AND c.id=".$compId)
                ->queryRow();
            $data =  $rawData["name"];               
            return $data;  
        }
              
    }
?>
