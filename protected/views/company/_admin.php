<?php
/* @var $this CompanyController */
/* @var $model Company */

?>

<h1>Manage Companies</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'company-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'name',
        'trading_name',
        'contact',
        'billing_address',
        array(
           'name'=>'isTenant',
            'type'=>'raw',
            'header' => "Is Tenant",
            'filter'=>array(0=>"No",1=>"Yes"),
            'value' => '$data->isTenant?"Yes":"No"',
            'htmlOptions' => array('style' => "text-align:center;"),
            
        ),
        
      
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
));

function isCompanyTenant($companyId) {

    $company = Yii::app()->db->createCommand()
                    ->select('c.id')
                    ->from('user u')
                    ->join('company c', 'u.company=c.id')
                    ->where('u.id=c.tenant and c.id !=1 and c.id="' . $companyId . '"')
                    ->queryAll();
    if(count($company) != 0){
        return  "1";
    } else {
        return "0";
    }
}
?>
