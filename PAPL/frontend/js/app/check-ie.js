/**
 * Created by phpvnn on 5/18/15.
 */
var checkIEBrowser = (!! window.ActiveXObject && +(/msie\s(\d+)/i.exec(navigator.userAgent)[1])) || NaN;
if (checkIEBrowser < 9) {
    document.documentElement.className += ' lt-ie9' + ' ie' + checkIEBrowser;
}
//console.log('checkIEBrowser',checkIEBrowser);