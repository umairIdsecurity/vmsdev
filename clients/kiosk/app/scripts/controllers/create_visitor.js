'use strict';

angular.module('kioskApp')
  .controller('CreateVisitorCtrl', ['$scope', 'VisitorService', '$location', 'DataService', 'ConfigService', function($scope, VisitorService, $location, DataService, ConfigService) {
    function updateStyles() {
      $scope.forwardButtonStyle = ConfigService.brandInfo.actionForwardButton;

      $scope.backButtonStyle = ConfigService.brandInfo.neutralButton;
    }

    $scope.hasError = false;

    $scope.goBack = function() {
      $location.path('visitor_email');
    };

    $scope.currentVisitor = VisitorService;
    $scope.createLogin = function() {
      VisitorService.firstName = $scope.currentVisitor.firstName;
      VisitorService.lastName  = $scope.currentVisitor.lastName;
      VisitorService.companyName = $scope.currentVisitor.companyName;
      VisitorService.email = $scope.currentVisitor.email;
      DataService.createVisitor(VisitorService,
                                function(data, responseCode) {
                                  VisitorService.visitorID = data.visitorID;
                                  VisitorService.companyID = data.companyID;
                                  console.log('Got visitor ID: ' + VisitorService.visitorID);
                                  $location.path('host_search');
                                  $scope.hasError = false;
                                },
                                function(data, responseCode) {
                                  console.log('Error creating new visitor: ' + data);
                                  $scope.hasError = true;
                                });
    };

    updateStyles();
  }]);
