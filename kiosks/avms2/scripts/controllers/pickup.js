'use strict';

/**
 * @ngdoc function
 * @name avmsKioskApp.controller:PickupCtrl
 * @description
 * # PickupCtrl
 * Controller of the avmsKioskApp
 */
angular.module('avmsKioskApp')
  .controller('PickupCtrl', ['$scope', '$location', 'ConfigService', 'VisitorService', function ($scope, $location, ConfigService, VisitorService) {
    function updateStyles() {
		$scope.forwardButtonStyle = ConfigService.brandInfo.actionForwardButton;
		$scope.checkOutButtonStyle = ConfigService.brandInfo.neutralButton;
		$scope.imgSrc = ConfigService.brandInfo.companyLogoURL;
		$scope.tagLine = ConfigService.companyTagLine;
		$scope.pickupLocation = ConfigService.pickupLocation;
    }
	
    // due to the network lag, we listen to a notification and update accordingly.
    $scope.$on('config:updated', updateStyles);
    updateStyles();

  }]);
