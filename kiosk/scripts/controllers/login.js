'use strict';

/**
 * @ngdoc function
 * @name kioskApp.controller:LoginCtrl
 * @description
 * # LoginCtrl
 * Controller of the kioskApp
 */
angular.module('kioskApp')
.controller('LoginCtrl', ['$scope', '$location', '$cookies', '$localStorage', 'DataService', 'VMSConfig', function ($scope, $location, $cookies, $localStorage, DataService, VMSConfig) {
		
	$scope.login = function () {
		$scope.dataLoading = true;
		
		var onSuccess = function(data, responseCode) {
			
			$scope.error = false;
			$scope.dataLoading = false;
			
			var globals = {accessToken: data.access_token, adminEmail: $scope.email};			
			$cookies.putObject('globals', globals);
			
			/* Permanent Login */
			$localStorage.globals = globals;
			
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
	}
}]);
