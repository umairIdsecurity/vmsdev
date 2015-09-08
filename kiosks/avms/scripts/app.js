'use strict';

/**
 * @ngdoc overview
 * @name avmsKioskApp
 * @description
 * # avmsKioskApp
 *
 * Main module of the application.
 */
angular
  .module('avmsKioskApp', [
    'avmsKioskApp.config',
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch',
    'ngStorage',
    'angular-spinkit',
    'mgcrea.ngStrap',
    'avmsKioskApp.VisitorService',
    'avmsKioskApp.CameraService',
    'avmsKioskApp.ConfigService',
    'avmsKioskApp.DataService',
    'avmsKioskApp.VisitService'
  ])
  .config(['$httpProvider', '$routeProvider', '$compileProvider', function ($httpProvider, $routeProvider, $compileProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/logon.html',
        controller: 'LogonCtrl'
      })
      .when('/intro', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .when('/preregistration', {
        templateUrl: 'views/preregistration.html',
        controller: 'PreregistrationCtrl'
      })
      .when('/scandriver', {
        templateUrl: 'views/scandriver.html',
        controller: 'ScandriverCtrl'
      })
      .when('/login', {
        templateUrl: 'views/login.html',
        controller: 'LoginCtrl'
      })
      .when('/confirmDetails', {
        templateUrl: 'views/confirmdetails.html',
        controller: 'ConfirmdetailsCtrl'
      })
      .when('/createAccount', {
        templateUrl: 'views/createaccount.html',
        controller: 'CreateaccountCtrl'
      })
      .when('/reason', {
        templateUrl: 'views/reason.html',
        controller: 'ReasonCtrl'
      })
      .when('/vicType', {
        templateUrl: 'views/victype.html',
        controller: 'VictypeCtrl'
      })
      .when('/workstation', {
        templateUrl: 'views/workstation.html',
        controller: 'WorkstationCtrl'
      })
      .when('/logVisit', {
        templateUrl: 'views/logvisit.html',
        controller: 'LogvisitCtrl'
      })
      .when('/asicSponsor', {
        templateUrl: 'views/asicsponsor.html',
        controller: 'AsicsponsorCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });

      $httpProvider.defaults.headers.common = {};
      $httpProvider.defaults.headers.post = {};
      $httpProvider.defaults.headers.get  = {};
      $httpProvider.defaults.headers.put  = {};
      $compileProvider.imgSrcSanitizationWhitelist(/^\s*(https?|local|data):/);
  }])
  .run(['$rootScope', '$location', '$http', '$cookies', '$localStorage', '$templateCache','DataService' , function run($rootScope, $location, $http, $cookies, $localStorage, $templateCache, DataService) {

      /** keep user logged in after page refresh */     
      $rootScope.$on('$locationChangeStart', function (event, next, current) {
        if (typeof(current) !== 'undefined'){
          $templateCache.remove(current.templateUrl);
        }
        
        /** redirect to login page if not logged in and trying to access a restricted page */     
        var restrictedPage = $.inArray($location.path(), ['/', '/register']) === -1;
        $rootScope.globals = $localStorage.avmsGlobals || {};
        
        var aToken = $rootScope.globals.accessToken;
        var adminEmail = $rootScope.globals.adminEmail;
        
        if(aToken){
          DataService.authToken = aToken;
          DataService.adminEmail = adminEmail;
        }
        
        if(!!$localStorage.avmsKioskInfo){
          DataService.kiosk = $localStorage.avmsKioskInfo.kiosk;
          DataService.workstation = $localStorage.avmsKioskInfo.workstation;
          DataService.ktoken = $localStorage.avmsKioskInfo.ktoken;        
        }
              
        if (restrictedPage && !aToken) {/* If not Authorized, send back to login screen */
          $location.path('/');
          
        }else if(!restrictedPage && aToken){
          $http.defaults.headers.common['HTTP_X_VMS_TOKEN'] = aToken;
          
          if(!!$localStorage.avmsKioskInfo.ktoken){/* Kiosk already registered */
            $location.path('/intro');
          }else{
            $location.path('/workstation');
          }               
        }
    });
  }]);
