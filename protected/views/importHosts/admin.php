<h1>Manage Duplicate Hosts</h1>
 
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'import-hosts-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		/* 'id', */
		'first_name',
		'last_name',
		'email',
		'department',
		'staff_id',
		'contact_number',
                'date_of_birth',
                'position',
		
		/*'company',
		'imported_by',
		'date_imported',
		'password',
		'role',
		*/
		 array(
                'header' => 'Actions',
                'class' => 'CButtonColumn',
                'template' => '{update}{delete}',
                'buttons' => array(
                    'update' => array(//the name {reply} must be same
                        'label' => 'Edit', // text label of the button
                        'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                    ),
                    'delete' => array(//the name {reply} must be same
                        'label' => 'Delete', // text label of the button
                        'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                        'visible' => '(($data->id)!= 1)',
                    ),
                ),
            ),
	),
)); ?>

<?php $form = $this->beginWidget("CActiveForm", array(
    "id"=>"importvisitor-to-visitor",
    "action"=>Yii::app()->createUrl('importHosts/import'),   
        )); ?>

    <div class="buttons">
	<?php echo CHtml::submitButton("Import Hosts"); ?>
    </div>
<?php $this->endWidget(); ?>
