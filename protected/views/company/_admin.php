<?php
/* @var $this CompanyController */
/* @var $model Company */

?>

<h1>Companies</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'company-grid',
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    'hideHeader'=>true,
    'filter' => $model,
    'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
    'columns' => array(
        array(
            'name' => 'name',
            'filter'=>CHtml::activeTextField($model, 'name', array('placeholder'=>'Company Name')),
        ),
//        array(
//            'name' => 'trading_name',
//            'filter'=>CHtml::activeTextField($model, 'trading_name', array('placeholder'=>'Trading/Display Name')),
//        ),
        array(
            'name' => 'contact',
            'filter'=>CHtml::activeTextField($model, 'contact', array('placeholder'=>'Company Contact Name')),
        ),
//        array(
//            'name' => 'billing_address',
//            'filter'=>CHtml::activeTextField($model, 'billing_address', array('placeholder'=>'Billing Address')),
//        ),
        array(
            'name' => 'user_email',
            'value' => 'getUserEmail($data->id)',
            'filter'=> false,
        ),
        array(
            'name' => 'user_contact_number',
            'value' => 'getUserContact($data->id)',
            'filter'=> false,
        ),
        /*array(
           'name'=>'isTenant',
            'type'=>'raw',
            'header' => "Is Tenant?",
            'filter'=>array(""=>"Is Tenant?",0=>"No",1=>"Yes"),
            'value' => '$data->isTenant?"Yes":"No"',
            'htmlOptions' => array('style' => "text-align:center;"),

        ),*/


        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}',
            'buttons' => array(
                'update' => array(//the name {reply} must be same
                    'label' => 'Edit', // text label of the button
                    'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                ),

                'delete' => array
                (
                    'label'=>'Delete',
                    //other params
                    'imageUrl' => false,
                    'visible' => '(($data->id)!= 1)',
                ),

            ),
        ),
    ),
));

function isCompanyTenant($companyId) {

    $company = Yii::app()->db->createCommand()
                    ->select('c.id')
                    ->from('"user" u')
                    ->join('company c', 'u.company=c.id')
                    ->where("u.id=c.tenant and c.id !=1 and c.id=" . $companyId . "")
                    ->queryAll();
    if(count($company) != 0){
        return  "1";
    } else {
        return "0";
    }
}

function getUserEmail($id)
{
    $users = User::model()->findAll('company=:company', array(':company'=>$id));
    if ($users)
        return $users[0]->email;
    else
        return "";
}

function getUserContact($id)
{
    $users = User::model()->findAll('company=:company', array(':company'=>$id));
    if ($users)
        return $users[0]->contact_number;
    else
        return "";
}

?>
