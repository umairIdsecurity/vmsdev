<?php
/* @var $this VisitController */
/* @var $model Visit */

?>
<h1>Preregistered Visitors</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'visit-gridDashboard',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
    'columns' =>
    array(
        array(
            'name' => 'visit_status',
            'filter' => false,
            'value' => 'CHtml::link(VisitStatus::$VISIT_STATUS_LIST[$data->visit_status],Yii::app()->createUrl("visit/detail",array("id"=>$data->id)),array("class" =>"statusLink"))',
            'type' => 'raw',
            'header' => 'Status',
            'cssClassExpression' => 'changeStatusClass($data->visit_status)',
        ),
        array(
            'name' => 'cardnumber',
            'header' => 'Card No.',
            'value'=>  'CardGenerated::model()->getCardCode($data->card)',
        ),
        
        array(
            'name' => 'firstname',
            'value' => 'Visitor::model()->findByPk($data->visitor)->first_name',
            'header' => 'First Name'
        ),
        array(
            'name' => 'lastname',
            'value' => 'Visitor::model()->findByPk($data->visitor)->last_name',
            'header' => 'Last Name'
        ),
        array(
            'name' => 'company',
            'value' => 'getCompany($data->visitor)',
            'header' => 'Company',
            'cssClassExpression' => '( getCompany($data->visitor)== "Not Available" ? "errorNotAvailable" : "" ) ',
            'type' => 'raw'
        ),
        array(
            'name' => 'contactnumber',
            'value' => 'Visitor::model()->findByPk($data->visitor)->contact_number',
            'header' => 'Contact Number'
        ),
        array(
            'name' => 'contactemail',
            'value' => 'Visitor::model()->findByPk($data->visitor)->email',
            'header' => 'Contact Email'
        ),
        array(
            'name' => 'date_in',
            'type' => 'html',
          //  'value' => 'formatDate($data->date_in)',
        ),
        array(
            'name' => 'time_in',
            'type' => 'html',
            'value' => 'formatTime($data->time_in)',
        ),
        array(
            'name' => 'date_out',
            'type' => 'html',
        //    'value' => 'formatDate($data->date_out)',
        ),
    ),
));

function getVisitorFullName($id) {
    $visitor = Visitor::model()->findByPk($id);

    return $visitor->first_name . ' ' . $visitor->last_name;
}

function getCompany($id) {

    $company_id = Visitor::model()->findByPk($id)->company;

    if (isset($company_id)) {

        $companyModel = Company::model();

        $company = $companyModel->findByPk($company_id, "is_deleted >= 0 " );

        if(isset($company))
        {
            return $company->name;
        }
    }
    return "Not Available";

}

function formatTime($time) {
    if ($time == '' || $time == '00:00:00') {
        return "-";
    } else {
        return date('h:i A', strtotime($time));
    }
}

function changeStatusClass($visitStatus){
   // return "red";
   switch ($visitStatus) {
       case VisitStatus::ACTIVE:
           return "green";
           break;
       
       case VisitStatus::PREREGISTERED:
           return "blue";
           break;
       
       case VisitStatus::CLOSED:
           return "red";
           break;
       
       case VisitStatus::SAVED:
           return "grey";
           break;

       default:
           break;
   }
}
?>
