'use strict';

/**
 * @ngdoc function
 * @name kioskApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the kioskApp
 */
angular.module('kioskApp')
	.controller('MainCtrl', ['$scope', '$location', 'ConfigService', 'DataService', function ($scope, $location, ConfigService, DataService) {
	
    function updateStyles() {
		$scope.forwardButtonStyle = ConfigService.brandInfo.actionForwardButton;
		$scope.checkOutButtonStyle = ConfigService.brandInfo.neutralButton;
		$scope.imgSrc = ConfigService.brandInfo.companyLogoURL;
		$scope.tagLine = ConfigService.companyTagLine;
    }
		
	if(!!DataService.info[0] && DataService.info[0].kioskstat == 'new'){
		$scope.success = "Kiosk name registered successfully.";
		delete DataService.info[0];		
	}
	
    // due to the network lag, we listen to a notification and update accordingly.
    $scope.$on('config:updated', updateStyles);
    updateStyles();
}]);
