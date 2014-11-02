
<div id="visitHistoryVisitDetailDiv">
    <span class="visitTitle">Visit History</span>
    <div id="visitHistoryTableDiv">
        <span>Closed Visit</span>

        <?php
        if($model->host !=''){
            $host = $model->host;
            $userHost = 'host';
        } else {
            $host= $model->patient;
            $userHost = 'patient';
        }
        
        $model = new Visit;
        $criteria = new CDbCriteria;
        $criteria->addCondition('visit_status=3 ');

        $model->unsetAttributes();
        $visitData = new CActiveDataProvider($model, array(
            'criteria' => $criteria,
        ));
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'visit-grid',
            'dataProvider' => $visitData,
            'columns' => array(
                array(
                    'header' => 'Card No.',
                    'name' => 'card'
                ),
                array(
                    'header' => 'Open by',
                    'name' => 'created_by',
                    'type' => 'html',
                    'value' => 'User::model()->findByPk($data->created_by)->first_name." ".User::model()->findByPk($data->created_by)->last_name',
                ),
                array(
                    'name' => 'date_in',
                    'type' => 'html',
                    'value' => 'Yii::app()->dateFormatter->format("d/MM/y",strtotime($data->date_in))',
                ),
                'host',
                array(
                    'name' => 'date_out',
                    'type' => 'html',
                    'value' => 'Yii::app()->dateFormatter->format("d/MM/y",strtotime($data->date_out))',
                ),
                'time_out',
                array(
                    'header' => 'Closed by',
                    'name' => 'created_by',
                    'type' => 'html',
                    'value' => 'User::model()->findByPk($data->created_by)->first_name." ".User::model()->findByPk($data->created_by)->last_name',
                ),
                array(
                    'header' => 'Actions',
                    'class' => 'CButtonColumn',
                    'template' => '{delete}',
                    'buttons' => array(
                        'delete' => array(//the name {reply} must be same
                            'label' => 'Delete', // text label of the button
                            'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                        ),
                    ),
                ),
            ),
        ));
        ?>

    </div>
</div>