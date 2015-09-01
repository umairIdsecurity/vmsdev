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
      .otherwise({
        redirectTo: '/'
      });
  });
