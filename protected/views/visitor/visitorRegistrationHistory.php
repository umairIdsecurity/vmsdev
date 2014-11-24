<?php
/* @var $this VisitorController */
/* @var $model Visitor */
?>

<h1>Visitor Registration History</h1>
<div style="text-align:left;"><input type="button" class="greenBtn" value="Export to CSV" id="export"/></div>
<br>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'visitor-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'first_name',
        'last_name',
        'email',
        'contact_number',
        array(
            'name' => 'visitor_status',
            'value' => 'VisitorStatus::$VISITOR_STATUS_LIST[$data->visitor_status]',
            'filter' => VisitorStatus::$VISITOR_STATUS_LIST,
        ),
        
    ),
));
?>
