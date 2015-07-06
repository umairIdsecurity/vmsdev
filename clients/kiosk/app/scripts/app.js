'use strict';

/**
 * @ngdoc overview
 * @name kioskApp
 * @description
 * Create the AngularJS app and set up all the routes.
 * Each screen in the app has a dedicated route and a dedicated controller.
 *
 * Main module of the application.
 */
angular
  .module('kioskApp', [
    'kiosk.config',
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch',
    'angular-spinkit',
    'kiosk.VisitorService',
    'kiosk.CameraService',
    'kiosk.ConfigService',
    'kiosk.DataService',
    'kiosk.VisitService'
  ])
  .config(['$httpProvider', '$routeProvider', function ($httpProvider, $routeProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/intro.html',
        controller: 'MainCtrl'
      })
      .when('/compliance', {
        templateUrl: 'views/compliance.html',
        controller: 'ComplianceCtrl'
      })
      .when('/visitor_email', {
        templateUrl: 'views/visitor_email.html',
        controller: 'VisitorEmailCtrl'
      })
      .when('/create_visitor_profile', {
        templateUrl: 'views/create_visitor_profile.html',
        controller: 'CreateVisitorCtrl'
      })
      .when('/host_search', {
        templateUrl: 'views/host_search.html',
        controller: 'HostSearchCtrl'
      })
      .when('/photo_capture', {
        templateUrl: 'views/photo_capture.html',
        controller: 'PhotoCaptureCtrl'
      })
      .when('/pickup_notice', {
        templateUrl: 'views/pickup_notice.html',
        controller: 'PickupNoticeCtrl'
      })
      .when('/check_out', {
        templateUrl: 'views/check_out.html',
        controller: 'CheckOutCtrl'
      })
      .when('/drop_off', {
        templateUrl: 'views/drop_off.html',
        controller: 'DropOffCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });
    $httpProvider.defaults.headers.common = {};
    $httpProvider.defaults.headers.post = {};
    $httpProvider.defaults.headers.get  = {};
    $httpProvider.defaults.headers.put  = {};
  }]);
