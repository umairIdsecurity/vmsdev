
<div class="page-content">
    
    <div id="menu">
        <div class="row items">
            <div class="col-xs-4 text-center"><a href="<?php echo Yii::app()->createUrl('preregistration/dashboard'); ?>"><span class="glyphicon glyphicon-home"></span></a></div>
            <div class="col-xs-4 text-center"><a href="<?php echo Yii::app()->createUrl('preregistration/visitHistory'); ?>">Visit History</a></div>
        </div>
    </div>

    <br><br>
    
    <div class="row">
        <div class="col-lg-8">

    <table class="table table-striped" border="0">
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
        	<?php foreach($query1 as $q){ ?>
        			<tr class="status-">
        				<td><?php echo date("j-n-Y",strtotime($q['date_in'])); ?></td>
		                <td><?php echo $q['first_name']." ".$q['last_name']; ?></td>
		                <td><?php echo $q['name']; ?></td>
		                <td><?php echo date("j-n-Y",strtotime($q['date_out'])); ?></td>
		                <td><?php echo $q['status'] == "Pre-registered" ? "Preregistered":$q['status']; ?></td>
        			</tr>	
        	<?php } ?> 
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



