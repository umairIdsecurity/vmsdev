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
    $tenant_agent = 't.tenant_agent="' . $_GET['tenant_agent'] . '" and';
} else {
    $tenant_agent = '(t.tenant_agent IS NULL or t.tenant_agent =0 or t.tenant_agent="") and';
}

$model = new User;
$criteria = new CDbCriteria;
$tenant = '';
if($_GET['tenant'] && $_GET['tenant']!=''){
  $tenant = 't.tenant='.$_GET['tenant'].' AND ';
}else{
    $tenant = '';
}
if ($session['role'] == Roles::ROLE_SUPERADMIN) {
    $criteria->addCondition($tenant.$tenant_agent . '  (CONCAT(t.first_name," ",t.last_name) like "%' . $visitorName . '%" or t.first_name like "%' . $visitorName . '%" or t.last_name like "%' . $visitorName . '%" or t.email like "%' . $visitorName . '%")');
} else {
    if (isset($_GET['tenant_agent']) && $_GET['tenant_agent'] != '') {
        $tenant_agent = 't.tenant_agent="' . $session['tenant_agent'] . '" and';
    } else {
        $tenant_agent = '(t.tenant_agent IS NULL or t.tenant_agent =0 or t.tenant_agent="") and';
    }
    $criteria->addCondition($tenant.$tenant_agent.'  (CONCAT(t.first_name," ",t.last_name) like "%' . $visitorName . '%" or t.first_name like "%' . $visitorName . '%" or t.last_name like "%' . $visitorName . '%" or t.email like "%' . $visitorName . '%")');
}

if (isset($_GET['cardType']) && $_GET['cardType'] > CardType::CONTRACTOR_VISITOR) {
    $criteria->join = 'INNER JOIN visitor v ON t.`email` = v.`email`';
    $criteria->addCondition('v.profile_type = "' . Visitor::PROFILE_TYPE_ASIC . '"');
}

$model->unsetAttributes();

$customDataProvider = new CActiveDataProvider($model, array(
    'criteria' => $criteria,
        ));
if ($visitorType != VisitorType::PATIENT_VISITOR) {
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'findHost-grid-1',
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
            return CHtml::link('Select ASIC Sponsor', '#', array(
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
