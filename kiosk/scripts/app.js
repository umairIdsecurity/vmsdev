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
        templateUrl: 'views/login.html',
        controller: 'LoginCtrl'
      })
	  .when('/workstation', {
        templateUrl: 'views/workstation.html',
        controller: 'WorkstationCtrl'
      })
	  .when('/intro', {
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
	
  }])
  .run(['$rootScope', '$location', '$http', '$cookies', '$templateCache', function run($rootScope, $location, $http, $cookies, $templateCache) {
        /** keep user logged in after page refresh */
		$rootScope.globals = $cookies.get('globals') || {};       

        $rootScope.$on('$locationChangeStart', function (event, next, current) {
			if (typeof(current) !== 'undefined'){
				$templateCache.remove(current.templateUrl);
			}
			
            /** redirect to login page if not logged in and trying to access a restricted page */
            var restrictedPage = $.inArray($location.path(), ['/', '/register']) === -1;
            var loggedIn = $rootScope.globals.accessToken;
			
            if (restrictedPage && !loggedIn) {
                $location.path('/');
            }else if(!restrictedPage && loggedIn){
				$location.path('/workstation');
				$http.defaults.headers.common['Authorization'] = $rootScope.globals.accessToken;
			}
        });
    }]);
