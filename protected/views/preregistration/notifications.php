
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
				    Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
				    ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
				    amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
				    odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
			    </p>
		  	</div>
		  	<h3>20 Day Visit Count Limit </h3>
			<div>
				<p>
			    	Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet
			    	purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor
			    	velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In
			    	suscipit faucibus urna.
		    	</p>
			</div>
		  	<h3>28 Day Visit Count Limit</h3>
		  	<div>
		   		<p>
		    		Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis.
		    		Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero
		    		ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis
		    		lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui.
		    	</p>
		  	</div>
		  	<h3>ASIC Sponsor verified your visits</h3>
		  	<div>
		    	<p>
		    		Cras dictum. Pellentesque habitant morbi tristique senectus et netus
		    		et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in
		    		faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia
		    		mauris vel est.
		    	</p>
		    	<p>
		    		Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus.
		    		Class aptent taciti sociosqu ad litora torquent per conubia nostra, per
		    		inceptos himenaeos.
		    	</p>
		  	</div>

		  	<h3>Your Identification is about to expire</h3>
		  	<div>
		    	<p>
		    		Cras dictum. Pellentesque habitant morbi tristique senectus et netus
		    		et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in
		    		faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia
		    		mauris vel est.
		    	</p>
		    	<p>
		    		Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus.
		    		Class aptent taciti sociosqu ad litora torquent per conubia nostra, per
		    		inceptos himenaeos.
		    	</p>
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

	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <!-- <script src="//code.jquery.com/jquery-1.10.2.js"></script> -->
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
 
 <script>
  $(function() {
    $( "#accordion" ).accordion();
  });
  </script>

