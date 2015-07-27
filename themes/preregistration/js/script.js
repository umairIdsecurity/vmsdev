/**
 * @name Site
 * @description Define global variables and functions
 * @version 1.0
 * @Script by phpvnn
 */

window.userAccess = window.userAccess || [];
var defineVariable = defineVariable || [];

defineVariable.location = defineVariable.location || [];
defineVariable.qsYesNo = defineVariable.qsYesNo || [];

var Site = (function($, window, undefined) {
    'use strict';
    var isFunction = function(functionToCheck) {
        var getType = {};
        return functionToCheck && getType.toString.call(functionToCheck) === '[object Function]';
    };
    /*in development
    description: We are using data attribute to manage all control of input which was checked validation
    user: <input type="text" name="first_name" data-validate="" data-required="required message here"
    data-pattern="^((?![/,\,<,>]).)*$" data-max-length="128" data-pattern-message="Validate message here">*/

    var isValidate = function(element) {
        var isValid = true,
            classIsValid = 'invalid',
            strMessage = null,
            strVal = element.val().trim(),
            min = element.data('minLength'),
            max = element.data('maxLength'),
            strRequired = element.data('required'),
            strPattern = element.data('pattern'),
            smsPattern = element.data('patternMessage'),
            patt = new RegExp(strPattern),
            type = element.attr('type');

            strVal = strVal.replace('"','”');
            strVal = strVal.replace('\'','’');


        if (strRequired) {
            if (!strVal) {
                isValid = false;
                strMessage = strRequired;
            } else if (type == 'radio') {
                var $radios = $('input:radio[name="' + element.attr('name') + '"]:checked');
                if (!$radios.length) {
                    isValid = false;
                    strMessage = strRequired;
                } else {
                    strVal = $radios.val();
                    console.log(strVal);
                }
            }
        }

        if (strVal) {
            if (strPattern && !strMessage) {
                isValid = patt.test(strVal);
                if (!isValid) {
                    strMessage = smsPattern;
                }
            }
            if (min && min > strVal.length) {
                isValid = false;
                strMessage = smsPattern;
            }
            if (max && max < strVal.length) {
                isValid = false;
                strMessage = smsPattern;
            }
        }

        if (!isValid) {
            if (!element.data('hiddenMessage')) {
                element.next('span').html(strMessage);
            }
            element.closest('.form-group').addClass(classIsValid);
        } else {
            if (!element.data('hiddenMessage')) {
                element.next('span').empty();
            }
            element.closest('.form-group').removeClass(classIsValid);
        }

        element.val(strVal);

        return isValid;
    };

    var formatStr = function(str) {
        var theString = str;
        for (var i = 1; i < arguments.length; i++) {
            var regEx = new RegExp("\\{" + (i - 1) + "\\}", "gm");
            theString = theString.replace(regEx, arguments[i]);
        }
        return theString;
    };

    return {
        isFunction: isFunction,
        isValidate: isValidate,
        formatStr: formatStr
    };

})(jQuery, window);

/**
 * Created by phpvnn on 5/18/15.
 */
var checkIEBrowser = (!! window.ActiveXObject && +(/msie\s(\d+)/i.exec(navigator.userAgent)[1])) || NaN;
if (checkIEBrowser < 9) {
    document.documentElement.className += ' lt-ie9' + ' ie' + checkIEBrowser;
}
//console.log('checkIEBrowser',checkIEBrowser);
/*
if (Modernizr.touch) {
    alert('Touch Screen');
} else {
    alert('No Touch Screen');
}*/

jQuery(function() {
    'use strict';
    var $datepickerEls = $('[data-date-picker]');

    if($datepickerEls.length){

        $datepickerEls.each(function(){
            var formatDay =$(this).data('dateFormat') || 'dd/mm/yyyy';
            var $linkedPickersElm = $(this).data('linkedPickers')?$($(this).data('linkedPickers')):null;

            $(this).datepicker({
                format: formatDay,
                autoclose: true
            });
            /*if($linkedPickersElm && $linkedPickersElm.length){
                $(this).click(function () {
                    if($linkedPickersElm.val()){
                        $(this).datepicker({
                            format: formatDay,
                            startDate:$linkedPickersElm.val(),
                            autoclose: true
                        });
                    }
                });
            }*/
        });
    }

    /* start date */
    $(".from_date").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    }).on('changeDate', function (selected) {
        var startDate = new Date(selected.date.valueOf());
        $('.to_date').datepicker('setStartDate', startDate);
    }).on('clearDate', function (selected) {
        $('.to_date').datepicker('setStartDate', null);
    });

    /* end date */
    $(".to_date").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    }).on('changeDate', function (selected) {
        var endDate = new Date(selected.date.valueOf());
        $('.from_date').datepicker('setEndDate', endDate);
    }).on('clearDate', function (selected) {
        $('.from_date').datepicker('setEndDate', null);
    });

});

jQuery(function() {
    'use strict';
    var $btnToggleClass = $('[data-toggle-class]'),
        $btnClosetToggleClass = $('[data-closet-toggle-class]'),
        $btnClosetUpdateClass = $('[data-closet-update-class]');

    if ($btnToggleClass.length) {
        $btnToggleClass.on('click', function(e) {
            e.preventDefault();
            var objTarget = $(this).data('toggleClassObject')? $(this).data('toggleClassObject').split(','):null;
            var objClass = $(this).data('toggleClass')?$(this).data('toggleClass').split(','):null;

            var showHide = $(this).data('showHide')?$(this).data('showHide').split(','):null;

            if (objTarget && objClass) {
                for (var i = 0, l = objTarget.length; i < l; i++) {
                    $($(objTarget[i].trim())).toggleClass(objClass[i].trim());
                }
            }

            if(showHide){
                // show
                if( showHide[0] && $(showHide[0]).length ){
                    $(showHide[0].trim()).removeClass("hidden");
                }
                // hide
                if( showHide[1] && $(showHide[1]).length ){
                     $(showHide[1].trim()).addClass("hidden");
                }
            }
        });
    }

    if ($btnClosetToggleClass.length) {
        $btnClosetToggleClass.on('click', function(e) {
            e.preventDefault();
            $(this).closest($(this).data('object')).toggleClass($(this).data('closetToggleClass'));
        });
    }
    if ($btnClosetUpdateClass.length) {
        $btnClosetUpdateClass.on('click', function(e) {
            e.preventDefault();
            $(this).closest($(this).data('object')).attr('class', $(this).data('closetUpdateClass'));
        });
    }
});

jQuery(function() {
    'use strict';
    var $validateInput = $('[data-validate]');
    if ($validateInput.length) {
        $validateInput.on('change', function(e) {
            Site.isValidate($(this));
        });
    }
});