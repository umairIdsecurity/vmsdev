'use strict';

angular.module('kioskApp')
	.controller('VisitorEmailCtrl', ['$scope', '$location', 'VisitorService', 'DataService', 'ConfigService', function ($scope, $location, VisitorService, DataService, ConfigService) {
    
	function updateStyles() {
      $scope.forwardButtonStyle = ConfigService.brandInfo.actionForwardButton;
      $scope.backButtonStyle = ConfigService.brandInfo.neutralButton;
    }

    $scope.hasError = false;

    $scope.email = null;
    $scope.$watch('visitor_email', function(newValue) {
		$scope.email = { text: newValue };
		VisitorService.email = $scope.email.text;
    });

    $scope.target = null;
    $scope.loadVisitorInfo = function() {
		var onSuccess = function(data, responseCode) {
			$scope.hasError = false;
			var visitorKeys = ['visitorID', 'firstName', 'lastName', 'email'];
			angular.forEach(visitorKeys, function(key) {
				VisitorService[key] = data[key];
			});
			
			/* If card type loaded */
			if(VisitorService.cardType  != null){ 
				$scope.target = 'host_search';
			}else{
				$scope.target = 'card_types';
			}
			
			$scope.navigateToNext();
		};
		var onFailure = function(data, responseCode) {
			if (responseCode == 404) {
				/* Delete previous visitor data if added */
				var visitorKeys = ['visitorID', 'firstName', 'lastName', 'companyName'];
				angular.forEach(visitorKeys, function(key) {
					delete VisitorService[key];
				});				
				
				$scope.target = 'create_visitor_profile';
				$scope.navigateToNext();
			}
			else {
			$scope.hasError = true;
			}
		};
		DataService.getVisitor(VisitorService.email, onSuccess, onFailure);
    };

    $scope.navigateToNext = function() {
		$location.path($scope.target);
    };

    $scope.goBack = function() {
		$location.path('compliance');
    };

    updateStyles();
}]);
