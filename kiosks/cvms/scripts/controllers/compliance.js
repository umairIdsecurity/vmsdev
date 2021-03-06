
'use strict';

/**
 * @ngdoc controller
 * @name kioskApp.controller:ComplianceCtrl
 * @description
 * Simply displays the compliance terms from the server and ensures the user agrees before proceeding.
 */
angular.module('kioskApp')
	.controller('ComplianceCtrl', ['$scope', '$location', 'VisitorService', 'ConfigService', function ($scope, $location, VisitorService, ConfigService) {
		function updateStyles() {
			
			$scope.forwardButtonStyle = ConfigService.brandInfo.actionForwardButton;
			$scope.backButtonStyle = ConfigService.brandInfo.neutralButton;			
		}

		function loadCompliance() {
			$scope.questions = ConfigService.complianceTerms;
			/*if ($scope.questions === null || $scope.questions.length === 0) {
				//$scope.changeView();
			}*/
		}		
		
		$scope.hasAgreed = false;
		$scope.goBack = function() {
			$location.path('/intro');
		};
		$scope.changeView = function() {
			$location.path('/visitor_email');
			VisitorService.termsAccepted = true;
		};
		/** Listen to a notification and update accordingly. */
		$scope.$on('config:updated', loadCompliance);
		
		updateStyles();
		loadCompliance();
}]);
