<style>
    .summary{
        display:none !important;
    }
</style>
<?php
$session = new CHttpSession;
/* @var $this VisitorController */
/* @var $model Visitor */
$visitorName = $_GET['id'];
$visitorType = $_GET['visitortype'];

if (isset($_GET['tenant_agent']) && $_GET['tenant_agent'] != '') {
    $tenant_agent = 'tenant_agent="' . $_GET['tenant_agent'] . '" and';
} else {
    $tenant_agent = '(tenant_agent IS NULL or tenant_agent =0 or tenant_agent="") and';
}

$model = new User;
$criteria = new CDbCriteria;
if ($session['role'] == Roles::ROLE_SUPERADMIN) {
    $criteria->addCondition('tenant="' . $_GET['tenant'] . '"  and ' . $tenant_agent . '  (CONCAT(first_name," ",last_name) like "%' . $visitorName . '%" or first_name like "%' . $visitorName . '%" or last_name like "%' . $visitorName . '%")');
} else {
    if (isset($_GET['tenant_agent']) && $_GET['tenant_agent'] != '') {
        $tenant_agent = 'tenant_agent="' . $session['tenant_agent'] . '" and';
    } else {
        $tenant_agent = '(tenant_agent IS NULL or tenant_agent =0 or tenant_agent="") and';
    }
    $criteria->addCondition('tenant="' . $session['tenant'] . '" and '.$tenant_agent.'  (CONCAT(first_name," ",last_name) like "%' . $visitorName . '%" or first_name like "%' . $visitorName . '%" or last_name like "%' . $visitorName . '%")');
}

$model->unsetAttributes();

$customDataProvider = new CActiveDataProvider($model, array(
    'criteria' => $criteria,
        ));
if ($visitorType != VisitorType::PATIENT_VISITOR) {
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'findHost-grid',
        'dataProvider' => $customDataProvider,
        'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
        'columns' => array(
            array(
                'name' => 'first_name',
                'filter' => false
            ),
            'last_name',
            'email',
            'contact_number',
            array(
                'header' => 'Action',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align:center', 'class' => 'findHostButtonColumn'),
                'value' => function($data) {
            return CHtml::link('Select Host', '#', array(
                        'id' => $data['id'],
                        'onclick' => "parent.populateFieldHost({$data['id']})",
                            )
            );
        },
            ),
        ),
    ));
}
?>
