

<?php

/* @var $this CountryController */
/* @var $model Country */
?>

<h1>Countries</h1>

<br />
<?php echo CHtml::button('Export to CSV', array('id' => 'export-button', 'class' => 'greenBtn complete'));?>


<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'country-grid',
    'dataProvider' => $model->search(),
    'hideHeader'=>true,
	'htmlOptions'=> array('style' => 'margin: 40px'),
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id',
            'filter'=>CHtml::activeTextField($model, 'id', array('placeholder'=>'ID', 'class' => 'header-form')),
        ),
        array(
            'name' => 'code',
            'filter'=>CHtml::activeTextField($model, 'code', array('placeholder'=>'Country Code', 'class' => 'header-form')),
        ),
        array(
            'name' => 'name',
            'filter'=>CHtml::activeTextField($model, 'name', array('placeholder'=>'Country name', 'class' => 'header-form', 'style'=>'length:90px')),
        ),
		array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'template' => '{update}',
            'buttons' => array(
                'update' => array(//the name {reply} must be same
                    'label' => 'Edit', // text label of the button
                    'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                ),
            ),
        ),
    ),
));

?>

<script>
$(document).ready(function() {
        if ($("#totalRecordsCount").val() == 0) {
            $('#export-button').removeClass('greenBtn');
            $('#export-button').addClass('btn DeleteBtn actionForward');
            $("#export-button").attr('disabled', true);
        }
        $('#export-button').on('click', function() {
            $.fn.yiiGridView.export();
        });
        $.fn.yiiGridView.export = function() {
            $.fn.yiiGridView.update('country-grid', {
                success: function() {
                    $('#country-grid').removeClass('grid-view-loading');
                    window.location = '<?php echo $this->createUrl('exportFileCountry');?>';
                },
                data: $('#country-grid').serialize() + '&export=true'
            });
        }

    });
</script>
