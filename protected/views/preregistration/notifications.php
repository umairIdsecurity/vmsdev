
<div class="page-content">
    
    <div id="menu">
        <div class="row items">
            <div class="col-xs-4 text-center"><a href="<?php echo Yii::app()->createUrl('preregistration/dashboard'); ?>"><span class="glyphicon glyphicon-home"></span></a></div>
            <div class="col-xs-4 text-center"><a href="<?php echo Yii::app()->createUrl('preregistration/notifications'); ?>">Notifications</a></div>
        </div>
    </div>

    <br><br>
    
    <?php if(Yii::app()->user->account_type == "VIC"): ?>
	    <div class="row items">
	    	<div class="col-lg-10">
	    		<table class="table table-striped">
					<thead>
						<tr>
							<th>Subject</th>
							<th>Message</th>
							<th>Date Created</th>
							<th>Notification Type</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php if($notifications):?>
							<?php foreach ($notifications as $key => $notification):?>	
								<tr>
									<td><?= $notification['subject'] ?></td>
									<td><?= $notification['message'] ?></td>
									<td><?= $notification['date_created'] ?></td>
									<td><?= $notification['notification_type'] ?></td>
									<td><a href="#" class="btn btn-danger">Delete</a></td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td></td>
								<td></td>
								<td>No notifications found</td>
								<td></td>
								<td></td>
							</tr>		
						<?php endif; ?>
					</tbody>
				</table>

	    	</div>
	    </div>
	<?php endif; ?>   

	<!-- *************************************************************************************************** -->
	<!-- *************************************************************************************************** -->

	<?php if(Yii::app()->user->account_type == "ASIC"): ?>
	    <div class="row">
	       
	    </div>
	<?php endif; ?>   

	<!-- *************************************************************************************************** -->
	<!-- *************************************************************************************************** -->

	<?php if(Yii::app()->user->account_type == "CORPORATE"): ?>
	    <div class="row">
	       
	    </div>
	<?php endif; ?>    

</div>



