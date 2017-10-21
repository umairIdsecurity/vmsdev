
<?php

if($user->email_notification!=null || $user->email_notification!='0')
	$checkValue=$user->email_notification;
else
	$checkValue=0;

?>

        <div class="flash-success" style="display:none">
               
        </div>

 <div id="Notification" style="display:inline-flex;">
 <h1>Manage Notifications</h1>
<input style="margin-left:25px; margin-top:14px;" type="checkbox" id="CheckEmailNotifications" name="emailnotification" value="<?php echo $checkValue; ?>"><label style="margin-top:10px;"> Send notifications to email</label> 
</div>
<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'notification-grid',
	'dataProvider'=>$model->indexSearch(),
	'filter'=>$model,
	'columns'=>array(
		/* 'id', */
		'subject',
		/* 'message', */
                'date_created',
                'notification_type',
		/*'created_by',
		 
		'role_id',
		 'notification_type',
		*/
             array(
                'header' => 'Actions',
                'class' => 'CButtonColumn',
                'template' => '{view} {delete}',
                'deleteButtonUrl' => 'Yii::app()->createUrl("notifications/indexDelete", array("id"=>$data->id))',
                'buttons' => array(                  
                    'view' => array(//the name {reply} must be same
                        'label' => 'view', // text label of the button
                        'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                    ),
                    'delete' => array(//the name {reply} must be same
                        'label' => 'Delete', // text label of the button
                        'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                    ),
                     
                ),
            ),
		 
	),
)); ?>
<script>
$(document).ready(function(){
	$('.flash-success').hide();
	if($('#CheckEmailNotifications').val()=='0' || $('#CheckEmailNotifications').val()=="" )
		$('#CheckEmailNotifications').prop('checked', false);	
	else
		$('#CheckEmailNotifications').prop('checked', true); 
	
    $('#CheckEmailNotifications').click(function(){
		if($('#CheckEmailNotifications').val()=='0' || $('#CheckEmailNotifications').val()=="" )
		{
			var checkValue='1';
		}
		else
		{
			var checkValue='0';
		}
		//alert(checkValue);
            var url = "<?php echo Yii::app()->createUrl('notifications/emailNotification'); ?>";
            $.ajax({
                url: url,
                type: 'POST',
                data:"checkvalue="+checkValue,
                success: function(data) {
                    var successmsg= "Notification preference changed";
					$('.flash-success').show();
					$('.flash-success').html(successmsg);
					$('.flash-success').animate({opacity: 1.0}, 5000).fadeOut("slow");
					
                },
                error: function(xhr,textStatus,errorThrown){
                console.log(xhr.responseText);
                console.log(textStatus);
                console.log(errorThrown);
            }
            });
    });
});


</script>