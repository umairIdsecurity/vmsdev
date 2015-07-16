'use strict';

/**
 * @ngdoc function
 * @name kioskApp.controller:LoginCtrl
 * @description
 * # LoginCtrl
 * Controller of the kioskApp
 */
angular.module('kioskApp')
.controller('WorkstationCtrl', ['$scope', '$location', 'DataService', 'ConfigService', 'VMSConfig', function ($scope, $location, DataService, ConfigService, VMSConfig) {
	
	function getWorkstation() {
		var onSuccess = function(data, responseCode) {
			$scope.facilities = data;
		};
		var onFailure = function(data, responseCode) {
			$scope.error = data.errorDescription;
		};
		DataService.getWorkstation(onSuccess, onFailure);
	};
	
	$scope.nextStep = function () {		
		$scope.dataLoading = true;
		DataService.kiosk = $scope.kiosk;
		DataService.workstation = $scope.workstations;
		
		var onSuccess = function(data, responseCode) {			
			$scope.dataLoading = false;
			$scope.error = false;
			$location.path('/intro');
		};
		var onFailure = function(data, responseCode) {
			$scope.error = data.errorDescription;
			$scope.dataLoading = false;
		};
		DataService.resgiterKiosk(onSuccess, onFailure);
	};
		
	function updateStyles() {
		$scope.forwardButtonStyle = ConfigService.brandInfo.actionForwardButton;
		$scope.checkOutButtonStyle = ConfigService.brandInfo.neutralButton;
		$scope.imgSrc = ConfigService.brandInfo.companyLogoURL;
		$scope.tagLine = ConfigService.companyTagLine;
    }
	$scope.$on('config:updated', updateStyles);
	
	getWorkstation();
	//updateStyles();
}]);
