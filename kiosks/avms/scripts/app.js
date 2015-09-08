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
    'angular-spinkit',
    'avmsKioskApp.VisitorService',
    'avmsKioskApp.CameraService',
    'avmsKioskApp.ConfigService',
    'avmsKioskApp.DataService',
    'avmsKioskApp.VisitService'
  ])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/', {
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
      .otherwise({
        redirectTo: '/'
      });
  });
