<?php $this->renderPartial('//importHosts/buttonstyle', null, false); ?>
<h1> Import Lodged Applicants </h1>
<div class="form">
 
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'importcsv-form',
    'enableAjaxValidation'=>false,
    'method'=>'post',
	'stateful'=>true,
    'htmlOptions'=>array(
        'enctype'=>'multipart/form-data'
    )
)); ?>
 
     
     <div class=" <?php if ($model->hasErrors('postcode')) echo "error"; ?>">
	 <label>
	  <b>Upload AusCheck Lodgement File</b></br> This will import applicant from ASIC Applicant to ASIC Lodged
	 </label>
         <label >
             <?php echo $form->fileField($uploadFile,'file', array('class'=>'input-file')); ?>
             <!--<span>Browse File</span>-->
			 <?php //echo $data->fileName;?>
         </label>
	<label>
	  <b>Upload Eligible/ Not Eligible File</b></br> This will reset eligible applicants to '0' in Visitors > ASIC Pending and not eligible applicants to ASIC Denied
	 </label>
         <label >
             <?php echo $form->fileField($uploadFile,'file1', array('class'=>'input-file')); ?>
             <!--<span>Browse File</span>-->
			 <?php //echo $data->fileName;?>
         </label>
	<label>

          <div class="row message-no-margin">
            <?php echo $form->error($model,'file'); ?>
         </div>
      </div>
      <div class="row">
        <?php echo CHtml::submitButton('Upload File', array("class"=>"completeButton")); ?>
      </div>

<?php $this->endWidget(); ?>
<h1> Lodged Applicants </h1>
 <?php

$this->widget('zii.widgets.grid.CGridView', array(
	'id'              => 'asic-applicant',
	'dataProvider'    => $model->search(),
	'enableSorting'   => false,
	//'ajaxUpdate'=>true,
	'hideHeader'      => true,
	'filter'          => $model,
	'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
	'columns'         => array(
		
		array(
			'name'   => 'id',
			'filter' => CHtml::activeTextField($model, 'id', array('placeholder' => 'ID', 'class' => 'header-form','id'=>'asic_id')),
		),
		array(
			'name'   => 'First Name',
			'value'  => '$data->first_name',
			'filter' => CHtml::activeTextField($model, 'first_name', array('placeholder' => 'First Name', 'class' => 'header-form')),
		),
		array(
			'name'   => 'Given Names',
			'value'  => '$data->given_name2." ".$data->given_name3',
			'filter' => CHtml::activeTextField($model, 'given_name2', array('placeholder' => 'Given Names', 'class' => 'header-form','disabled'=>true)),
		),
		
		array(
			'name'   => 'lastname',
			'value'  => '$data->last_name',
			'filter' => CHtml::activeTextField($model, 'last_name', array('placeholder' => 'Last Name', 'class' => 'header-form')),
		),
		array(
			'name'   => 'DOB',
			'value'  => 'date("d/m/Y",strtotime($data->date_of_birth))',
			'filter' => CHtml::activeTextField($model, 'date_of_birth', array('placeholder' => 'Date of Birth', 'class' => 'header-form')),
		),
		array(
			'name'   => 'email',
			'value'  => '$data->email',
			'filter' => CHtml::activeTextField($model, 'email', array('placeholder' => 'Email', 'class' => 'header-form')),
		),
		array(
			'name'   => 'Application Type',
			'value'  => '$data->application_type',
			'filter' => CHtml::activeTextField($model, 'application_type', array('placeholder' => 'Application', 'class' => 'header-form')),
		),
		array(
			'name'   => 'Company',
			'value'  => 'getCompanyName($data->company_id)',
			'filter' => CHtml::activeTextField($model, 'company_id', array('placeholder' => 'company', 'class' => 'header-form')),
		),
		array(
			'name'   => 'Applied',
			'value'  => 'date("d/m/Y",strtotime($data->created_on))',
			'filter' => CHtml::activeTextField($model, 'created_on', array('placeholder' => 'Applied On', 'class' => 'header-form')),
		),
		array(
			'name'   => 'Eligible',
			'value'  => '($data->is_eligible==1) ? "Yes" : "-"',
			'filter' => CHtml::activeTextField($model, 'created_on', array('placeholder' => 'Eligible', 'class' => 'header-form','style'=>'width:55px;','disabled'=>true)),
		),


	),
));



function getCompanyName($comp) {
    if ($comp == '') {
        return "";
    } else {
        $company = Company::model()->findByPk($comp);
        return $company->name;
    }
}

?>

<script>
   $(document).ready(function() {
 
    });
</script>
</div>