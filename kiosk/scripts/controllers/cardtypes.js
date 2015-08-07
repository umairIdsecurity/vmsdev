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
	
	/* Get the list of card types for that selected workstation */
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
	
	/* Get the selected card detail */
	// $scope.getCDetail = function () {		
	// 	VisitorService.cardType = $scope.ctypes;	
	// 	$scope.dataLoading = true;
	// 	var onSuccess = function(data, responseCode) {
	// 		$scope.cardImage = data.card_image;
	// 		$scope.dataLoading = false;
	// 	};
	// 	var onFailure = function(data, responseCode) {
	// 		$scope.error = data.errorDescription;
	// 		$scope.dataLoading = false;
	// 	};
	// 	DataService.getCardDetail(VisitorService, onSuccess, onFailure);
	// };

	$scope.getCDetail = function ($index) {
		$scope.selected_card = $scope.ctypeOptions[$index].id;
		VisitorService.cardType = $scope.ctypeOptions[$index].id;
		$scope.dataLoading = true;
		var onSuccess = function(data, responseCode) {
			$scope.cardImage = data.card_image;
			$scope.dataLoading = false;
		};
		var onFailure = function(data, responseCode) {
			$scope.error = data.errorDescription;
			$scope.dataLoading = false;
		};
		DataService.getCardDetail(VisitorService, onSuccess, onFailure);
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
