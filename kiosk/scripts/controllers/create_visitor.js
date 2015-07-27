'use strict';

angular.module('kioskApp')
  .controller('CreateVisitorCtrl', ['$scope', 'VisitorService', '$location', 'DataService', 'ConfigService', function($scope, VisitorService, $location, DataService, ConfigService) {
	  
    function updateStyles() {
		$scope.forwardButtonStyle = ConfigService.brandInfo.actionForwardButton;
		$scope.backButtonStyle = ConfigService.brandInfo.neutralButton;
    }

    $scope.hasError = false;
	
	/* Search company names */
	$scope.compOptions = [];
	$scope.compId = null;
		
	/* Choose company */	
	$scope.choose = function(company) {        
        $scope.currentVisitor.companyName = company.name;
		$scope.compId = company.id;
    };

    $scope.goBack = function() {
		$location.path('visitor_email');
    };

    $scope.currentVisitor = VisitorService;
    $scope.createLogin = function() {
		VisitorService.firstName = $scope.currentVisitor.firstName;
		VisitorService.lastName  = $scope.currentVisitor.lastName;
		VisitorService.companyName = $scope.compId;
		VisitorService.email = $scope.currentVisitor.email;
		DataService.createVisitor(VisitorService,
			function(data, responseCode) {
				$scope.hasError = false;
				
				VisitorService.visitorID = data.visitorID;
				VisitorService.companyID = data.companyID;
				console.log('Got visitor ID: ' + VisitorService.visitorID);
				
				if(data.CtypeCount > 1){
					$location.path('card_types');
				}else if(data.CtypeCount == 1){
					VisitorService.cardType = data.cid;
					$location.path('host_search');
				}else{
					alert('No Card-Type available for the selected workstation');// Need to address this case
				}				
				
			},
			function(data, responseCode) {
				console.log('Error creating new visitor: ' + data);
				$scope.error = data.errorDescription;
				$scope.hasError = true;				
			}
		);
    };
	
	$scope.performCompanySearch = function() {
		var comp = $scope.currentVisitor.companyName
		$scope.compOptions = [];
		if (comp.length > 3) {
			$scope.compId = null;
			DataService.searchComp(comp,  function(data, responseCode) {
				$scope.compOptions = data;
				var results = null;
				if(data.length > 5) {
					results = data.slice(0, 5);
				}
				else {
					results = data;
				}
				$scope.compOptions = results;
			},
			function(data, responseCode) {
				$scope.compOptions = [];
			});
		}
	};

    updateStyles();
}]);
