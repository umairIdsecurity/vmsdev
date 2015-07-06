'use strict';

/**
 * @ngdoc function
 * @name kioskApp.controller:CheckOutCtrl
 * @description
 * Prompts the user for a VIC number, searches the API for Visits with that number,
 * and presents the results to the user. When the user selects a visit to checkout,
 * sends a request to the server to update the visit and its end time.
 */
angular.module('kioskApp')
  .controller('CheckOutCtrl', ['$scope', '$location', 'ConfigService', 'DataService', function ($scope, $location, ConfigService, DataService) {
    function updateStyles() {
      $scope.forwardButtonStyle = ConfigService.brandInfo.actionForwardButton;
      $scope.backButtonStyle = ConfigService.brandInfo.neutralButton;
    }

    $scope.hasError = false;

    $scope.searchVisits = function(q) {
      $scope.visit = null;
      console.log('searching visits matching: "'+ q + '"');
      DataService.searchVisits(q,
                               function(data, responseCode) {
                                 console.log('Success: ' + responseCode);
                                 $scope.visits = data;
                                 $scope.hasError = false;
                               },
                               function(data, responseCode) {
                                 console.log('Error: ' + responseCode + ' Scope: ' + $scope);
                                 if (responseCode != 404) {
                                   $scope.hasError = true;
                                 }
                               });
    };

    $scope.choose = function(v) {
      $scope.visit = v;
      console.log(v);
      DataService.checkOutVisit(v,
                               function(data, responseCode) {
                                 $location.path('drop_off');
                               },
                               function(data, responseCode) {
                                 $scope.hasError = true;
                               });
    };

    $scope.goBack = function() {
      $location.path('/');
    };

    $scope.visits = null;
    $scope.visit = null;
    updateStyles();
  }]);
