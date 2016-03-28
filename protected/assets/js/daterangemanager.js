/**
 * Created by geoffstewart on 25/03/2016.
 */


function DateRangeManager(startControl,endControl,options)
{
    this.startControl = startControl;
    this.endControl = endControl;
    this.options = options;
    this.startControl.datepicker('option','minDate',options['min_start_date']);
    this.startControl.datepicker('option','maxDate',options['max_start_date']);

    startControl.daterangemanager = this;
    endControl.daterangemanager = this;


    this.checkEndDate = function(){

        var maxDurationDate = null;
        var minDurationDate = null;
        var minEndDate = null;
        var maxEndDate = null;
        var dateFormat = startControl.datepicker('option','dateFormat');

        if(options['max_end_date']){
            maxEndDate = $.datepicker.parseDate(dateFormat,options['max_end_date']);
        }

        if(options['max_duration']){
            maxDurationDate = startControl.datepicker('getDate');
            maxDurationDate.setDate(maxDurationDate.getDate() + options['max_duration']);
            if(maxEndDate == null || maxDurationDate < maxEndDate){
                maxEndDate = maxDurationDate;
            }
        }

        minEndDate = $.datepicker.parseDate(dateFormat,startControl.val());

        if(options['min_duration']){
            minDurationDate = startControl.datepicker('getDate');
            minDurationDate.setDate(mindurationDate.getDate() + options['min_duration']);
            if(minDurationDate > minEndDate){
                minEndDate = minDurationDate;
            }
        }

        if(options['min_end_date']){
            minEndDate = $.datepicker.parseDate(dateFormat,option['min_end_date']);
        }

        var currentEndDate = $.datepicker.parseDate(dateFormat,endControl.val());

        if(currentEndDate > maxEndDate){
            currentEndDate = maxEndDate;
        } else if(currentEndDate < minEndDate)  {
            currentEndDate = minEndDate;
        }

        endControl.datepicker("setDate", $.datepicker.formatDate(dateFormat,currentEndDate));


        if(minEndDate){
            endControl.datepicker("option","minDate", $.datepicker.formatDate(dateFormat,minEndDate));
        }

        if(maxEndDate){
            endControl.datepicker("option","maxDate", $.datepicker.formatDate(dateFormat,maxEndDate));
        }

    }

    startControl.datepicker('option','onClose',startControl.daterangemanager.checkEndDate);
    endControl.datepicker('option','onClose',endControl.daterangemanager.checkEndDate);

}

