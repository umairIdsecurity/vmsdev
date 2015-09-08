'use strict';

/**
 * @ngdoc function
 * @name avmsKioskApp.controller:LogonCtrl
 * @description
 * # LogonCtrl
 * Controller of the avmsKioskApp
 */
angular.module('avmsKioskApp')
  .controller('LogonCtrl', ['$scope', '$location', '$cookies', '$localStorage', 'DataService', 'VMSConfig', function ($scope, $location, $cookies, $localStorage, DataService, VMSConfig) {
		
	$scope.login = function () {
		$scope.dataLoading = true;
		
		var onSuccess = function(data, responseCode) {
			
			$scope.error = false;
			$scope.dataLoading = false;
			
			var avmsGlobals = {accessToken: data.access_token, adminEmail: $scope.email};			
			$cookies.putObject('avmsGlobals', avmsGlobals);
			
			/* Permanent Login */
			$localStorage.avmsGlobals = avmsGlobals;
			
			DataService.authToken = data.access_token;
			DataService.adminEmail = $scope.email;		
			
			$location.path('/workstation');
		};
		var onFailure = function(data, responseCode) {
			$scope.error = data.errorDescription;
			$scope.dataLoading = false;
		};
		
		DataService.authLogin($scope.email, $scope.password, onSuccess, onFailure);
	};
	
	if(!!DataService.info[0]){/* Display error message if token expired */
		$scope.error = DataService.info[0];
		delete DataService.info[0];
	}
}]);
