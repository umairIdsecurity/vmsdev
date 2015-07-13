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
	
	$scope.getCTypes = function () {
		$scope.wloading = true;
		DataService.workstation = $scope.workstations;
		
		var onSuccess = function(data, responseCode) {
			$scope.wloading = false;
			$scope.cardtypes = data;
		};
		var onFailure = function(data, responseCode) {
			$scope.error = data.errorDescription;
		};		
		DataService.getCardType(onSuccess, onFailure);
	};
	
	$scope.nextStep = function () {
		
		$scope.dataLoading = true;
		
		DataService.cardType = $scope.cardtype;
		alert("Selectd Work station:"+DataService.workstation);
		alert("Selectd Card Type:"+DataService.cardType);
		
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
