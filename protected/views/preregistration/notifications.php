
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
			<h3>Your Preregistered Visits</h3>
		  	<div>
		    	<p>
		    		<?php if($notifications){
	    					foreach ($notifications as $key => $notification) {
	    						if($notification['subject'] == 'You have Preregistered a Visit'){
	    							echo $notification['message']."<br>";
	    						}
	    					}
		    		 ?>
		    		<?php }else{?>
		    			Sorry, no notifications found
		    		<?php } ?>
			    </p>
		  	</div>
		  	<h3>20 Day Visit Count Limit </h3>
			<div>
				<p>
			    	<?php if($notifications){
	    					foreach ($notifications as $key => $notification) {
	    						if($notification['subject'] == 'You have reached a Visit Count of 20 days'){
	    							echo $notification['message']."<br>";
	    						}
	    					}
		    		 ?>
		    		<?php }else{?>
		    			Sorry, no notifications found
		    		<?php } ?>
		    	</p>
			</div>
		  	<h3>28 Day Visit Count Limit</h3>
		  	<div>
		   		<p>
		    		<?php if($notifications){
	    					foreach ($notifications as $key => $notification) {
	    						if($notification['subject'] == 'You have reached your 28 Day Visit Count Limit'){
	    							echo $notification['message']."<br>";
	    						}
	    					}
		    		 ?>
		    		<?php }else{?>
		    			Sorry, no notifications found
		    		<?php } ?>
		    	</p>
		  	</div>
		  	<h3>ASIC Sponsor verified your visits</h3>
		  	<div>
		    	<p>
		    		<?php if($notifications){
	    					foreach ($notifications as $key => $notification) {
	    						if($notification['subject'] == 'ASIC Sponsor has verified your visit'){
	    							echo $notification['message']."<br>";
	    						}
	    					}
		    		 ?>
		    		<?php }else{?>
		    			Sorry, no notifications found
		    		<?php } ?>
		    	</p>
		    </div>

		  	<h3>Your Identification is about to expire</h3>
		  	<div>
		    	<p>
		    	<?php if($notifications){
    					foreach ($notifications as $key => $notification) {
    						if($notification['subject'] == 'Your Identification is about to expire'){
    							echo $notification['message']."<br>";
    						}
    					}
	    		 ?>
	    		<?php }else{?>
	    			Sorry, no notifications found
	    		<?php } ?>
		    	</p>
		  	</div>
		</div>
	<?php endif; ?>   

	<!-- *************************************************************************************************** -->
	<!-- *************************************************************************************************** -->

	<?php if(Yii::app()->user->account_type == "ASIC"): ?>
	   	<div id="accordion">
			<h3>VIC Holder requested ASIC Sponsor verification</h3>
		  	<div>
		    	<p>
		    		<?php if($notifications){
	    					foreach ($notifications as $key => $notification) {
	    						if($notification['subject'] == 'VIC Holder has requested ASIC Sponsor verification'){
	    							echo $notification['message']."<br>";
	    						}
	    					}
		    		 ?>
		    		<?php }else{?>
		    			Sorry, no notifications found
		    		<?php } ?>
			    </p>
		  	</div>
		  	<h3>ASIC Sponsor assigned you a VIC holder Verification</h3>
			<div>
				<p>
			    	<?php if($notifications){
	    					foreach ($notifications as $key => $notification) {
	    						if($notification['subject'] == 'ASIC Sponsor has assigned you a VIC holder Verification'){
	    							echo $notification['message']."<br>";
	    						}
	    					}
		    		 ?>
		    		<?php }else{?>
		    			Sorry, no notifications found
		    		<?php } ?>
		    	</p>
			</div>
		  	<h3>Your ASIC is about to Expire</h3>
		  	<div>
		   		<p>
		    		<?php if($notifications){
	    					foreach ($notifications as $key => $notification) {
	    						if($notification['subject'] == 'Your ASIC is about to Expire'){
	    							echo $notification['message']."<br>";
	    						}
	    					}
		    		 ?>
		    		<?php }else{?>
		    			Sorry, no notifications found
		    		<?php } ?>
		    	</p>
		  	</div>
		</div>
	<?php endif; ?>   

	<!-- *************************************************************************************************** -->
	<!-- *************************************************************************************************** -->

	<?php if(Yii::app()->user->account_type == "CORPORATE"): ?>
	    <div id="accordion">
			<h3>VIC Holder in your company preregistered a Visit</h3>
		  	<div>
		    	<p>
		    		<?php if($notifications){
	    					foreach ($notifications as $key => $notification) {
	    						if($notification['subject'] == 'VIC Holder in your company has Preregistered a Visit'){
	    							echo $notification['message']."<br>";
	    						}
	    					}
		    		 ?>
		    		<?php }else{?>
		    			Sorry, no notifications found
		    		<?php } ?>
			    </p>
		  	</div>
		  	<h3>VIC Holder in your company reached their 20 day visit count</h3>
			<div>
				<p>
			    	<?php if($notifications){
	    					foreach ($notifications as $key => $notification) {
	    						if($notification['subject'] == 'VIC Holder in your company has reached their 20 day visit count'){
	    							echo $notification['message']."<br>";
	    						}
	    					}
		    		 ?>
		    		<?php }else{?>
		    			Sorry, no notifications found
		    		<?php } ?>
		    	</p>
			</div>
		  	<h3>VIC Holder in your company reached their 28 day limit</h3>
		  	<div>
		   		<p>
		    		<?php if($notifications){
	    					foreach ($notifications as $key => $notification) {
	    						if($notification['subject'] == 'VIC Holder in your company has reached their 28 day limit'){
	    							echo $notification['message']."<br>";
	    						}
	    					}
		    		 ?>
		    		<?php }else{?>
		    			Sorry, no notifications found
		    		<?php } ?>
		    	</p>
		  	</div>
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

