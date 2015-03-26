<style>
    .grid-view .summary {
        margin-left: 755px !important;
    }
</style>
<?php
/* @var $this UserController */
/* @var $model User */
$session = new ChttpSession;
$session['lastPage'] = 'admin';
?>

<h1>Manage Users</h1>


<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'first_name',
        'last_name',
        array(
            'name' => 'role',
            'value' => 'User::model()->getUserRole($data->role)',
            'filter' => getAssignableRoles($session['role']),
        ),
        array(
            'name' => 'assignedWorkstations',
            'filter' => CHtml::listData(Workstation::model()->findAll(array('order' => 'name ASC')), 'id', 'name'),
            'type' => 'html',
            'value' => 'UserWorkstations::model()->getAllworkstations($data->id)',
        ),
        array(
            'name' => 'user_type',
            'value' => 'UserType::model()->getUserType($data->user_type)',
            'filter' => User::$USER_TYPE_LIST,
        ),
        array(
            'name' => 'company',
            'value' => 'getCompany($data->id)',
            'header' => 'Company',
            'type' => 'raw'
        ),
        'contact_number',
        'email',
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
                    'visible' => '$data->id != 16',
                    'url' => 'Yii::app()->controller->createUrl("user/delete",array("id"=>$data->id))',
                    'options' => array(// this is the 'html' array but we specify the 'ajax' element
                        'confirm' => "Are you sure you want to delete this item?",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => "js:$(this).attr('href')", // ajax post will use 'url' specified above
                            'success' => 'function(data){
                                
                                                if(data == "true"){
                                                    $.fn.yiiGridView.update("user-grid");   
                                                    return false;
                                                }else{
                                                    var urlAddress = this.url;
                                                    var urlAddressId = urlAddress.split("=");
                                                    var x;
                                                    if($("#visitExists"+  urlAddressId["2"]).val() == 1){
                                                        alert("This profile cannot be deleted. This profile is currently assigned to a visit.");
                                                        return false;
                                                    } else if($("#isTenant"+  urlAddressId["2"]).val() == 1){
                                                        alert("This profile cannot be deleted. Profile is tenant of a company");
                                                        return false;
                                                    } else if($("#isUserWorkstation"+  urlAddressId["2"]).val() == 1){
                                                        alert("A workstation is linked to this profile. Please unlink workstation first before deleting this user.");
                                                        return false;
                                                    } else if($("#isUserTenantOfVisitor"+  urlAddressId["2"]).val() == 1){
                                                        alert("This profile cannot be deleted. This profile is currently the tenant of a visitor. ");
                                                        return false;
                                                    } else if($("#isUserTenantAgent"+  urlAddressId["2"]).val() == 1){
                                                        alert("This profile cannot be deleted. This profile is currently the tenant agent of a company.");
                                                        return false;
                                                    }   
                                                }
                                            }',
                        ),
                    ),
                ),
            ),
        ),
        array(
            'name' => 'id',
            'type' => 'raw',
            'value' => 'CHtml::textField("visitExists".$data->id,isUserInVisitExists($data->id))',
            'visible' => true,
            'cssClassExpression' => '"hidden"',
            'filter' => false,
        ),
        array(
            'name' => 'id',
            'type' => 'raw',
            'value' => 'CHtml::textField("isTenant".$data->id,isUserTenantOfCompany($data->id))',
            'visible' => true,
            'cssClassExpression' => '"hidden"',
            'filter' => false,
        ),
        array(
            'name' => 'id',
            'type' => 'raw',
            'value' => 'CHtml::textField("isUserWorkstation".$data->id,isUserAssignedToAWorkstation($data->id))',
            'visible' => true,
            'cssClassExpression' => '"hidden"',
            'filter' => false,
        ),
        array(
            'name' => 'id',
            'type' => 'raw',
            'value' => 'CHtml::textField("isUserTenantOfVisitor".$data->id,isUserTenantOfVisitor($data->id))',
            'visible' => true,
            'cssClassExpression' => '"hidden"',
            'filter' => false,
        ),
        array(
            'name' => 'id',
            'type' => 'raw',
            'value' => 'CHtml::textField("isUserTenantAgent".$data->id,isUserTenantAgent($data->id))',
            'visible' => true,
            'cssClassExpression' => '"hidden"',
            'filter' => false,
        ),
    ),
));

function getAssignableRoles($user_role) {
    //$assignableRolesArray = array();
    switch ($user_role) {
        case Roles::ROLE_AGENT_ADMIN: //agentadmin
            $assignableRoles = array(
                Roles::ROLE_AGENT_ADMIN => 'Agent Administrator',
                Roles::ROLE_AGENT_OPERATOR => 'Agent Operator',
                Roles::ROLE_STAFFMEMBER => 'Staff Member'); //keys

            break;

        case Roles::ROLE_SUPERADMIN: //superadmin
            $assignableRoles = array(
                Roles::ROLE_SUPERADMIN => 'Super Administrator',
                Roles::ROLE_ADMIN => 'Administrator',
                Roles::ROLE_AGENT_ADMIN => 'Agent Administrator',
                Roles::ROLE_AGENT_OPERATOR => 'Agent Operator',
                Roles::ROLE_OPERATOR => 'Operator',
                Roles::ROLE_STAFFMEMBER => 'Staff Member'
            ); //keys

            break;

        case Roles::ROLE_ADMIN: //admin

            $assignableRoles = array(
                Roles::ROLE_ADMIN => 'Administrator',
                Roles::ROLE_AGENT_ADMIN => 'Agent Administrator',
                Roles::ROLE_AGENT_OPERATOR => 'Agent Operator',
                Roles::ROLE_OPERATOR => 'Operator',
                Roles::ROLE_STAFFMEMBER => 'Staff Member'
            ); //keys
            break;
    }
    return $assignableRoles;
}

function isUserInVisitExists($userId) {
    return Visit::model()->exists('is_deleted = 0 and host ="' . $userId . '"');
}

function isUserTenantOfCompany($userId) {
    return Company::model()->exists('is_deleted = 0 and tenant ="' . $userId . '"');
}

function isUserAssignedToAWorkstation($userId) {
    return UserWorkstations::model()->exists('user = "' . $userId . '"');
}

function isUserTenantOfVisitor($userId) {
    return Visitor::model()->exists('tenant = "' . $userId . '" and is_deleted=0');
}

function isUserTenantAgent($userId) {
    return Company::model()->exists('tenant_agent = "' . $userId . '" and is_deleted=0');
}

function getCompany($id) {
        return Company::model()->findByPk(User::model()->findByPk($id)->company)->name;
}
?>