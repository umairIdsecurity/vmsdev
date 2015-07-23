<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 7/22/15
 * Time: 7:10 PM
 */


?>

<div class="page-content">
    <h1 class="text-primary title">LOG VISIT DETAILS</h1>
    <div class="bg-gray-lighter form-info">Please select the time of your visit.</div>
    <div class="form-log-visit">
        <div class="row">
            <div class="hidden-xs col-sm-4 text-center">
                <a href="#"><img src="<?=Yii::app()->theme->baseUrl?>/images/vic24h.png" alt="Vic24h"></a>
            </div>
            <div class="col-sm-8">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4 text-primary control-label">DATE OF VISIT</label>
                        <div class="col-sm-7">
                            <span class="glyphicon glyphicon-calendar"></span>
                            <input type="input"
                                   name="date_start"
                                   class="form-control input-lg"
                                   data-date-picker
                                   data-date-format="dd/mm/yy"
                                   placeholder="DD/MM/YY">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 text-primary control-label">END DATE OF VISIT</label>
                        <div class="col-sm-7">
                            <span class="glyphicon glyphicon-calendar"></span>
                            <input type="input"
                                   name="date_end"
                                   class="form-control input-lg"
                                   data-date-picker
                                   data-date-format="dd/mm/yy"
                                   data-linked-pickers="[name=date_start]"
                                   placeholder="DD/MM/YY">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 text-primary control-label">TIME IN</label>
                        <div class="row col-sm-7">
                            <div class="col-xs-6">
                                <select name="time-in-h" class="form-control input-lg">
                                    <option value="5:00">5:00</option>
                                    <option value="5:30">5:30</option>
                                    <option value="6:00">6:00</option>
                                    <option value="6:30">6:30</option>
                                    <option value="7:00">7:00</option>
                                    <option value="7:30">7:30</option>
                                    <option value="8:00">8:00</option>
                                    <option value="8:30">8:30</option>
                                    <option value="9:00">9:00</option>
                                    <option value="9:30">9:30</option>
                                    <option value="10:00">10:00</option>
                                    <option value="10:30">10:30</option>
                                    <option value="11:00">11:00</option>
                                    <option value="11:30">11:30</option>
                                    <option value="12:00">12:00</option>
                                    <option value="12:30">12:30</option>
                                    <option value="1:00">1:00</option>
                                    <option value="1:30">1:30</option>
                                    <option value="2:00">2:00</option>
                                    <option value="2:30">2:30</option>
                                    <option value="3:00">3:00</option>
                                    <option value="3:30">3:30</option>
                                    <option value="4:00">4:00</option>
                                    <option value="4:30">4:30</option>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <select name="time-in-h" class="form-control input-lg">
                                    <option value="AM">AM</option>
                                    <option value="AM">PM</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-1"></div>
        </div>
    </div>
</div>