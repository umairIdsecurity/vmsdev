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
