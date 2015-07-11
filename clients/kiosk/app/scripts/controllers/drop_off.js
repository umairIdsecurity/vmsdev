'use strict';

/**
 * @ngdoc function
 * @name kioskApp.controller:DropOffCtrl
 * @description
 * # DropOffCtrl
 * Controller of the kioskApp
 */
angular.module('kioskApp')
  .controller('DropOffCtrl', ['$scope', 'ConfigService', '$location', function ($scope, ConfigService, $location) {
    $scope.dropOffLocation = ConfigService.pickupLocation;
    $scope.startOver = function() {
      $location.path('/');
    };
  }]);
