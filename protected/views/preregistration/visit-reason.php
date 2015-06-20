<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/19/15
 * Time: 10:06 AM
 */

?>
<?php
if(Yii::app()->user->isGuest){
    echo "its guest";
}
else{
    echo "logged in";
}
?>
<div class="page-content">
    <h1 class="text-primary title">REASON FOR VISIT</h1>
    <div class="bg-gray-lighter form-info">Please provide a reason for this visit.</div>
    <form class="form-create-login">
        <div class="form-group">
            <select name="type" class="form-control input-lg">
                <option disabled selected>Select visitor type</option>
                <option value="1">Entry Point 1</option>
                <option value="2">Entry Point 2</option>
                <option value="3">Entry Point 3</option>
                <option value="4">Entry Point 4</option>
                <option value="5">Entry Point 5</option>
            </select>
        </div>
        <div class="form-group">
            <select name="reason" class="form-control input-lg">
                <option disabled selected>Select reason</option>
                <option value="1">Entry Point 1</option>
                <option value="2">Entry Point 2</option>
                <option value="3">Entry Point 3</option>
                <option value="4">Entry Point 4</option>
                <option value="5">Entry Point 5</option>
            </select>
        </div>
        <div class="form-group">

            <input name="first-name"
                   class="form-control input-lg"
                   data-validate-input
                   placeholder="Random co." >
        </div>
        <div class="form-group">
            <input name="last-name"
                   class="form-control input-lg"
                   data-validate-input
                   placeholder="Jane Schimdt" >
        </div>
        <div class="form-group">
            <input name="email"
                   class="form-control input-lg"
                   data-validate-input
                   placeholder="jane.schimdt@company.com" >
        </div>
        <div class="form-group">
            <input name="tel"
                   class="form-control input-lg"
                   data-validate-input
                   placeholder="+63512345678" >
        </div>
    </form>
</div>