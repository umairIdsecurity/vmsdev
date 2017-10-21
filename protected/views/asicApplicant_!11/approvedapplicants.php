<?php $this->renderPartial('//importHosts/buttonstyle', null, false); ?>
<h1> Import Approved Applicants </h1>
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
         <label >
             <?php echo $form->fileField($uploadFile,'file', array('class'=>'input-file')); ?>
             <!--<span>Browse File</span>-->
			 <?php //echo $data->fileName;?>
         </label>

          <div class="row message-no-margin">
            <?php echo $form->error($uploadFile,'file'); ?>
         </div>
      </div>
      <div class="row">
        <?php echo CHtml::submitButton('Upload File', array("class"=>"completeButton")); ?>
      </div>

<?php $this->endWidget(); ?>
<h1> Approved Applicants </h1>
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
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}',
            'buttons' => array(
                'update' => array(//the name {reply} must be same
                    'label' => 'Edit', // text label of the button
                    'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                    'url' => 'Yii::app()->createUrl("asicApplicant/asicUpdate", array("id"=>$data->id))',
					//'options'=>array('style'=>'display: inline-block; font-size: 15px; text-align: center; width: 25%; margin-right: 10%')
                ),
                'delete' => array(//the name {reply} must be same
                    'label' => 'Delete', // text label of the button
                    'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                    'url' => 'Yii::app()->controller->createUrl("asicApplicant/delete",array("id"=>$data->id))',
                    'options' => array(// this is the 'html' array but we specify the 'ajax' element
					//'style'=>'display: inline-block; font-size: 15px; text-align: center; width: 25%; margin-right: 10%',
                       'confirm' => "Are you sure you want to delete this item?",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => "js:$(this).attr('href')", // ajax post will use 'url' specified above
                            'success' => 'function(data){
											//alert(data);
											if (data == "true")
											 {
											 $.fn.yiiGridView.update("asic-applicant");
												return false;
											 }
											 else
											 {
												 alert ("Cannot delete the requested ASIC");
											 }
                                            }',
							'error'=>'function(xhr,textStatus,errorThrown){
									console.log(xhr.responseText);
									console.log(textStatus);
									console.log(errorThrown);
							}',
                        ),
                    ),
                    
                ),
            ),
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