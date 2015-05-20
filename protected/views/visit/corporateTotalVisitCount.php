<?php

/* @var $this VisitController */
/* @var $model Visit */
?>

<h1>Corporate Total Visit Count</h1>

<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'corporate-total-visit-count',
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    //'ajaxUpdate'=>true,
    'hideHeader'=>true,
    'filter' => $model,
    'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
    'columns' => array(
        array(
            'name' => 'id',
            'filter'=>CHtml::activeTextField($model, 'id', array('placeholder'=>'Visitor ID')),
        ),
        array(
            'name' => 'visit_count',
            //'value' => '$data->totalvisit',
            'header' => 'Total Visits',
            'filter'=>CHtml::activeTextField($model, 'totalvisit', array('placeholder'=>'Total Visits')),
        ),
        array(
            'name' => 'company0.code',
            'header' => 'Company Code',
            'filter'=>CHtml::activeTextField($model, 'companycode', array('placeholder'=>'Company Code')),
        ),
        array(
            'name' => 'first_name',
            'filter'=>CHtml::activeTextField($model, 'first_name', array('placeholder'=>'First Name')),
        ),
        array(
            'name' => 'last_name',
            'filter'=>CHtml::activeTextField($model, 'last_name', array('placeholder'=>'Last Name')),
        ),
        array(
            'name' => 'company0.name',
            'header' => 'Company Name',
            'filter'=>CHtml::activeTextField($model, 'company', array('placeholder'=>'Company Name')),
        ),

        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'template' => '{reset}',
            'buttons' => array(
                'reset' => array(//the name {reply} must be same
                    'label' => 'Reset', // text label of the button
                    'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                    'url' => 'Yii::app()->createUrl("visit/resetVisitCount", array("id"=>$data->id))',
                    'click'=>"function(){
						if(!confirm('".Yii::t('warnings','Are you sure you want to do this?')."')) return false;
							$.fn.yiiGridView.update('corporate-total-visit-count', {
								type:'GET',
								url:$(this).attr('href'),
								success:function(response) {
									$.fn.yiiGridView.update('corporate-total-visit-count');
								}
							});
						return false;
					}",

                ),
            )
        )
    ),
));

?>
