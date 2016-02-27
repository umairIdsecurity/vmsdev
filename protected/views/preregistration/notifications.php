<div class="page-content">
    
    <div id="menu">
        <div class="row items">
            <div class="col-xs-4 text-center"><a href="<?php echo Yii::app()->createUrl('preregistration/dashboard'); ?>"><span class="glyphicon glyphicon-home"></span></a></div>
            <div class="col-xs-4 text-center"><a href="<?php echo Yii::app()->createUrl('preregistration/notifications'); ?>">Notifications</a></div>
        </div>
    </div>

    <br><br>
    
    <?php if(Yii::app()->user->account_type == "VIC"): ?>
    	<div id="accordion">

			<?php if(!empty($notifications[0])):?>
				<h3>Your Preregistered Visits</h3>
			  	<div>
			    	<p>
			    		<?php 
			    			foreach ($notifications[0] as $key => $notification) { ?>
			    				<?= $notification['message'] ?><br>
		    			<?php
		    				}	 
			    		?>
				    </p>
			  	</div>
		  	<?php endif; ?>
		  	
		  	<?php if(!empty($notifications[1])):?>
			  	<h3>20 Day Visit Count Limit </h3>
				<div>
					<p>
			    		<?php 
			    			foreach ($notifications[1] as $key => $notification) {
		    					echo $notification['message']."<br>";
		    				}	 
			    		?>
				    </p>
				</div>
			<?php endif; ?>

			<?php if(!empty($notifications[2])):?>
			  	<h3>28 Day Visit Count Limit</h3>
			  	<div>
			   		<p>
			    		<?php 
			    			foreach ($notifications[2] as $key => $notification) {
		    					echo $notification['message']."<br>";
		    				}	 
			    		?>
				    </p>
			  	</div>
			<?php endif; ?>
			
			<?php if(!empty($notifications[3])):?>
			  	<h3>ASIC Sponsor verified your visits</h3>
			  	<div>
			    	<p>
			    		<?php 
			    			foreach ($notifications[3] as $key => $notification) { ?>
			    				<?= $notification['message'] ?> <br>
		    			<?php
		    				}	 
			    		?>
				    </p>
			    </div>
		    <?php endif; ?>

		    <?php if(!empty($notifications[4])):?>
			    <h3>ASIC Sponsor rejected your visits</h3>
			  	<div>
			    	<p>
			    		<?php 
			    			foreach ($notifications[4] as $key => $notification) { ?>
			    				<?= $notification['message'] ?><br>
		    			<?php
		    				}	 
			    		?>
				    </p>
			    </div>
		    <?php endif; ?>

		    <?php if(!empty($notifications[5])):?>
			  	<h3>Your Identification is about to expire</h3>
			  	<div>
			    	<p>
			    		<?php 
			    			foreach ($notifications[5] as $key => $notification) { ?>
			    				<a class="title" href="<?php echo Yii::app()->createUrl('preregistration/profile?id=' . Yii::app()->user->id); ?>"><?= $notification['message'] ?></a> <br>
		    			<?php
		    				}	 
			    		?>
				    </p>
			  	</div>
		  	<?php endif; ?>

		</div>
	<?php endif; ?>   

	<!-- *************************************************************************************************** -->
	<!-- *************************************************************************************************** -->

	<?php if(Yii::app()->user->account_type == "ASIC"): ?>
	   	<div id="accordion">

	   		<?php if(!empty($notifications[0])):?>
				<h3>VIC Holder requested ASIC Sponsor verification</h3>
			  	<div>
			    	<p>
			    		<?php 
			    			foreach ($notifications[0] as $key => $notification) {
			    				if($notification['verify_visit_id']) {?>
			    					<a class="title" href="<?php echo Yii::app()->createUrl('preregistration/verifyVicholder?id=' . $notification['verify_visit_id']); ?>"><?= $notification['message'] ?></a> <br>
			    				<?php }else{?>
			    					<a class="title" href="<?php echo Yii::app()->createUrl('preregistration/verifications'); ?>"><?= $notification['message'] ?></a> <br>
			    				<?php } ?>
			    				
		    			<?php
		    				}	 
			    		?>
				    </p>
			  	</div>
		  	<?php endif; ?>

		  	<?php if(!empty($notifications[1])):?>
			  	<h3>ASIC Sponsor assigned you a VIC holder Verification</h3>
				<div>
					<p>
			    		<?php 
			    			foreach ($notifications[1] as $key => $notification) {
			    				if($notification['verify_visit_id']) {?>
			    					<a class="title" href="<?php echo Yii::app()->createUrl('preregistration/verifyVicholder?id=' . $notification['verify_visit_id']); ?>"><?= $notification['message'] ?></a> <br>
			    				<?php }else{?>
			    					<a class="title" href="<?php echo Yii::app()->createUrl('preregistration/verifications'); ?>"><?= $notification['message'] ?></a> <br>
			    				<?php } ?>
			    				
		    			<?php
		    				}	 
			    		?>
				    </p>
				</div>
			<?php endif; ?>

			<?php if(!empty($notifications[2])):?>
			  	<h3>Your ASIC is about to Expire</h3>
			  	<div>
			   		<p>
			    		<?php 
			    			foreach ($notifications[2] as $key => $notification) { ?>
			    				<a class="title" href="<?php echo Yii::app()->createUrl('preregistration/profile?id=' . Yii::app()->user->id); ?>"><?= $notification['message'] ?></a> <br>
		    			<?php
		    				}	 
			    		?>
				    </p>
			  	</div>
		  	<?php endif; ?>

		</div>
	<?php endif; ?>   

	<!-- *************************************************************************************************** -->
	<!-- *************************************************************************************************** -->

	<?php if(Yii::app()->user->account_type == "CORPORATE"): ?>
	    <div id="accordion">

	    	<?php if(!empty($notifications[0])):?>
				<h3>VIC Holder in your company preregistered a Visit</h3>
			  	<div>
			    	<p>
			    		<?php 
			    			foreach ($notifications[0] as $key => $notification) { ?>
			    				<?= $notification['message'] ?><br>
		    			<?php
		    				}	 
			    		?>
				    </p>
			  	</div>
			<?php endif; ?>

			<?php if(!empty($notifications[1])):?>
			  	<h3>VIC Holder in your company reached their 20 day visit count</h3>
				<div>
					<p>
			    		<?php 
			    			foreach ($notifications[1] as $key => $notification) {
		    					echo $notification['message']."<br>";
		    				}	 
			    		?>
				    </p>
				</div>
			<?php endif; ?>

			<?php if(!empty($notifications[2])):?>
			  	<h3>VIC Holder in your company reached their 28 day limit</h3>
			  	<div>
			   		<p>
			    		<?php 
			    			foreach ($notifications[2] as $key => $notification) {
		    					echo $notification['message']."<br>";
		    				}	 
			    		?>
				    </p>
			  	</div>
		  	<?php endif; ?>

		</div>
	<?php endif; ?>    

</div>

	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <!-- <script src="//code.jquery.com/jquery-1.10.2.js"></script> -->
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
 
 <script>
  $(function() {
    $( "#accordion" ).accordion();
  });
  </script>

