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
	'ngStorage',
    'angular-spinkit',
    'kiosk.VisitorService',
    'kiosk.CameraService',
    'kiosk.ConfigService',
    'kiosk.DataService',
    'kiosk.VisitService'
  ])
  .config(['$httpProvider', '$routeProvider', '$compileProvider', function ($httpProvider, $routeProvider, $compileProvider) {
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
	  .when('/card_types', {
        templateUrl: 'views/card_types.html',
        controller: 'CardTypesCtrl'
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
			//$rootScope.globals = $cookies.getObject('globals') || {};
			$rootScope.globals = $localStorage.globals || {};
			
            var aToken = $rootScope.globals.accessToken;
			var adminEmail = $rootScope.globals.adminEmail;
			
			if(aToken){
				DataService.authToken = aToken;
				DataService.adminEmail = adminEmail;
			}
			
			if(!!$localStorage.kioskInfo){
				DataService.kiosk = $localStorage.kioskInfo.kiosk;
				DataService.workstation = $localStorage.kioskInfo.workstation;
				DataService.ktoken = $localStorage.kioskInfo.ktoken;				
			}
						
            if (restrictedPage && !aToken) {/* If not Authorized, send back to login screen */
				
                $location.path('/');
				
            }else if(!restrictedPage && aToken){
				$http.defaults.headers.common['HTTP_X_VMS_TOKEN'] = aToken;
				
				if(!!$localStorage.kioskInfo.ktoken){/* Kiosk already registered */
					$location.path('/intro');
				}else{
					$location.path('/workstation');
				}								
			}
        });
    }]);
