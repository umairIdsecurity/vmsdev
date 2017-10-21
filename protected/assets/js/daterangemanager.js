/**
 * Created by geoffstewart on 25/03/2016.
 */


function DateRangeManager(startControl,endControl,options)
{
	console.log(startControl.val());
	console.log(endControl.val());
    this.startControl = startControl;
    this.endControl = endControl;
	
    this.options = options;
    this.startControl.datepicker('option','minDate',options['min_start_date']);
    this.startControl.datepicker('option','maxDate',options['max_start_date']);
    startControl.daterangemanager = this;
    endControl.daterangemanager = this;
//console.log(this);

    this.checkEndDate = function(){

        var maxDurationDate = null;
        var minDurationDate = null;
        var minEndDate = null;
        var maxEndDate = null;
        var dateFormat = startControl.datepicker('option','dateFormat');

        if(!endControl.is(':disabled')) {
			
            if(options['max_end_date']!=""){
            maxEndDate = $.datepicker.parseDate(dateFormat,options['max_end_date']-1);
        }

        if(options['max_duration']){
					console.log(options);
            maxDurationDate = startControl.datepicker('getDate');
            maxDurationDate.setDate(maxDurationDate.getDate() + Math.max(options['max_duration'],0));
            if(maxEndDate == null || maxDurationDate < maxEndDate){
                maxEndDate = maxDurationDate;
				console.log(maxEndDate);
            }
        }

        minEndDate = $.datepicker.parseDate(dateFormat,startControl.val());

        if(typeof options['min_duration']!='undefined'){
            minDurationDate = startControl.datepicker('getDate');
            minDurationDate.setDate(minDurationDate.getDate() + Math.max(0,options['min_duration']+1));
			
            if(minDurationDate > minEndDate){
                minEndDate = minDurationDate;
            }
			//console.log(minEndDate);
        }

        if(options['min_end_date']){
            minEndDate = $.datepicker.parseDate(dateFormat,option['min_end_date']);
        }


            var currentEndDate = $.datepicker.parseDate(dateFormat, endControl.val());

            if (currentEndDate > maxEndDate) {
                currentEndDate = maxEndDate;
            } else if (currentEndDate < minEndDate) {
                currentEndDate = minEndDate;
            }

            endControl.datepicker("setDate", $.datepicker.formatDate(dateFormat, currentEndDate));


            if (minEndDate) {
                endControl.datepicker("option", "minDate", $.datepicker.formatDate(dateFormat, minEndDate));
            }

            if (maxEndDate) {
                endControl.datepicker("option", "maxDate", $.datepicker.formatDate(dateFormat, maxEndDate));
            }
        }

    }

    startControl.datepicker('option','onClose',startControl.daterangemanager.checkEndDate);
    endControl.datepicker('option','onClose',endControl.daterangemanager.checkEndDate);
    this.checkEndDate();
}

