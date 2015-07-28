'use strict';

/**
 * @ngdoc function
 * @name kioskApp.controller:LoginCtrl
 * @description
 * # LoginCtrl
 * Controller of the kioskApp
 */
angular.module('kioskApp')
.controller('CardTypesCtrl', ['$scope', '$location', 'DataService', 'ConfigService', 'VisitorService', function ($scope, $location, DataService, ConfigService, VisitorService) {
	
	function getCardTypes() {
		var onSuccess = function(data, responseCode) {
			$scope.ctypeOptions = data;
		};
		var onFailure = function(data, responseCode) {
			$scope.error = data.errorDescription;
		};
		DataService.getCardType(onSuccess, onFailure);
	};
	
	$scope.goNext = function () {		
		VisitorService.cardType = $scope.ctypes;
		$location.path('host_search');
	};
	
	$scope.goBack = function () {		
		$location.path('visitor_email');
	};
		
	$scope.getImage = function () {		
		alert('Card Type Image has to integrate');
	};
	
	function updateStyles() {
		$scope.forwardButtonStyle = ConfigService.brandInfo.actionForwardButton;
		$scope.checkOutButtonStyle = ConfigService.brandInfo.neutralButton;
		$scope.imgSrc = ConfigService.brandInfo.companyLogoURL;
		$scope.tagLine = ConfigService.companyTagLine;
    }
	
	// Listen to a notification and update accordingly.
	$scope.$on('config:updated', updateStyles);
	
	getCardTypes();
	updateStyles();
}]);
