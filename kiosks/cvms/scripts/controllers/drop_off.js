'use strict';

/**
 * @ngdoc function
 * @name kioskApp.controller:DropOffCtrl
 * @description
 * # DropOffCtrl
 * Controller of the kioskApp
 */
angular.module('kioskApp')
  .controller('DropOffCtrl', ['$scope', 'ConfigService', 'VisitorService', '$location', function ($scope, ConfigService, VisitorService, $location) {
    $scope.dropOffLocation = ConfigService.pickupLocation;
    $scope.visitor = VisitorService;
    $scope.startOver = function() {
      $location.path('/');
    };
  }]);
