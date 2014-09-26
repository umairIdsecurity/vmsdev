<?php
/* @var $this UserController */
/* @var $model User */
$session = new CHttpSession;
?>

<h1>Set Access Rules</h1>

<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'first_name',
            'header' => 'User',
            'value' => 'ucwords($data->first_name.\' \'.$data->last_name)',
        // 'filter'=>'',
        ),
        array(
            'name' => 'user_type',
            'value' => 'UserType::model()->getUserType($data->user_type)',
            'filter' => User::$USER_TYPE_LIST,
        ),
        'email',
        array(
            'header' => 'Action',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center'),
            'value' => function($data) {
        return CHtml::link('Edit', '#', array(
                    'id' => $data['id'],
                    'onclick' => "updateWorkstations({$data['id']},'{$data['first_name']} {$data['last_name']}')",
                    'data-target' => '#myModal',
                    'data-toggle' => 'modal',
                        )
        );
    },
        ),
    ),
));
?>


<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'workstationsModal')); ?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Workstations assigned to <span id='assignedto'></span></h4>
</div>

<div class="modal-body">

</div>

<?php $this->endWidget(); ?>
<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'Click me',
    'type' => 'primary',
    'htmlOptions' => array(
        'data-toggle' => 'modal',
        'data-target' => '#workstationsModal',
        'id' => 'modalBtn',
        'style' => 'display:none',
    ),
));
?>
<script>
    $(document).ready(function() {

    });

    function updateWorkstations(id, username) {

        //append selected name in modal
        var span = document.getElementById('assignedto');
        while (span.firstChild) {
            span.removeChild(span.firstChild);
        }

        span.appendChild(document.createTextNode(username));

        //change modal url to pass user id
        var url = 'index.php?r=userWorkstations/index&id=' + id;
        $(".modal-body").html('<iframe width="100%" height="50%" frameborder="0" scrolling="no" src="' + url + '"></iframe>');
        $("#modalBtn").click();
    }

</script>

