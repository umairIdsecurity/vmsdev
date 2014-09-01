<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Manage User', 'url'=>array('admin')),
	array('label'=>'Add User', 'url'=>array('user')),
);

$session = new ChttpSession;
switch ($session['role']){
    case "5":
    case "1":
        array_push($this->menu, array('label'=>'Add Administrator', 'url'=>array('user/create/&role=1')));
        array_push($this->menu, array('label'=>'Add Agent Administrator', 'url'=>array('user/create/&role=6')));
        array_push($this->menu, array('label'=>'Add Operator', 'url'=>array('user/create/&role=8')));
        array_push($this->menu, array('label'=>'Add Agent Operator', 'url'=>array('user/create/&role=7')));
        array_push($this->menu, array('label'=>'Set Access Rules', 'url'=>array('userworkstations/admin')));
        break;
    case "6":
        array_push($this->menu, array('label'=>'Add Agent Operator', 'url'=>array('user/create/&role=7')));
        array_push($this->menu, array('label'=>'Set Access Rules', 'url'=>array('user/create')));
        break;
    default:
        echo "";
        break;
};
//$this->widget('ext.CDropDownMenu.CDropDownMenu',array(
//            'style' => 'vertical', // or default or navbar
//            'items'=>array(
//                array(
//                   'label'=>'Login',
//                    'visible'=>!Yii::app()->user->isGuest,
//                    'items' => array(
//                        array(
//                            'label'=>'Login',
//                            'url'=>array('//demo/index'),
//                            ), 
//                        array(
//                            'label'=>'Login',
//                            'url'=>array('//demo/create'),
//                            ), 
//                        array(
//                            'label'=>'Login',
//                            'url'=>array('//demo/index', 'owner' => true),
//                            ), 
//                    ),
//                ) 
//        ),
//));

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Users</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		
		'first_name',
		'last_name',
		array (
                    'name'=>'role',
                    'value'=>'User::model()->getUserRole($data->role)',
                ),
                array (
                    'name'=>'user_type',
                    'value'=>'UserType::model()->getUserType($data->user_type)',
                ),
		'contact_number',
		
		/*
		'company',
		'department',
		'position',
		'staff_id',
		'notes',
		'photo',
		'password',
		'role',
		'user_type',
		'user_status',
		'created_by',
		*/
		array(
                    'header'=>'Actions',
                    'class'=>'CButtonColumn',
                    'template' => '{update}{delete}',
                    
		),
	),
)); ?>
