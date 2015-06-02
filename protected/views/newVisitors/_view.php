<?php
/* @var $this NewVisitorsController */
/* @var $data NewVisitors */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('first_name')); ?>:</b>
	<?php echo CHtml::encode($data->first_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('middle_name')); ?>:</b>
	<?php echo CHtml::encode($data->middle_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_name')); ?>:</b>
	<?php echo CHtml::encode($data->last_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_number')); ?>:</b>
	<?php echo CHtml::encode($data->contact_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_of_birth')); ?>:</b>
	<?php echo CHtml::encode($data->date_of_birth); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('company')); ?>:</b>
	<?php echo CHtml::encode($data->company); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('department')); ?>:</b>
	<?php echo CHtml::encode($data->department); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('position')); ?>:</b>
	<?php echo CHtml::encode($data->position); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('staff_id')); ?>:</b>
	<?php echo CHtml::encode($data->staff_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notes')); ?>:</b>
	<?php echo CHtml::encode($data->notes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('role')); ?>:</b>
	<?php echo CHtml::encode($data->role); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('visitor_type')); ?>:</b>
	<?php echo CHtml::encode($data->visitor_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('visitor_status')); ?>:</b>
	<?php echo CHtml::encode($data->visitor_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vehicle')); ?>:</b>
	<?php echo CHtml::encode($data->vehicle); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('photo')); ?>:</b>
	<?php echo CHtml::encode($data->photo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_deleted')); ?>:</b>
	<?php echo CHtml::encode($data->is_deleted); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tenant')); ?>:</b>
	<?php echo CHtml::encode($data->tenant); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tenant_agent')); ?>:</b>
	<?php echo CHtml::encode($data->tenant_agent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('visitor_card_status')); ?>:</b>
	<?php echo CHtml::encode($data->visitor_card_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('visitor_workstation')); ?>:</b>
	<?php echo CHtml::encode($data->visitor_workstation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('profile_type')); ?>:</b>
	<?php echo CHtml::encode($data->profile_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('identification_type')); ?>:</b>
	<?php echo CHtml::encode($data->identification_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('identification_country_issued')); ?>:</b>
	<?php echo CHtml::encode($data->identification_country_issued); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('identification_document_no')); ?>:</b>
	<?php echo CHtml::encode($data->identification_document_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('identification_document_expiry')); ?>:</b>
	<?php echo CHtml::encode($data->identification_document_expiry); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('identification_alternate_document_name1')); ?>:</b>
	<?php echo CHtml::encode($data->identification_alternate_document_name1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('identification_alternate_document_no1')); ?>:</b>
	<?php echo CHtml::encode($data->identification_alternate_document_no1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('identification_alternate_document_expiry1')); ?>:</b>
	<?php echo CHtml::encode($data->identification_alternate_document_expiry1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('identification_alternate_document_name2')); ?>:</b>
	<?php echo CHtml::encode($data->identification_alternate_document_name2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('identification_alternate_document_no2')); ?>:</b>
	<?php echo CHtml::encode($data->identification_alternate_document_no2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('identification_alternate_document_expiry2')); ?>:</b>
	<?php echo CHtml::encode($data->identification_alternate_document_expiry2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_unit')); ?>:</b>
	<?php echo CHtml::encode($data->contact_unit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_street_no')); ?>:</b>
	<?php echo CHtml::encode($data->contact_street_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_street_name')); ?>:</b>
	<?php echo CHtml::encode($data->contact_street_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_street_type')); ?>:</b>
	<?php echo CHtml::encode($data->contact_street_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_suburb')); ?>:</b>
	<?php echo CHtml::encode($data->contact_suburb); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_state')); ?>:</b>
	<?php echo CHtml::encode($data->contact_state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_country')); ?>:</b>
	<?php echo CHtml::encode($data->contact_country); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('asic_no')); ?>:</b>
	<?php echo CHtml::encode($data->asic_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('asic_expiry')); ?>:</b>
	<?php echo CHtml::encode($data->asic_expiry); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('verifiable_signature')); ?>:</b>
	<?php echo CHtml::encode($data->verifiable_signature); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_postcode')); ?>:</b>
	<?php echo CHtml::encode($data->contact_postcode); ?>
	<br />

	*/ ?>

</div>