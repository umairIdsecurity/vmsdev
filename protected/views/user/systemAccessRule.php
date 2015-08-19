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
    'id' => 'user-access-grid',
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    'hideHeader'=>true,
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'first_name',
            'header' => 'User',
            'value' => 'ucwords($data->first_name.\' \'.$data->last_name)',
            'filter'=>CHtml::activeTextField($model, 'first_name', array('placeholder'=>'User')),
        // 'filter'=>'',
        ),
        array(
            'name' => 'user_type',
            'value' => 'UserType::model()->getUserType($data->user_type)',
            'filter' => User::$USER_TYPE_LIST,
        ),
        array(
            'name' => 'email',
            'filter'=>CHtml::activeTextField($model, 'email', array('placeholder'=>'Email Address')),
        ),

        array(
            'header' => 'Action',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center'),
            'value' => function($data) {
        return CHtml::link('Edit', '#', array(
                    'id' => $data['id'],
                    'class' => 'actionForward',
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
        'style' => 'display:none;'
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
        $(".modal-body").html('<iframe onload="javascript:resizeIframe(this);"  id="iframe" width="100%" height="100%" frameborder="0" scrolling="no" src="' + url + '"></iframe>');
        $("#modalBtn").click();
    }
    
    function resizeIframe(obj) {
        var text = $('#iframe').contents().find('head').html();
        if (text.indexOf("Visitor Management System  - Login") > -1) {
            window.location = "<?php echo Yii::app()->createUrl('site/login');?>";
        }
        obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
    }
    
    
</script>

