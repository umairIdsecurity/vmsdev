<?php
/* @var $this UserController */
/* @var $model User */
$session = new ChttpSession;
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
//        array(
//            'name' => 'workstation.workstation',
//            'header' => 'Assigned Workstations',
//            'value' => 'UserWorkstations::model()->getAllworkstations($data->id)',
//        ),
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
        'contact_number',
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
                ),
            ),
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
?>
