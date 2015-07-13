'use strict';

/**
 * @ngdoc function
 * @name kioskApp.controller:LoginCtrl
 * @description
 * # LoginCtrl
 * Controller of the kioskApp
 */
angular.module('kioskApp')
.controller('LoginCtrl', ['$scope', '$rootScope', '$location', '$cookies', 'DataService', 'VMSConfig', function ($scope, $rootScope, $location, $cookies, DataService, VMSConfig) {
		
	$scope.login = function () {
		$scope.dataLoading = true;
		
		var onSuccess = function(data, responseCode) {
			$rootScope.globals = {accessToken: data.access_token, adminEmail: $scope.email};
			$cookies.put('globals', $rootScope.globals);
			
			DataService.authToken = data.access_token;
			DataService.adminEmail = $scope.email;
			DataService.kiosk = $scope.kiosk;
			$location.path('/workstation');
		};
		var onFailure = function(data, responseCode) {
			$scope.error = data.errorDescription;
		};
		
		DataService.authLogin($scope.email, $scope.password, onSuccess, onFailure);
	};
}]);
